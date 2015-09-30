<?php 
global $response, $Session; 
if ( $Session->is_admin() ){
	require_once DIRECTORY_CLASS . "class.supplier.php";
	switch ( $action ){
	
		case 'is_unique_supplier': 
			global $Validate;
			$id_supplier = $_POST['id_supplier'];
			$su_supplier = $_POST['supplier']; 
			$id_supplier = ( !is_numeric($id_supplier) ) ? 0 : $id_supplier; 
			$response['unique']  = $Validate->is_unique( 'supplier', 'su_supplier', $su_supplier, 'id_supplier', $id_supplier );
			$response['success'] = TRUE; 
			
			break;
			
		case 'get_branch_info':
			$id_supplier = ( isset($_POST['id_supplier']) && is_numeric($_POST['id_supplier']) && $_POST['id_supplier'] > 0 ) ? $_POST['id_supplier'] : 0;
			$id_branch = ( isset($_POST['id_branch']) && is_numeric($_POST['id_branch']) && $_POST['id_branch'] > 0 ) ? $_POST['id_branch'] : 0;
			if ( $id_supplier > 0 && $id_branch > 0 ){
				$Supplier = new Supplier( $id_supplier );
				$response['info'] = $Supplier->get_array();
				if ( count( $Supplier->error ) > 0 ){
					$response['error'] = $Supplier->get_errors(); 
				} else {
					$resp = new stdClass;
					$resp->id_branch  = 0;
					$resp->branch 	  = "";
					$resp->num		  = "";  
					foreach ($Supplier->branches as $k => $br) {
						if ( $br->id_branch == $id_branch ){
							$resp = $br;
						}
					}
					$resp->id_supplier = $id_supplier;
					$response['info'] = $resp;
					$response['success'] = TRUE;
				}
			} else{
				$response['error'] = "Invalid data.";
			} 
			break;
		case 'delete_branch': 
			$id_branch = ( isset($_POST['id_branch']) && is_numeric($_POST['id_branch']) && $_POST['id_branch'] > 0 ) ? $_POST['id_branch'] : 0;
			if ( $id_branch > 0 ){
				$Supplier = new Supplier( 0 );
				$resp = $Supplier->delete_branch( $id_branch );
				if ( !$resp || count($Supplier->error) > 0 ){
					$response['error'] 	= $Supplier->get_errors(); 
				} else {
					$response['success'] = TRUE;
				}
			} else{
				$response['error'] = "Invalid supplier.";
			} 
			break; 
		case 'delete_supplier': 
			$id_supplier = ( isset($_POST['id_supplier']) && is_numeric($_POST['id_supplier']) && $_POST['id_supplier'] > 0 ) ? $_POST['id_supplier'] : 0;
			if ( $id_supplier > 0 ){
				$Supplier = new Supplier( $id_supplier );
				$resp = $Supplier->delete();
				if ( !$resp || count($Supplier->error) > 0 ){
					$response['error'] 	= $Supplier->get_errors();
				} else {
					$response['success'] = TRUE;
				}
			} else{
				$response['error'] = "Invalid supplier.";
			} 
			break; 
		case 'get_supplier_info':  
			$id_supplier = ( isset($_POST['id_supplier']) && is_numeric($_POST['id_supplier']) && $_POST['id_supplier'] > 0 ) ? $_POST['id_supplier'] : 0;
			if ( $id_supplier > 0 ){
				$Supplier = new Supplier( $id_supplier );
				$response['info'] = $Supplier->get_array();
				if ( count( $Supplier->error ) > 0 ){
					$response['error'] = $Supplier->get_errors(); 
				} else {
					$response['success'] = TRUE;
				}
			} else{
				$response['error'] = "Invalid supplier.";
			} 
			break;
		case 'get_supplier_info_html': 
			$id_supplier = ( isset($_POST['id_supplier']) && is_numeric($_POST['id_supplier']) && $_POST['id_supplier'] > 0 ) ? $_POST['id_supplier'] : 0;
			if ( $id_supplier > 0 ){
				$Supplier = new Supplier( $id_supplier ); 
				$response['html'] = $Supplier->get_info_html( );
				if ( count( $Supplier->error ) > 0 ){
					$response['error'] = $Supplier->get_errors(); 
				} else {
					$response['success'] = TRUE;
				}
			} else{
				$response['error'] = "Invalid supplier.";
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