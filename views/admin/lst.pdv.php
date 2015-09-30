<?php 
require_once DIRECTORY_CLASS . "class.admin.lst.php";	
global $Index; 
$list = new AdminList( 'lst_pdv' ); 
?>
<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js"></script>
<script> 
	var ini_lat = <?php echo $pdv->latitude  != '' ? $pdv->latitude  :  19.432611 ?>;
	var ini_lng = <?php echo $pdv->longitude != '' ? $pdv->longitude : -99.133211 ?>; 
	var command = '<?php echo $Index->command;  ?>';  
	var cmd_frm = '<?php echo FRM_PDV;  ?>';  

</script>
<style>
	.tabs-links .nav {
	    background-color: #454545;
	}
</style>
<div id="dashboard-header" class="row">
	<div class="col-xs-12 ">
		<h2> <i class="fa fa-map-marker"> </i>&nbsp; Puntos De Venta </h2>
	</div> 
</div> 
<div id='pdvs-content' class='row '>
	<div class="col-xs-12 col-sm-12">
		<div class='row-fluid'>
			<div id="pdv_links" class="col-xs-12 col-sm-2 pull-right tabs-links" >
				<ul class="nav nav-pills nav-stacked"> 
					<li>
						<span clas='tab-link'>
							<div class="row "> 
								<div class="col-xs-12 " style="margin-bottom: 7px;">
									<select class="form-control" id="flt_channel" onchange="reload_pdv_table();" >
								<?php 	echo $catalogue->get_catalgue_options( 'channel', 0, 'Canal' ); ?>
									</select>
								</div>
								<div id='btns_channel' class="col-xs-12 text-right " style="display:none;"> 
									<button onclick="edit_channel(0)"> <i class='fa fa-plus'></i> </button>
									<button onclick="edit_channel(	$('#flt_channel').val())"> <i class='fa fa-pencil'></i> </button>
									<button onclick="delete_channel($('#flt_channel').val())"> <i class='fa fa-trash-o'></i> </button> 
								</div>	
								<div class="col-xs-12 text-center" style="cursor:pointer;" onclick="$('#btns_channel').toggle();" >
									<span class="text-center"> <i class="fa fa-angle-down"></i> </span>
								</div>
							</div>
						</span>
					</li>
					<li> 
						<span clas='tab-link'>
							<div class="row "> 
								<div class="col-xs-12 " style="margin-bottom: 7px;">
									<select class="form-control " id="flt_division" onchange="reload_pdv_table();" >
										<?php 	echo $catalogue->get_catalgue_options( 'division', 0, 'División' ); ?>
									</select>
								</div>
							</div>
						</span>			
					</li>
				</ul>
			</div>
			<div id="pdv_tabs" class="col-xs-12 col-sm-10 tabs-content content-info" style='margin-top: 0;'>
				<div class="row" style="visibility: visible; position: relative;"> 
					<div class="col-xs-9">
						<h3 id='lbl_table_pdvs'> Listado de PDV </h3> 
					</div>
					<div id='fnc_table_pdvs' class='col-xs-3 pull-right ' style='padding-top: 15px;'>
					<!--
						<button class="btn btn-default pull-right" type="button" title="Crear PDV" onclick='edit_pdv(0);' > 
							<i class="fa fa-plus"></i> <span class='hidden-xs hidden-sm' >Crear PDV</span>
						</button>
					--> 
						<div class="btn-group pull-right">
						  <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
						  	<i class="fa fa-plus"></i><span class='hidden-xs hidden-sm' >Crear PDVs</span> <span class="caret"></span>
						  </button>
						  <ul class="dropdown-menu" role="menu">  
						    <li><a href="#" title="Importar Visitas" onclick='upload_pdvs();' data-target="#mdl_frm_load_pdv" data-toggle="modal">Importar PDVs</a></li> 
						    <li><a href="<?php echo DIRECTORY_UPLOADS ?>tmpl.pdv_load.csv" title="Descargar Plantilla" target="_blank" > Descargar Plantilla </a></li>  
						  </ul>
						</div>
					</div> 
					<div class="col-xs-12 col-sm-12" style="min-height: 400px; overflow-x:auto;"> 
						<table id='tbl_pdv' class="table table-striped table-bordered table-hover datatable">
							 <?php $list->get_list_html();  ?>
						</table> 
					</div>
				</div>
			</div> 
			<div class="clearfix"></div>
		</div>
	</div>
</div>