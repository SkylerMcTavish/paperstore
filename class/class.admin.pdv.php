<?php

if (!class_exists('PDV')){
	require_once 'class.pdv.php';
}

/**
* AdminPDV CLass
* 
* @package		SF·Tracker 			
* @since        11/23/2014 
* 
*/ 
class AdminPDV extends PDV {
	 
	/**
	* __construct()    
	* Creates a User object from the DB.
	*  
	* @param	$id_pdv (optional) If set populates values from DB record. 
	* 
	*/  
	function __construct( $id_pdv ){
		global $Session;  
		$this->class = 'AdminPDV';  
		if ( !$Session->is_admin() ){
			$this->set_error('Restricted Access', SES_RESTRICTED_ACCESS, 3);
			throw new Exception("Restricted access.", 1); 
		}
		parent::__construct( $id_pdv );
		$this->class = 'AdminPDV';  
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
							':id_pdv_type' 	 => $this->id_pdv_type,
							':pdv_name' 	 => $this->name,  
							':pdv_lastname'  => $this->lastname,  
							':pdv_lastname2' => $this->lastname2,  
							':pdv_route'	 => $this->route, 
							':jde' 			 => $this->jde,
							':invoice'		 => $this->invoice,
							':id_format' 	 => $this->id_format,
							':id_channel' 	 => $this->id_channel,
							':id_division' 	 => $this->id_division,
							':invoice'	 	 => $this->invoice,
							':pdv_latitude'	 => $this->latitude,
							':pdv_longitude' => $this->longitude,  
							':pdv_timestamp' => time() 
						);
				if ( $this->id_pdv > 0 ){ 
					$values[':id_pdv'] = $this->id_pdv ;
					$query = " UPDATE " . PFX_MAIN_DB . "pdv SET "  
								. " pdv_pvt_id_pdv_type = :id_pdv_type, "
								. " pdv_name 			= :pdv_name , " 
								. " pdv_lastname		= :pdv_lastname , " 
								. " pdv_lastname2		= :pdv_lastname2 , " 
								. " pdv_route 			= :pdv_route , " 
								. " pdv_fo_id_format	= :id_format , "
								. " pdv_ch_id_channel	= :id_channel , "
								. " pdv_dv_id_division	= :id_division , " 
								. " pdv_jde 			= :jde , "  
								. " pdv_invoice			= :invoice , " 
								. " pdv_latitude 		= :pdv_latitude , " 
								. " pdv_longitude 		= :pdv_longitude , " 
								. " pdv_status	 		= 1, "
								. " pdv_timestamp 		= :pdv_timestamp "
							. " WHERE id_pdv 	= :id_pdv ";
				} else { 
					$query = "INSERT INTO " . PFX_MAIN_DB . "pdv "
							. " (pdv_pvt_id_pdv_type, pdv_fo_id_format, pdv_ch_id_channel, pdv_dv_id_division, pdv_name, pdv_lastname, pdv_lastname2,  pdv_jde, pdv_route, pdv_invoice, pdv_latitude, pdv_longitude, pdv_status, pdv_timestamp ) "
							. " VALUES (:id_pdv_type, :id_format, :id_channel, :id_division, :pdv_name, :pdv_lastname, :pdv_lastname2, :jde, :pdv_route, :invoice, :pdv_latitude, :pdv_longitude, 1, :pdv_timestamp ) ";
				}  
				$result = $obj_bd->execute( $query, $values );
				if ( $result !== FALSE ){ 
					if ( $this->id_pdv == 0){
						$this->id_pdv = $obj_bd->get_last_id();
					}
					$this->set_msg('SAVE', " PDV " . $this->id_pdv. " saved. ");
					
					$addr = $this->save_address();
					$cont = $this->save_contact();
					$schd = $this->save_schedule();
					$extr = $this->meta->save_values( $this->id_pdv );
					
					return $addr && $cont && $schd && $extr ;
				} else { 
					$this->set_error( "An error ocurred while trying to save the record. "  , ERR_DB_EXEC, 3 );
					return FALSE;
				} 
			}
			
		} else {
			$this->set_error("Restricted action.", SES_RESTRICTED_ACTION);
			return FALSE;
		}
	}
	
	/**
	* save_address()    
	* Creates an Address object related to the PDV
	* @param         $id_address ( 0 )
	*  
	*/  
	private function save_address(){ 
		if ( $this->address->save() ){
			global $obj_bd;
			$this->id_address = $this->address->id_address;
			$query = "UPDATE " . PFX_MAIN_DB . "pdv SET "
						. " pdv_ad_id_address = :id_address "
					. " WHERE id_pdv = :id_pdv ";
			$resp = $obj_bd->execute( $query, array( ':id_address' => $this->id_address, ':id_pdv' => $this->id_pdv ) );
			if ( !$resp ){
				$this->set_error( ' An error occurred while updating PDV id_address ', ERR_DB_EXEC, 3 );
				return FALSE;
			} else {
				return TRUE;
			}
		} else {
			return FALSE;
		}
	}
	
	/**
	 * save_contact()
	 * Saves the pdv contact info to the DB
	 * 
	 * @return 	TRUE | FALSE
	 */
	private function save_contact(){ 
		if ( $this->id_pdv > 0 ){
			if ( $this->validate_contact() ){
				global $obj_bd;
				$query = "SELECT id_pdv_contact "  
						. " FROM " . PFX_MAIN_DB . "pdv_contact "
						. " WHERE pvc_pdv_id_pdv = :id_pdv  ";
				$resp = $obj_bd->query($query, array( ':id_pdv' => $this->id_pdv ));
				if ( $resp !== FALSE ){ 
					if ( count( $resp ) > 0 ){
						 $query = "UPDATE " . PFX_MAIN_DB . "pdv_contact SET "
						 			. " pvc_business_name = :pvc_business_name, "
						 			. " pvc_rfc 	= :pvc_rfc, "
						 			. " pvc_phone_1 = :pvc_phone_1, "
						 			. " pvc_curp 	= 	:pvc_curp, "
						 			. " pvc_email 	= :pvc_email "
								. " WHERE pvc_pdv_id_pdv = :id_pdv ";
					} else {
						 $query = "INSERT INTO " . PFX_MAIN_DB . "pdv_contact ( pvc_pdv_id_pdv, pvc_business_name, pvc_rfc, pvc_phone_1, pvc_curp, pvc_email) "
						 		. " VALUES ( :id_pdv, :pvc_business_name, :pvc_rfc, :pvc_phone_1, :pvc_curp, :pvc_email) "; 
					} 
					$values = array( 
								':id_pdv'			 => $this->id_pdv,
								':pvc_business_name' => $this->contact->business_name,
								':pvc_rfc' 			 => $this->contact->rfc,
								':pvc_phone_1' 		 => $this->contact->phone_1,
								':pvc_curp'			 => $this->contact->curp,
								':pvc_email' 		 => $this->contact->email 
							);
					$resp = $obj_bd->execute($query, $values );
					if ( !$resp ){
						$this->set_error( ' An error occurred while saving PDV contact information ', ERR_DB_EXEC, 3 );
						return FALSE;
					} else {
						$this->set_msg('SAVE', " PDV " . $this->id_pdv. " contact information saved. ");
						return TRUE;
					} 
				} else {
					$this->set_error(" An error occured while querying for the contact", ERR_DB_QRY);
					return FALSE;
				}
			} else { //Validation
				return FALSE;
			}
		} 
	}
	 
	/**
	 * save_schedule()
	 * Saves the pdv schdeule info to the DB
	 * 
	 * @return 	TRUE | FALSE
	 */
	private function save_schedule(){
		if ( $this->id_pdv > 0 ){
			global $obj_bd;
			$query = "SELECT id_pdv_info "  
					. " FROM " . PFX_MAIN_DB . "pdv_info "
					. " WHERE pvi_pdv_id_pdv = :id_pdv  ";
			$resp = $obj_bd->query($query, array( ':id_pdv' => $this->id_pdv ));
			if ( $resp !== FALSE ){ 
				if ( count( $resp ) > 0 ){
					 $query = "UPDATE " . PFX_MAIN_DB . "pdv_info SET "
					 			. " pvi_schedule_from 	= :schedule_from, "
					 			. " pvi_schedule_to		= :schedule_to, "
					 			. " pvi_weekdays 		= :weekdays, "
					 			. " pvi_fr_id_frequency = :id_frequency "
							. " WHERE pvi_pdv_id_pdv = :id_pdv ";
				} else {
					 $query = "INSERT INTO " . PFX_MAIN_DB . "pdv_info " 
					 			. " ( pvi_pdv_id_pdv, pvi_fr_id_frequency, pvi_schedule_from, pvi_schedule_to, pvi_weekdays ) "
					 		. " VALUES ( :id_pdv, :id_frequency, :schedule_from, :schedule_to, :weekdays ) "; 
				} 
				$values = array( 
							':id_pdv'			 => $this->id_pdv,
							':id_frequency'		 => $this->schedule->id_frequency  > 0  ?  $this->schedule->id_frequency : NULL,
							':schedule_from' 	 => $this->schedule->schedule_from,
							':schedule_to' 		 => $this->schedule->schedule_to,
							':weekdays'			 => $this->schedule->weekdays_str 
						); 
				$resp = $obj_bd->execute( $query, $values );
				if ( !$resp ){
					$this->set_error( ' An error occurred while saving PDV schdeule information ', ERR_DB_EXEC, 3 );
					return FALSE;
				} else {
					$this->set_msg('SAVE', " PDV " . $this->id_pdv. " schedule information saved. ");
					return TRUE;
				} 
			} else {
				$this->set_error(" AN error occured while querying for the schdeule information", ERR_DB_QRY);
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
		if ( !$this->name != '' ){
			$this->set_error( 'Name value empty. ', ERR_VAL_EMPTY );
			return FALSE;
		} 
		if ( !is_numeric($this->id_pdv_type) || !( $this->id_pdv_type > 0 ) ){ 
			$this->set_error( 'Invalid PDV Type value. ', ERR_VAL_INVALID );
			return FALSE;
		} 
		if ( !is_numeric($this->id_format) || !( $this->id_format > 0 ) ){ 
			$this->set_error( 'Invalid Format value. ', ERR_VAL_INVALID );
			return FALSE;
		} 
		return TRUE; 
	}

	/**
	* validate_contact()    
	* Validates the values before inputing to Data Base 
	*  
	* @return        Boolean TRUE if valid; FALSE if invalid
	*/ 
	public function validate_contact(){ 
		global $Validate; 
		if ( $this->contact->email != '' && !$Validate->is_email( $this->contact->email )){
			$this->set_error( 'Invalid email. ', ERR_VAL_INVALID );
			return FALSE;
		} 
		return TRUE; 
	}
	
	/**
	* validate_schedule()    
	* Validates the values before inputing to DB
	*  
	* @return        Boolean TRUE if valid; FALSE if invalid
	*/ 
	public function validate_schedule(){ 
		global $Validate; 
		if ( !is_numeric($this->schedule->id_frequency) || !( $this->schedule->id_frequency > 0 ) ){ 
			$this->set_error( 'Invalid Frequency value. ', ERR_VAL_INVALID );
			return FALSE;
		} 
		if ( !is_numeric($this->schedule->schedule_from) || !( $this->schedule->schedule_from >= 0 && $this->schedule->schedule_from < 24 ) ){ 
			$this->set_error( 'Invalid Schedule From value. ', ERR_VAL_INVALID );
			return FALSE;
		} 
		if ( !is_numeric($this->schedule->schedule_to) || !( $this->schedule->schedule_to >= 0 && $this->schedule->schedule_to < 24 ) ){ 
			$this->set_error( 'Invalid Schedule To value. ', ERR_VAL_INVALID );
			return FALSE;
		} 
		if ( $this->schedule->schedule_to < $this->schedule->schedule_from  ){ 
			$this->set_error( 'Invalid Schedule Range values (To < From). ', ERR_VAL_INVALID );
			return FALSE;
		} 
		if ( $this->schedule->weekdays_str != '' ){
			$this->set_error( 'Empty weekdays. ', ERR_VAL_EMPTY );
			return FALSE;
		} 
		
		return TRUE; 
	}
	
	/**
	* delete()    
	* Changes status for PDV to 0 in the DB.
	*
	* @return 	TRUE on success; FALSE otherwise 
	*/  
	public function delete(){
		global $Session;
		if ( $Session->is_admin() ){
			global $obj_bd;
			$query = " UPDATE "  . PFX_MAIN_DB . "pdv SET pdv_status = 0 WHERE id_pdv = :id_pdv ";
			$result = $obj_bd->execute( $query, array( ':id_pdv' => $this->id_pdv ) );
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