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
<script> 
	var id_profile 	=  <?php echo $id_profile ?>;
	var command 	= '<?php echo $Index->command;  ?>';
	var cmd_frm_contact = '<?php echo FRM_CONTACT;  ?>';
</script>
<div id="dashboard-header" class="row">
	<div class="col-xs-12 ">
		<h2> <i class="fa fa-calendar-o"> </i> &nbsp; <?php echo $proyect->proyect ?>: Motivos de Omisión de Tarea </h2>
	</div>  
</div> 

<div id='users-content' class="row">
	<div class="col-lg-12">
		<section class="panel">
			<div class="panel-heading tab-bg-info " style="padding-bottom: 0;">
				<ul class="nav nav-tabs">
					<li class="active"> <a href="#pry-task_ommition-lst" data-toggle="tab"> <i class="fa fa-camera "></i> <span class='hidden-xs'>&nbsp;Motivos de Omisión de Tarea</span> </a> </li>
					<li> <a href="#pry-task_ommition-asign-lst" data-toggle="tab"> <i class="fa fa-sitemap "></i> <span class='hidden-xs'>&nbsp;Asignaciones</span> </a> </li>
				</ul>
			</div>
			<div class="panel-body">
				<div class="tab-content">
					<!-- pry-usr-lst -->
					<div class="tab-pane active" id="pry-task_ommition-lst">
						<section class="panel"> 
							<div class="panel-body ">
								<h3>  Motivos de Omisión de Tarea del Proyecto </h3> 
								<div class='row-fluid'>  
									<div id="proyect-user-overview" class="row" style="">  
										<div class="col-xs-12 col-sm-12" style="min-height: 400px; overflow-x:auto;"> 
											<table class="table table-striped table-bordered table-hover datatable" id='tbl_task_omition'>
												<?php 
													$list = new AdminProyectList( 'lst_pry_task_omition', 'tbl_task_omition' );
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
					<div class="tab-pane " id="pry-task_ommition-asign-lst" >
						<section class="panel"> 
							<div class="panel-body ">
							
								<div class="col-xs-6 col-sm-6">
									<h3>  Asignación de Motivos de Omisión de Tarea </h3> 
								</div>
							
								<div class="col-xs-6 col-sm-6">
									<button class="btn btn-default pull-right" type="button" title="Crear Producto" onclick="asign_all('task_omition', true);" > 
										<i class="fa fa-check-square-o"></i> <span class='hidden-xs hidden-sm' >Asignar Todos</span>
									</button>
									
									<button class="btn btn-default pull-right" type="button" title="Crear Producto" onclick="asign_all('task_omition', false);" > 
										<i class="fa fa-check-square-o"></i> <span class='hidden-xs hidden-sm' >Desasignar Todos</span>
									</button>
								</div>
								
								
								<div class='row-fluid'>  
									<div id="proyect-user-overview" class="row" style="">  
										<div class="col-xs-12 col-sm-12" style="min-height: 400px; overflow-x:auto;"> 
											<table class="table table-striped table-bordered table-hover datatable" id='tbl_task_omition_asignation'>
												 <?php 
													$list->set_list( 'lst_pry_task_omition_asignation', 'tbl_task_omition_asignation' );
													$list->set_select_all_function( 'asign_records', array("'task_omition'") );
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

		</div>
	</div>
</div>

<!-- User Detail Modal  -->
<div id="mdl_detail_user" class="modal fade"  role="dialog" aria-labelledby="mdl_detail_user" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true" onclick="clean_form();"> &times; </button>
				<h4 id="mdl_frm_user_title" class="modal-title">Detalle de Usuario</h4>
			</div> 
			<div class="modal-body" id='detail_user_content'>
				
			</div>  
			<div class="modal-footer">
				<input type='hidden' id='inp_detail_id_user' name='detail_id_user' value='0' />  
				<button type="button" class="btn btn-default" data-dismiss="modal">
					<i class='fa fa-times'></i> &nbsp;Cerrar
				</button>
			</div> 
		</div>
	</div>
</div> 