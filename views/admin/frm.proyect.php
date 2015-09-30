<?php
require_once DIRECTORY_CLASS . "class.proyect.php";
global $Session;
if ( !$Session->is_admin() ){ 
	require_once DIRECTORY_VIEWS . "base/403.php";
	die();
} else { 
	if ( isset( $_GET['idp'] ) && $_GET['idp'] > 0 ){ 
		$id_proyect = $_GET['idp'];	
	} else {
		$id_proyect = 0; 
	}
	$proyect = new Proyect( $id_proyect ); 
?>
<script>
$(document).ready(function() {
	$.validate({
		form : '#frm_proyect',
		language : validate_language 
	});
});
</script>
<div id="section-header" class="row">
	<div class="col-xs-12 ">
		<h2> Edición de Proyecto </h2>
	</div> 
</div>
<div id='form-content' class=' content-info row '> 
	<form id="frm_proyect" class="form-horizontal" role="form" method="post" action="admin.proyect.php" >
	<div class="col-xs-12 col-sm-12">  
		<div class="row "> &nbsp; </div>
		<fieldset class="row">
			<div class="row ">
				<legend class="border-bottom"> Información de Proyecto </legend>
			</div>
			<div class="row ">
				<div class="col-xs-12 col-sm-6">  
					<label>Proyecto: </label> 
					<input type="text" id="inp_proyect" name="proyect" class="form-control"
						data-validation="required" value="<?php echo $proyect->proyect ?>" /> 
				</div>
				<div class="col-xs-12 col-sm-6">  
					<label>Tipo de Proyecto </label> 
					<select class="form-control" id='inp_id_proyect_type' name='id_proyect_type' class="form-control" data-validation="required select-option" >
					<?php echo $catalogue->get_catalgue_options( 'proyect_type', $proyect->id_proyect_type ) ?>
					</select>  
				</div>
			</div>
			<div class="row ">
				<div class="col-xs-12 col-sm-6">  
					<label>Compañía: </label> 
					<select class="form-control" id='inp_id_company' name='id_company' class="form-control" data-validation="required select-option" >
					<?php echo $catalogue->get_catalgue_options( 'company', $proyect->id_company ) ?>
					</select>   
				</div>
				<div class="col-xs-12 col-sm-6">  
					<label>Region: </label> 
					<select id='inp_id_region' name='id_region' class="form-control" data-validation="required select-option" >
					<?php echo $catalogue->get_catalgue_options( 'region', $proyect->id_region ) ?>
					</select>   
				</div>
			</div> 
			<div class="row ">
				<div class="col-xs-12 col-sm-6 col-md-3">  
					<label>Inicio de Jornada: </label> 
					<select id="inp_shift_start" name="shift_start" class="form-control text-center" data-validation="required" >
					<?php 
	            		for ($i=0;$i<24;$i++){
	            			echo "<option value='$i'" . ( $proyect->shift_start == $i ? "selected='selected'" : "") . "> " . $i . ":00 </option>";
	            		}
	            	?>  
	            	</select> 
				</div>
				<div class="col-xs-12 col-sm-6 col-md-3">  
					<label>Fin de Jornada: </label> 
					<select id="inp_shift_end" name="shift_end" class="form-control text-center" data-validation="required" >
					<?php 
	            		for ($i=0;$i<24;$i++){
	            			echo "<option value='$i'" . ( $proyect->shift_end == $i ? "selected='selected'" : "") . "> " . $i . ":00 </option>";
	            		}
	            	?>  
	            	</select> 
				</div>
				
				<div class="col-xs-12 col-sm-6 col-md-3">  
					<label>Visitas al día: </label> 
					<input type="number" id="inp_day_visits" name="day_visits" class="form-control text-center" data-validation="required"
						 value="<?php echo $proyect->day_visits ?>" />
				</div>
				
				<div class="col-xs-12 col-sm-6 col-md-3"> 
					<label >Días Laborales </label>
					<div class='row'> 
						<div class="col-xs-12"> 
							<div class='input-group'>
								<span class='input-group-addon'> 
									<input type='checkbox' name='workdays[]' id='inp_workdays_lu' value='Lu' <?php echo in_array("Lu", $proyect->workdays) ? "checked='checked'" : ""  ?> />  
								</span><label class='form-control'>Lunes</label>
							</div>
							<div class='input-group'>
								<span class='input-group-addon'> 
									<input type='checkbox' name='workdays[]' id='inp_workdays_ma' value='Ma' <?php echo in_array("Ma", $proyect->workdays) ? "checked='checked'" : ""  ?> />  
								</span><label class='form-control'>Martes</label>
							</div>
							<div class='input-group'>
								<span class='input-group-addon'> 
									<input type='checkbox' name='workdays[]' id='inp_workdays_mi'  value='Mi' <?php echo in_array("Mi", $proyect->workdays) ? "checked='checked'" : ""  ?> />  
								</span><label class='form-control'>Miércoles</label>
							</div>
							<div class='input-group'>
								<span class='input-group-addon'> 
									<input type='checkbox' name='workdays[]' id='inp_workdays_ju' value='Ju' <?php echo in_array("Ju", $proyect->workdays) ? "checked='checked'" : ""  ?> />  
								</span><label class='form-control'>Jueves</label>
							</div>
							<div class='input-group'>
								<span class='input-group-addon'> 
									<input type='checkbox' name='workdays[]' id='inp_workdays_vi' value='Vi' <?php echo in_array("Vi", $proyect->workdays) ? "checked='checked'" : ""  ?> />  
								</span><label class='form-control'>Viernes</label>
							</div>
							<div class='input-group'>
								<span class='input-group-addon'> 
									<input type='checkbox' name='workdays[]' id='inp_workdays_sa' value='Sa' <?php echo in_array("Sa", $proyect->workdays) ? "checked='checked'" : ""  ?> />  
								</span><label class='form-control'>Sábado</label>
							</div>
							<div class='input-group'>
								<span class='input-group-addon'> 
									<input type='checkbox' name='workdays[]' id='inp_workdays_do' value='Do' <?php echo in_array("Do", $proyect->workdays) ? "checked='checked'" : ""  ?> />  
								</span><label class='form-control'>Domingo</label>
							</div>
						</div>
					</div>
				</div>
			</div>
		</fieldset>  
		<div class="row "> &nbsp; </div>  
		<div class="row border-top" style="margin: 10px 0;"></div>
		<div class="row ">
			<input type="hidden" name="action" 		value="edit_proyect" />
			<input type="hidden" name="id_proyect" 	id='inp_id_proyect' value="<?php echo $proyect->id_proyect ?>" />
			<input type="hidden" name="cb" 			id='cb'				value="<?php echo isset($_GET['cb']) ? $_GET['cb'] : LST_PROYECT ?>" />
			<button type="reset"  class="btn btn-default" onclick="call_back();"><i class="fa fa-refresh"></i> Cancelar </button>
			<button type="submit" class="btn btn-default pull-right"><i class="fa fa-save"></i> Guardar </button>
		</div>
	</div>
	</form>
</div>
<?php } ?>