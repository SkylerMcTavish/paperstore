<?php 
if (!class_exists('Invoice')){
	require_once 'class.invoice.php';
}
/**
* AdminInvoice CLass
* 
* @package		Ragasa	
* @since        1/27/2015
* @author		ignacio.cerda
*/ 
class AdminInvoice extends Invoice{
	 
	function __construct( $id_invoice )
	{
		global $Session;
		$this->class = 'AdminInvoice';
		if ( !$Session->is_admin() )
		{
			$this->set_error('Restricted Access', SES_RESTRICTED_ACCESS, 3);
			throw new Exception("Restricted access.", 1); 
		}
		parent::__construct( $id_invoice );
		$this->class = 'AdminInvoice';
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
				global $obj_bd; //in_date, in_pdv_id_pdv, in_folio, in_total, in_status
				$values = array(  
							':date'	 	=> $this->date,  
							':id_pdv'	=> $this->id_pdv, 
							':folio'	=> $this->folio, 
							':total'	=> $this->total,
							':status' 	=> $this->status,
							':timestamp'=> time()
						);
				$action = "SAVE";
				if ( $this->id_visit > 0 )
				{ 
					$action = "UPDATE";
					$values[':id_invoice'] 	= $this->id_invoice;
					
					$query = " UPDATE " . PFX_MAIN_DB . "invoice SET "  
								. " in_date			= :date , "
								. " in_pdv_id_pdv	= :id_pdv , "
								. " in_folio		= :folio , "
								. " in_total		= :total , "
								. " in_status		= :status, "
								. " in_timestamp	= :timestamp "
							. " WHERE id_invoice 	= :id_invoice ";
				}
				else
				{ 
					$action = "INSERT"; 
					$query = "INSERT INTO " . PFX_MAIN_DB . "invoice "
						. " (in_date, in_pdv_id_pdv, in_folio, in_total, in_status, in_timestamp ) "
						. " VALUES ( :date, :id_pdv, :folio, :total, :status, :timestamp)  "; 
				}  
				$result = $obj_bd->execute( $query, $values );
				
				if ( $result !== FALSE )
				{ 
					if ( $this->id_invoice == 0)//new record
					{ 
						$this->id_invoice = $obj_bd->get_last_id(); 
						$resp = TRUE;
					} 
					else
						$resp = TRUE;
					
					$this->set_msg( $action , " Invoice " . $this->id_invoice. " saved. ");
					return $resp;
				}
				else
				{ 
					$this->set_error( "An error ocurred while trying to save the record. ", ERR_DB_EXEC, 3 );
					return FALSE;
				} 
			}
			else
			{
				return FALSE;
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
	public function validate()
	{ 
		global $Validate; 
		if ( !$this->id_pdv > 0 || !$Validate->exists( 'pdv', 'id_pdv', $this->id_pdv ))
		{
			$this->set_error( 'Invalid PDV. ', ERR_VAL_EMPTY );
			return FALSE;
		}
		
		return TRUE;
	}
	
	/**
	* delete()    
	* Changes status for Visit to 0 in the DB.
	*
	* @return 	TRUE on success; FALSE otherwise 
	*/  
	public function delete()
	{
		global $Session;
		if ( $Session->is_admin() )
		{
			global $obj_bd;
			$query = " UPDATE "  . PFX_MAIN_DB . "visit SET vi_status = 0 WHERE id_visit = :id_visit ";
			$result = $obj_bd->execute( $query, array( ':id_visit' => $this->id_visit ) );
			if ( $result !== FALSE )
			{
				$this->clean();
				return TRUE;
			}
			else
			{
				$this->set_error( "An error ocurred while trying to set status to 0. ", ERR_DB_EXEC, 3 );
				return FALSE;
			} 
		}
	} 
}
?>