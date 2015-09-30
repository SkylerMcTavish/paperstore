<?php
/**
* PDV CLass
* 
* @package		SF·Tracker 			
* @since        11/19/2014 
* 
*/ 
class PDV extends Object {
	
	public $id_pdv; 
	public $name;
	public $route;
	public $latitude;
	public $longitude;
	public $jde;
	public $id_pdv_type;
	public $type; 
	public $id_format;
	public $format;
	public $id_group;
	public $group;
	public $id_channel;
	public $channel;
	
	public $address;
	public $contact;
	public $schedule;
	
	public $invoice;
	
	public $timestamp; 
	public $meta;
	public $error = array();
	
	/**
	* PDV()    
	* Creates a User object from the DB.
	*  
	* @param	$id_pdv (optional) If set populates values from DB record. 
	* 
	*/  
	function __construct( $id_pdv = 0 ){
		global $obj_bd;
		$this->class = 'PDV';
		$this->error = array();
		$this->clean();
		if ( $id_pdv > 0 ){
			$query = "SELECT "
						. " id_pdv, pdv_name, pdv_route, pdv_jde, pdv_invoice, pdv_timestamp, pdv_status, pdv_invoice, " 
						. " pdv_latitude, pdv_longitude, id_format, fo_format, id_division, dv_division, id_channel, ch_channel, "
						. " id_pdv_type, pvt_pdv_type, pdv_ad_id_address "
					. " FROM " . PFX_MAIN_DB . "pdv "  
						. " INNER JOIN " . PFX_MAIN_DB . "pdv_type ON id_pdv_type = pdv_pvt_id_pdv_type "
						. " INNER JOIN " . PFX_MAIN_DB . "format ON id_format = pdv_fo_id_format "
						//. " INNER JOIN " . PFX_MAIN_DB . "group ON id_group = fo_gr_id_group "
						. " INNER JOIN " . PFX_MAIN_DB . "channel ON id_channel = pdv_ch_id_channel "
						. " INNER JOIN " . PFX_MAIN_DB . "division ON id_division = pdv_dv_id_division "
						
					. " WHERE id_pdv = :id_pdv ";
			$info = $obj_bd->query( $query, array( ':id_pdv' => $id_pdv ) );
			if ( $info !== FALSE ){
				if ( count($info) > 0 ){ 
					$pv = $info[0];
					$this->id_pdv 		= $pv['id_pdv'];  
					$this->jde 			= $pv['pdv_jde'];
					$this->name			= $pv['pdv_name']; 
					$this->lastname		= $pv['pdv_lastname']; 
					$this->lastname2	= $pv['pdv_lastname2'];
					$this->route		= $pv['pdv_route'];
					$this->latitude		= $pv['pdv_latitude']; 
					$this->longitude	= $pv['pdv_longitude']; 
					
					$this->invoice		= $pv['pdv_invoice']; 
					
					$this->id_format	= $pv['id_format'];
					$this->format		= $pv['fo_format'];
					$this->id_division	= $pv['id_division'];
					$this->division		= $pv['dv_division'];
					 
					//$this->id_group		= $pv['id_group']; 
					//$this->group		= $pv['gr_group']; 
					$this->id_channel	= $pv['id_channel'];
					$this->channel		= $pv['ch_channel']; 
					
					$this->id_pdv_type	= $pv['id_pdv_type']; 
					$this->pdv_type		= $pv['pvt_pdv_type']; 
					
					$this->id_address	= $pv['pdv_ad_id_address'];
					
					$this->timestamp	= $pv['pdv_timestamp']; 
					
					$this->set_address($this->id_address);
					$this->set_contact();
					$this->set_schedule();
					
					$this->set_meta(); 
					
					
				} else {
					$this->set_error( "PDV not found (" . $id_pdv . "). ", ERR_DB_NOT_FOUND, 2 ); 
				}
			} else { 
				$this->set_error( "An error ocurred while querying the Data Base. ", ERR_DB_QRY, 2 );
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
	 * set_meta()
	 * Sets the pdv meta options and values
	 * 
	 */
	private function set_meta(){ 
		if ( !class_exists( 'PDVMeta' ) ) 
	  		require_once 'class.pdv_meta.php';
		$this->meta = new PDVMeta( $this->id_pdv );
	} 
	
	/**
	 * set_contact()
	 * Sets the pdv contact info from the DB
	 */
	private function set_contact(){
		
		if ( $this->id_pdv > 0 ){
			global $obj_bd;
			$query = "SELECT "
						. " pvc_business_name, pvc_rfc, pvc_phone_1, pvc_curp, pvc_email " 
					. " FROM " . PFX_MAIN_DB . "pdv_contact "
					. " WHERE pvc_pdv_id_pdv = :id_pdv  ";
			$resp = $obj_bd->query($query, array( ':id_pdv' => $this->id_pdv ));
			if ( $resp !== FALSE ){
				if ( count( $resp ) > 0 ){
					$c = $resp[0];
					$this->contact->business_name	= $c['pvc_business_name'];
					$this->contact->rfc				= $c['pvc_rfc'];
					$this->contact->phone_1			= $c['pvc_phone_1'];
					$this->contact->curp			= $c['pvc_curp'];
					$this->contact->email			= $c['pvc_email'];
				}
			} else {
				$this->set_error(" AN error occured while querying for the contact", ERR_DB_QRY);
			}
		} 
	}
	 
	
	/**
	 * set_schedule()
	 * Sets the pdv schdeule info from the DB
	 */
	private function set_schedule(){
		if ( $this->id_pdv > 0 ){
			global $obj_bd;
			$query = "SELECT "
						. " id_frequency, fr_frequency, pvi_schedule_from, pvi_schedule_to, pvi_weekdays  " 
					. " FROM " . PFX_MAIN_DB . "pdv_info "
						. " INNER JOIN " . PFX_MAIN_DB . "frequency ON id_frequency = pvi_fr_id_frequency "
					. " WHERE pvi_pdv_id_pdv = :id_pdv  ";
			$resp = $obj_bd->query($query, array( ':id_pdv' => $this->id_pdv ));
			if ( $resp !== FALSE ){
				if ( count( $resp ) > 0 ){
					$c = $resp[0];
					$this->schedule->id_frequency	= $c['id_frequency'];
					$this->schedule->frequency		= $c['fr_frequency'];
					$this->schedule->schedule_from	= $c['pvi_schedule_from'];
					$this->schedule->schedule_to	= $c['pvi_schedule_to'];
					$this->schedule->weekdays_str	= $c['pvi_weekdays'];
					$this->schedule->weekdays 		= explode(";", $this->schedule->weekdays_str);
				}
			} else {
				$this->set_error(" AN error occured while querying for the schdeule info", ERR_DB_QRY, 1);
			}
		} 
	} 
	
	/**
	 * get_array()
	 * returns an Array with pdv information
	 * 
	 * @param 	$full Boolean if TRUE returns PDV and Instance Arrays (default FALSE)
	 * 
	 * @return	$array Array width User information
	 */
	 public function get_array(){
	 	$array = array(
	 					'id_pdv' 		=>	$this->id_pdv, 
	 					'name' 			=>	$this->name,  
	 					'timestamp'		=>	$this->timestamp
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
	 public function get_info_html(){
	 	$html  = "";
		$pdv = $this;
		ob_start();
		require_once DIRECTORY_VIEWS . "pdv/info.pdv.php"; 
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
		$this->id_pdv 		=  0; 
		$this->name			= ""; 
		$this->route			= ""; 
		$this->latitude		= ""; 
		$this->longitude	= "";
 
		$this->id_format	= 0;
		$this->format		= ""; 
		$this->id_group		= 0;
		$this->group		= "";  
		$this->id_channel	= 0;
		$this->channel		= "";  
		
		$this->invoice		= 0;  
		
		$this->id_pdv_type	= 0;
		$this->pdv_type		= "";  
		
		$this->contact = new stdClass; 
		$this->contact->business_name	= "";
		$this->contact->rfc				= "";
		$this->contact->phone_1			= "";
		$this->contact->curp			= "";
		$this->contact->email			= "";
		
		$this->schedule = new stdClass; 
		$this->schedule->id_frequency	= 0;
		$this->schedule->frequency		= "";
		$this->schedule->schedule_from	= "";
		$this->schedule->schedule_to	= "";
		$this->schedule->weekdays_str	= "";
		$this->schedule->weekdays		= array();
		 
		
		$this->timestamp 	= 0;
		$this->set_address(); 
		$this->set_meta(); 
		$this->error = array(); 
	}
	 
}

?>