<?php
global $catalogue;
?>
<!-- Activity Type Modal -->
<div id="mdl_frm_activity_type" class="modal fade"  role="dialog" aria-labelledby="mdl_frm_activity_type" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true" onclick="clean_activity_type_form();"> &times; </button>
				<h4 id="mdl_frm_activity_type_title" class="modal-title">Edición de Tipo de Actividad</h4>
			</div>
			<form id="frm_activity_type" class="form-horizontal" role="form" method="post" action="admin.activity.php" >
				<div class="modal-body">   
					<fieldset> 
						<div class="form-group">
							<div class="hidden-xs col-sm-1"> &nbsp; </div> 
							<div class="col-xs-12 col-sm-10">
								<label class="control-label">Tipo de Actividad</label>
								<input type="text" id="inp_activity_type" name="activity_type" class="form-control" value="" required  data-validation="required unique-activity_type" />
								
								<label class="control-label">Auxiliar</label>
								<select id="inp_table_aux" name="table_aux" class="form-control" value="" required >
									<option disabled value="" >Elija una Opción</option>
									<option value="" >Sin tabla auxiliar</option>
									<option value="form">Formulario</option>
									<option value="media_file">Archivo de Medios</option>
									<option value="profile">Perfil</option>
									<option value="evidence_type">Tipo de Evidencia</option>
								</select>
							</div>
						</div>
					</fieldset> 
				</div>
				<div class="modal-footer">
					<input type='hidden' id='inp_id_activity_type' name='id_activity_type' 	value='' />
					<input type='hidden' id='inp_action'   name='action'	value='edit_activity_type' />
					<button type="button" class="btn btn-default" data-dismiss="modal" onclick="clean_activity_type_form();">
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
		name : 'unique-activity_type',
		validatorFunction : function(value, $el, config, language, $form) {
			if (value.length > 5){
				is_unique_activity_type( value );
				return unique;
			} else 
				return true;
		},
		errorMessage : 'El Tipo de Actividad ya existe. ',
		errorMessageKey: 'badActivityTypeUnique'
	});
	
	$.validate({
		form : '#frm_activity_type',
		language : validate_language 
	});
});
</script>