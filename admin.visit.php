<?php
require_once 'init.php';
ini_set( 'display_errors', TRUE );
global $Session;
$action = $_POST['action'];
$cb	 	= $_POST['cb'];
switch( $action ){ 
	/**** Visits ****/
	
	case 'load_visit': 
		if ( !$Session->is_admin() ){
			global $Log;
			$Log->write_log( "Restricted attempt to visit load. ", SES_RESTRICTED_ACTION, 3 );
			header("Location: index.php?command=" . ERR_403 . "&err=" . urlencode( "Acción restringida." ) );
			die();
		}
		$command = ( $cb != '' ) ? $cb : LST_VISIT ;
		if ( isset($_FILES['file']) ){
			require_once DIRECTORY_CLASS . "class.visit.loader.php"; 
			$loader = new VisitLoader();  
			$resp 	= $loader->load_uploaded_file( $_FILES['file'] );
			if ( $resp === TRUE ){
				header("Location: index.php?command=" . LST_VISIT . "&msg=" . urlencode( "Las visitas fueron generadas de manera exitosa." )   ); 
			} else {  
				header("Location: index.php?command=" . $command . "&err=" . /* urlencode( $loader->get_errors() ) . */ print_r( $loader->error, TRUE ) ); 
			}
		} else {  
			header("Location: index.php?command=" . $command . "&err=" . urlencode( "No se recibió un archivo para cargar." ) ); 
		} 
		echo "<script> window.location=index.php?command=" . LST_VISIT ."</script>";
		break;
		
	default: 
		$command = ( $cb != '' ) ? $cb : HOME ;
		header("Location: index.php?command=" . $command . "&err=" . urlencode( "Acción inválida." ));
		break;
}
?>