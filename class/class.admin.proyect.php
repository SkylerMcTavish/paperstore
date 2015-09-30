<?php
if (!class_exists('Proyect')){
	require_once 'class.proyect.php';
}
/**
* AdminProyect CLass
* 
* @package		SF Tracker			
* @since        18/05/2014 
* 
*/ 
class AdminProyect extends Proyect{
	
	/**
	* AdminProyect()    
	* Creates a User object from the DB.
	*  
	* @param 		$id_proyect (optional) If set populates values from DB record. 
	*/  
	function AdminProyect( $id_proyect = 0 ){
		global $Session;  
		$this->class = 'AdminProyect';
		if ( !$Session->is_admin() ){
			$this->set_error('Restricted Access', SES_RESTRICTED_ACCESS, 3);
			throw new Exception("Restricted access.", 1);
		}
		parent::__construct( $id_proyect );
		$this->class = 'AdminProyect';
	}
	
	/**
	* save()    
	* Inserts or Updates the record in the DB. 
	* 
	*/  
	public function save(){
		global $Session;
		if ( $Session->is_admin() ){ 
			if ( $this->validate() ){
				global $obj_bd;
				
				$values = array(
								':id_proyect_type'	=> $this->id_proyect_type,
								':id_company'		=> $this->id_company,
								':id_region'		=> $this->id_region,
								':pr_proyect'		=> $this->proyect,
								':pr_shift_start'	=> $this->shift_start,
								':pr_shift_end'		=> $this->shift_end,
								':pr_workdays'		=> implode(";",$this->workdays),
								':pr_day_visits'	=> $this->day_visits,
								':pr_timestamp'		=> time()
							);
				
				if ( $this->id_proyect > 0 ){
					$values[':id_proyect'] = $this->id_proyect;
					$query = " UPDATE " . PFX_MAIN_DB . "proyect SET " 
								. " pr_prt_id_proyect_type = :id_proyect_type, "
								. " pr_cm_id_company= :id_company, "
								. " pr_re_id_region = :id_region,  " 
								. " pr_proyect 	 	= :pr_proyect, "
								. " pr_shift_start  = :pr_shift_start, "
								. " pr_shift_end	= :pr_shift_end, " 
								. " pr_workdays		= :pr_workdays,  " 
								. " pr_day_visits	= :pr_day_visits, " 
								. " pr_status	 	= 1, "
								. " pr_timestamp 	= :pr_timestamp  "
							. " WHERE id_proyect = :id_proyect ";
				} else {
					$query = "INSERT INTO " . PFX_MAIN_DB . "proyect " 
							. " ( pr_prt_id_proyect_type, pr_cm_id_company, pr_re_id_region, pr_proyect, pr_shift_start, pr_shift_end, pr_workdays, pr_day_visits, pr_status, pr_timestamp ) "
							. " VALUES ( :id_proyect_type, :id_company, :id_region, :pr_proyect, :pr_shift_start, :pr_shift_end, :pr_workdays, :pr_day_visits, 1, :pr_timestamp ) ";
				} 
				$result = $obj_bd->execute( $query, $values );
				if ( $result !== FALSE ){
					if ( $this->id_proyect == 0){
						$this->id_proyect = $obj_bd->get_last_id(); 
						$this->set_msg('SAVE', " Proyect " . $this->id_proyect. " saved. ");
						return $this->create_entities(); 
					} else {
						$this->set_msg('UPDATE', " Proyect " . $this->id_proyect. " saved. ");
						return TRUE;
					}
				} else {
					$this->set_error( "An error ocurred while trying to save the record. " . print_r($obj_bd->get_error()), ERR_DB_EXEC, 3 );
					return FALSE;
				} 
			} else {
				return FALSE;
			}
		} else {
			$this->set_error("Restricted action.", SES_RESTRICTED_ACTION);
			return FALSE;
		}
	} 
	
	
	/******** Cycles ********/
	/**
	* save_cycle()    
	* Inserts a cycle record for the proyect in the DB. 
	* 
	* @param	stdClass Cycle ( 'from' & 'to' values)
	*/  
	public function save_cycle( $cycle ){
		global $Session;
		if ( $Session->is_proyect_admin() ){
			if ( $this->validate_cycle( $cycle ) ){
				global $obj_bd;
				$query = "INSERT INTO " . PFX_PRY_DB . "cycle ( cy_from, cy_to ) VALUES (  :cy_from, :cy_to ) ";
				 
				$values = array( ':cy_from' => $cycle->from, ":cy_to" => $cycle->to ); 
				$resp = $obj_bd->execute($query, $values);
				if ( $resp ){
					$this->set_cycles();
					return TRUE;
				} else { 
					$this->set_error("Could not save Cycle." , ERR_DB_EXEC);
					return FALSE;
				}
			} else {
				return FALSE;
			}
		} else {
			$this->set_error("Restricted action.", SES_RESTRICTED_ACTION);
			return FALSE;
		}
	}
	
	/**
	* delete_cycle()    
	* Deletes a proyect's cycle record from the DB. 
	* 
	* @param	stdClass Cycle ( 'from' & 'to' values)
	*/
	public function delete_cycle( $cycle ){
		global $Session;
		if ( $Session->is_proyect_admin() ){
			if ( $this->validate_cycle( $cycle ) ){
				global $obj_bd;
				$query = "DELETE FROM " . PFX_PRY_DB . "cycle WHERE cy_from = :cy_from AND cy_to = :cy_to  "; 
				$values = array( ':cy_from' => $cycle->from, ":cy_to" => $cycle->to ); 
				$resp = $obj_bd->execute($query, $values);
				if ( $resp ){
					$this->set_cycles();
					return TRUE;
				} else { 
					$this->set_error("Could not delete Cycle." , ERR_DB_EXEC);
					return FALSE;
				}
			} else {
				return FALSE;
			}
		} else {
			$this->set_error("Restricted action.", SES_RESTRICTED_ACTION);
			return FALSE;
		}
	}
	
	
	
	/******** Media Files ********/
	/**
	* save_media()    
	* Inserts a media_file record for the proyect in the DB. 
	* 
	* @param	stdClass Media File  
	*/  
	public function save_media( $media ){
		global $Session;
		if ( $Session->is_proyect_admin() ){
			if ( $this->validate_media( $media ) ){
				require_once "class.file.manager.php";
				$fmanager = new FileManager();
				$target = DIRECTORY_UPLOADS . "pr" . ID_PRY . "_mf_" . date( 'YmdHis' ); 
				$info = $fmanager->save_uploaded($media->file, $target);
				if ( $info ){	
					global $obj_bd;
					$query = "INSERT INTO " . PFX_PRY_DB . "media_file " 
								. " ( mf_ft_id_file_type, mf_mt_id_media_type, mf_title, mf_name, mf_description, mf_route, mf_status, mf_timestamp ) " 
								. " VALUES ( :id_file_type, :id_media_type, :title, :name, :description, :route, 1, :timestamp ) "; 
					$values = array( 
								':id_file_type' => $info->id_file_type, 
								':id_media_type'=> $media->id_media_type,
								':title'		=> $media->title,
								':name'			=> $media->file['name'], 
								':description'	=> $media->description,
								':route'		=> $target, 
								':timestamp'	=> time(), 
							);
					$resp = $obj_bd->execute($query, $values);
					if ( $resp ){ 
						$this->set_media();
						return TRUE;
					} else { 
						$this->set_error("Could not save Media File. " . $obj_bd->get_error(), ERR_DB_EXEC);
						return FALSE;
					}
				} else {
					$this->error[] = $fmanager->error[ count($fmanager->error)-1 ];
				}
			} else {
				return FALSE;
			}
		} else {
			$this->set_error("Restricted action.", SES_RESTRICTED_ACTION);
			return FALSE;
		}
	}
	
	/**
	* delete_media()    
	* Deletes a proyect's media record from the DB. 
	* 
	* @param	Integer $id_media
	*/
	public function delete_media( $id_media ){
		global $Session;
		if ( $Session->is_proyect_admin() ){ 
			global $obj_bd;
			$query = "UPDATE " . PFX_PRY_DB . "media_file SET mf_status = 0 WHERE id_media_file = :id_media  "; 
			$values = array( ':id_media' => $id_media ); 
			$resp = $obj_bd->execute($query, $values);
			if ( $resp ){
				$this->set_media();
				return TRUE;
			} else { 
				$this->set_error("Could not delete Media File." , ERR_DB_EXEC);
				return FALSE;
			} 
		} else {
			$this->set_error("Restricted action.", SES_RESTRICTED_ACTION);
			return FALSE;
		}
	}
	 
	
	/**
	 * Database Functions
	 */
	private function create_entities(){
		global $Session;
		if ( $Session->is_admin() ){
			if ( $this->id_proyect > 0 ){
				global $obj_bd;
				$pfx = PFX_MAIN_DB . "pr" . $this->id_proyect . "_";
				$queries['cycle'] = " CREATE TABLE IF NOT EXISTS " . $pfx . "cycle ( cy_from int(11) NOT NULL, cy_to int(11) NOT NULL, PRIMARY KEY (cy_from,cy_to) );";
				
				$queries['free_day'] = " CREATE TABLE IF NOT EXISTS " . $pfx . "free_day ( id_free_day int(11) NOT NULL AUTO_INCREMENT, fd_date_string varchar(45) DEFAULT NULL, fd_date_timestamp int(11) NOT NULL, PRIMARY KEY (id_free_day) );";
				 
				$queries['media_file'] = " CREATE TABLE IF NOT EXISTS " . $pfx . "media_file ( "
							. " id_media_file int(11) NOT NULL AUTO_INCREMENT, "
							. " mf_ft_id_file_type int(11) NOT NULL, "
							. " mf_mt_id_media_type int(11) NOT NULL, "
							. " mf_title varchar(64) NOT NULL, "
							. " mf_name varchar(64) DEFAULT NULL, "
							. " mf_description text, "
							. " mf_route varchar(64) NOT NULL, "
							. " mf_status int(11) NOT NULL DEFAULT '1', "
							. " mf_timestamp int(11) NOT NULL DEFAULT '0', "
							. " PRIMARY KEY (id_media_file), "
							. " KEY " . $pfx . "mf_ft_id_file_type_idx (mf_ft_id_file_type), "
							. " KEY " . $pfx . "mt_id_media_type_idx (mf_mt_id_media_type), "
							. " CONSTRAINT " . $pfx . "mf_ft_id_file_type FOREIGN KEY (mf_ft_id_file_type) REFERENCES " . PFX_MAIN_DB . "file_type (id_file_type) ON DELETE NO ACTION ON UPDATE NO ACTION, "
							. " CONSTRAINT " . $pfx . "mf_mt_id_media_type FOREIGN KEY (mf_mt_id_media_type) REFERENCES " . PFX_MAIN_DB . "media_type (id_media_type) ON DELETE NO ACTION ON UPDATE NO ACTION "
						. " ) DEFAULT CHARSET=utf8;"; 
				
				$queries['visit'] = " CREATE TABLE IF NOT EXISTS " . $pfx . "visit ( " 
									. " id_visit int(11) NOT NULL AUTO_INCREMENT, " 
									. " vi_pdv_id_pdv int(11) NOT NULL, " 
									. " vi_us_id_user int(11) NOT NULL, " 
									. " vi_vs_id_visit_status int(11) NOT NULL DEFAULT '1', " 
									. " vi_scheduled_start int(11) NOT NULL DEFAULT '0', " 
									. " vi_scheduled_end int(11) NOT NULL DEFAULT '0', " 
									. " vi_real_start int(11) DEFAULT NULL, " 
									. " vi_real_end int(11) DEFAULT NULL, " 
									. " vi_latitude decimal(23,20) DEFAULT NULL, " 
									. " vi_longitude decimal(23,20) DEFAULT NULL, " 
									. " vi_vrc_id_reschedule_cause int(11) DEFAULT NULL, " 
									. " vi_status int(11) NOT NULL DEFAULT '1', " 
									. " vi_timestamp varchar(45) NOT NULL DEFAULT '0', " 
								. " PRIMARY KEY (id_visit), " 
								. " KEY " . $pfx . "vi_us_id_user_idx (vi_us_id_user), " 
								. " KEY " . $pfx . "vi_vrc_id_reschedule_cause_idx (vi_vrc_id_reschedule_cause), " 
								. " KEY " . $pfx . "vi_pdv_id_pdv_idx (vi_pdv_id_pdv), " 
								. " KEY " . $pfx . "vi_vs_id_visit_status_idx (vi_vs_id_visit_status), " 
								. " CONSTRAINT " . $pfx . "vi_vs_id_visit_status FOREIGN KEY (vi_vs_id_visit_status) REFERENCES " . PFX_MAIN_DB . "visit_status (id_visit_status) ON DELETE NO ACTION ON UPDATE NO ACTION, " 
								. " CONSTRAINT " . $pfx . "vi_pdv_id_pdv FOREIGN KEY (vi_pdv_id_pdv) REFERENCES " . PFX_MAIN_DB . "pdv (id_pdv) ON DELETE NO ACTION ON UPDATE NO ACTION, " 
								. " CONSTRAINT " . $pfx . "vi_us_id_user FOREIGN KEY (vi_us_id_user) REFERENCES " . PFX_MAIN_DB . "user (id_user) ON DELETE NO ACTION ON UPDATE NO ACTION, " 
								. " CONSTRAINT " . $pfx . "vi_vrc_id_reschedule_cause FOREIGN KEY (vi_vrc_id_reschedule_cause) "
											. " REFERENCES " . PFX_MAIN_DB . "visit_reschedule_cause (id_visit_reschedule_cause) ON DELETE SET NULL ON UPDATE NO ACTION " 
							. " ) DEFAULT CHARSET=utf8 " ;
							
				$queries['visit_file_time'] =  " CREATE TABLE IF NOT EXISTS " . $pfx . "visit_file_time ( " 
									. " id_visit_file_time 		int(11) NOT NULL AUTO_INCREMENT, " 
									. " vft_mf_id_media_file 	int(11) NOT NULL, " 
									. " vft_vi_id_visit 		int(11) NOT NULL, " 
									. " vft_time 				int(11) DEFAULT NULL, " 
									. " vft_times 				int(11) DEFAULT NULL, " 
								. " PRIMARY KEY (id_visit_file_time), " 
								. " KEY " . $pfx . "vft_vi_id_visit_idx 		(vft_vi_id_visit), " 
								. " KEY " . $pfx . "vft_mf_id_media_file_idx 	(vft_mf_id_media_file), " 
								. " CONSTRAINT " . $pfx . "vft_mf_id_media_file FOREIGN KEY (vft_mf_id_media_file) REFERENCES " . $pfx . "media_file (id_media_file) ON DELETE NO ACTION ON UPDATE NO ACTION, " 
								. " CONSTRAINT " . $pfx . "vft_vi_id_visit 		FOREIGN KEY (vft_vi_id_visit) REFERENCES " . $pfx . "visit (id_visit) ON DELETE CASCADE ON UPDATE NO ACTION
								) DEFAULT CHARSET=utf8 "; 
								
				$queries['visit_price'] =  " CREATE TABLE IF NOT EXISTS " . $pfx . "visit_price ( " 
									. " vp_vi_id_visit 		int(11) NOT NULL, " 
									. " vp_pd_id_product 	int(11) NOT NULL, " 
									. " vp_price 		decimal(10,2) DEFAULT NULL, " 
									. " vp_retail 		decimal(10,2) DEFAULT NULL, " 
									. " vp_rival 		decimal(10,2) DEFAULT NULL, " 
								. " PRIMARY KEY (vp_vi_id_visit, vp_pd_id_product), " 
								. " KEY " . $pfx . "vp_vi_id_visit_idx (vp_vi_id_visit), " 
								. " KEY " . $pfx . "vp_pd_id_product_idx (vp_pd_id_product), " 
								. " CONSTRAINT " . $pfx . "vp_pd_id_product FOREIGN KEY (vp_pd_id_product) REFERENCES " . PFX_MAIN_DB . "product (id_product) ON DELETE NO ACTION ON UPDATE NO ACTION, " 
								. " CONSTRAINT " . $pfx . "vp_vi_id_visit FOREIGN KEY (vp_vi_id_visit) REFERENCES " . $pfx . "visit (id_visit) ON DELETE CASCADE ON UPDATE NO ACTION " 
							. " ) DEFAULT CHARSET=utf8 ";
							
				$queries['visit_stock'] = " CREATE TABLE IF NOT EXISTS " . $pfx . "visit_stock ( " 
									. " vsk_vi_id_visit 	int(11) NOT NULL, " 
									. " vsk_pd_id_product 	int(11) NOT NULL, " 
									. " vsk_front 			int(11) DEFAULT NULL, " 
									. " vsk_depth 			int(11) DEFAULT NULL, " 
									. " vsk_total 			int(11) DEFAULT NULL, " 
									. " vsk_warehouse 		int(11) DEFAULT NULL, " 
									. " vsk_exhibition 		int(11) DEFAULT NULL, " 
								. " PRIMARY KEY (vsk_vi_id_visit,vsk_pd_id_product), " 
								. " KEY " . $pfx . "vsk_vi_id_visit_idx (vsk_vi_id_visit), " 
								. " KEY " . $pfx . "vsk_pd_id_product_idx (vsk_pd_id_product), " 
								. " CONSTRAINT " . $pfx . "vsk_pd_id_product FOREIGN KEY (vsk_pd_id_product) REFERENCES " . PFX_MAIN_DB . "product (id_product) ON DELETE NO ACTION ON UPDATE NO ACTION, " 
								. " CONSTRAINT " . $pfx . "vsk_vi_id_visit FOREIGN KEY (vsk_vi_id_visit) REFERENCES " . $pfx . "visit (id_visit) ON DELETE NO ACTION ON UPDATE NO ACTION " 
							. " ) DEFAULT CHARSET=utf8 ";
							
				$queries['visit_supervision'] = " CREATE TABLE IF NOT EXISTS " . $pfx . "visit_supervision ( " 
									. " id_visit_supervision 	int(11) NOT NULL AUTO_INCREMENT, " 
									. " vsu_vi_id_visit 		int(11) NOT NULL, " 
									. " vsu_us_id_user 			int(11) NOT NULL, " 
									. " vsu_comment 			text, " 
									. " vsu_supervision_status 	int(11) DEFAULT '0', " 
									. " vsu_status 				int(11) NOT NULL DEFAULT '1', " 
									. " vsu_timestamp 			int(11) NOT NULL DEFAULT '0', " 
								. " PRIMARY KEY (id_visit_supervision), " 
								. " KEY " . $pfx . "vsu_vi_id_visit_idx (vsu_vi_id_visit), " 
								. " KEY " . $pfx . "vsu_us_id_user_idx (vsu_us_id_user), " 
								. " CONSTRAINT " . $pfx . "vsu_us_id_user  FOREIGN KEY (vsu_us_id_user)  REFERENCES " . PFX_MAIN_DB . "user (id_user) ON DELETE NO ACTION ON UPDATE NO ACTION, " 
								. " CONSTRAINT " . $pfx . "vsu_vi_id_visit FOREIGN KEY (vsu_vi_id_visit) REFERENCES " . $pfx		. "visit (id_visit) ON DELETE CASCADE ON UPDATE NO ACTION " 
							. " ) DEFAULT CHARSET=utf8 ";
							
				$queries['task'] = " CREATE TABLE IF NOT EXISTS " . $pfx . "task ( " 
									. " id_task int(11) NOT NULL AUTO_INCREMENT, " 
									. " tk_vi_id_visit int(11) NOT NULL, " 
									. " tk_tt_id_task_type int(11) NOT NULL, " 
									. " tk_time int(11) DEFAULT NULL, " 
									. " tk_toc_id_task_omition_cause int(11) DEFAULT NULL, " 
								. " PRIMARY KEY (id_task), " 
								. " KEY " . $pfx . "tk_vi_id_visit_idx (tk_vi_id_visit), " 
								. " KEY " . $pfx . "tk_tt_id_task_type_idx (tk_tt_id_task_type), " 
								. " KEY " . $pfx . "tk_toc_id_task_omition_cause_idx (tk_toc_id_task_omition_cause), " 
								. " CONSTRAINT " . $pfx . "tk_toc_id_task_omition_cause FOREIGN KEY (tk_toc_id_task_omition_cause) REFERENCES " . PFX_MAIN_DB . "task_omition_cause (id_task_omition_cause) ON DELETE SET NULL ON UPDATE NO ACTION, " 
								. " CONSTRAINT " . $pfx . "tk_tt_id_task_type FOREIGN KEY (tk_tt_id_task_type) 	REFERENCES " . PFX_MAIN_DB . "task_type (id_task_type) ON DELETE NO ACTION ON UPDATE NO ACTION, " 
								. " CONSTRAINT " . $pfx . "tk_vi_id_visit FOREIGN KEY (tk_vi_id_visit) 			REFERENCES " . $pfx . "visit (id_visit) ON DELETE CASCADE ON UPDATE NO ACTION " 
							. " ) DEFAULT CHARSET=utf8 ";
				
				$queries['evidence'] = " CREATE TABLE IF NOT EXISTS " . $pfx . "evidence ( " 
									. " id_evidence 	int(11) NOT NULL AUTO_INCREMENT, " 
									. " ev_vi_id_visit 	int(11) NOT NULL, " 
									. " ev_et_id_evidence_type int(11) NOT NULL, " 
									. " ev_text 		text, " 
									. " ev_route 		varchar(64) NOT NULL, " 
									. " ev_timestamp 	int(11) NOT NULL DEFAULT '1', " 
								. " PRIMARY KEY (id_evidence), " 
								. " KEY " . $pfx . "ev_et_id_evidence_type_idx (ev_et_id_evidence_type), "
								. " KEY " . $pfx . "ev_vi_id_visit_idx (ev_vi_id_visit), "
								. " CONSTRAINT " . $pfx . "ev_vi_id_visit FOREIGN KEY (ev_vi_id_visit) REFERENCES " . $pfx . "visit (id_visit) ON DELETE CASCADE ON UPDATE NO ACTION, " 
								. " CONSTRAINT " . $pfx . "ev_et_id_evidence_type FOREIGN KEY (ev_et_id_evidence_type) REFERENCES " . PFX_MAIN_DB . "evidence_type (id_evidence_type) ON DELETE NO ACTION ON UPDATE NO ACTION "
							. " ) DEFAULT CHARSET=utf8;";
				
				$queries['order'] = " CREATE TABLE IF NOT EXISTS " . $pfx . "order ( " 
									. " id_order int(11) NOT NULL AUTO_INCREMENT, " 
									. " or_pdv_id_pdv int(11) DEFAULT NULL, " 
									. " or_us_id_user int(11) DEFAULT NULL, " 
									. " or_date int(11) NOT NULL, " 
									. " or_su_id_supplier int(11) NOT NULL, " 
									. " or_ba_id_branch int(11) DEFAULT NULL, " 
									. " or_vi_id_visit int(11) DEFAULT NULL, " 
									. " or_client_code varchar(64) DEFAULT NULL, " 
									. " or_agent_number varchar(64) DEFAULT NULL, " 
									. " or_confirmation_code varchar(64) DEFAULT NULL, " 
									. " or_status int(11) DEFAULT '1', " 
									. " or_timestamp int(11) DEFAULT '0', " 
								. " PRIMARY KEY (id_order), "
								. " KEY " . $pfx . "or_pdv_id_pdv_idx 	(or_pdv_id_pdv), " 
								. " KEY " . $pfx . "or_us_id_user_idx 	(or_us_id_user), "
								. " KEY " . $pfx . "or_su_id_supplier_idx (or_su_id_supplier), "
								. " KEY " . $pfx . "or_ba_id_branch_idx (or_ba_id_branch), " 
								. " CONSTRAINT " . $pfx . "or_ba_id_branch 	 FOREIGN KEY (or_ba_id_branch) REFERENCES " . PFX_MAIN_DB . "branch (id_branch) ON DELETE NO ACTION ON UPDATE NO ACTION, " 
								. " CONSTRAINT " . $pfx . "or_pdv_id_pdv 	 FOREIGN KEY (or_pdv_id_pdv) REFERENCES " . PFX_MAIN_DB . "pdv (id_pdv) ON DELETE SET NULL ON UPDATE NO ACTION, " 
								. " CONSTRAINT " . $pfx . "or_su_id_supplier FOREIGN KEY (or_su_id_supplier) REFERENCES " . PFX_MAIN_DB . "supplier (id_supplier) ON DELETE NO ACTION ON UPDATE NO ACTION, " 
								. " CONSTRAINT " . $pfx . "or_us_id_user 	 FOREIGN KEY (or_us_id_user) 	REFERENCES "  . PFX_MAIN_DB . "user (id_user) ON DELETE SET NULL ON UPDATE NO ACTION " 
							. " ) DEFAULT CHARSET=utf8 ";
								
				$queries['order_detail'] = " CREATE TABLE IF NOT EXISTS " . $pfx . "order_detail ( " 
									. " id_order_detail int(11) NOT NULL AUTO_INCREMENT, " 
									. " od_or_id_order int(11) NOT NULL, " 
									. " od_pd_id_product int(11) NOT NULL, " 
									. " od_pp_id_product_presentation int(11) NOT NULL DEFAULT '1', " 
									. " od_quantity int(11) DEFAULT NULL, " 
									. " od_price decimal(10,2) DEFAULT NULL, " 
								. " PRIMARY KEY (id_order_detail), " 
								. " KEY " . $pfx . "od_or_id_order_idx (od_or_id_order), " 
								. " KEY " . $pfx . "od_pd_id_product_idx (od_pd_id_product), " 
								. " KEY " . $pfx . "od_pp_id_product_presentation_idx (od_pp_id_product_presentation), " 
								. " CONSTRAINT " . $pfx . "od_or_id_order FOREIGN KEY (od_or_id_order) REFERENCES " . $pfx . "order (id_order) ON DELETE NO ACTION ON UPDATE NO ACTION, " 
								. " CONSTRAINT " . $pfx . "od_pd_id_product FOREIGN KEY (od_pd_id_product) REFERENCES " . PFX_MAIN_DB . "product (id_product) ON DELETE NO ACTION ON UPDATE NO ACTION, " 
								. " CONSTRAINT " . $pfx . "od_pp_id_product_presentation FOREIGN KEY (od_pp_id_product_presentation) " 
										. " REFERENCES " . PFX_MAIN_DB . "product_presentation (id_product_presentation) ON DELETE NO ACTION ON UPDATE NO ACTION " 
							. " ) DEFAULT CHARSET=utf8 ";
				
				$queries['form_type'] = " CREATE TABLE IF NOT EXISTS " . $pfx . "form_type (" 
									. " id_form_type int(11) NOT NULL AUTO_INCREMENT," 
									. " fmt_form_type varchar(45) NOT NULL," 
									. " fmt_status int(11) NOT NULL DEFAULT '1'," 
									. " fmt_timestamp int(11) NOT NULL," 
								. " PRIMARY KEY (id_form_type) "  
							. " ) DEFAULT CHARSET=utf8 ";
							
				$queries['form'] = " CREATE TABLE IF NOT EXISTS " . $pfx . "form ( " 
									. " id_form int(11) NOT NULL AUTO_INCREMENT, " 
									. " frm_fmt_id_form_type int(11) DEFAULT NULL, " 
									. " frm_title varchar(64) DEFAULT NULL, " 
									. " frm_description text, " 
									. " frm_status int(11) NOT NULL DEFAULT '1', " 
									. " frm_timestamp int(11) NOT NULL, " 
								. " PRIMARY KEY (id_form), " 
								. " KEY " . $pfx . "frm_fmt_id_form_type_idx (frm_fmt_id_form_type), "  
								. " CONSTRAINT " . $pfx . "frm_fmt_id_form_type FOREIGN KEY (frm_fmt_id_form_type) REFERENCES " . $pfx . "form_type (id_form_type) ON DELETE NO ACTION ON UPDATE NO ACTION "
							. " ) DEFAULT CHARSET=utf8 ";
							
				$queries['form_section'] = " CREATE TABLE IF NOT EXISTS " . $pfx . "form_section ( " 
									. " id_form_section int(11) NOT NULL AUTO_INCREMENT, " 
									. " fms_frm_id_form int(11) NOT NULL, " 
									. " fms_title varchar(64) DEFAULT NULL, " 
									. " fms_description text, " 
									. " fms_status int(11) NOT NULL DEFAULT '1', " 
									. " fms_timestamp int(11) NOT NULL, " 
								. " PRIMARY KEY (id_form_section), "
								. " KEY " . $pfx . "fms_frm_id_form_idx (fms_frm_id_form), "
								. " CONSTRAINT " . $pfx . "fms_frm_id_form FOREIGN KEY (fms_frm_id_form) REFERENCES " . $pfx . "form (id_form) ON DELETE NO ACTION ON UPDATE NO ACTION "
							  . " ) DEFAULT CHARSET=utf8 ";

				$queries['form_result'] = "CREATE TABLE IF NOT EXISTS " . $pfx . "form_result ( " 
									. " id_form_result int(11) NOT NULL AUTO_INCREMENT, " 
									. " fmr_frm_id_form int(11) NOT NULL, " 
									. " fmr_us_id_user int(11) NOT NULL, " 
									. " fmr_date int(11) NOT NULL, " 
									. " fmr_comments text, " 
									. " fmr_status int(11) NOT NULL DEFAULT '1', " 
									. " fmr_timestamp int(11) NOT NULL, " 
								. " PRIMARY KEY (id_form_result), " 
								. " KEY " . $pfx . "fmr_us_id_user_idx (fmr_us_id_user), " 
								. " KEY " . $pfx . "fmr_frm_id_form_idx (fmr_frm_id_form), " 
								. " CONSTRAINT " . $pfx . "fmr_us_id_user FOREIGN KEY (fmr_us_id_user) REFERENCES " . PFX_MAIN_DB . "user (id_user) ON DELETE NO ACTION ON UPDATE NO ACTION, " 
								. " CONSTRAINT " . $pfx . "fmr_frm_id_form FOREIGN KEY (fmr_frm_id_form) REFERENCES " . $pfx . "form (id_form) ON DELETE NO ACTION ON UPDATE NO ACTION "
							. " ) DEFAULT CHARSET=utf8 ";

				$queries['question'] = " CREATE TABLE IF NOT EXISTS " . $pfx . "question ( "
									. " id_question int(11) NOT NULL AUTO_INCREMENT, "
  									. " qs_fms_id_form_section int(11) NOT NULL, "
									. " qs_qt_id_question_type int(11) NOT NULL, "
									. " qs_order int(11) NOT NULL, "
									. " qs_question text, "
									. " qs_correct text, "
									. " qs_options text, "
									. " qs_weight decimal(7,4) DEFAULT NULL, "
									. " qs_status int(11) NOT NULL DEFAULT '1', "
									. " qs_timestamp int(11) NOT NULL, "
								. " PRIMARY KEY (id_question), "
								. " KEY " . $pfx . "qs_qt_id_question_type_idx (qs_qt_id_question_type), "
								. " CONSTRAINT " . $pfx . "qs_fms_id_form_section FOREIGN KEY (qs_fms_id_form_section) REFERENCES " . $pfx . "form_section (id_form_section) ON DELETE NO ACTION ON UPDATE NO ACTION, "
								. " CONSTRAINT " . $pfx . "qs_qt_id_question_type FOREIGN KEY (qs_qt_id_question_type) REFERENCES " . PFX_MAIN_DB . "question_type (id_question_type) ON DELETE NO ACTION ON UPDATE NO ACTION "
							. " ) DEFAULT CHARSET=utf8 ";
							
				$queries['answer'] = " CREATE TABLE IF NOT EXISTS " . $pfx . "answer ( "
									. " id_answer int(11) NOT NULL AUTO_INCREMENT, "
									. " an_fmr_id_form_result int(11) NOT NULL, "
									. " an_qs_id_question int(11) NOT NULL, "
									. " an_answer text NOT NULL, "
								. " PRIMARY KEY (id_answer), "
								. " KEY " . $pfx . "an_fmr_id_form_result_idx (an_fmr_id_form_result), "
								. " KEY " . $pfx . "an_qs_id_question_idx (an_qs_id_question), "
								. " CONSTRAINT " . $pfx . "an_fmr_id_form_result FOREIGN KEY (an_fmr_id_form_result) REFERENCES " . $pfx . "form_result (id_form_result) ON DELETE NO ACTION ON UPDATE NO ACTION, "
								. " CONSTRAINT " . $pfx . "an_qs_id_question 	 FOREIGN KEY (an_qs_id_question) 	 REFERENCES " . $pfx . "question (id_question) ON DELETE NO ACTION ON UPDATE NO ACTION "
							. " ) DEFAULT CHARSET=utf8 "; 
				
				$queries['user_supervisor'] = " CREATE  TABLE IF NOT EXISTS " . $pfx . "user_supervisor ( "
									. " usu_us_id_user INT NOT NULL , "
									. " usu_us_id_parent INT NOT NULL , "
								. " PRIMARY KEY (usu_us_id_user, usu_us_id_parent) , "
								. " INDEX " . $pfx . "usu_us_id_parent_idx (usu_us_id_parent ASC) , "
								. " INDEX " . $pfx . "usu_us_id_user_idx (usu_us_id_user ASC) , "
								. " CONSTRAINT " . $pfx . "usu_us_id_user FOREIGN KEY (usu_us_id_user ) 	REFERENCES " . PFX_MAIN_DB . "user (id_user ) ON DELETE NO ACTION ON UPDATE CASCADE, "
								. " CONSTRAINT " . $pfx . "usu_us_id_parent FOREIGN KEY (usu_us_id_parent ) REFERENCES " . PFX_MAIN_DB . "user (id_user ) ON DELETE CASCADE ON UPDATE NO ACTION ); ";
				
				$response = TRUE;
				foreach ($queries as $key => $query) {
					$resp = $obj_bd->execute($query); 
					if ( !$resp ){
						$err = $obj_bd->get_error();
						$this->set_error(" An error occured while creating Proyect " . $this->id_proyect . " table " . $key . ": " . $err, ERR_DB_EXEC, 3);
						$response = $response && $resp; 
					} else {
						$this->set_msg( "CREATE",  " Proyect  " . $this->id_proyect . " table " . $key . " created succesfully. ");
					}
				} 
				return $response;
			}
		} 
		else return FALSE;
	}
	 

	/**
	* validate()    
	* Validates the values before inputing to Data Base 
	*  
	* @return		Boolean TRUE if valid; FALSE if invalid
	*/ 
	public function validate(){ 
		global $Validate; 
		if ( !$this->proyect != '' ){
			$this->set_error( 'Proyect value empty. ', ERR_VAL_EMPTY );
			return FALSE;
		} 
		if ( !$this->id_proyect_type > 0 || !$Validate->exists( 'proyect_type', 'id_proyect_type', $this->id_proyect_type)){
			$this->set_error( 'Invalid proyect type. ', ERR_VAL_EMPTY );
			return FALSE;
		}
		if ( !$this->id_company > 0 || !$Validate->exists( 'company', 'id_company', $this->id_company)){
			$this->set_error( 'Invalid company. ', ERR_VAL_EMPTY );
			return FALSE;
		}
		if ( !$this->id_region > 0 || !$Validate->exists( 'region', 'id_region', $this->id_region)){
			$this->set_error( 'Invalid region. ', ERR_VAL_EMPTY );
			return FALSE;
		}
		if ( ! $Validate->is_int_between($this->shift_start, 0, 23) ){
			$this->set_error( 'Invalid Shift start. ', ERR_VAL_INVALID );
			return FALSE;
		}
		if ( ! $Validate->is_int_between($this->shift_end, 0, 23) ){
			$this->set_error( 'Invalid Shift end. ', ERR_VAL_INVALID );
			return FALSE;
		}
		if ( ! $Validate->is_int_between($this->day_visits, 1, 16) ){
			$this->set_error( 'Invalid day visits. ', ERR_VAL_INVALID );
			return FALSE;
		}
		if ( !count($this->workdays) > 0 ){
			$this->set_error( 'Invalid workdays. ', ERR_VAL_INVALID );
			return FALSE;
		}
		return TRUE; 
	}

	/**
	 * validate_cycle() 
	* Validates the values before inputing to Data Base 
	*  
	* @return		Boolean TRUE if valid; FALSE if invalid
	*/ 
	public function validate_cycle( $cycle ){ 
		global $Validate; 
		if ( !($cycle->from > 0) ){
			$this->set_error( 'Invalid From value. ', ERR_VAL_INVALID );
			return FALSE;
		} 
		if ( !($cycle->to > 0) ){
			$this->set_error( 'Invalid To value. ', ERR_VAL_INVALID );
			return FALSE;
		}
		if ( !($cycle->from < $cycle->to) ){
			$this->set_error( 'Invalid Range values. ', ERR_VAL_INVALID );
			return FALSE;
		}
		return TRUE;
	} 
	 
	/**
	 * validate_media() 
	* Validates the values before inputing to Data Base 
	*  
	* @return		Boolean TRUE if valid; FALSE if invalid
	*/ 
	public function validate_media( $media ){ 
		global $Validate; 
		if ( !($media->title != '') ){
			$this->set_error( 'Title value empty. ', ERR_VAL_EMPTY );
			return FALSE;
		} 
		if ( !($media->id_media_type > 0) ){
			$this->set_error( 'Invalid Media Type value. ', ERR_VAL_INVALID );
			return FALSE;
		} 
		if (  !($media->file['tmp_name'] != '')  ){
			$this->set_error( 'No file uploaded. ', ERR_VAL_EMPTY );
			return FALSE;
		} 
		return TRUE;
	} 
	
	
	/**
	* delete()    
	* Changes status from User to 0 in the DB.. 
	*
	* @return 	TRUE on success; FALSE otherwise 
	*/  
	public function delete(){
		global $Session;
		if ( $Session->is_admin() ){
			global $obj_bd;
			$query = " UPDATE "  . PFX_MAIN_DB . "proyect SET "
						. " pr_status = 0 "
					. " WHERE id_proyect = " . $this->id_proyect . " ";
			$result = $obj_bd->execute( $query );
			if ( $result !== FALSE ){
				$this->set_msg('DELETE', " Proyect " . $this->id_proyect. " deleted. ");
				$this->clean();
				return TRUE;
			} else {
				$this->set_error( "An error ocurred while trying to set status to 0. ", ERR_DB_EXEC, 3 );
				return FALSE;
			} 
		}
	}
	   
	/**
	* clean()    
	* Cleans all parameters and resets all objects
	*  
	*/  
	public function clean(){
		$this->id_proyect 	=  0;
		$this->proyect 		= "";
		
		$this->id_company 	=  0;
		$this->company 		= "";
		$this->id_region 	=  0;
		$this->region 		= "";
		$this->id_proyect_type 	=  0;
		$this->proyect_type = "";
		
		$this->shift_start 	= 0;
		$this->shift_end 	= 0; 
		$this->workdays		= array(); 
		$this->day_visits	= 0;
		
		$this->timestamp 	= 0;
		 
		$this->error = array(); 
	}
}

?>