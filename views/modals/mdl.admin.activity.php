<?php
global $catalogue;
?>
<!-- Activity Modal -->
<div id="mdl_frm_activity" class="modal fade"  role="dialog" aria-labelledby="mdl_frm_activity" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true" onclick="clean_activity_form();"> &times; </button>
				<h4 id="mdl_frm_activity_title" class="modal-title">Edición de Actividad</h4>
			</div>
			<form id="frm_activity" class="form-horizontal" role="form" method="post" action="admin.activity.php" >
				<div class="modal-body">   
					<fieldset> 
						<div class="form-group">
							<div class="hidden-xs col-sm-1"> &nbsp; </div> 
							<div class="col-xs-12 col-sm-10">
								<label class="control-label">Actividad</label>
								<input type="text" id="inp_activity" name="activity" class="form-control" value="" required  data-validation="required unique-activity" />
								
								<label class="control-label">Tipo de Actividad</label>
								<select id="inp_activity_type_id" name="activity_type_id" class="form-control" value="" required onchange="filter_table_aux()" >
									<?php echo $catalogue->get_catalgue_options('activity_type') ?>
								</select>
								
								<div class="clearfix">&nbsp;</div>
								
								<label class="control-label">Auxiliar</label>
								<select id="inp_activity_aux" name="activity_aux" disabled="disabled" class="form-control" >
									<option value="" disabled>Sin Auxiliar</option>
								</select>
								
								<label class="control-label">Descripción</label>
								<textarea id="inp_activity_description" name="activity_description" class="form-control" style="resize: none" required> </textarea>
								
							</div>
						</div>
					</fieldset> 
				</div>
				<div class="modal-footer">
					<input type='hidden' id='inp_id_activity' name='id_activity' 	value='0' />
					<input type='hidden' id='inp_action'   name='action'	value='edit_activity' />
					<button type="button" class="btn btn-default" data-dismiss="modal" onclick="clean_activity_form();">
						Cancelar
					</button>
					<button type="submit" class="btn btn-default" >
						Aceptar
					</button>
				</div>
			</form>
		</div>
	</div>
</div>  

<script>
	
$(document).ready(function() {
	
	$.formUtils.addValidator({
		name : 'unique-activity',
		validatorFunction : function(value, $el, config, language, $form) {
			if (value.length > 5){
				is_unique_activity( value );
				return unique;
			} else 
				return true;
		},
		errorMessage : 'El Tipo de Actividad ya existe. ',
		errorMessageKey: 'badActivityTypeUnique'
	});
	
	$.validate({
		form : '#frm_activity',
		language : validate_language 
	});
});
</script>