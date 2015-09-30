<?php 
global $response, $Session; 
require_once DIRECTORY_CLASS . "class.pry.form.type.php";
switch ( $action ){
	case 'edit_form':
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
	case 'delete_type_form':
		$id_type_form = ( isset($_POST['id_type_form']) && is_numeric($_POST['id_type_form']) && $_POST['id_type_form'] > 0 ) ? $_POST['id_type_form'] : 0;
		
			if ( $id_type_form > 0 ){				
				//Revisar esta madrola Typeform()	
					
				$typeform = new Typeform($id_type_form);
				
				$resp = $typeform->delete_type_form();
				if ( !$resp || count($typeform->error) > 0 ){
					$response['error'] 	= $typeform->get_errors();
				} else {
					$response['success'] = TRUE;
				}
				
				
			} else{
				$response['error'] = "Invalid type form.";
			} 
		break;
		case 'is_unique_type_form':
			global $Validate;
			$id_type_form = $_POST['id_type_form'];
			$type_form = $_POST['type_form']; 
			$id_type_form = ( !is_numeric($id_type_form) ) ? 0 : $id_type_form;					
			$response['unique']  = $Validate->is_unique( 'pr1_form_type', 'fmt_form_type', $type_form, 'id_form_type', $id_type_form );
			$response['success'] = TRUE; 
		break;
	case 'get_form_type_info':  
			$id_type_form = ( isset($_POST['id_type_form']) && is_numeric($_POST['id_type_form']) && $_POST['id_type_form'] > 0 ) ? $_POST['id_type_form'] : 0;
			if ( $id_type_form > 0 ){
				$typeform = new Typeform( $id_type_form );
				$response['info'] = $typeform->get_array();
				if ( count( $typeform->error ) > 0 ){
					$response['error'] = $typeform->get_errors(); 
				} else {
					$response['success'] = TRUE;
				}
			} else{
				$response['error'] = "Invalid Type form.";
			} 
			break;	
	case 'get_section_info':  
		$id_form 	= ( isset($_POST['id_form']) 	&& is_numeric($_POST['id_form']) 	&& $_POST['id_form'] > 0 	) ? $_POST['id_form'] + 0 : 0;
		$id_section = ( isset($_POST['id_section']) && is_numeric($_POST['id_section']) && $_POST['id_section'] > 0 ) ? $_POST['id_section'] + 0 : 0;
		if ( $id_form > 0 ){
			$form = new Typeform( $id_form ); 
			$section = $form->get_section_info($id_section); 
			if ( count( $form->error ) > 0 ){
				$response['error'] = $form->get_errors(); 
			} else {
				$response['info'] = $section;
				$response['success'] = TRUE;
			}
		} else{
			$response['error'] = "Invalid form.";
		} 
		break;
	case 'get_question_info':  
		$id_form 	= ( isset($_POST['id_form']) 	&& is_numeric($_POST['id_form']) 	&& $_POST['id_form'] > 0 	) ? $_POST['id_form'] + 0 : 0;
		$id_question= ( isset($_POST['id_question']) && is_numeric($_POST['id_question']) && $_POST['id_question'] > 0 ) ? $_POST['id_question'] + 0 : 0;
		if ( $id_form > 0 ){
			$form = new ProyectForm( $id_form );
			$question = $form->get_question_info($id_question);  
			if ( count( $form->error ) > 0 ){
				$response['error'] = $form->get_errors(); 
			} else { 
				$response['info'] = $question;
				$response['success'] = TRUE;
			}
		} else{
			$response['error'] = "Invalid form.";
		} 
		break;
	default:
		$response['error'] = "Invalid action.";
			break;
}
?>