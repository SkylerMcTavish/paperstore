<?php 
global $response;
ini_set('display_errors', TRUE);
if ( IS_ADMIN ){
	switch ( $action ){
		/*case 'is_unique_type_form':
			global $Validate;
			$id_type_form = $_POST['id_type_form'];
			$type_form = $_POST['type_form']; 
			$id_type_form = ( !is_numeric($id_type_form) ) ? 0 : $id_type_form;					
			$response['unique']  = $Validate->is_unique( 'pr1_form_type', 'fmt_form_type', $type_form, 'id_form_type', $id_type_form );
			$response['success'] = TRUE; 
		break;	*/ 
		case 'get_proyect_info': 
			require_once DIRECTORY_CLASS . "class.proyect.php";
			$id_proyect = ( isset($_POST['id_proyect']) && is_numeric($_POST['id_proyect']) && $_POST['id_proyect'] > 0 ) ? $_POST['id_proyect'] : 0;
			if ( $id_proyect > 0 ){
				$Proyect = new Proyect( $id_proyect );
				$response['info'] = $Proyect->get_array();
				if ( count( $Proyect->error ) > 0 ){
					$response['error'] = $Proyect->get_errors(); 
				} else {
					$response['success'] = TRUE;
				}
			} else{
				$response['error'] = "Invalid proyect.";
			} 
			break;
		case 'get_proyect_info_html':
			require_once DIRECTORY_CLASS . "class.proyect.php";
			$id_proyect = ( isset($_POST['id_proyect']) && is_numeric($_POST['id_proyect']) && $_POST['id_proyect'] > 0 ) ? $_POST['id_proyect'] : 0;
			if ( $id_proyect > 0 ){
				$Proyect = new Proyect( $id_proyect ); 
				$response['html'] = $Proyect->get_info_html( TRUE );
				if ( count( $Proyect->error ) > 0 ){
					$response['error'] = $Proyect->get_errors(); 
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
} else {
	$response['error'] = "Invalid action.";
}
?>