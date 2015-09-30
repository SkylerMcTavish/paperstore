<?php
if (!class_exists('Sell'))
{
	require_once 'class.sell.php';
}

class AdminSell extends Sell{
	
	function __construct($id_sell = 0)
	{
		global $Session;  
		$this->class = 'AdminSell';  
		if ( !$Session->is_admin() )
		{
			$this->set_error('Restricted Access', SES_RESTRICTED_ACCESS, 3);
			throw new Exception("Restricted access.", 1); 
		}
		parent::__construct( $id_sell );
		$this->class = 'AdminSell';  
	}
	
	public function create_header()
	{
		global $obj_bd;
		global $Session;
		
		$values = array(
			":date" 	=> time(),
			":id_user"	=> $Session->get_id()
		);
		
		$query = 	" INSERT INTO ".PFX_MAIN_DB."sell ".
					" (sl_date, sl_total, sl_us_id_user, sl_status, sl_timestamp, sl_ss_id_sell_status ) ".
					" VALUES ".
					" (:date, 0, :id_user, 1, :date, 1) ";
		$resp = $obj_bd->execute($query, $values);
		if($resp !== FALSE)
		{
			$this->id_sell = $obj_bd->get_last_id();
			$this->set_msg('Venta generada con exito. ['.$this->id_sell.']');
			return TRUE;
		}
		else
		{
			$this->set_error("Error al generar la venta.",ERR_BD_EXEC);
			return FALSE;
		}
	}
	
	public function save_detail()
	{
		global $obj_bd;
		$success = TRUE;
		$this->subtotal = 0;
		foreach($this->details as $k => $detail)
		{
			$values = array(
				":id_sell"		=> $this->id_sell,
				":id_product"	=> $detail['id_product'],
				":id_stock"		=> $detail['id_stock'],
				":quantity"		=> $detail['quantity'],
				":price"		=> $detail['price']
			);
			
			$action = 'SAVE';
			
			if($detail['id_detail'] > 0)
			{
				$action = 'UPDATE';
				$values[':id_detail'] = $detail['id_detail'];
				$query =	" UPDATE ".PFX_MAIN_DB."sell_detail SET ".
							" sd_sl_id_sell			= :id_sell, ".
							" sd_pd_id_product		= :id_product, ".
							" sd_bs_id_bar_stock	= :id_stock, ".
							" sd_quantity			= :quantity, ".
							" sd_price				= :price ".
							" WHERE id_sell_detail = :id_detail ";
			}
			else
			{
				$action = 'INSERT';
				$query = 	" INSERT INTO ".PFX_MAIN_DB."sell_detail ".
							" (sd_sl_id_sell, sd_pd_id_product, sd_bs_id_bar_stock, sd_quantity, sd_price) ".
							" VALUES ".
							" (:id_sell, :id_product, :id_stock, :quantity, :price ) ";
			}
			
			$resp = $obj_bd->execute($query, $values);
			if($resp !== FALSE)
			{
				$this->set_msg('Producto ['.$detail['id_product'].'] vendido con exito. '.$action);
				$success = $success && TRUE;
				$this->subtotal += ( $detail['price'] * $detail['quantity'] );
			}
			else
			{
				$this->set_error("Ocurrio un error al vender el producto [".$detail['id_product']."].",ERR_DB_EXEC);
				$success = $success && FALSE;
			}
		}
		
		$this->update_total();
		
		return $success;
	}
	
	public function update_total()
	{
		$this->total = $this->subtotal;
		
		global $obj_bd;
		$query = 	" UPDATE ".PFX_MAIN_DB."sell SET ".
					" sl_subtotal 		= :total, ".
					" sl_total 			= :total ".
					" WHERE id_sell = :id_sell ";
		$resp = $obj_bd->execute($query, array(":total" => $this->total, ":id_sell" => $this->id_sell));
		if($resp !== FALSE)
		{
			$this->set_msg('Total ['.$this->total.'] de venta ['.$this->id_sell.'] actualizado. '.$action);
			return TRUE;
		}
		else
		{
			$this->set_error("Ocurrio un error al actualizar el total de venta [".$this->id_sell."].",ERR_DB_EXEC);
			return FALSE;
		}
		
	}
	
	public function delete_detail($id_detail)
	{
		if($id_detail > 0)
		{
			foreach($this->details as $k => $detail)
			{
				if($detail['id_detail'] == $id_detail)
				{
					
					global $obj_bd;
					$query = 	" DELETE FROM ".PFX_MAIN_DB."sell_detail WHERE id_sell_detail = :id_detail ";
					$resp = $obj_bd->execute($query, array(":id_detail" => $id_detail));
					if($resp !== FALSE)
					{
						$this->set_msg("Detalle eliminado.");
						return TRUE;
					}
					else
					{
						$this->set_error("Ocurrio un error al eliminar el detalle .",ERR_DB_EXEC);
						return FALSE;
					}
				}
			}
			$this->set_error("No se encontro el detalle [".$id_detail."].",ERR_DB_EXEC);
			return FALSE;
		}
		else
		{
			$this->set_error("Detalle invalido [".$id_detail."].",ERR_DB_EXEC);
			return FALSE;
		}
	}
	
	public function update_detail($id_detail, $quantity )
	{
		if($id_detail > 0)
		{
			foreach($this->details as $k => $detail)
			{
				if($detail['id_detail'] == $id_detail)
				{
					//$detail['quantity'] = $quantity;
					$this->details[$k]['quantity'] = $quantity;
					$this->set_msg("Cantidad [$quantity] del detalle [".$detail['quantity']."] actualizada. ");
					return TRUE;
				}
			}
			$this->set_error("No se encontro el detalle [".$id_detail."].",ERR_DB_EXEC);
			return FALSE;
		}
		else
		{
			$this->set_error("Detalle invalido [".$id_detail."].",ERR_DB_EXEC);
			return FALSE;
		}
	}
	
	public function confirm()
	{
		if($this->confirm_stock())
		{
			global $obj_bd;
			$query = 	" UPDATE ".PFX_MAIN_DB."sell SET ".
						" sl_ss_id_sell_status 		= 2 ".
						" WHERE id_sell = :id_sell ";
			$resp = $obj_bd->execute($query, array( ":id_sell" => $this->id_sell));
			if($resp !== FALSE)
			{
				$this->set_msg('Venta ['.$this->id_sell.'] confirmada. '.$action);
				//return $this->update_stocks();
				return TRUE;
			}
			else
			{
				$this->set_error("Ocurrio un error al confirmar la venta [".$this->id_sell."].",ERR_DB_EXEC);
				return FALSE;
			}
		}
		else
		{
			$this->set_error('Error al confirmar los inventarios.',ERR_DB_EXEC);
			return FALSE;
		}
	}
	
	private function update_stocks()
	{
		$resp = TRUE;
		foreach($this->details as $k => $pd)
		{
			if (!class_exists('AdminBarStock'))
			{
				require_once 'class.admin.bar.stock.php';
			}
			
			$Stock = new AdminBarStock($pd['id_stock']);
			if($Stock->sell_product($pd['quantity']) )
			{
				$resp = $resp && TRUE;
			}
			else
			{
				$resp = $resp && FALSE;
			}
		}
	}
	
	private function confirm_stock()
	{
		require_once DIRECTORY_CLASS . 'class.admin.bar.stock.php';
		foreach($this->details as $k => $detail)
		{
			if($detail['id_product'] > 1)
			{
				$stock = new AdminBarStock($detail['id_stock']);
				$resp = $stock->sell_product($detail['quantity']);
				if($resp !== FALSE)
				{
					$this->set_msg('Producto confirmado.['.$detail['id_product'].']');
				}
				else
				{
					$this->set_error('Ocurrio un error al confirmar el producto ['.$detail['id_product'].']', ERR_DB_EXEC);
					return FALSE;
				}
			}
		}
		
		return TRUE;
	}
	
	public function cancel()
	{
		global $obj_bd;
		$query = 	" UPDATE ".PFX_MAIN_DB."sell SET ".
					" sl_ss_id_sell_status 		= 3 ".
					" WHERE id_sell = :id_sell ";
		$resp = $obj_bd->execute($query, array( ":id_sell" => $this->id_sell));
		if($resp !== FALSE)
		{
			$this->set_msg('Venta ['.$this->id_sell.'] cancelada. '.$action);
			return TRUE;
		}
		else
		{
			$this->set_error("Ocurrio un error al cancelar la venta [".$this->id_sell."].",ERR_DB_EXEC);
			return FALSE;
		}
	}
}

?>