<?php
/*paperstore*/
require_once DIRECTORY_CLASS . "class.admin.lst.php";	
global $Index; 
$list = new AdminList( 'lst_sell' ); 
?>
<script> 
	var command = '<?php echo $Index->command;  ?>';  
	var cmd_frm = '<?php echo PAPERSTORE;  ?>';  
	var map;
	var product_marker;  
</script>
<style>
	.tabs-links .nav { background-color: #454545; }
</style>
<div id="dashboard-header" class="row">
	<div class="col-xs-12 ">
		<h2> <i class="fa fa-tag"> </i>&nbsp; Ventas </h2>
	</div> 
</div> 
<div id='products-content' class='row '>
	<div class="col-xs-12 col-sm-12">
		<div class='row-fluid'>
			
			<div id="product_tabs" class="col-xs-12 col-sm-12 tabs-content content-info" style='margin-top: 0;'>
				<div class="row" style="visibility: visible; position: relative;"> 
					<div class="col-xs-9">
						<h3 id='lbl_table_products'> Registro de Ventas </h3> 
					</div>
					<div id='fnc_table_products' class='col-xs-3 pull-right ' style='padding-top: 15px;'>
						
						<form action="admin.paperstore.php" method="post">
							<input type="hidden" id="inp_action" name="action" value="create_sell" />
							<button class="btn btn-default pull-right" type="submit" title="Registrar Venta"  > 
								<i class="fa fa-plus"></i> <span class='hidden-xs hidden-sm' >Registrar Venta</span>
							</button>
						</form>
						<!--
						<button class="btn btn-default pull-right" type="button" title="Cargar Producto" onclick='load_products()' > 
							<i class="fa fa-upload"></i> <span class='hidden-xs hidden-sm' >Cargar Productos</span>
						</button>
						--> 
					</div> 
					<div class="col-xs-12 col-sm-12" style="min-height: 400px; overflow-x:auto;"> 
						<table id='tbl_product' class="table table-striped table-bordered table-hover datatable">
							 <?php $list->get_list_html();  ?>
						</table> 
					</div>
				</div>
			</div> 
			<div class="clearfix"></div>
		</div>
	</div>
</div> 