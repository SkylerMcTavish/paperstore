<?php
global $catalogue;
?>
<!-- Task Type Modal -->
<div id="mdl_frm_task_type" class="modal fade"  role="dialog" aria-labelledby="mdl_frm_task_type" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true" onclick="clean_task_type_form();"> &times; </button>
				<h4 id="mdl_frm_task_type_title" class="modal-title">Edición de Tipo de Tarea</h4>
			</div>
			<form id="frm_task_type" class="form-horizontal" role="form" method="post" action="admin.task.type.php" >
				<div class="modal-body">   
					<fieldset> 
						<div class="form-group">
							<div class="hidden-xs col-sm-1"> &nbsp; </div> 
							<div class="col-xs-12 col-sm-10">
								<label class="control-label">Tipo de Tarea</label>
								<input type="text" id="inp_task_type" name="task_type" class="form-control" value="" required  data-validation="required unique-task_type" />
								
								<label class="control-label">Descripción</label>
								<textarea id="inp_description" name="description" class="form-control" value="" required style="resize: none"></textarea>
							</div>
						</div>
					</fieldset> 
				</div>
				<div class="modal-footer">
					<input type='hidden' id='inp_id_task_type' name='id_task_type' 	value='' />
					<input type='hidden' id='inp_action'   name='action'	value='edit_task_type' />
					<button type="button" class="btn btn-default" data-dismiss="modal" onclick="clean_task_type_form();">
						Cancelar
					</button>
					<button type="submit" class="btn btn-default">
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
		name : 'unique-task_type',
		validatorFunction : function(value, $el, config, language, $form) {
			if (value.length > 5){
				is_unique_task_type( value );
				return unique;
			} else 
				return true;
		},
		errorMessage : 'El Tipo de Tarea ya existe. ',
		errorMessageKey: 'badTaskTypeUnique'
	});
	
	$.validate({
		form : '#frm_task_type',
		language : validate_language 
	});
});
</script>