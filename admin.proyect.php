<?php
require_once 'init.php';   
global $Session;
$action = $_POST['action'];
$cb	 	= $_POST['cb'];
 
switch( $action ){ 
	/**** Proyect ****/
	case 'edit_proyect': 
		if ( !$Session->is_admin() ){
			global $Log;
			$Log->write_log( "Restricted attempt to proyect edition. ", SES_RESTRICTED_ACTION, 3 );
			header("Location: index.php?command=" . ERR_403 . "&err=" . urlencode( "Acción restringida." ) );
			die();
		} 
		$command = ( $cb != '' ) ? $cb : LST_PROYECT ;
		require_once DIRECTORY_CLASS . "class.admin.proyect.php";
		
		if ( isset( $_POST['id_proyect'] ) && is_numeric($_POST['id_proyect']) && $_POST['id_proyect'] >= 0 ){
			$id_proyect = $_POST['id_proyect'];  
		} else  $id_proyect = 0;
		$proyect = new AdminProyect( $id_proyect );  
		$proyect->proyect 			= ( isset($_POST['proyect']) 	  	&& $_POST['proyect'] != '' 			) 	? strip_tags($_POST['proyect']) 	: '';
		$proyect->id_proyect_type	= ( isset($_POST['id_proyect_type'])&& is_numeric($_POST['id_proyect_type'])) ? $_POST['id_proyect_type'] + 0	: 0; 
		$proyect->id_company		= ( isset($_POST['id_company'])		&& is_numeric($_POST['id_company'])) 	? $_POST['id_company'] + 0			: 0; 
		$proyect->id_region			= ( isset($_POST['id_region'])		&& is_numeric($_POST['id_region'])	)	? ($_POST['id_region'] + 0 )		: 0;  
		$proyect->shift_start		= ( isset($_POST['shift_start'])	&& is_numeric($_POST['shift_start'] )	)	? ($_POST['shift_start'] + 0 )	: 0; 
		$proyect->shift_end			= ( isset($_POST['shift_end'])		&& is_numeric($_POST['shift_end'])	)	? ($_POST['shift_end'] + 0 )		: 0; 
		$proyect->day_visits		= ( isset($_POST['day_visits'])		&& is_numeric($_POST['day_visits'])	)	? ($_POST['day_visits'] + 0 )		: 0;
		$proyect->workdays 			= ( isset($_POST['workdays']) 		&& is_array($_POST['workdays']) 	) 	? $_POST['workdays']  				: array(); 
		
		$resp = $proyect->save(); 
		if ( $resp === TRUE ){
			header("Location: index.php?command=" . FRM_PROYECT . "&idp=" . $proyect->id_proyect . "&msg=" . urlencode( "El registro se guardó exitosamente." )   ); 
		} else {  
			header("Location: index.php?command=" . $command . "&err=" . urlencode( $proyect->get_errors() ) ); 
		}  
		break;
		
	/**** Cycle ****/
	case 'edit_cycle':
		if ( $Session->id_proyect > 0 ){
			require_once DIRECTORY_CLASS . "class.admin.proyect.php";
			$proyect = new AdminProyect( $Session->id_proyect );
			$cycle = new stdClass; 
			$cycle->from_str = ( isset($_POST['from'])	&& $_POST['from'] != '' ) ? strip_tags($_POST['from']) 	: '';
			$cycle->to_str	 = ( isset($_POST['to'])	&& $_POST['to'] != '' 	) ? strip_tags($_POST['to']) 	: '';
			
			$cycle->from = get_timestamp( $cycle->from_str );
			$cycle->to	 = get_timestamp( $cycle->to_str );
			 
			$resp = $proyect->save_cycle( $cycle );
			 
			if ( $resp === TRUE ){
				header("Location: index.php?command=" . PRY_CYCLE . "&idp=" . $proyect->id_proyect . "&msg=" . urlencode( "El registro se guardó exitosamente." )   ); 
			} else {  
				$command = ( $cb != '' ) ? $cb : PRY_CYCLE ;
				header("Location: index.php?command=" . $command . "&err=" . urlencode( $proyect->get_errors() ) ); 
			}  
		} 
		break;
	
	/**** Media File ****/
	case 'edit_media_file':
		if ( $Session->id_proyect > 0 ){
			require_once DIRECTORY_CLASS . "class.admin.proyect.php";
			$proyect = new AdminProyect( $Session->id_proyect );
			
			$media = new stdClass;
			$media->title	 	= ( isset($_POST['title'])	&& $_POST['title'] != '' ) ? strip_tags($_POST['title']) : '';
			$media->description	= ( isset($_POST['description']) && $_POST['description'] != '' ) ? strip_tags($_POST['description']) : '';
			$media->id_media_type=( isset($_POST['id_media_type'])&& is_numeric($_POST['id_media_type'])) ? $_POST['id_media_type'] + 0	: 0;
			
			$media->file		= ( isset($_FILES['media_file']) && $_FILES['media_file']['tmp_name'] != '' ) ? $_FILES['media_file'] : FALSE; 
			$resp = $proyect->save_media( $media );  
			if ( $resp === TRUE ){
				header("Location: index.php?command=" . PRY_MEDIA . "&idp=" . $proyect->id_proyect . "&msg=" . urlencode( "El registro se guardó exitosamente." )   ); 
			} else {  
				$command = ( $cb != '' ) ? $cb : PRY_MEDIA ;
				header("Location: index.php?command=" . $command . "&err=" . urlencode( $proyect->get_errors() ) ); 
			}  
		} 
		break;	
	
		
	default: 
		$command = ( $cb != '' ) ? $cb : HOME ;
		header("Location: index.php?command=" . $command . "&err=" . urlencode( "Acción inválida." ));
		break;
} 
?>