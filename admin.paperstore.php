<?php
require_once 'init.php';
global $Session;
$action = $_POST['action'];
$cb	 	= $_POST['cb'];
 
switch( $action ){
	case 'create_sell':
		if ( !$Session->is_admin() ){
			global $Log;
			$Log->write_log( "Restricted attempt to pdv edition. ", SES_RESTRICTED_ACTION, 3 );
			header("Location: index.php?command=" . ERR_403 . "&err=" . urlencode( "Acción restringida." ) );
			die();
		} 
		$command = ( $cb != '' ) ? $cb : FRM_SELL ;
		if ( ! class_exists( 'AdminSell' ) )
				require_once DIRECTORY_CLASS . "class.admin.sell.php";
		$Sell = new AdminSell();
		
		$resp = $Sell->create_header();
		
		if ( $resp === TRUE )
		{  
			header("Location: index.php?command=" . $command ."&id_sell=".$Sell->id_sell );
		}
		else
		{ 
			header("Location: index.php?command=" . PAPERSTORE . "&err=" . urlencode( $pdv->get_errors() ) ); 
		} 
		
	break;
		
	default: 
		$command = ( $cb != '' ) ? $cb : HOME ;
		header("Location: index.php?command=" . $command . "&err=" . urlencode( "Acción inválida." ));
	break;
	
} 
?>