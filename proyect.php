<?php
require_once 'init.php';  
global $Session;
$action = $_REQUEST['action'];
$cb	 	= $_REQUEST['cb'];
 
switch( $action ){
	case 'edit_form':
			require_once DIRECTORY_CLASS . "class.pry.form.type.php";
			$id_type_form = $_POST['id_type_form'];
			$type_form = $_POST['type_form']; 
			if ( $type_form != '' ){						
				$frm = new Typeform( $id_type_form );
				$frm->type_form = $type_form;
				$frm->id_type_form = $id_type_form; 				
				$resp = $frm->save(); 
				if ( $resp === TRUE ){ 
					$str_err = "";
					if  ( count( $frm->error ) > 0 ){
						$str_err = "&err=" . urlencode( $frm->get_errors() );
					} 
					header("Location: index.php?command=" . PRY_TYPE_FORMS .  "&msg=" . urlencode( "El registro se guardó exitosamente." ) . $str_err );				
				} else { 
					header("Location: index.php?command=" . PRY_TYPE_FORMS .  "&err=" . urlencode( $frm->get_errors() ) ); 
				}
			} else { 
				header("Location: index.php?command=" . PRY_TYPE_FORMS .  "&err=" . urlencode( "No se recibió un nombre de formulario válido.") ); 
			} 
		break;
	case 'edit_free_day':
			require_once DIRECTORY_CLASS . "class.free.day.php";
			$id_free_day = $_POST['id_free_day'];
			$free_day = $_POST['free_day'];
			$day=$_POST['day'];
			$day = strtotime($day);  		
			if ( $free_day != '' ){						
				$frm = new Freeday( $id_free_day );
				$frm->free_day = $free_day;
				$frm->day = $day;				
				$frm->id_free_day = $id_free_day;						
				$resp = $frm->save(); 
				if ( $resp === TRUE ){ 
					$str_err = "";
					if  ( count( $frm->error ) > 0 ){
						$str_err = "&err=" . urlencode( $frm->get_errors() );
					} 
						header("Location: index.php?command=" . PRY_FREE_DAYS .  "&msg=" . urlencode( "El registro se guardó exitosamente." ) . $str_err );				
				} else { 
					header("Location: index.php?command=" . PRY_FREE_DAYS .  "&err=" . urlencode( $frm->get_errors() ) ); 
				}
			} else { 
				header("Location: index.php?command=" . PRY_FREE_DAYS .  "&err=" . urlencode( "No se recibió un nombre de formulario válido.") ); 
			} 
		Break;	
	case 'load_proyect': 
		global $Session;
		$cb = ( $cb != '' ) ? $cb : HOME ;
		if ( isset( $_REQUEST['idp'] ) && is_numeric($_REQUEST['idp']) && $_REQUEST['idp'] > 0 ){
			$id_proyect = $_REQUEST['idp'];
		} else  {
			header("Location: index.php?command=" . $cb . "&err=" . urlencode( "Proyecto inválido." ));
		} 
		if ($Session->valid_proyect_access( $id_proyect ) ){
			$success = $Session->get_proyect( );
			if ( $success !== FALSE ){
				header("Location: index.php?command=" . PRY_DASHBOARD );
			} else {
				header("Location: index.php?command=" . $cb . "&err=" . urlencode( "Acción restringida." ));
			}
		} else {
			header("Location: index.php?command=" . $cb . "&err=" . urlencode( "Acción restringida." ));
		}
		break;
	default: 
		$command = ( $cb != '' ) ? $cb : HOME ;
		header("Location: index.php?command=" . $command . "&err=" . urlencode( "Acción inválida." ));
		break;
} 
?>