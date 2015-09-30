<?php
/**
* Invoice CLass
* 
* @package		Ragasa			
* @since        1/28/2015
* @author		ignacio.cerda
* 
*/ 
class Invoice extends Object {
	
	public $id_invoice;
	public $date;
	public $id_pdv;
	public $pdv;
	public $folio;
	public $total;
	public $status;
	
	public $error = array(); 
	
	/**
	* Invoice()    
	* Creates an Invoice object from the DB.
	*  
	* @param	$id_invoice (optional) If set populates values from DB record. 
	* 
	*/ 
	function __construct( $id_invoice = 0 )
	{
		global $obj_bd;
		$this->class = 'Invoice';
		$this->error = array();
		$this->clean();
		if ( $id_invoice > 0 )
		{
			$query = 	" SELECT id_invoice, in_date, id_pdv, in_folio, in_total, in_status ".
						" FROM rg_invoice ".
						" INNER JOIN rg_pdv ON id_pdv = in_pdv_id_pdv ".
						" WHERE id_invoice = :id_invoice "; 
			$info = $obj_bd->query( $query, array( ':id_invoice' => $id_invoice ) );
			if ( $info !== FALSE )
			{
				if ( count($info) > 0 )
				{ 
					$in = $info[0];
					$this->id_invoice	= $in['id_invoice'];
					$this->date		 	= $in['in_date'];
					$this->folio 		= $in['in_folio'];
					$this->total 		= $in['in_total'];
					$this->status	 	= $in['in_status'];
					
					$this->set_pdv($in['id_pdv']);
				}
				else
				{
					$this->set_error( "Invoice not found (" . $id_invoice . "). ", ERR_DB_NOT_FOUND, 2 ); 
				}
			}
			else
			{ 
				$this->set_error( "An error ocurred while querying the Data Base for Invoice (" . $id_visit . ") information. ", ERR_DB_QRY, 2 );
			} 
		}   
	}
	
	private function set_pdv( $id_pdv = 0 )
	{
		if ( !class_exists( 'PDV' ) ) 
		 		require_once 'class.pdv.php';
		 $this->pdv = new PDV( $id_pdv ); 
	}
	/**
	 * get_array()
	 * returns an Array with visit information
	 *   
	 * @return	$array Array width Visit information
	 */
	 public function get_array()
	 {
	 	$array = array(
	 					'id_invoice'	=>	$this->id_invoice,  
	 					'date' 			=>	$this->date > 0 ? str_replace(" ", "T", date( 'Y-m-d H:i', $this->date)) : "",
						'folio'			=>	$this->folio,
						'total' 		=>	$this->total,
						'pdv'			=>  $this->pdv->get_array(),
					);	
		return $array;
	 }
	
         public function get_info_html()
	{
		$html  = "";
		$invoice = $this;
		ob_start();
		require_once DIRECTORY_VIEWS . "invoice/info.invoice.php"; 
		$html .= ob_get_contents();
		ob_end_clean(); 
		return str_replace(array("\n", "\t"), "", $html);
	}
        
	/**
	* clean()    
	* Cleans all parameters and resets all objects
	*  
	*/  
	public function clean()
	{
		$this->id_invoice	= 0;
		$this->date		 	= 0;
		$this->folio 		= "";
		$this->total 		= "";
		$this->status	 	= "";
		$this->set_pdv();
		$this->error = array();
	}
}

?>