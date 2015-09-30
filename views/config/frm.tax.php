<?php 
require_once DIRECTORY_CLASS . "class.admin.lst.php";
require_once DIRECTORY_CLASS . "class.tax.php";	
global $Index;
global $Settings;
$list = new AdminList( 'lst_tax' );
$tax = new Tax( $Settings->get_settings_option('default_tax') );

?>


<script> 
	var command = '<?php echo $Index->command;  ?>';  
	var cmd_frm = '<?php echo FRM_TAXES;  ?>';  
</script>
<style>
	.tabs-links .nav {
	    background-color: #454545;
	}
</style>
<div id="dashboard-header" class="row">
	<div class="col-xs-12 ">
		<h2> <i class="fa fa-money"> </i>&nbsp;&nbsp;&nbsp; Tarifas del Ciber </h2>
	</div> 
</div> 
<div id='tax-content' class='row '>
	<div class="col-xs-12">
		<div class='row-fluid'>
			<div id="tax_tabs" class="col-xs-12 col-sm-12 tabs-content content-info" style='margin-top: 0;'>
				
				<div class="row" style="visibility: visible; position: relative;"> 
					<div class="col-xs-9">
						<h3 id='lbl_table_tax'> Tarifa Actual: <span id="sp_def_tax"><?php echo $tax->tax ?></span> &nbsp; Costo Hora: <span id="sp_def_hour"><?php echo '$ '.number_format($tax->hour, 2); ?></span> </h3> 
					</div>
					
				</div>
			
				<div class="row" style="visibility: visible; position: relative;"> 
					<div class="col-xs-9">
						<h3 id='lbl_table_tax'> Listado de Tarifas </h3> 
					</div>
					<div id='fnc_table_tax' class='col-xs-3 pull-right ' style='padding-top: 15px;'>
						<button class="btn btn-default pull-right" type="button" title="Crear Tarifa" onclick='edit_tax(0);' > 
							<i class="fa fa-plus"></i> <span class='hidden-xs hidden-sm' >Crear Tarifa</span>
						</button>
					</div> 
					<div class="col-xs-12 col-sm-12" style="min-height: 400px; overflow-x:auto;"> 
						<table id='tbl_tax' class="table table-striped table-bordered table-hover datatable">
							 <?php $list->get_list_html();  ?>
						</table> 
					</div>
				</div>
			</div> 
			<div class="clearfix"></div>
		</div>
	</div>
</div>