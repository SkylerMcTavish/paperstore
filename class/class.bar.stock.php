<?php
/**
* BarStock CLass
* 
* @package		SF·Tracker 			
* @since        11/19/2014 
* 
*/ 
class BarStock extends Object {
	
	public $id_stock;
	public $id_product;
	public $product;
	public $quantity;
	public $sell_price;
	public $min;
	public $max;
	public $id_rack;
	public $rack;
	public $rack_location;
	public $id_supplier;
	public $supplier;
	public $id_product_packing;
	public $product_packing;
	public $buy_price;
	
	public $timestamp;
	
	
	function __construct( $id_stock = 0 )
	{
		global $obj_bd;		
		$this->class = 'BarStock';
		$this->error = array();		
		$this->clean();
		if ( $id_stock > 0 )
		{
			$query =	" SELECT id_bar_stock, id_product, pd_product, bs_unity_quantity, bs_sell_price, bs_min, bs_max, bs_timestamp, ".
						" id_product_packing, pp_product_packing, bs_buy_price  ".
						" FROM ".PFX_MAIN_DB."bar_stock ".
						" INNER JOIN ".PFX_MAIN_DB."product ON id_product = bs_pd_id_product ".
						//" LEFT JOIN ".PFX_MAIN_DB."rack_products ON rkp_pd_id_product = id_product ".
						//" LEFT JOIN ".PFX_MAIN_DB."rack ON rkp_rk_id_rack = id_rack ".
						" LEFT JOIN ".PFX_MAIN_DB."product_packing ON bs_pp_id_product_packing = id_product_packing ".
						" WHERE id_bar_stock = :id_stock ";			
			$info = $obj_bd->query( $query, array( ':id_stock' => $id_stock ) );			
			if ( $info !== FALSE )
			{
				if ( count($info) > 0 )
				{ 
					$pv = $info[0];
					$this->id_stock 			= $pv['id_bar_stock'];  
					$this->id_product 			= $pv['id_product'];
					$this->product				= $pv['pd_product']; 
					$this->quantity				= $pv['bs_unity_quantity']; 
					$this->sell_price			= $pv['bs_sell_price'];
					$this->min					= $pv['bs_min'];
					$this->max					= $pv['bs_max'];
					/*
					$this->id_rack				= $pv['id_rack'];
					$this->rack					= $pv['rk_name'];
					$this->rack_location		= $pv['rk_location'];
					*/
					$this->timestamp			= $pv['bs_timestamp'];
					
					$this->id_product_packing 	= $pv['id_product_packing'];
					$this->product_packing 		= $pv['pp_product_packing'];
					$this->buy_price 			= ($pv['bs_buy_price']);
					//$this->set_supplier();
					
				}
				else
				{
					$this->set_error( "Bar Stock not found (" . $id_stock . "). ", ERR_DB_NOT_FOUND, 2 ); 
				}
			}
			else
			{ 
				$this->set_error( "An error ocurred while querying the Data Base. ", ERR_DB_QRY, 2 );
			} 
		}   
	}
	
	private function validate_product($id_product)
	{
		global $Validate; 
		
		if ( !is_numeric($id_product) || !( $id_product > 0 ) ){ 
			$this->set_error( 'Invalid Product value to load. ', ERR_VAL_INVALID );
			return FALSE;
		}
		return TRUE;
	}
	
	public function load_stock_from_product($id_product = 0)
	{
		global $obj_bd;		
		$this->clean();
		if ( $this->validate_product($id_product) )
		{
			$query =	" SELECT id_bar_stock, id_product, pd_product, bs_unity_quantity, bs_sell_price, bs_min, bs_max, bs_timestamp, ".
						" id_product_packing, pp_product_packing, bs_buy_price  ".
						" FROM ".PFX_MAIN_DB."bar_stock ".
						" INNER JOIN ".PFX_MAIN_DB."product ON id_product = bs_pd_id_product ".
						//" LEFT JOIN ".PFX_MAIN_DB."rack_products ON rkp_pd_id_product = id_product ".
						//" LEFT JOIN ".PFX_MAIN_DB."rack ON rkp_rk_id_rack = id_rack ".
						" LEFT JOIN ".PFX_MAIN_DB."product_packing ON bs_pp_id_product_packing = id_product_packing ".
						" WHERE bs_pd_id_product = :id_product ";
			$info = $obj_bd->query( $query, array( ':id_product' => $id_product ) );
			if ( $info !== FALSE )
			{
				if ( count($info) > 0 )
				{ 
					$pv = $info[0];
					$this->id_stock 			= $pv['id_bar_stock'];  
					$this->id_product 			= $pv['id_product'];
					$this->product				= $pv['pd_product']; 
					$this->quantity				= $pv['bs_unity_quantity']; 
					$this->sell_price			= $pv['bs_sell_price'];
					$this->min					= $pv['bs_min'];
					$this->max					= $pv['bs_max'];
					/*
					$this->id_rack				= $pv['id_rack'];
					$this->rack					= $pv['rk_name'];
					$this->rack_location		= $pv['rk_location'];
					*/
					$this->timestamp			= $pv['bs_timestamp'];
					
					$this->id_product_packing 	= $pv['id_product_packing'];
					$this->product_packing 		= $pv['pp_product_packing'];
					$this->buy_price 			= $pv['bs_buy_price'];
					
				}
				else
				{
					$this->set_error( "Bar Stock not found for product (" . $id_product . "). ", ERR_DB_NOT_FOUND, 2 ); 
				}
			}
			else
			{ 
				$this->set_error( "An error ocurred while querying the Data Base. ", ERR_DB_QRY, 2 );
			} 
		} 
	}
	
	private function set_supplier()
	{
		if($this->id_stock > 0)
		{
			global $obj_bd;
			$query = 	" SELECT id_storehouse_stock ".
						" FROM ".PFX_MAIN_DB."storehouse_stock ".
						" WHERE ss_pd_id_product = :id_product ";
			
			$resp = $obj_bd->query($query, array(':id_product' => $this->id_product) );
			
			if($resp !== FALSE)
			{
				if(count($resp) > 0)
				{
					$info = $resp[0];
					$this->id_supplier = $info['id_storehouse_stock'];
					require_once DIRECTORY_CLASS . 'class.warehouse.php';
					$this->supplier = new Warehouse($this->id_supplier);
					
				}
				else
				{
					$this->set_error( "Invalid supplier.", ERR_DB_QRY, 2 );
				}
			}
			else
			{
				$this->set_error( "An error ocurred while querying the Data Base for supplier.", ERR_DB_QRY, 2 );
			}
		}
		else
		{
			$this->id_supplier = 0;
			$this->supplier = new stdClass();
			$this->supplier->total_unity = 0;
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
						'sell_price'	=> $this->sell_price,
						'min'			=> $this->min,
						'max'			=> $this->max,						
						'timestamp'		=> $this->timestamp,
						'id_pack'		=> $this->id_product_packing,
						'pack'			=> $this->product_packing,
						'buy_price'		=> $this->buy_price
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
		require_once DIRECTORY_VIEWS . "stock/info.bar.stock.php"; 
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
		$this->id_stock 			= 0;  
		$this->id_product 			= 0;
		$this->product				= ''; 
		$this->quantity				= 0; 
		$this->sell_price			= 0;
		$this->min					= 0;
		$this->max					= 0;
		
		$this->id_rack				= 0;
		$this->rack					= '';
		$this->rack_location		= '';
		
		$this->timestamp			= 0;
		
		$this->id_supplier 			= 0;
		
		$this->id_product_packing 	= 0;
		$this->product_packing 		= '';
		$this->buy_price 			= 0.0;
		
		/*
		require_once DIRECTORY_CLASS . 'class.warehouse.php';
		$this->supplier 		= new Warehouse(0);
		*/
	}
	 
}

?>