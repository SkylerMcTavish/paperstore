<?php
if (!class_exists('ProyectForm')){
	require_once 'class.pry.form.php';
}

/**
* AdminProyectForm CLass
* 
* @package		SF·Tracker 			
* @since        11/25/2014 
* 
*/ 
class AdminProyectForm extends ProyectForm {
	 
	/**
	* __construct()    
	* Creates a AdminProyectForm object from the DB.
	*  
	* @param	$id_form (optional) If set populates values from DB record. 
	* 
	*/  
	function __construct( $id_form ){
		global $Session;  
		$this->class = 'AdminProyectForm';
		if ( !$Session->is_proyect_admin() ){
			$this->set_error('Restricted Access', SES_RESTRICTED_ACCESS, 3);
			throw new Exception("Restricted access.", 1); 
		}
		parent::__construct( $id_form );
		$this->class = 'AdminProyectForm';
	}
	
	/**
	* save()    
	* Inserts or Update the record in the DB. 
	* 
	*/  
	public function save(){
		global $Session;
		if ( $Session->is_proyect_admin() ){ 
			if ( $this->validate() ){ 
				global $obj_bd; 
				$values = array( 
							':id_form_type' 	=> $this->id_form_type,
							':frm_title' 		=> $this->title,   
							':frm_description' 	=> $this->description,
							':frm_timestamp' 	=> time() 
						);
				if ( $this->id_form > 0 ){ 
					$values[':id_form'] = $this->id_form ;
					$query = " UPDATE " . PFX_PRY_DB . "form SET "  
								. " frm_fmt_id_form_type = :id_form_type, "
								. " frm_title 		= :frm_title , "  
								. " frm_description = :frm_description , "  
								. " frm_status	 	= 1, "
								. " frm_timestamp 	= :frm_timestamp "
							. " WHERE id_form = :id_form ";
				} else { 
					$query = "INSERT INTO " . PFX_PRY_DB . "form (frm_fmt_id_form_type,  frm_title,  frm_description, frm_status, frm_timestamp ) "
							. " VALUES (:id_form_type, :frm_title, :frm_description, 1, :frm_timestamp ) ";
				}  
				$result = $obj_bd->execute( $query, $values );
				if ( $result !== FALSE ){ 
					if ( $this->id_form == 0 ){
						$this->id_form = $obj_bd->get_last_id();
					}
					$this->set_msg('SAVE', " Form " . $this->id_form . " ( " . ID_PRY . ") " . " saved. "); 
					return TRUE;
				} else { 
					$this->set_error( "An error ocurred while trying to save the form " . $this->id_form . " ( " . ID_PRY . "). ", ERR_DB_EXEC, 3 );
					return FALSE;
				} 
			} else {
				return FALSE;
			}
			
		} else {
			$this->set_error("Restricted action.", SES_RESTRICTED_ACTION);
			return FALSE;
		}
	}

	/**
	 * save_section()
	 * Saves the form sections info to the DB
	 * 
	 * @return 	TRUE | FALSE
	 */
	public function save_section( $section ){ 
		if ( $this->id_form > 0 ){ 
			if ( $this->validate_section( $section ) ){
				global $obj_bd; 
				$values = array( 
							':id_form'		=> $this->id_form,
							':title' 		=> $section->title,
							':description' 	=> $section->description,
							':timestamp' 	=> time()
						);
				if ( $section->id_section > 0 ){
					$values[':id_section'] = $section->id_section;
					$query = "UPDATE " . PFX_PRY_DB . "form_section SET "
					 			. " fms_title		= :title, "
					 			. " fms_description = :description, "
					 			. " fms_status		= 1, "
					 			. " fms_timestamp	= :timestamp "
							. " WHERE id_form_section = :id_section AND fms_frm_id_form = :id_form ";
				} else {
					 $query = "INSERT INTO " . PFX_PRY_DB . "form_section ( fms_frm_id_form, fms_title, fms_description, fms_status, fms_timestamp ) "
					 		. " VALUES ( :id_form, :title, :description, 1, :timestamp  ) "; 
				} 
				$resp = $obj_bd->execute( $query, $values );
				if ( !$resp ){
					$err = $obj_bd->get_error(); 
					$this->set_error( ' An error occurred while saving ProyectForm Section information '  , ERR_DB_EXEC, 3 );
					return FALSE;
				} else {
					$this->set_msg('SAVE', " ProyectForm " . $this->id_form. " section information saved. ");
					$this->set_content();
					return TRUE;
				}  
			} else { //Validation
				return FALSE;
			}
		} 
	}
	 
	/**
	 * save_question()
	 * Saves the form schdeule info to the DB
	 * 
	 * @return 	TRUE | FALSE
	 */
	public function save_question( $question ){
		if ( $this->id_form > 0 ){
			if ( $this->validate_question( $question ) ){
				global $obj_bd; 
				$values = array( 
							':id_section'	=> $question->id_section,
							':id_type' 		=> $question->id_question_type,
							':question' 	=> $question->question,
							':order' 		=> $question->order,
							':options' 		=> $question->options,
							':correct' 		=> $question->correct,
							':weight' 		=> $question->weight,
							':timestamp'	=> time()
						);
				if ( $question->id_question > 0 ){
					$values[':id_question'] = $question->id_question;
					$query = "UPDATE " . PFX_PRY_DB . "question SET "
					 			. " qs_qt_id_question_type = :id_type, " 
					 			. " qs_question = :question, "
					 			. " qs_order 	= :order, "
					 			. " qs_options	= :options, "
					 			. " qs_correct 	= :correct, "
					 			. " qs_weight	= :weight, " 
					 			. " qs_timestamp= :timestamp "
							. " WHERE qs_fms_id_form_section = :id_section AND id_question = :id_question ";
				} else {
					 $query = "INSERT INTO " . PFX_PRY_DB . "question "
					 			. " ( qs_qt_id_question_type, qs_fms_id_form_section, qs_order, qs_question, qs_options, qs_correct, qs_weight, qs_status, qs_timestamp ) "
					 		. " VALUES ( :id_type, :id_section, :order, :question, :options, :correct, :weight, 1, :timestamp ) "; 
				} 
				$resp = $obj_bd->execute( $query, $values );
				if ( !$resp ){
					$this->set_error( ' An error occurred while saving ProyectForm Question information <pre>' . print_r($obj_bd->error, TRUE) . '</pre>', ERR_DB_EXEC, 3 );
					return FALSE;
				} else {
					$this->set_msg('SAVE', " ProyectForm " . $this->id_form. " Question information saved. ");
					$this->set_content();
					return TRUE;
				}  
			} else { //Validation
				return FALSE;
			}
		} 
	}

	/**
	* validate()    
	* Validates the values before inputing to Data Base 
	*  
	* @return        Boolean TRUE if valid; FALSE if invalid
	*/ 
	public function validate(){ 
		global $Validate; 
		if ( !$this->title != '' ){
			$this->set_error( 'Title value empty. ', ERR_VAL_EMPTY );
			return FALSE;
		}  
		if ( !is_numeric($this->id_form_type) || !( $this->id_form_type > 0 ) ){ 
			$this->set_error( 'Invalid Family value. ', ERR_VAL_INVALID );
			return FALSE;
		}
		return TRUE; 
	}

	/**
	* validate_section()    
	* Validates the values before inputing to Data Base 
	*  
	* @return        Boolean TRUE if valid; FALSE if invalid
	*/ 
	public function validate_section( $section ){ 
		global $Validate; 
		if ( ! ($section->title != '') ){
			$this->set_error( ' Section: Invalid Title. ', ERR_VAL_INVALID );
			return FALSE;
		}  
		return TRUE; 
	} 
	
	/**
	* validate_question()    
	* Validates the values before inputing to Data Base 
	*  
	* @return        Boolean TRUE if valid; FALSE if invalid
	*/ 
	public function validate_question( $question ){ 
		global $Validate; 
		if ( !is_numeric( $question->id_section ) || !($question->id_section > 0) ){
			$this->set_error( 'Question: Invalid Section. ', ERR_VAL_INVALID );
			return FALSE;
		} 
		if ( !is_numeric($question->id_question_type) || !( $question->id_question_type > 0 ) ){ 
			$this->set_error( 'Question: Invalid Question Type value. ', ERR_VAL_INVALID );
			return FALSE;
		}
		if ( $question->question == '' ){
			$this->set_error( 'Question: Invalid Question. ', ERR_VAL_INVALID );
			return FALSE;
		}
		/*
		 * TODO: validate question type cases
		 * */
		return TRUE; 
	} 
	
	/**
	* delete()    
	* Changes status for ProyectForm to 0 in the DB.
	*
	* @return 	TRUE on success; FALSE otherwise 
	*/  
	public function delete(){
		global $Session;
		if ( $Session->is_admin() ){
			global $obj_bd;
			$query = " UPDATE "  . PFX_MAIN_DB . "form SET frm_status = 0 WHERE id_form = :id_form ";
			$result = $obj_bd->execute( $query, array( ':id_form' => $this->id_form ) );
			if ( $result !== FALSE ){
				$this->clean();
				return TRUE;
			} else {
				$this->set_error( "An error ocurred while trying to set status to 0. ", ERR_DB_EXEC, 3 );
				return FALSE;
			} 
		}
	}
	
	/**
	* delete_section()    
	* Deletes Section record from the DB.
	*
	* @param	$id_section  ID of the form presentation
	* 
	* @return 	TRUE on success; FALSE otherwise 
	*/  
	public function delete_section( $id_section ){ //form presentation
		global $Session;
		if ( $Session->is_admin() ){
			global $obj_bd;
			$query = " DELETE FROM "  . PFX_PRY_DB . "form_section WHERE fms_frm_id_form = :id_form AND id_form_section = :id_form_section ";
			$result = $obj_bd->execute( $query, array( ':id_form' => $this->id_form, ':id_form_section' => $id_section  ) );
			if ( $result !== FALSE ){
				$this->set_content();
				return TRUE;
			} else {
				$this->set_error( "An error ocurred while trying to delete the Section from the DB. ", ERR_DB_EXEC, 3 );
				return FALSE;
			} 
		}
	}

	/**
	* delete_question()    
	* Deletes Question record from the DB.
	*
	* @param	$id_pp  ID of the form presentation
	* 
	* @return 	TRUE on success; FALSE otherwise 
	*/  
	public function delete_question( $id_question ){ //form presentation
		global $Session;
		if ( $Session->is_admin() ){
			global $obj_bd;
			$query = " UPDATE "  . PFX_MAIN_DB . "question SET qs_status = 0  WHERE :id_question  = :id_question ";
			$result = $obj_bd->execute( $query, array( ':id_question' => $id_question  ) );
			if ( $result !== FALSE ){
				$this->set_content();
				return TRUE;
			} else {
				$this->set_error( "An error ocurred while trying to delete the Question from the DB. ", ERR_DB_EXEC, 3 );
				return FALSE;
			} 
		}
	}
	
	
	/**
	 * get_sections_form_html()
	 */
	 public function get_sections_form_html(){
	 	$html  = "";  
	 	if ( count( $this->sections ) > 0 ){
	 		ob_start(); 
			foreach ( $this->sections as $k => $section) { 
				require DIRECTORY_VIEWS . "proyect/frm.form.section.php";  
			}
			$html .= ob_get_contents();
			ob_end_clean(); 
	 	} else {
	 		$html = "<div class='row text-center'> No existen secciones que mostrar. </div>";
	 	}
	 	
		return str_replace(array("\n", "\t"), "", $html); 
	 }
	 
	
	/**
	 * get_questions_form_html()
	 */
	 public function get_questions_form_html( $section ){
	 	$html  = ""; 
		ob_start(); 
		foreach ( $section->questions as $k => $question) {
			require_once DIRECTORY_VIEWS . "proyect/frm.form.question.php"; 
			$html .= ob_get_contents();
		}
		ob_end_clean(); 
		return str_replace(array("\n", "\t"), "", $html); 
	 }	 
}

?>