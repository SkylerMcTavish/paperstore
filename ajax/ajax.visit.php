<?php 
global $response, $Session; 
require_once DIRECTORY_CLASS . "class.visit.php"; 
switch ( $action ){
	case 'get_visit_info': 
		$id_visit = ( isset($_POST['id_visit']) && is_numeric($_POST['id_visit']) && $_POST['id_visit'] > 0 ) ? $_POST['id_visit'] : 0;
		
		if ( $id_visit > 0 ){
			$Visit = new Visit( $id_visit ); 
			$response['html'] = $Visit->get_info_html( );
			if ( count( $Visit->error ) > 0 ){
				$response['error'] = $Visit->get_errors(); 
			} else {
				$response['success'] = TRUE;
			}
		} else{
			$response['error'] = "Invalid Visit.";
		} 
		break;  
	case 'get_visit_info_html': 
		$id_visit = ( isset($_POST['id_visit']) && is_numeric($_POST['id_visit']) && $_POST['id_visit'] > 0 ) ? $_POST['id_visit'] : 0;
		
		if ( $id_visit > 0 ){
			/**/$Visit = new Visit( $id_visit ); 
			$response['html'] = $Visit->get_info_html( );
			if ( count( $Visit->error ) > 0 ){
				$response['error'] = $Visit->get_errors(); 
			} else {
				$response['success'] = TRUE;
			}
		} else{
			$response['error'] = "Invalid Visit.";
		} 
		break;
}
?>