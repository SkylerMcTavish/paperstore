<?php
global $catalogue;
?>
<!-- Sell Form Modal -->
<div id="mdl_frm_sell" class="modal fade"  role="dialog" aria-labelledby="mdl_frm_sell" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true" onclick="clean_sell_form();"> &times; </button>
				<h4 id="mdl_frm_sell_title" class="modal-title">Registrar Venta</h4>
			</div>
			<form id="frm_sell" class="form-horizontal" role="form" method="post" action="admin.sell.php" >
				<div class="modal-body">   
					<fieldset>  
						<div class="form-group">
							<div class="hidden-xs col-sm-1"> &nbsp; </div>
							<div class="col-xs-6 col-sm-5">
								<label class='form-control'>Anaquel</label>
								<select class='form-control' id="inp_id_rack" name="id_rack"  >
								<?php echo $catalogue->get_catalgue_options('rack'); ?>
								</select>
							</div>
							
							<div class="col-xs-6 col-sm-5">
								<label class='form-control'>Producto</label>
								<select class='form-control' id="inp_id_product" name="id_product"  >
								<?php echo $catalogue->get_catalgue_options('product'); ?>
								</select>
							</div> 
							
							<div class="hidden-xs col-sm-1"> &nbsp; </div>
						</div> 
						<div class="form-group">
							<div class="hidden-xs col-sm-1"> &nbsp; </div>
							<div class="col-xs-6 col-sm-5">
								<label class='form-control'>Cantidad</label>
								<input type="number" min="1" value="1" class='form-control' id="inp_quantity" name="quantity"  >
							</div>
							
							<div class="col-xs-6 col-sm-5">
								<label class='form-control'>Precio</label>
								<input type="number" min="0" value="0" class='form-control' id="inp_price" name="price"  >
							</div>
							<div class="hidden-xs col-sm-1"> &nbsp; </div>
						</div>
						
						<div class="form-group">
							<div class="hidden-xs col-sm-1"> &nbsp; </div>
							<div class="col-xs-6 col-sm-5">
								<label class='form-control'>Cantidad</label>
								<input type="number" min="1" value="1" class='form-control' id="inp_quantity" name="quantity"  >
							</div>
							
							<div class="col-xs-6 col-sm-5">
								<label class='form-control'>Precio</label>
								<input type="number" min="0" value="0" class='form-control' id="inp_price" name="price"  >
							</div>
							<div class="hidden-xs col-sm-1"> &nbsp; </div>
						</div>
						
					</fieldset>
					<div class="row">
						<div class="col-xs-12 col-sm-12" style="overflow-x:auto;"> 
							<table id='tbl_sell_detail_product' class="table table-striped table-bordered table-hover datatable">
								<thead>
									<tr>
										<th>Producto</th>
										<th>Cantidad</th>
										<th>Precio</th>
										<th>Total</th>
										<th>Accion</th>
									</tr>
								</thead>
								<tbody>
								</tbody>
								
								<tfoot>
									<tr>
										<td></td>
										<td></td>
										<td>Subtotal:</td>
										<td>$<strong class="badge">0.00</strong></td>
									</tr>
									<tr>
										<td></td>
										<td></td>
										<td>Total:</td>
										<td>$<strong class="badge">0.00</strong></td>
									</tr>
								</tfoot>
							</table> 
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<input type='hidden' id='inp_id_sell' name='id_sell' 	value='' />
					<input type='hidden' id='inp_action'   name='action'	value='edit_sell' />
					<input type="hidden" name="cb" value="<?php echo $Index->command ?>" />
					<button type="button" class="btn btn-default" data-dismiss="modal" onclick="clean_sell_form();">
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
