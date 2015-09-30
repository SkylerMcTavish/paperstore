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
require_once DIRECTORY_CLASS . "class.admin.proyect.supervisor.lst.php";
 
require_once DIRECTORY_CLASS. 'class.admin.proyect.supervisor.php';
?>

<div id="dashboard-header" class="row">
	<div class="col-xs-12 ">
		<h2> <i class="fa fa-calendar-o"> </i> &nbsp; <?php echo $proyect->proyect ?>: Supervisores </h2>
	</div>  
</div> 

<div id='users-content' class="row">
	<div class="col-lg-12">
		<section class="panel">
			<div class="panel-heading tab-bg-info " style="padding-bottom: 0;">
				<ul class="nav nav-tabs">
					<li class="active"> <a href="#pry-pdv-lst" data-toggle="tab"> <i class="fa fa-gavel "></i> <span class='hidden-xs'>&nbsp;Supervisores</span> </a> </li>
					<li> <a href="#pry-pdv-asign-lst" data-toggle="tab"> <i class="fa fa-book "></i> <span class='hidden-xs'>&nbsp;Agenda</span> </a> </li>
				</ul>
			</div>
			<div class="panel-body">
				<div class="tab-content">
					<!-- pry-usr-lst -->
					<div class="tab-pane active" id="pry-pdv-lst">
						<section class="panel"> 
							<div class="panel-body ">
								<h3> Promotores del Supervisor </h3>
								<div class='row-fluid'>  
									<div id="proyect-user-overview" class="row" style="">  
										<div class="col-xs-12 col-sm-12" >
											<label>Supervisor</label>
											<select id="inp_id_supervisor" onchange="load_table_supervisor('tbl_supervisor')">
												<option selected value="0" disabled >Seleccione Supervisor</option>
												<?php
													
													$admin = new ProyectSupervisor( $id_proyect );
													echo $admin->get_supervisor_option_HTML();
												?>
											</select>
										</div>
									</div> 
									<div class="clearfix"></div>
								</div>
								
								<div class='row-fluid'>  
									<div id="proyect-supervisor-overview" class="row" style="display: none;">  
										<div class="col-xs-12 col-sm-12" style="min-height: 400px; overflow-x:auto;"> 
											<table class="table table-striped table-bordered table-hover datatable" id='tbl_supervisor'>
												<?php 
													$list = new AdminProyectSupervisorList( 'lst_pry_supervisor', 'tbl_supervisor' );
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
								<h3> Agenda del Supervisor </h3>
								<div class='row-fluid'>  
									<div id="proyect-user-overview" class="row" style="">  
										<div class="col-xs-12 col-sm-12" >
											<label>Supervisor</label>
											<select id="inp_id_supervisor_agenda" onchange="load_table_agenda('tbl_agenda')">
												<option selected value="0" disabled >Seleccione Supervisor</option>
												<?php
													
													$admin = new ProyectSupervisor( $id_proyect );
													echo $admin->get_supervisor_option_HTML();
												?>
												
											</select>
										</div>
									</div> 
									<div class="clearfix"></div>
								</div>
								
								<div class='row-fluid'>  
									<div id="proyect-agenda-overview" class="row" style="display: none;">  
										<div class="col-xs-12 col-sm-12" style="min-height: 400px; overflow-x:auto;"> 
											<table class="table table-striped table-bordered table-hover datatable" id='tbl_agenda'>
												<?php 
													$list = new AdminProyectSupervisorList( 'lst_pry_agenda', 'tbl_agenda' );
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

<!-- PDV Detail Modal  -->
<div id="mdl_detail_pdv" class="modal fade"  role="dialog" aria-labelledby="mdl_detail_pdv" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true" > &times; </button>
				<h4 id="mdl_frm_pdv_title" class="modal-title">Información de PDV</h4>
			</div> 
			<div class="modal-body" id='detail_pdv_content'>  </div>
			<div class="modal-footer">
				<input type='hidden' id='inp_detail_id_pdv' name='detail_id_pdv' value='0' />  
				<button type="button" class="btn btn-default" data-dismiss="modal">
					<i class='fa fa-times'></i> &nbsp; Cerrar
				</button>
			</div> 
		</div>
	</div>
</div> 

<?php 
include DIRECTORY_VIEWS . 'admin/mdl.cgf.php';
?>