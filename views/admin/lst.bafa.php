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
		<h2> <i class="fa fa-barcode"> </i>&nbsp; Marcas </h2>
	</div> 
</div> 
<div id='pdvs-content' class='row '>
	<div class="col-xs-12 col-sm-12">
	
	<div class='tab-content' id="cont-brand">
		<div class='row-fluid' >
		<?php $list = new AdminList( 'lst_brand' ); ?>
			<div id="pdv_tabs" class="col-xs-12 col-sm-12 tabs-content content-info" style='margin-top: 0;'>
				<div class="row" style="visibility: visible; position: relative;"> 
					<div class="col-xs-9">
						<h3 id='lbl_table_pdvs'> Listado de Marcas </h3> 
					</div>
					<div id='fnc_table_pdvs' class='col-xs-3 pull-right ' style='padding-top: 15px;'> 
						<button class="btn btn-default pull-right" type="button" title="Crear Marca" onclick='edit_brand(0);' > 
							<i class="fa fa-plus"></i> <span class='hidden-xs hidden-sm' >Crear Marca</span>
						</button>
					</div> 
					<div class="col-xs-12 col-sm-12" style="min-height: 400px; overflow-x:auto;"> 
						<table id='tbl_brands' class="table table-striped table-bordered table-hover datatable">
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