<!-- Supplier Form Modal --> 
<div id="mdl_frm_tax" class=" modal fade"  role="dialog" aria-labelledby="mdl_frm_tax" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true" onclick="clean_tax_form();"> &times; </button>
				<h4 id="mdl_frm_tax_title" class="modal-title">Edición de Tarifa</h4>
			</div>
			<form id="frm_tax" class="form-horizontal" role="form" method="post" action="admin.tax.php" >
				<div class="modal-body">   
					<fieldset>   
						<div class="form-group">
							<div class="row">
								<div class="col-xs-12">
									<label class="control-label">Tarifa</label>
									<input type="text" id="inp_tax" name="tax" placeholder="Nombre de la Tarifa" class="form-control" value="" required  data-validation="required unique-tax" />
								</div>
							</div>
							
							<div class="row">
								<div class="col-xs-6">
									<label class="control-label">Tarifa Hora Completa</label>
									<input type="number" id="inp_hour" min="1" name="hour" class="form-control" value="" required  />
								</div>
								
								<div class="col-xs-6">
									<label class="control-label">Tipo de Tarifa</label>
									<select class="form-control" id="inp_type" name="type" required  >
										<option disabled="disabled" selected>Elija una opción</option>
										<option value="1">Hora Completa</option>
										<option value="2">Fraccion de 10 minutos</option>
										<option value="3">Mitad de Hora</option>
									</select>
								</div>
							</div>
							
							<div class="clearfix">&nbsp;</div>
							<div class="clearfix">&nbsp;</div>
							
							<div class="row">
								<div class="col-xs-4">
									<label class="control-label">Costo de Fraccion (10 minutos)</label>
									<input type="number" id="inp_fraction" min="1" step=".1"  name="fraction" class="form-control" value=""   />
								</div>
								
								<div class="col-xs-4">
									<label class="control-label">Costo Primer Media Hora</label>
									<input type="number" id="inp_first_half" min="1" step=".1" name="first_half" class="form-control" value=""   />
								</div>
								
								<div class="col-xs-4">
									<label class="control-label">Costo Segunda Media Hora</label>
									<input type="number" id="inp_second_half" min="1" step=".1"  name="second_half" class="form-control" value=""   />
								</div>
							</div>
							
						</div>  
					</fieldset> 
				</div>
				<div class="modal-footer">
					<input type='hidden' id='inp_id_tax' name='id_tax' value='' />
					<input type='hidden' id='inp_action'  name='action' value='edit_tax' />
					<button type="button" class="btn btn-default" data-dismiss="modal" >
						<i class="fa fa-times"></i> Cancelar
					</button>
					<button type="submit" class="btn btn-check" >
						<i class="fa fa-save"></i> Aceptar
					</button>
				</div>
			</form>
		</div>
	</div>
</div>  