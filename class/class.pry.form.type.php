<?php
class Typeform extends Object{
	
	public $id_type_form; 
	public $form_type; 	
	public $timestamp;	
	public $branches = array();
	public $error = array();
	
	/**
	  * Typeform()
	  * 
	  */
	public function Typeform($id_type_form=0){
		global $obj_bd;
		$this->error = array();
		if ( $id_type_form > 0 ){
			$query = "SELECT id_form_type, fmt_form_type, fmt_status, fmt_timestamp "
						. " FROM " . PFX_MAIN_DB . "pr1_form_type"  
					. " WHERE id_form_type = :id_form_type  "; 
			$info = $obj_bd->query( $query, array( ':id_form_type' => $id_type_form ) );
			global $Log;
			$Log->write_log('qry SELECT: [' . $query . ']');
			if ( $info !== FALSE ){
				if ( count($info) > 0 ){ 
					$usr = $info[0];
					$this->id_form_type = $usr['id_form_type'];
					$this->form_type	= $usr['fmt_form_type']; 
					$this->timestamp	= $usr['fmt_timestamp']; 
				}
			} else {
				$this->clean();
				$this->set_error( "An error ocurred while querying the Data Base. ", ERR_DB_QRY, 2 );
			} 
		} else {
			$this->clean();
		}  
	}
	
	/**
	* delete_type_form()    
	* Changes status for type form to 0 in the DB.
	*
	* @return 	TRUE on success; FALSE otherwise 
	*/  
	public function delete_type_form(){
		global $Session;
		if ( $Session->is_admin() ){
			global $obj_bd;
			
			$query = " UPDATE "  . PFX_PRY_DB . "form_type SET fmt_status = 0 WHERE id_form_type = :id_form_type";
			//$query = " UPDATE "  . PFX_MAIN_DB . "pr1_form_type SET fmt_status = '0' WHERE id_form_type = :id_form_type";
			$values=array( ':id_form_type' => $this->id_form_type);
			$result = $obj_bd->execute( $query, $values );
			global $Log;
			$Log->write_log('qry Update: [' . $query . ']');
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
	* validate()    
	* Validates the values before inputing to Data Base 
	*  
	* @return        Boolean TRUE if valid; FALSE if invalid
	*/ 
	public function validate(){
		
		global $Validate;
		if ( !$this->type_form != '' ){
			$this->set_error( 'Type For value empty. ', ERR_VAL_EMPTY );
			return FALSE;
		} 
		if ( !$Validate->is_unique( 'pr1_form_type', 'fmt_form_type', $this->type_form, 'id_form_type', $this->id_type_form) ){
			$this->set_error( 'User not unique. ', ERR_VAL_NOT_UNIQUE );
			return FALSE;
		} 
		return TRUE; 
	}
	
	/**
	* save()    
	* Inserts or Update the record in the DB. 
	**/
	 
 	public function save(){
		global $Session;
		global $obj_bd;
		if ( $Session->is_admin() ){
			if ( $this->validate() ){				
				if ( $this->id_type_form > 0 ){
						$values = array( 
								':fmt_form_type' 	=> $this->type_form, 
								':fmt_timestamp' => time(),
								':id_form_type'  => $this->id_type_form,
								); 
						
					
					$query = " UPDATE " . PFX_PRY_DB . "form_type SET "  
								. " fmt_form_type 	= :fmt_form_type , " 
								. " fmt_status	 	= 1, "
								. " fmt_timestamp 	= :fmt_timestamp "
							. " WHERE id_form_type 	= :id_form_type ";
				} else {
					$values = array( 
								':fmt_form_type' 	=> $this->type_form, 
								':fmt_timestamp' => time(),						
								); 
						$query = "INSERT INTO " . PFX_PRY_DB . "form_type (fmt_form_type,  fmt_status, fmt_timestamp ) "
							. " VALUES (:fmt_form_type, 1, :fmt_timestamp ) ";
						/*$query = "INSERT INTO sf_pr1_form_type ( fmt_form_type, fmt_status, fmt_timestamp ) "
							. " VALUES  ( :fmt_form_type, 1, :fmt_timestamp) ";	*/
						
				}  
				$result = $obj_bd->execute( $query, $values );
				global $Log;
				$Log->write_log('qry Insert: [' . $query . ']');
				if ( $result !== FALSE ){					
					return TRUE;
				} else {
					$this->set_error( "An error ocurred while trying to save the record. ", ERR_DB_EXEC, 3 );
					return FALSE;
				} 
			}
			
		} else {
			$this->set_error("Restricted action.", SES_RESTRICTED_ACTION);
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
	 					'id_form_type' 	=> $this->id_form_type, 
	 					'form_type' 	=> $this->form_type,   	 	
	 					'timestamp'		=> $this->timestamp
					);
	 }
	 
	/**
	* clean()    
	* Cleans all parameters and resets all objects
	*  
	*/  
	public function clean(){	
		$this->id_form_type	= 0;
		$this->form_type	= "";		
		$this->sections 		= array();
		$this->error 		= array();
	}
	
	
} ?>