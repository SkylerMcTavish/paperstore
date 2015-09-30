<?php
require_once 'init.php';
global $Session;
$action = $_POST['action'];
$cb	 	= $_POST['cb'];
 
switch( $action ){
	case 'edit_pdv':
		if ( !$Session->is_admin() ){
			global $Log;
			$Log->write_log( "Restricted attempt to pdv edition. ", SES_RESTRICTED_ACTION, 3 );
			header("Location: index.php?command=" . ERR_403 . "&err=" . urlencode( "Acción restringida." ) );
			die();
		} 
		$command = ( $cb != '' ) ? $cb : FRM_PDV ;
		if ( ! class_exists( 'PDV' ) )
				require_once DIRECTORY_CLASS . "class.pdv.php";
		
		if ( isset( $_POST['id_pdv'] ) && is_numeric($_POST['id_pdv']) && $_POST['id_pdv'] >= 0 ){
			$id_pdv = $_POST['id_pdv'];  
		} 
		else  $id_pdv = 0;
		$pdv = new PDV( $id_pdv ); 
		
		$pdv->name 		  		= ( isset($_POST['name']) 	  		&& $_POST['name'] != '' ) 					? strip_tags($_POST['name']) 		: '';
		$pdv->id_pdv_type 		= ( isset($_POST['id_pdv_type'])	&& is_numeric($_POST['id_pdv_type'])) 		? ($_POST['id_pdv_type']) 			: 0;
		$pdv->jde  				= ( isset($_POST['jde']) 	&& $_POST['jde'] != '' ) 			? strip_tags($_POST['jde'])	: '';
		$pdv->zone 		  		= ( isset($_POST['zone']) 	  		&& $_POST['zone'] != '' ) 					? strip_tags($_POST['zone']) 		: '';
		
		$pdv->latitude	  		= ( isset($_POST['latitude']) 		&& is_numeric($_POST['latitude'])) 			? ($_POST['latitude']) 			: 0;
		$pdv->longitude 		= ( isset($_POST['longitude']) 	  	&& is_numeric($_POST['longitude'])) 		? ($_POST['longitude']) 		: 0;
		
		$pdv->shift_start 	  	= ( isset($_POST['shift_start']) 	&& is_numeric($_POST['shift_start'])) 		? ($_POST['shift_start']) 		: 0;
		$pdv->shift_end 	  	= ( isset($_POST['shift_end']) 	  	&& is_numeric($_POST['shift_end'])) 		? ($_POST['shift_end']) 		: 0;
		$pdv->day_visits 	  	= ( isset($_POST['day_visits']) 	&& is_numeric($_POST['day_visits'])) 		? ($_POST['day_visits']) 		: 0;
		$pdv->workdays	 	  	= ( isset($_POST['workdays']) 	  	&& is_array($_POST['workdays'])) 			? ($_POST['workdays']) 			: array();
		
		foreach ($pdv->meta->options as $k => $option) {
			$id 	= $option->id_option;
			$idx 	= "pdv_option_" . $id;
			$pdv->meta->options[$k]->value = ( isset($_POST[$idx]) && $_POST[$idx] != '' )? strip_tags($_POST[$idx]) : '';
		}
		
		$resp = $pdv->save(); 
		if ( $resp === TRUE ){  
			header("Location: index.php?command=" . $command . "&msg=" . urlencode( "El registro se guardó exitosamente." ) . $str_err );				
		} else { 
			header("Location: index.php?command=" . FRM_PDV . "&pdv=" . $pdv->id_pdv . "&err=" . urlencode( $pdv->get_errors() ) ); 
		} 
		
		break;
	case 'upload_pdv': 
		if ( !$Session->is_admin()){
			global $Log;
			$Log->write_log( "Restricted attempt to pdv load. ", SES_RESTRICTED_ACTION, 3 );
			header("Location: index.php?command=" . ERR_403 . "&err=" . urlencode( "Acción restringida." ) );
			die();
		}
		$command = ( $cb != '' ) ? $cb : LST_PDV ;  
		if ( isset($_FILES['csv_pdv']) ){
			require_once DIRECTORY_CLASS . "class.pdv.loader.php"; 
			$loader = new PDVLoader();
			$resp 	= $loader->load_uploaded_file($_FILES['csv_pdv']); 
			if ( $resp === TRUE ){
				header("Location: index.php?command=" . PRY_VISIT . "&msg=" . urlencode( "Las visitas fueron generadas de manera exitosa." )   ); 
			} else {  
				header("Location: index.php?command=" . $command . "&err=" . urlencode( $loader->get_errors() ) ); 
			}
		} else {  
			header("Location: index.php?command=" . $command . "&err=" . urlencode( "No se recibió un archivo para cargar." ) ); 
		} 
		break;
		
	case 'edit_pdv_type':
		if ( !$Session->is_admin() )
		{
			global $Log;
			$Log->write_log( "Restricted attempt to pdv type edition. ", SES_RESTRICTED_ACTION, 3 );
			header("Location: index.php?command=" . ERR_403 . "&err=" . urlencode( "Acción restringida." ) );
			die();
		}
		
		$command = ( $cb != '' ) ? $cb : LST_PDV_TYPE ;
		if ( ! class_exists( 'PDV' ) )
				require_once DIRECTORY_CLASS . "class.admin.pdv.type.php";
		
		if ( isset( $_POST['id_pdv_type'] ) && is_numeric($_POST['id_pdv_type']) && $_POST['id_pdv_type'] >= 0 ){
			$id_pdv_type = $_POST['id_pdv_type'];  
		} 
		else  $id_pdv_type = 0;
		
		$pvt = new AdminPDVType( $id_pdv_type ); 
		
		$pvt->pdv_type 	= ( isset($_POST['pdv_type'])  && $_POST['pdv_type'] != '' ) ? strip_tags($_POST['pdv_type']) : '';
		
		$resp = $pvt->save(); 
		if ( $resp === TRUE )
		{  
			header("Location: index.php?command=" . $command . "&msg=" . urlencode( "El registro se guardó exitosamente." ) . $str_err );				
		}
		else
		{ 
			header("Location: index.php?command=" . LST_PDV_TYPE . "&pdv=" . $pvt->id_pdv_type . "&err=" . urlencode( $pvt->get_errors() ) ); 
		} 
	break;
		
	default: 
		$command = ( $cb != '' ) ? $cb : HOME ;
		header("Location: index.php?command=" . $command . "&err=" . urlencode( "Acción inválida." ));
		break;
	
} 
?>