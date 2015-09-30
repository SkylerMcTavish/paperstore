<?php

class Sell extends Object{

	public $id_sell;
	public $date;
	public $subtotal;
	public $discount;
	public $total;
	public $id_user;
	public $us_user;
	
	public $details;
	
	public $timestamp;

	function __construct( $id_sell = 0 )
	{
		global $obj_bd;
		$this->class = 'Sell';
		$this->error = array();
		$this->clean();
		if ( $id_sell > 0 )
		{
			$query = 	" SELECT id_sell, sl_date, sl_subtotal, sl_discount, sl_total, id_user, us_user, sl_timestamp ".
						" FROM ".PFX_MAIN_DB."sell ".
						" INNER JOIN ".PFX_MAIN_DB."user ON id_user = sl_us_id_user ".
						" WHERE id_sell = :id_sell ";
						
			$info = $obj_bd->query( $query, array( ':id_sell' => $id_sell ) );
			
			if ( $info !== FALSE )
			{
				if ( count($info) > 0 )
				{ 
					$sl = $info[0];
					$this->id_sell		= $sl['id_sell'];
					$this->date			= $sl['sl_date'];
					$this->subtotal		= $sl['sl_subtotal'];
					$this->discount		= $sl['sl_discount'];
					$this->total		= $sl['sl_total'];
					$this->id_user		= $sl['id_user'];
					$this->us_user		= $sl['us_user'];
					$this->timestamp	= $sl['sl_timestamp'];
					
					$this->set_detail();
				}
				else
				{
					$this->clean();
					$this->set_error( "Sell not found (" . $id_sell . "). ", ERR_DB_NOT_FOUND, 2 ); 
				}
			}
			else
			{ 
				$this->clean();
				$this->set_error( "An error ocurred while querying the Data Base. ", ERR_DB_QRY, 2 );
			} 
		}
	}
	
	public function set_detail()
	{
		global $obj_bd;
		
		$query = 	" SELECT id_sell_detail, id_product, pd_product, sd_bs_id_bar_stock, sd_quantity, sd_price ".
					" FROM ".PFX_MAIN_DB."sell_detail ".
					" INNER JOIN ".PFX_MAIN_DB."product ON id_product = sd_pd_id_product ".
					" WHERE sd_sl_id_sell = :id_sell ";
					
		$info = $obj_bd->query( $query, array( ':id_sell' => $this->id_sell ) );
		$this->details = array();
		
		if ( $info !== FALSE )
		{
			foreach($info as $k => $detalle )
			{
				$det = array();
				$det['id_detail']	= $detalle['id_sell_detail'];
				$det['id_product']	= $detalle['id_product'];
				$det['product']		= $detalle['pd_product'];
				$det['id_stock']	= $detalle['sd_bs_id_bar_stock'];
				$det['quantity']	= $detalle['sd_quantity'];
				$det['price']		= $detalle['sd_price'];
				
				$this->details[] = $det;
			}
		}
		else
		{ 
			$this->clean();
			$this->set_error( "An error ocurred while querying the Data Base. ", ERR_DB_QRY, 2 );
		} 
		
	}
	
	private function clean()
	{
		$this->id_sell		= 0;
		$this->date			= 0;
		$this->subtotal		= 0;
		$this->discount		= 0;
		$this->total		= 0;
		$this->id_user		= 0;
		$this->us_user		= '';
		$this->timestamp	= 0;
		
		$this->details = array();
	}
	
	public function get_info_html()
	{
		$html  = "";
		$sell = $this;
		ob_start();
		require_once DIRECTORY_VIEWS . "sell/info.sell.php"; 
		$html .= ob_get_contents();
		ob_end_clean(); 
		return str_replace(array("\n", "\t"), "", $html);
	}
	
	public function get_detail_list_html()
	{
		$html = '';
		
		foreach($this->details as $k => $pd)
		{
			$html .= '<tr>'.
						'<td>'.$pd['product'].'</td>'.
						'<td>'.$pd['quantity'].'</td>'.
						'<td>$&nbsp;'.number_format($pd['price'],2,'.',',').'</td>'.
					'</tr>';
		}
		
		return $html;
	}
	
	public function get_sell_detail_list_html()
	{
		$html = '';
		
		foreach($this->details as $k => $pd)
		{
			$html .= '<tr>'.
						'<td>'.$pd['product'].'</td>'.
						'<td>'.$pd['quantity'].'</td>'.
						'<td>$&nbsp;'.number_format($pd['price'],2,'.',',').'</td>'.
						'<td>$&nbsp;'.number_format(($pd['price'] * $pd['quantity']),2,'.',',').'</td>'.
						'<td align="center">
							<button class="button" type="button" title="Editar" onclick="edit_product_sell('.$pd['id_detail'].');"><i class="fa fa-edit"></i></button>
							<button class="button" type="button" title="Eliminar" onclick="delete_product_sell('.$pd['id_detail'].');"><i class="fa fa-times"></i></button>
						</td>'.
					'</tr>';
		}
		
		return $html;
	}
	
	public function get_sell_detail_html()
	{
		$html  = "";
		$sell = $this;
		ob_start();
		require_once DIRECTORY_VIEWS . "sell/frm.sell.detail.php"; 
		$html .= ob_get_contents();
		ob_end_clean(); 
		return str_replace(array("\n", "\t"), "", $html);
	}
}

?>