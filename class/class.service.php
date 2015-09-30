<?php

class Service extends Object{
	
	public $id_service;
	public $service;
	public $price;
	
	public $products;
	public $timestamp;
	
	function __construct($id_service = 0)
	{
		$this->class = 'Service';
		$this->clean();
		
		if($id_service > 0)
		{
			global $obj_bd;
			$query = 	" SELECT id_service, sr_service, sr_price, sr_timestamp ".
						" FROM ".PFX_MAIN_DB."service ".
						" WHERE id_service = :id_service ";
			$resp = $obj_bd->query($query, array(":id_service" => $id_service) );
			if($resp !== FALSE)
			{
				if(count($resp) > 0)
				{
					$info = $resp[0];
					
					$this->id_service		= $info['id_service'];
					$this->service			= $info['sr_service'];
					$this->price			= $info['sr_price'];
					
					$this->timestamp		= $info['sr_timestamp'];
					$this->set_products();
					
				}
				else
				{
					$this->set_error('No se encontro el servicio. ['.$id_service.'] ', ERR_DB_QRY);
					return FALSE;
				}
			}
			else
			{
				$this->set_error('Error al acceder a la base de datos por el servicio. ', ERR_DB_QRY);
				return FALSE;
			}
		}
		
	}
	
	public function set_products()
	{
		if($this->id_service > 0)
		{
			global $obj_bd;
			$this->products = array();
			$query = 	" SELECT id_product, pd_product, bs_sell_price, id_bar_stock ".
						" FROM ".PFX_MAIN_DB."service_product ".
						" INNER JOIN ".PFX_MAIN_DB."product ON id_product = srp_pd_id_product ".
						" INNER JOIN ".PFX_MAIN_DB."bar_stock ON bs_pd_id_product = srp_pd_id_product ".
						" WHERE srp_sr_id_service = :id_service ";
			$resp = $obj_bd->query($query, array(":id_service" => $this->id_service) );
			if($resp !== FALSE)
			{
				foreach($resp as $k => $info)
				{
					$prod = new stdClass;
					$prod->id_product 		= $info['id_product'];
					$prod->product			= $info['pd_product'];
					$prod->price	 		= $info['bs_sell_price'];
					$prod->id_stock	 		= $info['id_bar_stock'];
					
					$this->products[] = $prod;
				}
			}
		}
	}
	
	public function get_array()
	{
		$array = array(
			'id_service'		=> $this->id_service,
			'service'			=> $this->service,
			'price'				=> $this->price
		);
		
		return $array;
	}
	
	public function clean()
	{
		$this->id_service		= 0;
		$this->service			= '';
		$this->price			= 0;
		
		$this->products			= array();
		$this->timestamp		= 0;
		
		$this->error			= array();
	}
	
	public function get_detail_list_html()
	{
		$html = '';
		
		if(count($this->products) > 0)
		{
			foreach($this->products as $k => $pd)
			{
				$html .= '<tr>'.
							'<td>'.$pd->product.'</td>'.
							'<td>'.$pd->price.'</td>'.
							'<td align="center">
								<button class="button" type="button" title="Eliminar" onclick="delete_product_service('.$pd->id_product.');"><i class="fa fa-times"></i></button>
							</td>'.
						'</tr>';
			}
		}
		else
		{
			$html .= '<tr>'.
							'<td align="center" colspan="3">No hay productos asignados a este servicio.</td>'.
						'</tr>';
		}
		
		return $html;
	}
	
	public function get_list_html()
	{
		$html  = "";
		$service = $this;
		ob_start();
		require_once DIRECTORY_VIEWS . "service/frm.service.detail.php"; 
		$html .= ob_get_contents();
		ob_end_clean(); 
		return str_replace(array("\n", "\t"), "", $html);
	}
}

?>