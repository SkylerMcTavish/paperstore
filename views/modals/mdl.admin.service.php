<?php
global $catalogue;
?>
<!-- Service Form Modal -->
<div id="mdl_frm_service" class="modal fade"  role="dialog" aria-labelledby="mdl_frm_service" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true" onclick="clean_service_form();"> &times; </button>
				<h4 id="mdl_frm_service_title" class="modal-title">Editar Servicio</h4>
			</div>
			<form id="frm_service" class="form-horizontal" role="form" method="post" action="admin.service.php" >
				<div class="modal-body">   
					<fieldset>  
						<div class="form-group">
							<div class="row">
								<div class="hidden-xs col-sm-1"> &nbsp; </div>
								<div class="col-xs-6 col-sm-6">
									<label>Servicio</label>
									<input type="text" id="inp_service" name="service" class="form-control" value="" required />
								</div>
								
								<div class="col-xs-6 col-sm-4">
									<label>Precio</label>
									<input type="number" id="inp_price" name="price" class="form-control" value="0" min="0" step="0.1" required />
								</div> 
								
								<div class="hidden-xs col-sm-1"> &nbsp; </div>
							</div>
							
							<div class="row">
								<div class="hidden-xs col-sm-1"> &nbsp; </div>
								<div class="col-xs-10 col-sm-10 pull-left">
									<label>&nbsp;</label>
									<input type="checkbox" id="inp_products" name="products" />
									<label>Asignar Producto(s)</label>
								</div> 
							</div>
						</div> 
						
					</fieldset>
				</div>
				<div class="modal-footer">
					<input type='hidden' id='inp_id_service' name='id_service' 	value='0' />
					<input type='hidden' id='inp_action'   name='action'	value='edit_service' />
					<input type="hidden" name="cb" value="<?php echo $Index->command ?>" />
					<button type="button" class="btn btn-default" data-dismiss="modal" onclick="clean_service_form();">
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
