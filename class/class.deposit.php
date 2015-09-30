<?php
/**
* Deposit CLass
* 
* @package		Ragasa 			
* @since        1/27/2015
* @author		ignacio.cerda
* 
*/

class Deposit extends Object {
	
	public $id_deposit;
	public $id_user;
	public $user;
	public $folio;
	public $date;
	public $total;
	public $id_evidence;
	
	public $timestamp;
	public $error = array();
	
	
	function __construct( $id_deposit = 0 )
	{
		global $obj_bd;
		$this->class = 'Deposit';
		$this->error = array();
		$this->clean();
		
		if ( $id_deposit > 0 )
		{
			$query = 	" SELECT id_deposit, dp_us_id_user, us_user, dp_folio, dp_date, dp_total, dp_ev_id_evidence, dp_timestamp ".
						" FROM ". PFX_MAIN_DB ."deposit ".
						" INNER JOIN ". PFX_MAIN_DB ."user ON id_user = dp_us_id_user ".
						" INNER JOIN ". PFX_MAIN_DB ."evidence ON id_evidence = dp_ev_id_evidence ".
						" WHERE id_deposit = :id_deposit ";
					
			$info = $obj_bd->query( $query, array( ':id_deposit' => $id_deposit ) );
			
			if ( $info !== FALSE )
			{
				if ( count($info) > 0 )
				{ 
					$dp = $info[0];
					$this->id_deposit 		= $dp['id_deposit'];
					$this->id_user 			= $dp['dp_us_id_user'];
					$this->user 			= $dp['us_user'];
					$this->folio 			= $dp['dp_folio'];
					$this->date 			= $dp['dp_date'];
					$this->total 			= $dp['dp_total'];
					$this->id_evidence 		= $dp['dp_ev_id_evidence'];
					
					$this->timestamp 		= $dp['dp_timestamp'];
					
					$this->set_invoice();
						
				}
				else
				{
					$this->set_error( "Deposit not found (" . $id_payment . "). ", ERR_DB_NOT_FOUND, 2 ); 
				}
			}
			else
			{ 
				$this->set_error( "An error ocurred while querying the Data Base. ", ERR_DB_QRY, 2 );
			} 
		}   
	}
	
	public function get_info_html()
	{
		$html  = "";
		$deposit = $this;
		ob_start();
		require_once DIRECTORY_VIEWS . "deposit/info.deposit.php"; 
		$html .= ob_get_contents();
		ob_end_clean(); 
		return str_replace(array("\n", "\t"), "", $html);
	}
	
	public function clean()
	{
		$this->id_payment 			= 0;
		$this->id_pdv	 			= 0;
		$this->pdv		 			= '';
		$this->id_user	 			= 0;
		$this->user 				= '';
		$this->date 				= 0;
		$this->date_payment 		= 0;
		$this->id_invoice 			= 0;
		$this->invoice 				= '';
		$this->id_payment_method	= 0;
		$this->payment_method 		= '';
		$this->total 				= 0;
		$this->error = array();
		
		$this->invoice = new stdClass();
		$this->invoice->date 	= 0;
		$this->invoice->folio 	= '';
		$this->invoice->total 	= '';
	}
	
	private function set_invoice()
	{
		$this->invoice = new stdClass();
		$this->invoice->date 	= 0;
		$this->invoice->folio 	= '';
		$this->invoice->total 	= '';
		
		if($this->id_invoice > 0)
		{
			global $obj_bd;
			
			$query =	" SELECT in_date, in_folio, in_total ".
						" FROM " . PFX_MAIN_DB . "invoice ".
						" WHERE id_invoice = :id_invoice ";
			
			$info = $obj_bd->query( $query, array( ':id_invoice' => $this->id_invoice ) );
			
			if($info !== FALSE)
			{
				$inv = $info[0];	
				$this->invoice->date 	= $inv['in_date'];
				$this->invoice->folio 	= $inv['in_folio'];
				$this->invoice->total 	= $inv['in_total'];
			}
			
		}

	}
}	

?>