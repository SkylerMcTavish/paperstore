<?php
//ini_set('display_errors' , TRUE);
global $response, $Session; 
require_once DIRECTORY_CLASS . "class.admin.proyect.php";
switch ( $action ){  
	case 'delete_cycle':  
		if ( $Session->id_proyect > 0 ){
			$proyect = new AdminProyect( $Session->id_proyect ); 
			
			$cycle = new stdClass;
			$cycle->from 	= ( isset($_POST['from']) 	&& is_numeric($_POST['from']) 	&& $_POST['from'] > 0 	) ? $_POST['from'] + 0 	: 0;
			$cycle->to 		= ( isset($_POST['to']) 	&& is_numeric($_POST['to']) 	&& $_POST['to'] > 0 	) ? $_POST['to'] + 0 	: 0;
			$resp = $proyect->delete_cycle( $cycle );
			if ( count( $proyect->error ) > 0 ){
				$response['error'] = $proyect->get_errors(); 
			} else { 
				$response['success'] = TRUE;
			}
		} else{
			$response['error'] = "Invalid proyect.";
		} 
		break; 
	default:
		$response['error'] = "Invalid action.";
			break;
}
?>