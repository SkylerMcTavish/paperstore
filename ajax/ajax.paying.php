<?php 
global $response, $Session; 
require_once DIRECTORY_CLASS . "class.paying.php"; 
switch ( $action )
{  
	case 'get_paying_info_html': 
		$id_user = ( isset($_POST['id_user']) && is_numeric($_POST['id_user']) && $_POST['id_user'] > 0 ) ? $_POST['id_user'] : 0;
		$date = ( isset($_POST['date']) && $_POST['date'] != '' ) ? $_POST['date'] : '';
		if ( $id_user > 0 && $date != '' )
		{
			$paying = new Paying( $id_user, $date ); 
			$response['html'] = $paying->get_list_html( TRUE );
			if ( count( $paying->error ) > 0 )
			{
				$response['error'] = $paying->get_errors(); 
			}
			else
			{
				$response['success'] = TRUE;
			}
		}
		else
		{
			$response['error'] = "Invalid parameters.";
		} 
	break;
	
	default:
		$response['error'] = "Invalid action.";
	break;
}
?>