<?php
class Freeday extends Object{
	
	public $id_free_day; 
	public $free_day; 
	public $day;	
	public $timestamp;	
	public $error = array();
	
	/**
	  * Typeform()
	  * 
	  */
	public function Freeday($id_free_day=0){
		global $obj_bd;
		$this->error = array();
		if ( $id_free_day > 0 ){
			$query = "SELECT id_free_day, fd_date_string, fd_date_timestamp "
						. " FROM " . PFX_PRY_DB . "free_day"  
					. " WHERE id_free_day = :id_free_day  "; 
			$info = $obj_bd->query( $query, array( ':id_free_day' => $id_free_day ) );
			global $Log;
			$Log->write_log('qry SELECT: [' . $query . ']');
			if ( $info !== FALSE ){
				if ( count($info) > 0 ){ 
					$usr = $info[0];
					$this->id_free_day = $usr['id_free_day'];
					$this->free_day	= $usr['fd_date_string']; 
					$this->day	= $usr['fd_date_timestamp']; 
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
	public function delete(){
		global $Session;
		if ( $Session->is_admin() ){
			global $obj_bd;
			
			$query = " DELETE FROM "  . PFX_PRY_DB . "free_day WHERE id_free_day ='$this->id_free_day'";			
			$values=array( ':id_free_day' => $this->id_free_day);
			$result = $obj_bd->execute( $query, $values );
			global $Log;
			$Log->write_log('qry DELETE: [' . $query . ']');
			if ( $result !== FALSE ){
				$this->clean();
				return TRUE;
			} else {
				$this->set_error( "An error ocurred while trying to delete id. ", ERR_DB_EXEC, 3 );
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
		if ( !$this->free_day != '' ){
			$this->set_error( 'Type For value empty. ', ERR_VAL_EMPTY );
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
				if ( $this->id_free_day > 0 ){
					$values = array( 								
								':fd_date_string' 	=> $this->free_day, 
								':fd_date_timestamp' => $this->day,	
								':id_free_day'  => $this->id_free_day							
								); 
					$query = " UPDATE " . PFX_PRY_DB . "free_day SET "  
								. " fd_date_string 		= :fd_date_string , " 						
								. " fd_date_timestamp 	= :fd_date_timestamp "
							. " WHERE id_free_day 	= :id_free_day ";
				} else {				
						$query = "INSERT INTO " . PFX_PRY_DB . "free_day (fd_date_string, fd_date_timestamp) "
							. " VALUES (:fd_date_string, :fd_date_timestamp)";					
						$values = array( 								
								':fd_date_string' 	=> $this->free_day, 
								':fd_date_timestamp' => $this->day								
								); 
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
	 					'id_free_day' 	=> $this->id_free_day, 
	 					'free_day' 		=> $this->free_day,   	 	
	 					'day'			=> date("d-m-Y", $this->day)
					);
	 }
	 
	/**
	* clean()    
	* Cleans all parameters and resets all objects
	*  
	*/  
	public function clean(){	
		$this->id_free_day	= 0;
		$this->free_day	= "";
		$this->day	= "";			
		$this->error 		= array();
	}
	
	
} ?>