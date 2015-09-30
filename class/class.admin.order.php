<?php 
if (!class_exists('Order')){
	require_once 'class.order.php';
}
/**
* AdminOrder CLass
* 
* @package		SF·Tracker 			
* @since        11/25/2014 
*/ 
class AdminOrder extends Order {
	 
	/**
	* __construct()    
	* Creates a User object from the DB.
	*  
	* @param	$id_order (optional) If set populates values from DB record.  
	*/  
	function __construct( $id_order ){
		global $Session; 
		parent::__construct( $id_order );
		$this->class = 'AdminOrder';
	}
	
	/**
	* save()    
	* Inserts or Update the record in the DB. 
	* 
	*/  
	public function save(){ 
		if ( $this->validate() ){ 
			global $obj_bd; 
			$values = array(   
						':id_pdv'	 		=> $this->id_pdv,  
						':id_user'			=> $this->id_user,   
						':date'				=> $this->date,  
						':id_visit'			=> $this->id_visit,
						':id_order_status'	=> $this->id_order_status,
						':folio'			=> $this->folio,
						':timestamp' 		=> time() 
					);
			$action = "SAVE";
			if ( $this->id_order > 0 ){ 
				$action = "UPDATE";
				$values[':id_order'] 	= $this->id_order ; 
				$query = " UPDATE " . PFX_MAIN_DB . "order SET " 
							. " or_pdv_id_pdv			= :id_pdv , "
							. " or_us_id_user			= :id_user , "   
							. " or_vi_id_visit		 	= :id_visit , " 
							. " or_date					= :date, "
							. " or_folio 				= :folio, "
							. " or_os_id_order_status	= :id_order_status, "  
							. " or_status				= 1 , "
							. " or_timestamp 			= :timestamp " 
						. " WHERE id_order 	= :id_order ";
			} else { 
				$action = "INSERT";  
				$query = "INSERT INTO " . PFX_MAIN_DB . "order "
				. " (or_pdv_id_pdv, or_us_id_user, or_os_id_order_status, or_date, or_folio, or_vi_id_visit, or_status, or_timestamp) "
				. " VALUES (:id_pdv, :id_user, :id_order_status, :date, :folio,  :id_visit, 1, :timestamp) " ; 
			}  
			
			$result = $obj_bd->execute( $query, $values ); 
			if ( $result !== FALSE ){ 
				if ( $this->id_order == 0){ //new record
					$this->id_order = $obj_bd->get_last_id(); 
				}  
				$this->set_msg( $action , " Order " . $this->id_order. " saved. ");
				return $this->save_order_detail();
			} else { 
				$this->set_error( "An error ocurred while trying to save the record. " , ERR_DB_EXEC, 3 );
				return FALSE;
			} 
		} else {
			return FALSE;
		} 
	} 

	/**
	 * function save_order_detail()
	 * 
	 * @return 		Boolean TRUE on success; FALSE otherwize
	 */
	 private function save_order_detail(){
	 	if ( $this->id_order > 0 ){
	 		if ( count ( $this->detail ) > 0 ){
	 			global $obj_bd;
	 			$query = "DELETE FROM " . PFX_MAIN_DB . "order_detail WHERE od_or_id_order = :id_order ";
	 			$result = $obj_bd->execute($query, array( ':id_order' => $this->id_order)); 
	 			if ( $result !== FALSE ){
	 				$query = "INSERT INTO " . PFX_MAIN_DB . "order_detail ( od_or_id_order, od_pd_id_product, od_pp_id_product_presentation, od_quantity, od_price) "
							. " VALUES ( :id_order, :id_product, :id_product_presentation, :quantity, :price) " ;
					$resp = TRUE;
		 			foreach ($this->detail as $k => $detail) {
		 				$params = array( 
		 								':id_order' 	=> $this->id_order,
		 								':id_product' 	=> $detail->id_product,
		 								':id_product_presentation' => $detail->id_product_presentation,
		 								':quantity' 	=> $detail->quantity,
		 								':price' 		=> $detail->price 
		 							);
						$result = $obj_bd->execute($query, $params);
						if ( !($result !== FALSE)){
							$this->error[] = $this->set_error("An error occured while saving product detail ( Order " . $this->id_order . " Line " . $k . " )", ERR_DB_EXEC);
						}
						$resp = $resp & $result;
					}
					return $resp;
				} else {
					$this->set_error("A database error occured while preparing order details. ", ERR_DB_EXEC );
					return FALSE;
				}
	 		} else {
		 		$this->set_error("Empty order details.", ERR_VAL_EMPTY, 1);
		 		return FALSE;
		 	}
	 	} else {
	 		$this->set_error("Invalid order ID attempting to save detail.", ERR_VAL_INVALID, 3);
	 		return FALSE;
	 	}
	 }
	 
	/**
	* function validate_detail()
	* 
	* @return		Boolean TRUE if valid; FALSE if invalid
	*/
	public function validate_detail( $detail, $idx = FALSE ){
		global $Validate;
		if ( !$detail->id_product > 0 || !$Validate->exists( 'product', 'id_product', $detail->id_product )){
			$this->set_error( 'Invalid Product. ' . ( $idx !== FALSE ? "detail  line " . $idx . "." : "" ) , ERR_VAL_EMPTY );
			return FALSE;
		} 
		if ( !$detail->id_product_presentation > 0 || !$Validate->exists( 'product_presentation', 'id_product_presentation', $detail->id_product_presentation)){
			$this->set_error( 'Invalid Prodct Presentation. ' . ( $idx !== FALSE ? "detail  line " . $idx . "." : "" ) , ERR_VAL_INVALID );
			return FALSE;
		}  
		
		if ( ! $detail->quantity > 0 ){
			$this->set_error( 'Invalid Quantitiy. ' . ( $idx !== FALSE ? "detail  line " . $idx . "." : "" ) , ERR_VAL_INVALID );
			return FALSE;
		} 
		if ( ! $detail->price > 0 ){
			$this->set_error( 'Invalid Price. ' . ( $idx !== FALSE ? "detail  line " . $idx . "." : "" ) , ERR_VAL_INVALID );
			return FALSE;
		} 
		return TRUE;
	}
	 
	/**
	* validate()    
	* Validates the values before inputing to Data Base 
	*  
	* @return	Boolean TRUE if valid; FALSE if invalid
	*/ 
	public function validate(){ 
		global $Validate; 
		if ( !$this->id_pdv > 0 || !$Validate->exists( 'pdv', 'id_pdv', $this->id_pdv )){
			$this->set_error( 'Invalid PDV. ', ERR_VAL_EMPTY );
			return FALSE;
		} 
		if ( !$this->id_user > 0 || !$Validate->exists( 'user', 'id_user', $this->id_user)){
			$this->set_error( 'Invalid User. ', ERR_VAL_INVALID );
			return FALSE;
		}   
		if ( $this->id_visit > 0 ){
			if ( !$Validate->exists( 'visit', 'id_visit', $this->id_visit)){
				$this->set_error( 'Invalid Visit. ', ERR_VAL_INVALID );
				return FALSE;
			} 
		}
		
		if ( ! $this->date > 0 ){
			$this->set_error( 'Invalid Date. ', ERR_VAL_INVALID );
			return FALSE;
		} 

		if ( !(count( $this->detail ) > 0) ){
			$this->set_error( 'Empty details. ', ERR_VAL_EMPTY );
			return FALSE; 
		}  
		foreach ($this->detail as $k => $detail ) {
			if ( !$this->validate_detail($detail, $k) ){
				return FALSE;
			}
		}
		
		return TRUE;
	}
	
	/**
	* delete()    
	* Changes status for Order to 0 in the DB.
	*
	* @return 	TRUE on success; FALSE otherwise 
	*/  
	public function delete(){
		global $Session;
		if ( $Session->is_admin() ){
			global $obj_bd;
			$query = " UPDATE "  . PFX_MAIN_DB . "order SET or_status = 0 WHERE id_order = :id_order ";
			$result = $obj_bd->execute( $query, array( ':id_order' => $this->id_order ) );
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