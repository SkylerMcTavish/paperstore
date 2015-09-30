<?php 
global $response, $Session; 
require_once DIRECTORY_CLASS . "class.admin.task.type.php";
if ( $Session->is_admin() )
{
	switch ( $action )
	{ 
		case 'get_task_type_info': 
			$id_task_type = ( isset($_POST['id_task_type']) && is_numeric($_POST['id_task_type']) && $_POST['id_task_type'] > 0 ) ? $_POST['id_task_type'] : 0;
			if ( $id_task_type > 0 )
			{
				require_once DIRECTORY_CLASS . "class.task.type.php";
				$tasktype = new TaskType( $id_task_type );
				$response['info'] = $tasktype->get_array();
				
				if ( count($tasktype->error) > 0 )
				{
					$response['error'] 	= $tasktype->get_errors(); 
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
		
		case 'set_task_type_activity':
			$id_task_type = ( isset($_POST['id_ttype']) && is_numeric($_POST['id_ttype']) && $_POST['id_ttype'] > 0 ) ? $_POST['id_ttype'] : 0;
			$id_activity = ( isset($_POST['id_activity']) && is_numeric($_POST['id_activity']) && $_POST['id_activity'] > 0 ) ? $_POST['id_activity'] : 0;
			$status = isset($_POST['status']) ? $_POST['status'] : 0;
			
			if($id_task_type > 0 && $id_activity > 0)
			{
				$tasktype = new AdminTaskType( $id_task_type );
				$tasktype->set_activity($id_activity, $status);
				if ( count($tasktype->error) > 0 )
				{
					$response['error'] 	= $tasktype->get_errors(); 
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
		
		case 'get_task_type_activity_info_html':
			$id_task_type = ( isset($_POST['id_ttype']) && is_numeric($_POST['id_ttype']) && $_POST['id_ttype'] > 0 ) ? $_POST['id_ttype'] : 0;
			if ( $id_task_type > 0 )
			{
				require_once DIRECTORY_CLASS . "class.task.type.php";
				$tasktype = new TaskType( $id_task_type );
				$response['html'] = $tasktype->get_activities_info__html();
				
				if ( count($tasktype->error) > 0 )
				{
					$response['error'] 	= $tasktype->get_errors(); 
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
		
		case 'delete_task_type':
			$id_task_type = ( isset($_POST['id_ttype']) && is_numeric($_POST['id_ttype']) && $_POST['id_ttype'] > 0 ) ? $_POST['id_ttype'] : 0;
			if($id_task_type > 0 )
			{
				$tasktype = new AdminTaskType( $id_task_type );
				$tasktype->delete();
				
				if ( count($tasktype->error) > 0 )
				{
					$response['error'] 	= $tasktype->get_errors(); 
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