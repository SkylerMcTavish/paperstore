<?php 
global $Session;
if ( !$Session->is_proyect_admin() ){  
	require_once DIRECTORY_VIEWS . "base/403.php";
	die();
} 
$id_proyect = $Session->get_proyect(); 
if ( !( $id_proyect > 0 ) ){ 
	$error .= "Proyecto inválido.";
	header( "Location:index.php?command=" . LST_PROYECT . "&err=" . urlencode($error) ); 
}
global $Index; 
require_once DIRECTORY_CLASS . "class.proyect.php";
require_once DIRECTORY_CLASS . "class.admin.proyect.lst.php";
$proyect = new Proyect( $id_proyect ); 
$list = new AdminProyectList( 'lst_pry_form' );
?>
<script> 
	var command = '<?php echo $Index->command;  ?>';
	var frm_command = '<?php echo PRY_FRM_FORM ?>';
</script>
<div id="dashboard-header" class="row">
	<div class="col-xs-12 ">
		<h2> <i class="fa fa-film"> </i> &nbsp; <?php echo $proyect->proyect ?>: Formularios </h2> 
	</div>  
</div>
<div id='forms-content' class='row content-info'> 
	<div class="col-xs-12 col-sm-12">
		<div class='row-fluid'>  
			<div id="dashboard-overview" class="row" style=""> 
				<div class="col-xs-9">
					<h3 id='lbl_table_forms'> Formularios </h3> 
				</div>
				<div id='fnc_table_forms' class='col-xs-3 pull-right ' style='padding-top: 15px;'> 
					<button class="btn btn-default pull-right" type="button" title="Crear Formulario" onclick='edit_form(0);' data-target="#mdl_frm_form" data-toggle="modal"> 
						<i class="fa fa-plus"></i><span class='hidden-xs hidden-sm' >Cargar Formulario</span>
					</button> 
				</div> 
				<div class="col-xs-12 col-sm-12" style="min-height: 400px; overflow-x:auto;"> 
					<table class="table table-striped table-bordered table-hover datatable" id='tbl_form'>
						 <?php $list->get_list_html();  ?>
					</table> 
				</div>
			</div> 
			<div class="clearfix"></div>
		</div>
	</div>
</div>

		</div>
	</div>
</div>

<!-- Media File Detail Modal  -->
<div id="mdl_detail_form" class="modal fade"  role="dialog" aria-labelledby="mdl_detail_form" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true" onclick="clean_form();"> &times; </button>
				<h4 id="mdl_frm_form_title" class="modal-title">Información de Formulario</h4>
			</div> 
			<div class="modal-body" id='detail_form_content'>
				
			</div>  
			<div class="modal-footer">
				<input type='hidden' id='inp_detail_id_form' name='detail_id_form' value='0' />  
				<button type="button" class="btn btn-default" data-dismiss="modal">
					<i class='fa fa-times'></i> &nbsp; Cerrar
				</button>
			</div> 
		</div>
	</div>
</div>
 