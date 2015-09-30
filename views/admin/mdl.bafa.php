<?php
global $catalogue;
?>
<!-- Channel, Group, Format Forms Modal -->
<!-- Channel -->
<div id="mdl_frm_brand" class="modal fade"  role="dialog" aria-labelledby="mdl_frm_brand" aria-hidden="true">
	<div class="modal-dialog modal-sm">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true" onclick="clean_brand_form();"> &times; </button>
				<h4 id="mdl_frm_brand_title" class="modal-title">Edición de Marca</h4>
			</div>
			<form id="frm_brand" class="form-horizontal" role="form" method="post" action="admin.product.php" >
				<div class="modal-body">   
					<fieldset>  
						<div class="row "> 
							<div class="col-xs-12 ">  
								<div class="input-group">
							      	<span class="input-group-addon">
							        	<input type="radio" id='inp_ba_rival_t' name='rival' value="0" />
							      	</span> <label class='form-control'>Propia</label>
							    </div><!-- /input-group -->
							</div> 
							<div class="col-xs-12 ">  
								<div class="input-group">
							      	<span class="input-group-addon">
							      		<input type="radio" id='inp_ba_rival_f' name='rival' value="1" />
							      	</span> <label class='form-control'>Competencia</label>
							    </div><!-- /input-group -->
							</div>  
						</div> 
						<div class="form-group">
							<div class="hidden-xs col-sm-1"> &nbsp; </div> 
							<div class="col-xs-12 col-sm-10">
								<label class="control-label">Marca</label>
								<input type="text" id="inp_brand" name="brand" class="form-control" value="" required  data-validation="required unique-brand" />
							</div>  
							<div class="hidden-xs col-sm-1"> &nbsp; </div>
						</div>
					</fieldset> 
				</div>
				<div class="modal-footer">
					<input type='hidden' id='inp_id_brand' name='id_brand' 	value='' />
					<input type='hidden' id='inp_action'   name='action'	value='edit_brand' />
					<input type="hidden" name="cb" value="<?php echo $Index->command ?>" />
					<button type="button" class="btn btn-default" data-dismiss="modal" onclick="clean_brand_form();">
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
<div id="mdl_frm_family" class="modal fade"  role="dialog" aria-labelledby="mdl_frm_family" aria-hidden="true">
	<div class="modal-dialog modal-sm">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true" onclick="clean_family_form();"> &times; </button>
				<h4 id="mdl_frm_family_title" class="modal-title">Edición de Familia</h4>
			</div>
			<form id="frm_family" class="form-horizontal" role="form" method="post" action="admin.product.php" >
				<div class="modal-body">   
					<fieldset>
						<div class="form-group row "> 
							<div class="col-xs-12 ">  
								<div class="input-group">
							      	<span class="input-group-addon">
							        	<input type="radio" id='inp_fa_rival_t' name='rival' value="0"  onchange="filter_rivals('inp_fa_rival', 'inp_fa_id_brand' )"/>
							      	</span> <label class='form-control'>Propia</label>
							    </div><!-- input-group -->
							</div> 
							<div class="col-xs-12 ">  
								<div class="input-group">
							      	<span class="input-group-addon">
							      		<input type="radio" id='inp_fa_rival_f' name='rival' value="1" onchange="filter_rivals('inp_fa_rival', 'inp_fa_id_brand' )"/>
							      	</span> <label class='form-control'>Competencia</label>
							    </div><!-- input-group -->
							</div>   
						</div> 
						<div class="form-group">
							<div class="hidden-xs col-sm-1"> &nbsp; </div> 
							<div class="col-xs-12 col-sm-10">
								<label class="control-label">Marca</label>
								<select class="form-control" id="inp_fa_id_brand" name="id_brand" required data-validation="select-option " onchange="filter_options( 'flt_family', 'family', this.value)" >
							<?php 	echo $catalogue->get_catalgue_options( 'brand', 0, 'Elija una opción' ); ?>
								</select>
							</div>  
							<div class="hidden-xs col-sm-1"> &nbsp; </div>
						</div>
						<div class="form-group">
							<div class="hidden-xs col-sm-1"> &nbsp; </div> 
							<div class="col-xs-12 col-sm-10">
								<label class="control-label">Familia</label>
								<input type="text" id="inp_fa_family" name="family" class="form-control" value="" required  data-validation="required unique-family" />
							</div>  
							<div class="hidden-xs col-sm-1"> &nbsp; </div>
						</div>
					</fieldset> 
				</div>
				<div class="modal-footer">
					<input type='hidden' id='inp_id_family' name='id_family' value='' />
					<input type='hidden' id='inp_action'  name='action' value='edit_family' />
					<input type="hidden" name="cb" value="<?php echo $Index->command ?>" />
					<button type="button" class="btn btn-default" data-dismiss="modal" onclick="clean_family_form();">
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
		name : 'unique-brand',
		validatorFunction : function(value, $el, config, language, $form) {
			if (value.length > 5){
				is_unique_brand( value );
				return unique;
			} else 
				return true;
		},
		errorMessage : 'La marca ya existe. ',
		errorMessageKey: 'badChannelUnique'
	});
	
	$.formUtils.addValidator({
		name : 'unique-family',
		validatorFunction : function(value, $el, config, language, $form) {
			if (value.length > 5){
				is_unique_family( value );
				return unique;
			} else 
				return true;
		},
		errorMessage : 'La familia ya existe. ',
		errorMessageKey: 'badFamilyUnique'
	}); 
	
	$.validate({
		form : '#frm_brand',
		language : validate_language 
	});
	$.validate({
		form : '#frm_family',
		language : validate_language 
	}); 
});
</script>