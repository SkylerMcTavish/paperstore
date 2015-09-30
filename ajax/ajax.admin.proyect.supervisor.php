<?php
//ini_set('display_errors' , TRUE);
global $response, $Session; 
require_once DIRECTORY_CLASS . "class.admin.proyect.supervisor.php";
switch ( $action ){  
	case 'asign_user_supervisor':  
		if ( $Session->id_proyect > 0 )
		{
			if( isset($_POST['id_parent']) && $_POST['id_parent'] > 0 && isset($_POST['id_user']) && $_POST['id_user']  > 0 )
			{
				$asign = new ProyectSupervisor( $Session->id_proyect ); 
				
				$id_parent = $_POST['id_parent'];
				$id_user   = $_POST['id_user'];
				$state = ( is_numeric( $_POST['state'] ) ? $_POST['state'] : 0 );
				
				$resp = $asign->asign_user_supervisor($id_parent, $id_user, $state);
				
				if ( !$resp )
				{
					$response['error'] = $asign->get_errors(); 
				}
				else
				{ 
					$response['success'] = TRUE;
				}
			}
			else
			{
				$response['error'] = "Wrong parameters.";
			}
		}
		else
		{
			$response['error'] = "Invalid proyect.";
		} 
		break;
	default:
		$response['error'] = "Invalid action.";
	break;
}
?>