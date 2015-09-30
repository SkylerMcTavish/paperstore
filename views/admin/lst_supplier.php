<?php 
require_once DIRECTORY_CLASS . "class.admin.lst.php";	
global $Index; 
$list = new AdminList( 'lst_supplier' ); 
?>
<script> 
	var command = '<?php echo $Index->command;  ?>';  
</script>
<div id="dashboard-header" class="row">
	<div class="col-xs-12 ">
		<h2> Mayoristas </h2>
	</div>  
</div> 
<div id='suppliers-content' class='row content-info'> 
	<div class="col-xs-12 col-sm-12">
		<div class='row-fluid'>  
			<div id="dashboard-overview" class="row" style=""> 
				<div class="col-xs-9">
					<h3 id='lbl_table_suppliers'> Listado de Mayoristas </h3> 
				</div>
				<div id='fnc_table_suppliers' class='col-xs-3 pull-right ' style='padding-top: 15px;'> 
					<button class="btn btn-default pull-right" type="button" title="Crear Mayorista" onclick='edit_supplier(0);' data-target="#mdl_frm_supplier" data-toggle="modal"> 
						<i class="fa fa-plus"></i><span class='hidden-xs hidden-sm' >Crear Mayorista</span>
					</button> 
				</div> 
				<div class="col-xs-12 col-sm-12" style="min-height: 400px; overflow-x:auto;"> 
					<table class="table table-striped table-bordered table-hover datatable" id='tbl_supplier'>
						 <?php $list->get_list_html();  ?>
					</table> 
				</div>
			</div> 
			<div class="clearfix"></div>
		</div>
	</div>
</div>