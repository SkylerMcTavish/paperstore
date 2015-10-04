<?php 
global $Session;
if ( !$Session->is_admin() ){  
	require_once DIRECTORY_VIEWS . "base/403.php";
	die();
}
global $Index;
require_once DIRECTORY_CLASS . "class.admin.lst.php";	
$list = new AdminList( 'lst_bar_stock' ); 

?>
<script> 
	var command 	= '<?php echo $Index->command;  ?>';
	var frm_command = '<?php echo PRY_VISIT_FRM ?>';
</script>
<div id="dashboard-header" class="row">
	<div class="col-xs-12 ">
		<h2> <i class="fa fa-thumb-tack"> </i> &nbsp; Mostrador </h2> 
	</div>  
</div>
<div id='visits-content' class='row content-info'> 
	<div class="col-xs-12 col-sm-12">
		<div class='row-fluid'>  
			<div id="dashboard-overview" class="row" style=""> 
				<div class="col-xs-9">
					<h3 id='lbl_table_visits'> Inventario Mostrador </h3> 
				</div>
				<div id='fnc_table_visits' class='col-xs-3 pull-right ' style='padding-top: 15px;'>
					<?php if ( $Session->is_admin() ){ ?> 
						<!-- Single button -->
						<div class="btn-group pull-right">
						  <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
						  	<i class="fa fa-plus"></i><span class='hidden-xs hidden-sm' >Surtimiento</span> <span class="caret"></span>
						  </button>
						  <ul class="dropdown-menu" role="menu">
						    <li><a href="#" title="Surtir Nuevo" onclick='supply_bar_stock(0);' ><i class="fa fa-truck"></i> Surtir Nuevo </a></li>
						  	<li class="divider"></li>
						    <li><a href="#" title="Lista Surtir" onclick='supply_list();' data-target="#mdl_upload_visit" data-toggle="modal">Lista de Surtimiento</a></li>
							<li class="divider"></li>
							<li><a href="#" title="Importar Visitas" onclick='load_products();' data-target="#mdl_upload_product" data-toggle="modal">Importar Productos</a></li> 
						  </ul>
						</div>
						<!--
					<button class="btn btn-default pull-right" type="button" title="Importar Visitas" onclick='load_visits();' data-target="#mdl_frm_visit_load" data-toggle="modal"> 
						<i class="fa fa-plus"></i><span class='hidden-xs hidden-sm' >Importar Visitas</span>
					</button>
					<button class="btn btn-default pull-right" type="button" title="Crear Visita" onclick='edit_visit(0);' > 
						<i class="fa fa-plus"></i><span class='hidden-xs hidden-sm' >Crear Visita</span>
					</button> -->
					<?php } ?>
				</div> 
				<div class="col-xs-12 col-sm-12" style="min-height: 400px; overflow-x:auto;"> 
					<table class="table table-striped table-bordered table-hover datatable" id='tbl_bar_stock'>
						 <?php $list->get_list_html();  ?>
					</table> 
				</div>
			</div> 
			<div class="clearfix"></div>
		</div>
	</div>
</div>