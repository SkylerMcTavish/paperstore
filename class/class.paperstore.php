<?php

class Paperstore extends Object{
	
	public $sales;
	public $leasing;
	public $profit;
	
	public $total;
	
	function __construct()
	{
		$this->clean();
		$this->get_daily_sales();
		$this->get_daily_leasing();
		$this->get_daily_profit();
		$this->total = $this->sales + $this->leasing;
	}
	
	public function clean()
	{
		$this->sales 		= 0;
		$this->leasing 		= 0;
		$this->total 		= 0;
		$this->profit 		= 0;
	}
	
	public function get_daily_profit()
	{
		global $obj_bd;
		$start  = mktime(0, 0, 0, date('n'), date('j'), date('Y') );
		$end    = mktime(23, 59, 59, date('n'), date('j'), date('Y') );
		
		$query = 	" SELECT bs_sell_price, ss_buy_price, sd_quantity ".
					" FROM ".PFX_MAIN_DB."sell ".
					" INNER JOIN ".PFX_MAIN_DB."sell_detail ON id_sell = sd_sl_id_sell ".
					" INNER JOIN ".PFX_MAIN_DB."bar_stock ON bs_pd_id_product = sd_pd_id_product ".
					" INNER JOIN ".PFX_MAIN_DB."storehouse_stock ON ss_pd_id_product = sd_pd_id_product ".
					" WHERE sl_status > 0 AND sl_ss_id_sell_status = 2 ".
					" AND sl_date >= :start AND sl_date <= :end ";
		$resp = $obj_bd->query($query, array(":start" => $start, ":end" => $end));
		
		if($resp !== FALSE)
		{
			foreach($resp as $k => $pd)
			{
				$this->profit += ( ($pd['bs_sell_price'] * $pd['sd_quantity']) - ($pd['ss_buy_price'] * $pd['sd_quantity']) );
			}
		}
		else
		{
			$this->profit = 0;
		}
	}
	
	public function get_daily_sales()
	{
		global $obj_bd;
		$start  = mktime(0, 0, 0, date('n'), date('j'), date('Y') );
		$end    = mktime(23, 59, 59, date('n'), date('j'), date('Y') );
		
		$query = 	" SELECT SUM(sl_total) AS total ".
					" FROM ".PFX_MAIN_DB."sell ".
					" WHERE sl_status > 0 AND sl_ss_id_sell_status = 2 ".
					" AND sl_date >= :start AND sl_date <= :end ";
		$resp = $obj_bd->query($query, array(":start" => $start, ":end" => $end));
		
		if($resp !== FALSE)
		{
			if(count($resp) > 0)
			{
				$info = $resp[0];
				$this->sales =  $info['total'];
			}
			else
			{
				$this->sales = 0;
			}
		}
		else
		{
			$this->sales = 0;
		}
	}
	
	public function get_daily_leasing()
	{
		global $obj_bd;
		$start  = mktime(0, 0, 0, date('n'), date('j'), date('Y') );
		$end    = mktime(23, 59, 59, date('n'), date('j'), date('Y') );
		
		$query = 	" SELECT SUM(ls_total) AS total ".
					" FROM ".PFX_MAIN_DB."leasing ".
					" WHERE ls_end > 0 AND ls_status = 0  ".
					" AND ls_start >= :start AND ls_start <= :end ";
		$resp = $obj_bd->query($query, array(":start" => $start, ":end" => $end) );
		
		if($resp !== FALSE)
		{
			if(count($resp) > 0)
			{
				$info = $resp[0];
				$this->leasing = $info['total'];
			}
			else
			{
				$this->leasing = 0;
			}
		}
		else
		{
			$this->leasing = 0;
		}
	}
	
	public function search_product( $search )
	{
		global $obj_bd;
		$search = mysql_real_escape_string($search);
		$query 	= 	" SELECT id_product, pd_product, pd_alias ".
					" FROM ".PFX_MAIN_DB."product ".
					" INNER JOIN ".PFX_MAIN_DB."bar_stock ON id_product = bs_pd_id_product ".
					" INNER JOIN ".PFX_MAIN_DB."brand ON id_brand = pd_br_id_brand ".
					" WHERE pd_status = 1 AND ( pd_product LIKE '%".$search."%' OR pd_alias LIKE '%".$search."%' )";
		$resp = $obj_bd->query($query);
		if($resp !== FALSE)
		{
			$data = $resp;
			$html  = '<div class="col-xs-12 col-sm-12" style="min-height: 400px; overflow-x:auto;"> 
						<table id="tbl_sell_product" class="table table-striped table-bordered table-hover datatable">
							<thead>
								<tr>
									<th>ID</th>
									<th>Producto</th>
									<th>Alias</th>
									<th>Seleccionar</th>
								</tr>
							</thead>
							<tbody>';
			if(count($resp) > 0)
			{
				foreach($resp as $k => $info)
				{
					$html .= '<tr>'.
								'<td>'.$info['id_product'].'</td>'.
								'<td>'.$info['pd_product'].'</td>'.
								'<td>'.$info['pd_alias'].'</td>'.
								'<td align="center">'.
									'<button type="button" class="btn btn-default" onclick="use_product('.$info['id_product'].')" data-dismiss="modal" >'.
										'<i class="fa fa-plus"></i> Seleccionar '.
									'</button></td>'.
							'</tr>';
				}
			}
			else
			{
				$html .= '<tr><td colspan="4" align="center">No se encontraron productos.</td></tr>';
			}
			
			$html .= '</tbody>
					</table> 
				</div>';
			
			return str_replace(array("\n", "\t"), "", $html);
		}
		else
		{
			$this->set_error("Database error while querying for product '" . $search . "'. ", ERR_VAL_INVALID);
            return FALSE;
		}
	}
}

?>