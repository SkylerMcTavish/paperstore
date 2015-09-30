<?php
	require_once DIRECTORY_CLASS . "class.admin.lst.php";	
	global $Index; 
	$list = new AdminList( 'lst_channel' ); 
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
		<h2> <i class="fa fa-sitemap"> </i>&nbsp; Canal, Grupo, Formato </h2>
	</div> 
</div> 
<div id='pdvs-content' class='row '>
	<div class="col-xs-12 col-sm-12">
	
	<ul class="nav nav-tabs" role="tablist">
		<li <?php echo ( isset($_GET['tab']) ) ? "" : "class='active'" ?>><a href="#cont-channel" role="tab" data-toggle="tab" onclick="showTab('#cont-channel');">Canal</a></li> 
		<li <?php echo ( isset($_GET['tab']) && $_GET['tab'] == 'gpo' ) ? "class='active'" : "" ?>><a href="#cont-group" role="tab" data-toggle="tab" onclick="showTab('#cont-group');">Grupo</a></li>
		<li <?php echo ( isset($_GET['tab']) && $_GET['tab'] == 'fto' ) ? "class='active'" : "" ?>><a href="#cont-format" role="tab" data-toggle="tab" onclick="showTab('#cont-format');">Formato</a></li>
	</ul> 
	
	<div class='tab-content' id="cont-channel">
		<div class='row-fluid' >
		<?php $list = new AdminList( 'lst_channel' );  ?>
			<div id="pdv_tabs" class="col-xs-12 col-sm-12 tabs-content content-info" style='margin-top: 0;'>
				<div class="row" style="visibility: visible; position: relative;"> 
					<div class="col-xs-9">
						<h3 id='lbl_table_pdvs'> Listado de Canales </h3> 
					</div>
					<div id='fnc_table_pdvs' class='col-xs-3 pull-right ' style='padding-top: 15px;'> 
						<button class="btn btn-default pull-right" type="button" title="Crear PDV" onclick='edit_channel(0);' > 
							<i class="fa fa-plus"></i> <span class='hidden-xs hidden-sm' >Crear Canal</span>
						</button>
					</div> 
					<div class="col-xs-12 col-sm-12" style="min-height: 400px; overflow-x:auto;"> 
						<table id='tbl_channel' class="table table-striped table-bordered table-hover datatable">
							 <?php $list->get_list_html();  ?>
						</table> 
					</div>
				</div>
			</div> 
			<div class="clearfix"></div>
		</div>
	</div>
		
	<div class='tab-content' id="cont-group" style="display: none;">
		<div class='row-fluid' >
		<?php $list = new AdminList( 'lst_group' );  ?>
			<div id="pdv_tabs" class="col-xs-12 col-sm-12 tabs-content content-info" style='margin-top: 0;'>
				<div class="row" style="visibility: visible; position: relative;"> 
					<div class="col-xs-9">
						<h3 id='lbl_table_pdvs'> Listado de Grupos </h3> 
					</div>
					<div id='fnc_table_pdvs' class='col-xs-3 pull-right ' style='padding-top: 15px;'> 
						
						<button class="btn btn-default pull-right" type="button" title="Crear PDV" onclick='edit_group(0);' > 
							<i class="fa fa-plus"></i> <span class='hidden-xs hidden-sm' >Crear Grupo</span>
						</button>
						
					</div> 
					<div class="col-xs-12 col-sm-12" style="min-height: 400px; overflow-x:auto;"> 
						<table id='tbl_channel' class="table table-striped table-bordered table-hover datatable">
							 <?php $list->get_list_html();  ?>
						</table> 
					</div>
				</div>
			</div> 
			<div class="clearfix"></div>
		</div>
	</div>
		
	<div class='tab-content' id="cont-format" style="display: none;">
		<div class='row-fluid'>
		<?php $list = new AdminList( 'lst_format' );  ?>
			<div id="pdv_tabs" class="col-xs-12 col-sm-12 tabs-content content-info" style='margin-top: 0;'>
				<div class="row" style="visibility: visible; position: relative;"> 
					<div class="col-xs-9">
						<h3 id='lbl_table_pdvs'> Listado de Formatos </h3> 
					</div>
					<div id='fnc_table_pdvs' class='col-xs-3 pull-right ' style='padding-top: 15px;'> 
						
						<button class="btn btn-default pull-right" type="button" title="Crear PDV" onclick='edit_format(0);' > 
							<i class="fa fa-plus"></i> <span class='hidden-xs hidden-sm' >Crear Formato</span>
						</button>
						
						
					</div> 
					<div class="col-xs-12 col-sm-12" style="min-height: 400px; overflow-x:auto;"> 
						<table id='tbl_channel' class="table table-striped table-bordered table-hover datatable">
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