<?php
global $catalogue;
?>
<!-- Channel, Group, Format Forms Modal -->
<!-- Channel -->
<div id="mdl_frm_channel" class="modal fade"  role="dialog" aria-labelledby="mdl_frm_channel" aria-hidden="true">
	<div class="modal-dialog modal-sm">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true" onclick="clean_channel_form();"> &times; </button>
				<h4 id="mdl_frm_channel_title" class="modal-title">Edición de Canal</h4>
			</div>
			<form id="frm_channel" class="form-horizontal" role="form" method="post" action="pdv.php" >
				<div class="modal-body">   
					<fieldset>  
						<div class="form-group">
							<div class="hidden-xs col-sm-1"> &nbsp; </div> 
							<div class="col-xs-12 col-sm-10">
								<label class="control-label">Canal</label>
								<input type="text" id="inp_channel" name="channel" class="form-control" value="" required  data-validation="required unique-channel" />
							</div>  
							<div class="hidden-xs col-sm-1"> &nbsp; </div>
						</div>
					</fieldset> 
				</div>
				<div class="modal-footer">
					<input type='hidden' id='inp_id_channel' name='id_channel' value='' />
					<input type='hidden' id='inp_action'  name='action' value='edit_channel' />
					<input type="hidden" name="cb" value="<?php echo $Index->command ?>" />
					<button type="button" class="btn btn-default" data-dismiss="modal" onclick="clean_channel_form();">
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

<!--  Group  -->
<div id="mdl_frm_group" class="modal fade"  role="dialog" aria-labelledby="mdl_frm_group" aria-hidden="true">
	<div class="modal-dialog modal-sm">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true" onclick="clean_group_form();"> &times; </button>
				<h4 id="mdl_frm_group_title" class="modal-title">Edición de Grupo</h4>
			</div>
			<form id="frm_group" class="form-horizontal" role="form" method="post" action="pdv.php" >
				<div class="modal-body">   
					<fieldset>  
						<div class="form-group">
							<div class="hidden-xs col-sm-1"> &nbsp; </div> 
							<div class="col-xs-12 col-sm-10">
								<label class="control-label">Canal</label>
								<select class="form-control" id="inp_gr_id_channel" name="id_channel" required  data-validation="select-option " onchange="filter_options( 'flt_group', 'group', this.value)" >
							<?php 	echo $catalogue->get_catalgue_options( 'channel', 0  ); ?>
								</select>
							</div>  
							<div class="hidden-xs col-sm-1"> &nbsp; </div>
						</div>
						<div class="form-group">
							<div class="hidden-xs col-sm-1"> &nbsp; </div> 
							<div class="col-xs-12 col-sm-10">
								<label class="control-label">Grupo</label>
								<input type="text" id="inp_gr_group" name="group" class="form-control" value="" required  data-validation="required unique-group" />
							</div>  
							<div class="hidden-xs col-sm-1"> &nbsp; </div>
						</div>
					</fieldset> 
				</div>
				<div class="modal-footer">
					<input type='hidden' id='inp_id_group' name='id_group' value='' />
					<input type='hidden' id='inp_action'  name='action' value='edit_group' />
					<input type="hidden" name="cb" value="<?php echo $Index->command ?>" />
					<button type="button" class="btn btn-default" data-dismiss="modal" onclick="clean_group_form();">
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

<!-- Format -->
<div id="mdl_frm_format" class="modal fade"  role="dialog" aria-labelledby="mdl_frm_format" aria-hidden="true">
	<div class="modal-dialog modal-sm">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true" onclick="clean_format_form();"> &times; </button>
				<h4 id="mdl_frm_format_title" class="modal-title">Edición de Formato</h4>
			</div>
			<form id="frm_format" class="form-horizontal" role="form" method="post" action="pdv.php" >
				<div class="modal-body">   
					<fieldset>  
						<div class="form-group">
							<div class="hidden-xs col-sm-1"> &nbsp; </div> 
							<div class="col-xs-12 col-sm-10">
								<label class="control-label">Canal</label>
								<select class="form-control" id="inp_fo_id_channel" name="id_channel" required  data-validation="select-option " onchange="filter_options( 'inp_fo_id_group', 'group', this.value)" >
							<?php 	echo $catalogue->get_catalgue_options( 'channel', 0  ); ?>
								</select>
							</div>  
							<div class="hidden-xs col-sm-1"> &nbsp; </div>
						</div>
						<div class="form-group">
							<div class="hidden-xs col-sm-1"> &nbsp; </div> 
							<div class="col-xs-12 col-sm-10">
								<label class="control-label">Grupo</label>
								<select class="form-control" id="inp_fo_id_group" name="id_group" required  data-validation="select-option "  >
							<?php 	echo $catalogue->get_catalgue_options( 'group', 0  ); ?>
								</select>
							</div>  
							<div class="hidden-xs col-sm-1"> &nbsp; </div>
						</div>
						<div class="form-group">
							<div class="hidden-xs col-sm-1"> &nbsp; </div> 
							<div class="col-xs-12 col-sm-10">
								<label class="control-label">Formato</label>
								<input type="text" id="inp_fo_format" name="format" class="form-control" value="" required  data-validation="required unique-format" />
							</div>  
							<div class="hidden-xs col-sm-1"> &nbsp; </div>
						</div>
					</fieldset> 
				</div>
				<div class="modal-footer">
					<input type='hidden' id='inp_id_format' name='id_format' value='' />
					<input type='hidden' id='inp_action'  name='action' value='edit_format' />
					<input type="hidden" name="cb" value="<?php echo $Index->command ?>" />
					<button type="button" class="btn btn-default" data-dismiss="modal" onclick="clean_format_form();">
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
		name : 'unique-channel',
		validatorFunction : function(value, $el, config, language, $form) {
			if (value.length > 5){
				is_unique_channel( value );
				return unique;
			} else 
				return true;
		},
		errorMessage : 'El canal ya existe. ',
		errorMessageKey: 'badChannelUnique'
	});
	
	$.formUtils.addValidator({
		name : 'unique-group',
		validatorFunction : function(value, $el, config, language, $form) {
			if (value.length > 5){
				is_unique_group( value );
				return unique;
			} else 
				return true;
		},
		errorMessage : 'El grupo ya fue asignado. ',
		errorMessageKey: 'badGroupUnique'
	});
	
	$.formUtils.addValidator({
		name : 'unique-format',
		validatorFunction : function(value, $el, config, language, $form) {
			if (value.length > 5){
				is_unique_format( value );
				return unique;
			} else 
				return true;
		},
		errorMessage : 'El formato ya fue asignado. ',
		errorMessageKey: 'badFormatUnique'
	});
	
	$.validate({
		form : '#frm_channel',
		language : validate_language 
	});
	$.validate({
		form : '#frm_group',
		language : validate_language 
	});
	$.validate({
		form : '#frm_format',
		language : validate_language 
	}); 
});
</script>