<?php
if ( !class_exists( "Loader" ) ){
	require_once DIRECTORY_CLASS . "class.loader.php";
}

/**
 * class VisitLoader
 */
class VisitLoader extends Loader {
	
	private $Visit;
	private $users;
	private $pdvs;
	
	function __construct( ){ 
		if ( !class_exists( "AdminVisit" ) ){
			require_once DIRECTORY_CLASS . "class.admin.visit.php";
		}
		$this->class 	 = "VisitLoader";
		$this->line 	 = 0;
		$this->processed = 0;
		$this->saved 	 = 0;
		$this->users	 = array();
		$this->pdvs	 	 = array();
		$this->Visit 	 = new AdminVisit(0);
	}
	
	public function load_uploaded_file( $file ){
		if ( !class_exists( "FileManager" ) ){
			require_once DIRECTORY_CLASS . "class.file.manager.php";
		}
		$fm = new FileManager();
		$response = $fm->save_uploaded( $file, DIRECTORY_UPLOADS . "visit_tmpl_" . date( 'YmdHis' ) , 7 );
		
		if ( $response !== FALSE ){  
			return $this->process_file( $response->location ); 
		} else {
			$this->error[] = $fm->error[ count($fmanager->error) - 1 ];
			return FALSE;
		}
	}
	
	private function process_file( $route ){ 
		if ( $this->open_file( $route ) ){  
			$line = 0;
			try { 
				while (($row = fgetcsv($this->handle, 1000, ",")) !== FALSE) { 
					if ($row[0] != '' && trim($row[0]) != '' ){
						if ( $this->line > 0 ){
							$resp = $this->process_line($row);
							$this->processed++;
							if ( $resp )
								$this->saved++;
						} 
					}
					$this->line++;
				}  
				$this->close_file();
				return TRUE;
			} catch ( Exception $e ){
				$this->set_error("An error occurred while processing the file (Line " . $line . " ). ", ERR_VAL_INVALID);
			}
		}
		else return FALSE;
	}
	
	private function process_line( $line ){ 
		if ( is_array( $line ) && count( $line ) > 3 ){ 
			$user 	= trim( $line[0] );
			$pdv 	= trim( $line[1] );
			$date 	= trim( $line[2] );
			$start 	= trim( $line[3] );
			//$end 	= trim( $line[4] );
			
			$id_user = $this->get_user_id( $user );
			if ( !$id_user ){
				$this->set_error("Invalid User ( '$user' ) on line " . $this->line . ". ", ERR_VAL_INVALID );
				return FALSE;
			} 
			
			$id_pdv  = $this->get_pdv_id( $pdv );
			if ( !$id_pdv ){
				$this->set_error("Invalid PDV ( '$pdv' ) on line " . $this->line . ". ", ERR_VAL_INVALID );
				return FALSE;
			}
			
			$scheduled_start = $this->get_timestamp( $date, $start );
			//$scheduled_end	= $this->get_timestamp( $date, $end );
			
			if ( !( $scheduled_start > time() ) ){
				$this->set_error("Invalid Date ( $date $start ) on line " . $this->line . " - " . date("Ymd H:i:s") . ". Date can not be less than the current date. ", ERR_VAL_INVALID );
				return FALSE;
			}
			
			$this->Visit->clean();
			
			$this->Visit->id_user			= $id_user;
			$this->Visit->id_pdv 			= $id_pdv;
			$this->Visit->scheduled_start 	= $scheduled_start;
			//$this->Visit->scheduled_end 	= $scheduled_end;
			$this->Visit->id_visit_status 	= 1;
			
			$resp = $this->Visit->save();
			if ( $resp !== FALSE ){
				$this->set_msg( "LOAD", "Visit " . $this->Visit->id_visit . " created successfully. ");
				return TRUE;
			} else return FALSE;
			
		} else {
			$this->set_error("Invalid line data (Line " . $this->line . "). ", ERR_VAL_INVALID );
			return FALSE;
		} 
	}
	
	private function get_user_id( $user = '' ){ 
		global $Validate; 
		if ( $user != '' && $Validate->is_email( $user ) ){
			if ( array_key_exists( $user , $this->users ) ){
				return $this->users[ $user ];
			} else {
				global $obj_bd;
				$query = " SELECT id_user FROM " . PFX_MAIN_DB . "user  " 
						. " WHERE us_user = :us_user ";
				$result = $obj_bd->query($query, array( ':us_user' => $user ) );
				if ( $result !== FALSE ){ 
					if ( count( $result ) > 0 ){
						$id_user = $result[0]['id_user'];
						if ( $Validate->is_integer( $id_user ) && $id_user > 0 ){
							$this->users[ $user ] = $id_user;
							return $id_user;
						} 
						else return FALSE;
					} 
				} else {
					$this->set_error("Database error while querying for user '" . $user . "'. ", ERR_VAL_INVALID );
					return FALSE;
				}
			} 
		} else {
			$this->set_error("Invalid User ( '$user' ) on line " . $this->line . ". ", ERR_VAL_INVALID );
			return FALSE;
		} 
	}
	
	private function get_pdv_id( $pdv = '' ){ 
		global $Validate;
		if ( $pdv != '' ){
			if ( array_key_exists( $pdv , $this->pdvs ) ){
				return $this->pdvs[ $pdv ];
			} else {
				global $obj_bd;
				$query = " SELECT id_pdv FROM " . PFX_MAIN_DB . "pdv WHERE pdv_jde = :pdv ";
				$result = $obj_bd->query($query, array( ':pdv' => $pdv ) ); 
				if ( $result !== FALSE ){ 
					if ( count( $result ) > 0 ){
						$id_pdv = $result[0]['id_pdv'];
						if ( $Validate->is_integer( $id_pdv ) && $id_pdv > 0 ){
							$this->pdvs[ $pdv ] = $id_pdv;
							return $id_pdv;
						}
						else return FALSE;
					}
				} else {
					$this->set_error("Database error while querying for pdv '" . $pdv . "'. ", ERR_VAL_INVALID );
					return FALSE;
				}
			}
		} else {
			$this->set_error("Invalid User ( '$pdv' ) on line " . $this->line . ". ", ERR_VAL_INVALID );
			return FALSE;
		}
	}

	private function get_timestamp( $date, $time ){
		// >> 15/01/2015   ,   10:20
		try{
			list( $d, $m, $Y ) 	= explode("/", $date );
			list( $H, $i ) 		= explode(":", $time );
			return mktime( $H, $i, 0, $m, $d, $Y );
		} catch ( Exception $e ){
			$this->set_error("Invalid date parameters ( $date , $time )", ERR_VAL_INVALID);
			return FALSE;
		} 
		
	}

}
?>