<?php 
global $response, $Session; 
require_once DIRECTORY_CLASS . "class.activity.php";
if ( $Session->is_admin() )
{
	switch ( $action )
	{ 
		case 'get_activity_type_info': 
			$id_activity_type = ( isset($_POST['id_activity_type']) && is_numeric($_POST['id_activity_type']) && $_POST['id_activity_type'] > 0 ) ? $_POST['id_activity_type'] : 0;
			if ( $id_activity_type > 0 )
			{
				require_once DIRECTORY_CLASS . "class.activity.type.php";
				$actype = new ActivityType( $id_activity_type );
				$response['info'] = $actype->get_array();
				
				if ( count($actype->error) > 0 )
				{
					$response['error'] 	= $actype->get_errors(); 
				}
				else
				{
					$response['success'] = TRUE;
				}
			}
			else
			{
				$response['error'] = "Invalid Activity Type.";
			} 
		break;
		
		case 'get_activity_type_aux_table':
			$id_activity_type = ( isset($_POST['id_activity_type']) && is_numeric($_POST['id_activity_type']) && $_POST['id_activity_type'] > 0 ) ? $_POST['id_activity_type'] : 0;
			if ( $id_activity_type > 0 )
			{
				require_once DIRECTORY_CLASS . "class.activity.type.php";
				$actype = new ActivityType( $id_activity_type );
				$response['html'] = $actype->get_table_aux_html_option();
				$required = ( $actype->table_aux != '' ) ? TRUE : FALSE ;
				
				if ( count($actype->error) > 0 )
				{
					$response['error'] 	= $actype->get_errors(); 
				}
				else
				{
					$response['success'] = TRUE;
					$response['required'] = $required;
				}
			}
			else
			{
				$response['error'] = "Invalid Activity Type.";
			} 
		break;
		
		case 'get_activity_info':
			$id_activity = ( isset($_POST['id_activity']) && is_numeric($_POST['id_activity']) && $_POST['id_activity'] > 0 ) ? $_POST['id_activity'] : 0;
			if ( $id_activity > 0 )
			{
				$activity = new Activity( $id_activity );
				$response['info'] = $activity->get_array();
				
				if ( count($activity->error) > 0 )
				{
					$response['error'] 	= $activity->get_errors(); 
				}
				else
				{
					$response['success'] = TRUE;
				}
			}
			else
			{
				$response['error'] = "Invalid Activity.";
			} 
		break;
		
		case 'get_activity_info_html':
			$id_activity = ( isset($_POST['id_activity']) && is_numeric($_POST['id_activity']) && $_POST['id_activity'] > 0 ) ? $_POST['id_activity'] : 0;
			if ( $id_activity > 0 )
			{
				$activity = new Activity( $id_activity );
				$response['html'] = $activity->get_info_html();
				
				if ( count($activity->error) > 0 )
				{
					$response['error'] 	= $activity->get_errors(); 
				}
				else
				{
					$response['success'] = TRUE;
				}
			}
			else
			{
				$response['error'] = "Invalid Activity.";
			} 
		break;
		
		case 'delete_activity_type':
			$id_activity_type = ( isset($_POST['id_activity_type']) && is_numeric($_POST['id_activity_type']) && $_POST['id_activity_type'] > 0 ) ? $_POST['id_activity_type'] : 0;
			if ( $id_activity_type > 0 )
			{
				require_once DIRECTORY_CLASS . "class.admin.activity.type.php";
				$actype = new AdminActivityType( $id_activity_type );
				$actype->delete();
				
				if ( count($actype->error) > 0 )
				{
					$response['error'] 	= $actype->get_errors(); 
				}
				else
				{
					$response['success'] = TRUE;
				}
			}
			else
			{
				$response['error'] = "Invalid Activity Type.";
			}
		break;
		
		default:
		$response['error'] = "Invalid action.";
		break;
	}
	
}
else
{
	$response['error'] = "Restricted action.";
}
?>