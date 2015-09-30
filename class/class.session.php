<?php

class Session extends Object{
	var $name;
	var $hash;
	var $level;
	var $user;
	var $id; 
	var $settings;
	var $id_proyect;
	var $job;

	function Session(){
		$this->class = 'Session';
		$this->init(); 
		$this->set_settings();
	}

	private function init() {
		global $Debug; 
		$this->user = "";
		$this->name = "";
		$this->level = 0;
		$this->id = "";
		$this->job = "";

		if ( $this->set_from_session() ) {
            return TRUE;
		} else if ( $this->set_from_cookie() ){
			return TRUE;
		} else{
			$this->end_session();
			return FALSE;
		}
	}
	
	private function set_settings(){
		global $Settings;
		$this->settings = new stdClass;
		
		$this->settings->title  = $Settings->get_settings_option('global_sys_title');
		$this->settings->color1 = $Settings->get_settings_option('global_css_color1');
		$this->settings->color2 = $Settings->get_settings_option('global_css_color2');
		$this->settings->color3 = $Settings->get_settings_option('global_css_color3');
		
	}
	
	private function set_from_session(){
		if (
			//isset($_SESSION[PFX_SYS . 'name']) && ($_SESSION[PFX_SYS . 'name'] != "") &&
			isset($_SESSION[ PFX_SYS . 'profile']) && ($_SESSION[ PFX_SYS . 'profile'] != "") &&
			isset($_SESSION[ PFX_SYS . 'user']) && ($_SESSION[ PFX_SYS . 'user'] != "") &&
			isset($_SESSION[ PFX_SYS . 'id']) && ($_SESSION[ PFX_SYS . 'id'] != "")
		) { 
            $this->name 	= $_SESSION[ PFX_SYS . 'name'];
			$this->level 	= $_SESSION[ PFX_SYS . 'profile'];
			$this->user 	= $_SESSION[ PFX_SYS . 'user'];
			$this->id 		= $_SESSION[ PFX_SYS . 'id'];
			$this->job 		= $_SESSION[ PFX_SYS . 'job']; 
			
			$this->id_proyect = isset($_SESSION[ PFX_SYS . 'id_proyect']) ? $_SESSION[ PFX_SYS . 'id_proyect'] : 0;
			
			if ( $this->id_proyect > 0 ){
				$this->set_proyect_constants();
			}
			
			if ( $this->level == 1 ){
				define('IS_ADMIN', TRUE);
			} else {
				define('IS_ADMIN', FALSE);
			}
			return TRUE;
		} else {
			return FALSE;
		}
	}
	
	private function set_from_cookie(){
		if (
			isset($_COOKIE[PFX_SYS . 'user'] ) && $_COOKIE[PFX_SYS . 'user']  != '' && 
			isset($_COOKIE[PFX_SYS . 'token']) && $_COOKIE[PFX_SYS . 'token'] != '' 
		) {
			$us_usuario	= $_COOKIE[PFX_SYS . 'usr'];
			$us_password= $_COOKIE[PFX_SYS . 'token'];
			if ($this->create_session($us_usuario , $us_password)){ 
				if (stripos( $_SERVER['SCRIPT_NAME'] , SYS_LOGIN ) > 0)  header('location: index.php');
				//cookie activa y la sesion válida
			}  else header('location: '.SYS_LOGIN); 
		} 
	}
	
	public function is_admin(){
		if ( $this->level == 1 )
			return TRUE;
		else 
			return FALSE;
	}
	
	public function is_proyect_admin(){
		if ( $this->level == 1 )
			return TRUE;
		else if ( $this->level == 2 )
			return ( $this->get_proyect() ) ? TRUE : FALSE ;
		else 
			return FALSE;
	}
	
	public function valid_proyect_access( $id_proyect ){
		if ( $this->is_admin() )
			return TRUE;
		else if ( $id_proyect > 0 ) {
			global $obj_bd;
			$query = "SELECT pu_pr_id_proyect FROM " . PFX_MAIN_DB . "proyect_user " 
						. " WHERE pu_pr_id_proyect = :id_proyect AND pu_us_id_user = :id_user ";
			$values = array(
						':id_proyect' => $id_proyect,
						':id_user'	=> $this->get_id()
					 );
			$resp = $obj_bd->query($query, $values);
			if ( $resp !== FALSE ){
				if ( count( $resp ) == 1 ){
					return TRUE;
				} else {
					return FALSE;
				}
			} else {
				$this->set_error(' Error while querying for Proyect ( ' . $id_proyect . ' ) Access.', ERR_DB_QRY);
				return FALSE;
			}
		} else {
			return FALSE;
		}
	}

	private function set_proyect_constants(){
		if ( $this->id_proyect > 0 ){
			define("ID_PRY", $this->id_proyect );
			define("PFX_PRY_DB", PFX_MAIN_DB . "pr" . $this->id_proyect . "_"); 
		} 
	} 
	
	
	public function get_proyect( ){
		if ( !( $this->id_proyect > 0) ){ 
			$id_proyect = FALSE;
			if (isset($_SESSION[ PFX_SYS . 'id_proyect' ])){
				$this->id_proyect = $_SESSION[ PFX_SYS . 'id_proyect' ];
				return $this->id_proyect;
			}
			if ( isset($_POST['id_proyect']) && $_POST['id_proyect'] > 0 ){
				$id_proyect = $_POST['id_proyect'];
			} else if ( isset($_POST['idp']) && $_POST['idp'] > 0 ){
				$id_proyect = $_POST['idp']; 
			} else if ( isset($_GET['id_proyect']) && $_GET['id_proyect'] > 0 ){
				$id_proyect = $_GET['id_proyect'];
			} else if ( isset($_GET['idp']) && $_GET['idp'] > 0 ){
				$id_proyect = $_GET['idp']; 
			} 
			if ( $id_proyect > 0 ){ 
				$valid = $this->valid_proyect_access($id_proyect);
				if ($valid){ 
					session_start();
			 		$_SESSION[ PFX_SYS . 'id_proyect' ] = $id_proyect; 
					session_write_close();
					$this->id_proyect = $id_proyect;
					$this->set_proyect_constants();
					return $this->id_proyect;
				} else { 
					$this->set_error("Restricted Access attempt Proyect " . $id_proyect . ". ", ERR_403, 3);
					return FALSE;
				}
			} else {
				return FALSE;
			}
		} else {
			return $this->id_proyect;
		}
	}

	public function logged_in() {
		return ($this->id != "");
	} 
	
    public function get_name() {
        return $this->name;
    } 
            
	public function get_level() {
		return $this->level;
	}

	public function get_user() {
		return $this->user;
	}

	public function get_email() {
		return $this->user;
	}
	
	public function get_id() {
		return $this->id;
	}
	
	public function get_job(){
		return $this->job;
	}

	public function get_var( $varname ) {
		return ( isset($_SESSION[$varname]) ? $_SESSION[$varname] : "" );
	}
	
	public function set_var( $varname, $value ) {
		$_SESSION[$varname] = $value;
	}
 
	public function end_session() {
		$_SESSION[PFX_SYS . 'name'] 	= "";
		$_SESSION[PFX_SYS . 'user'] 	= "";
		$_SESSION[PFX_SYS . 'id'] 		= "";
		$_SESSION[PFX_SYS . 'profile'] 	= 0;
		
		setcookie("meta_tracker_user",	'', time() - 3600 );  
		setcookie("meta_tracker_token",	'', time() - 3600 );
		
		session_destroy();
		session_start();
		
		$this->user = "";
		$this->name = "";
		$this->level = 0;
		$this->id = "";
	}

}
?>