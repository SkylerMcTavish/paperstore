<?php
global $Session; 
global $response; 
switch ( $action ) {
	case 'brand':
	case 'product_category':
	case 'supplier':
	
	case 'lst_admin_users':
	case 'lst_supplier': 
	case 'company':
	case 'country':
	case 'evidence_type':
	case 'region':
	case 'state':
	case 'task_omition_cause':
	case 'visit_reschedule_cause':
	case 'lst_activity_type':
	case 'lst_activity':
	case 'lst_task_type':
	case 'lst_task_type':
	case 'lst_task_type_activities':
	case 'lst_pdv_type':
	case 'lst_pdv_type_task':
		if ( !$Session->is_admin() )
			$response['error'] = " No permissions for list. ";
		break; 
	
	case 'lst_pdv':
	case 'lst_product':
    case 'lst_prospect':
	case 'lst_channel':
	case 'lst_group':
	case 'lst_format':
	case 'lst_brand':
	case 'lst_family':
	case 'lst_visit':
	case 'lst_order':
	case 'lst_payment':
	case 'lst_invoice':
	case 'lst_city':
	case 'lst_computer':
	case 'lst_tax':
	case 'lst_service':
	case 'lst_bar_stock':
	case 'lst_warehouse':
	case 'lst_leasing':
	break;
		
	default:
		$response['error'] = " Invalid list. ";
	break;
}

if ( !isset($response['error']) || $response['error'] == '' ){
	
	if ( isset( $_POST['table_id'] ) && $_POST['table_id'] != '' ){
		$table_id = $_POST['table_id'];
		require_once DIRECTORY_CLASS . "class.datatable.php";
		
		switch ($action) {
			case 'brand':
			case 'product_category':
			case 'supplier':
				require_once DIRECTORY_CLASS . "class.catalogue.lst.php";
				$list = new CatalogueList( $action, $table_id );	
				break; 
			case 'lst_admin_users':
				require_once DIRECTORY_CLASS . "class.admin.lst.php";
				$list = new AdminList( $action, $table_id );
				break;  
			case 'lst_pdv':
			case 'lst_product':
                        case 'lst_prospect':
			case 'lst_channel':
			case 'lst_group':
			case 'lst_format':
			case 'lst_brand':
			case 'lst_family':
			case 'lst_visit':
			case 'lst_order':
			case 'lst_payment':
			case 'lst_invoice':
			case 'lst_city':
			case 'lst_activity':
			case 'lst_activity_type':
			case 'lst_task_type':
			case 'lst_task_type':
			case 'lst_task_type_activities':
			case 'lst_pdv_type':
			case 'lst_pdv_type_task':
			case 'lst_computer':
			case 'lst_tax':
			case 'lst_service':
			case 'lst_bar_stock':
			case 'lst_warehouse':
			case 'lst_leasing':
				if ( $Session->is_admin() ){ 
					require_once DIRECTORY_CLASS . "class.admin.lst.php";
					$list = new AdminList( $action, $table_id );
				} else {
					require_once DIRECTORY_CLASS . "class.proyect.lst.php";
					$list = new ProyectList( $action, $table_id ); 
				}
				break;				
			case 'lst_pry_supplier':
			case 'lst_pry_cycle':
			case 'lst_pry_form':
			case 'lst_pry_media':
			case 'lst_pry_user':
			case 'lst_pry_user_asignation':
			case 'lst_pry_user_activation':
			case 'lst_pry_product':
			case 'lst_pry_product_asignation':
			case 'lst_pry_product_activation':
			case 'lst_pry_pdv':
			case 'lst_pry_pdv_asignation':
			case 'lst_pry_pdv_activation':
			case 'lst_pry_evidence_type':
			case 'lst_pry_evidence_type_asignation':
			case 'lst_pry_task_omition':
			case 'lst_pry_task_omition_asignation':
			case 'lst_pry_visit_omition':
			case 'lst_pry_visit_omition_asignation':
			case 'lst_pry_supplier':
			case 'lst_pry_supplier_asignation':
			case 'lst_pry_form_type':
			case 'lst_pry_free_day':				
				if ( $Session->is_proyect_admin() ){ 
					require_once DIRECTORY_CLASS . "class.admin.proyect.lst.php";
					$list = new AdminProyectList( $action, $table_id );
				} else {
					require_once DIRECTORY_CLASS . "class.proyect.lst.php";
					$list = new ProyectList( $action, $table_id ); 
				}
				break;
			case 'lst_pry_visit':
				if ( $Session->is_proyect_admin() ){ 
					require_once DIRECTORY_CLASS . "class.admin.visit.php";
					$list = new AdminProyectList( $action, $table_id );
				} else {
					require_once DIRECTORY_CLASS . "class.visit.php";
					$list = new ProyectList( $action, $table_id ); 
				}
				break;
				
			case 'lst_pry_supervisor':										
				if ( $Session->is_proyect_admin() )
				{ 
					require_once DIRECTORY_CLASS . "class.admin.proyect.supervisor.lst.php";
					$list = new AdminProyectSupervisorList( $action, $table_id, $_POST['parent'] );
				}else{
					require_once DIRECTORY_CLASS . "class.admin.proyect.supervisor.php";
					$list = new ProyectSupervisor( $action, $table_id, $_POST['parent'] );
				}
				break;
				case 'lst_pry_agenda':
				if ( $Session->is_admin() ){ 
					require_once DIRECTORY_CLASS . "class.admin.proyect.supervisor.lst.php";
					$list = new AdminProyectSupervisorList( $action, $table_id, $_POST['parent'] );
				}else{
					require_once DIRECTORY_CLASS . "class.admin.proyect.supervisor.php";
					$list = new ProyectSupervisor( $action, $table_id, $_POST['parent'] );
				} 
				break;		
		} 
		
		if ( isset($_POST['filterIdx']) && $_POST['filterIdx'] != '' && isset($_POST['filterVal']) && $_POST['filterVal'] != '' ){
			$list->set_filter( $_POST['filterIdx'], $_POST['filterVal']);
			$list->fidx = $_POST['filterIdx'];
			$list->fval = $_POST['filterVal'];
		} 
		
		if ( isset($_POST['extraFilterIdx']) && $_POST['extraFilterIdx'] != '' && isset($_POST['extraFilterVal']) && $_POST['extraFilterVal'] != '' ){
			$list->set_filter( $_POST['extraFilterIdx'], $_POST['extraFilterVal']);
			$list->exfidx = $_POST['extraFilterIdx'];
			$list->exfval = $_POST['extraFilterVal'];
		}
		
		$response['html'] = $list->get_list_html( TRUE );
		if ( count( $list->error ) > 0 ){
			//$response['error'] .= $list->get_errors( );
			//$response['html'] 	= "";
			$response['success'] = TRUE;
		}  else {
			$response['lbl_foot'] = $list->get_foot_records_label();
			$response['tpages'] = $list->total_pages;
			$response['page'] = $list->page;
			$response['trecords'] = $list->total_records;
			$response['rows'] = $list->rows;
			$response['success'] = TRUE;
		}
		
	} else {
		$response['error'] .= " Invalid table id. <br/> "; 
	} 
	 
}

?>