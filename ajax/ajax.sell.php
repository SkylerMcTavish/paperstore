<?php 
global $response, $Session; 
require_once DIRECTORY_CLASS . "class.sell.php"; 
switch ( $action )
{
	case 'get_sell_info_html': 
		$id_sell = ( isset($_POST['id_sell']) && is_numeric($_POST['id_sell']) && $_POST['id_sell'] > 0 ) ? $_POST['id_sell'] : 0;
		if ( $id_sell > 0 )
		{
			$Sell = new Sell( $id_sell ); 
			$response['html'] = $Sell->get_info_html( );
			if ( count( $Sell->error ) > 0 )
			{
				$response['error'] = $Sell->get_errors(); 
			}
			else
			{
				$response['success'] = TRUE;
			}
		}
		else
		{
			$response['error'] = "Invalid sell. [$id_sell]";
		} 
	break;
	
	case 'get_sell_info_product':
		$id_product = ( isset($_POST['id_product']) && is_numeric($_POST['id_product']) && $_POST['id_product'] > 0 ) ? $_POST['id_product'] : 0;
		if ( $id_product > 0 )
		{
			require_once DIRECTORY_CLASS . "class.product.php"; 
			$Product = new Product( $id_product ); 
			$response['info'] = $Product->get_sale_info( );
			if ( count( $Product->error ) > 0 )
			{
				$response['error'] = $Product->get_errors(); 
			}
			else
			{
				$response['success'] = TRUE;
			}
		}
		else
		{
			$response['error'] = "Invalid Product. [$id_product]";
		}
	break;
	
	case 'add_product_sell':
		$id_sell = ( isset($_POST['id_sell']) && is_numeric($_POST['id_sell']) && $_POST['id_sell'] > 0 ) ? $_POST['id_sell'] : 0;
		$id_product = ( isset($_POST['id_product']) && is_numeric($_POST['id_product']) && $_POST['id_product'] > 0 ) ? $_POST['id_product'] : 0;
		$id_stock = ( isset($_POST['id_stock']) && is_numeric($_POST['id_stock']) && $_POST['id_stock'] > 0 ) ? $_POST['id_stock'] : 0;
		
		$price = ( isset($_POST['price']) ) ? trim(str_replace('$', "", $_POST['price'] )): 0;
		$quantity = ( isset($_POST['quantity']) && is_numeric($_POST['quantity']) && $_POST['quantity'] > 0 ) ? $_POST['quantity'] : 0;
		if ( $id_sell > 0 )
		{
			require_once DIRECTORY_CLASS . "class.admin.sell.php"; 
			$Sell = new AdminSell( $id_sell );
			
			$det = array();
			$det['id_detail']	= 0;
			$det['id_product']	= $id_product;
			$det['id_stock']	= $id_stock;
			$det['quantity']	= $quantity;
			$det['price']		= $price;
			
			$Sell->details[] = $det;
			$Sell->save_detail();
			$Sell->set_detail();
			
			$response['html'] = $Sell->get_sell_detail_html( );
			if ( count( $Sell->error ) > 0 )
			{
				$response['error'] = $Sell->get_errors(); 
			}
			else
			{
				$response['success'] = TRUE;
			}
		}
		else
		{
			$response['error'] = "Invalid sell. [$id_sell]";
		} 
	break;
	
	case 'edit_product_sell':
		$id_sell = ( isset($_POST['id_sell']) && is_numeric($_POST['id_sell']) && $_POST['id_sell'] > 0 ) ? $_POST['id_sell'] : 0;
		$id_detail = ( isset($_POST['id_detail']) && is_numeric($_POST['id_detail']) && $_POST['id_detail'] > 0 ) ? $_POST['id_detail'] : 0;
		
		$quantity = ( isset($_POST['quantity']) && is_numeric($_POST['quantity']) && $_POST['quantity'] > 0 ) ? $_POST['quantity'] : 0;
		if ( $id_sell > 0 )
		{
			require_once DIRECTORY_CLASS . "class.admin.sell.php"; 
			$Sell = new AdminSell( $id_sell );
			
			$Sell->update_detail($id_detail, $quantity);
			$Sell->save_detail();
			$Sell->set_detail();
			
			$response['html'] = $Sell->get_sell_detail_html( );
			if ( count( $Sell->error ) > 0 )
			{
				$response['error'] = $Sell->get_errors(); 
			}
			else
			{
				$response['success'] = TRUE;
			}
		}
		else
		{
			$response['error'] = "Invalid sell. [$id_sell]";
		} 
	break;
	
	case 'delete_product_sell':
		$id_sell = ( isset($_POST['id_sell']) && is_numeric($_POST['id_sell']) && $_POST['id_sell'] > 0 ) ? $_POST['id_sell'] : 0;
		$id_detail = ( isset($_POST['id_detail']) && is_numeric($_POST['id_detail']) && $_POST['id_detail'] > 0 ) ? $_POST['id_detail'] : 0;
		
		if ( $id_sell > 0 )
		{
			require_once DIRECTORY_CLASS . "class.admin.sell.php"; 
			$Sell = new AdminSell( $id_sell );
			
			$Sell->delete_detail($id_detail);
			$Sell->set_detail();
			$Sell->save_detail();
			$Sell->set_detail();
			
			$response['html'] = $Sell->get_sell_detail_html( );
			if ( count( $Sell->error ) > 0 )
			{
				$response['error'] = $Sell->get_errors(); 
			}
			else
			{
				$response['success'] = TRUE;
			}
		}
		else
		{
			$response['error'] = "Invalid sell. [$id_sell]";
		} 
	break;
	
	case 'confirm_sell':
		$id_sell = ( isset($_POST['id_sell']) && is_numeric($_POST['id_sell']) && $_POST['id_sell'] > 0 ) ? $_POST['id_sell'] : 0;
		
		if ( $id_sell > 0 )
		{
			require_once DIRECTORY_CLASS . "class.admin.sell.php"; 
			$Sell = new AdminSell( $id_sell );
			
			$Sell->save_detail();
			$Sell->set_detail();
			$Sell->confirm();
			
			$response['html'] = $Sell->get_sell_detail_html( );
			if ( count( $Sell->error ) > 0 )
			{
				$response['error'] = $Sell->get_errors(); 
			}
			else
			{
				$response['success'] = TRUE;
			}
		}
		else
		{
			$response['error'] = "Invalid sell. [$id_sell]";
		} 
	break;
	
	case 'cancel_sell':
		$id_sell = ( isset($_POST['id_sell']) && is_numeric($_POST['id_sell']) && $_POST['id_sell'] > 0 ) ? $_POST['id_sell'] : 0;
		
		if ( $id_sell > 0 )
		{
			require_once DIRECTORY_CLASS . "class.admin.sell.php"; 
			$Sell = new AdminSell( $id_sell );
			$Sell->cancel();
			
			if ( count( $Sell->error ) > 0 )
			{
				$response['error'] = $Sell->get_errors(); 
			}
			else
			{
				$response['success'] = TRUE;
			}
		}
		else
		{
			$response['error'] = "Invalid sell. [$id_sell]";
		} 
	break;
	
	case 'search_product':
		$search = ( isset($_POST['search']) && $_POST['search'] != '' ) ? $_POST['search'] : '';
		if ( $search != '' )
		{
			require_once DIRECTORY_CLASS . "class.paperstore.php"; 
			$report = new Paperstore();
			$response['html'] = $report->search_product( $search );
			
			if ( count( $report->error ) > 0 )
			{
				$response['error'] = $report->get_errors(); 
			}
			else
			{
				$response['success'] = TRUE;
			}
		}
		else
		{
			$response['error'] = "Invalid product. [$search]";
		} 
	break;
	
	default:
		$response['error'] = "Invalid action.";
	break;
}
?>