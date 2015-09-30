<?php 
if (!class_exists('Visit')){
	require_once 'class.visit.php';
}
/**
* AdminVisit CLass
* 
* @package		SF·Tracker 			
* @since        11/25/2014 
*/ 
class AdminVisit extends Visit {
	 
	/**
	* __construct()    
	* Creates a User object from the DB.
	*  
	* @param	$id_visit (optional) If set populates values from DB record.  
	*/  
	function __construct( $id_visit ){
		global $Session;
		$this->class = 'AdminVisit';
		if ( !$Session->is_admin() ){
			$this->set_error('Restricted Access', SES_RESTRICTED_ACCESS, 3);
			throw new Exception("Restricted access.", 1); 
		}
		parent::__construct( $id_visit );
		$this->class = 'AdminVisit';
	}
	
	/**
	* save()    
	* Inserts or Update the record in the DB. 
	* 
	*/  
	public function save(){
		global $Session;
		if ( $Session->is_proyect_admin() ){ 
			if ( $this->validate() ){ 
				global $obj_bd; 
				$values = array(  
							':id_pdv'	 		=> $this->id_pdv,  
							':id_user'			=> $this->id_user, 
							':id_visit_status'	=> $this->id_visit_status, 
							':scheduled_start'	=> $this->scheduled_start,
							//':scheduled_end' 	=> $this->scheduled_end, 
							':latitude'			=> $this->latitude,
							':longitude'		=> $this->longitude,
							 
							':timestamp' 		=> time() 
						);
				$action = "SAVE";
				if ( $this->id_visit > 0 ){ 
					$action = "UPDATE";
					$values[':id_visit'] 	= $this->id_visit ;
					$values[':real_start'] 	= $this->real_start ;
					$values[':real_end'] 	= $this->real_end ;
					
					$query = " UPDATE " . PFX_MAIN_DB . "visit SET "  
								. " vi_pdv_id_pdv			= :id_pdv , "
								. " vi_us_id_user			= :id_user , " 
								. " vi_vs_id_visit_status 	= :id_visit_status , " 
								. " vi_scheduled_start		= :scheduled_start , " 
								//. " vi_scheduled_end		= :scheduled_end , " 
								. " vi_real_start 			= :real_start , "  
								. " vi_real_end			 	= :real_end , "
								. " vi_latitude				= :latitude , "
								. " vi_longitude			= :longitude , "
								. " vi_status				= 1 , "
								. " vi_timestamp 			= :timestamp "
							. " WHERE id_visit 	= :id_visit ";
				} else { 
					$action = "INSERT"; 
					$this->set_coordinates();
					$values[':id_visit_status'] = 1;
					$values[':latitude'] 		= $this->latitude;
					$values[':longitude'] 		= $this->longitude;
					
					$query = "INSERT INTO " . PFX_MAIN_DB . "visit "
						. " (vi_pdv_id_pdv, vi_us_id_user, vi_vs_id_visit_status, vi_scheduled_start, vi_latitude, vi_longitude, vi_status, vi_timestamp ) "
						. " VALUES ( :id_pdv, :id_user, :id_visit_status, :scheduled_start, :latitude, :longitude, 1, :timestamp )  "; 
				}  
				$result = $obj_bd->execute( $query, $values );
				
				if ( $result !== FALSE ){ 
					if ( $this->id_visit == 0){ //new record
						$this->id_visit = $obj_bd->get_last_id(); 
						$resp = TRUE;
					} 
					else $resp = TRUE;
					$this->set_msg( $action , " Visit " . $this->id_visit. " saved. ");
					return $resp;
				} else { 
					$this->set_error( "An error ocurred while trying to save the record. ", ERR_DB_EXEC, 3 );
					return FALSE;
				} 
			} else {
				return FALSE;
			} 
		} else {
			$this->set_error("Restricted action.", SES_RESTRICTED_ACTION);
			return FALSE;
		}
	}

	/**
	 * set_coordinates()
	 * Retrieves the PDV's coordinates for the Visit
	 * 
	 */
	 public function set_coordinates(){
	 	if ( $this->id_pdv > 0 ){
	 		global $obj_bd;
	 		$query = "SELECT pdv_latitude, pdv_longitude FROM " . PFX_MAIN_DB . "pdv WHERE id_pdv = :id_pdv ";
			$resp = $obj_bd->query( $query , array( ':id_pdv' => $this->id_pdv ));
			if ( $resp !== FALSE ){
				$info = $resp[0];
				$this->latitude  = $info['pdv_latitude'];
				$this->longitude = $info['pdv_longitude'];
			} else {
				$this->set_error( "An error ocurred while retrieveing PDV coordinates. ", ERR_DB_EXEC, 3 );
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
		if ( !$this->id_pdv > 0 || !$Validate->exists( 'pdv', 'id_pdv', $this->id_pdv )){
			$this->set_error( 'Invalid PDV. ', ERR_VAL_EMPTY );
			return FALSE;
		}
		/*if ( !$this->id_region > 0 || !$Validate->exists( 'user', 'id_user', $this->id_user)){
			$this->set_error( 'Invalid Region. ', ERR_VAL_EMPTY );
			return FALSE;
		} */
		if ( !$Validate->exists( 'user', 'id_user', $this->id_user)){
			$this->set_error( 'Invalid User. ', ERR_VAL_EMPTY );
			return FALSE;
		} 
		if ( !$this->id_visit_status > 0 || !$Validate->exists( 'visit_status', 'id_visit_status', $this->id_visit_status)){
			$this->set_error( 'Invalid Visit status. ', ERR_VAL_EMPTY );
			return FALSE;
		}
		
		if ( ! $Validate->is_int_between($this->scheduled_start, time(), time() + (365 * 86400)) ){
			$this->set_error( 'Invalid Start. ', ERR_VAL_INVALID );
			return FALSE;
		}
		/*if ( ! $Validate->is_int_between($this->scheduled_start, time(), time() + (365 * 86400)) ){
			$this->set_error( 'Invalid End. ', ERR_VAL_INVALID );
			return FALSE;
		}*/
		
		return TRUE;
	}
	
	/**
	* delete()    
	* Changes status for Visit to 0 in the DB.
	*
	* @return 	TRUE on success; FALSE otherwise 
	*/  
	public function delete(){
		global $Session;
		if ( $Session->is_admin() ){
			global $obj_bd;
			$query = " UPDATE "  . PFX_MAIN_DB . "visit SET vi_status = 0 WHERE id_visit = :id_visit ";
			$result = $obj_bd->execute( $query, array( ':id_visit' => $this->id_visit ) );
			if ( $result !== FALSE ){
				$this->clean();
				return TRUE;
			} else {
				$this->set_error( "An error ocurred while trying to set status to 0. ", ERR_DB_EXEC, 3 );
				return FALSE;
			} 
		}
	} 
}
?>