<?php 
require_once DIRECTORY_CLASS . "class.proyect.php";
global $Session;
if ( !$Session->is_proyect_admin() ){  
	require_once DIRECTORY_VIEWS . "base/403.php";
	die();
} else {
	$id_proyect = $Session->get_proyect(); 
	if ( !( $id_proyect > 0 ) ){ 
		$error .= "Proyecto inválido.";
		header( "Location:index.php?command=" . LST_PROYECT . "&err=" . urlencode($error) ); 
	}
	$proyect = new Proyect( $id_proyect ); 
	require_once DIRECTORY_CLASS . "class.admin.proyect.lst.php";
	global $Index; 
	$list = new AdminProyectList( 'lst_pry_cycle' ); 
?>
<script> 
	var command = '<?php echo $Index->command;  ?>';
	$(document).ready(function() {
		$('#inp_from, #inp_to').datepicker({setDate: new Date(), dateFormat: "yy/mm/dd" });
	});
</script>
<div id="dashboard-header" class="row">
	<div class="col-xs-12 ">
		<h2> <i class="fa fa-calendar-o"> </i> &nbsp; <?php echo $proyect->proyect ?>: Cíclos </h2>
	</div>  
</div> 
<div id='cycles-content' class='row content-info'> 
	<div class="col-xs-12 col-sm-12">
		<div class='row-fluid'>  
			<div id="proyect-cycle-overview" class="row" style=""> 
				<div class="col-xs-9">
					<h3 id='lbl_table_cycles'> Cíclos del Proyecto </h3> 
				</div>
				<div id='fnc_table_cycles' class='col-xs-3 pull-right ' style='padding-top: 15px;'> 
					<button class="btn btn-default pull-right" type="button" title="Crear Cíclo" onclick='edit_cycle(0);' data-target="#mdl_frm_cycle" data-toggle="modal"> 
						<i class="fa fa-plus"></i><span class='hidden-xs hidden-sm' >Crear Cíclo</span>
					</button> 
				</div> 
				<div class="col-xs-12 col-sm-12" style="min-height: 400px; overflow-x:auto;"> 
					<table class="table table-striped table-bordered table-hover datatable" id='tbl_cycle'>
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
 
<!-- Cycle Form Modal --> 
<div id="mdl_frm_cycle" class=" modal fade"  role="dialog" aria-labelledby="mdl_frm_cycle" aria-hidden="true">
	<div class="modal-dialog modal-sm">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true" onclick="clean_form();"> &times; </button>
				<h4 id="mdl_frm_cycle_title" class="modal-title">Edición de Cíclo</h4>
			</div>
			<form id="frm_cycle" class="form-horizontal" role="form" method="post" action="admin.proyect.php" >
				<div class="modal-body">   
					<fieldset>   
						<div class="form-group"> 
							<div class="col-xs-12">
								<label class="control-label">Desde</label>
								<input type="text" id="inp_from" name="from" class="form-control" value="" data-validation="inp_from" data-validation-format="dd/mm/yyyy"  />
							</div>  
						</div>  
						<div class="form-group"> 
							<div class="col-xs-12">
								<label class="control-label">Hasta</label>
								<input type="text" id="inp_to" name="to" class="form-control" value="" data-validation="inp_to" data-validation-format="dd/mm/yyyy"  />
							</div>  
						</div>  
					</fieldset> 
				</div>
				<div class="modal-footer"> 
					<input type='hidden' id='inp_action'  	name='action' 	value='edit_cycle' />
					<input type='hidden' id='inp_cb'  		name='cb' 		value='<?php echo PRY_CYCLE ?>' />
					<button type="button" class="btn btn-default" data-dismiss="modal" onclick="cancel_cycle_edition();">
						<i class="fa fa-times"></i> Cancelar
					</button>
					<button type="submit" class="btn btn-check" > <i class="fa fa-save"></i> Aceptar </button>
				</div>
			</form>
		</div>
	</div>
</div>
<?php  }  ?>