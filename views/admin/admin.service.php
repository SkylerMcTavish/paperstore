<?php
/*paperstore*/
require_once DIRECTORY_CLASS . "class.admin.lst.php";	
global $Index; 
$list = new AdminList( 'lst_service' ); 
?>
<script> 
	var command = '<?php echo $Index->command;  ?>';  
	var cmd_frm = '<?php echo FRM_SERVICE;  ?>';  
	var map;
	var service_marker;  
</script>
<style>
	.tabs-links .nav { background-color: #454545; }
</style>
<div id="dashboard-header" class="row">
	<div class="col-xs-12 ">
		<h2> <i class="fa fa-tag"> </i>&nbsp; Servicios </h2>
	</div> 
</div> 
<div id='services-content' class='row '>
	<div class="col-xs-12 col-sm-12">
		<div class='row-fluid'>
			<div id="service_tabs" class="col-xs-12 col-sm-12 tabs-content content-info" style='margin-top: 0;'>
				<div class="row" style="visibility: visible; position: relative;"> 
					<div class="col-xs-9">
						<h3 id='lbl_table_services'> Listado de Servicios </h3> 
					</div>
					<div id='fnc_table_services' class='col-xs-3 pull-right ' style='padding-top: 15px;'>
						<button class="btn btn-default pull-right" type="button" title="Crear Servicio" onclick='edit_service(0);' > 
							<i class="fa fa-plus"></i> <span class='hidden-xs hidden-sm' >Crear Servicio</span>
						</button>
					</div> 
					<div class="col-xs-12 col-sm-12" style="min-height: 400px; overflow-x:auto;"> 
						<table id='tbl_service' class="table table-striped table-bordered table-hover datatable">
							 <?php $list->get_list_html();  ?>
						</table> 
					</div>
				</div>
			</div> 
			<div class="clearfix"></div>
		</div>
	</div>
</div> 