<?php
/**
* ProyectForm CLass
* 
* @package		SF·Tracker 			
* @since        11/19/2014 
* 
*/ 
class ProyectForm extends Object {
	
	public $id_form; 
	public $title; 
	public $description;
	
	public $id_form_type;
	public $form_type; 
	
	public $sections = array(); 
	 
	public $timestamp; 
	
	/**
	* ProyectForm()    
	* Creates a User object from the DB.
	*  
	* @param	$id_form (optional) If set populates values from DB record. 
	* 
	*/  
	function __construct( $id_form = 0 ){
		global $obj_bd;
		$this->class = 'ProyectForm';
		$this->error = array();
		$this->clean();
		if ( $id_form > 0 ){
			$query = "SELECT "
						. " id_form, frm_title, frm_description, id_form_type, fmt_form_type, frm_timestamp " 
					. " FROM " . PFX_PRY_DB . "form " 
						. " INNER JOIN " . PFX_PRY_DB . "form_type ON id_form_type = frm_fmt_id_form_type " 
					. " WHERE id_form = :id_form ";
			$info = $obj_bd->query( $query, array( ':id_form' => $id_form ) );
			if ( $info !== FALSE ){
				if ( count($info) > 0 ){ 
					$pv = $info[0];
					$this->id_form 		= $pv['id_form'];
					$this->title		= $pv['frm_title']; 
					$this->description	= $pv['frm_description']; 
					
					$this->id_form_type	= $pv['id_form_type'];
					$this->form_type	= $pv['fmt_form_type']; 
					
					$this->timestamp	= $pv['frm_timestamp']; 
					$this->set_content(); 
					
				} else {
					$this->set_error( "ProyectForm not found (" . $id_form . "). ", ERR_DB_NOT_FOUND, 2 ); 
				}
			} else { 
				$this->set_error( "An error ocurred while querying the Data Base. ", ERR_DB_QRY, 2 );
			} 
		}
	} 
	 
	/**
	 * set_content()
	 * Sets the form prices info from the DB
	 */
	protected function set_content(){
		$this->sections = array();
		if ( $this->id_form > 0 ){
			global $obj_bd;
			$query = "SELECT "
						. " id_form_section, fms_title, fms_description " 
					. " FROM " . PFX_PRY_DB . "form_section "  
					. " WHERE fms_status > 0 AND fms_frm_id_form = :id_form  "; 
			$resp = $obj_bd->query($query, array( ':id_form' => $this->id_form )); 
			if ( $resp !== FALSE ){
				if ( count( $resp ) > 0 ){ 
					foreach ($resp as $k => $sec) {
						$section = new stdClass;
						$section->id_section	= $sec['id_form_section'];
						$section->title			= $sec['fms_title'];
						$section->description	= $sec['fms_description']; 
						
						$section->questions 	= $this->get_questions( $section->id_section ); 
						$this->sections[] 		= $section;
					} 
				}
			} else {
				$this->set_error("  An error occured while querying for the form section ( " . $this->id_form . " ) ", ERR_DB_QRY);
			}
		} 
	}
	  
	/**
	 * get_questions()
	 * Sets the form prices info from the DB
	 */
	protected function get_questions( $id_section ){
		$resp = array(); 
		if ( $id_section > 0 ){
			global $obj_bd;
			$query = "SELECT "
						. " id_question, id_question_type, qt_question_type, qs_order, qs_question, qs_options, qs_correct, qs_weight " 
					. " FROM " . PFX_PRY_DB . "question "   
						. " INNER JOIN " . PFX_MAIN_DB . "question_type ON id_question_type = qs_qt_id_question_type "
					. " WHERE qs_status > 0  AND qs_fms_id_form_section = :id_section ORDER BY qs_order ASC "; 
			$result = $obj_bd->query($query, array( ':id_section' => $id_section )); 
			if ( $result !== FALSE ){
				if ( count( $result ) > 0 ){ 
					foreach ($result as $k => $qs) {
						$question = new stdClass;
						$question->id_question		= $qs['id_question'];
						$question->id_question_type	= $qs['id_question_type'];
						$question->question_type	= $qs['qt_question_type'];
						
						$question->order			= $qs['qs_order'];
						$question->question			= $qs['qs_question'];
						$question->options			= $qs['qs_options'];
						$question->correct			= $qs['qs_correct'];
						$question->weight			= $qs['qs_weight'];
						 
						$resp[] = $question;
					} 
				}
			} else {
				$this->set_error(" An error occured while querying for the questions ( " . $this->id_form . ", " . $id_section . ")", ERR_DB_QRY);
			}
		} 
		return $resp;
	}

	/**
	 * get_section_info()
	 * 
	 * @param 	$id_section
	 * 
	 * @return 	$section 
	 */
	 public function get_section_info( $id_section = 0 ){
	 	if ( $this->id_form > 0 && $id_section > 0 ){
	 		global $obj_bd;
	 		$query = "SELECT id_form_section, fms_title, fms_description " 
	 					. " FROM " . PFX_PRY_DB . "form_section "
					. " WHERE id_form_section = :id_section AND fms_frm_id_form = :id_form " ;
			$params = array( 'id_section' => $id_section, ':id_form' => $this->id_form);
			$result = $obj_bd->query($query, $params);
			if ( $result !== FALSE ){
				$sec = $result[0];
				$section = new stdClass;
				$section->id_section  = $sec['id_form_section'];
				$section->title		  = $sec['fms_title'];
				$section->description = $sec['fms_description'];
				return $section;
			} else {
				$this->set_error(" An error occured while querying for the section ( " . $id_section . "). ", ERR_DB_QRY );
	 			return FALSE;
			}
	 	} else {
	 		$this->set_error(" Invalid parameters for section info. ", ERR_VAL_INVALID );
	 		return FALSE;
	 	}
	 }
	
	/**
	 * get_section()
	 * 
	 * @param	$id_section
	 */
	 public function get_section( $id_section ) {
	 	if ( $id_section > 0 ){
	 		foreach ($this->sections as $k => $section) {
				 if ( $section->id_section == $id_section )
				 	return $section;
			 }
			 return FALSE;	
	 	} else {
	 		$this->set_error(" Invalid section id. ", ERR_VAL_INVALID );
	 		return FALSE;
	 	} 
	 }
	
	/**
	 * get_question_info()
	 * 
	 * @param 	$id_question
	 * 
	 * @return 	$section 
	 */
	 public function get_question_info( $id_question = 0 ){
	 	if ( $this->id_form > 0 && $id_question > 0 ){
	 		global $obj_bd;
	 		$query = "SELECT " 
	 					. " id_question, id_form_section, fms_title, id_question_type, qt_question_type, "
	 					. " qs_question, qs_order, qs_options, qs_correct, qs_weight, qs_status " 
	 				. " FROM " . PFX_PRY_DB . "question "
	 					. " INNER JOIN " . PFX_PRY_DB . "form_section ON id_form_section = qs_fms_id_form_section "
	 					. " INNER JOIN " . PFX_MAIN_DB . "question_type ON id_question_type = qs_qt_id_question_type "
					. " WHERE id_question = :id_question AND fms_frm_id_form = :id_form " ;
			$params = array( 'id_question' => $id_question, ':id_form' => $this->id_form);
			$result = $obj_bd->query($query, $params);
			if ( $result !== FALSE ){
				$sec = $result[0];
				$question = new stdClass;
				$question->id_question  	= $sec['id_question'];
				$question->id_form_section	= $sec['id_form_section'];
				$question->id_section		= $sec['id_form_section'];
				$question->id_question_type = $sec['id_question_type'];
				
				$question->section_title	= $sec['fms_title'];
				$question->question_type 	= $sec['qt_question_type'];
				$question->question			= $sec['qs_question'];
				$question->order			= $sec['qs_order'];
				$question->options			= $sec['qs_options'];
				$question->correct 			= $sec['qs_correct'];
				$question->weight			= $sec['qs_weight'];
				 
				return $question;
			} else {
				$this->set_error(" An error occured while querying for the question ( " . $id_question . "). ", ERR_DB_QRY );
	 			return FALSE;
			}
	 	} else {
	 		$this->set_error(" Invalid parameters for question info. ", ERR_VAL_INVALID );
	 		return FALSE;
	 	}
	 }
	   
	/**
	 * get_array()
	 * returns an Array with form information 
	 * 
	 * @return	$array Array width User information
	 */
	 public function get_array( ){ 
		return array(
	 					'id_form' 		=> $this->id_form, 
	 					'form' 			=> $this->title,   
	 					'description'	=> $this->description,  
	 					'expiration'	=> $this->expiration,
	 					 
						'id_form_type'	=> $this->id_form_type,
						'form_type'		=> $this->form_type, 
						
						'content'		=> $this->sections, 
						
	 					'timestamp'		=> $this->timestamp
					);
	 }
	
	/**
	 * get_info_html()
	 * returns a String of HTML with Form information
	 *  
	 * @return	$html String html user info template
	 */
	 public function get_info_html(){
	 	$html  = "";
		$form = $this;
		ob_start();
		require_once DIRECTORY_VIEWS . "form/info.form.php"; 
		$html .= ob_get_contents();
		ob_end_clean(); 
		return str_replace(array("\n", "\t"), "", $html);
	 } 
	 
	/**
	* clean()    
	* Cleans all parameters and resets all objects
	*  
	*/  
	public function clean(){
		$this->id_form 	=  0;
		$this->title		= "";
		$this->description	= "";
 
		$this->id_form_type	= 0;
		$this->form_type	= "";
		
		$this->sections 		= array();
		$this->error 		= array();
	}
	
}

?>