<?php
global $catalogue;
?>
<!-- Warehouse Modal -->
<div id="mdl_frm_warehouse" class="modal fade"  role="dialog" aria-labelledby="mdl_frm_warehouse" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true" onclick="clean_warehouse_form();"> &times; </button>
				<h4 id="mdl_frm_warehouse_title" class="modal-title">Surtir Producto a Bodega</h4>
			</div>
			<form id="frm_warehouse" class="form-horizontal" role="form" method="post" action="admin.stock.php" >
				<div class="modal-body">   
					<fieldset> 
						<div class="form-group">
							<div class="row">
								<div class="hidden-xs col-sm-1"> &nbsp; </div> 
								<div class="col-xs-6 col-sm-5">
									<label class="control-label">Producto</label>
									<select id="inp_id_product" name="id_product" class="form-control" value="" required >
										<?php echo $catalogue->get_catalgue_options('product_supply_warehouse') ?>
									</select>
								</div>
								
								<div class="col-xs-6 col-sm-5">
									<label class="control-label">Cantidad</label>
									<input type="number" min="0" id="inp_quantity" name="quantity" class="form-control" value="" required />
								</div>
							</div>
							
							<div class="row">
								<div class="hidden-xs col-sm-1"> &nbsp; </div> 
								<div class="col-xs-6 col-sm-5">
									<label class="control-label">Minimo</label>
									<input type="number" min="0" id="inp_min" name="min" class="form-control" value="" required />
								</div>
								
								<div class="col-xs-6 col-sm-5">
									<label class="control-label">Maximo</label>
									<input type="number" min="0" id="inp_max" name="max" class="form-control" value="" required />
								</div>
							</div>
							
							<div class="row">
								<div class="hidden-xs col-sm-1"> &nbsp; </div> 
								<div class="col-xs-6 col-sm-5">
									<label class="control-label">Empaque</label>
									<select id="inp_id_packing" name="id_packing" class="form-control" value="" required >
										<?php echo $catalogue->get_catalgue_options('packing') ?>
									</select>
								</div>
								
								<div class="col-xs-6 col-sm-5" id="div_supply">
									<label class="control-label">Cantidad Surtida</label>
									<input type="number" min="0" id="inp_supply" name="supply" class="form-control" value="0" />
								</div>
							</div>
							
						</div>
					</fieldset> 
				</div>
				<div class="modal-footer">
					<input type='hidden' id='inp_id_warehouse' name='id_warehouse' 	value='0' />
					<input type='hidden' id='inp_action'   name='action'	value='edit_warehouse' />
					<button type="button" class="btn btn-default" data-dismiss="modal" onclick="clean_warehouse_form();">
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