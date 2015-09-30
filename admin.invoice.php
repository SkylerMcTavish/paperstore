<?php
require_once 'init.php';
global $Session;
$action = $_POST['action'];
$cb	 	= $_POST['cb'];
 
switch( $action )
{ 
	/**** Invoice ****/
	case 'upload_invoice': 
		if ( !$Session->is_admin() )
		{
			global $Log;
			$Log->write_log( "Restricted attempt to invoice load. ", SES_RESTRICTED_ACTION, 3 );
			header("Location: index.php?command=" . ERR_403 . "&err=" . urlencode( "Acción restringida." ) );
			die();
		}
		$command = ( $cb != '' ) ? $cb : LST_INVOICE ; 
		if ( isset($_FILES['csv_invoice']) )
		{
			require_once DIRECTORY_CLASS . "class.invoice.loader.php"; 
			$loader = new InvoiceLoader();
			$resp 	= $loader->load_uploaded_file($_FILES['csv_invoice']); 
			if ( $resp === TRUE )
			{
				header("Location: index.php?command=" . LST_INVOICE . "&msg=" . urlencode( "Las facturas fueron cargadas de manera exitosa." )   ); 
			}
			else
			{
				header("Location: index.php?command=" . $command . "&err=" . urlencode( $loader->get_errors() ) ); 
			}
		}
		else
		{  
			header("Location: index.php?command=" . $command . "&err=" . urlencode( "No se recibió un archivo para cargar." ) ); 
		} 
		echo "<script> window.location=index.php?command=" . LST_INVOICE ."</script>";
	break;
		
	default: 
		$command = ( $cb != '' ) ? $cb : HOME ;
		header("Location: index.php?command=" . $command . "&err=" . urlencode( "Acción inválida." ));
		break;
}
?>