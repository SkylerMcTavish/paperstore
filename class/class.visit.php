<?php
/**
* Visit CLass
* 
* @package		SF·Tracker 			
* @since        11/19/2014 
* 
*/ 
class Visit extends Object {
	
	public $id_visit;
	public $id_pdv;
	public $id_user;
	public $id_visit_status;
	
	public $id_rescheduled_cause;
	
	public $date; 
	public $scheduled_start;
	public $scheduled_end;
	public $real_start;
	public $real_end;
	
	public $status;
	public $pdv;
	public $user;
	public $rescheduled_cause;
	 
	public $latitude;
	public $longitude;

	public $address;  
	public $timestamp;
	
	public $tasks = array(); 
	
	/**
	* Visit()    
	* Creates a User object from the DB.
	*  
	* @param	$id_visit (optional) If set populates values from DB record. 
	* 
	*/ 
	function __construct( $id_visit = 0 ){
		global $obj_bd;
		$this->class = 'Visit';
		$this->error = array();
		$this->clean();
		if ( $id_visit > 0 ){
			$query = "SELECT "
						. " id_visit, id_pdv, id_user, id_visit_status, us_user, pdv_name, pdv_ad_id_address, vi_timestamp, vs_visit_status, " 
						. " vi_scheduled_start, vi_scheduled_end, vi_real_start, vi_real_end, vi_latitude, vi_longitude,  "
						. " vi_timestamp, id_visit_reschedule_cause, vrc_visit_reschedule_cause "
					. " FROM " . PFX_MAIN_DB . "visit "  
						. " INNER JOIN " . PFX_MAIN_DB . "visit_status ON id_visit_status = vi_vs_id_visit_status "
						. " INNER JOIN " . PFX_MAIN_DB . "user ON id_user = vi_us_id_user "
						. " INNER JOIN " . PFX_MAIN_DB . "pdv ON id_pdv = vi_pdv_id_pdv" 
						. "  LEFT JOIN " . PFX_MAIN_DB . "visit_reschedule_cause ON id_visit_reschedule_cause = vi_vrc_id_reschedule_cause "
					. " WHERE id_visit = :id_visit "; 
			$info = $obj_bd->query( $query, array( ':id_visit' => $id_visit ) );
			if ( $info !== FALSE ){
				if ( count($info) > 0 ){ 
					$vi = $info[0];
					$this->id_visit 		= $vi['id_visit'];
					$this->id_pdv 			= $vi['id_pdv'];
					$this->id_user 			= $vi['id_user'];
					$this->id_visit_status 	= $vi['id_visit_status'];
					
					$this->pdv				= $vi['pdv_name']; 
					$this->user				= $vi['us_user'];
					$this->visit_status 	= $vi['vs_visit_status'];
					
					$this->scheduled_start	= $vi['vi_scheduled_start'];
					$this->scheduled_end	= $vi['vi_scheduled_end'];
					$this->real_start		= $vi['vi_real_start'] + 0;
					$this->real_end			= $vi['vi_real_end'] + 0;
					$this->latitude			= $vi['vi_latitude'];
					$this->longitude		= $vi['vi_longitude'];
					  
					$this->timestamp		= $vi['vi_timestamp'];
					
					$this->id_rescheduled_cause	= $vi['vrc_visit_rescheduled_cause'];
					$this->rescheduled_cause	= $vi['vrc_visit_rescheduled_cause'];
					
					$this->set_address( $vi['pdv_ad_id_address'] );
					
					//$this->set_visit_tasks();
					
				} else {
					$this->set_error( "Visit not found (" . $id_visit . "). ", ERR_DB_NOT_FOUND, 2 ); 
				}
			} else { 
				$this->set_error( "An error ocurred while querying the Data Base for Visit (" . $id_visit . ") information. ", ERR_DB_QRY, 2 );
			} 
		}   
	} 
	
	private function set_visit_tasks(){
		$this->tasks = array();
		if ( $this->id_visit > 0 ){ 
			if ( $this->id_visit_status == 3 ){
				global $obj_bd;
				$query = " SELECT  "
							. " id_task, id_task_type, tt_task_type, tk_time, id_task_omition_cause, toc_task_omition_cause " 
						. " FROM " . PFX_MAIN_DB . "task "
							. " INNER JOIN " . PFX_MAIN_DB . "task_type ON id_task_type = tk_tt_id_task_type "
							. "  LEFT JOIN " . PFX_MAIN_DB . "task_omition_cause ON id_task_omtition_cause = tk_toc_id_task_omtition_cause "
						. " WHERE tk_vi_id_visit = :id_visit ORDER BY id_task ASC ";
				$result = $obj_bd->query( $query, array( ':id_visit' => $this->id_visit ));
				if ( $result !== FALSE ){
					if ( count( $result ) > 0 ){
						foreach ($result as $k => $tk) {
							$task = new stdClass;
							$task->id_task 		= $tk['id_task'];
							$task->id_task_type	= $tk['id_task_type'];
							$task->task_type 	= $tk['tt_task_type'];
							$task->time 		= $tk['tk_time'];
							$task->id_task_omition_cause = $tk['id_task_omition_cause'];
							$task->task_omition_cause 	 = $tk['toc_task_omition_cause'];
							$task->activities			 = $this->get_task_type_activities($task->id_task_type);
							
							$this->tasks[] = $task;
						}
					} else {
						$this->set_error( "No tasks found for Visit (" . $this->id_visit . "). ", ERR_DB_NOT_FOUND, 2 );
					}
				} else {
					$this->set_error( "An error ocurred while querying the Data Base for tasks for Visit (" . $this->id_visit . "). ", ERR_DB_QRY , 2 ); 
				} 
			} else {
				$this->tasks = $this->get_pdv_type_tasks(); 
			}
		}
	}
	
	/**
	* set_address()    
	* Creates an Address object related to the PDV
	* @param         $id_address ( 0 )
	*  
	*/  
	private function set_address( $id_address = 0 ){  
		 if ( !class_exists( 'Address' ) ) 
		 		require_once 'class.address.php';
		 $this->address = new Address( $id_address ); 
	} 
	
	/**
	 * get_pdv_type_tasks()
	 * returns The id_pdv_type of the associated PDV 
	 * 
	 * @return	$resp Array
	 */
	 private function get_pdv_type_tasks(){
	 	$resp = array();
	 	if ( $this->id_pdv > 0 ){
	 		global $obj_bd; 
			$query = " SELECT id_task_type, tt_task_type "
					. " FROM " . PFX_MAIN_DB . "pdv "
						. " INNER JOIN " . PFX_MAIN_DB . "pdv_type_task_type ON ptt_pvt_id_pdv_type = pdv_pvt_id_pdv_type "
						. " INNER JOIN " . PFX_MAIN_DB . "task_type ON id_task_type = ptt_tt_id_task_type " 
					. " WHERE id_pdv = :id_pdv ";
			$types = $obj_bd->query($query, array( ':id_pdv' => $this->id_pdv ));
			if ( $types !== FALSE ){ 
				foreach ($types as $k => $tk) {
					$task = new stdClass; 
					$task->id_task_type	= $tk['id_task_type'];
					$task->task_type 	= $tk['tt_task_type'];
					$task->time 		= 0;
					$task->id_task_omition_cause = NULL;
					$task->task_omition_cause 	 = "";
					$task->activities 	= $this->get_task_type_activities($task->id_task_type);
					
					$resp[] = $task;
				} 
			} else {
				$this->set_error("An error occurred while querying for tasks from PDV type. ", ERR_DB_QRY, 2); 
			}
	 	}  
		return $resp;
	 }
	 
	 private function get_task_type_activities($id_task_type = 0)
	 {
		if($id_task_type > 0)
		{
			if ( !class_exists( 'Activity' ) ) 
		 		require_once 'class.activity.php';
			
			global $obj_bd; 
			$query = 	" SELECT tta_tt_id_task_type, tta_ac_id_activity ".
						" FROM " . PFX_MAIN_DB . "task_type_activities ".
						" WHERE tta_tt_id_task_type = :id_task_type ";
			$info = $obj_bd->query($query, array( ':id_task_type' => $id_task_type ));
			
			if ( $info !== FALSE )
			{
				$activities = array();
				foreach ($info as $k => $act )
				{
					$activity = new Activity($act['tta_ac_id_activity']);					
					$activities[] = $activity->get_array();
				}
				
				return $activities;
			}
			else
			{
				$this->set_error("An error occurred while querying for tasks from PDV type. ", ERR_DB_QRY, 2); 
			}
		}
	 }
	 
	/**
	 * get_array()
	 * returns an Array with visit information
	 *   
	 * @return	$array Array width Visit information
	 */
	 public function get_array(){
	 	$array = array(
	 					'id_visit' 			=>	$this->id_visit,  
	 					'id_visit_status' 	=>	$this->id_visit_status, 
	 					'id_pdv' 			=>	$this->id_pdv, 
	 					'id_user'			=>	$this->id_user,
	 					
	 					'pdv' 				=>	$this->pdv, 
	 					'user'				=>	$this->user, 
	 					'visit_status'		=>	$this->visit_status,
	 					
	 					'scheduled_start' 	=>	 date( 'Y-m-d H:i',$this->scheduled_start) , 
	 					//'scheduled_end'		=>	$this->scheduled_end, 
	 					'real_start' 		=>	$this->real_start > 0 	?  date( 'Y-m-d H:i', $this->real_start) : "", 
	 					'real_end'			=>	$this->real_end > 0 	?  date( 'Y-m-d H:i', $this->real_end) : "", 
	 					'latitude' 			=>	$this->latitude, 
	 					'longitude'			=>	$this->longitude,
	 					
						'address'			=> $this->address->get_array(),
	 					
	 					'tasks'				=> array()
					);
		foreach ($this->tasks as $k => $tk) {
			$array['tasks'][] = $tk;
		} 		
		return $array;
	 }
	 
	 
	
	/**
	 * get_array_api()
	 * returns an Array with visit information for the API
	 *   
	 * @return	$array Array width Visit information
	 */
	 public function get_array_api(){
	 	$array = array(
	 					'visit_id' 			=> $this->id_visit,  
	 					'visit_status_id' 	=> $this->id_visit_status, 
	 					'pdv_id' 			=> $this->id_pdv, 
	 					
	 					'pdv' 				=> $this->pdv,
	 					'visit_status'		=> $this->visit_status,
	 					
	 					'scheduled_start' 	=> date( 'H:i',$this->scheduled_start), 
	 					//'scheduled_end'		=>	$this->scheduled_end, 
	 					'real_start' 		=> $this->real_start > 0 ?  date( 'H:i', $this->real_start) : "", 
	 					'real_end'			=> $this->real_end > 0 	? date( 'H:i', $this->real_end) : "",
	 					'latitude' 			=> $this->latitude, 
	 					'longitude'			=> $this->longitude,
	 					'address'			=> $this->address->get_string_api() 
					);
		foreach ($this->tasks as $k => $tk) {
			$array['tasks'][] = $tk;
		} 		
		return $array;
	 }
	
	
	/**
	 * get_info_html()
	 * returns a String of HTML with visit information 
	 * 
	 * @return	$html String html visit info template
	 */
	 public function get_info_html(){
	 	$html  = "";
		$Visit = $this;
		ob_start(); 
		require_once DIRECTORY_VIEWS . "visit/info.visit.php"; 
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
		$this->id_visit 		= 0;
		$this->id_pdv 			= 0;
		$this->id_user 			= 0;
		$this->id_visit_status 	= 0;
		
		$this->pdv				= "";
		$this->user				= "";
		$this->visit_status 	= "";
		
		$this->scheduled_start	= 0;
		$this->scheduled_end	= 0;
		$this->real_start		= 0;
		$this->real_end			= 0;
		$this->latitude			= 0;
		$this->longitude		= 0;
		  
		$this->timestamp		= 0;
		
		$this->id_rescheduled_cause	= 0;
		$this->rescheduled_cause	= "";
		
		$this->set_address();
		$this->error = array();
	}
}

?>