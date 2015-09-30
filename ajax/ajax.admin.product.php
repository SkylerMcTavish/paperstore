<?php
ini_set('display_errors' , TRUE);
global $response, $Session; 
require_once DIRECTORY_CLASS . "class.admin.product.php";
switch ( $action ){  
	case 'save_price':  
		$id_product = ( isset($_POST['id_product']) && is_numeric($_POST['id_product']) && $_POST['id_product'] > 0 ) ? $_POST['id_product'] + 0 : 0;
		if ( $id_product > 0 ){
			$product = new AdminProduct( $id_product ); 
			
			$price = new stdClass;
			$price->price = ( isset($_POST['price']) && is_numeric($_POST['price']) && $_POST['price'] > 0 ) ? $_POST['price'] + 0 : 0;
			$price->units = ( isset($_POST['units']) && is_numeric($_POST['units']) && $_POST['units'] > 0 ) ? $_POST['units'] + 0 : 0;
			$price->id_product_presentation = ( isset($_POST['id_product_presentation']) && is_numeric($_POST['id_product_presentation']) && $_POST['id_product_presentation'] > 0 ) 
								? $_POST['id_product_presentation'] + 0 : 0;
			$resp = $product->save_price( $price );
			if ( count( $product->error ) > 0 ){
				$response['error'] = $product->get_errors(); 
			} else {
				$response['html'] = $product->get_prices_frm_lst();
				$response['success'] = TRUE;
			}
		} else{
			$response['error'] = "Invalid product.";
		} 
		break;
	case 'save_supplier_code':   
		$id_product = ( isset($_POST['id_product']) && is_numeric($_POST['id_product']) && $_POST['id_product'] > 0 ) ? $_POST['id_product'] : 0;
		if ( $id_product > 0 ){ 
			$product = new AdminProduct( $id_product );  
			$code = new stdClass; 
			$code->code 		= ( isset($_POST['code']) && $_POST['code'] != "" ) ? $_POST['code'] : "";
			$code->id_supplier = ( isset($_POST['id_supplier']) && is_numeric($_POST['id_supplier']) && $_POST['id_supplier'] > 0 ) ? $_POST['id_supplier'] : 0;
			
			$resp = $product->save_supplier_code( $code );
			if ( count( $product->error ) > 0 ){
				$response['error'] = $product->get_errors(); 
			} else {
				$response['html'] = $product->get_supplier_codes_frm_lst();
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