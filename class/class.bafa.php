<?php
/**
* BAFA CLass
* 
* @package		SF Tracker			
* @since        26/11/2014  
* 
*/ 
class BAFA extends Object {
	 
	public $branches = array(); 
	
	/**
	* User()    
	* Creates a User object from the DB.
	*  
	* @param	$id_supplier (optional) If set populates values from DB record. 
	* 
	*/  
	function __construct( ){
		global $obj_bd;
		$this->error = array();
		$this->class = "BAFA";
	}
	
	/**
	 * get_brand()
	 * Returns a  the brand record form the DB for the $id_brand recieved
	 * 
	 * @param 	$id_brand 
	 */
	public function get_brand( $id_brand ){ 
		$brand = new stdClass;
		$brand->id_brand = 0;
		$brand->brand = ""; 
		if ( $id_brand > 0 ){
			global $obj_bd; 
			$query = "SELECT id_brand, ba_brand, ba_rival FROM " . PFX_MAIN_DB . "brand WHERE id_brand = :id_brand ";
			$resp = $obj_bd->query( $query, array( ':id_brand' => $id_brand ) );
			if ( $resp !== FALSE ){
				$ch = $resp[0]; 
				$brand->id_brand= $ch['id_brand'];
				$brand->brand 	= $ch['ba_brand'];
				$brand->rival 	= $ch['ba_rival'];
			}
		}
		return $brand;
	}
	
	/**
	 * get_family()
	 * Returns a  the family record form the DB for the $id_family recieved
	 * 
	 * @param 	$id_family 
	 */
	public function get_family( $id_family ){ 
		$family = new stdClass;
		$family->id_family = 0;
		$family->id_brand= 0;
		$family->brand= "";
		$family->family = ""; 
		if ( $id_family > 0 ){
			global $obj_bd; 
			$query = "SELECT id_family, fa_ba_id_brand, fa_family, fa_rival FROM " . PFX_MAIN_DB . "family WHERE id_family = :id_family ";
			$resp = $obj_bd->query( $query, array( ':id_family' => $id_family ) );
			if ( $resp !== FALSE ){
				$ch = $resp[0]; 
				$family->id_family	= $ch['id_family'];
				$family->id_brand 	= $ch['fa_ba_id_brand'];
				$family->family 	= $ch['fa_family'];
				$family->rival	 	= $ch['fa_rival'];
			}
		}
		return $family;
	} 
	 
	/**
	* validate_brand()    
	* Validates the brand values before inputing to Data Base 
	*  
	* @return        Boolean TRUE if valid; FALSE if invalid
	*/ 
	public function validate_brand( $brand ){ 
		global $Validate; 
		if ( !is_numeric($brand->id_brand) || $brand->id_brand < 0 ){
			$this->set_error( 'Invalid Id value ( ' . $brand->id_brand . ' ). ', ERR_VAL_INVALID );
			return FALSE;
		} 
		if ( !$brand->brand != '' ){
			$this->set_error( 'Brand value empty. ', ERR_VAL_EMPTY );
			return FALSE;
		} 
		if ( !$Validate->is_unique( 'brand', 'ba_brand', $brand->brand, 'id_brand', $brand->id_brand ) ){
			$this->set_error( 'Brand not unique. ', ERR_VAL_NOT_UNIQUE );
			return FALSE;
		} 
			
		return TRUE; 
	}
	
	/**
	* validate_family()    
	* Validates the family values before inputing to Data Base 
	*  
	* @return        Boolean TRUE if valid; FALSE if invalid
	*/ 
	public function validate_family( $family ){ 
		global $Validate; 
		if ( !is_numeric($family->id_family) || $family->id_family < 0 ){
			$this->set_error( 'Invalid Id value ( ' . $family->id_family . ' ). ', ERR_VAL_INVALID );
			return FALSE;
		} 
		if ( !is_numeric($family->id_brand) || $family->id_brand < 1 ){
			$this->set_error( 'Invalid Brand ID value ( ' . $family->id_brand. ' ). ', ERR_VAL_INVALID );
			return FALSE;
		} 
		if ( !$family->family != '' ){
			$this->set_error( 'Family value empty. ', ERR_VAL_EMPTY );
			return FALSE;
		} 
		if ( !$Validate->is_unique( 'family', 'fa_family', $family->family, 'id_family', $family->id_family, 'fa_ba_id_brand', $family->id_brand ) ){
			$this->set_error( 'Family not unique. ', ERR_VAL_NOT_UNIQUE );
			return FALSE;
		} 
			
		return TRUE; 
	}
	 
	
	/**
	* save_brand()    
	* Inserts or Update the record in the DB. 
	* 
	 * @param 	$brand Brand object
	*/  
	public function save_brand( $brand ){
		global $Session;
		if ( $Session->is_admin() ){ 
			if ( $this->validate_brand( $brand ) ){
				global $obj_bd;
				
				$values = array( 
							':ba_brand' => $brand->brand, 
							':ba_rival' => $brand->rival, 
							':ba_timestamp' => time() 
						);
				if ( $brand->id_brand > 0 ){
					$values[':id_brand'] = $brand->id_brand;
					$query = " UPDATE " . PFX_MAIN_DB . "brand SET "  
								. " ba_brand	 = :ba_brand , " 
								. " ba_rival	 = :ba_rival, " 
								. " ba_status	 = 1, "
								. " ba_timestamp = :ba_timestamp "
							. " WHERE id_brand = :id_brand ";
				} else {
					$query = "INSERT INTO " . PFX_MAIN_DB . "brand ( ba_brand, ba_rival, ba_status, ba_timestamp ) "
							. " VALUES  ( :ba_brand, :ba_rival, 1, :ba_timestamp ) ";
				}  
				$result = $obj_bd->execute( $query, $values );
				if ( $result !== FALSE ){
					if ( $brand->id_brand == 0){
						$brand->id_brand = $obj_bd->get_last_id();
					}
					$this->set_msg('SAVE', " Brand " . $brand->id_brand . " saved. ");
					return TRUE;
				} else {
					$this->set_error( "An error ocurred while trying to save brand record. ", ERR_DB_EXEC, 3 );
					return FALSE;
				} 
			}
			
		} else {
			$this->set_error("Restricted action.", SES_RESTRICTED_ACTION);
			return FALSE;
		}
	}

	/**
	* save_family()    
	* Inserts or Update the record in the DB. 
	* 
	 * @param 	$family Family object
	*/  
	public function save_family( $family ){
		global $Session;
		if ( $Session->is_admin() ){ 
			if ( $this->validate_family( $family ) ){
				global $obj_bd; 
				$values = array( ':id_brand' => $family->id_brand, ':fa_family' => $family->family, ':fa_rival' => $family->rival, ':fa_timestamp' => time() );
				if ( $family->id_family > 0 ){
					$values[':id_family'] = $family->id_family;
					$query = " UPDATE " . PFX_MAIN_DB . "family SET "  
								. " fa_ba_id_brand = :id_brand , " 
								. " fa_family	 = :fa_family , " 
								. " fa_rival	 = :fa_rival , " 
								. " fa_status	 = 1, "
								. " fa_timestamp = :fa_timestamp "
							. " WHERE id_family = :id_family ";
				} else {
					$query = "INSERT INTO " . PFX_MAIN_DB . "family ( fa_family, fa_ba_id_brand, fa_rival, fa_status, fa_timestamp ) "
							. " VALUES  ( :fa_family, :id_brand, :fa_rival, 1, :fa_timestamp ) ";
				}  
				$result = $obj_bd->execute( $query, $values );
				if ( $result !== FALSE ){
					if ( $family->id_family == 0){
						$family->id_family = $obj_bd->get_last_id();
					}
					$this->set_msg('SAVE', " Family " . $family->id_family . " saved. ");
					return TRUE;
				} else {
					$this->set_error( "An error ocurred while trying to save family record. ", ERR_DB_EXEC, 3 );
					return FALSE;
				} 
			}
			
		} else {
			$this->set_error("Restricted action.", SES_RESTRICTED_ACTION);
			return FALSE;
		}
	}
	 
	/**
	* delete_brand()    
	* Changes status for Brand to 0 in the DB.
	*
	* @param	$id_brand
	* @return 	TRUE on success; FALSE otherwise 
	*/  
	public function delete_brand( $id_brand ){
		global $Session;
		if ( $Session->is_admin() ){
			global $obj_bd;
			$query = " UPDATE "  . PFX_MAIN_DB . "brand SET ba_status = 0 WHERE id_brand = :id_brand ";
			$result = $obj_bd->execute( $query, array( ':id_brand' => $id_brand ) );
			if ( $result !== FALSE ){
				$this->set_msg('DELETE', " Brand " . $id_brand . " deleted. "); 
				return TRUE;
			} else {
				$this->set_error( "An error ocurred while trying to set status to 0. ", ERR_DB_EXEC, 3 );
				return FALSE;
			} 
		}
	}
	
	/**
	* delete_family()    
	* Changes status for Family to 0 in the DB.
	*
	* @param	$id_family
	* @return 	TRUE on success; FALSE otherwise 
	*/  
	public function delete_family( $id_family ){
		global $Session;
		if ( $Session->is_admin() ){
			global $obj_bd;
			$query = " UPDATE "  . PFX_MAIN_DB . "family SET fa_status = 0 WHERE id_family = :id_family ";
			$result = $obj_bd->execute( $query, array( ':id_family' => $id_family ) );
			if ( $result !== FALSE ){
				$this->set_msg('DELETE', " Family " . $id_family . " deleted. ");
				return TRUE;
			} else {
				$this->set_error( "An error ocurred while trying to set status to 0. ", ERR_DB_EXEC, 3 );
				return FALSE;
			} 
		}
	} 
	 
}

?>