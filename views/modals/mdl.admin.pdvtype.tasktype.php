<?php
global $catalogue;
?>
<!-- PDV Type - Task Type Modal -->
<div id="mdl_frm_pdvtype_ttype" class="modal fade"  role="dialog" aria-labelledby="mdl_frm_pdvtype_ttype" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true" onclick="clean_pdv_task_form();"> &times; </button>
				<h4 id="mdl_frm_pdvtype_ttype_title" class="modal-title">Asignar Tarea a Tipo de PDV</h4>
			</div>
			
				<div class="modal-body">   
					<fieldset> 
						<div class="form-group">
							<div class="hidden-xs col-sm-1"> &nbsp; </div> 
							<div class="col-xs-12 col-sm-10">
								<label class="control-label">Tipo de PDV</label>
								<select id="inp_asgn_id_pdv_type" name="asgn_id_pdv_type" class="form-control" required onchange="filter_options( 'inp_asgn_id_ttype', 'task_type', this.value)" >
									<?php echo $catalogue->get_catalgue_options('pdv_type') ?>
								</select>
								
								<div class="clearfix">&nbsp;</div>
								
								<label class="control-label">Tipo de Tarea</label>
								<select id="inp_asgn_id_ttype" name="asgn_id_ttype" class="form-control" required >
									<?php echo $catalogue->get_catalgue_options('task_type') ?>
								</select>
								
								<div class="clearfix">&nbsp;</div>
							</div>
						</div>
					</fieldset> 
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal" onclick="clean_pdv_task_form();">
						Cancelar
					</button>
					<button type="button" class="btn btn-default" onclick="set_pdv_type_task_type(); clean_pdv_task_form();" >
						Aceptar
					</button>
				</div>

		</div>
	</div>
</div>  