<?php
/*paperstore*/
require_once DIRECTORY_CLASS . "class.sitemap.php";	
global $Index; 
$map = new Sitemap();
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
		<h2> <i class="fa fa-sitemap"> </i>&nbsp; Disposicion del Ciber Rosy </h2>
	</div> 
</div> 
<div id='products-content' class='row '>
	<div class="col-xs-12 col-sm-12">
		<div class='row-fluid'>
			<div id="product_tabs" class="col-xs-12 col-sm-12 tabs-content content-info" style='margin-top: 0;'>
				<div class="row" style="visibility: visible; position: relative;"> 
					<div class="col-xs-9">
						<h3 id='lbl_table_products'> Disposicion para las computadoras del ciber </h3> 
					</div>
					
					<div class="col-xs-3">
						<input style="width: 50px;" type="number" step="1" min="1" max="12" value="<?php echo $map->x; ?>" id="inp_map_x" />
						&times;
						<input style="width: 50px;" type="number" step="1" min="1" max="10" value="<?php echo $map->y; ?>" id="inp_map_y" />
						<button type="button" class="btn btn-default" data-dismiss="modal" onclick="adjust_sitemap_size();">
							<i class="fa fa-clock-o"></i>
						   Actualizar
					   </button>
					</div>
					
					
				</div>
				
				<div class="row">
					<div id="sitemap">
						<?php echo $map->get_layout_html(); ?>
					</div>	
				</div>
			</div>
			<div class="clearfix"></div>
		</div>
	</div>
</div> 