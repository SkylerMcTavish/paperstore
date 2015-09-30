<?php
require_once 'init.php';
global $Session;
$action = $_POST['action'];
$cb	 	= $_POST['cb'];
 
switch( $action )
{ 
	/**** Activity ****/
	case 'edit_activity':
		if ( !$Session->is_admin() )
		{
			global $Log;
			$Log->write_log( "Restricted attempt to activity type edition. ", SES_RESTRICTED_ACTION, 3 );
			header("Location: index.php?command=" . ERR_403 . "&err=" . urlencode( "Acción restringida." ) );
			die();
		} 
		$command = ( $cb != '' ) ? $cb : LST_ACTIVITIES ;
		if ( ! class_exists( 'AdminActivityType' ) )
				require_once DIRECTORY_CLASS . "class.admin.activity.php";
		
		if ( isset( $_POST['id_activity'] ) && is_numeric($_POST['id_activity']) && $_POST['id_activity'] >= 0 ){
			$id_activity = $_POST['id_activity'];  
		} 
		else
			$id_activity = 0;
			
		$activity = new AdminActivity( $id_activity ); 
		
		$activity->activity	= ( isset($_POST['activity']) 	&& $_POST['activity'] != '' )	? strip_tags($_POST['activity']) 	: '';
		$activity->id_activity_type	= ( isset($_POST['activity_type_id']) 	 && is_numeric($_POST['activity_type_id']) && $_POST['activity_type_id'] > 0 ) ? $_POST['activity_type_id']	: 0;
		$activity->id_aux	= ( isset($_POST['activity_aux']) 	 && is_numeric($_POST['activity_aux']) && $_POST['activity_aux'] > 0 ) ? $_POST['activity_aux']	: 0;
		$activity->description	= ( isset($_POST['activity_description']) 	&& $_POST['activity_description'] != '' )	? strip_tags($_POST['activity_description']) 	: '';
		
		$resp = $activity->save(); 
		if ( $resp === TRUE )
		{  
			header("Location: index.php?command=" . $command . "&msg=" . urlencode( "El registro se guardó exitosamente." ) . $str_err );				
		}
		else
		{ 
			header("Location: index.php?command=" . LST_ACTIVITIES . "&pdv=" . $activity->id_activity . "&err=" . urlencode( $activity->get_errors() ) ); 
		} 
	break;
	
	case 'edit_activity_type':
		if ( !$Session->is_admin() )
		{
			global $Log;
			$Log->write_log( "Restricted attempt to activity type edition. ", SES_RESTRICTED_ACTION, 3 );
			header("Location: index.php?command=" . ERR_403 . "&err=" . urlencode( "Acción restringida." ) );
			die();
		} 
		$command = ( $cb != '' ) ? $cb : LST_ACTIVITIES . "&tab=actype" ;
		if ( ! class_exists( 'AdminActivityType' ) )
				require_once DIRECTORY_CLASS . "class.admin.activity.type.php";
		
		if ( isset( $_POST['id_activity_type'] ) && is_numeric($_POST['id_activity_type']) && $_POST['id_activity_type'] >= 0 ){
			$id_activity_type = $_POST['id_activity_type'];  
		} 
		else
			$id_activity_type = 0;
			
		$actype = new AdminActivityType( $id_activity_type ); 
		
		$actype->activity_type	= ( isset($_POST['activity_type']) 	&& $_POST['activity_type'] != '' )	? strip_tags($_POST['activity_type']) 	: '';
		$actype->table_aux		= ( isset($_POST['table_aux']) 	  	&& $_POST['table_aux'] != '' ) 		? strip_tags($_POST['table_aux']) 		: '';
		
		$resp = $actype->save(); 
		if ( $resp === TRUE )
		{  
			header("Location: index.php?command=" . $command . "&msg=" . urlencode( "El registro se guardó exitosamente." ) . $str_err );				
		}
		else
		{ 
			header("Location: index.php?command=" . LST_ACTIVITIES . "&pdv=" . $actype->id_activity_type . "&err=" . urlencode( $actype->get_errors() ) ); 
		} 
	break;
		
	default: 
		$command = ( $cb != '' ) ? $cb : HOME ;
		header("Location: index.php?command=" . $command . "&err=" . urlencode( "Acción inválida." ));
		break;
}
?>