<?php
/**
* Payment CLass
* 
* @package		Ragasa 			
* @since        1/27/2015
* @author		ignacio.cerda
* 
*/

class Payment extends Object {
	
	public $id_payment;
	public $id_pdv;
	public $pdv;
	public $id_user;
	public $user;
	public $date;
	public $date_payment;
	public $id_invoice;
	public $invoice;
	public $id_payment_method;
	public $payment_method;
	public $total;
	
	
	public $timestamp; 
	public $error = array();
	
	
	function __construct( $id_payment = 0 )
	{
		global $obj_bd;
		$this->class = 'Payment';
		$this->error = array();
		$this->clean();
		
		if ( $id_payment > 0 )
		{
			$query = 	" SELECT id_payment, id_pdv, pdv_name, id_user, us_user, py_date_payment, py_date, py_in_id_invoice, in_folio, ".
						" id_payment_method, pm_payment_method, py_total, py_timestamp ".
						" FROM " . PFX_MAIN_DB . "payment ".
						" INNER JOIN " . PFX_MAIN_DB . "pdv ON id_pdv = py_pdv_id_pdv ".
						" INNER JOIN " . PFX_MAIN_DB . "user ON id_user = py_us_id_user ".
						" INNER JOIN " . PFX_MAIN_DB . "payment_method ON id_payment_method = py_pm_id_payment_method ".
						" LEFT JOIN " . PFX_MAIN_DB . "invoice ON id_invoice = py_in_id_invoice ".
						" WHERE id_payment = :id_payment ";
					
			$info = $obj_bd->query( $query, array( ':id_payment' => $id_payment ) );
			
			if ( $info !== FALSE )
			{
				if ( count($info) > 0 )
				{ 
					$pv = $info[0];
					$this->id_payment 			= $pv['id_payment'];
					$this->id_pdv	 			= $pv['id_pdv'];
					$this->pdv		 			= $pv['pdv_name'];
					$this->id_user	 			= $pv['id_user'];
					$this->user 				= $pv['us_user'];
					$this->date 				= $pv['py_date'];
					$this->date_payment 		= $pv['py_date_payment'];
					$this->id_invoice 			= $pv['py_in_id_invoice'];
					//$this->invoice 				= $pv['in_folio'];
					$this->id_payment_method	= $pv['id_payment_method'];
					$this->payment_method 		= $pv['pm_payment_method'];
					$this->total 				= $pv['py_total'];
					
					$this->timestamp 			= $pv['py_timestamp'];
					
					$this->set_invoice();
						
				}
				else
				{
					$this->set_error( "Payment not found (" . $id_payment . "). ", ERR_DB_NOT_FOUND, 2 ); 
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
		$payment = $this;
		ob_start();
		require_once DIRECTORY_VIEWS . "payment/info.payment.php"; 
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
	
	private function get_array()
	{
		$data = array();
		
		$data['id_payment'] 		= $this->id_payment;
		$data['id_pdv'] 			= $this->id_pdv;
		$data['id_user'] 			= $this->id_user;
		$data['date'] 				= $this->date;
		$data['date_payment'] 		= $this->date_payment;
		$data['id_invoice'] 		= $this->id_invoice;
		$data['id_payment_method'] 	= $this->id_payment_method;
		$data['total'] 				= $this->total;
		$data['invoice_date'] 		= $this->invoice->date;
		$data['invoice_folio']		= $this->invoice->folio;
		$data['invoice_total'] 		= $this->invoice->total;
		
		return $data;
	}
}	

?>