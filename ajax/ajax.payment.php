<?php 
global $response, $Session; 
require_once DIRECTORY_CLASS . "class.payment.php"; 
switch ( $action )
{  
	
	case 'get_payment_info_html': 
		$id_payment = ( isset($_POST['id_payment']) && is_numeric($_POST['id_payment']) && $_POST['id_payment'] > 0 ) ? $_POST['id_payment'] : 0;
		
		if ( $id_payment > 0 )
		{
			$payment = new Payment( $id_payment ); 
			$response['html'] = $payment->get_info_html( );
			
			if ( count( $payment->error ) > 0 )
			{
				$response['error'] = $payment->get_errors(); 
			}
			else
			{
				$response['success'] = TRUE;
			}
		}
		else
		{
			$response['error'] = "Invalid payment.";
		} 
	break;
		
	default:
		$response['error'] = "Invalid action.";
	break;
}
?>