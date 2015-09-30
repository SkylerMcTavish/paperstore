<?php

if (!class_exists('Service'))
{
	require_once 'class.service.php';
}

class AdminService extends Service{
	
	function __construct( $id_service )
	{
		global $Session;  
		$this->class = 'AdminService';  
		if ( !$Session->is_admin() )
		{
			$this->set_error('Restricted Access', SES_RESTRICTED_ACCESS, 3);
			throw new Exception("Restricted access.", 1); 
		}
		parent::__construct( $id_service );
		$this->class = 'AdminService';  
	}
	
	private function validate_detail($detail, $idx = FALSE)
	{
		global $Validate;
		if ( !$detail->id_product > 0 || !$Validate->exists( 'product', 'id_product', $detail->id_product )){
			$this->set_error( 'Invalid Product. ' . ( $idx !== FALSE ? "detail  line " . $idx . "." : "" ) , ERR_VAL_EMPTY );
			return FALSE;
		} 
		
		return TRUE;
	}
	
	public function asign_product($id_product)
	{
		global $Validate;
		$id_stock 	= $Validate->get_data_by_column('bar_stock', 'id_bar_stock', 'bs_pd_id_product', $id_product);
		$price 		= $Validate->get_data_by_column('bar_stock', 'id_bar_stock', 'bs_sell_price', $id_product);
		
		$prod = new stdClass;
		$prod->id_product 		= $id_product;
		$prod->price	 		= $price;
		$prod->id_stock	 		= $id_stock;
		
		$this->products[] 		= $prod;
	}
	
	public function delete_product($id_product)
	{
		global $obj_bd;
		foreach($this->products as $k => $pd)
		{
			if($pd->id_product == $id_product)
			{
				$query = 	" DELETE FROM ".PFX_MAIN_DB."service_product WHERE srp_pd_id_product = :id_product AND srp_sr_id_service = :id_service ";
				$values = array(':id_product' => $id_product, ':id_service' => $this->id_service);
				
				$resp = $obj_bd->execute($query, $values);
				if($resp !== FALSE)
				{
					$this->set_msg("Producto [".$id_product."] borrado del servicio [".$this->id_service."].");
					return TRUE;
				}
				else
				{
					$this->set_error( 'Error al eliminar el producto del servicio. ' , ERR_DB_EXE );
					return FALSE;
				}
			}
		}
		
		return FALSE;
	}
	
	private function validate()
	{
		global $Validate;
		if ( !$this->service != '' )
		{
			$this->set_error( 'Name value empty. ', ERR_VAL_EMPTY );
			return FALSE;
		}
		if ( !is_numeric($this->price)  )
		{ 
			$this->set_error( 'Invalid Service Price value. ', ERR_VAL_INVALID );
			return FALSE;
		}
		
		foreach ($this->products as $k => $detail ) {
			if ( !$this->validate_detail($detail, $k) ){
				return FALSE;
			}
		}
		return TRUE;
	}
	
	
	public function save()
	{
		if($this->validate())
		{
			global $obj_bd;
			$values = array(
				":service"		=> $this->service,
				":price"		=> $this->price,
				":time"			=> time()
			);
			$action = 'SAVE';
			if($this->id_service > 0)
			{
				$values[':id_service'] = $this->id_service;
				$action = 'UPDATE';
				$query =	" UPDATE ".PFX_MAIN_DB."service SET ".
							" sr_service		= :service, ".
							" sr_price			= :price, ".
							" sr_timestamp		= :time ".
							" WHERE id_service 	= :id_service ";
			}
			else
			{
				$action = 'INSERT';
				$query = 	" INSERT INTO ".PFX_MAIN_DB."service ".
							" (sr_service, sr_price, sr_status, sr_timestamp ) ".
							" VALUES ".
							" (:service, :price, 1, :time) ";
			}
			
			$resp = $obj_bd->execute($query, $values);
			if($resp !== FALSE)
			{
				if($this->id_service == 0)
				{
					$this->id_service = $obj_bd->get_last_id();
				}
				$this->set_msg($action, 'El servicio ['.$this->id_service.'] se guardo correctamente.');
				
				return $this->save_detail();
			}
			else
			{
				$this->set_error("Ocurrio un error al guardar el servicio. [".$this->service."]", ERR_DB_EXEC);
				return FALSE;
			}
		}
		else
		{
			return FALSE;
		}
	}
	
	private function save_detail()
	{
		if ( $this->id_service > 0 )
		{
	 		if ( count ( $this->products ) > 0 )
			{
	 			global $obj_bd;
	 			$query = "DELETE FROM " . PFX_MAIN_DB . "service_product WHERE srp_sr_id_service = :id_service ";
	 			$result = $obj_bd->execute($query, array( ':id_service' => $this->id_service)); 
	 			if ( $result !== FALSE )
				{
	 				$query = "INSERT INTO " . PFX_MAIN_DB . "service_product ( srp_sr_id_service, srp_pd_id_product ) "
							. " VALUES ( :id_service, :id_product) " ;
					$resp = TRUE;
		 			foreach ($this->products as $k => $detail)
					{
		 				$params = array( 
		 								':id_service' 	=> $this->id_service,
		 								':id_product' 	=> $detail->id_product,
		 							);
						$result = $obj_bd->execute($query, $params);
						if ( !($result !== FALSE))
						{
							$this->error[] = $this->set_error("An error occured while saving product detail ( Service " . $this->id_service . " Line " . $k . " )", ERR_DB_EXEC);
						}
						$resp = $resp & $result;
					}
					return $resp;
				}
				else
				{
					$this->set_error("A database error occured while preparing service details. ", ERR_DB_EXEC );
					return FALSE;
				}
	 		}
			return TRUE;
	 	}
		else
		{
	 		$this->set_error("Invalid service ID attempting to save detail.", ERR_VAL_INVALID, 3);
	 		return FALSE;
	 	}
	}
	
	public function delete()
	{
		global $obj_bd;
		
		$query = 	" DELETE FROM ".PFX_MAIN_DB."service_product WHERE srp_sr_id_service = :id_service ";
		$values = array(':id_service' => $this->id_service);
		
		$resp = $obj_bd->execute($query, $values);
		if($resp !== FALSE)
		{
			$this->set_msg("Productos borrados del servicio [".$this->id_service."].");
			$query = 	" UPDATE ".PFX_MAIN_DB."service SET sr_status = 0 WHERE id_service =:id_service ";
			$values = array(':id_service' => $this->id_service);
			$del = $obj_bd->execute($query, $values);
			if($del !== FALSE )
			{
				$this->set_msg('Servicio ['.$this->id_service.'] eliminado con exito.');
				return TRUE;
			}
			else
			{
				$this->set_error( 'Error al eliminar el servicio. ' , ERR_DB_EXE );
				return FALSE;
			}
		}
		else
		{
			$this->set_error( 'Error al eliminar los productos del servicio. ' , ERR_DB_EXE );
			return FALSE;
		}
	}
}

?>