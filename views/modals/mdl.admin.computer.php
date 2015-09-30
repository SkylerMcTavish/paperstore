<?php
global $catalogue;
?>
<!-- Bar Supply Modal -->
<div id="mdl_frm_computer" class="modal fade"  role="dialog" aria-labelledby="mdl_frm_computer" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true" onclick="clean_computer_form();"> &times; </button>
				<h4 id="mdl_frm_computer_title" class="modal-title">Editar Computadora</h4>
			</div>
			<form id="frm_computer" class="form-horizontal" role="form" method="post" action="admin.computer.php" >
				<div class="modal-body">   
					<fieldset> 
						<div class="form-group">
							<div class="row">
								<div class="hidden-xs col-sm-1"> &nbsp; </div> 
								<div class="col-xs-6 col-sm-5">
									<label class="control-label">Nombre</label>
									<input type="text" id="inp_computer" name="computer" class="form-control" value="" placeholder="Numero de la computadora" required />
								</div>
								
								<div class="col-xs-6 col-sm-5">
									<label class="control-label">Tipo</label>
									<select id="inp_id_type" name="id_type" class="form-control" value="" required >
										<?php echo $catalogue->get_catalgue_options('computer_type') ?>
									</select>
								</div>
							</div>
							
							<div class="row">
								<div class="hidden-xs col-sm-1"> &nbsp; </div> 
								<div class="col-xs-6 col-sm-5">
									<label class="control-label">Marca</label>
									<input type="text" id="inp_brand" name="brand" class="form-control" value="" placeholder="Lenovo" required />
								</div>
								
								<div class="col-xs-6 col-sm-5">
									<label class="control-label">Modelo</label>
									<input type="text" id="inp_model" name="model" class="form-control" value="" placeholder="Modelo de la computadora" required />
								</div>
							</div>
							
							<div class="row">
								<div class="hidden-xs col-sm-1"> &nbsp; </div> 
								<div class="col-xs-6 col-sm-5">
									<label class="control-label">Numero de Serie</label>
									<input type="text" id="inp_serial" name="serial" class="form-control" value="" required />
								</div>
								
								<div class="col-xs-6 col-sm-5" id="div_supply">
									<label class="control-label">Sistema Operativo</label>
									<input type="text" id="inp_so" name="so" class="form-control" value="" placeholder="Windows..." required />
								</div>
							</div>
							
						</div>
					</fieldset> 
				</div>
				<div class="modal-footer">
					<input type='hidden' id='inp_id_computer' name='id_computer' 	value='0' />
					<input type='hidden' id='inp_action'   name='action'	value='edit_computer' />
					<button type="button" class="btn btn-default" data-dismiss="modal" onclick="clean_computer_form();">
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