<?php

class Report extends Object{
	
	public $name;
	public $tag;
	
	private $query;
	private $sidx;
	private $result;
	
	function __construct($data){
		global $obj_bd;
		$this->error = array();
		$this->class = "Report";
		$this->configure($data);
	}
	/*Step 1, configure report*/
	private function configure($data)
	{
		$this->name = $data->name;
		$this->tag = $data->tag;
		$this->set_query();
	}
	
	private function set_query()
	{
		switch($this->name)
		{
			case 'Balance de Productos':
				$this->query = 	" SELECT id_product, sp_bs_id_bar_stock, pd_product, SUM(sp_supplied) AS total ".
								" FROM ".PFX_MAIN_DB."supply ".
								" INNER JOIN ".PFX_MAIN_DB."product ON sp_pd_id_product = id_product ".
								" GROUP BY id_product ";
								//" WHERE id_product = :id_product ";
			break;
		}
	}
	
	/*Step 2, generate it*/
	public function generate_report()
	{
		/*
		if ( (int)method_exists($this, $this->endpoint) > 0)
		{        	
            $this->{$this->endpoint}($this->args);
        }
        //return array( "No Endpoint: ". $this->endpoint , 404);
		return FALSE;
		*/
		$this->run_balance();
	}
	
	private function run_balance()
	{
		require_once DIRECTORY_CLASS . "class.bar.stock.php";	
		global $obj_bd;
		$this->result = new stdClass;
		
		$resp = $obj_bd->query($this->query);
		if( $resp !== FALSE)
		{
			$this->result->products = array();			
			foreach ($resp as $k => $pd)
			{
				$product = new stdClass;
				
				$head = new stdClass;
				$head->id_product = $pd['id_product'];
				$head->product = $pd['pd_product'];
				$head->total = $pd['total'];
				$stock = new BarStock($pd['sp_bs_id_bar_stock']);
				$head->stock = $stock->quantity;
				$product->head = $head;
				
				$query = 	" SELECT sp_current, sp_supplied, sp_timestamp ".
							" FROM ".PFX_MAIN_DB."supply ".
							" WHERE sp_pd_id_product = :id_product ";
				$info = $obj_bd->query($query, array( ':id_product' => $head->id_product ) );
				if($info !== FALSE)
				{
					$detalles = array();
					foreach($info as $j => $sup)
					{
						$detalle = new stdClass;
						$detalle->current = $sup['sp_current'];
						$detalle->supplied = $sup['sp_supplied'];
						$detalle->timestamp = $sup['sp_timestamp'];
						$detalles[] = $detalle;						
					}
					$product->detail = $detalles;
				}				
				
				$this->result->products[] = $product;
			}
		}
		
	}	
	
	/*Step 3, get the html*/
	public function get_info_html()
	{
	 	$html  = "";
		$data = $this->result;
		ob_start();
		require_once DIRECTORY_VIEWS . "reports/info.".$this->tag.".php"; 
		$html .= ob_get_contents();
		ob_end_clean(); 
		return str_replace(array("\n", "\t"), "", $html);
	 }
	 
	 /*Report specific functions*/
	
	
	
}

?>