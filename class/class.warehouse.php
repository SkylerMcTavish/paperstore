<?php
/**
* BarStock CLass
* 
* @package		SF·Tracker 			
* @since        11/19/2014 
* 
*/ 
class Warehouse extends Object {
	
	public $id_stock;
	public $id_product;
	public $product;
	public $quantity;
	
	public $id_packing;
	public $packing;
	public $packing_unity;
	
	public $total_unity;
	
	public $min;
	public $max;
	
	public $buy_price;
	
	public $timestamp;
	
	
	function __construct( $id_stock = 0 )
	{
		global $obj_bd;
		$this->class = 'Warehouse';
		$this->error = array();
		$this->clean();
		if ( $id_stock > 0 )
		{
			$query =	" SELECT id_storehouse_stock, id_product, pd_product, id_product_packing, pp_product_packing, pp_unity_quantity, ss_quantity, ".
						" 	(pp_unity_quantity * ss_quantity) AS ss_total, ss_min, ss_max, ss_timestamp, ss_buy_price ".
						" FROM ".PFX_MAIN_DB."storehouse_stock ".
						" INNER JOIN ".PFX_MAIN_DB."product ON id_product = ss_pd_id_product ".
						" INNER JOIN ".PFX_MAIN_DB."product_packing ON id_product_packing = ss_pp_id_product_packing ".
						" WHERE id_storehouse_stock = :id_stock ";
			$info = $obj_bd->query( $query, array( ':id_stock' => $id_stock ) );
			if ( $info !== FALSE )
			{
				if ( count($info) > 0 )
				{ 
					$pv = $info[0];
					$this->id_stock 		= $pv['id_storehouse_stock'];  
					$this->id_product 		= $pv['id_product'];
					$this->product			= $pv['pd_product'];
					
					$this->id_packing		= $pv['id_product_packing'];
					$this->packing			= $pv['pp_product_packing'];
					$this->packing_unity	= $pv['pp_unity_quantity'];
					
					$this->quantity			= $pv['ss_quantity'];
					$this->total_unity		= $pv['ss_total']; 
					
					$this->min				= $pv['ss_min'];
					$this->max				= $pv['ss_max']; 
					
					$this->buy_price		= $pv['ss_buy_price'];
					
					$this->timestamp		= $pv['ss_timestamp'];
					
				}
				else
				{
					$this->set_error( "Storehouse Stock not found (" . $id_stock . "). ", ERR_DB_NOT_FOUND, 2 ); 
				}
			}
			else
			{ 
				$this->set_error( "An error ocurred while querying the Data Base. ", ERR_DB_QRY, 2 );
			} 
		}   
	} 
	
	/**
	 * get_array()
	 * returns an Array with pdv information
	 * 
	 * @param 	$full Boolean if TRUE returns PDV and Instance Arrays (default FALSE)
	 * 
	 * @return	$array Array width User information
	 */
	 public function get_array()
	 {
	 	$array = array(
	 					'id_stock'		=> $this->id_stock,
						'id_product'	=> $this->id_product,
						'product'		=> $this->product,
						'quantity'		=> $this->quantity,
						'id_packing'	=> $this->id_packing,
						'packing'		=> $this->packing,
						'packing_unity'	=> $this->packing_unity,
						'total_unity'	=> $this->total_unity,
						'min'			=> $this->min,
						'max'			=> $this->max,
						'timestamp'		=> $this->timestamp
					);
		return $array;
	 }
	
	/**
	 * get_info_html()
	 * returns a String of HTML with user information
	 * 
	 * @param 	$full Boolean if TRUE returns Contact and Instance Arrays (default FALSE)
	 * 
	 * @return	$html String html user info template
	 */
	 public function get_info_html(){
	 	$html  = "";
		$pdv = $this;
		ob_start();
		require_once DIRECTORY_VIEWS . "stock/info.warehouse.php"; 
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
		$this->id_stock 		= 0;  
		$this->id_product 		= 0;
		$this->product			= '';
		
		$this->id_packing		= 0;
		$this->packing			= '';
		$this->packing_unity	= 0;
		
		$this->quantity			= 0;
		$this->total_unity		= 0; 
		
		$this->min				= 0;
		$this->max				= 0; 
		
		$this->timestamp		= 0;	
	}
	 
}

?>