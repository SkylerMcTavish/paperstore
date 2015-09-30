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
<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js"></script>
<script> 
	var command = '<?php echo $Index->command;  ?>';  
	var cmd_frm = '<?php echo FRM_PDV;  ?>';  
	var map;
	var pdv_marker; 
</script>
<style>
	.tabs-links .nav {
	    background-color: #454545;
	}
</style>
<script> 
	var id_profile 	=  <?php echo $id_profile ?>;
	var command 	= '<?php echo $Index->command;  ?>';
	var cmd_frm_contact = '<?php echo FRM_CONTACT;  ?>';
</script>
<div id="dashboard-header" class="row">
	<div class="col-xs-12 ">
		<h2> <i class="fa fa-calendar-o"> </i> &nbsp; <?php echo $proyect->proyect ?>: PDVs </h2>
	</div>  
</div> 

<div id='users-content' class="row">
	<div class="col-lg-12">
		<section class="panel">
			<div class="panel-heading tab-bg-info " style="padding-bottom: 0;">
				<ul class="nav nav-tabs">
					<li class="active"> <a href="#pry-pdv-lst" data-toggle="tab"> <i class="fa fa-bullseye "></i> <span class='hidden-xs'>&nbsp;PDVs</span> </a> </li>
					<li> <a href="#pry-pdv-asign-lst" data-toggle="tab"> <i class="fa fa-sitemap "></i> <span class='hidden-xs'>&nbsp;Asignaciones</span> </a> </li>
					<li> <a href="#pry-pdv-activ-lst" data-toggle="tab"> <i class="fa fa-check-circle "></i> <span class='hidden-xs'>&nbsp;Activaciones</span> </a> </li>  
				</ul>
			</div>
			<div class="panel-body">
				<div class="tab-content">
					<!-- pry-usr-lst -->
					<div class="tab-pane active" id="pry-pdv-lst">
						<section class="panel"> 
							<div class="panel-body ">
								<h3>  PDVs del Proyecto </h3> 
								<div class='row-fluid'>  
									<div id="proyect-user-overview" class="row" style="">  
										<div class="col-xs-12 col-sm-12" style="min-height: 400px; overflow-x:auto;"> 
											<table class="table table-striped table-bordered table-hover datatable" id='tbl_pdv'>
												<?php 
													$list = new AdminProyectList( 'lst_pry_pdv', 'tbl_pdv' );
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
					<div class="tab-pane " id="pry-pdv-asign-lst" >
						<section class="panel"> 
							<div class="panel-body ">
							
								<div class="col-xs-6 col-sm-6">
									<h3>  Asignación de PDVs </h3> 
								</div>
							
								<div class="col-xs-6 col-sm-6">
									<button class="btn btn-default pull-right" type="button" title="Crear Producto" onclick="asign_all('pdv', true);" > 
										<i class="fa fa-check-square-o"></i> <span class='hidden-xs hidden-sm' >Asignar Todos</span>
									</button>
									
									<button class="btn btn-default pull-right" type="button" title="Crear Producto" onclick="asign_all('pdv', false);" > 
										<i class="fa fa-check-square-o"></i> <span class='hidden-xs hidden-sm' >Desasignar Todos</span>
									</button>
								</div>
								
								
								<div class='row-fluid'>  
									<div id="proyect-pdv-overview" class="row" style="">  
										<div class="col-xs-12 col-sm-12" style="min-height: 400px; overflow-x:auto;"> 
											<table class="table table-striped table-bordered table-hover datatable" id='tbl_pdv_asignation'>
												 <?php 
													$list->set_list( 'lst_pry_pdv_asignation', 'tbl_pdv_asignation' );
													$list->set_select_all_function( 'asign_records', array("'pdv'") );
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
					<!-- pry-usr-activation-lst -->
					<div class="tab-pane " id="pry-pdv-activ-lst" >
						<section class="panel"> 
							<div class="panel-body ">
							
								<div class="col-xs-6 col-sm-6">
									<h3>  Activación de PDVs </h3>
								</div>
							
								<div class="col-xs-6 col-sm-6">
									<button class="btn btn-default pull-right" type="button" title="Crear Producto" onclick="activate_all('pdv', true);" > 
										<i class="fa fa-check-square-o"></i> <span class='hidden-xs hidden-sm' >Activar Todos</span>
									</button>
									<button class="btn btn-default pull-right" type="button" title="Crear Producto" onclick="activate_all('pdv', false);" > 
										<i class="fa fa-check-square-o"></i> <span class='hidden-xs hidden-sm' >Desactivar Todos</span>
									</button>
								</div>
								
								<div class='row-fluid'>  
									<div id="proyect-pdv-overview" class="row" style="">  
										<div class="col-xs-12 col-sm-12" style="min-height: 400px; overflow-x:auto;"> 
											<table class="table table-striped table-bordered table-hover datatable" id='tbl_pdv_activation'>
												 <?php 
													$list->set_list( 'lst_pry_pdv_activation', 'tbl_pdv_activation' );
													$list->set_select_all_function( 'activate_records', array("'pdv'") );
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
					<!-- /pry-usr-activation-lst -->
				</div>
			</div>
		</div>
	</div>
</div>  