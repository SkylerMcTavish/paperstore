<?php
/**
 * Class Settings
 * 
 */

class Settings extends Object{
 	
	public $error = array();
	
	function __construct(){
		$this->class = "Settings";
	}
	
	/**
	* get_settings_option()
	* returns the value of the $option from the DB
	* 
	* @param         $option String option key
	* @param 		 $instance Integer (Default 0)  
	* @param 		 $user 		Integer (Default 0) If > 0 sets user filter for the option 
	* 
	* @return 		String value of the option from the DB. NULL on error.
	*/  
	public function get_settings_option( $option, $user = FALSE , $timestamp = FALSE){
		if ( $option != '' ){
			global $obj_bd; 
			global $Session;
			$query = " SELECT so_value, so_timestamp  FROM " . PFX_MAIN_DB . "settings_option "
					. " WHERE so_option = :option " 
						. (( $user ) ? " AND so_us_id_user = :user " : "")
						. " AND so_status = 1 "; 
			$params = array( ':option' =>   $option );
			
			if ( $user ) 
				$params[':user'] = $Session->get_id() ;
			
			$record	= $obj_bd->query( $query, $params );  
			if ( $record !== FALSE ){
				if (count($record) > 0 ){
					if ( $timestamp ) {
						$resp = new stdClass;
						$resp->value 	= $record[0]['so_value'];
						$resp->timestamp= $record[0]['so_timestamp'];
						$resp->key		= $option;
						return $resp;
					} else {
						$resp = $record[0]['so_value'];
					}
					return $resp;
				} else {
					$this->set_error( "Option not found (" . $option . ")", ERR_DB_NOT_FOUND, 1);
					return NULL;
				}
			}else {
				$this->set_error( "Could not retrieve option (" . $option . ")", ERR_DB_QRY, 2);
				return NULL;
			}
		} else{
			$this->set_error( "Invalid option parameter. ", ERR_VAL_EMPTY); 
			return NULL;
		}
	}
	
	/**
	* save_settings_option()
	* Saves an the value for an option in the DB.
	* 
	* @param         $option 	String option key
	* @param 		 $value 	String option value 
	* @param 		 $instance 	Integer (Default 0)  
	* @param 		 $user 		Boolean (Default FALSE) If TRUE sets Session user as filter for the option  
	* 
	* @return 		String value of the option from the DB. NULL on error.
	*/  
	public function save_settings_option( $option , $value, $instance = 0, $user = FALSE  ){
		if ( $option != '' && $value != '' ){
			global $obj_bd;
			global $Session; 
			$query_ex = " SELECT id_settings_option, so_value, so_timestamp  FROM " . PFX_MAIN_DB . "settings_option "
					. " WHERE so_option = :option " 
						. (( $user ) ? " AND so_us_id_user = :so_user " : "")
						. " AND so_status = 1 "; 
			$params = array( ':option' =>   $option ); 
			if ( $user )  
				$params[':so_user'] = $Session->get_id() ; 
			$exists	= $obj_bd->query( $query_ex, $params );  
			if ( $exists !== FALSE ){ 
				$values = array( 
						':so_option' 	=> $option, 
						':so_value' 	=> $value, 
						':so_timestamp' => time(), 
						':so_id_user'	=> $Session->get_id(),
					);
					
				if ( count($exists) > 0 ){
					$values[':id_option'] = $exists[0]['id_settings_option'];
					$query = "UPDATE  " . PFX_MAIN_DB . "settings_option SET "
								. " so_option 	 = :so_option , "
								. " so_value  	 = :so_value , "
								. " so_timestamp = :so_timestamp , "
								. " so_us_id_user= :so_id_user , "
								. " so_status 	 = 1 "
							. " WHERE id_settings_option  = :id_option ";
				}else{ 
					$query = " INSERT INTO " . PFX_MAIN_DB . "settings_option " 
								. "(so_option, so_value, so_timestamp, so_us_id_user, so_status )"
								. "VALUES ( :so_option, :so_value, :so_timestamp, :so_id_user, 1 )";
				} 
							
				$result = $obj_bd->execute( $query, $values );
				if ( $result !== FALSE ){
					$this->set_msg('SAVE', "Option " . $option . " saved. ");
					return TRUE;
				} else { 
					$this->set_error( "An error ocurred while saving the option " . $option . ". ", ERR_DB_EXEC, 3 );
					return FALSE;
				}
			}
			else {
				$this->set_error( "An error ocurred while querying the DB for the option " . $option . ". ", ERR_DB_QRY ); 
				return FALSE;
			}
		} 
		else{
			$this->set_error( "Invalid parameters to save. ", ERR_VAL_EMPTY ); 
			return FALSE;
		} 
	}
	 
	public function save_logo( $file ){
		global $Session; 
		if ( $Session->is_admin() ){
			if ($file["tmp_name"] != '' && $file["name"] != '' ){ 
				$file_tmp = $file["tmp_name"];
				try { 
					$moved = move_uploaded_file($file_tmp, DIRECTORY_UPLOADS . "logo.png"); 
					if ( $moved ) {
						return $this->save_settings_option('global_sys_logo', DIRECTORY_UPLOADS . "logo.png");
					} else {
						$this->set_error("An error occurred while saving the file to the server. ", ERR_FILE_UPLOAD, 3 ); 
						return FALSE;
					}
				} catch (Exception $e){
					$this->set_error("An error occurred while saving the file to the server. ", ERR_FILE_UPLOAD, 3 ); 
					return FALSE; 
				}  
			} else {
				$this->set_error("Error uploading file to server. ", ERR_FILE_UPLOAD, 2 ); 
				return FALSE; 
			}
		} 
		else return FALSE;
	}
	
}
?>