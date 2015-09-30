<?php 
require_once DIRECTORY_CLASS . "class.admin.lst.php";	
global $Index; 
$list = new AdminList( 'lst_prospect' ); 
?>
<script> 
	var command = '<?php echo $Index->command;  ?>';
</script>
<style>
	.tabs-links .nav { background-color: #454545; }
</style>
<div id="dashboard-header" class="row">
	<div class="col-xs-12 ">
		<h2> <i class="fa fa-tag"> </i>&nbsp; Prospectos </h2>
	</div> 
</div> 
<div id='prospects-content' class='row '>
	<div class="col-xs-12 col-sm-12">
		<div class='row-fluid'> 
			<div id="prospect_tabs" class="col-xs-12 col-sm-12  content-info" style='margin-top: 0;'>
				<div class="row" style="visibility: visible; position: relative;"> 
					<div class="col-xs-9">
						<h3 id='lbl_table_prospects'> Listado de Prospectos </h3> 
					</div>
					<div id='fnc_table_prospects' class='col-xs-3 pull-right ' style='padding-top: 15px;'>
						<button type="button" class="btn btn-default" onclick="export_table_xls('lst_prospect');" >
							<i class="fa fa-download"></i><span class='hidden-xs hidden-sm' >Exportar Prospectos</span>
						</button>  
					</div> 
					<div class="col-xs-12 col-sm-12" style="min-height: 400px; overflow-x:auto;"> 
						<table id='tbl_prospect' class="table table-striped table-bordered table-hover datatable">
							 <?php $list->get_list_html();  ?>
						</table> 
					</div>
				</div>
			</div> 
			<div class="clearfix"></div>
		</div>
	</div>
</div> 