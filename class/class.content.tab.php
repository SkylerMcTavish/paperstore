<?php
/**
* ContentTab CLass
* 
* @package		SF·Tracker 			
* @since        16/01/2015 
* 
*/ 
class ContentTab extends Object {
	
	public $tab;
	public $id_pdv;
	 
	function __construct( $id_visit = 0 ){
		global $obj_bd;
		$this->class = 'Visit';
		$this->error = array();
		$this->clean();
		if ( $id_visit > 0 ){
			$query = "SELECT * FROM  " . PFX_PRY_DB . "visit INNER JOIN " . PFX_PRY_DB 			
					. "task  ON tk_vi_id_visit=id_visit  INNER JOIN " . PFX_PRY_DB 
					. "visit_stock  ON tk_vi_id_visit=vsk_vi_id_visit INNER JOIN " . PFX_PRY_DB 
					. "visit_price ON vsk_vi_id_visit=vp_vi_id_visit WHERE id_visit=:id_visit"; 
					
					
					
					
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
					$this->real_start		= $vi['vi_real_start'];
					$this->real_end			= $vi['vi_real_end'];
					$this->latitude			= $vi['vi_latitude'];
					$this->longitude		= $vi['vi_longitude'];
					  
					$this->timestamp		= $vi['vi_timestamp'];
					
					$this->id_rescheduled_cause	= $vi['vrc_visit_rescheduled_cause'];
					$this->rescheduled_cause	= $vi['vrc_visit_rescheduled_cause'];
					
					$this->set_visit_tasks();
					
				} else {
					$this->set_error( "Visit not found (" . $id_visit . "). ", ERR_DB_NOT_FOUND, 2 ); 
				}
			} else { 
				$this->set_error( "An error ocurred while querying the Data Base for Visit (" . $id_visit . ") information. ", ERR_DB_QRY, 2 );
			} 
		}   
	} 

	/**
	 * get_info_html()
	 * returns a String of HTML with visit information 
	 * 
	 * @return	$html String html visit info template
	 */
	 public function get_info_html(){
	 	$html  = "";
		$tab = $this;
		ob_start(); 
		require_once DIRECTORY_VIEWS . "visit/tab.info.visit.php"; 
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
	
	
	/*	$this->id_visit 		= 0;
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
		
		$this->error = array(); */
	}
}

?>