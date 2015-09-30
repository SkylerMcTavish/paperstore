<?php 
global $response, $Session; 
require_once DIRECTORY_CLASS . "class.product.php"; 
switch ( $action ){  
	case 'get_brand_info':  
		$id_brand = ( isset($_POST['id_brand']) && is_numeric($_POST['id_brand']) && $_POST['id_brand'] > 0 ) ? $_POST['id_brand'] : 0;
		if ( $id_brand > 0 ){
			require_once DIRECTORY_CLASS . "class.bafa.php";
			$bafa = new BAFA( );
			$response['info'] = $bafa->get_brand( $id_brand );
			if ( count( $bafa->error ) > 0 ){
				$response['error'] = $bafa->get_errors(); 
			} else {
				$response['success'] = TRUE;
			}
		} else{
			$response['error'] = "Invalid brand.";
		} 
		break;
	case 'get_family_info':  
		$id_family = ( isset($_POST['id_family']) && is_numeric($_POST['id_family']) && $_POST['id_family'] > 0 ) ? $_POST['id_family'] : 0;
		if ( $id_family > 0 ){
			require_once DIRECTORY_CLASS . "class.bafa.php";
			$bafa = new BAFA( );
			$response['info'] = $bafa->get_family( $id_family );
			if ( count( $bafa->error ) > 0 ){
				$response['error'] = $bafa->get_errors();
			} else {
				$response['success'] = TRUE;
			}
		} else{
			$response['error'] = "Invalid family.";
		} 
		break; 
	case 'get_product_info_html': 
		$id_product = ( isset($_POST['id_product']) && is_numeric($_POST['id_product']) && $_POST['id_product'] > 0 ) ? $_POST['id_product'] : 0;
		if ( $id_product > 0 ){
			$product = new Product( $id_product ); 
			$response['html'] = $product->get_info_html( );
			if ( count( $product->error ) > 0 ){
				$response['error'] = $product->get_errors(); 
			} else {
				$response['success'] = TRUE;
			}
		} else{
			$response['error'] = "Invalid product.";
		} 
		break;
	default:
		$response['error'] = "Invalid action.";
			break;
}
?>