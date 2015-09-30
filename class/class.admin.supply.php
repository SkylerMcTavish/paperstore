<?php

if (!class_exists('Supply')){
	require_once 'class.supply.php';
}

/**
* AdminSupply CLass
* 
* @package		SF·Tracker 			
* @since        11/23/2014 
* 
*/ 
class AdminSupply extends Supply {
	 
	/**
	* __construct()    
	* Creates a User object from the DB.
	*  
	* @param	$id_pdv (optional) If set populates values from DB record. 
	* 
	*/  
	function __construct( $id_stock ){
		global $Session;  
		$this->class = 'AdminSupply';  
		if ( !$Session->is_admin() ){
			$this->set_error('Restricted Access', SES_RESTRICTED_ACCESS, 3);
			throw new Exception("Restricted access.", 1); 
		}
		parent::__construct( $id_stock );
		$this->class = 'AdminSupply';  
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
							':id_bar_stock'  => $this->id_bar_stock,  
							':current'		 => $this->current,  
							':supplied'		 => $this->supplied,
							':timestamp' 	 => time()
						);
				if ( $this->id_supply > 0 )
				{ 
					$values[':id_supply'] = $this->id_supply;
					$query = " UPDATE " . PFX_MAIN_DB . "supply SET "  
								. " sp_bs_id_bar_stock	= :id_bar_stock, "
								. " sp_pd_id_product	= :id_product, "
								. " sp_current			= :current, "
								. " sp_supplied			= :supplied, "
								. " sp_status	 		= 1, "
								. " sp_timestamp 		= :timestamp "								
							. " WHERE id_supply		 	= :id_supply ";
				}
				else
				{ 
					$query =	" INSERT INTO ".PFX_MAIN_DB."supply (sp_pd_id_product, sp_bs_id_bar_stock, sp_current, sp_supplied, sp_status, sp_timestamp ) ".
								" VALUES (:id_product, :id_bar_stock, :current, :supplied, 1, :timestamp ) ";
				}  
				$result = $obj_bd->execute( $query, $values );
				if ( $result !== FALSE )
				{ 
					if ( $this->id_stock == 0)
					{
						$this->id_stock = $obj_bd->get_last_id();
					}
					$this->set_msg('SAVE', " Supply " . $this->id_stock. " saved. ");
					
					return TRUE;
				}
				else
				{ 
					$this->set_error( "An error ocurred while trying to save the record. ".print_r($values, TRUE)  , ERR_DB_EXEC, 3 );
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
		if ( !is_numeric($this->id_bar_stock) || !( $this->id_bar_stock > 0 ) ){ 
			$this->set_error( 'Invalid ID Stock value. ['.$this->id_bar_stock.']', ERR_VAL_INVALID );
			return FALSE;
		}	
		return TRUE; 
	}
	
}

?>