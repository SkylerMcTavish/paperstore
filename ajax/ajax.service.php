<?php 
global $response, $Session; 
require_once DIRECTORY_CLASS . "class.admin.service.php"; 
switch ( $action )
{
	case 'add_service_product': 
		$id_service = ( isset($_POST['id_service']) && is_numeric($_POST['id_service']) && $_POST['id_service'] > 0 ) ? $_POST['id_service'] : 0;
		$id_product = ( isset($_POST['id_product']) && is_numeric($_POST['id_product']) && $_POST['id_product'] > 0 ) ? $_POST['id_product'] : 0;
		if ( $id_service > 0 )
		{
			if($id_product > 0)
			{
				$Service = new AdminService($id_service);
				$Service->asign_product($id_product);
				$Service->save();
				$Service->set_products();
				$response['html'] = $Service->get_list_html();
				
				if ( count( $Service->error ) > 0 )
				{
					$response['error'] = $Service->get_errors(); 
				}
				else
				{
					$response['success'] = TRUE;
				}
			}
			else
			{
				$response['error'] = "Invalid product. [$id_product]";
			}
		}
		else
		{
			$response['error'] = "Invalid service. [$id_service]";
		} 
	break;
	
	case 'delete_service_product':
		$id_service = ( isset($_POST['id_service']) && is_numeric($_POST['id_service']) && $_POST['id_service'] > 0 ) ? $_POST['id_service'] : 0;
		$id_product = ( isset($_POST['id_product']) && is_numeric($_POST['id_product']) && $_POST['id_product'] > 0 ) ? $_POST['id_product'] : 0;
		if ( $id_service > 0 )
		{
			if($id_product > 0)
			{
				$Service = new AdminService($id_service);
				$Service->delete_product($id_product);
				$Service->set_products();
				$response['html'] = $Service->get_list_html();
				
				if ( count( $Service->error ) > 0 )
				{
					$response['error'] = $Service->get_errors(); 
				}
				else
				{
					$response['success'] = TRUE;
				}
			}
			else
			{
				$response['error'] = "Invalid product. [$id_product]";
			}
		}
		else
		{
			$response['error'] = "Invalid service. [$id_service]";
		} 
	break;
	
	case 'info_service':
		$id_service = ( isset($_POST['id_service']) && is_numeric($_POST['id_service']) && $_POST['id_service'] > 0 ) ? $_POST['id_service'] : 0;
		if ( $id_service > 0 )
		{
			require_once DIRECTORY_CLASS . "class.service.php"; 
			$Service = new Service($id_service);
			$response['info'] = $Service->get_array();
			
			if ( count( $Service->error ) > 0 )
			{
				$response['error'] = $Service->get_errors(); 
			}
			else
			{
				$response['success'] = TRUE;
			}
		}
		else
		{
			$response['error'] = "Invalid service. [$id_service]";
		}
	break;
	
	case 'delete_service':
		$id_service = ( isset($_POST['id_service']) && is_numeric($_POST['id_service']) && $_POST['id_service'] > 0 ) ? $_POST['id_service'] : 0;
		if ( $id_service > 0 )
		{
			$Service = new AdminService($id_service);
			$Service->delete();
			
			if ( count( $Service->error ) > 0 )
			{
				$response['error'] = $Service->get_errors(); 
			}
			else
			{
				$response['success'] = TRUE;
			}
		}
		else
		{
			$response['error'] = "Invalid service. [$id_service]";
		}
	break;
	
	
	default:
		$response['error'] = "Invalid action.";
	break;
}
?>