<?php
/**
* Supply CLass
* 
* @package		SkyPaper 			
* @since        29/09/2015 
* 
*/ 
class Supply extends Object {
	
	public $id_supply;
	public $id_bar_stock;
	public $bar_stock;
	public $id_product;
	public $product;
	public $current;
	public $supplied;
	
	public $timestamp;
	
	
	function __construct( $id_supply = 0 )
	{
		global $obj_bd;
		$this->class = 'Supply';
		$this->error = array();
		$this->clean();
		if ( $id_supply > 0 )
		{
			$query =	" SELECT id_supply, id_product, sp_bs_id_bar_stock, sp_current, sp_supplied, sp_timestamp ".
						" FROM ".PFX_MAIN_DB."supply ".
						" INNER JOIN ".PFX_MAIN_DB."product ON sp_pd_id_product = id_product ".
						" WHERE id_supply = :id_supply ";
			$info = $obj_bd->query( $query, array( ':id_supply' => $id_supply ) );
			if ( $info !== FALSE )
			{
				if ( count($info) > 0 )
				{ 
					$pv = $info[0];
					$this->id_supply 			= $pv['id_supply'];
					$this->id_bar_stock 		= $pv['sp_bs_id_bar_stock'];
					$this->id_product 			= $pv['id_product'];
					$this->current 				= $pv['sp_current'];
					$this->supplied 			= $pv['sp_supplied'];
					
					$this->timestamp 			= $pv['sp_timestamp'];  
					
					//$this->set_supplier();
					
				}
				else
				{
					$this->set_error( "Supply not found (" . $id_supply . "). ", ERR_DB_NOT_FOUND, 2 ); 
				}
			}
			else
			{ 
				$this->set_error( "An error ocurred while querying the Data Base for Supply. ", ERR_DB_QRY, 2 );
			} 
		}   
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
		$this->id_supply 			= 0;
		$this->id_bar_stock 		= 0;
		$this->id_product 			= 0;
		$this->current 				= 0;
		$this->supplied 			= 0;
		
		$this->timestamp 			= 0;
		
		/*
		require_once DIRECTORY_CLASS . 'class.warehouse.php';
		$this->supplier 		= new Warehouse(0);
		*/
	}
	 
}

?>