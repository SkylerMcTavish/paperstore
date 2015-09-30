<?php
	require_once DIRECTORY_CLASS . "class.admin.lst.php";	
	global $Index; 
	$list = new AdminList( 'lst_pdv_type' ); 
?>

<script>
	function showTab( which )
	{
		$('.tab-content').hide();
		$(which).show();
	}
</script>

<div id="dashboard-header" class="row">
	<div class="col-xs-12 ">
		<h2> <i class="fa fa-barcode"> </i>&nbsp; PDVs </h2>
	</div> 
</div> 
<div id='pdvs-content' class='row '>
	<div class="col-xs-12 col-sm-12">
	
	<ul class="nav nav-tabs" role="tablist">
		<li <?php echo ( isset($_GET['tab']) ) ? "" : "class='active'" ?>><a href="#cont-pdvs" role="tab" data-toggle="tab" onclick="showTab('#cont-pdv_type');">Tipos de PDV</a></li> 
		<li <?php echo ( isset($_GET['tab']) && $_GET['tab'] == 'pdvtask' ) ? "class='active'" : "" ?>><a href="#cont-tasks" role="tab" data-toggle="tab" onclick="showTab('#cont-pdvs_activities');">PDVs y Tareas</a></li> 
	</ul>
	
	<div class='tab-content' id="cont-pdv_type" <?php echo ( isset($_GET['tab']) ) ? 'style="display: none"' : ""  ?>>
		<div class='row-fluid' >
		<?php $list = new AdminList( 'lst_pdv_type' ); ?>
			<div id="pdv_type_tabs" class="col-xs-12 col-sm-12 tabs-content content-info" style='margin-top: 0;'>
				<div class="row" style="visibility: visible; position: relative;"> 
					<div class="col-xs-9">
						<h3 id='lbl_table_pdv_type'> Tipos de PDV </h3> 
					</div>
					<div id='fnc_table_pdv_type' class='col-xs-3 pull-right ' style='padding-top: 15px;'> 
						<button class="btn btn-default pull-right" type="button" title="Crear Tipo de Tarea" onclick='edit_pdv_type(0);' > 
							<i class="fa fa-plus"></i> <span class='hidden-xs hidden-sm' >Crear Tipo de PDV	</span>
						</button>
					</div> 
					<div class="col-xs-12 col-sm-12" style="min-height: 400px; overflow-x:auto;"> 
						<table id='tbl_pdv_type' class="table table-striped table-bordered table-hover datatable">
							 <?php $list->get_list_html();  ?>
						</table> 
					</div>
				</div>
			</div> 
			<div class="clearfix"></div>
		</div>
	</div> 
	
	<div class='tab-content' id="cont-pdvs_activities" <?php echo ( isset($_GET['tab']) && $_GET['tab'] == 'pdvtask' ) ? "" : 'style="display: none"' ?> >
		<div class='row-fluid' >
		<?php $list = new AdminList( 'lst_pdv_type_task' ); ?>
			<div id="pdv_tabs" class="col-xs-12 col-sm-12 tabs-content content-info" style='margin-top: 0;'>
				<div class="row" style="visibility: visible; position: relative;"> 
					<div class="col-xs-9">
						<h3 id='lbl_table_pdvs'> Tareas por Tipo de PDV </h3> 
					</div>
					
					<div id='fnc_table_pdv_type' class='col-xs-3 pull-right ' style='padding-top: 15px;'> 
						<button class="btn btn-default pull-right" type="button" title="Asignar Actividad" onclick='asgn_pdv_task(0);' > 
							<i class="fa fa-plus"></i> <span class='hidden-xs hidden-sm' >Asignar Tarea</span>
						</button>
					</div>
					
					<div class="col-xs-12 col-sm-12" style="min-height: 400px; overflow-x:auto;"> 
						<table id='tbl_pdvs' class="table table-striped table-bordered table-hover datatable">
							 <?php $list->get_list_html();  ?>
						</table> 
					</div>
				</div>
			</div> 
			<div class="clearfix"></div>
		</div>
	</div>
	
	
		
	</div>
</div> 