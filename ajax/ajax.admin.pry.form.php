<?php
ini_set('display_errors', TRUE); 
global $response, $Session; 
require_once DIRECTORY_CLASS . "class.admin.pry.form.php";
switch ( $action ){  
	case 'save_section':  
		$id_form = ( isset($_POST['id_form']) && is_numeric($_POST['id_form']) && $_POST['id_form'] > 0 ) ? $_POST['id_form'] + 0 : 0;
		if ( $id_form > 0 ){
			$form = new AdminProyectForm( $id_form );
			$section = new stdClass;
			$section->id_section	= ( isset($_POST['id_section']) && is_numeric($_POST['id_section']) && $_POST['id_section'] > 0 ) ? $_POST['id_section'] + 0 : 0;
			$section->title 		= ( isset($_POST['title']) 		 && ($_POST['title'] != '')   		) ? $_POST['title']  : "";
			$section->description 	= ( isset($_POST['description']) && ($_POST['description'] != '')   ) ? $_POST['description']  : ""; 
			$resp = $form->save_section( $section );
			if ( count( $form->error ) > 0 ){
				$response['error'] = $form->get_errors(); 
			} else {
				$response['html'] = $form->get_sections_form_html();
				$response['success'] = TRUE;
			}
		} else{
			$response['error'] = "Invalid form.";
		} 
		break;
	case 'save_question':  
		$id_form = ( isset($_POST['id_form']) && is_numeric($_POST['id_form']) && $_POST['id_form'] > 0 ) ? $_POST['id_form'] + 0 : 0;
		if ( $id_form > 0 ){
			$form = new AdminProyectForm( $id_form );
			$question = new stdClass;
			$question->id_question	= ( isset($_POST['id_question']) && is_numeric($_POST['id_question']) && $_POST['id_question'] > 0 ) ? $_POST['id_question'] + 0 : 0;
			$question->id_question_type	= ( isset($_POST['id_question_type'])  && is_numeric($_POST['id_question_type']) && $_POST['id_question_type'] > 0 ) ? $_POST['id_question_type'] + 0 : 0;
			$question->id_section 	= ( isset($_POST['id_section'])  && is_numeric($_POST['id_section']) && $_POST['id_section'] > 0 ) ? $_POST['id_section'] + 0 	: 0; 
			$question->order	 	= ( isset($_POST['order'])  	 && is_numeric($_POST['order']) 	 && $_POST['order'] > 0 	 ) ? $_POST['order'] + 0 		: 0;
			$question->question 	= ( isset($_POST['question']) 	 && ($_POST['question'] != '')   ) ? $_POST['question']  : "";
			$question->options 		= ( isset($_POST['options']) 	 && ($_POST['options'] != '')    ) ? $_POST['options']  : "";
			$question->correct	 	= ( isset($_POST['correct']) 	 && ($_POST['correct'] != '' )   ) ? $_POST['correct']  : "";
			$question->weight	 	= ( isset($_POST['weight'])  	 && is_numeric($_POST['weight']) 	 && $_POST['weight'] > 0 	 ) ? $_POST['weight'] + 0 		: 0;
			 
			$resp = $form->save_question( $question );
			if ( count( $form->error ) > 0 ){
				$response['error'] = $form->get_errors(); 
			} else {
				$section = $form->get_section( $question->id_section );
				$response['html'] = $form->get_questions_form_html( $section );
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