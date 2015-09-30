<?php 
global $Session;
if ( !$Session->is_admin() ){  
	require_once DIRECTORY_VIEWS . "base/403.php";
	die();
}
global $Index;
require_once DIRECTORY_CLASS . "class.admin.lst.php";	
$list = new AdminList( 'lst_invoice' ); 

?>
<script> 
	var command 	= '<?php echo $Index->command;  ?>';
</script>
<div id="dashboard-header" class="row">
	<div class="col-xs-12 ">
		<h2> <i class="fa fa-clipboard"> </i> &nbsp; Facturas </h2> 
	</div>  
</div>
<div id='invoice-content' class='row content-info'> 
	<div class="col-xs-12 col-sm-12">
		<div class='row-fluid'>  
			<div id="dashboard-overview" class="row" style=""> 
				<div class="col-xs-9">
					<h3 id='lbl_table_invoice'> Facturas </h3> 
				</div>
				<div id='fnc_table_invoice' class='col-xs-3 pull-right ' style='padding-top: 15px;'>
					<div class="btn-group pull-right">
						<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
						  <i class="fa fa-plus"></i><span class='hidden-xs hidden-sm' >Factura</span> <span class="caret"></span>
						</button>
						<ul class="dropdown-menu" role="menu">
						  <li><a href="#" title="Crear Factura" onclick='edit_invoice(0);' > Crear Factura </a></li>
						  <li class="divider"></li>
						  <li><a href="#" title="Importar Factura" onclick='load_invoice();' data-target="#mdl_upload_invoice" data-toggle="modal">Importar Facturas</a></li> 
						  <li><a href="uploads/tmpl.invoice_load.csv" title="Descargar Plantilla" target="_blank" > Descargar Plantilla </a></li>  
						</ul>
					</div>
				</div>
				<div class="col-xs-12 col-sm-12" style="min-height: 400px; overflow-x:auto;">
					<table class="table table-striped table-bordered table-hover datatable" id='tbl_invoice'>
						 <?php $list->get_list_html();  ?>
					</table> 
				</div>
			</div> 
			<div class="clearfix"></div>
		</div>
	</div>
</div>