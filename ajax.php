<?php
require_once "init.php"; 
//ini_set('display_errors', true);
try {

	$response 	= array( 'success' => false );
	$resource	= isset($_REQUEST['resource']) ? $_REQUEST['resource'] : '';
	$action 	= isset($_REQUEST['action']	) ? $_REQUEST['action'] : '';
	
	switch ( $resource ){ 
		case 'settings':
		case 'contact':
		case 'lists':
		case 'proyect':
		case 'supplier':
		case 'catalogue':
		case 'pdv':
		case 'pry.form':
		case 'free.day':
		case 'visit':		
		case 'meta':
		case 'payment':
		case 'deposit':
        case 'stock':
        case 'invoice':
		case 'paying':
		case 'prospect':
        case 'order':
		/***********************/
		case 'product':
		case 'sell':
		case 'sitemap':
		case 'tax':
		case 'service':
		case 'reports':
			require_once DIRECTORY_AJAX . 'ajax.' . $resource . '.php';
			break;  
		case 'user':
		case 'profile':
			require_once DIRECTORY_AJAX . 'ajax.admin.php';
			break;  
		case 'admin.visit':
		case 'admin.pdv':
		case 'admin.product':
		case 'admin.proyect':
		case 'admin.catalogues':
		case 'admin.proyect.supervisor':
		case 'admin.activity':
		case 'admin.task.type':
				global $Session;
			if ( $Session->is_admin() ){
				require_once DIRECTORY_AJAX . 'ajax.' . $resource . '.php';
			} else {
				global $Log;
				$Log->write_log( "Restricted access ", SES_RESTRICTED_ACTION, 3 );
				//$responce['error'] = "Restricted access"; 
				$response['error'] = "Restricted access";
			}
			break;
		case 'admin.proyect.asignation':
			global $Session;
			if ( $Session->is_proyect_admin() ){
				require_once DIRECTORY_AJAX . 'ajax.' . $resource . '.php';
			} else {
				global $Log;
				$Log->write_log( "Restricted access ", SES_RESTRICTED_ACTION, 3 ); 
				$response['error'] = "Restricted access";
			}
			break;
		default: 
			//$responce['error'] = "Invalid resource";
			$response['error'] = "Invalid resource";
			break; 
	} 	
} catch ( Exception $err ){ 
	$response 	= array( 'success' => false, 'error' => $err->__toString() );
}

echo json_encode( $response );
?>