<?php
global $catalogue;
?>
<!-- PDV Type Modal -->
<div id="mdl_frm_pdv_type" class="modal fade"  role="dialog" aria-labelledby="mdl_frm_pdv_type" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true" onclick="clean_pdv_type_form();"> &times; </button>
				<h4 id="mdl_frm_pdv_type_title" class="modal-title">Edición de Tipo de PDV</h4>
			</div>
			<form id="frm_pdv_type" class="form-horizontal" role="form" method="post" action="admin.pdv.php" >
				<div class="modal-body">   
					<fieldset> 
						<div class="form-group">
							<div class="hidden-xs col-sm-1"> &nbsp; </div> 
							<div class="col-xs-12 col-sm-10">
								<label class="control-label">Tipo de PDV</label>
								<input type="text" id="inp_pdv_type" name="pdv_type" class="form-control" value="" required  data-validation="required unique-pdv_type" />
							</div>
						</div>
					</fieldset> 
				</div>
				<div class="modal-footer">
					<input type='hidden' id='inp_id_pdv_type' name='id_pdv_type' 	value='' />
					<input type='hidden' id='inp_action'   name='action'	value='edit_pdv_type' />
					<button type="button" class="btn btn-default" data-dismiss="modal" onclick="clean_pdv_type_form();">
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
		name : 'unique-pdv_type',
		validatorFunction : function(value, $el, config, language, $form) {
			if (value.length > 5){
				is_unique_pdv_type( value );
				return unique;
			} else 
				return true;
		},
		errorMessage : 'El Tipo de Tarea ya existe. ',
		errorMessageKey: 'badPDVTypeUnique'
	});
	
	$.validate({
		form : '#frm_pdv_type',
		language : validate_language 
	});
});
</script>