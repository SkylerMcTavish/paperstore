<?php
global $catalogue;
?>
<!-- Task Type Activities Modal -->
<div id="mdl_frm_ttype_activity" class="modal fade"  role="dialog" aria-labelledby="mdl_frm_ttype_activity" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true" onclick="clean_asgn_task_type_activity();"> &times; </button>
				<h4 id="mdl_frm_ttype_activity_title" class="modal-title">Asignar Actividad a Tipo de Tarea</h4>
			</div>
			<form id="frm_ttype_activity" class="form-horizontal" role="form" method="post" action="admin.activity.php" >
				<div class="modal-body">   
					<fieldset> 
						<div class="form-group">
							<div class="hidden-xs col-sm-1"> &nbsp; </div> 
							<div class="col-xs-12 col-sm-10">
								<label class="control-label">Tipo de Tarea</label>
								<select id="inp_asgn_id_task_type" name="asgn_id_task_type" class="form-control" required onchange="filter_options( 'inp_asgn_id_activity', 'activity', this.value)" >
									<?php echo $catalogue->get_catalgue_options('task_type') ?>
								</select>
								
								<div class="clearfix">&nbsp;</div>
								
								<label class="control-label">Actividad</label>
								<select id="inp_asgn_id_activity" name="asgn_id_activity" class="form-control" required >
									<?php echo $catalogue->get_catalgue_options('activity') ?>
								</select>
								
								<div class="clearfix">&nbsp;</div>
							</div>
						</div>
					</fieldset> 
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal" onclick="clean_asgn_task_type_activity();">
						Cancelar
					</button>
					<button type="button" class="btn btn-default" onclick="set_ttype_activity(); clean_asgn_task_type_activity();" >
						Aceptar
					</button>
				</div>
			</form>
		</div>
	</div>
</div>  