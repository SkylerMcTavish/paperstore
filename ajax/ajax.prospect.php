<?php 
global $response;
require_once DIRECTORY_CLASS . "class.prospect.php"; 
switch ( $action )
{  
	case 'get_prospect_info_html': 
		$id_prospect = ( isset($_POST['id_prospect']) && is_numeric($_POST['id_prospect']) && $_POST['id_prospect'] > 0 ) ? $_POST['id_prospect'] : 0;
		if ( $id_prospect > 0 )
		{
			$prospect = new Prospect( $id_prospect ); 
			$response['html'] = $prospect->get_info_html( );
			if ( count( $prospect->error ) > 0 )
			{
				$response['error'] = $prospect->get_errors(); 
			}
			else
			{
				$response['success'] = TRUE;
			}
		}
		else
		{
			$response['error'] = "Invalid prospect.";
		} 
		break;
	default:
		$response['error'] = "Invalid action.";
			break;
}
?>