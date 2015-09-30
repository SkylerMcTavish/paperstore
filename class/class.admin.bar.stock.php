<?php

if (!class_exists('BarStock')){
	require_once 'class.bar.stock.php';
}

/**
* AdminBarStock CLass
* 
* @package		SF·Tracker 			
* @since        11/23/2014 
* 
*/ 
class AdminBarStock extends BarStock {
	 
	/**
	* __construct()    
	* Creates a User object from the DB.
	*  
	* @param	$id_pdv (optional) If set populates values from DB record. 
	* 
	*/  
	function __construct( $id_stock ){
		global $Session;  
		$this->class = 'AdminBarStock';  
		if ( !$Session->is_admin() ){
			$this->set_error('Restricted Access', SES_RESTRICTED_ACCESS, 3);
			throw new Exception("Restricted access.", 1); 
		}
		parent::__construct( $id_stock );
		$this->class = 'AdminBarStock';  
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
							':quantity' 	 => $this->quantity,  
							':price'  		 => $this->sell_price,  
							':min'			 => $this->min,  
							':timestamp' 	 => time(),
							':id_packing'	 => $this->id_product_packing,
							':buy_price'	 => $this->buy_price
						);
				if ( $this->id_stock > 0 )
				{ 
					$values[':id_stock'] = $this->id_stock;
					$query = " UPDATE " . PFX_MAIN_DB . "bar_stock SET "  
								. " bs_pd_id_product	= :id_product, "
								. " bs_unity_quantity	= :quantity, "
								. " bs_sell_price		= :price, "
								. " bs_min				= :min, "
								. " bs_status	 		= 1, "
								. " bs_timestamp 		= :timestamp, "
								. " bs_pp_id_product_packing 		= :id_packing, "
								. " bs_buy_price 		= :buy_price "
							. " WHERE id_bar_stock 	= :id_stock ";
				}
				else
				{ 
					$query =	" INSERT INTO ".PFX_MAIN_DB."bar_stock (bs_pd_id_product, bs_unity_quantity, bs_sell_price, bs_min, bs_status, bs_timestamp, bs_pp_id_product_packing, bs_buy_price) ".
								" VALUES (:id_product, :quantity, :price, :min, 1, :timestamp, :id_packing, :buy_price) ";
				}  
				$result = $obj_bd->execute( $query, $values );
				if ( $result !== FALSE )
				{ 
					if ( $this->id_stock == 0)
					{
						$this->id_stock = $obj_bd->get_last_id();
					}
					$this->set_msg('SAVE', " Bar Stock " . $this->id_stock. " saved. ");
					
					return TRUE;
				}
				else
				{ 
					$this->set_error( "An error ocurred while trying to save the record. ".print_r($obj_bd->error, TRUE)  , ERR_DB_EXEC, 3 );
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
		if ( !is_numeric($this->sell_price) || !( $this->sell_price > 0 ) ){ 
			$this->set_error( 'Invalid Sell Price value. ['.$this->sell_price.']', ERR_VAL_INVALID );
			return FALSE;
		} 
		if ( !is_numeric($this->quantity) ){ 
			$this->set_error( 'Invalid Quantity value. ['.$this->quantity.']', ERR_VAL_INVALID );
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
	
	public function sell_product($quantity = 0)
	{
		if($this->id_stock > 0 AND $quantity > 0)
		{
			global $obj_bd;
			$query = 	" UPDATE ".PFX_MAIN_DB."bar_stock SET ".
						" bs_unity_quantity		= :quantity ".
						" WHERE id_bar_stock = :id_stock ";
			$values = array(
				":quantity"		=> ( $this->quantity - $quantity ),
				":id_stock"		=> $this->id_stock
			);
			$resp = $obj_bd->execute($query, $values);
			if($resp !== FALSE )
			{
				$this->set_msg('Se actualizo el inventario ['.$this->id_stock.'] con exito ['.$this->quantity.'] :: ['.($this->quantity - $quantity).']');
				return TRUE;
			}
			else
			{
				$this->set_error('Ocurrio un error al actualizar el inventario de mostrador ['.$this->id_stock.'].', ERR_DB_EXEC);
				return FALSE;
			}
		}
		else
		{
			$this->set_error('Valores invalidos.', ERR_DB_EXEC);
			return FALSE;
		}
	}
}

?>