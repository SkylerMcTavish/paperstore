<?php
/**
* Address CLass
* 
* @package		SF·Tracker 			
* @since        11/19/2014 
* 
*/ 
class Address extends Object {
	
	public $id_address; 
	public $street;
	public $ext_num;
	public $int_num;
	public $locality;
	public $city; 
	public $city_code; 
	public $district;
	public $zipcode;
	public $id_state;
	public $state; 
	public $country;
	
	public $timestamp; 
	public $error = array();
	
	/**
	* Address()    
	* Creates an Address object from the DB related to a PDV.
	*  
	* @param	$id_pdv (optional) If set populates values from DB record. 
	* 
	*/  
	function __construct( $id_address = 0 ){
		global $obj_bd;
		$this->class = 'Address';
		$this->error = array();
		if ( $id_address > 0 ){
			$query = "SELECT "
						. " id_address, ad_street, ad_ext_num, ad_int_num, ad_locality, ad_city, ad_district, ad_zipcode, " 
						. " id_state, st_state, st_code, st_country_code, ct_city "
					. " FROM " . PFX_MAIN_DB . "address "  
						. "INNER JOIN " . PFX_MAIN_DB . "state ON id_state = ad_st_id_state "
						. "LEFT JOIN " . PFX_MAIN_DB . "city ON ct_code = ad_city " 
					. " WHERE id_address = :id_address ";
			$info = $obj_bd->query( $query, array( ':id_address' => $id_address ) );
			if ( $info !== FALSE ){
				if ( count($info) > 0 ){ 
					$adr = $info[0];
					$this->id_address	= $adr['id_address'];
					$this->street		= $adr['ad_street']; 
					$this->ext_num		= $adr['ad_ext_num']; 
					$this->int_num		= $adr['ad_int_num']; 
					$this->locality		= $adr['ad_locality']; 
					$this->district		= $adr['ad_district'];
					$this->city_code	= $adr['ad_city'];
					$this->city			= $adr['ct_city'];
					$this->zipcode		= $adr['ad_zipcode'];
					$this->id_state		= $adr['id_state']; 
					$this->state		= $adr['st_state']; 
					$this->state_code	= $adr['st_code'];  
					$this->country		= $adr['st_country_code'];
					
				} else {
					$this->clean();
					$this->set_error( "Address not found (" . $id_address . "). ", ERR_DB_NOT_FOUND, 2 ); 
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
	* validate()    
	* Validates the values before inputing to Data Base 
	*  
	* @return        Boolean TRUE if valid; FALSE if invalid
	*/ 
	public function validate(){ 
		global $Validate; 
		if ( !$this->street != '' ){
			$this->set_error( 'Street value empty. ', ERR_VAL_EMPTY );
			return FALSE;
		} 
		if ( !$this->ext_num != '' ){
			$this->set_error( 'External Number value empty. ', ERR_VAL_EMPTY );
			return FALSE;
		} 
		if ( !$this->id_state > 0  ){
			$this->set_error( 'Invalid state. ', ERR_VAL_EMPTY );
			return FALSE;
		} 
		return TRUE; 
	}
	
	/**
	* save()    
	* Inserts or Update the record in the DB. 
	* 
	*/  
	public function save(){
		global $Session;
		if ( $Session->is_admin() ){ 
			if ( $this->validate() ){
				global $obj_bd;
				
				$values = array( 
							':street' 	=> $this->street, 
							':ext_num' 	=> $this->ext_num, 
							':int_num' 	=> $this->int_num , 
							':district' => $this->district, 
							':locality' => $this->locality , 
							':city' 	=> $this->city_code,  
							':id_state' => $this->id_state, 
							':zipcode' 	=> $this->zipcode   
						); 
				if ( $this->id_address > 0 ){
					$values[':id_address'] = $this->id_address; 
					$query = " UPDATE " . PFX_MAIN_DB . "address SET "  
								. " ad_street		= :street, " 
								. " ad_ext_num	 	= :ext_num, "
								. " ad_int_num	 	= :int_num, "  
								. " ad_district		= :district, " 
								. " ad_locality	 	= :locality, "
								. " ad_city		 	= :city, "
								. " ad_st_id_state	= :id_state, "
								. " ad_zipcode	 	= :zipcode " 
							. " WHERE id_address 	= :id_address ";
				} else {
					$query = "INSERT INTO " . PFX_MAIN_DB . "address ( ad_street, ad_ext_num, ad_int_num, ad_district, ad_locality, ad_city, ad_st_id_state, ad_zipcode ) "
							. " VALUES  ( :street, :ext_num, :int_num, :district, :locality, :city, :id_state, :zipcode ) ";
				}  
				$result = $obj_bd->execute( $query, $values );
				if ( $result !== FALSE ){
					if ( $this->id_address == 0){
						$this->id_address = $obj_bd->get_last_id();
					}
					$this->set_msg('SAVE', " Address " . $this->id_address. " saved. "); 
					return TRUE;
				} else {
					$this->set_error( "An error ocurred while trying to save the record. ", ERR_DB_EXEC, 3 );
					return FALSE;
				} 
			} 
		} else {
			$this->set_error("Restricted action.", SES_RESTRICTED_ACTION);
			return FALSE;
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
	 public function get_array( ){
	 	$array = array(  
	 					'street'	=> $this->street,  
	 					'ext_num'	=> $this->ext_num,
	 					'int_num'	=> $this->int_num,
	 					'district'	=> $this->district,  
	 					'locality'	=> $this->locality,  
	 					'city_code'	=> $this->city_code,   
	 					'city'		=> $this->city, 
	 					'zipcode'	=> $this->zipcode,
	 					'id_state'	=> $this->id_state,
	 					'state_code'=> $this->state_code,
	 					'state'		=> $this->state,  
	 					'country'	=> $this->country
					); 
		return $array;
	 }
	
	/**
	 * get_string()
	 * returns the Address formated as a string
	 *   
	 * @return	$string 
	 */
	 public function get_string( $html = TRUE ){
	 	$break = $html ? "<br/>" : "\n"; 
		return " " . $this->street . " " . $this->ext_num . ( $this->int_num != '' ? ", " . $this->int_num : "" ) . ", " . $break 
				. " " . $this->district . ", " . $this->locality . ", " . $break
				. " " . $this->city . ", " . $this->state . ", " . $break
				. " " . $this->zipcode . ", " . $this->country;
	 } 
	
	/**
	 * get_string_api()
	 * returns the Address formated as a string
	 *   
	 * @return	$string 
	 */
	 public function get_string_api(){ 
		return " " . $this->street . " " . $this->ext_num . ( $this->int_num != '' ? ", " . $this->int_num : "" ) . ", " 
				. " " . $this->district . ", " . $this->locality . ", "  
				. " " . $this->zipcode . ", " . " " . $this->city . ", " 
				. $this->state ;
	 } 
	
	/**
	* clean()    
	* Cleans all parameters and resets all objects
	*  
	*/  
	public function clean(){ 
		$this->id_address	= 0;
		$this->street		= ""; 
		$this->ext_num		= ""; 
		$this->int_num		= ""; 
		$this->locality		= ""; 
		$this->city			= ""; 
		$this->brick		= ""; 
		$this->district		= ""; 
		$this->zipcode		= "";
		$this->id_state		= 0; 
		$this->state		= ""; 
		$this->id_country 	= 0; 
		$this->country		= ""; 
		$this->timestamp	= 0;  
		$this->error = array(); 
	}
	 
}

?>