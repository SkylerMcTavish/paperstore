<?php 
global $response, $Session; 
require_once DIRECTORY_CLASS . "class.pdv.php"; 
switch ( $action ){  
	case 'get_channel_info':  
		$id_channel = ( isset($_POST['id_channel']) && is_numeric($_POST['id_channel']) && $_POST['id_channel'] > 0 ) ? $_POST['id_channel'] : 0;
		if ( $id_channel > 0 ){
			require_once DIRECTORY_CLASS . "class.cgf.php";
			$cgf = new CGF( );
			$response['info'] = $cgf->get_channel( $id_channel );
			if ( count( $cgf->error ) > 0 ){
				$response['error'] = $cgf->get_errors(); 
			} else {
				$response['success'] = TRUE;
			}
		} else{
			$response['error'] = "Invalid channel.";
		} 
		break;
	case 'get_group_info':  
		$id_group = ( isset($_POST['id_group']) && is_numeric($_POST['id_group']) && $_POST['id_group'] > 0 ) ? $_POST['id_group'] : 0;
		if ( $id_group > 0 ){
			require_once DIRECTORY_CLASS . "class.cgf.php";
			$cgf = new CGF( );
			$response['info'] = $cgf->get_group( $id_group );
			if ( count( $cgf->error ) > 0 ){
				$response['error'] = $cgf->get_errors(); 
			} else {
				$response['success'] = TRUE;
			}
		} else{
			$response['error'] = "Invalid group.";
		} 
		break;
	case 'get_format_info':  
		$id_format = ( isset($_POST['id_format']) && is_numeric($_POST['id_format']) && $_POST['id_format'] > 0 ) ? $_POST['id_format'] : 0;
		if ( $id_format > 0 ){
			require_once DIRECTORY_CLASS . "class.cgf.php";
			$cgf = new CGF( );
			$response['info'] = $cgf->get_format( $id_format );
			if ( count( $cgf->error ) > 0 ){
				$response['error'] = $cgf->get_errors(); 
			} else {
				$response['success'] = TRUE;
			}
		} else{
			$response['error'] = "Invalid format.";
		} 
		break;
	case 'get_pdv_info':  
		$id_pdv = ( isset($_POST['id_pdv']) && is_numeric($_POST['id_pdv']) && $_POST['id_pdv'] > 0 ) ? $_POST['id_pdv'] : 0;
		if ( $id_pdv > 0 ){
			$pdv = new PDV( $id_pdv );
			$response['info'] = $pdv->get_array();
			if ( count( $pdv->error ) > 0 ){
				$response['error'] = $pdv->get_errors(); 
			} else {
				$response['success'] = TRUE;
			}
		} else{
			$response['error'] = "Invalid pdv.";
		} 
		break;
	case 'get_pdv_info_html': 
		$id_pdv = ( isset($_POST['id_pdv']) && is_numeric($_POST['id_pdv']) && $_POST['id_pdv'] > 0 ) ? $_POST['id_pdv'] : 0;
		if ( $id_pdv > 0 ){
			$pdv = new PDV( $id_pdv ); 
			$response['html'] = $pdv->get_info_html( );
			if ( count( $pdv->error ) > 0 ){
				$response['error'] = $pdv->get_errors(); 
			} else {
				$response['success'] = TRUE;
			}
		} else{
			$response['error'] = "Invalid pdv.";
		} 
		break;
	case 'is_channel_unique':
		if( isset($_POST['channel']) && $_POST['channel'] != '' )
		{
			global $Validate;
			
		}
		break;
	
	default:
		$response['error'] = "Invalid action.";
			break;
}
?>