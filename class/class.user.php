<?php
/**
* User CLass
* 
* @package		SF·Tracker			
* @since        18/05/2014
* @author		Manuel Fernández
*/ 
class User extends Object {
	
	public $id_user;
	public $user;
	public $password;
	
	public $id_profile;
	public $profile; 
	public $lastlogin;
	public $permissions;
	
	public $contact;
	public $instance;
	
	public $error = array();
	
	/**
	* User()    
	* Creates a User object from the DB.
	*  
	* @param	$id_user (optional) If set populates values from DB record. 
	* 
	*/  
	function User( $id_user = 0 ){
		global $obj_bd;
		$this->class = "User";
		$this->error = array(); 
		if ( $id_user > 0 ){
			$query = "SELECT id_user, us_user, id_profile, pf_profile, us_lastlogin "
						. " FROM " . PFX_MAIN_DB . "user "
						. " INNER JOIN " . PFX_MAIN_DB . "profile ON id_profile = us_pf_id_profile "
					. " WHERE id_user = :id_user " ; 
			$params = array( ':id_user' => $id_user );
			$info = $obj_bd->query( $query, $params );
			if ( $info !== FALSE ){
				if ( count($info) > 0 ){
					$usr = $info[0];
					$this->id_user 		= $usr['id_user'];
					$this->user	 		= $usr['us_user'];
					$this->id_profile 	= $usr['id_profile'];
					$this->lastlogin 	= $usr['us_lastlogin'];
					
					$this->set_profile();
					$this->set_contact();
				}
				else
				{
					$this->clean();
					$this->set_error( "User not found (" . $id_user . "). ", ERR_DB_NOT_FOUND, 2 ); 
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
	* validate()    
	* Validates the values before inputing to Data Base 
	*  
	* @return        Boolean TRUE if valid; FALSE if invalid
	*/ 
	public function validate(){
		
		global $Validate;
		
		if ( !$this->user != '' ){
			$this->set_error( 'User value empty. ', ERR_VAL_EMPTY );
			return FALSE;
		}
		if ( !$Validate->is_unique( 'user', 'us_user', $this->user, 'id_user', $this->id_user ) ){
			$this->set_error( 'User not unique. ', ERR_VAL_NOT_UNIQUE );
			return FALSE;
		} 
		if ( !$this->id_profile > 0 || !$Validate->exists( 'profile', 'id_profile', $this->id_profile)){
			$this->set_error( 'Invalid profile. ', ERR_VAL_EMPTY );
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
			
			if ( $this->id_user > 0 ){

				$query = " UPDATE " . PFX_MAIN_DB . "user SET ".
							" us_user			= :us_user, ".
							" us_pf_id_profile	= :us_id_profile,".
							" us_timestamp		= :us_timestamp".
							" WHERE id_user 	= :id_user ";
				 
				 	$values = array( 
							':us_user' 		 => $this->user, 
							':id_user' 		 => $this->id_user, 
							':us_id_profile' => $this->id_profile, 
							':us_timestamp'  => time() 
						);
					
				$result = $obj_bd->execute( $query, $values );
		
				if ( $result !== FALSE ){ 
					return TRUE;
				} else {
					$this->set_error( "An error ocurred while trying to update the password in the DB. ", ERR_DB_EXEC, 3 );
					return FALSE;
				}  
			}
			else
			{
				
				if ( $this->password == "" )
				{  
					$this->password = generate_password(); 
				}
				$values = array( 
							':us_user' 		 => $this->user, 							
							':us_id_profile' => $this->id_profile,
							':us_password'	 => md5($this->password), 
							':us_timestamp'  => time(),
						);
				
				$query = "INSERT INTO " . PFX_MAIN_DB . "user " 
						. "( us_user, us_pf_id_profile, us_password, us_timestamp, us_status) "
						. " VALUES ( :us_user, :us_id_profile, :us_password, :us_timestamp, '1')" ;
						
				$notify = TRUE;
				$result = $obj_bd->execute( $query, $values );
				
			}
			
			if ( $result !== FALSE ){
				if ( $this->id_user == 0){
					 $this->id_user = $obj_bd->get_last_id();
					/* TODO: Notify New user of password 
					 *  return $this->notify_user_password($this->password);
					 * */ 
					 return TRUE;
				}
				return TRUE;
			} else {
				$this->set_error( "An error ocurred while trying to save the record. ", ERR_DB_EXEC, 3 );
				return FALSE;
			} 
		}
	}

	/**
	* set_password()    
	* IF password is empty, generates a new password.  
	* Either way it sends the password on an e-mail to the user.
	* 
	* @param	$flag TRUE sets new user email template; FALSE sets change password email template. (Default is FALSE)
	* 
	* @return	TRUE if password was saved correctly: FALSE otherwise.
	*/  
	public function set_password( $flag = FALSE ){
		if ( $this->password == "" ){  
			$this->password = generate_password(); 
		}
		$hash = md5( $this->password );
		$values = array( 
						':us_password' => $hash, 
						':us_timestamp' => time(), 
						':id_user' => $this->id_user 
					);
		
		global $obj_bd;
		$query = " UPDATE "  . PFX_MAIN_DB . "user SET "
					. " us_password  = :us_password , us_timestamp = :us_timestamp "
				. " WHERE id_user = :id_user ";
		/*$query = " UPDATE "  . PFX_MAIN_DB . "user SET "
					. " us_password  = '$hash' , us_timestamp = 'time()' "
				. " WHERE id_user = '$this->id_user' ";*/
		
					
		$result = $obj_bd->execute( $query, $values );
		
		if ( $result !== FALSE ){ 
			/* TODO: Notify New user of password 
			 *  return $this->notify_user_password($this->password);
			 * */ 
			return TRUE;
		} else {
			$this->set_error( "An error ocurred while trying to update the password in the DB. ", ERR_DB_EXEC, 3 );
			return FALSE;
		} 
	}
	
	/**
	* delete()    
	* Changes status from User to 0 in the DB.. 
	* 
	*/  
	public function delete(){
		global $Session; 
		if ( $Session->is_admin() ){
			global $obj_bd;
			$query = " UPDATE "  . PFX_MAIN_DB . "user SET us_status = 0 WHERE id_user = :id_user ";
			$result = $obj_bd->execute( $query, array(':id_user' => $this->id_user ) );
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
	* set_contact()    
	* Creates a Contact object related to the User
	* @param         $id_contact ( 0 )
	*  
	*/  
	private function set_contact( $id_contact = 0 ){ 
		if ( $id_contact == 0 ){ 
			if ( $this->id_user > 0 ){ 
				global $obj_bd;
				$query = "SELECT id_contact FROM " . PFX_MAIN_DB . "contact WHERE co_us_id_user = :co_id_user " ;
				$info = $obj_bd->query( $query, array( ':co_id_user' => $this->id_user ) );
				if ( $info !== FALSE ) {
					if ( count( $info ) > 0 )
						$id_contact = $info[0]['id_contact'];
				} else{
					$this->set_error( "An error ocurred while trying to query the DB for the contact information. ", ERR_DB_QRY, 2 );
				}
			} 
		} 
		if ( !class_exists( 'Contact' ) ) 
	  		require_once 'class.contact.php';
		$this->contact = new Contact( $id_contact );
	} 
	
	/**
	* set_profile()    
	* Creates a Profile object related to the User
	* @param         $id_contact ( 0 )
	*  
	*/  
	private function set_profile( ){
		if ( $this->id_profile > 0 ){
			 if ( !class_exists('Profile' ) ) 
			 		require_once 'class.profile.php';
			 $this->profile = new Profile( $this->id_profile ); 
		} 
	}
	
	
	/**
	 * get_array()
	 * returns an Array with user information
	 * 
	 * @param 	$full Boolean if TRUE returns Contact and Instance Arrays (default FALSE)
	 * 
	 * @return	$array Array with User information
	 */
	 public function get_array( $full = FALSE ){
	 	$array = array(
	 					'id_user' 		=>	$this->id_user,
	 					'user' 			=>	$this->user,
	 					'profile' 		=>	$this->profile->profile
					);
		
		if ($full){
	 		$array['profile']	= $this->profile->get_array();
		} 
		return $array;
	 }
	
	/**
	 * get_user_html()
	 * returns a String of HTML with user information
	 * 
	 * @param 	$full Boolean if TRUE returns Contact and Instance Arrays (default FALSE)
	 * 
	 * @return	$html String html user info template
	 */
	 public function get_user_html( $full = FALSE ){
	 	$html  = "";
		$user = $this;
		ob_start();
		require_once DIRECTORY_VIEWS . "admin/info.user.php"; 
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
		$this->id_user = 0;
		$this->user = "";
		
		$this->id_profile = 0;
		$this->profile = ""; 
		$this->permissions 	= "";
		$this->password 	= "";
		$this->lastlogin 	= 0;
		$this->jde			= '';
		
		$this->contact = new stdClass;
		
		$this->error = array();
		
	}
	 
}

?>