<?php
/**
* Supplier CLass
* 
* @package		SF Tracker			
* @since        11/11/2014 
* 
*/ 
class Supplier extends Object {
	
	public $id_supplier; 
	public $supplier; 
	
	public $timestamp;
	
	public $branches = array();
	public $error = array();
	
	/**
	* User()    
	* Creates a User object from the DB.
	*  
	* @param	$id_supplier (optional) If set populates values from DB record. 
	* 
	*/  
	function Supplier( $id_supplier = 0 ){
		global $obj_bd;
		$this->error = array();
		if ( $id_supplier > 0 ){
			$query = "SELECT id_supplier, su_supplier, su_timestamp, su_status "
						. " FROM " . PFX_MAIN_DB . "supplier "  
					. " WHERE id_supplier = :id_supplier  "; 
			$info = $obj_bd->query( $query, array( ':id_supplier' => $id_supplier ) );
			if ( $info !== FALSE ){
				if ( count($info) > 0 ){ 
					$usr = $info[0];
					$this->id_supplier 	= $usr['id_supplier'];
					$this->supplier		= $usr['su_supplier']; 
					$this->timestamp	= $usr['su_timestamp']; 
					
					$this->get_branches();
				} else {
					$this->clean();
					$this->set_error( "Supplier not found (" . $id_supplier . "). ", ERR_DB_NOT_FOUND, 2 ); 
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
	 * get_branches()
	 * Retrieves the branches records related to the supplier from the DB
	 * 
	 */
	private function get_branches(){
		$this->branches = array();
		if ( $this->id_supplier > 0 ){
			global $obj_bd; 
			$query = "SELECT id_branch, ba_branch, ba_number FROM " . PFX_MAIN_DB . "branch WHERE ba_su_id_supplier = :id_supplier AND ba_status = 1 ";
			$branches = $obj_bd->query( $query, array( ':id_supplier' => $this->id_supplier ) );
			if ( $branches !== FALSE ){
				foreach ($branches as $k => $br) {
					$b = new stdClass;
					$b->id_branch = $br['id_branch'];
					$b->branch 	  = $br['ba_branch'];
					$b->num		  = $br['ba_number']; 
					$this->branches[] = $b; 
				}
			} else {
				$this->set_error("An error occured while retrieving the branches for supplier ( " . $this->id_supplier . " ) ", ERR_DB_QRY, 2);
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
		if ( !$this->supplier != '' ){
			$this->set_error( 'Supplier value empty. ', ERR_VAL_EMPTY );
			return FALSE;
		} 
		if ( !$Validate->is_unique( 'supplier', 'su_supplier', $this->supplier, 'id_supplier', $this->id_supplier ) ){
			$this->set_error( 'User not unique. ', ERR_VAL_NOT_UNIQUE );
			return FALSE;
		} 
		return TRUE; 
	}
	
	/**
	* save()    
	* Inserts or Update the record in the DB. 
	* 
	*/  
	public function save(){
		global $Session;
		global $obj_bd;
		if ( $Session->is_admin() ){
			
		
					
			if ( $this->validate() ){
				
				
				
				if ( $this->id_supplier > 0 ){
						$values = array( 
								':su_supplier' 	=> $this->supplier, 
								':su_timestamp' => time(),
								':id_supplier'  => $this->id_supplier,
								); 
						
					
					$query = " UPDATE " . PFX_MAIN_DB . "supplier SET "  
								. " su_supplier 	= :su_supplier , " 
								. " su_status	 	= 1, "
								. " su_timestamp 	= :su_timestamp "
							. " WHERE id_supplier 	= :id_supplier ";
				} else {
					$values = array( 
								':su_supplier' 	=> $this->supplier, 
								':su_timestamp' => time(),						
								); 
						
						$query = "INSERT INTO " . PFX_MAIN_DB . "supplier ( su_supplier, su_status, su_timestamp ) "
							. " VALUES  ( :su_supplier, 1, :su_timestamp) ";	
						
				}  
				$result = $obj_bd->execute( $query, $values );
				global $Log;
				$values = array( 
								':su_supplier' 	=> $this->supplier, 
								':su_timestamp' => time(),
								':id_supplier'  => $this->id_supplier,
								); 
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
		}/**/
	}
	
	/****
	 * save_branch()
	 * Saves a branch record for the Supplier
	 * 
	 */
	public function save_branch( $branch ){
		global $Session;
		if ( $Session->is_admin() ){
			global $obj_bd;
			
			$values = array(
							':id_supplier' => $this->id_supplier,
							':ba_branch' => $branch->branch,
							':ba_number' => $branch->num,
							':ba_timestamp' => time()
						);
			
			if ( $branch->id_branch > 0 ){
				$values[':id_branch'] = $branch->id_branch;
				$query = "UPDATE " . PFX_MAIN_DB . "branch SET "
							. " ba_su_id_supplier = :id_supplier, " 
							. " ba_branch = :ba_branch, " 
							. " ba_number = :ba_number, " 
							. " ba_status = 1, " 
							. " ba_timestamp = :ba_timestamp " 
						. " WHERE id_branch = :id_branch "; 
			} else {
				$query = " INSERT INTO " . PFX_MAIN_DB . "branch (ba_su_id_supplier, ba_branch, ba_number, ba_status, ba_timestamp ) "
						. " VALUES  (:id_supplier, :ba_branch, :ba_number, 1, :ba_timestamp ) "; 
			} 
			$result = $obj_bd->execute( $query, $values );
			if ( $result !== FALSE ){ 
				return TRUE;
			} else {
				$this->set_error( "An error ocurred while trying to save the branch. ", ERR_DB_EXEC, 3 );
				return FALSE;
			} 
			
		} else {
			$this->set_error("Restricted action.", SES_RESTRICTED_ACTION);
			return FALSE;
		}
		
	}
	 
	/**
	* delete()    
	* Changes status for Supplier to 0 in the DB.
	*
	* @return 	TRUE on success; FALSE otherwise 
	*/  
	public function delete(){
		global $Session;
		if ( $Session->is_admin() ){
			global $obj_bd;
			$query = " UPDATE "  . PFX_MAIN_DB . "supplier SET su_status = 0 WHERE id_supplier = :id_supplier ";
			$result = $obj_bd->execute( $query, array( ':id_supplier' => $this->id_supplier ) );
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
	* delete_branch()    
	* Changes status for Branch to 0 in the DB. 
	*
	* @return 	TRUE on success; FALSE otherwise 
	*/  
	public function delete_branch($id_branch){
		global $Session;
		if ( $Session->is_admin() ){
			global $obj_bd;
			$query = " UPDATE "  . PFX_MAIN_DB . "branch SET ba_status = 0 WHERE id_branch = :id_branch ";
			$result = $obj_bd->execute( $query, array( ':id_branch' => $id_branch ) );
			if ( $result !== FALSE ){ 
				return TRUE;
			} else {
				$this->set_error( "An error ocurred while trying to set status to 0. ", ERR_DB_EXEC, 3 );
				return FALSE;
			} 
		}
	}
	
	
	 
	/**
	 * get_array()
	 * returns an Array with supplier information
	 * 
	 * @param 	$full Boolean if TRUE returns Supplier and Instance Arrays (default FALSE)
	 * 
	 * @return	$array Array width User information
	 */
	 public function get_array( ){
	 	$array = array(
	 					'id_supplier' 	=> $this->id_supplier, 
	 					'supplier' 		=> $this->supplier,  
	 					'timestamp'		=> $this->timestamp,
	 					'branches'		=> $this->branches
					); 
		
		return $array;
	 }
	
	/**
	 * get_info_html()
	 * returns a String of HTML with user information
	 * 
	 * @param 	$full Boolean if TRUE returns Contact and Instance Arrays (default FALSE)
	 * 
	 * @return	$html String html user info template
	 */
	 public function get_info_html(){
	 	$html  = "";
		$supplier = $this;
		ob_start();
		require_once DIRECTORY_VIEWS . "admin/info.supplier.php"; 
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
		$this->id_supplier 	=  0;
		$this->supplier 		= "";
		 
		$this->timestamp 	= 0; 
		$this->branches = array(); 
		$this->error = array(); 
	}
	 
}

?>