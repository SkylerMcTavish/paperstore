<?php
/**
* Proyect CLass
* 
* @package		SF Tracker			
* @since        18/05/2014 
* 
*/ 
class Proyect extends Object{
	
	public $id_proyect; 
	public $proyect;
	
	public $id_company;
	public $company;
	public $id_region;
	public $region;
	public $id_proyect_type;
	public $proyect_type;
	public $shift_start;
	public $shift_end;
	public $workdays_str;
	public $workdays;
	public $day_visits; 
	
	public $timestamp;
	
	public $cycles = array();
	public $presentation = array();
	public $recomendation = array();
	public $error = array();
	
	/**
	* User()    
	* Creates a User object from the DB.
	*  
	* @param	$id_proyect (optional) If set populates values from DB record. 
	* 
	*/  
	function Proyect( $id_proyect = 0 ){
		global $obj_bd;
		$this->class = 'Proyect';
		$this->error = array();
		if ( $id_proyect > 0 ){
			$query = "SELECT "
							. " id_proyect, id_proyect_type, id_company, id_region, "
							. " prt_proyect_type, cm_company, re_region, pr_proyect, pr_day_visits,"
							. " pr_shift_start, pr_shift_end, pr_workdays, pr_timestamp, pr_status "
						. " FROM " . PFX_MAIN_DB . "proyect " 
							. " INNER JOIN " . PFX_MAIN_DB . "proyect_type ON id_proyect_type = pr_prt_id_proyect_type "
							. " INNER JOIN " . PFX_MAIN_DB . "company ON id_company = pr_cm_id_company  "
							. " INNER JOIN " . PFX_MAIN_DB . "region ON id_region = pr_re_id_region "
					. " WHERE id_proyect = :id_proyect " ; 
			$info = $obj_bd->query( $query, array( ':id_proyect' => $id_proyect ) );
			if ( $info !== FALSE ){
				if ( count($info) > 0 ){
					$usr = $info[0];
					$this->id_proyect 		= $usr['id_proyect'];
					$this->id_proyect_type	= $usr['id_proyect_type'];
					$this->id_company 		= $usr['id_company'];
					$this->id_region 		= $usr['id_region'];
					
					$this->proyect	 		= $usr['pr_proyect'];
					$this->proyect_type		= $usr['prt_proyect_type'];
					$this->company		 	= $usr['cm_company'];
					$this->region		 	= $usr['re_region']; 
					 
					$this->day_visits	 	= $usr['pr_day_visits'];
					$this->shift_start	 	= $usr['pr_shift_start'];
					$this->shift_end	 	= $usr['pr_shift_end'];
					$this->str_workdays	 	= $usr['pr_workdays'];
					$this->workdays_str	 	= explode(';',$usr['pr_workdays']);
					$this->workdays		 	= $this->workdays_str;
					
					$this->timestamp	 	= $usr['pr_timestamp'];
					
				} else {
					$this->clean();
					$this->set_error( "Proyect not found (" . $id_proyect . "). ", ERR_DB_NOT_FOUND, 2 ); 
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
	 * set_cycles()
	 * populates cycle array with cycles from the DB
	 */
	 protected function set_cycles(){
	 	$this->cycles = array();
	 	if ( $this->id_proyect > 0 ){
	 		global $obj_bd;
			$query = "SELECT cy_from, cy_to FROM " . PFX_PRY_DB . "cycle ORDER BY cy_from ASC ";
			$resp = $obj_bd->query( $query );
			if ( $resp ){
				foreach ($resp as $k => $cy) {
					$cycle = new stdClass;
					$cycle->from	= $cy['cy_from'];
					$cycle->to 		= $cy['cy_to'];
					$cycle->from_str= date('Y/m/d', $cycle->from);
					$cycle->to_str	= date('Y/m/d', $cycle->to);
					
					$this->cycles[] = $cycle;
				}
			} else {
				$this->set_error("Could not retrieve cycles for proyect ( " . $this->id_proyect . " ) from the DB.", ERR_DB_QRY);
				return FALSE;
			}
	 	}
	 }

	/**
	 * set_media()
	 * populates recomendation and presentation arrays with mediafiles from the DB
	 * 
	 */
	 protected function set_media(){
	 	$this->recomendation = array();
	 	$this->presentation  = array();
	 	if ( $this->id_proyect > 0 ){
	 		global $obj_bd;
			$query = "SELECT " 
						. " id_media_file, id_media_type, id_file_type, ft_file_type, ft_icon, mf_name, mf_title, mf_description, mf_route " 
					. " FROM " . PFX_PRY_DB . "media_file " 
						. " INNER JOIN  " . PFX_MAIN_DB . "file_type ON id_file_type = mf_ft_id_file_type "
						. " INNER JOIN  " . PFX_MAIN_DB . "media_type ON id_media_type = mf_mt_id_media_type "
					. " WHERE mf_status > 0 ORDER BY id_media_file ASC ";
			$resp = $obj_bd->query( $query );
			if ( $resp ){
				foreach ($resp as $k => $media) {
					$file = new stdClass; 
					$file->id_media_file= $media['id_media_file'];
					$file->id_file_type = $media['id_file_type'];
					$file->file_type 	= $media['ft_file_type'];
					$file->name 		= $media['mf_name'];
					$file->title		= $media['mf_title'];
					$file->description 	= $media['description'];
					$file->route 		= $media['mf_route'];
					if ( $media['id_media_type'] == 1 ){
						$this->recomendation[] = $file;
					} else if ( $media['id_media_type'] == 2 ){
						$this->presentation[]  = $file; 
					}
				}
			} else {
				$this->set_error("Could not retrieve media files for proyect ( " . $this->id_proyect . ") from the DB.", ERR_DB_QRY);
				return FALSE;
			}
	 	}
	 }

	/**
	 * get_array()
	 * returns an Array with proyect information
	 * 
	 * @param 	$full Boolean if TRUE returns Proyect and Instance Arrays (default FALSE)
	 * 
	 * @return	$array Array width User information
	 */
	 public function get_array( ){
	 	$array = array(
	 					'id_proyect' 		=>	$this->id_proyect, 
	 					'proyect' 			=>	$this->proyect,
	 					
	 					'id_company' 		=>	$this->id_company, 
	 					'company' 			=>	$this->company,
	 					'id_proyect_type' 	=>	$this->id_proyect_type, 
	 					'proyect_type' 		=>	$this->proyect_type,
	 					'id_region' 		=>	$this->id_region, 
	 					'region' 			=>	$this->region,
	 					
	 					'shift_start'		=>	$this->shift_start,
	 					'shift_end'	 		=>	$this->shift_end, 
	 					'workdays'			=>	$this->workdays,
	 					'day_visits'		=> 	$this->day_visits,
	 					
	 					'timestamp'			=>	$this->timestamp 
					); 
		return $array;
	 }
	
	/**
	 * get_info_html()
	 * returns a String of HTML with user information
	 * 
	 * @param 	$full Boolean if TRUE returns Contact and Instance Arrays (default FALSE)
	 * 
	 * @return	$html String html user info template
	 */
	 public function get_info_html( $full = FALSE ){
	 	$html  = "";
		$proyect = $this;
		ob_start();
		require_once DIRECTORY_VIEWS . "proyect/info.proyect.php"; 
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
		$this->id_proyect 	=  0;
		$this->proyect 		= "";
		
		$this->id_company 	=  0;
		$this->company 		= "";
		$this->id_region 	=  0;
		$this->region 		= "";
		$this->id_proyect_type 	=  0;
		$this->proyect_type = "";
		
		$this->shift_start 	= 0;
		$this->shift_end 	= 0; 
		$this->workdays		= array(); 
		$this->day_visits	= 0;
		
		$this->timestamp 	= 0;
		 
		$this->error = array(); 
	}
	 
}

?>