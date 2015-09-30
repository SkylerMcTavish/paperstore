<?php 
global $response, $Session; 
require_once DIRECTORY_CLASS . "class.pdv.php";
if ( $Session->is_admin() ){
	switch ( $action ){ 
		case 'delete_channel': 
				$id_channel = ( isset($_POST['id_channel']) && is_numeric($_POST['id_channel']) && $_POST['id_channel'] > 0 ) ? $_POST['id_channel'] : 0;
				if ( $id_channel > 0 ){
					require_once DIRECTORY_CLASS . "class.cgf.php";
					$cgf = new CGF( );
					$resp = $cgf->delete_channel( $id_channel );
					if ( !$resp || count($cgf->error) > 0 ){
						$response['error'] 	= $cgf->get_errors(); 
					} else {
						$response['success'] = TRUE;
					}
				} else{
					$response['error'] = "Invalid channel.";
				} 
			break; 
		case 'delete_group': 
			if ( $Session->is_admin() ){
				$id_group = ( isset($_POST['id_group']) && is_numeric($_POST['id_group']) && $_POST['id_group'] > 0 ) ? $_POST['id_group'] : 0;
				if ( $id_group > 0 ){
					require_once DIRECTORY_CLASS . "class.cgf.php";
					$cgf = new CGF( );
					$resp = $cgf->delete_group( $id_group );
					if ( !$resp || count($cgf->error) > 0 ){
						$response['error'] 	= $cgf->get_errors(); 
					} else {
						$response['success'] = TRUE;
					}
				} else{
					$response['error'] = "Invalid group.";
				}  
			} else {
				$response['error'] = "Restricted action.";
			}
			break; 
		case 'delete_format': 
			if ( $Session->is_admin() ){
				$id_format = ( isset($_POST['id_format']) && is_numeric($_POST['id_format']) && $_POST['id_format'] > 0 ) ? $_POST['id_format'] : 0;
				if ( $id_format > 0 ){
					require_once DIRECTORY_CLASS . "class.cgf.php";
					$cgf = new CGF( );
					$resp = $cgf->delete_format( $id_format );
					if ( !$resp || count($cgf->error) > 0 ){
						$response['error'] 	= $cgf->get_errors(); 
					} else {
						$response['success'] = TRUE;
					}
				} else{
					$response['error'] = "Invalid format.";
				}  
			} else {
				$response['error'] = "Restricted action.";
			}
			break; 
		case 'delete_pdv': 
			$id_pdv = ( isset($_POST['id_pdv']) && is_numeric($_POST['id_pdv']) && $_POST['id_pdv'] > 0 ) ? $_POST['id_pdv'] : 0;
			if ( $id_pdv > 0 ){
				$pdv = new PDV( $id_pdv );
				$resp = $pdv->delete();
				if ( !$resp || count($pdv->error) > 0 ){
					$response['error'] 	= $pdv->get_errors();
				} else {
					$response['success'] = TRUE;
				}
			} else{
				$response['error'] = "Invalid pdv.";
			} 
			break; 
		case 'get_channel_info':  
			$id_channel = ( isset($_POST['id_channel']) && is_numeric($_POST['id_channel']) && $_POST['id_channel'] > 0 ) ? $_POST['id_channel'] : 0;
			if ( $id_channel > 0 ){
				require_once DIRECTORY_CLASS . "class.cgf.php";
				$cgf = new CGF( );
				$response['info'] = $pdv->get_array();
				if ( count( $pdv->error ) > 0 ){
					$response['error'] = $pdv->get_errors(); 
				} else {
					$response['success'] = TRUE;
				}
			} else{
				$response['error'] = "Invalid channel.";
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
			
		case 'get_pdv_type_info':
			$id_pdv_type = ( isset($_POST['id_pdv_type']) && is_numeric($_POST['id_pdv_type']) && $_POST['id_pdv_type'] > 0 ) ? $_POST['id_pdv_type'] : 0;
			if ( $id_pdv_type > 0 )
			{
				require_once DIRECTORY_CLASS . "class.pdv.type.php";
				$pvt = new PDVType( $id_pdv_type );
				$response['info'] = $pvt->get_array();
				if ( count( $pvt->error ) > 0 )
				{
					$response['error'] = $pvt->get_errors(); 
				}
				else
				{
					$response['success'] = TRUE;
				}
			}
			else
			{
				$response['error'] = "Invalid pdv.";
			} 
		break;
		
		case 'get_pdv_type_task_type_html':
			$id_pdv_type = ( isset($_POST['id_pdv_type']) && is_numeric($_POST['id_pdv_type']) && $_POST['id_pdv_type'] > 0 ) ? $_POST['id_pdv_type'] : 0;
			if ( $id_pdv_type > 0 )
			{
				require_once DIRECTORY_CLASS . "class.pdv.type.php";
				$pvt = new PDVType( $id_pdv_type );
				$response['html'] = $pvt->get_task_type_info__html();
				
				if ( count($pvt->error) > 0 )
				{
					$response['error'] 	= $pvt->get_errors(); 
				}
				else
				{
					$response['success'] = TRUE;
				}
			}
			else
			{
				$response['error'] = "Invalid Task Type.";
			} 
		break;
		
		case 'set_pdv_type_task_type':
			$id_pdv_type = ( isset($_POST['id_pdv_type']) && is_numeric($_POST['id_pdv_type']) && $_POST['id_pdv_type'] > 0 ) ? $_POST['id_pdv_type'] : 0;
			$id_task_type = ( isset($_POST['id_ttype']) && is_numeric($_POST['id_ttype']) && $_POST['id_ttype'] > 0 ) ? $_POST['id_ttype'] : 0;
			$status = isset($_POST['status']) ? $_POST['status'] : 0;
			
			if($id_pdv_type > 0 && $id_task_type > 0)
			{
				require_once DIRECTORY_CLASS . "class.admin.pdv.type.php";
				$pvt = new AdminPDVType( $id_pdv_type );
				$pvt->set_task_type($id_task_type, $status);
				if ( count($pvt->error) > 0 )
				{
					$response['error'] 	= $pvt->get_errors(); 
				}
				else
				{
					$response['success'] = TRUE;
				}
			}
			else
			{
				$response['error'] = "Invalid Parameters.";
			}
		break;
		
		case 'delete_pdv_type':
			$id_pdv_type = ( isset($_POST['id_pdv_type']) && is_numeric($_POST['id_pdv_type']) && $_POST['id_pdv_type'] > 0 ) ? $_POST['id_pdv_type'] : 0;
			if ( $id_pdv_type > 1 )
			{
				require_once DIRECTORY_CLASS . "class.admin.pdv.type.php";
				$pvt = new AdminPDVType( $id_pdv_type );
				$pvt->delete();
				
				if ( count( $pvt->error ) > 0 )
				{
					$response['error'] = $pvt->get_errors(); 
				}
				else
				{
					$response['success'] = TRUE;
				}
			}
			else
			{
				$response['error'] = "Invalid pdv.";
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