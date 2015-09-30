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
require_once DIRECTORY_CLASS . "class.admin.proyect.lst.php";
$proyect = new Proyect( $id_proyect ); 
$list = new AdminProyectList( 'lst_pry_free_day' );
?>
<script> 
	var command = '<?php echo $Index->command;  ?>';
	var frm_command = '<?php echo PRY_FRM_FORM ?>';
$(function() {
$( "#inp_day" ).datepicker({dateFormat: "dd-mm-yy"});
});
</script>
<div id="dashboard-header" class="row">
	<div class="col-xs-12 ">
		<h2> <i class="fa fa-film"> </i> &nbsp; <?php echo $proyect->proyect ?>: Días Libres </h2> 
	</div>  
</div>
<div id='forms-content' class='row content-info'> 
	<div class="col-xs-12 col-sm-12">
		<div class='row-fluid'>  
			<div id="dashboard-overview" class="row" style=""> 
				<div class="col-xs-9">
					<h3 id='lbl_table_forms'> Días Libres </h3> 
				</div>
				<div id='fnc_table_forms' class='col-xs-3 pull-right ' style='padding-top: 15px;'> 
					<button class="btn btn-default pull-right" type="button" title="Agregar día" onclick='edit_free_day(0);' data-target="#mdl_frm_form" data-toggle="modal"> 
						<i class="fa fa-plus"></i><span class='hidden-xs hidden-sm' >Agregar día</span>
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

<!-- Type Form Modal  -->
<div id="mdl_free_day" class="modal fade"  role="dialog" aria-labelledby="mdl_free_day" aria-hidden="true">
	<div class="modal-dialog modal-sm">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true" onclick="clean_form();"> &times; </button>
				<h4 id="mdl_frm_form_title" class="modal-title">Días Libres</h4>
			</div> 
			<div class="modal-body" id='detail_form_content'>
			<form id="frm_free_day" class="form-horizontal" role="form" method="post" action="proyect.php" >
				<div class="modal-body">   
					<fieldset>   
						<div class="form-group"> 
							<div class="col-xs-12">
								<label class="control-label">Concepto</label>
								<input type="text" id="inp_free_day" name="free_day" class="form-control" value="" required  data-validation="required unique-day" />
								<label class="control-label">Fecha</label>
								<input type="text" id="inp_day" name="day" class="form-control" value="" />
							</div>  
						</div>  
					</fieldset> 
				</div>
				<div class="modal-footer">
					<input type='hidden' id='inp_id_free_day' name='id_free_day' value='0' />
					<input type='hidden' id='inp_action'  name='action' value='edit_free_day' />
					<button type="button" class="btn btn-default" data-dismiss="modal" >
						<i class="fa fa-times"></i> Cancelar
					</button>
					<button type="submit" class="btn btn-check" >
						<i class="fa fa-save"></i> Aceptar
					</button>
				</div>
			</form>  			
		</div>
	</div>
</div>
 