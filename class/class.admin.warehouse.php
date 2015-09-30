<?php

if (!class_exists('Warehouse')){
	require_once 'class.warehouse.php';
}

/**
* AdminWarehouse CLass
* 
* @package		SF·Tracker 			
* @since        11/23/2014 
* 
*/ 
class AdminWarehouse extends Warehouse {
	 
	/**
	* __construct()    
	* Creates a User object from the DB.
	*  
	* @param	$id_pdv (optional) If set populates values from DB record. 
	* 
	*/  
	function __construct( $id_stock ){
		global $Session;  
		$this->class = 'AdminWarehouse';  
		if ( !$Session->is_admin() ){
			$this->set_error('Restricted Access', SES_RESTRICTED_ACCESS, 3);
			throw new Exception("Restricted access.", 1); 
		}
		parent::__construct( $id_stock );
		$this->class = 'AdminWarehouse';  
	}
	
	/**
	* save()    
	* Inserts or Update the record in the DB. 
	* 
	*/  
	public function save()
	{
		global $Session;
		if ( $Session->is_admin() )
		{ 
			if ( $this->validate() )
			{ 
				global $obj_bd;
				
				$values = array( 
							':id_product' 	 => $this->id_product,
							':id_packing' 	 => $this->id_packing,  
							':quantity'  	 => $this->quantity,  
							':min'			 => $this->min,  
							':max'	 		 => $this->max,
							':price'		 => $this->buy_price,
							':timestamp' 	 => time()
						);
				if ( $this->id_stock > 0 )
				{ 
					$values[':id_stock'] = $this->id_stock;
					$query = " UPDATE " . PFX_MAIN_DB . "storehouse_stock SET "  
								. " ss_pd_id_product			= :id_product, "
								. " ss_pp_id_product_packing	= :id_packing, "
								. " ss_quantity					= :quantity, "
								. " ss_min						= :min, "
								. " ss_max						= :max, "
								. " ss_buy_price				= :price, "
								. " ss_status	 				= 1, "
								. " ss_timestamp 				= :timestamp "
							. " WHERE id_storehouse_stock 		= :id_stock ";
				}
				else
				{ 
					$query =	" INSERT INTO ".PFX_MAIN_DB."storehouse_stock (ss_pd_id_product, ss_pp_id_product_packing, ss_quantity, ss_min, ss_max, ss_status, ss_timestamp, ss_buy_price) ".
								" VALUES (:id_product, :id_packing, :quantity, :min, :max, 1, :timestamp, :price) ";
				}  
				$result = $obj_bd->execute( $query, $values );
				if ( $result !== FALSE )
				{ 
					if ( $this->id_stock == 0)
					{
						$this->id_stock = $obj_bd->get_last_id();
					}
					$this->set_msg('SAVE', " Warehouse Stock " . $this->id_stock. " saved. ");
					
					return TRUE;
				}
				else
				{ 
					$this->set_error( "An error ocurred while trying to save the record. "  , ERR_DB_EXEC, 3 );
					return FALSE;
				} 
			}
			
		}
		else
		{
			$this->set_error("Restricted action.", SES_RESTRICTED_ACTION);
			return FALSE;
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
		
		if ( !is_numeric($this->id_product) || !( $this->id_product > 0 ) ){ 
			$this->set_error( 'Invalid Product value. ', ERR_VAL_INVALID );
			return FALSE;
		}
		if ( !is_numeric($this->id_packing) || !( $this->id_packing > 0 ) ){ 
			$this->set_error( 'Invalid ID Packing value. ['.$this->sell_price.']', ERR_VAL_INVALID );
			return FALSE;
		} 
		if ( !is_numeric($this->quantity) ){ 
			$this->set_error( 'Invalid Quantity value. ', ERR_VAL_INVALID );
			return FALSE;
		}
		/*
		if ( !is_numeric($this->min) || !( $this->min > 0 ) ){ 
			$this->set_error( 'Invalid Min value. ', ERR_VAL_INVALID );
			return FALSE;
		}
		
		if ( !is_numeric($this->max) || !( $this->max > 0 ) ){ 
			$this->set_error( 'Invalid Max value. ', ERR_VAL_INVALID );
			return FALSE;
		}
		*/
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