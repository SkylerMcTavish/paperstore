<?php
global $Session;
if ( !$Session->is_admin() ){
	require_once DIRECTORY_VIEWS . "base/403.php";
} else { 
	require_once DIRECTORY_CLASS . "class.pdv.php";
	if ( isset( $_GET['pdv'] ) && $_GET['pdv'] > 0 ){ 
		$id_pdv = $_GET['pdv'];	
	} else {
		$id_pdv = 0; 
	}  
	$pdv = new PDV( $id_pdv );
?>
<!-- Mapa -->
<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js"></script>
<script type="text/javascript" >
	
	var map;
	var pdv_marker;
	var ini_lat = <?php echo $pdv->latitude  != '' ? $pdv->latitude  :  19.432611 ?>;
	var ini_lng = <?php echo $pdv->longitude != '' ? $pdv->longitude : -99.133211 ?>; 
    
	var unique_pdv;
	var unique_viamente; 
    
var unique;
$(document).ready(function() {
	$.formUtils.addValidator({
		name : 'unique-pdv',
		validatorFunction : function(value, $el, config, language, $form) {
			if (value.length > 3){				
				is_unique(value);				
				return unique;
			} else 
				return true;
		},
		errorMessage : 'El pdv ya existe. ',
		errorMessageKey: 'badPDVUnique'
	});
	
	$.formUtils.addValidator({
		name : 'unique-viamente',
		validatorFunction : function(value, $el, config, language, $form) {
			if (value.length > 3){
				is_unique_viamente( value );
				return unique;
			} else 
				return true;
		},
		errorMessage : 'El id viamente ya fue asignado. ',
		errorMessageKey: 'badViamenteUnique'
	});
	
	$.validate({
		form : '#frm_pdv',
		language : validate_language 
	});
	
	initialize_frm_map();
	
	$('#inp_dr_birthdate').datepicker({setDate: new Date()});
});
</script>
<div id="section-header" class="row">
	<div class="col-xs-12 ">
		<h2> Edición de Punto de Visita </h2>
	</div> 
</div>
<div id='form-content' class=' content-info row '> 
	<form id="frm_pdv" class="form-horizontal" role="form" method="post" action="pdv.php" >
	<div class="col-xs-12 col-sm-12">  
		<div class="row "> &nbsp; </div>
		<fieldset class="row">
			<div class="row ">
				<legend class="border-bottom"> Información de Punto de Visita </legend>
			</div>
			<div class="row ">
				<div class="col-xs-12 col-sm-6">  
					<label>Nombre: </label> 
					<input type="text" id="inp_name" name="name" class="form-control" maxlength="60"
						data-validation="required unique-pdv" value="<?php echo $pdv->name ?>" /> 
				</div>
				<div class="col-xs-12 col-sm-6">  
					<label>Tipo de Punto de Visita </label> 
					<select class="form-control" id='inp_id_pdv_type' name='id_pdv_type' class="form-control" 
						data-validation="required select-option" >
					<?php echo $catalogue->get_catalgue_options( 'pdv_type', $pdv->id_pdv_type ) ?>
					</select>  
				</div>
			</div>
			<div class="row ">
				<div class="col-xs-12 col-sm-6">  
					<label>JDE: </label> 
					<input type="text" id="inp_jde" name="jde" class="form-control" maxlength="45"
						data-validation="unique-viamente" value="<?php echo $pdv->jde ?>" />  
				</div>
				<div class="col-xs-12 col-sm-6">  
					<label>Ruta: </label> 
					<input type="text" id="inp_route" name="route" class="form-control" maxlength="24"
						data-validation=" " value="<?php echo $pdv->route ?>" />   
				</div>
			</div> 
			<div class="row ">
				<div class="col-xs-6 col-sm-4">  
					<label>Canal: </label> 
					<select id='inp_id_channel' name='id_channel' class="form-control" 
						data-validation="select-option " onchange="filter_options('inp_id_group',  'group',this.value );" >
					<?php echo $catalogue->get_catalgue_options( 'channel', $pdv->id_channel ) ?>
					</select>  
				</div>
				<div class="col-xs-6 col-sm-4">  
					<label>Grupo: </label> 
					<select id='inp_id_group' name='id_group'  class="form-control"
						 data-validation="select-option " onchange="filter_options('inp_id_format',  'format',this.value );" > 
					<?php echo $catalogue->get_catalgue_options( 'group', $pdv->id_group ) ?>
					</select>  
				</div>
				<div class="col-xs-6 col-sm-4">  
					<label>Formato: </label> 
					<select id='inp_id_format' name='id_format'  class="form-control"
						 data-validation="select-option "  >
					<?php echo $catalogue->get_catalgue_options( 'format', $pdv->id_format ) ?>
					</select>  
				</div>
			</div> 
			<div class="row ">&nbsp;</div>
			<div class="row ">&nbsp;</div>
			<div class="row">
				<fieldset class="col-xs-12">
					<legend> Contacto </legend>
					<div class="row">
						<div class="col-xs-12">
							<div class="form-group">
								<div class="col-xs-12 ">  
									<label>Razón Social: </label> 
									<input type="text" id="inp_business_name" name="business_name" class="form-control" maxlength="120"
										data-validation="required" value="<?php echo $pdv->contact->business_name ?>" />   
								</div> 
							</div>  
						</div>
					</div> 
					<div class="row ">
						<div class="col-xs-12 col-sm-6">  
							<div class="form-group">
								<div class="col-xs-12 ">  
									<label>RFC: </label> 
									<input type="text" id="inp_rfc" name="rfc" class="form-control" maxlength="18"
										data-validation="" value="<?php echo $pdv->contact->rfc ?>" />   
								</div> 
							</div>  
						</div>
						<div class="col-xs-12 col-sm-6">  
							<div class="form-group">
								<div class="col-xs-12 ">  
									<label>E-mail: </label> 
									<input type="email" id="inp_email" name="email" class="form-control" maxlength="40"
										data-validation="" value="<?php echo $pdv->contact->email ?>" />     
								</div>  
							</div>
						</div>
					</div> 
					<div class="row "> 
						<div class="col-xs-12 col-sm-6">  
							<div class="form-group">
								<div class="col-xs-12 ">  
									<label>Teléfono 1: </label> 
									<input type="text" id="inp_phone_1" name="phone_1" class="form-control" maxlength="20"
										data-validation="" value="<?php echo $pdv->contact->phone_1 ?>" />     
								</div>  
							</div>
						</div> 
						<div class="col-xs-12 col-sm-6">  
							<div class="form-group">
								<div class="col-xs-12 ">  
									<label>CURP: </label> 
									<input type="text" id="inp_phone_2" name="phone_2" class="form-control" maxlength="20"
										data-validation="" value="<?php echo $pdv->contact->curp ?>" />     
								</div>  
							</div>
						</div>
					</div>
				</fieldset>
			</div>
			<div class="row ">&nbsp;</div>
			<div class="row ">&nbsp;</div>
			<div class="row">
				<fieldset title="Dirección" class="col-xs-12">
					<legend> Dirección </legend> 
					<div class="row">
						<div class="col-xs-12 col-sm-6">
							<div class="form-group">
								<div class="col-xs-12 ">  
									<label>Calle: </label> 
									<input type="text" id="inp_street" name="street" class="form-control" maxlength="120"
										data-validation="required" value="<?php echo $pdv->address->street ?>" />   
								</div> 
							</div>  
							<div class="form-group"> 
								<div class="col-xs-6 ">
									<label>Num. Ext: </label> 
									<input type="text" id="inp_ext_num" name="ext_num" class="form-control" maxlength="20"
										data-validation="required" value="<?php echo $pdv->address->ext_num ?>" />   
								</div> 
								<div class="col-xs-6 ">
									<label>Num. Int: </label> 
									<input type="text" id="inp_int_num" name="int_num" class="form-control" maxlength="20"
										data-validation="" value="<?php echo $pdv->address->int_num ?>" />   
								</div> 
							</div>  
							<div class="form-group">
								<div class="col-xs-12 ">  
									<label>Colonia: </label> 
									<input type="text" id="inp_district" name="district" class="form-control" maxlength="120"
										data-validation="required" value="<?php echo $pdv->address->district ?>" />   
								</div> 
							</div> 
							
							<div class="form-group">
								<div class="col-xs-12">  
									<label>Municipio/Delegación: </label> 
									<input type="text" id="inp_locality" name="locality" class="form-control" maxlength="64"
										data-validation="required" value="<?php echo $pdv->address->locality ?>" />   
								</div> 
							</div> 
							<div class="form-group">
								<div class="col-xs-6">  
									<label>C.P.: </label> 
									<input type="text" id="inp_zipcode" name="zipcode" class="form-control" maxlength="5"
										data-validation="required number" data-validation-allowing="range[1;99999]" 
										value="<?php echo $pdv->address->zipcode ?>" />   
								</div>  
							</div> 
							<div class="form-group">
								<!--<div class="col-xs-12 ">  
									<label>Paìs: </label> 
									<select class="form-control" id='inp_id_country' name='id_country' class="form-control" 
										data-validation="required select-option" onchange="filter_state(this)" >
									<?php // echo $catalogue->get_catalgue_options( 'country', $pdv->address->id_country ) ?>
									</select>    
								</div> 
								-->
							</div>  
							<div class="form-group">
								<div class="col-xs-12 ">  
									<label>Estado: </label> 
									<select class="form-control" id='inp_id_state' name='id_state' class="form-control" 
										data-validation="required select-option" >
									<?php echo $catalogue->get_catalgue_options( 'state', $pdv->address->id_state, 'Elija una opción' ) ?>
									</select>
								</div> 
							</div> 
							<div class="form-group">
								<div class="col-xs-12 ">  
									<label>Ciudad: </label> 
									<select class="form-control" id='inp_id_city' name='id_city' class="form-control" 
										data-validation="required select-option" >
									<?php echo $catalogue->get_catalgue_options( 'city', $pdv->address->city_code, 'Elija una opción' ) ?>
									</select>
								</div> 
							</div> 
						</div>
						<div class="col-xs-12 col-sm-6">
							<div class="form-group"> 
								<div class="col-xs-6  ">
									<label>Latitud: </label> 
									<input type="text" id="inp_latitude" name="latitude" class="form-control" 
										data-validation="float" value="<?php echo $pdv->latitude ?>" />   
								</div> 
								<div class="col-xs-6 ">
									<label>Longitud: </label> 
									<input type="text" id="inp_longitude" name="longitude" class="form-control" 
										data-validation="float" value="<?php echo $pdv->longitude ?>" />   
								</div> 
							</div>  
							 
							<div class="col-xs-12 ">  
								<div id="map-pdv" style="min-height:300px;"></div> 
							</div>
							
						</div>
					</div>
				</fieldset>
			</div>
			<div class="row ">&nbsp;</div>
			<div class="row ">&nbsp;</div>
			<div class="row">
				<fieldset class="col-xs-12">
					<legend> Horario </legend>
					<div class="row">
						<div class="col-xs-6">
							
							<div class="form-group">
								<div class="col-xs-12 ">  
									<label>Frecuencia de Visita: </label>
									<select class="form-control" id='inp_id_frequency' name='id_frequency' class="form-control" 
										data-validation="required select-option" >
									<?php echo $catalogue->get_catalgue_options( 'frequency', $pdv->schedule->id_frequency ) ?>
									</select>     
								</div> 
							</div> 
							<div class="form-group">
								<div class="col-xs-12 ">  
									<label>Horario de: </label> 
									<select id="inp_schedule_from" name="schedule_from" class="form-control text-center" data-validation="required" >
								<?php	for ($i=0;$i<24;$i++){
					            			echo "<option value='$i'" . ( $pdv->schedule->schedule_from == $i ? "selected='selected'" : "") . "> " . $i . ":00 </option>";
					            		}
					            ?>  
					            	</select>      
								</div>  
							</div> 
							<div class="form-group">
								<div class="col-xs-12 ">  
									<label>Horario a: </label> 
									<select id="inp_schedule_to" name="schedule_to" class="form-control text-center" data-validation="required" >
								<?php	for ($i=0;$i<24;$i++){
					            			echo "<option value='$i'" . ( $pdv->schedule->schedule_to == $i ? "selected='selected'" : "") . "> " . $i . ":00 </option>";
					            		}
					            ?>  
					            	</select>       
								</div>  
							</div>
							
						</div>
						<div class="col-xs-6"> 
							<div class="form-group">
								<div class="col-xs-12 ">  
									<label>Días Laborales: </label> 
									<div class='row'> 
										<div class="col-xs-12"> 
											<div class='input-group'>
												<span class='input-group-addon'> 
													<input type='checkbox' name='weekdays[]' id='inp_weekdays_lu'
														value='Lu' <?php echo in_array("Lu", $pdv->schedule->weekdays) ? "checked='checked'" : ""  ?> />  
												</span><label class='form-control'>Lunes</label>
											</div>
											<div class='input-group'>
												<span class='input-group-addon'> 
													<input type='checkbox' name='weekdays[]' id='inp_weekdays_ma'
														value='Ma' <?php echo in_array("Ma", $pdv->schedule->weekdays) ? "checked='checked'" : ""  ?> />  
												</span><label class='form-control'>Martes</label>
											</div>
											<div class='input-group'>
												<span class='input-group-addon'> 
													<input type='checkbox' name='weekdays[]' id='inp_weekdays_mi'
														value='Mi' <?php echo in_array("Mi", $pdv->schedule->weekdays) ? "checked='checked'" : ""  ?> />  
												</span><label class='form-control'>Miércoles</label>
											</div>
											<div class='input-group'>
												<span class='input-group-addon'> 
													<input type='checkbox' name='weekdays[]' id='inp_weekdays_ju'
														value='Ju' <?php echo in_array("Ju", $pdv->schedule->weekdays) ? "checked='checked'" : ""  ?> />  
												</span><label class='form-control'>Jueves</label>
											</div>
											<div class='input-group'>
												<span class='input-group-addon'> 
													<input type='checkbox' name='weekdays[]' id='inp_weekdays_vi'
														value='Vi' <?php echo in_array("Vi", $pdv->schedule->weekdays) ? "checked='checked'" : ""  ?> />  
												</span><label class='form-control'>Viernes</label>
											</div>
											<div class='input-group'>
												<span class='input-group-addon'> 
													<input type='checkbox' name='weekdays[]' id='inp_weekdays_sa'
														value='Sa' <?php echo in_array("Sa", $pdv->schedule->weekdays) ? "checked='checked'" : ""  ?> />  
												</span><label class='form-control'>Sábado</label>
											</div>
											<div class='input-group'>
												<span class='input-group-addon'> 
													<input type='checkbox' name='weekdays[]' id='inp_weekdays_do'
														value='Do' <?php echo in_array("Do", $pdv->schedule->weekdays) ? "checked='checked'" : ""  ?> />  
												</span><label class='form-control'>Domingo</label>
											</div>
										</div>
									</div>
								</div> 
							</div>
						</div>
					</div>   
				</fieldset>
			</div>
			<div class="row ">&nbsp;</div>
			<div class="row ">&nbsp;</div>
			
			<div class="row ">
				<fieldset class="row" style="margin: 10px 0;"> 
					<div class="row ">
						<legend class="border-bottom"> Información de pdv </legend>
					</div>
					<?php echo $pdv->meta->get_frm_html( 'inp_',"col-xs-12 col-sm-6"   ); ?> 
				</fieldset> 
			</div>  
			
			
			
		</fieldset>  
		<div class="row "> &nbsp; </div>  
		<div class="row border-top" style="margin: 10px 0;"></div>
		<div class="row ">
			<input type="hidden" name="action" value="edit_pdv" />
			<input type="hidden" id="inp_id_pdv" name="id_pdv" value="<?php echo $pdv->id_pdv ?>" />
			<input type="hidden" name="cb" value="<?php echo $_GET['cb'] ?>" />
			<button type="reset" class="btn btn-default"><i class="fa fa-refresh"></i> Cancelar </button>
			<button type="submit" class="btn btn-default pull-right"><i class="fa fa-save"></i> Guardar </button>
		</div>
	</div>
	</form>
</div>
<?php } ?>