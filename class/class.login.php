<?php 
include_once("class.template.php");

class Login {
	var $bd;
	var $user;
	var $nombre; 
	var $nivel;
	var $email;
	var $id;
	var $plantilla;

	function Login(){
		$this->init();
	}

	function init(){
		global $obj_bd;
		$this->bd = $obj_bd;
		$this->template = new Template;
	}
 
	function get_user(){
		return $this->user;
	}
            
    function get_name(){
        return $this->nombre;
    }
            
	function get_level(){
		return $this->nivel;
	}

	function get_email(){
		return $this->email;
	}

	function get_id() {
		return $this->id;
	}

	function log_in($usuario, $password) { 
		global $obj_bd;
		$query 	= "SELECT id_user AS id FROM " . PFX_MAIN_DB . "user WHERE us_user = :us_user AND us_password = :pwd ";
		$usr	= $obj_bd->query( $query, array( ':us_user' => $usuario, ':pwd' => $password) );   
		if ( $usr !== FALSE ){
			
			if ( count($usr) > 0 ){
				 
				$query = "SELECT * " 
						. " FROM " . PFX_MAIN_DB . "user u "
	                    	. " INNER JOIN " . PFX_MAIN_DB . "profile p ON id_profile = us_pf_id_profile "
						. " WHERE id_user = :id_us  ";
				
				$user_info = $obj_bd->query( $query, array( ':id_us' => $usr[0]['id']));
				if ( $user_info !== FALSE ){
					$record = $user_info[0];
					$this->name 	= utf8_encode($record['us_user']);
					$this->user 	= $record['us_user'];
					$this->email 	= $record['us_user'];
					$this->level 	= $record['id_profile'];
					$this->id 		= $record['id_user'];
					
					$_SESSION[PFX_SYS . 'name']		= $this->name;
					$_SESSION[PFX_SYS . 'profile']	= $this->level;
					$_SESSION[PFX_SYS . 'user']		= $this->user;
					$_SESSION[PFX_SYS . 'id']		= $this->id;
					$_SESSION[PFX_SYS . 'job']		= $record['pf_profile'];
					
					if ( $this->level == 1 ){
						define('ES_ADMIN', true);
					} else {
						define('ES_ADMIN', false);
					}
					session_write_close();
					
					$sql  = "UPDATE " . PFX_MAIN_DB . "user SET us_lastlogin = :lastlogin WHERE id_user = :id_us "; 
					$resp = $obj_bd->execute( $sql, array( ':lastlogin' => time(),  ':id_us' => $this->id ) ); 
					
					return LOGIN_SUCCESS; 
				}  else {
					return LOGIN_DBFAILURE;
				} 
			} else {
				return LOGIN_BADLOGIN;
			}
		} else {
			return LOGIN_DBFAILURE;
		} 
	}

	function Forgot($email) {
		
		/* TODO */
		
	}

}
?>
