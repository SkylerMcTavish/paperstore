<?php
if ( !class_exists( "Loader" ) ){
	require_once DIRECTORY_CLASS . "class.loader.php";
}

/**
 * class InvoiceLoader
 */
class InvoiceLoader extends Loader {
	
	private $Invoice;
	private $pdvs;
	public $error = array();
	
	function __construct( )
	{ 
		if ( !class_exists( "AdminInvoice" ) )
		{
			require_once DIRECTORY_CLASS . "class.admin.invoice.php";
		}
		$this->class 	 = "InvoiceLoader";
		$this->line 	 = 0;
		$this->processed = 0;
		$this->saved 	 = 0;
		$this->pdvs	 	 = array();
		$this->Invoice 	 = new AdminInvoice(0);
		$this->error	 = array();
	}
	
	public function load_uploaded_file( $file )
	{
		if ( !class_exists( "FileManager" ) )
		{
			require_once DIRECTORY_CLASS . "class.file.manager.php";
		}
		$fm = new FileManager();
		$response = $fm->save_uploaded( $file, DIRECTORY_UPLOADS . "invoice_tmpl_" . date( 'YmdHis' ) , 7 );
		if ( $response !== FALSE )
		{
			return $this->process_file( $response->location ); 
		}
		else
		{
			$this->error[] = $fm->error[ count($fmanager->error) - 1 ];
			return FALSE;
		}
	}
	
	private function process_file( $route )
	{ 
		if ( $this->open_file( $route ) )
		{  
			$line = 0;
			try
			{
				while (($row = fgetcsv($this->handle, 1000, ",")) !== FALSE)
				{
					if ($row[0] != '' && trim($row[0]) != 'FOLIO' && trim($row[0]) != '' )
					{
						if ( $this->line > 0 )
						{
							$resp = $this->process_line($row);
							$this->processed++;
							if ( $resp )
								$this->saved++;
						} 
					}
					$this->line++;
				}  
				$this->close_file();
			}
			catch ( Exception $e )
			{
				$this->set_error("An error occurred while processing the file (Line " . $line . " ). ", ERR_VAL_INVALID);
				return FALSE;
			}
		}
		else
		{
			$this->set_error("An error occurred while trying to open the file. ", ERR_VAL_INVALID);
			return FALSE;
		}
		return TRUE;
	}
	
	private function process_line( $line )
	{ 
		if ( is_array( $line ) && count( $line ) > 3 )
		{ 
			$folio 			= trim( $line[0] );
			$pdv 			= trim( $line[1] );
			$invoice_date 	= trim( $line[2] );
			$total 			= trim( $line[3] );
			
			$id_pdv  = $this->get_pdv_id( $pdv );
			if ( !$id_pdv )
			{
				$this->set_error("Invalid PDV ( '$pdv' ) on line " . $this->line . ". ", ERR_VAL_INVALID );
				return FALSE;
			}
			if ( !is_numeric($folio) )
			{
				$this->set_error("Invalid Folio ( '$folio' ) on line " . $this->line . ". ", ERR_VAL_INVALID );
				return FALSE;
			}
			if ( !is_numeric($total) )
			{
				$this->set_error("Invalid Total quantity ( '$total' ) on line " . $this->line . ". ", ERR_VAL_INVALID );
				return FALSE;
			}
			
			$date = $this->get_timestamp( $invoice_date );
			
			$this->Invoice->clean();
			$this->Invoice->id_pdv	= $id_pdv;
			$this->Invoice->date	= $date;
			$this->Invoice->folio	= $folio;
			$this->Invoice->total	= $total;
			$this->Invoice->status	= 1; //por pagar
			
			$resp = $this->Invoice->save();
			if ( $resp !== FALSE )
			{
				$this->set_msg( "LOAD", "Invoice " . $this->Invoice->id_invoice . " created successfully. ");
				return TRUE;
			}
			else
			{
				$this->set_error("Error while trying to save the record on line " . $this->line . ". ", ERR_VAL_INVALID );
				return FALSE;
			}
			
		}
		else
		{
			$this->set_error("Invalid line data (Line " . $this->line . "). ", ERR_VAL_INVALID );
			return FALSE;
		} 
	}
	
	private function get_pdv_id( $pdv = '' )
	{ 
		global $Validate;
		if ( $pdv != '' )
		{
			if ( array_key_exists( $pdv , $this->pdvs ) )
			{
				return $this->pdvs[ $pdv ];
			}
			else
			{
				global $obj_bd;
				$query = " SELECT id_pdv FROM " . PFX_MAIN_DB . "pdv WHERE pdv_jde = :pdv ";
				$result = $obj_bd->query($query, array( ':pdv' => $pdv ) ); 
				if ( $result !== FALSE )
				{ 
					if ( count( $result ) > 0 )
					{
						$id_pdv = $result[0]['id_pdv'];
						if ( $Validate->is_integer( $id_pdv ) && $id_pdv > 0 )
						{
							$this->pdvs[ $pdv ] = $id_pdv;
							return $id_pdv;
						}
						else
							return FALSE;
					}
				}
				else
				{
					$this->set_error("Database error while querying for pdv '" . $pdv . "'. ", ERR_VAL_INVALID );
					return FALSE;
				}
			}
		}
		else
		{
			$this->set_error("Invalid User ( '$pdv' ) on line " . $this->line . ". ", ERR_VAL_INVALID );
			return FALSE;
		}
	}

	private function get_timestamp( $date )
	{
		// >> 15/01/2015
		try
		{
			list( $d, $m, $Y ) 	= explode("/", $date );
			return mktime( 0, 0, 0, $m, $d, $Y );
		}
		catch ( Exception $e )
		{
			$this->set_error("Invalid date parameters ( $date )", ERR_VAL_INVALID);
			return FALSE;
		} 
		
	}

}
?>