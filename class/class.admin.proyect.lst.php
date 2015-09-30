<?php

/**
 * AdminProyectList
 */
class AdminProyectList extends DataTable {
	 
	function __construct( $which = '', $table_id = '' ) {
		$this->class = 'AdminProyectList';
		if ( $which != '' ) {
			global $Session;
			$this->which = $which; 
			parent::__construct( $which, $table_id ); 
			$this->id_proyect = $Session->get_proyect();
			
			$this->set_query();
			$this->set_template(); 
		} else {
			$this->clean();
			$this->error[] = "Listado inválido.";
		} 
	}
	
	public function set_list( $which, $table_id = '' ){ 
		$this->which = $which;
		if ( $table_id != '')
			$this->table_id = $table_id;
		else 
			$this->table_id = $which ;
		$this->set_query();
		$this->set_template();
	}
	
	private function set_query(){
		switch ( $this->which ){ 
			case 'lst_pry_cycle':
				$this->query = " SELECT  cy_from, cy_to FROM " . PFX_PRY_DB . "cycle " ;
				$this->sidx = ( $this->sidx != 'id') ? $this->sidx : 'cy_from';
				break;
				
			case 'lst_pry_form':
				$this->query = "SELECT " 
						. " id_form, id_form_type, fmt_form_type, frm_title, frm_description " 
					. " FROM " . PFX_PRY_DB . "form " 
						. " INNER JOIN  " . PFX_PRY_DB . "form_type ON id_form_type = frm_fmt_id_form_type " 
					. " WHERE fmt_status = 1  ";  
				$this->sidx = ( $this->sidx != 'id' ) ? $this->sidx : 'id_form'; 
				break;
				
			case 'lst_pry_form_type':
				$this->query = "SELECT id_form_type, fmt_form_type, fmt_status, fmt_timestamp FROM " . PFX_PRY_DB . "form_type WHERE fmt_status > 0  ";  
				$this->sidx = ( $this->sidx != 'id' ) ? $this->sidx : 'id_form_type'; 			
				break;
				
				 
			case 'lst_pry_media':
				$this->query = "SELECT " 
						. " id_media_file, id_media_type, id_file_type, mt_media_type, ft_file_type, ft_icon, mf_name, mf_title, mf_description, mf_route " 
					. " FROM " . PFX_PRY_DB . "media_file " 
						. " INNER JOIN  " . PFX_MAIN_DB . "file_type ON id_file_type = mf_ft_id_file_type "
						. " INNER JOIN  " . PFX_MAIN_DB . "media_type ON id_media_type = mf_mt_id_media_type "
					. " WHERE mf_status > 0  ";  
				$this->sidx = ( $this->sidx != 'id' ) ? $this->sidx : 'id_media_file'; 
				break;
				 
			case 'lst_pry_user_asignation':
				$this->query = " SELECT * FROM (  SELECT "
								. " id_user , us_user, us_zone, pf_profile, id_profile, CONCAT( co_lastname, ' ', co_name ) as name, "
								. " pu_us_id_user IS NOT NULL as asigned " 
							. " FROM " . PFX_MAIN_DB . "user u "
								. " INNER JOIN " . PFX_MAIN_DB . "profile p ON id_profile = us_pf_id_profile  "
								. "  LEFT JOIN " . PFX_MAIN_DB . "contact c ON co_us_id_user = id_user  "
								. "  LEFT JOIN " . PFX_MAIN_DB . "proyect_user ON pu_us_id_user = id_user AND pu_pr_id_proyect = ".ID_PRY. " "
							. " WHERE us_status = 1 AND id_profile > 1 GROUP BY id_user ) as tbl WHERE id_user > 0 ";
				$this->group = " GROUP BY id_user "; 
				$this->sidx = ( $this->sidx != 'id' ) ? $this->sidx : 'id_user'; 
				break;
			case 'lst_pry_user_activation':
				$this->query = 	" SELECT id_user , us_user, us_zone, pf_profile, id_profile, CONCAT( co_lastname, ' ', co_name ) as name, "
								. " pu_active as active " 
								. " FROM " . PFX_MAIN_DB . "proyect_user "
								. " INNER JOIN " . PFX_MAIN_DB . "user ON id_user = pu_us_id_user "
								. " INNER JOIN " . PFX_MAIN_DB . "profile p ON id_profile = us_pf_id_profile  "
								. " LEFT JOIN " . PFX_MAIN_DB . "contact c ON co_us_id_user = id_user  "
							. " WHERE us_status = 1 AND id_profile > 1 AND pu_pr_id_proyect = ".ID_PRY." ";
				$this->sidx = ( $this->sidx != 'id' ) ? $this->sidx : 'id_user';
				break;
			case 'lst_pry_user':
				$this->query = " SELECT * FROM (  SELECT "
								. " id_user , us_user, us_zone, pf_profile, id_profile, CONCAT( co_lastname, ' ', co_name ) as name, co_sex, us_lastlogin " 
							. " FROM " . PFX_MAIN_DB . "user u "
								. " INNER JOIN " . PFX_MAIN_DB . "proyect_user ON pu_us_id_user = id_user AND pu_pr_id_proyect = ".ID_PRY. " "
								. " INNER JOIN " . PFX_MAIN_DB . "profile p ON id_profile = us_pf_id_profile  "
								. "  LEFT JOIN " . PFX_MAIN_DB . "contact c ON co_us_id_user = id_user  "
							. " WHERE us_status = 1 AND id_profile > 1 GROUP BY id_user ) as tbl WHERE id_user > 0 ";
				$this->group = " GROUP BY id_user "; 
				$this->sidx = ( $this->sidx != 'id' ) ? $this->sidx : 'id_user';
				break;
				
			case 'lst_pry_product':
				$this->query = 	" SELECT id_product, pd_rival, ba_brand, fa_family, pd_sku, pd_product ".
								" FROM " . PFX_MAIN_DB . "product ".
								" INNER JOIN " . PFX_MAIN_DB . "proyect_product ON ppo_po_id_product = id_product AND ppo_pr_id_proyect =  ".ID_PRY. " ".
								" INNER JOIN " . PFX_MAIN_DB . "family on pd_fa_id_family = id_family ".
								" INNER JOIN " . PFX_MAIN_DB . "brand on fa_ba_id_brand = id_brand ".
								" WHERE pd_status > 0 ";
				$this->group = " GROUP BY id_product "; 
				$this->sidx = ( $this->sidx != 'id' ) ? $this->sidx : 'id_product';
			break;
			
			case 'lst_pry_product_asignation':
				$this->query = 	" SELECT id_product, pd_rival, ba_brand, fa_family, pd_sku, pd_product, ppo_po_id_product IS NOT NULL as asigned ".
								" FROM " . PFX_MAIN_DB . "product ".
								" LEFT JOIN  " . PFX_MAIN_DB . "proyect_product ON ppo_po_id_product = id_product AND ppo_pr_id_proyect = ".ID_PRY. " ".
								" INNER JOIN " . PFX_MAIN_DB . "family on pd_fa_id_family = id_family ".
								" INNER JOIN " . PFX_MAIN_DB . "brand on fa_ba_id_brand = id_brand ".
								" WHERE pd_status > 0 ";
				$this->group = " GROUP BY id_product "; 
				$this->sidx = ( $this->sidx != 'id' ) ? $this->sidx : 'id_product';
			break;
			
			case 'lst_pry_product_activation':
				$this->query = 	" SELECT id_product, pd_rival, ba_brand, fa_family, pd_sku, pd_product, ppo_active as active ".
								" FROM " . PFX_MAIN_DB . "proyect_product ".
								" INNER JOIN " . PFX_MAIN_DB . "product ON ppo_po_id_product = id_product ".
								" INNER JOIN " . PFX_MAIN_DB . "family on pd_fa_id_family = id_family ".
								" INNER JOIN " . PFX_MAIN_DB . "brand on fa_ba_id_brand = id_brand ".
								" WHERE pd_status > 0 AND ppo_pr_id_proyect = ".ID_PRY. " ";
				
				$this->group = " GROUP BY id_product "; 
				$this->sidx = ( $this->sidx != 'id' ) ? $this->sidx : 'id_product';
			break;
			
			case 'lst_pry_pdv':
				$this->query = 	" SELECT id_pdv, pvt_pdv_type, pdv_name, pdv_zone, ch_channel, gr_group, fo_format, id_channel, id_group ".
								" FROM " . PFX_MAIN_DB . "pdv ".
								" INNER JOIN " . PFX_MAIN_DB . "proyect_pdv ON ppv_pdv_id_pdv = id_pdv AND ppv_pr_id_proyect = ".ID_PRY. " ".
								" INNER JOIN " . PFX_MAIN_DB . "pdv_type ON id_pdv_type = pdv_pvt_id_pdv_type ".
								" INNER JOIN " . PFX_MAIN_DB . "format ON id_format = pdv_fo_id_format ".
								" INNER JOIN " . PFX_MAIN_DB . "group ON id_group = fo_gr_id_group ".
								" INNER JOIN " . PFX_MAIN_DB . "channel ON id_channel = gr_ch_id_channel ".
								" WHERE pdv_status = 1 ";
				$this->group = " GROUP BY id_pdv "; 
				$this->sidx = ( $this->sidx != 'id' ) ? $this->sidx : 'id_pdv';
			break;
			case 'lst_dpdv':
				$this->query = 	" SELECT id_pdv, pvt_pdv_type, pdv_name, pdv_zone, ch_channel, gr_group, fo_format, id_channel, id_group, pdv_latitude, pdv_longitude ".
								" FROM " . PFX_MAIN_DB . "pdv ".
								" LEFT JOIN " . PFX_MAIN_DB . "proyect_pdv ON ppv_pdv_id_pdv = id_pdv AND ppv_pr_id_proyect = ".ID_PRY. " ".
								" LEFT JOIN " . PFX_MAIN_DB . "pdv_type ON id_pdv_type = pdv_pvt_id_pdv_type ".
								" LEFT JOIN " . PFX_MAIN_DB . "format ON id_format = pdv_fo_id_format ".
								" LEFT JOIN " . PFX_MAIN_DB . "group ON id_group = fo_gr_id_group ".
								" LEFT JOIN " . PFX_MAIN_DB . "channel ON id_channel = gr_ch_id_channel ".
								" WHERE pdv_status = 1 ";
				$this->group = " GROUP BY id_pdv "; 
				$this->sidx = ( $this->sidx != 'id' ) ? $this->sidx : 'id_pdv';
			break;
			
			case 'lst_pry_pdv_asignation':
				$this->query = 	" SELECT id_pdv, pvt_pdv_type, pdv_name, pdv_zone, ch_channel, gr_group, fo_format, ".
								" id_channel, id_group, ppv_pdv_id_pdv IS NOT NULL as asigned ".
								" FROM " . PFX_MAIN_DB . "pdv ".
								" LEFT JOIN " . PFX_MAIN_DB . "proyect_pdv ON ppv_pdv_id_pdv = id_pdv AND ppv_pr_id_proyect = ".ID_PRY. " ".
								" INNER JOIN " . PFX_MAIN_DB . "pdv_type ON id_pdv_type = pdv_pvt_id_pdv_type ".
								" INNER JOIN " . PFX_MAIN_DB . "format ON id_format = pdv_fo_id_format ".
								" INNER JOIN " . PFX_MAIN_DB . "group ON id_group = fo_gr_id_group ".
								" INNER JOIN " . PFX_MAIN_DB . "channel ON id_channel = gr_ch_id_channel ".
								" WHERE pdv_status = 1 ";
				$this->group = " GROUP BY id_pdv "; 
				$this->sidx = ( $this->sidx != 'id' ) ? $this->sidx : 'id_pdv';
			break;
			
			case 'lst_pry_pdv_activation':
				$this->query = 	" SELECT id_pdv, pvt_pdv_type, pdv_name, pdv_zone, ch_channel, gr_group, fo_format, ".
								" id_channel, ppv_active as active ".
								" FROM " . PFX_MAIN_DB . "proyect_pdv ".
								" INNER JOIN " . PFX_MAIN_DB . "pdv ON ppv_pdv_id_pdv = id_pdv ".
								" INNER JOIN " . PFX_MAIN_DB . "pdv_type ON id_pdv_type = pdv_pvt_id_pdv_type ".
								" INNER JOIN " . PFX_MAIN_DB . "format ON id_format = pdv_fo_id_format ".
								" INNER JOIN " . PFX_MAIN_DB . "group ON id_group = fo_gr_id_group ".
								" INNER JOIN " . PFX_MAIN_DB . "channel ON id_channel = gr_ch_id_channel ".
								" WHERE pdv_status = 1 AND ppv_pr_id_proyect = ".ID_PRY. " ";
				$this->group = " GROUP BY id_pdv "; 
				$this->sidx = ( $this->sidx != 'id' ) ? $this->sidx : 'id_pdv';
			break;
			
			case 'lst_pry_evidence_type':
				$this->query = 	" SELECT id_evidence_type, et_evidence_type, pet_et_id_evidence_type ".
								" FROM " . PFX_MAIN_DB . "evidence_type ".
								" INNER JOIN " . PFX_MAIN_DB . "proyect_evidence_type ON id_evidence_type = pet_et_id_evidence_type ".
								" AND pet_pr_id_proyect = ".ID_PRY. " ".
								" WHERE et_status > 0";
				$this->group = " GROUP BY id_evidence_type "; 
				$this->sidx = ( $this->sidx != 'id' ) ? $this->sidx : 'id_evidence_type';
			break;
			
			case 'lst_pry_evidence_type_asignation':
				$this->query = 	" SELECT id_evidence_type, et_evidence_type, pet_et_id_evidence_type, pet_pr_id_proyect IS NOT NULL as asigned ".
								" FROM " . PFX_MAIN_DB . "evidence_type ".
								" LEFT JOIN " . PFX_MAIN_DB . "proyect_evidence_type ON id_evidence_type = pet_et_id_evidence_type ".
								" AND pet_pr_id_proyect = ".ID_PRY. " ".
								" WHERE et_status > 0";
				$this->group = " GROUP BY id_evidence_type "; 
				$this->sidx = ( $this->sidx != 'id' ) ? $this->sidx : 'id_evidence_type';
			break;
			
			case 'lst_pry_task_omition':
				$this->query = 	" SELECT id_task_omition_cause, IFNULL( tt_task_type, 'Default' )  as parent, toc_task_omition_cause ".
								" FROM " . PFX_MAIN_DB . "task_omition_cause ".
								" LEFT JOIN " . PFX_MAIN_DB . "task_type ON id_task_type = toc_tt_id_task_type ".
								" INNER JOIN " . PFX_MAIN_DB . "proyect_omition_cause ON poc_toc_id_task_omition_cause = id_task_omition_cause ".
								" AND poc_pr_id_proyect = ".ID_PRY. " ".
								" WHERE toc_status > 0";
				$this->group = " GROUP BY id_task_omition_cause "; 
				$this->sidx = ( $this->sidx != 'id' ) ? $this->sidx : 'id_task_omition_cause';
			break;
			
			case 'lst_pry_task_omition_asignation':
				$this->query = 	" SELECT id_task_omition_cause, IFNULL( tt_task_type, 'Default' )  as parent, toc_task_omition_cause, ".
								" poc_toc_id_task_omition_cause IS NOT NULL as asigned ".
								" FROM " . PFX_MAIN_DB . "task_omition_cause ".
								" LEFT JOIN " . PFX_MAIN_DB . "task_type ON id_task_type = toc_tt_id_task_type ".
								" LEFT JOIN " . PFX_MAIN_DB . "proyect_omition_cause ON poc_toc_id_task_omition_cause = id_task_omition_cause ".
								" AND poc_pr_id_proyect = ".ID_PRY. " ".
								" WHERE toc_status > 0";
				$this->group = " GROUP BY id_task_omition_cause "; 
				$this->sidx = ( $this->sidx != 'id' ) ? $this->sidx : 'id_task_omition_cause';
			break;
			
			case 'lst_pry_visit':		
				$this->query = " SELECT "
								. " id_visit, id_pdv, id_user, id_visit_status, vi_scheduled_start, vi_scheduled_end, "
								. " IFNULL(vi_real_start,0) as vi_real_start, IFNULL(vi_real_end,0) as vi_real_end, "
								. " pdv_name, us_user, vs_visit_status, vi_latitude, vi_longitude "
							. " FROM " . PFX_PRY_DB . "visit "
								. " INNER JOIN " . PFX_MAIN_DB . "visit_status ON id_visit_status = vi_vs_id_visit_status "
								. " INNER JOIN " . PFX_MAIN_DB . "user ON id_user = vi_us_id_user "
								. " INNER JOIN " . PFX_MAIN_DB . "pdv ON id_pdv = vi_pdv_id_pdv "
							. " WHERE vi_status = 1 AND id_user=".$_GET['user']; 
				$this->sidx = ( $this->sidx != 'id') ? $this->sidx : 'id_visit';
				break;
				
			case 'lst_pry_visit_omition':
				$this->query = 	" SELECT id_visit_reschedule_cause, vrc_visit_reschedule_cause ".
								" FROM " . PFX_MAIN_DB . "visit_reschedule_cause ".
								" INNER JOIN " . PFX_MAIN_DB . "proyect_reschedule_cause ON prc_vrc_id_visit_reschedule_cause = id_visit_reschedule_cause ".
								" AND prc_pr_id_proyect = ".ID_PRY. " ".
								" WHERE vrc_status > 0 ";
				$this->group = " GROUP BY id_visit_reschedule_cause "; 
				$this->sidx = ( $this->sidx != 'id' ) ? $this->sidx : 'id_visit_reschedule_cause';
			break;
			
			case 'lst_pry_visit_omition_asignation':
				$this->query = 	" SELECT id_visit_reschedule_cause, vrc_visit_reschedule_cause, prc_vrc_id_visit_reschedule_cause IS NOT NULL as asigned ".
								" FROM " . PFX_MAIN_DB . "visit_reschedule_cause ".
								" LEFT JOIN " . PFX_MAIN_DB . "proyect_reschedule_cause ON prc_vrc_id_visit_reschedule_cause = id_visit_reschedule_cause ".
								" AND prc_pr_id_proyect = ".ID_PRY. " ".
								" WHERE vrc_status > 0 ";
				$this->group = " GROUP BY id_visit_reschedule_cause "; 
				$this->sidx = ( $this->sidx != 'id' ) ? $this->sidx : 'id_visit_reschedule_cause';
			break;
			
			case 'lst_pry_supplier':
				$this->query = 	" SELECT id_supplier, su_supplier ".
								" FROM " . PFX_MAIN_DB . "supplier ".
								" INNER JOIN " . PFX_MAIN_DB . "proyect_supplier ON id_supplier = psu_su_id_supplier ".
								" AND psu_pr_id_proyect = ".ID_PRY. " ".
								" WHERE su_status > 0";
				$this->group = " GROUP BY id_supplier "; 
				$this->sidx = ( $this->sidx != 'id' ) ? $this->sidx : 'id_supplier';
			break;
			
			case 'lst_pry_supplier_asignation':
				$this->query = 	" SELECT id_supplier, su_supplier, psu_pr_id_proyect IS NOT NULL as asigned ".
								" FROM " . PFX_MAIN_DB . "supplier ".
								" LEFT JOIN " . PFX_MAIN_DB . "proyect_supplier ON id_supplier = psu_su_id_supplier ".
								" AND psu_pr_id_proyect = ".ID_PRY. " ".
								" WHERE su_status > 0";
				$this->group = " GROUP BY id_supplier "; 
				$this->sidx = ( $this->sidx != 'id' ) ? $this->sidx : 'id_supplier';
			break;
			
			case 'lst_pry_free_day':	
				$this->query = 	" SELECT id_free_day, fd_date_string, fd_date_timestamp".
								" FROM " . PFX_PRY_DB . "free_day";			
				$this->group = " GROUP BY id_free_day"; 
				$this->sidx = ( $this->sidx != 'id' ) ? $this->sidx : 'id_free_day';
			break;
		}
		$this->sort = " ORDER BY " . $this->sidx . " " . $this->sord . " ";
	}
	
	private function set_template() {
		switch ( $this->which ){ 
			case 'lst_pry_cycle':
				$this->title = " Cíclos del proyecto ";
				$this->columns = array(
					array( 'idx' => 'cy_from',		'lbl' => 'Desde',		'sortable' => TRUE, 	'searchable' => TRUE  	),
					array( 'idx' => 'cy_to',		'lbl' => 'Hasta',		'sortable' => TRUE, 	'searchable' => TRUE 	),    
					array( 'idx' => 'actions',		'lbl' => 'Acciones', 	'sortable' => FALSE, 	'searchable' => FALSE, 'width' => '120px'	)
				); 
				$this->template = DIRECTORY_VIEWS . "/lists/lst.pry.cycle.php"; 
				break;  
			case 'lst_pry_form':
				$this->title = " Formularios del proyecto ";
				$this->columns = array(
					array( 'idx' => 'id_form',		'lbl' => 'ID', 			'sortable' => TRUE, 	'searchable' => TRUE , 'width' => '50px' 	),
					array( 'idx' => 'fmt_form_type','lbl' => 'Tipo',		'sortable' => TRUE, 	'searchable' => TRUE 	), 
					array( 'idx' => 'frm_title',	'lbl' => 'Título', 		'sortable' => TRUE, 	'searchable' => TRUE , 'width' => '50%'  ),  
					array( 'idx' => 'actions',	 	'lbl' => 'Acciones', 	'sortable' => FALSE, 	'searchable' => FALSE  )
				);
				$this->template = DIRECTORY_VIEWS . "/lists/lst.pry.form.php"; 
				break;
			case 'lst_pry_form_type':
				$this->title = " Materiales del proyecto ";
				$this->columns = array(
					array( 'idx' => 'id_form_type',	'lbl' => 'ID', 			'sortable' => TRUE, 	'searchable' => TRUE , 'width' => '50px' 	),
					array( 'idx' => 'fmt_form_type','lbl' => 'Tipo',		'sortable' => TRUE, 	'searchable' => TRUE ,	), 
					array( 'idx' => 'actions',	 	'lbl' => 'Acciones', 	'sortable' => FALSE, 	'searchable' => FALSE,  'width' => '90px')
				);
				$this->template = DIRECTORY_VIEWS . "/lists/lst.pry.form.type.php"; 
				break;
			case 'lst_pry_media':
				$this->title = " Materiales del proyecto ";
				$this->columns = array(
					array( 'idx' => 'id_media_file','lbl' => 'ID', 			'sortable' => TRUE, 	'searchable' => TRUE , 'width' => '50px' 	),
					array( 'idx' => 'ft_file_type',	'lbl' => 'Tipo',		'sortable' => TRUE, 	'searchable' => TRUE , 'width' => '50px'	),
					array( 'idx' => 'mt_media_type','lbl' => 'Material', 	'sortable' => TRUE, 	'searchable' => TRUE   ),
					array( 'idx' => 'mf_title',		'lbl' => 'Título', 		'sortable' => TRUE, 	'searchable' => TRUE , 'width' => '50%'  ),  
					array( 'idx' => 'actions',	 	'lbl' => 'Acciones', 	'sortable' => FALSE, 	'searchable' => FALSE  )
				);
				$this->template = DIRECTORY_VIEWS . "/lists/lst.pry.media_file.php"; 
				break;
			case 'lst_pry_user':
			case 'lst_pry_user_asignation':
			case 'lst_pry_user_activation':
				$this->title = " Usuarios del proyecto ";
				$this->columns = array(
					array( 'idx' => 'id_user', 		'lbl' => 'ID', 			'sortable' => TRUE, 	'searchable' => TRUE  	),
					array( 'idx' => 'us_zone', 		'lbl' => 'Ruta',		'sortable' => TRUE, 	'searchable' => TRUE, 'width' => '50px' 	),
					array( 'idx' => 'us_user',	 	'lbl' => 'Usuario', 	'sortable' => TRUE, 	'searchable' => TRUE  	),
					array( 'idx' => 'name',		 	'lbl' => 'Nombre', 		'sortable' => TRUE, 	'searchable' => TRUE  	),
					array( 'idx' => 'pf_profile', 	'lbl' => 'Perfil', 		'sortable' => TRUE, 	'searchable' => TRUE  	), 
					array( 'idx' => 'actions',	 	'lbl' => 'Acciones', 	'sortable' => FALSE, 	'searchable' => FALSE, 'width' => '50px'	)
				); 
				$this->template = DIRECTORY_VIEWS . "/lists/lst.pry.user.php"; 
				break;
			
			case 'lst_pry_product':
			case 'lst_pry_product_asignation':
			case 'lst_pry_product_activation':
				$this->title = " Productos del proyecto ";
				$this->columns = array(
					array( 'idx' => 'id_product',	'lbl' => 'ID', 			'sortable' => TRUE, 	'searchable' => TRUE  	),
					array( 'idx' => 'pd_rival',		'lbl' => 'Comp.',		'sortable' => TRUE, 	'searchable' => FALSE, 'width' => '25px !important'  	),
					array( 'idx' => 'ba_brand',		'lbl' => 'Marca',	 	'sortable' => TRUE, 	'searchable' => TRUE 	),
					array( 'idx' => 'fa_family',	'lbl' => 'Familia',	 	'sortable' => TRUE, 	'searchable' => TRUE 	),
					array( 'idx' => 'pd_sku',		'lbl' => 'SKU', 		'sortable' => TRUE, 	'searchable' => TRUE 	),
					array( 'idx' => 'pd_product',	'lbl' => 'Producto', 	'sortable' => TRUE, 	'searchable' => TRUE, 'width' => '30%'  	), 
					array( 'idx' => 'actions',		'lbl' => 'Acciones', 	'sortable' => FALSE, 	'searchable' => FALSE, 'width' => '120px'	)
				); 
				$this->template = DIRECTORY_VIEWS . "/lists/lst.pry.product.php"; 
			break;
			case 'lst_dpdv':
			$this->title = " PDVs";
				$this->columns = array(
					array( 'idx' => 'id_pdv',		'lbl' => 'ID', 			'sortable' => TRUE, 	'searchable' => TRUE  	),
					array( 'idx' => 'pdv_name',		'lbl' => 'Nombre', 		'sortable' => TRUE, 	'searchable' => TRUE  	),
					array( 'idx' => 'pvt_pdv_type',		'lbl' => 'Tipo', 		'sortable' => TRUE, 	'searchable' => TRUE  	),
					array( 'idx' => 'pdv_latitude',	'lbl' => 'Latitud', 		'sortable' => TRUE, 	'searchable' => TRUE 	),
					array( 'idx' => 'pdv_longitude','lbl' => 'Longitud',	 	'sortable' => TRUE, 	'searchable' => TRUE 	),
					array( 'idx' => 'pdv_zone',	'lbl' => 'Zona',	 	'sortable' => TRUE, 	'searchable' => TRUE 	)		
				);
				$this->template = DIRECTORY_VIEWS . "/lists/li.pry.pdv.php"; 
			break;
			case 'lst_pry_pdv':				
			case 'lst_pry_pdv_asignation':
			case 'lst_pry_pdv_activation':
				$this->title = " PDVs del proyecto ";
				$this->columns = array(
					array( 'idx' => 'id_pdv',		'lbl' => 'ID', 			'sortable' => TRUE, 	'searchable' => TRUE  	),
					array( 'idx' => 'pdv_name',		'lbl' => 'Nombre', 		'sortable' => TRUE, 	'searchable' => TRUE, 'width' => '30%'  	),
					array( 'idx' => 'pvt_pdv_type',	'lbl' => 'Tipo', 		'sortable' => TRUE, 	'searchable' => TRUE 	),
					array( 'idx' => 'pdv_zone',		'lbl' => 'Zona',	 	'sortable' => TRUE, 	'searchable' => TRUE 	),
					array( 'idx' => 'ch_channel',	'lbl' => 'Canal',	 	'sortable' => TRUE, 	'searchable' => TRUE 	),
					array( 'idx' => 'gr_group',		'lbl' => 'Groupo',	 	'sortable' => TRUE, 	'searchable' => TRUE 	),
					array( 'idx' => 'fo_format',	'lbl' => 'Formato',	 	'sortable' => TRUE, 	'searchable' => TRUE 	), 
					array( 'idx' => 'actions',		'lbl' => 'Acciones', 	'sortable' => FALSE, 	'searchable' => FALSE, 'width' => '120px'	)
				);
				$this->template = DIRECTORY_VIEWS . "/lists/lst.pry.pdv.php"; 
			break;
			
			case 'lst_pry_evidence_type':
				$this->title = " Tipos de Evidencia del proyecto ";
				$this->columns = array(
					array( 'idx' => 'id_evidence_type',	'lbl' => 'ID', 					'sortable' => TRUE, 	'searchable' => TRUE  	),
					array( 'idx' => 'et_evidence_type',	'lbl' => 'Tipo de Evidencia',  	'sortable' => TRUE, 	'searchable' => TRUE, 	'width' => '80%;'  	)
				);
				$this->template = DIRECTORY_VIEWS . "/lists/lst.pry.evidence_type.php";
			break;
			case 'lst_pry_evidence_type_asignation':
				$this->title = " Tipos de Evidencia del proyecto ";
				$this->columns = array(
					array( 'idx' => 'id_evidence_type',	'lbl' => 'ID', 					'sortable' => TRUE, 	'searchable' => TRUE  	),
					array( 'idx' => 'et_evidence_type',	'lbl' => 'Tipo de Evidencia',  	'sortable' => TRUE, 	'searchable' => TRUE, 	'width' => '80%;'  	),  
					array( 'idx' => 'actions',	 		'lbl' => 'Acciones', 			'sortable' => FALSE, 	'searchable' => FALSE	)
				);
				$this->template = DIRECTORY_VIEWS . "/lists/lst.pry.evidence_type.php"; 
			break;
			
			case 'lst_pry_task_omition':
				$this->columns = array(
					array( 'idx' => 'id_task_omition_cause',	'lbl' => 'ID', 					'sortable' => TRUE, 	'searchable' => TRUE  	),
					array( 'idx' => 'tt_task_type',				'lbl' => 'Tipo de Tarea',		'sortable' => TRUE, 	'searchable' => TRUE , 	'width' => '30%;' 	),
					array( 'idx' => 'toc_task_omition_cause',	'lbl' => 'Motivo de Omisión',	'sortable' => TRUE, 	'searchable' => TRUE , 	'width' => '50%;' 	)
				);
				$this->template = DIRECTORY_VIEWS . "/lists/lst.pry.task_omition.php"; 
			break;
			
			case 'lst_pry_task_omition_asignation':
				$this->columns = array(
					array( 'idx' => 'id_task_omition_cause',	'lbl' => 'ID', 					'sortable' => TRUE, 	'searchable' => TRUE  	),
					array( 'idx' => 'tt_task_type',				'lbl' => 'Tipo de Tarea',		'sortable' => TRUE, 	'searchable' => TRUE , 	'width' => '30%;' 	),
					array( 'idx' => 'toc_task_omition_cause',	'lbl' => 'Motivo de Omisión',	'sortable' => TRUE, 	'searchable' => TRUE , 	'width' => '50%;' 	),  
					array( 'idx' => 'actions',					'lbl' => 'Acciones', 			'sortable' => FALSE, 	'searchable' => FALSE	)
				);
				$this->template = DIRECTORY_VIEWS . "/lists/lst.pry.task_omition.php"; 
			break;
			
			case 'lst_pry_visit':
				$this->title = " Visitas ";
				$this->columns = array(
					array( 'idx' => 'id_visit',			'lbl' => 'ID', 			'sortable' => FALSE, 	'searchable' => FALSE  	),
					array( 'idx' => 'vi_scheduled_start','lbl'=> 'Inicio Prog.','sortable' => FALSE, 	'searchable' => FALSE 	),
					array( 'idx' => 'vi_scheduled_end',	'lbl' => 'Final Prog.',	'sortable' => FALSE, 	'searchable' => FALSE 	),
					array( 'idx' => 'vi_real_start',	'lbl' => 'Inicio Real',	'sortable' => FALSE, 	'searchable' => FALSE 	),
					array( 'idx' => 'vi_real_end',		'lbl' => 'Final Real', 	'sortable' => FALSE, 	'searchable' => FALSE 	),   
					array( 'idx' => 'us_user',			'lbl' => 'Usuario',		'sortable' => FALSE, 	'searchable' => FALSE 	),   
					array( 'idx' => 'pdv_name',			'lbl' => 'PDV',			'sortable' => FALSE, 	'searchable' => FALSE 	), 			 
					array( 'idx' => 'vs_visit_status',	'lbl' => 'Status',		'sortable' => FALSE, 	'searchable' => FALSE 	),   
					array( 'idx' => 'actions',			'lbl' => 'Acciones', 	'sortable' => FALSE, 	'searchable' => FALSE, 'width' => '60px'	)
				); 
				$this->template = DIRECTORY_VIEWS . "/lists/lst.pry.visit.php"; 
				break;  
				
			case 'lst_pry_visit_omition':
				$this->columns = array(
					array( 'idx' => 'id_visit_reschedule_cause',	'lbl' => 'ID', 						'sortable' => TRUE, 	'searchable' => TRUE  	),
					array( 'idx' => 'vrc_visit_reschedule_cause',	'lbl' => 'Motivo de Reagendación',  'sortable' => TRUE, 	'searchable' => TRUE, 	'width' => '80%;'  	)
				);
				$this->template = DIRECTORY_VIEWS . "/lists/lst.pry.visit_omition.php"; 
			break;
			
			case 'lst_pry_visit_omition_asignation':
				$this->columns = array(
					array( 'idx' => 'id_visit_reschedule_cause',	'lbl' => 'ID', 						'sortable' => TRUE, 	'searchable' => TRUE  	),
					array( 'idx' => 'vrc_visit_reschedule_cause',	'lbl' => 'Motivo de Reagendación',  'sortable' => TRUE, 	'searchable' => TRUE, 	'width' => '80%;'  	),  
					array( 'idx' => 'actions',	 					'lbl' => 'Acciones', 				'sortable' => FALSE, 	'searchable' => FALSE	)
				);
				$this->template = DIRECTORY_VIEWS . "/lists/lst.pry.visit_omition.php"; 
			break;
			
			case 'lst_pry_supplier':
			case 'lst_pry_supplier_asignation':
				$this->columns = array(
					array( 'idx' => 'id_supplier',	'lbl' => 'ID', 			'sortable' => TRUE, 	'searchable' => TRUE  	),
					array( 'idx' => 'su_supplier',	'lbl' => 'Mayorista', 	'sortable' => TRUE, 	'searchable' => TRUE, 'width' => '80%'	), 
					array( 'idx' => 'actions',		'lbl' => 'Acciones', 	'sortable' => FALSE, 	'searchable' => FALSE	)
				); 
				$this->template = DIRECTORY_VIEWS . "/lists/lst.pry.supplier.php"; 
			break;
			/**/case 'lst_pry_free_day':
				$this->title = " Días Libres ";
				$this->columns = array(
					array( 'idx' => 'id_free_day',		'lbl' => 'Id',		'sortable' => TRUE, 	'searchable' => TRUE  	),
					array( 'idx' => 'fd_date_string',		'lbl' => 'Concepto',		'sortable' => TRUE, 	'searchable' => TRUE 	),    
					array( 'idx' => 'fd_date_timestamp','lbl' => 'Fecha', 	'sortable' => FALSE, 	'searchable' => FALSE),
					array( 'idx' => 'actions',	'lbl' => 'Acciones', 				'sortable' => FALSE, 	'searchable' => FALSE	)
				); 
				$this->template = DIRECTORY_VIEWS . "/lists/lst.pry.free.day.php"; 
				break;
		}
	} 
}


?>