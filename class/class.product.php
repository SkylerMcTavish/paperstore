<?php
/**
* Product CLass
* 
* @package		SF·Tracker	
* @since        11/19/2014 
* 
*/ 
class Product extends Object {
	
	public $id_product; 
	public $product;
	public $alias;
	public $sku;
	public $description; 
	public $id_brand;
	public $brand; 
	public $id_supplier;
	public $supplier;
	public $id_category;
	public $category;
    
	public $bar_stock;
	public $storehouse;
	
	public $meta  = array();
	
	 
	public $timestamp; 
	
	/**
	* Product()    
	* Creates a User object from the DB.
	*  
	* @param	$id_product (optional) If set populates values from DB record. 
	* 
	*/  
	function __construct( $id_product = 0 ){
		global $obj_bd;
		$this->class = 'Product';
		$this->error = array();
		$this->clean();
		if ( $id_product > 0 )
		{
			$query = 	" SELECT id_product, pd_product, pd_alias, pd_description, pd_sku, id_brand, br_brand, ".
						" id_supplier, sp_supplier, id_product_category, pc_product_category, pd_timestamp ".
						" FROM ".PFX_MAIN_DB."product ".
						" INNER JOIN ".PFX_MAIN_DB."brand ON id_brand = pd_br_id_brand ".
						" INNER JOIN ".PFX_MAIN_DB."supplier ON id_supplier = pd_sp_id_supplier ".
						" INNER JOIN ".PFX_MAIN_DB."product_category ON id_product_category = pd_pc_id_product_category ".
						" WHERE id_product = :id_product ";
			$info = $obj_bd->query( $query, array( ':id_product' => $id_product ) );
			
			if ( $info !== FALSE )
			{
				if ( count($info) > 0 )
				{ 
					$pv = $info[0];
					$this->id_product 	= $pv['id_product'];
					$this->product		= $pv['pd_product'];
					$this->alias		= $pv['pd_alias'];
					$this->description	= $pv['pd_description'];
					$this->sku			= $pv['pd_sku'];
					
					$this->id_brand		= $pv['id_brand'];
					$this->brand		= $pv['br_brand'];
					
					$this->id_supplier	= $pv['id_supplier'];
					$this->supplier		= $pv['sp_supplier'];
					
					$this->id_category	= $pv['id_product_category'];
					$this->category		= $pv['pc_product_category'];
					
					$this->timestamp	= $pv['pd_timestamp'];
					
					$this->set_bar_stock();
					$this->set_warehouse_stock();
					
				}
				else
				{
					$this->clean();
					$this->set_error( "Product not found (" . $id_product . "). ", ERR_DB_NOT_FOUND, 2 ); 
				}
			}
			else
			{ 
				$this->clean();
				$this->set_error( "An error ocurred while querying the Data Base. ", ERR_DB_QRY, 2 );
			} 
		}   
	} 
	
	/**
	 * set_meta()
	 * Sets the product meta options and values
	 * 
	 */
	protected function set_meta(){ 
		if ( !class_exists( 'ProductMeta' ) ) 
	  		require_once 'class.product_meta.php';
		$this->meta = new ProductMeta( $this->id_product );
	} 
 
	/**
	 * get_array()
	 * returns an Array with product infamilyion
	 * 
	 * @param 	$full Boolean if TRUE returns Product and Instance Arrays (default FALSE)
	 * 
	 * @return	$array Array width User infamilyion
	 */
	 public function get_array( ){
		
		return array(
	 					'id_product'	=> $this->id_product,
						'product'		=> $this->product,
						'alias'			=> $this->alias,
						'description'	=> $this->description,
						'sku'			=> $this->sku,
						'id_brand'		=> $this->id_brand,
						'brand'			=> $this->brand,
						'id_supplier'	=> $this->id_supplier,
						'supplier'		=> $this->supplier,
						'id_category'	=> $this->id_category,
						'category'		=> $this->category,
						'timestamp'		=> $this->timestamp
					);
	 }
	
	/**
	* clean()    
	* Cleans all parameters and resets all objects
	*  
	*/  
	public function clean()
	{
		$this->id_product 	= 0;
		$this->product		= '';
		$this->alias		= '';
		$this->description	= '';
		$this->sku			= '';
		
		$this->id_brand		= 0;
		$this->brand		= '';
		
		$this->id_supplier	= 0;
		$this->supplier		= '';
		
		$this->id_category	= 0;
		$this->category		= '';
					
		$this->timestamp	= 0;
		$this->error 		= array(); 
	}
	
	private function set_bar_stock()
	{
		global $obj_bd;
		$query = 	" SELECT id_bar_stock, bs_unity_quantity, bs_sell_price ".
					" FROM ".PFX_MAIN_DB."bar_stock ".
					" WHERE bs_pd_id_product = :id_product ";
		$info = $obj_bd->query( $query, array( ':id_product' => $id_product ) );
			
		if ( $info !== FALSE )
		{
			if ( count($info) > 0 )
			{ 
				$stock = $info[0];
				$this->bar_stock['id_bar_stock']	= $stock['id_bar_stock'];
				$this->bar_stock['quantity']		= $stock['bs_unity_quantity'];
				$this->bar_stock['price'] 			= $stock['bs_sell_price'];
			}
			else
			{
				//$this->set_error( "Product not found (" . $id_product . "). ", ERR_DB_NOT_FOUND, 2 ); 
			}
		}
		else
		{ 
			$this->set_error( "An error ocurred while querying the Data Base. ", ERR_DB_QRY, 2 );
		} 
	}
	
	private function set_warehouse_stock()
	{
		global $obj_bd;
		$query = 	" SELECT id_storehouse_stock, pp_product_packing, pp_unity_quantity, ss_quantity ".
					" FROM ".PFX_MAIN_DB."storehouse_stock ".
					" INNER JOIN ".PFX_MAIN_DB."product_packing ON id_product_packing = ss_pp_id_product_packing ".
					" WHERE ss_pd_id_product = :id_product ";
		$info = $obj_bd->query( $query, array( ':id_product' => $id_product ) );
			
		if ( $info !== FALSE )
		{
			if ( count($info) > 0 )
			{ 
				$stock = $info[0];
				$this->storehouse['id_storehouse']	= $stock['id_storehouse_stock'];
				$this->storehouse['pack']			= $stock['pp_product_packing'];
				$this->storehouse['unity_pack'] 	= $stock['pp_unity_quantity'];
				$this->storehouse['quantity'] 		= $stock['ss_quantity'];
			}
			else
			{
				//$this->set_error( "Product not found (" . $id_product . "). ", ERR_DB_NOT_FOUND, 2 ); 
			}
		}
		else
		{ 
			$this->set_error( "An error ocurred while querying the Data Base. ", ERR_DB_QRY, 2 );
		} 
	}
	
	public function get_sale_info()
	{
		if($this->id_product > 0)
		{
			global $obj_bd;
			$query = 	" SELECT id_bar_stock, bs_pd_id_product, bs_unity_quantity, bs_sell_price ".
						" FROM ".PFX_MAIN_DB."bar_stock ".
						" WHERE bs_pd_id_product = :id_product ";
			$resp = $obj_bd->query($query, array(":id_product" => $this->id_product) );
			if($resp !== FALSE)
			{
				if(count($resp) > 0)
				{
					$info = $resp[0];
					$sell = array(
						"id_stock"		=> $info['id_bar_stock'],
						"id_product"	=> $this->id_product,
						"product"		=> $this->product,
						"price"			=> '$ '.number_format($info['bs_sell_price'], 2 ),
						"max"			=> $info['bs_unity_quantity']
					);
					
					return $sell;
				}
				else
				{
					$this->set_error("No se encontro el producto en mostrador.".$query.$this->id_product,ERR_DB_QRY);
					return array();
				}
			}
			else
			{
				$this->set_error("Ocurrio un error en la base de datos.",ERR_DB_QRY);
				return array();
			}
		}
		else
		{
			$this->set_error("No se encontro el producto.",ERR_DB_QRY);
			return array();
		}
	}
	
	public function get_info_html()
	{
		$html = "";
		$product = $this;
		ob_start();
		require_once DIRECTORY_VIEWS . "product/info.product.php";
		$html = ob_get_contents();
		ob_end_clean();
		
		return str_replace(array("\n", "\t"), "", $html);
	 
	}
}

?>