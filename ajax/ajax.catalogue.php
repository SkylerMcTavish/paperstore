<?php
global $response; 
global $Session;

switch ( $action ){
	case 'get_options':
		if ( $_POST['catalogue'] && $_POST['catalogue'] != '' ){
			$catalogue = $_POST['catalogue']; 
			require_once DIRECTORY_CLASS . "class.catalogue.php"; 
			$cat 	= new Catalogue(); 			
			$parent = ( isset($_POST['parent']) && $_POST['parent'] != '' ) ? $_POST['parent'] : FALSE; 
			$options = $cat->get_catalgue_options( $catalogue, 0, 'Elija una opción', $parent);
			if ( $options ){
				$response['message'] = "OK";
				$response['options'] = $options;
				$response['success'] = TRUE;
			} else {
				$response['error'] = $cat->get_error();
			}
		} else {
			$response['error'] = "Invalid catalogue.";
		}
		break;
	default:
		$response['error'] = "Invalid action.";
		break;
}
?>