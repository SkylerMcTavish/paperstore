<?php
/**
* Contact CLass
* 
* @package		SF Tracker			
* @since        18/05/2014
* @author		Manuel Fernández
*/ 

class Contact extends Object {
	
	public $id_contact; 
	
	public $id_user;
	public $name;
	public $lastname;
	public $sex; 
	public $telephone;
	public $cellphone;
	public $timestamp;
	
	public $meta  = array();
	
	public $error = array();
	
	/**
	* Contact()    
	* Creates a User object from the DB.
	*  
	* @param	$id_contact (optional) If set populates values from DB record. 
	* 
	*/  
	function Contact( $id_contact = 0 ){
		global $obj_bd;
		$this->error = array();
		if ( $id_contact > 0 ){
			$query = "SELECT "
							. " id_contact, co_us_id_user, co_name, co_lastname, co_sex, "
							. " co_telephone, co_cellphone, co_timestamp, co_status "
						. " FROM " . PFX_MAIN_DB . "contact " 
					. " WHERE id_contact = " . $id_contact; 
			$info = $obj_bd->query( $query );
			if ( $info !== FALSE ){
				if ( count($info) > 0 ){
					$usr = $info[0];
					$this->id_contact 		= $usr['id_contact'];
					$this->id_user	 		= $usr['co_us_id_user'];
					
					$this->name		 		= $usr['co_name'];
					$this->lastname		 	= $usr['co_lastname'];
					$this->sex			 	= $usr['co_sex']; 
					 
					$this->telephone	 	= $usr['co_telephone'];
					$this->cellphone	 	= $usr['co_cellphone'];
					$this->timestamp	 	= $usr['co_timestamp'];
					
					$this->set_address(); 
					$this->set_meta(); 
					
				} else {
					$this->clean();
					$this->set_error( "Contact not found (" . $id_contact . "). ", ERR_DB_NOT_FOUND, 2 ); 
				}
			} else {
				$this->clean();
				$this->set_error( "An error ocurred while querying the Data Base. ", ERR_DB_QRY, 2 );
			} 
		} else {
			$this->clean();
		}  
	}

	public function set_from_user( $id_user ){
		global $obj_bd;
		$this->error = array();
		if ( $id_user > 0 ){
			$query = "SELECT "
							. " id_contact, co_us_id_user, id_contact_type, ct_contact_type, " 
							. " co_name, co_lastname, co_sex, co_email "
							. " co_telephone, co_cellphone, co_timestamp, co_status "
						. " FROM " . PFX_MAIN_DB . "contact "
							. " INNER JOIN " . PFX_MAIN_DB . "contact_type ON id_contact_type = co_ct_id_contact_type "
					. " WHERE co_us_id_user = :id_user "; 
			$info = $obj_bd->query( $query, array( ':id_user' => $id_user ) );
			if ( $info !== FALSE ){
				if ( count($info) > 0 ){
					$usr = $info[0];
					$this->id_contact 		= $usr['id_contact'];
					$this->id_user	 		= $usr['co_us_id_user'];
					
					$this->name		 		= $usr['co_name'];
					$this->lastname		 	= $usr['co_lastname'];
					$this->sex			 	= $usr['co_sex'];
					$this->email		 	= $usr['co_email']; 
					$this->telephone	 	= $usr['co_telephone'];
					$this->cellphone	 	= $usr['co_cellphone'];
					$this->timestamp	 	= $usr['co_timestamp'];
					
					$this->id_type		 	= $usr['id_contact_type'];
					$this->type			 	= $usr['ct_contact_type'];
					
					$this->set_address(); 
					$this->set_meta(); 
					
				} else {
					$this->clean();  
				}
			} else {
				$this->clean();
				$this->set_error( "An error ocurred while querying the DB. ", ERR_DB_QRY, 2 );
			} 
		} else {
			$this->clean();
			$this->set_error( "Invalid User. ", ERR_VAL_INVALID , 1 );
		}  
	}

	/**
	 * set_meta()
	 * Sets the contact meta options and values
	 * 
	 */
	private function set_meta(){ 
		if ( !class_exists( 'ContactMeta' ) ) 
	  		require_once 'class.contact_meta.php';
		$this->meta = new ContactMeta( $this->id_contact ); 
	}
	 
	/**
	* validate()    
	* Validates the values before inputing to Data Base 
	*  
	* @return        Boolean TRUE if valid; FALSE if invalid
	*/ 
	public function validate(){ 
		global $Validate; 
		if ( !$this->name != '' ){
			$this->set_error( 'Name value empty. ', ERR_VAL_EMPTY );
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
		if ( $this->validate() ){
			global $obj_bd;
			
			$values = array(
							':id_user' 		=> $this->id_user,
							':co_name'		=> $this->name,
							':co_lastname'	=> $this->lastname,
							':co_sex'		=> ( $this->sex == 'F' ? 'F' : 'M' ),
							':co_telephone'	=> $this->telephone,
							':co_cellphone'	=> $this->cellphone,
							':co_timestamp'	=> time()
						);
			
			if ( $this->id_contact > 0 ){
				$query = " UPDATE " . PFX_MAIN_DB . "contact SET " 
							. " co_us_id_user= :id_user, " 
							. " co_name 	 = :co_name, "
							. " co_lastname  = :co_lastname, "
							. " co_sex 		 = :co_sex, " 
							. " co_telephone = :co_telephone, "
							. " co_cellphone = :co_cellphone, "
							. " co_status	 = 1, "
							. " co_timestamp = :co_timestamp "
						. " WHERE id_contact = :id_contact ";
				$values[':id_contact'] = $this->id_contact;
			} else {
				$query = "INSERT INTO " . PFX_MAIN_DB . "contact " 
						. " ( co_us_id_user, co_name, co_lastname, co_sex, co_telephone, co_cellphone, co_status, co_timestamp ) "
						. " VALUES ( :id_user, :co_name, :co_lastname, :co_sex, :co_telephone, :co_cellphone, 1, :co_timestamp ) ";
			} 
			$result = $obj_bd->execute( $query );
			if ( $result !== FALSE ){
				if ( $this->id_contact == 0){
					 $this->id_contact = $obj_bd->get_last_id(); 
				}
				return $this->meta->save_values( $this->id_contact );
			} else {
				$this->set_error( "An error ocurred while trying to save the record. ", ERR_DB_EXEC, 3 );
				return FALSE;
			} 
		}
	} 
	 
	/**
	* delete()    
	* Changes status from User to 0 in the DB.. 
	*
	* @return 	TRUE on success; FALSE otherwise 
	*/  
	public function delete(){
		if ( IS_ADMIN ){
			global $obj_bd;
			$query = " UPDATE "  . PFX_MAIN_DB . "contact SET co_status = 0 "
					. " WHERE id_contact = :id_contact ";
			$result = $obj_bd->execute( $query, array( ':id_contact' => $this->id_contact ) );
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
	* set_address()    
	* Creates a Contact object related to the User
	* @param         $id_address ( 0 )
	*  
	*/  
	private function set_address( $id_address = 0 ){
		if ( $id_address > 0 ){
			/* 
			 * if ( !is_classexists( 'Address' ) ) 
			 * 		requier_once 'class.address.php';
			 * $this->address = new Address( $id_address );
			 *  
			 * */ 
		} else {
			/* TODO: Query Data Base for address, create object if exists  */
		} 
	}
	
	/**
	 * get_pic()
	 * returns a String to be input as HTML img src attribute
	 * 
	 * @return	$resp String to be inserted in HTMl img src attribute.
	 */
	 public function get_pic(){ 
 		if ( $this->sex == 'F'){
 			$resp = DIRECTORY_IMAGES . "ico_ella.png";
 		} else {
			$resp = DIRECTORY_IMAGES . "ico_el.png";
		} 
		return $resp;
	 }
	
	/**
	 * get_array()
	 * returns an Array with contact information
	 * 
	 * @param 	$full Boolean if TRUE returns Contact and Instance Arrays (default FALSE)
	 * 
	 * @return	$array Array width User information
	 */
	 public function get_array( $full = FALSE ){
	 	$array = array(
	 					'id_contact' 	=>	$this->id_contact, 
	 					'name'	 		=>	$this->name,
	 					'lastname'		=>	$this->lastname,
	 					'sex'	 		=>	$this->sex, 
	 					'telephone'		=>	$this->telephone,
	 					'cellphone'		=>	$this->cellphone
	 					/* TODO: get_meta_array() */
					); 
		return $array;
	 }
	
	/**
	* clean()    
	* Cleans all parameters and resets all objects
	*  
	*/  
	public function clean(){
		$this->id_contact 	=  0;
		$this->contact 		= "";
		
		$this->id_type 		=  0;
		$this->type 		= "";
		
		$this->name		 	= "";
		$this->lastname 	= "";
		$this->sex		 	= "";
		$this->email		= "";
		$this->telephone	= "";
		$this->cellphone	= ""; 
		
		$this->avatar		= DIRECTORY_IMAGES . "ico_el.png";
		$this->thumb		= DIRECTORY_IMAGES . "ico_el.png";
		
		$this->set_meta(); 
		$this->error = array();
		
	}
}

?>