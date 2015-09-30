<?php 
global $response, $Session; 
require_once DIRECTORY_CLASS . "class.sell.php";

if ( $Session->is_admin() )
{
	switch ( $action ){ 
		case 'register_sell': 
				
			if ( !$resp || count($cgf->error) > 0 )
			{
				$response['error'] 	= $cgf->get_errors(); 
			}
			else
			{
				$response['success'] = TRUE;
			}
				
		break; 
			
		default:
			$response['error'] = "Invalid action.";
		break;
	}
	
} else {
	$response['error'] = "Restricted action.";
}
?>