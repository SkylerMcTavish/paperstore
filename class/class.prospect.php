<?php
/**
* Prospect CLass
* 
* @package		SF·Tracker 			
* @since        11/19/2014 
* 
*/ 
class Prospect extends Object {
		
		public $id_prospect	;  
		
		public $id_channel;	
		public $channel		; 
		public $id_division	;
		public $division;
		   
		public $rfc;
		public $phone;
		public $curp;
		public $email; 
		
		public $name; 
		public $lastname; 
		public $lastname2; 
		
		public $street;	
		public $ext_num; 
		public $int_num;
		
		public $district;
		public $locality;
		public $city;
		public $state;  
		
		public $route; 
		
		public $id_user;
		public $user; 
		
		public $latitude; 
		public $longitude;
   
		public $timestamp;  
		public $error = array(); 
	
	/**
	* Prospect()    
	* Creates a User object from the DB.
	*  
	* @param	$id_prospect (optional) If set populates values from DB record. 
	* 
	*/  
	function __construct( $id_prospect = 0 ){
		global $obj_bd;
		$this->class = 'Prospect';
		$this->error = array();
		$this->clean();
		if ( $id_prospect > 0 ){ 
			$query = "SELECT id_prospect, "
						. " pro_name, pro_lastname, pro_lastname2, pro_latitude, pro_longitude, pro_phone, pro_street, pro_ext_num, pro_int_num, "
						. " pro_district, pro_locality, pro_city, pro_state, pro_email, pro_rfc, pro_curp, pro_route, "
						. " id_division, id_channel, pro_status, pro_timestamp, id_user, us_user, ch_channel, dv_division "
					. " FROM " . PFX_MAIN_DB . "prospect "
						. " INNER JOIN " . PFX_MAIN_DB . "user ON id_user = pro_us_id_user " 
						. " LEFT JOIN " . PFX_MAIN_DB . "channel ON id_channel = pro_ch_id_channel "
						. " LEFT JOIN " . PFX_MAIN_DB . "division ON id_division = pro_dv_id_division " 
					. " WHERE id_prospect = :id_prospect ";
			$info = $obj_bd->query( $query, array( ':id_prospect' => $id_prospect ) );
			if ( $info !== FALSE ){
				if ( count($info) > 0 ){ 
					$pv = $info[0];
					$this->id_prospect 	= $pv['id_prospect']; 
					$this->name			= $pv['pro_name']; 
					$this->lastname		= $pv['pro_lastname']; 
					$this->lastname2	= $pv['pro_lastname2'];
					$this->route		= $pv['pro_route'];
					$this->latitude		= $pv['pro_latitude']; 
					$this->longitude	= $pv['pro_longitude']; 
					 
					$this->id_channel	= $pv['id_channel'];
					$this->channel		= $pv['ch_channel']; 
					$this->id_division	= $pv['id_division']; 
					$this->division		= $pv['dv_division'];
					   
					$this->rfc			= $pv['pro_rfc'];
					$this->phone		= $pv['pro_phone'];
					$this->curp			= $pv['pro_curp'];
					$this->email		= $pv['pro_email'];   
					
					
					$this->street		= $pv['pro_street']; 
					$this->ext_num		= $pv['pro_ext_num']; 
					$this->int_num		= $pv['pro_int_num']; 
					$this->district		= $pv['pro_district']; 
					$this->locality		= $pv['pro_locality']; 
					$this->city			= $pv['pro_city']; 
					$this->state		= $pv['pro_state'];
					 
					$this->id_user		= $pv['id_user']; 
					$this->user			= $pv['us_user']; 
					
					$this->timestamp	= $pv['pro_timestamp']; 
				} else {
					$this->set_error( "Prospect not found (" . $id_prospect . "). ", ERR_DB_NOT_FOUND, 2 ); 
				}
			} else { 
				$this->set_error( "An error ocurred while querying the Data Base. ", ERR_DB_QRY, 2 );
			} 
		}   
	} 


	/**
	* save()    
	* Inserts or Update the record in the DB. 
	* 
	*/  
	public function save(){  
			global $obj_bd; 
			$values = array(  
						':name' 		=> $this->name, 
						':lastname' 	=> $this->lastname, 
						':lastname2' 	=> $this->lastname2,
						':route'	 	=> $this->route,
						
						':rfc' 			=> $this->rfc,
						':phone'		=> $this->phone,
						':curp' 		=> $this->curp,
						':email' 		=> $this->email, 
						 
						':street' 		=> $this->street,	
						':ext_num' 		=> $this->ext_num, 
						':int_num' 		=> $this->int_num,
						':district' 	=> $this->district, 
						':locality' 	=> $this->locality, 
						':city' 		=> $this->city,
						':state' 		=> $this->state,
						
						':latitude' 	=> $this->latitude, 
						':longitude'	=> $this->longitude,
				   
						':id_channel' 	=> $this->id_channel,  
						':id_division' 	=> $this->id_division,  
					  
						':id_user'			=> $this->id_user, 
						':timestamp' 		=> time() 
					);  
			$action = "INSERT";  
			$query = "INSERT INTO " . PFX_MAIN_DB . "prospect "
			. " ( pro_name, pro_lastname, pro_lastname2, pro_latitude, pro_longitude, pro_phone, pro_street, pro_ext_num, pro_int_num, "
					. " pro_district, pro_locality, pro_city, pro_state, pro_email, pro_rfc, pro_curp, pro_route, "
					. " pro_dv_id_division, pro_ch_id_channel, pro_status, pro_timestamp, pro_us_id_user ) "
			. " VALUES (:name, :lastname, :lastname2, :latitude, :longitude, :phone, :street, :ext_num, :int_num, "
					. " :district, :locality, :city, :state, :email, :rfc, :curp, :route, "
					. " :id_division, :id_channel, 1, :timestamp, :id_user ) " ; 
			
			
			$result = $obj_bd->execute( $query, $values ); 
			if ( $result !== FALSE ){ 
				if ( $this->id_prospect == 0){ //new record
					$this->id_prospect = $obj_bd->get_last_id(); 
				}  
				$this->set_msg( $action , " Prospect " . $this->id_prospect. " saved. ");
				return TRUE;
			} else { 
				$this->set_error( "An error ocurred while trying to save the record. " , ERR_DB_EXEC, 3 );
				return FALSE;
			}  
	} 

	 
	/**
	 * get_array()
	 * returns an Array with prospect information
	 * 
	 * @param 	$full Boolean if TRUE returns Prospect and Instance Arrays (default FALSE)
	 * 
	 * @return	$array Array width User information
	 */
	 public function get_array(){
	 	$array = array(
	 					'id_prospect' 	=>	$this->id_prospect,
						'name' 		=> $this->name, 
						'lastname' 	=> $this->lastname, 
						'lastname2' 	=> $this->lastname2,
						'route'	 	=> $this->route,
						
						'rfc' 			=> $this->rfc,
						'phone'		=> $this->phone,
						'curp' 		=> $this->curp,
						'email' 		=> $this->email, 
						 
						'street' 		=> $this->street,	
						'ext_num' 		=> $this->ext_num, 
						'int_num' 		=> $this->int_num,
						'district' 		=> $this->district, 
						'locality' 		=> $this->locality, 
						'city' 			=> $this->city,
						'state' 		=> $this->state,
						
						'latitude' 		=> $this->latitude, 
						'longitude'		=> $this->longitude,
				   
						'id_channel' 	=> $this->id_channel,  
						'id_division' 	=> $this->id_division,  
					  
						'id_user'		=> $this->id_user, 
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
		$prospect = $this;
		ob_start();
		require_once DIRECTORY_VIEWS . "prospect/info.prospect.php"; 
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
		$this->id_prospect 	=  0; 
		$this->name			= ""; 
		$this->route		= ""; 
		$this->latitude		= ""; 
		$this->longitude	= "";
   
		$this->id_channel	= 0;
		$this->channel		= ""; 
		$this->id_division	= 0;
		$this->division		= "";  
		   
		$this->rfc			= "";
		$this->phone		= "";
		$this->curp			= "";
		$this->email		= "";  
		
		$this->name		= ""; 
		$this->lastname	= ""; 
		$this->lastname2= ""; 
		$this->latitude	= ""; 
		$this->longitude= ""; 
		$this->phone	= ""; 
		$this->street	= ""; 
		$this->ext_num	= ""; 
		$this->int_num	= ""; 
		$this->district	= ""; 
		$this->locality	= ""; 
		$this->city		= ""; 
		$this->state	= ""; 
		$this->email	= ""; 
		$this->rfc		= ""; 
		$this->curp		= ""; 
		$this->route	= ""; 
		
		$this->id_user	= ""; 
		$this->user	= ""; 
		
		$this->timestamp 	= 0; 
		$this->error = array(); 
	} 
}

?>