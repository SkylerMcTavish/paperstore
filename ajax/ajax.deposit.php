<?php 
global $response, $Session; 
require_once DIRECTORY_CLASS . "class.deposit.php"; 
switch ( $action )
{  
	
	case 'get_deposit_info_html': 
		$id_deposit = ( isset($_POST['id_deposit']) && is_numeric($_POST['id_deposit']) && $_POST['id_deposit'] > 0 ) ? $_POST['id_deposit'] : 0;
		
		if ( $id_deposit > 0 )
		{
			$deposit = new Deposit( $id_deposit ); 
			$response['html'] = $deposit->get_info_html( );
			
			if ( count( $deposit->error ) > 0 )
			{
				$response['error'] = $deposit->get_errors(); 
			}
			else
			{
				$response['success'] = TRUE;
			}
		}
		else
		{
			$response['error'] = "Invalid deposit.";
		} 
	break;
		
	default:
		$response['error'] = "Invalid action.";
	break;
}
?>