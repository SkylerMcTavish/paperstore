<?php 
global $Session;
if ( !$Session->is_proyect_admin() ){  
	require_once DIRECTORY_VIEWS . "base/403.php";
	die();
} 
require_once DIRECTORY_CLASS . "class.proyect.php";
$id_proyect = $Session->get_proyect(); 
if ( !( $id_proyect > 0 ) ){ 
	$error .= "Proyecto inválido.";
	header( "Location:index.php?command=" . LST_PROYECT . "&err=" . urlencode($error) ); 
}
global $Index; 
$proyect = new Proyect( $id_proyect ); 
require_once DIRECTORY_CLASS . "class.admin.proyect.lst.php";
 
?>
<div id="dashboard-header" class="row">
	<div class="col-xs-12 ">
		<h2> <i class="fa fa-calendar-o"> </i> &nbsp; <?php echo $proyect->proyect ?>: Mayoristas </h2>
	</div>  
</div> 

<div id='users-content' class="row">
	<div class="col-lg-12">
		<section class="panel">
			<div class="panel-heading tab-bg-info " style="padding-bottom: 0;">
				<ul class="nav nav-tabs">
					<li class="active"> <a href="#pry-supplier-lst" data-toggle="tab"> <i class="fa fa-truck "></i> <span class='hidden-xs'>&nbsp;Mayoristas</span> </a> </li>
					<li> <a href="#pry-supplier-asign-lst" data-toggle="tab"> <i class="fa fa-sitemap "></i> <span class='hidden-xs'>&nbsp;Asignaciones</span> </a> </li>
				</ul>
			</div>
			<div class="panel-body">
				<div class="tab-content">
					<!-- pry-usr-lst -->
					<div class="tab-pane active" id="pry-supplier-lst">
						<section class="panel"> 
							<div class="panel-body ">
								<h3>  Mayoristas del Proyecto </h3> 
								<div class='row-fluid'>  
									<div id="proyect-supplier-overview" class="row" style="">  
										<div class="col-xs-12 col-sm-12" style="min-height: 400px; overflow-x:auto;"> 
											<table class="table table-striped table-bordered table-hover datatable" id='tbl_supplier'>
												<?php 
													$list = new AdminProyectList( 'lst_pry_supplier', 'tbl_supplier' );
													$list->get_list_html();  
												?>
											</table> 
										</div>
									</div> 
									<div class="clearfix"></div>
								</div>
							</div>
						</section>
					</div>
					<!-- /pry-usr-lst -->
					<!-- pry-usr-asign-lst -->
					<div class="tab-pane " id="pry-supplier-asign-lst" >
						<section class="panel"> 
							<div class="panel-body ">
							
								<div class="col-xs-6 col-sm-6">
									<h3>  Asignación de Mayoristas </h3> 
								</div>
							
								<div class="col-xs-6 col-sm-6">
									<button class="btn btn-default pull-right" type="button" title="Crear Producto" onclick="asign_all('supplier', true);" > 
										<i class="fa fa-check-square-o"></i> <span class='hidden-xs hidden-sm' >Asignar Todos</span>
									</button>
									
									<button class="btn btn-default pull-right" type="button" title="Crear Producto" onclick="asign_all('supplier', false);" > 
										<i class="fa fa-check-square-o"></i> <span class='hidden-xs hidden-sm' >Desasignar Todos</span>
									</button>
								</div>
								
								
								<div class='row-fluid'>  
									<div id="proyect-supplier-overview" class="row" style="">  
										<div class="col-xs-12 col-sm-12" style="min-height: 400px; overflow-x:auto;"> 
											<table class="table table-striped table-bordered table-hover datatable" id='tbl_supplier_asignation'>
												 <?php 
													$list->set_list( 'lst_pry_supplier_asignation', 'tbl_supplier_asignation' );
													$list->set_select_all_function( 'asign_records', array("'supplier'") );
													$list->get_list_html();  
												?>
											</table> 
										</div>
									</div> 
									<div class="clearfix"></div>
								</div>
							</div>
						</section>
					</div>
					<!-- /pry-usr-lst -->
					
				</div>
			</div>
		</div>
	</div>
</div> 