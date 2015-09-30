<?php
require_once 'init.php';
global $Session;
$action = $_POST['action'];
$cb	 	= $_POST['cb'];
 
switch( $action )
{ 
	/**** Task ****/
	case 'edit_task_type':

		if ( !$Session->is_admin() )
		{
			global $Log;
			$Log->write_log( "Restricted attempt to task type edition. ", SES_RESTRICTED_ACTION, 3 );
			header("Location: index.php?command=" . ERR_403 . "&err=" . urlencode( "Acción restringida." ) );
			die();
		} 
		$command = ( $cb != '' ) ? $cb : LST_TASK ;
		if ( ! class_exists( 'AdminTaskType' ) )
				require_once DIRECTORY_CLASS . "class.admin.task.type.php";
		
		if ( isset( $_POST['id_task_type'] ) && is_numeric($_POST['id_task_type']) && $_POST['id_task_type'] >= 0 ){
			$id_task_type = $_POST['id_task_type'];  
		} 
		else
			$id_task_type = 0;
			
		$tasktype = new AdminTaskType( $id_task_type ); 
		
		$tasktype->task_type	= ( isset($_POST['task_type']) 		&& $_POST['task_type'] != '' )		? strip_tags($_POST['task_type']) 	: '';
		$tasktype->description	= ( isset($_POST['description'])	&& $_POST['description'] != '' )	? strip_tags($_POST['description']) : '';
		
		$resp = $tasktype->save(); 
		if ( $resp === TRUE )
		{  
			header("Location: index.php?command=" . $command . "&msg=" . urlencode( "El registro se guardó exitosamente." ) . $str_err );				
		}
		else
		{ 
			header("Location: index.php?command=" . LST_TASK . "&pdv=" . $actype->id_activity_type . "&err=" . urlencode( $actype->get_errors() ) ); 
		} 
	break;
		
	default: 
		$command = ( $cb != '' ) ? $cb : HOME ;
		header("Location: index.php?command=" . $command . "&err=" . urlencode( "Acción inválida." ));
		break;
}
?>