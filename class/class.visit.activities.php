<?php
if (!class_exists('Visit')){
	require_once 'class.visit.php';
}

/**
* VisitActivities CLass
* 
* @package		SF·Tracker 			
* @since        11/25/2014 
* 
*/ 
class VisitActivities extends Visit {
	 
	/**
	* __construct()    
	* Creates a User object from the DB.
	*  
	* @param	$id_visit (optional) If set populates values from DB record. 
	*/  
	function __construct( $id_visit ){
		global $Session; 
		parent::__construct( $id_visit );
		$this->class = 'VisitActivities';
	}
	
	/**
	 * start_visit()
	 * 
	 * @param 	$timestamp 	start timestamp
	 * @return 	TRUE on success / FALSE otherwise
	 */
	public function start_visit( $timestamp = 0 ){
		if ( !( is_numeric($timestamp) && $timestamp > 0)  ){
			$timestamp = time();
		} 
		
		if ( !($this->real_start > 1) ){
			global $obj_bd; 
			$query = " UPDATE " . PFX_MAIN_DB . "visit SET "
						. " vi_real_start = :start , "
						. " vi_vs_id_visit_status = 2, "
						. " vi_timestamp = :time "
					. " WHERE id_visit = :id_visit ";
			$result = $obj_bd->execute($query, array( ':id_visit' => $this->id_visit, ':start' => $timestamp, ':time' => time() ) );
			if ( $result !== FALSE ){
				$this->id_visit_status = 2;
				$this->real_start = $timestamp; 
				return TRUE;
			} else {
				$this->set_error("An error in the DB occured while updating the Visit information.", ERR_DB_EXEC, 3 );
				return FALSE;
			} 
		} else {
			$this->set_error("The visit ( " . $this->id_visit . " ) has already started ( " . date('Y-m-d H:i', $this->real_start) . " )", ERR_VAL_INVALID, 3 );
			return FALSE;
		} 
	}
	
	/**
	 * end_visit()
	 */
	 public function end_visit( $timestamp = 0 ){
	 	if ( !( is_numeric($timestamp) && $timestamp > 0)  ){
			$timestamp = time();
		}
		if ( !($this->real_end > 1) ){
			global $obj_bd; 
			$query = " UPDATE " . PFX_MAIN_DB . "visit SET "
						. " vi_real_end = :end , "
						. " vi_vs_id_visit_status = 3, "
						. " vi_timestamp = :time "
					. " WHERE id_visit = :id_visit ";
			$result = $obj_bd->execute($query, array( ':id_visit' => $this->id_visit , ':end' => $timestamp, ':time' => time() ) );
			if ( $result !== FALSE ){
				$this->id_visit_status = 3;
				$this->real_end = $timestamp; 
				return TRUE;
			} else {
				$this->set_error("An error in the DB occured while updating the Visit information.", ERR_DB_EXEC, 3 );
				return FALSE;
			} 
		} else {
			$this->set_error("The visit ( " . $this->id_visit . " ) has already ended ( " . date('Y-m-d H:i', $this->real_end). " )", ERR_VAL_INVALID, 3 );
			return FALSE;
		} 
	 }
	
	/**
	 * set_visit_status()
	 * Retrieves the PDV's coordinates for the Visit
	 * 
	 * @param 		INTEGER $id_visit_status : The new status for the visit
	 */
	 public function set_visit_status( $id_visit_status ){
	 	if ( $this->id_visit > 0 ){ 
			if ( $id_visit_status > 0 && $Validate->exists( 'visit_status', 'id_visit_status', $id_visit_status)){
				global $obj_bd;
				$query = " UPDATE " . PFX_MAIN_DB . "visit SET " 
							. " vi_vs_id_visit_status = :id_status " 
						. " WHERE id_visit = :id_visit ";
				$resp = $obj_bd->execute( $query, array( ':id_status' => $id_visit_status, ':id_visit' => $this->id_visit ) );
				if ( $resp !== FALSE ){
					$this->id_visit_status = $id_visit_status;
					return FALSE;
				} else {
					$this->set_error("An error occurred while updating the Visit's Status ( " . $this->id_visit . " )", ERR_DB_EXEC, 3 );
					return FALSE;
				} 
			} else {
				$this->set_error( 'Invalid Visit status. ', ERR_VAL_INVALID );
				return FALSE;
			} 
	 	}else {
			$this->set_error( "Invalid Visit. ", ERR_VAL_INVALID, 3 );
			return FALSE;
		} 
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