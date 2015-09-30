<?php
/**
* User Profile
* 
* @package		Meta Tracker			
* @since        18/05/2014
* @author		Manuel Fernández
*/ 

class Profile extends Object {
	
	public $id_profile;
	public $profile; 
	
	public $error = array();
	
	/**
	* User()    
	* Creates a User object from the DB.
	*  
	* @param	$id_user (optional) If set populates values from DB record. 
	* 
	*/ 
	function Profile( $id_profile = 0 ){ 
		if ( $id_profile > 0 ){
			global $obj_bd;
			$query = " SELECT id_profile, pf_profile FROM " . PFX_MAIN_DB . "profile "
					. " WHERE id_profile = :id_profile ";
			$result = $obj_bd->query( $query, array( ':id_profile' => $id_profile ) );
			if ( $result !== FALSE ){
				if ( count( $result ) > 0 ){
					$pf = $result[0];
					$this->id_profile 	= $id_profile;
					$this->profile 		= $pf['pf_profile'];   
				} else {
					$this->clean();
					$this->set_error( "Profile not found (" . $id_profile . "). ", ERR_DB_NOT_FOUND ); 
				}
			} else {
				$this->clean();
				$this->set_error( "An error ocurred while querying the DB. ", ERR_DB_QRY );
			} 
		} else {
			$this->clean();
		} 
	}
	
	
	/**
	* save()    
	* Inserts or Update the record in the DB. 
	* 
	*/  
	public function save(){
		if ( $this->validate() ){
			global $obj_bd;
			if ( $this->id_profile > 0 ){
				$query = " UPDATE " . PFX_MAIN_DB . "profile SET "
							. " pf_profile = '" 	. mysql_real_escape_string( $this->profile ) 	. "', " 
							. " pf_timestamp = " 	. time() . " "
							. " WHERE id_profile = " . $this->id_profile . " ";
			} else {
				$query = "INSERT INTO " . PFX_MAIN_DB . "profile " 
						. "( pf_profile, pf_timestamp, pf_status) "
						. " VALUES ("
						. " '" . mysql_real_escape_string( $this->profile ) . "', " 
						. "  " . time() . ", 1 "  
						. ")"; 
				$result = $obj_bd->execute( $query );
				if ( $result !== FALSE ){ 
					return TRUE;
				} else {
					$this->set_error( "An error ocurred while trying to save the record. ", ERR_DB_EXEC );
					return FALSE;
				} 
			}
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
			$query = " UPDATE "  . PFX_MAIN_DB . "profile SET "
						. " pf_profile = 0 "
					. " WHERE id_profile = " . $this->id_profile . " ";
			$result = $obj_bd->execute( $query );
			if ( $result !== FALSE ){
				$this->clean();
				return TRUE;
			} else {
				$this->set_error( "An error ocurred while trying to set status to 0. ", ERR_DB_EXEC );
				return FALSE;
			} 
		}
	}
	
	public function get_array(){
		return array(
						'id_profile'	=> $this->id_profile,
						'profile'	 	=> $this->profile,
						'permission'	=> $this->permission,
						'description' 	=> $this->description
					);
	} 
	
	/**
	* clean()    
	* Cleans all parameters and resets all objects
	*  
	*/  
	public function clean(){
		
		$this->id_profile 	= 0;
		$this->profile 		= ""; 
		$this->permission 	= "";
		$this->description 	= 0; 
		
		$this->error = array(); 
	}
	 
}
?>