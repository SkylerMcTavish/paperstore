<?php
/*paperstore*/
require_once DIRECTORY_CLASS . "class.sitemap.php";
require_once DIRECTORY_CLASS . "class.tax.php";	
global $Index;
global $Settings;
$map = new Sitemap( );
$tax = new Tax( $Settings->get_settings_option('default_tax') );
?>
<script> 
	var command = '<?php echo $Index->command;  ?>';  
	var cmd_frm = '<?php echo FRM_PRODUCT;  ?>';  
	var map;
	var product_marker;  
</script>
<style>
	.tabs-links .nav { background-color: #454545; }
</style>
<div id="dashboard-header" class="row">
	<div class="col-xs-12 ">
		<h2> <i class="fa fa-sitemap"> </i>&nbsp; Ciber Rosy </h2>
	</div> 
</div> 
<div id='products-content' class='row '>
	<div class="col-xs-12 col-sm-12">
		<div class='row-fluid'>
			<div id="product_tabs" class="col-xs-12 col-sm-12 tabs-content content-info" style='margin-top: 0;'>
				<div class="row" style="visibility: visible; position: relative;"> 
					<div class="col-xs-12">
						<h3 id='lbl_table_products'> Renta de Computadoras </h3>
						<span>Tarifa Actual: <?php echo $tax->tax ?> &nbsp; Costo Hora: <?php echo '$ '.number_format($tax->hour, 2); ?> </span>
					</div>
					
					
					
					
						<?php echo $map->get_ciber_html(); ?>
					
					
				</div>
			</div>
			
			<div class="clearfix"></div>
		</div>
	</div>
</div> 