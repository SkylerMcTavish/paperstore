<?php
require 'init.php';

$idp = isset( $_REQUEST['idp'] ) && $_REQUEST['idp'] > 0 ? $_REQUEST['idp'] : 0;

if ( !($idp > 0) ){
	
	$user  = isset( $_REQUEST['user']  ) && $_REQUEST['user']  != '' ? $_REQUEST['user']  : '';
	$token = isset( $_REQUEST['token'] ) && $_REQUEST['token'] != '' ? $_REQUEST['token'] : '';
	/* TODO: webservice function */
	$idp = 1;
	
	$access = TRUE;
}
else
{
	$access = TRUE;
}


if ( $access )
{ 
	$id  = isset( $_REQUEST['id'] )  && is_numeric( $_REQUEST['id']) && $_REQUEST['id'] > 0 ? $_REQUEST['id'] : 0;
	$type= isset( $_REQUEST['type'] ) && $_REQUEST['type'] != '' ? strip_tags($_REQUEST['type']) : "";
	if ( $id > 0 )
	{
		require_once DIRECTORY_CLASS . "class.file.manager.php";
		
		$fmanager = new FileManager();
		
		/*if ( $idp > 0 )
			$fmanager->set_proyect( $idp ); */
			
		$resp = $fmanager->output_file( $id, $type ); 
		
	}
	else
	{
		require_once DIRECTORY_VIEWS . "404.php";
	} 
}
else
{
	require_once DIRECTORY_VIEWS . "403.php";
}
die();
?>