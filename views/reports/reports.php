<?php
	require_once DIRECTORY_CLASS . "class.admin.lst.php";	
	global $Index; 
	$list = new AdminList( 'lst_product' ); 
?>

<script> 
	var command = '<?php echo $Index->command;  ?>';   
</script>
<style>
	.tabs-links .nav { background-color: #454545; }
</style>
<div id="dashboard-header" class="row">
	<div class="col-xs-12 ">
		<h2> <i class="fa fa-tag"> </i>&nbsp; Balance de Productos </h2>
	</div> 
</div> 
<div id='products-content' class='row '>
	<div class="col-xs-12 col-sm-12">
		<div class='row-fluid'>
			<div id="product_links" class="col-xs-12 col-sm-2 pull-right tabs-links" >
				<ul class="nav nav-pills nav-stacked"> 
					<li>
						<span clas='tab-link'>
							<div class="row "> 
								<div class="col-xs-12 " style="margin-bottom: 7px;">
									<select class="form-control" id="flt_category" >
										<?php echo $catalogue->get_catalgue_options( 'product_category', 0, 'Categoria' ); ?>
									</select>
								</div>
							</div>
						</span>
					</li>
					
					<li>
						<span clas='tab-link'>
							<div class="row "> 
								<div class="col-xs-12 " style="margin-bottom: 7px;">
									<select class="form-control" id="flt_product" >
										<?php echo $catalogue->get_catalgue_options( 'product', 0, 'Producto' ); ?>
									</select>
								</div>
							</div>
						</span>
					</li>
					
					<li>
						<span clas='tab-link'>
							<div class="row "> 
								<div class="col-xs-12 " style="margin-bottom: 7px;">
									<label>Fecha Inicial</label>
									<input type="date" class="form-control" id="flt_fini" />
								</div>
							</div>
						</span>
					</li>
					
					<li>
						<span clas='tab-link'>
							<div class="row "> 
								<div class="col-xs-12 " style="margin-bottom: 7px;">
									<label>Fecha Final</label>
									<input type="date" class="form-control" id="flt_ffin" />
								</div>
							</div>
						</span>
					</li>
					
					<li>
						<span clas='tab-link'>
							<div class="row "> 
								<div class="col-xs-12 " style="margin-bottom: 7px;">
									<button onclick="generate_report()">Generar Reporte</button>
								</div>
							</div>
						</span>
					</li>
					
				</ul>
			</div>
			<div id="product_tabs" class="col-xs-12 col-sm-10 tabs-content content-info" style='margin-top: 0;'>
				
			</div> 
			<div class="clearfix"></div>
		</div>
	</div>
</div> 