<?php
	require_once DIRECTORY_CLASS . "class.admin.lst.php";	
	global $Index; 
	$list = new AdminList( 'lst_activity' ); 
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
		<h2> <i class="fa fa-barcode"> </i>&nbsp; Actividades </h2>
	</div> 
</div> 
<div id='pdvs-content' class='row '>
	<div class="col-xs-12 col-sm-12">
	
	<ul class="nav nav-tabs" role="tablist">
		<li <?php echo ( isset($_GET['tab']) ) ? "" : "class='active'" ?>><a href="#cont-activities" role="tab" data-toggle="tab" onclick="showTab('#cont-activities');">Actividades</a></li> 
		<li <?php echo ( isset($_GET['tab']) && $_GET['tab'] == 'actype' ) ? "class='active'" : "" ?>><a href="#cont-activities" role="tab" data-toggle="tab" onclick="showTab('#cont-activity_type');">Tipos de Actividades</a></li> 
	</ul> 
	
	<div class='tab-content' id="cont-activities" <?php echo ( isset($_GET['tab']) ) ? 'style="display: none"' : ""  ?> >
		<div class='row-fluid' >
		<?php $list = new AdminList( 'lst_activity' ); ?>
			<div id="activity_tabs" class="col-xs-12 col-sm-12 tabs-content content-info" style='margin-top: 0;'>
				<div class="row" style="visibility: visible; position: relative;"> 
					<div class="col-xs-9">
						<h3 id='lbl_table_activities'> Actividades </h3> 
					</div>
					<div id='fnc_table_pdvs' class='col-xs-3 pull-right ' style='padding-top: 15px;'> 
						<button class="btn btn-default pull-right" type="button" title="Crear Actividad" onclick='edit_activity(0);' > 
							<i class="fa fa-plus"></i> <span class='hidden-xs hidden-sm' >Crear Actividad</span>
						</button>
					</div> 
					<div class="col-xs-12 col-sm-12" style="min-height: 400px; overflow-x:auto;"> 
						<table id='tbl_activities' class="table table-striped table-bordered table-hover datatable">
							 <?php $list->get_list_html();  ?>
						</table> 
					</div>
				</div>
			</div> 
			<div class="clearfix"></div>
		</div>
	</div>
	
	<div class='tab-content' id="cont-activity_type" <?php echo ( isset($_GET['tab']) && $_GET['tab'] == 'actype' ) ? "" : 'style="display: none"' ?>>
		<div class='row-fluid' >
		<?php $list = new AdminList( 'lst_activity_type' ); ?>
			<div id="activity_type_tabs" class="col-xs-12 col-sm-12 tabs-content content-info" style='margin-top: 0;'>
				<div class="row" style="visibility: visible; position: relative;"> 
					<div class="col-xs-9">
						<h3 id='lbl_table_activity_type'> Tipos de Actividad </h3> 
					</div>
					<div id='fnc_table_activity_type' class='col-xs-3 pull-right ' style='padding-top: 15px;'> 
						<button class="btn btn-default pull-right" type="button" title="Crear Tipo de Actividad" onclick='edit_activity_type(0);' > 
							<i class="fa fa-plus"></i> <span class='hidden-xs hidden-sm' >Crear Tipo de actividad</span>
						</button>
					</div> 
					<div class="col-xs-12 col-sm-12" style="min-height: 400px; overflow-x:auto;"> 
						<table id='tbl_activity_type' class="table table-striped table-bordered table-hover datatable">
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