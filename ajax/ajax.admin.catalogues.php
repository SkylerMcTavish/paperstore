<?php
global $response; 
global $Session;
if ( $Session->is_admin() ){
	switch ( $action ){
		case 'get_catalogue_admin_info': 
			require_once DIRECTORY_CLASS . "class.admin.catalogue.php";
			$catalogue = ( isset($_POST['catalogue']) && ($_POST['catalogue']) != '' ) ? $_POST['catalogue'] : "";
			if ( $catalogue != '' ){
				$id = ( isset($_POST['id']) && is_numeric($_POST['id']) && $_POST['id'] > 0 ) ? $_POST['id'] : 0;
				if ( $id >  0 ){
					$cat = new CatalogueAdmin( $catalogue, $id );
					$response['info'] = $cat->get_array();
					if ( count($cat->error) > 0 ){
						$response['error'] = $cat->get_errors(); 
					} else {
						$response['success'] = TRUE;
					}
				} else{
					$response['error'] = "Invalid id.";
				} 
			} else{
				$response['error'] = "Invalid catalogue.";
			} 
			break;
		case 'is_unique_catalogue': 
			global $Validate;
			$id 		= $_POST['id']; 
			$value		= $_POST['value']; 
			$catalogue 	= $_POST['catalogue']; 
			$id			= ( !is_numeric($id) ) ? 0 : $id;

			require_once DIRECTORY_CLASS . "class.admin.catalogue.php";
			$cat = new CatalogueAdmin($catalogue);
			
			$response['unique']  = $Validate->is_unique( $catalogue, $cat-> get_column(), $value, 'id_'.$catalogue, $id );
			$response['success'] = TRUE; 
			break;
		case 'delete_catalogue_element':
			require_once DIRECTORY_CLASS . "class.admin.catalogue.php";
			$catalogue = ( isset($_POST['catalogue']) && ($_POST['catalogue']) != '' ) ? $_POST['catalogue'] : "";
			if ( $catalogue != '' ){
				$id = ( isset($_POST['id']) && is_numeric($_POST['id']) && $_POST['id'] > 0 ) ? $_POST['id'] : 0; 
				if ( $id >  0 ){ 
					$cat = new CatalogueAdmin( $catalogue, $id );  
					$resp = $cat->delete();
					if ( !$resp || count($cat->error) > 0 ){
						$response['error'] 	= $cat->get_errors(); 
					} else {
						$response['success'] = TRUE;
					}
				} else{
					$response['error'] = "Invalid id.";
				} 
			} else{
				$response['error'] = "Invalid catalogue.";
			} 
			break;
		default: 
			$response['error'] = "Invalid action.";
			break;
	}
} else {
	$response['error'] = "Restricted access.";
}
?>