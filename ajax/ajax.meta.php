<?php 
global $response; 
global $Session;
global $Settings;

switch ( $action ){
	/**********************************
	 * CONTACT
	 **********************************/
	case 'get_contact_option':
		if ( $_POST['id_contact_option'] && $_POST['id_contact_option'] > 0 ){
			$id_contact_option = $_POST['id_contact_option'];
			
			require_once DIRECTORY_CLASS . "class.contact_meta.php";
			$contact_meta = new ContactMeta();
			$option = $contact_meta->get_option( $id_contact_option );
			if ( $option ){
				$response['message'] = "OK";
				$response['info'] 	 = $option;
				$response['success'] = TRUE;
			} else {
				$response['error'] = "Option not found.";
			}
		} else {
			$response['error'] = "Invalid parameters.";
		}
		break;
	case 'save_contact_option':
		if ( $_POST['id_contact_option'] && $_POST['id_contact_option'] > 0 ){
			$id_contact_option = $_POST['id_contact_option'];
		} else $id_contact_option = 0;
		
		$valid = TRUE;
		$option = new stdClass;
		$option->id_option = $id_contact_option;
		
		if ( $_POST['label'] && $_POST['label'] != '' ){
			$option->label = $_POST['label'];
		} else {
			$valid = FALSE;
			$response['error'] = "Etiqueta inválida.";
		} 
		if ( $_POST['id_data_type'] && $_POST['id_data_type'] > 0 ){
			$option->id_data_type = $_POST['id_data_type'];
		} else {
			$valid = FALSE;
			$response['error'] = "Tipo de dato inválido.";
		}  
		if ( $_POST['options'] && $_POST['options'] != '' ){
			$option->options = $_POST['options'];
		} 

		if ( $valid ){
			require_once DIRECTORY_CLASS . "class.contact_meta.php";
			$contact_meta = new ContactMeta();
			$resp = $contact_meta->save_option( $option );
			if ( $resp ){
				$contact_meta = new ContactMeta();
				$response['message'] = "OK";
				ob_start();
				$contact_meta->get_list_html( TRUE );
				$response['html'] 	 = ob_get_clean(); 
				$response['success'] = TRUE;
			} else {
				$response['error'] = "Error al guardar la información: " . $contact_meta->get_errors();
			}
		}
		
		break;
	case 'delete_contact_option':
		if ( $Session->is_admin() ){
			if ( $_POST['id_contact_option'] && $_POST['id_contact_option'] > 0 ){
				$id_contact_option = $_POST['id_contact_option'];
				
				require_once DIRECTORY_CLASS . "class.contact_meta.php";
				$contact_meta = new ContactMeta();
				$option = $contact_meta->delete_option( $id_contact_option );
				if ( $option ){
					$contact_meta = new ContactMeta();
					$response['message'] = "OK";
					ob_start();
					$contact_meta->get_list_html( TRUE );
					$response['html'] 	 = ob_get_clean(); 
					$response['success'] = TRUE;
				} else {
					$response['error'] = "Error al guardar la información: " . $contact_meta->get_errors();
				}
			} else {
				$response['error'] = "Invalid parameters.";
			}
		}else {
			$response['error'] = "Restricted action.";
		} 
		break;
		
	/**********************************
	 * PRODUCT
	 **********************************/
	case 'get_product_option':
		if ( $_POST['id_product_option'] && $_POST['id_product_option'] > 0 ){
			$id_product_option = $_POST['id_product_option'];
			
			require_once DIRECTORY_CLASS . "class.product_meta.php";
			$product_meta = new ProductMeta();
			$option = $product_meta->get_option( $id_product_option );
			if ( $option ){
				$response['message'] = "OK";
				$response['info'] 	 = $option;
				$response['success'] = TRUE;
			} else {
				$response['error'] = "Option not found.";
			}
		} else {
			$response['error'] = "Invalid parameters.";
		}
		break;
	case 'save_product_option':
		if ( $_POST['id_product_option'] && $_POST['id_product_option'] > 0 ){
			$id_product_option = $_POST['id_product_option'];
		} else $id_product_option = 0;
		
		$valid = TRUE;
		$option = new stdClass;
		$option->id_option = $id_product_option;
		
		if ( $_POST['label'] && $_POST['label'] != '' ){
			$option->label = $_POST['label'];
		} else {
			$valid = FALSE;
			$response['error'] = "Etiqueta inválida.";
		} 
		if ( $_POST['id_data_type'] && $_POST['id_data_type'] > 0 ){
			$option->id_data_type = $_POST['id_data_type'];
		} else {
			$valid = FALSE;
			$response['error'] = "Tipo de dato inválido.";
		}  
		if ( $_POST['options'] && $_POST['options'] != '' ){
			$option->options = $_POST['options'];
		} 

		if ( $valid ){
			require_once DIRECTORY_CLASS . "class.product_meta.php";
			$product_meta = new ProductMeta();
			$resp = $product_meta->save_option( $option );
			if ( $resp ){
				$product_meta = new ProductMeta();
				$response['message'] = "OK";
				ob_start();
				$product_meta->get_list_html( TRUE );
				$response['html'] 	 = ob_get_clean(); 
				$response['success'] = TRUE;
			} else {
				$response['error'] = "Error al guardar la información: " . $product_meta->get_errors();
			}
		}
		
		break;
	case 'delete_product_option':
		if ( $Session->is_admin() ){
			if ( $_POST['id_product_option'] && $_POST['id_product_option'] > 0 ){
				$id_product_option = $_POST['id_product_option'];
				
				require_once DIRECTORY_CLASS . "class.product_meta.php";
				$product_meta = new ProductMeta();
				$option = $product_meta->delete_option( $id_product_option );
				if ( $option ){
					$product_meta = new ProductMeta();
					$response['message'] = "OK";
					ob_start();
					$product_meta->get_list_html( TRUE );
					$response['html'] 	 = ob_get_clean(); 
					$response['success'] = TRUE;
				} else {
					$response['error'] = "Error al guardar la información: " . $product_meta->get_errors();
				}
			} else {
				$response['error'] = "Invalid parameters.";
			}
		}else {
			$response['error'] = "Restricted action.";
		} 
		break;
		
		
	/**********************************
	 * PDV
	 **********************************/
	case 'get_pdv_option':
		if ( $_POST['id_pdv_option'] && $_POST['id_pdv_option'] > 0 ){
			$id_pdv_option = $_POST['id_pdv_option'];
			
			require_once DIRECTORY_CLASS . "class.pdv_meta.php";
			$pdv_meta = new PDVMeta();
			$option = $pdv_meta->get_option( $id_pdv_option );
			if ( $option ){
				$response['message'] = "OK";
				$response['info'] 	 = $option;
				$response['success'] = TRUE;
			} else {
				$response['error'] = "Option not found.";
			}
		} else {
			$response['error'] = "Invalid parameters.";
		}
		break;
	case 'save_pdv_option':
		if ( $_POST['id_pdv_option'] && $_POST['id_pdv_option'] > 0 ){
			$id_pdv_option = $_POST['id_pdv_option'];
		} else $id_pdv_option = 0;
		
		$valid = TRUE;
		$option = new stdClass;
		$option->id_option = $id_pdv_option;
		
		if ( $_POST['label'] && $_POST['label'] != '' ){
			$option->label = $_POST['label'];
		} else {
			$valid = FALSE;
			$response['error'] = "Etiqueta inválida.";
		} 
		if ( $_POST['id_data_type'] && $_POST['id_data_type'] > 0 ){
			$option->id_data_type = $_POST['id_data_type'];
		} else {
			$valid = FALSE;
			$response['error'] = "Tipo de dato inválido.";
		}  
		if ( $_POST['options'] && $_POST['options'] != '' ){
			$option->options = $_POST['options'];
		} 

		if ( $valid ){
			require_once DIRECTORY_CLASS . "class.pdv_meta.php";
			$pdv_meta = new PDVMeta();
			$resp = $pdv_meta->save_option( $option );
			if ( $resp ){
				$pdv_meta = new PDVMeta();
				$response['message'] = "OK";
				ob_start();
				$pdv_meta->get_list_html( TRUE );
				$response['html'] 	 = ob_get_clean(); 
				$response['success'] = TRUE;
			} else {
				$response['error'] = "Error al guardar la información: " . $pdv_meta->get_errors();
			}
		}
		
		break;
	case 'delete_pdv_option':
		if ( $Session->is_admin() ){
			if ( $_POST['id_pdv_option'] && $_POST['id_pdv_option'] > 0 ){
				$id_pdv_option = $_POST['id_pdv_option'];
				
				require_once DIRECTORY_CLASS . "class.pdv_meta.php";
				$pdv_meta = new PDVMeta();
				$option = $pdv_meta->delete_option( $id_pdv_option );
				if ( $option ){
					$pdv_meta = new PDVMeta();
					$response['message'] = "OK";
					ob_start();
					$pdv_meta->get_list_html( TRUE );
					$response['html'] 	 = ob_get_clean(); 
					$response['success'] = TRUE;
				} else {
					$response['error'] = "Error al guardar la información: " . $pdv_meta->get_errors();
				}
			} else {
				$response['error'] = "Invalid parameters.";
			}
		}else {
			$response['error'] = "Restricted action.";
		} 
		break;
	default:
		$response['error'] = "Invalid action.";
		break;
} 
?>