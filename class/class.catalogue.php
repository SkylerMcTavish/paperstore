<?php
/*paperstore*/

class Catalogue extends Object{ 

	public function __construct(){
		$this->class = 'Catalogue'; 
	} 
	
	/**
	 * function get_catalogue()
	 * Returns an array of catalogue records 
	 * 
	 * @param 		$which 		String 	catalogue to query
	 * @param 		$opt	 	Boolean	if TRUE returns an array for lists od ID's and options.  
	 * @param 		$extra	 	if different to  FALSE uses the argument in the query   
	 * 
	 * @return		$html		Array An array of information from a catalogue , FALSE on error
	 */ 
	public function get_catalogue( $which = '', $opt = FALSE, $extra = FALSE ){
		if ($which != ''){
			switch ($which){
			
				case 'user':
					$query = "SELECT * " . ( $opt ? ", id_user as id, us_user as opt " : "") . " FROM " . PFX_MAIN_DB . "user WHERE us_status = 1 AND us_pf_id_profile > 3 ORDER BY id_user ";
				break;
				
				case 'brand':
					$query = "SELECT * " . ( $opt ? ", id_brand as id, br_brand as opt " : "") . " FROM " . PFX_MAIN_DB . "brand WHERE br_status = 1 ORDER BY id_brand ";
					break;
				
				case 'rack':
					$query = " SELECT * ".( $opt ? ", id_rack as id, rk_name as opt " : "") . "  FROM " . PFX_MAIN_DB . "rack WHERE rk_status = 1 ";
				break;
				
				case 'product':
					$query = " SELECT * ".( $opt ? ", id_product as id, pd_product as opt " : "") . "  FROM " . PFX_MAIN_DB . "product WHERE pd_status = 1 ";
				break;
				
				case 'product_supply_bar':
					$query = 	" SELECT * ".( $opt ? ", id_product as id, pd_product as opt " : "") .
								" FROM " . PFX_MAIN_DB . "storehouse_stock ".
								" INNER JOIN ".PFX_MAIN_DB."product ON id_product = ss_pd_id_product ".
								" WHERE ss_quantity > 0 AND pd_status > 0 AND ss_status > 0 ".
								" AND id_product NOT IN ( SELECT bs_pd_id_product FROM ".PFX_MAIN_DB."bar_stock ) ";
				break;
				
				case 'product_supply_warehouse':
					$query = 	" SELECT * ".( $opt ? ", id_product as id, pd_product as opt " : "") .
								" FROM ".PFX_MAIN_DB."product ".
								" WHERE pd_status > 0 AND id_product NOT IN ( SELECT ss_pd_id_product FROM ".PFX_MAIN_DB."storehouse_stock )";
				break;
				
				case 'supplier':
					$query = " SELECT * ".( $opt ? ", id_supplier as id, sp_supplier as opt " : "") . "  FROM " . PFX_MAIN_DB . "supplier WHERE sp_status = 1 ";
				break;
				
				case 'product_category':
					$query = " SELECT * ".( $opt ? ", id_product_category as id, pc_product_category as opt " : "") . "  FROM " . PFX_MAIN_DB . "product_category WHERE pc_status = 1 ";
				break;
				
				case 'packing':
					$query = " SELECT * ".( $opt ? ", id_product_packing as id, pp_product_packing as opt " : "") . "  FROM " . PFX_MAIN_DB . "product_packing WHERE pp_status = 1 ";
				break;
				
				case 'computer_type':
					$query = " SELECT * ".( $opt ? ", id_computer_type as id, ct_computer_type as opt " : "") . "  FROM " . PFX_MAIN_DB . "computer_type WHERE ct_status = 1 ";
				break;
				
				case 'sitemap_available_computer':
					$query = 	" SELECT * ".($opt ? ", id_computer AS id, cm_computer AS opt " : "" ) .
								" FROM " . PFX_MAIN_DB . "computer ".
								" WHERE id_computer NOT IN ( SELECT sm_cm_id_computer FROM " . PFX_MAIN_DB . "sitemap ) ".
								" AND cm_status > 0 ";
				break;
				
				case 'product_stock':
					$query = 	" SELECT * ".( $opt ? ", id_product as id, pd_product as opt " : "") .
								" FROM " . PFX_MAIN_DB . "bar_stock ".
								" INNER JOIN ".PFX_MAIN_DB."product ON id_product = bs_pd_id_product ".
								" WHERE bs_unity_quantity > 0 AND pd_status > 0 AND bs_status > 0 ".
								" ORDER BY opt ";
				break;
				
				case 'product_stock_paperstore':
					$query = 	" SELECT * ".( $opt ? ", id_product as id, pd_product as opt " : "") .
								" FROM " . PFX_MAIN_DB . "bar_stock ".
								" INNER JOIN ".PFX_MAIN_DB."product ON id_product = bs_pd_id_product ".
								" INNER JOIN ".PFX_MAIN_DB."product_category ON id_product_category = pd_pc_id_product_category ".
									" AND pc_product_category = 'Papeleria' ".
								" WHERE bs_unity_quantity > 0 AND pd_status > 0 AND bs_status > 0 ".
								" ORDER BY opt ";
				break;
				
				case 'product_stock_cloth':
					$query = 	" SELECT * ".( $opt ? ", id_product as id, pd_product as opt " : "") .
								" FROM " . PFX_MAIN_DB . "bar_stock ".
								" INNER JOIN ".PFX_MAIN_DB."product ON id_product = bs_pd_id_product ".
								" INNER JOIN ".PFX_MAIN_DB."product_category ON id_product_category = pd_pc_id_product_category ".
									" AND pc_product_category = 'Merceria' ".
								" WHERE bs_unity_quantity > 0 AND pd_status > 0 AND bs_status > 0 ".
								" ORDER BY opt ";
				break;
				
				case 'product_stock_gift':
					$query = 	" SELECT * ".( $opt ? ", id_product as id, pd_product as opt " : "") .
								" FROM " . PFX_MAIN_DB . "bar_stock ".
								" INNER JOIN ".PFX_MAIN_DB."product ON id_product = bs_pd_id_product ".
								" INNER JOIN ".PFX_MAIN_DB."product_category ON id_product_category = pd_pc_id_product_category ".
									" AND pc_product_category = 'Regalos' ".
								" WHERE bs_unity_quantity > 0 AND pd_status > 0 AND bs_status > 0 ".
								" ORDER BY opt ";
				break;
					
				/****************************************************************/
				 
				case 'channel':
					$query = "SELECT * " . ( $opt ? ", id_channel as id, ch_channel as opt " : "") . " FROM " . PFX_MAIN_DB . "channel WHERE ch_status = 1 ORDER BY id_channel ";
					break;
				case 'group':
					$query = "SELECT * " . ( $opt ? ", id_group as id, gr_group as opt " : "") . " FROM " . PFX_MAIN_DB . "group " 
								." WHERE gr_status = 1  " . ( ($extra != '' ) ? " AND gr_ch_id_channel = " . $extra . " " : "" )
							. " ORDER BY id_group ";
					break;
				case 'format':
					$query = "SELECT * " . ( $opt ? ", id_format as id, fo_format as opt " : "") . " FROM " . PFX_MAIN_DB . "format " 
								." WHERE fo_status = 1  " . ( ($extra != '' ) ? " AND fo_gr_id_group = " . $extra . " " : "" )
							. " ORDER BY id_format ";
					break;
					
				case 'division':
					$query = "SELECT * " . ( $opt ? ", id_division as id, dv_division as opt " : "") . " FROM " . PFX_MAIN_DB . "division ORDER BY id_division ";
					break;
				
				case 'city':
					$query = "SELECT * " . ( $opt ? ", id_city as id, CONCAT(ct_code, ' - ' , ct_city) as opt " : "") . " FROM " . PFX_MAIN_DB . "city WHERE ct_status = 1 ORDER BY ct_code "; 
					break;
					
				case 'activity_type':
					$query = "SELECT * " . ( $opt ? ", id_activity_type as id, at_activity_type as opt " : "") . " FROM " . PFX_MAIN_DB . "activity_type ORDER BY id_activity_type "; 
				break;
					
				case 'activity':
					$query = "SELECT * " . ( $opt ? ", id_activity as id, ac_activity as opt " : "") . " FROM " . PFX_MAIN_DB . "activity ".
					( ($extra != '' ) ? " WHERE id_activity NOT IN (SELECT tta_ac_id_activity FROM " . PFX_MAIN_DB . "task_type_activities WHERE tta_tt_id_task_type = " . $extra . "  )  " : "" ) .
					" ORDER BY id_activity "; 
				break;
					
				
				case 'brand_own':
					$query = "SELECT * " . ( $opt ? ", id_brand as id, ba_brand as opt " : "") . " FROM " . PFX_MAIN_DB . "brand WHERE ba_status = 1 AND ba_rival = 0 ORDER BY id_brand ";
					break;
				case 'brand_rival':
					$query = "SELECT * " . ( $opt ? ", id_brand as id, ba_brand as opt " : "") . " FROM " . PFX_MAIN_DB . "brand WHERE ba_status = 1 AND ba_rival = 1 ORDER BY id_brand ";
					break;
					
				case 'family':
					$query = "SELECT * " . ( $opt ? ", id_family as id, fa_family as opt " : "") . " FROM " . PFX_MAIN_DB . "family " 
								." WHERE fa_status = 1 " . ( ($extra != '' ) ? " AND fa_ba_id_brand = " . $extra . " " : "" )
							. " ORDER BY id_family ";
					break;
				case 'family_own':
					$query = "SELECT * " . ( $opt ? ", id_family as id, fa_family as opt " : "") . " FROM " . PFX_MAIN_DB . "family " 
								." WHERE fa_status = 1 AND fa_rival = 0 " . ( ($extra != '' ) ? " AND fa_ba_id_brand = " . $extra . " " : "" )
							. " ORDER BY id_family ";
					break;
				case 'family_rival':
					$query = "SELECT * " . ( $opt ? ", id_family as id, fa_family as opt " : "") . " FROM " . PFX_MAIN_DB . "family " 
								." WHERE fa_status = 1 AND fa_rival = 1 " . ( ($extra != '' ) ? " AND fa_ba_id_brand = " . $extra . " " : "" )
							. " ORDER BY id_family ";
					break;
				
				
				case 'company':
					$query = "SELECT * " . ( $opt ? ", id_company as id, cm_company as opt " : "") . " FROM " . PFX_MAIN_DB . "company WHERE cm_status = 1  ORDER BY id_company "; 
					break;
				case 'country':
					$query = "SELECT * " . ( $opt ? ", id_country as id, cnt_country as opt " : "") . " FROM " . PFX_MAIN_DB . "country WHERE cnt_status = 1 ORDER BY id_country "; 
					break;
				case 'frequency':
					$query = "SELECT * " . ( $opt ? ", id_frequency as id, fr_frequency as opt " : "") . " FROM " . PFX_MAIN_DB . "frequency ORDER BY id_frequency "; 
					break;
				case 'data_type':
					$query = "SELECT * " . ( $opt ? ", id_data_type as id, dt_data_type as opt " : "") . " FROM " . PFX_MAIN_DB . "data_type ORDER BY id_data_type "; 
					break;
				case 'file_type':
					$query = "SELECT * " . ( $opt ? ", id_file_type as id, ft_file_type as opt " : "") . " FROM " . PFX_MAIN_DB . "file_type ORDER BY id_file_type ";
					break; 
				case 'media_type':
					$query = "SELECT * " . ( $opt ? ", id_media_type as id, mt_media_type as opt " : "") . " FROM " . PFX_MAIN_DB . "media_type ORDER BY id_media_type ";
					break; 
				case 'proyect_type':
					$query = "SELECT * " . ( $opt ? ", id_proyect_type as id, prt_proyect_type as opt " : "") . " FROM " . PFX_MAIN_DB . "proyect_type ORDER BY id_proyect_type "; 
					break;
				case 'pdv_type':
					$query = "SELECT * " . ( $opt ? ", id_pdv_type as id, pvt_pdv_type as opt " : "") . " FROM " . PFX_MAIN_DB . "pdv_type ORDER BY id_pdv_type ";
					break; 
				case 'task_type':
					$query = "SELECT * " . ( $opt ? ", id_task_type as id, tt_task_type as opt " : "") . " FROM " . PFX_MAIN_DB . "task_type ".
							( ($extra != '' ) ? " WHERE id_task_type NOT IN (SELECT ptt_tt_id_task_type FROM " . PFX_MAIN_DB . "pdv_type_task_type WHERE ptt_pvt_id_pdv_type = " . $extra . "  )  " : "" ) .
							" ORDER BY id_task_type ";
					break; 
				case 'visit_status':
					$query = "SELECT * " . ( $opt ? ", id_visit_status as id, vs_visit_status as opt " : "") . " FROM " . PFX_MAIN_DB . "visit_status ORDER BY id_visit_status ";
					break; 
				case 'region':
					$query = "SELECT * " . ( $opt ? ", id_region as id, re_region as opt " : "") . " FROM " . PFX_MAIN_DB . "region ORDER BY id_region "; 
					break;
				case 'product_presentation':
					$query = "SELECT * " . ( $opt ? ", id_product_presentation as id, pp_product_presentation as opt " : "") . " FROM " . PFX_MAIN_DB . "product_presentation ORDER BY id_product_presentation ";
					break; 
				case 'profiles':
					$query = "SELECT * " . ( $opt ? ", id_profile as id, pf_profile as opt " : "") . " FROM " . PFX_MAIN_DB . "profile ORDER BY id_profile ";
					break; 
				case 'state':
					$query = "SELECT * " . ( $opt ? ", id_state as id, st_state as opt " : "" ) . " FROM " . PFX_MAIN_DB . "state "
								. " WHERE st_status = 1 " . ( ($extra != '' ) ? " AND st_cnt_id_country = " . $extra . " " : "" )
							. " ORDER BY st_state ";
					break;
				case 'supplier':
					$query = "SELECT * " . ( $opt ? ", id_supplier as id, su_supplier as opt " : "") . " FROM " . PFX_MAIN_DB . "supplier WHERE su_status = 1 ORDER BY id_supplier "; 
					break;
				case 'users_contact_edition':
					$query = "SELECT * " . ( $opt ? ", id_user as id, us_user as opt " : "") . " FROM " . PFX_MAIN_DB . "user "
								. " WHERE id_user NOT IN (SELECT co_us_id_user FROM " . PFX_MAIN_DB . "contact ) "
								. ( ($extra != '' ) ? " OR id_user = " . $extra . " " : "" ); 
					break;
				
				case 'question_type':
					$query = "SELECT * " . ( $opt ? ", id_question_type as id, qt_question_type as opt " : "") . " FROM " . PFX_MAIN_DB . "question_type ORDER BY id_question_type "; 
					break;
				
				/* Proyect Catalogues */
				case 'form_type':
					$query = "SELECT * " . ( $opt ? ", id_form_type as id, fmt_form_type as opt " : "") . " FROM " . PFX_PRY_DB . "form_type WHERE fmt_status = 1 ORDER BY id_form_type "; 
					break;
				case 'frm_visit';				
					$query = "SELECT * " . ( $opt ? ", id_user as id, us_user as opt " : "") . ", pu_pr_id_proyect, pu_us_id_user, pu_active FROM " . PFX_MAIN_DB . "user RIGHT JOIN " . PFX_MAIN_DB . "proyect_user ON id_user=pu_us_id_user AND pu_pr_id_proyect=".ID_PRY;
					break;
					
				default:
					$this->error[] = "Invalid catalogue.";
					return FALSE;
			}  
			
			global $obj_bd; 
			$result  = $obj_bd->query( $query ); 
			if ( $result !== FALSE ){
				return $result;
			} 
			else return FALSE;
		}
	}
	
	/**
	 * function get_catalgue_options()
	 * Returns an html string of catalogue options from the database to be inserted in a 'selected' control
	 * 
	 * @param 		$which 		String 	catalogue to query
	 * @param 		$active 	Int		ID of the selected option 
	 * @param 		$option_0	String 	for the first option if string is empty no first option  will be added 
	 * 
	 * @return		$html		String	HTML list of the catalogue options, FALSE on error
	 * 
	 */ 
	public function get_catalgue_options( $which, $selected = 0, $option_0 = 'Elija una opción', $extra = FALSE ){
		if ($which != ''){
			$html = "";
			if ( $option_0 != '' )
				$html .= "<option value='0' " . ( $selected == 0 ? "selected='selected'" : "" ) . " >" . $option_0 . "</option>";
			$options = $this->get_catalogue( $which, true, $extra); 
			if ( $options ){
				foreach ($options as $k => $ops) {
					$html .= "<option value='" . $ops['id'] . "' "
					 			. ( $selected == $ops['id'] ? "selected='selected'" : "" ) 
								. "  >" . $ops['opt'] 
							. "</option>";
				}
			}
			return $html;
		} else {
			$this->error[] = "Invalid catalogue.";
			return FALSE; 
		}
	}
	
	/**
	 * function get_catalgue_lists()
	 * Returns an html string of a listed tab menu from a catalogue
	 * 
	 * @param 		$which 		String 	catalogue to query
	 * @param 		$active 	Int		ID for the active tab		
	 * @param		$link_tmpl	String	link string template to concatenate to the id to change view
	 * @param 		$tab_0		String 	for the first tab if string is empty no first tab before the catalogue
	 * @param		$css		Strng 	Class for the link in the tab
	 * 
	 * @return		$html		String	HTML list of the catalogue tabs , FALSE on error
	 * 
	 */ 
	public function get_catalgue_lists( $which, $active = 0, $link_tmpl = '', $tab_0 = '', $css = 'tab-link' ){
		if ($which != ''){
			$html = "";
			if ( $tab_0 != '' )
				$html .=  "<li " . ( $active == 0 ? "class='active'" : "" ) . " >" 
							. "<a id='tab_" . $which . "_0' " 
									. " class='" . $css . "' " 
									. " href='" . ( $link_tmpl != '' ? $link_tmpl . "0" : "#" ) . "'>" 
								. $tab_0 
							. "</a>"  
						. "</li>";
			$options = $this->get_catalogue( $which, true); 
			if ( $options ){
				foreach ($options as $k => $ops) {
					$html .= "<li " . ( $active == $ops['id'] ? "class='active'" : "" ) . " >" 
							. "<a id='tab_" . $which . "_" . $ops['id'] . "' " 
									. " class='" . $css . "' " 
									. " href='" . ( $link_tmpl != '' ? $link_tmpl . $ops['id'] : "#" ) . "'>" 
								. $ops['opt']
							. "</a>"  
						. "</li>"; 
				}
			}
			return $html;
		} else {
			$this->set_error("Invalid catalogue.", ERR_VAL_INVALID);
			return FALSE; 
		}
	}	
}
?>