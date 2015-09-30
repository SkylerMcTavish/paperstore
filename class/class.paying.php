<?php
/**
* Paying CLass
* 
* @package		Ragasa
* @since        1/29/2015
* @author		ignacio.cerda
* 
*/ 
class Paying extends Object {
	 
	public $id_user;
	public $user;
	public $date;
	 
	public $sales;
	public $total_sales;
	
	public $deposits;
	public $total_deposit;
	
	public $stock;
	public $total_stock;
	
	public $payments;
	public $total_payment;
	
	function __construct( $id_user = 0, $date = 0 )
	{
		global $obj_bd;
		$this->error = array();
		$this->class = "Paying";
		$this->clean();
		
		if($id_user > 0 && $date > 0 )
		{
			global $Validate;
			
			if($Validate->exists('user','id_user',$id_user))
			{
				$this->date = $this->get_timestamp($date);
				$this->id_user 	= $id_user;
				//$this->date 	= $date;
				
				$this->set_orders();
				$this->set_deposits();
				$this->set_stock();
				$this->set_payments();
			}
			else
			{
				$this->set_error( "Invalid User ID. ", ERR_DB_QRY, 2 );
			}
		}
	}
	
	private function set_orders()
	{
		global $obj_bd;
		
		/*
		$query = 	" SELECT id_order, id_pdv, pdv_name, or_date, or_folio, os_order_status, or_total, ".
					" (SELECT SUM(or_total) FROM " . PFX_MAIN_DB . "order WHERE or_us_id_user = :id_user AND or_date BETWEEN :since AND :to ) as total ".
					" FROM " . PFX_MAIN_DB . "order ".
					" INNER JOIN " . PFX_MAIN_DB . "pdv ON id_pdv = or_pdv_id_pdv ".
					" INNER JOIN " . PFX_MAIN_DB . "order_status ON id_order_status = or_os_id_order_status ".
					" WHERE or_us_id_user = :id_user AND or_date BETWEEN :since AND :to ";
		*/
		
		$query = 	" SELECT id_order, or_us_id_user, id_pdv, pdv_name, or_date, or_folio, os_order_status, or_total, tbl.or_total_calculated ".
					" FROM " . PFX_MAIN_DB . "order ".
					" INNER JOIN " . PFX_MAIN_DB . "pdv ON id_pdv = or_pdv_id_pdv ".
					" INNER JOIN " . PFX_MAIN_DB . "order_status ON id_order_status = or_os_id_order_status ".
					" INNER JOIN  ( ".
					" 				SELECT od_or_id_order, (SUM(od_quantity * od_price) * 1.15 ) as or_total_calculated ".
					" 				FROM " . PFX_MAIN_DB . "order_detail ".
					" 				INNER JOIN " . PFX_MAIN_DB . "order ON id_order = od_or_id_order ".
					" 				WHERE or_us_id_user = :id_user AND or_date BETWEEN :since AND :to	".
					" 				GROUP BY id_order ".
					" 			) as tbl ON tbl.od_or_id_order = id_order ".
					" WHERE or_us_id_user = :id_user AND or_date BETWEEN :since AND :to ";
							
		$params = array(
						':id_user' 	=> $this->id_user,
						':since' 	=> $this->date,
						':to' 		=> ($this->date + 86400)
					   );
		
		$resp = $obj_bd->query($query, $params );
		
		if($resp !== FALSE)
		{
			//$this->total_sales = $resp[0]['total'];
			$this->total_sales = 0;
			foreach($resp as $k => $info)
			{
				
				$sale = array();
				$sale['order']		= $info['id_order'];
				$sale['pdv'] 		= $info['pdv_name'];
				$sale['folio'] 		= $info['or_folio'];
				$sale['total'] 		= $info['or_total_calculated'];
				
				$this->total_sales += $info['or_total_calculated'];
				
				$this->sales[] = $sale;
			}
		}
		else
		{
			$this->set_error( "An error ocurred while querying the Data Base for sales information. ", ERR_DB_QRY, 2 );
			return FALSE;
		}
	}
	
	private function set_deposits()
	{
		global $obj_bd;
		
		$query = 	" SELECT dp_folio, dp_total, ".
					" (SELECT SUM(dp_total) FROM " . PFX_MAIN_DB . "deposit WHERE dp_us_id_user = :id_user ".
						" AND dp_date BETWEEN :since AND :to ) AS total ".
					" FROM " . PFX_MAIN_DB . "deposit ".
					" WHERE dp_us_id_user = :id_user AND dp_date BETWEEN :since AND :to ";
							
		$params = array(
						':id_user' 	=> $this->id_user,
						':since' 	=> $this->date,
						':to' 		=> ($this->date + 86400)
					   );
		
		$resp = $obj_bd->query($query, $params );
		
		if($resp !== FALSE)
		{
			$this->total_deposit = $resp[0]['total'];
			foreach($resp as $k => $info)
			{
				
				$dp = array();
				$dp['folio'] 		= $info['dp_folio'];
				$dp['quantity'] 	= $info['dp_total'];
				
				$this->deposits[] = $dp;
			}
		}
		else
		{
			$this->set_error( "An error ocurred while querying the Data Base for deposits information. ", ERR_DB_QRY, 2 );
			return FALSE;
		}
	}
	
	private function set_stock()
	{
		global $obj_bd;
		
		$query = 	" SELECT id_order, od_pd_id_product, pd_product, pd_jde, ".
					" SUM(od_quantity) AS stock, ( SUM(od_quantity) / 12 ) AS box, ".
					" ( ".
					" 	SELECT SUM(od_quantity) / 12 ".
					" 	FROM " . PFX_MAIN_DB . "order_detail ".
					"	INNER JOIN " . PFX_MAIN_DB . "order ON id_order = od_or_id_order ".
					"	WHERE or_us_id_user = :id_user AND or_date BETWEEN :since AND :to	".
					" ) AS total_box ".
					" FROM " . PFX_MAIN_DB . "order ".
					" INNER JOIN " . PFX_MAIN_DB . "order_detail ON id_order = od_or_id_order ".
					" INNER JOIN " . PFX_MAIN_DB . "product ON id_product = od_pd_id_product ".
					" WHERE or_us_id_user = :id_user AND or_date BETWEEN :since AND :to ".
					" GROUP BY od_pd_id_product ";
							
		$params = array(
						':id_user' 	=> $this->id_user,
						':since' 	=> $this->date,
						':to' 		=> ($this->date + 86400)
					   );
		
		$resp = $obj_bd->query($query, $params );
		
		if($resp !== FALSE)
		{
			$this->total_stock = $resp[0]['total_box'];
			foreach($resp as $k => $info)
			{
				
				$stock = array();
				$stock['product'] 	= $info['pd_product'];
				$stock['jde'] 		= $info['pd_jde'];
				$stock['unity'] 	= $info['stock'];
				$stock['box'] 		= $info['box'];
				
				$this->stock[] = $stock;
			}
		}
		else
		{
			$this->set_error( "An error ocurred while querying the Data Base for sales information. ", ERR_DB_QRY, 2 );
			return FALSE;
		}
	}
	
	private function set_payments()
	{
		global $obj_bd;
		
		$query = 	" SELECT py_us_id_user, pdv_name, in_folio, pm_payment_method, py_total, ".
					" (SELECT SUM(py_total) FROM " . PFX_MAIN_DB . "payment WHERE py_us_id_user = :id_user AND py_timestamp BETWEEN :since AND :to ) AS total ".
					" FROM " . PFX_MAIN_DB . "payment ".
					" INNER JOIN " . PFX_MAIN_DB . "pdv ON id_pdv = py_pdv_id_pdv ".
					" INNER JOIN " . PFX_MAIN_DB . "payment_method ON id_payment_method = py_pm_id_payment_method ".
					" LEFT JOIN " . PFX_MAIN_DB . "invoice ON id_invoice = py_in_id_invoice ".
					" WHERE py_us_id_user = :id_user AND py_timestamp BETWEEN :since AND :to ";
							
		$params = array(
						':id_user' 	=> $this->id_user,
						':since' 	=> $this->date,
						':to' 		=> ($this->date + 86400)
					   );
		
		$resp = $obj_bd->query($query, $params );
		
		if($resp !== FALSE)
		{
			$this->total_payment = $resp[0]['total'];
			foreach($resp as $k => $info)
			{
				
				$py = array();
				$py['pdv'] 		= $info['pdv_name'];
				$py['folio'] 	= $info['in_folio'];
				$py['method'] 	= $info['pm_payment_method'];
				$py['amount'] 	= $info['py_total'];
				
				$this->payments[] = $py;
			}
		}
		else
		{
			$this->set_error( "An error ocurred while querying the Data Base for payments information. ", ERR_DB_QRY, 2 );
			return FALSE;
		}
	}
	
	public function get_sales_table()
	{
		$html = '';
		ob_start();
		foreach($this->sales as $record)
		{
			require DIRECTORY_VIEWS . "lists/lst.paying.sales.php"; 
			
		}
		$html .= ob_get_contents();
		ob_end_clean(); 
		return str_replace(array("\n", "\t"), "", $html);
	}

	public function get_deposit_table()
	{
		$html = '';
		ob_start();
		foreach($this->deposits as $record)
		{
			require DIRECTORY_VIEWS . "lists/lst.paying.deposit.php"; 
			
		}
		$html .= ob_get_contents();
		ob_end_clean(); 
		return str_replace(array("\n", "\t"), "", $html);
	}
	
	public function get_stock_table()
	{
		$html = '';
		ob_start();
		foreach($this->stock as $record)
		{
			require DIRECTORY_VIEWS . "lists/lst.paying.stock.php"; 
			
		}
		$html .= ob_get_contents();
		ob_end_clean(); 
		return str_replace(array("\n", "\t"), "", $html);
	}
	
	public function get_payment_table()
	{
		$html = '';
		ob_start();
		foreach($this->payments as $record)
		{
			require DIRECTORY_VIEWS . "lists/lst.paying.payment.php"; 
			
		}
		$html .= ob_get_contents();
		ob_end_clean(); 
		return str_replace(array("\n", "\t"), "", $html);
	}
	
	public function get_list_html( $ajax = FALSE )
	{
		$html = '';
		ob_start();
		?>
			<div class="bs-example">
				<div class="panel-group" id="accordion">
					
					<div class="panel panel-default">
						<div class="panel-heading" data-toggle="collapse" data-parent="#accordion"  href="#collapse_orders" style="cursor: pointer">
							<h4 class="panel-title">
								<span>Ventas</span>
								<span class="pull-right">Total:&nbsp;<strong id="lbl_order_total" class="badge">$ <?php echo number_format($this->total_sales, 2, '.', ',') ?></strong></span>
							</h4>
						</div>
						<div id="collapse_orders" class="panel-collapse collapse">
							<div class="panel-body">
								<table id='tbl_order' class="table table-striped table-bordered table-hover datatable">
									<thead>
										<tr>
											<th>Cliente</th>
											<th>ID Pedido</th>
											<th>Folio</th>
											<th>Total</th>
										</tr>
									</thead>
									<tbody>
										<?php echo $this->get_sales_table(); ?>
									</tbody>
							   </table> 
							</div>
						</div>
					</div>
					
					<div class="panel panel-default">
						<div class="panel-heading" data-toggle="collapse" data-parent="#accordion" href="#collapse_deposits" style="cursor: pointer">
							<h4 class="panel-title">
								<span>Depósitos Bancarios</span>
								<span class="pull-right">Total:&nbsp;<strong id="lbl_deposit_total"  class="badge">$ <?php echo number_format($this->total_deposit, 2, '.', ',') ?></strong></span>
							</h4>
						</div>
						<div id="collapse_deposits" class="panel-collapse collapse">
							<div class="panel-body" >
								<table id="tbl_deposits" class="table table-striped table-bordered table-hover datatable">
									<thead>
										<tr>
											<th>No. Ficha</th>
											<th>Cantidad</th>
										</tr>
									</thead>
									<tbody>
										<?php echo $this->get_deposit_table(); ?>
									</tbody>
							   </table> 
							</div>
						</div>
					</div>
					
					<div class="panel panel-default">
						<div class="panel-heading" data-toggle="collapse" data-parent="#accordion" href="#collapse_stock" style="cursor: pointer">
							<h4 class="panel-title">
								<span>Inventario</span>
								<span class="pull-right">Total:&nbsp;<strong id="lbl_stock_total"  class="badge"><?php echo number_format($this->total_stock, 2, '.', ',') ?> cajas</strong></span>
							</h4>
						</div>
						<div id="collapse_stock" class="panel-collapse collapse">
							<div class="panel-body" >
								<table id="tbl_stock" class="table table-striped table-bordered table-hover datatable">
									<thead>
										<tr>
											<th>Producto</th>
											<th>JDE</th>
											<th>Unidades</th>
											<th>Cajas</th>
										</tr>
									</thead>
									<tbody>
										<?php echo $this->get_stock_table(); ?>
									</tbody>
							   </table>
							</div>
						</div>
					</div>
					
					<div class="panel panel-default">
						<div class="panel-heading" data-toggle="collapse" data-parent="#accordion" href="#collapse_payment" style="cursor: pointer">
							<h4 class="panel-title">
								<span>Registro de Pagos</span>
								<span class="pull-right">Total:&nbsp;<strong id="lbl_payment_total"  class="badge">$ <?php echo number_format($this->total_payment, 2, '.', ',') ?></strong></span>
							</h4>
						</div>
						<div id="collapse_payment" class="panel-collapse collapse">
							<div class="panel-body">
								<table id="tbl_payment" class="table table-striped table-bordered table-hover">
									<thead>
										<tr>
											<th>Cliente</th>
											<th>Factura</th>
											<th>Metodo</th>
											<th>Monto</th>
										</tr>
									</thead>
									<tbody>
										<?php echo $this->get_payment_table(); ?>
									</tbody>
							   </table>
							</div>
						</div>
					</div>
					
				</div>
			</div>
		<?php
		$html .= ob_get_contents();
		ob_end_clean();
		
		if($ajax)
			return str_replace(array("\n", "\t"), "", $html);
		else
			echo $html;
	}
	
	private function get_timestamp( $date )
	{
		// >> 15/01/2015
		try
		{
			list( $d, $m, $Y ) 	= explode("/", $date );
			return mktime( 0, 0, 0, $m, $d, $Y );
		}
		catch ( Exception $e )
		{
			$this->set_error("Invalid date parameters ( $date )", ERR_VAL_INVALID);
			return FALSE;
		} 
		
	}
	
	private function clean()
	{
		$this->id_user 			= 0;
		$this->user 			= new stdClass();
		$this->date 			= 0;
		
		$this->sales			= array();
		$this->deposits			= array();
		$this->stock			= array();
		$this->payments			= array();
		
		$this->total_deposit 	= 0;
		$this->total_payment 	= 0;
		$this->total_sales 		= 0;
		$this->total_stock 		= 0;
	}
}

?>