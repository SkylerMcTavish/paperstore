<!-- Product Form Modal --> 
<div id="mdl_frm_product" class=" modal fade"  role="dialog" aria-labelledby="mdl_frm_product" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true" onclick="clean_form();"> &times; </button>
				<h4 id="mdl_frm_product_title" class="modal-title">Edición de Producto</h4>
			</div>
			<form id="frm_product" class="form-horizontal" role="form" method="post" action="admin.product.php" >
				<div class="modal-body">   
					<fieldset>   
						<div class="form-group">
							<div class="row">
								<div class="col-lg-6">
									<label class="control-label">Nombre</label>
									<input type="text" id="inp_product" name="product" class="form-control" value="" required  data-validation="required unique-product" />
								</div>
								
								<div class="col-lg-6">
									<label class="control-label">Alias</label>
									<input type="text" id="inp_alias" name="alias" class="form-control" value="" />
								</div>
							</div>
							<div class="clearfix">&nbsp;</div>
							
							<div class="row">
								<div class="col-lg-12">
									<label class="control-label">Descripcion</label>
									<textarea id="inp_description" name="description" class="form-control" style="resize: none"></textarea>
								</div>
							</div>
							<div class="clearfix">&nbsp;</div>
							
							<div class="row">
								<div class="col-lg-6">
									<label class="control-label">SKU</label>
									<input type="text" id="inp_sku" name="sku" class="form-control" value="" required  data-validation="required unique-product" />
								</div>
								
								<div class="col-lg-6">
									<label class="control-label">Marca</label>
									<select class="form-control" id="inp_id_brand" name="id_brand" >
										<?php 	echo $catalogue->get_catalgue_options( 'brand', 0 ); ?>
									</select>
								</div>
							</div>
							<div class="clearfix">&nbsp;</div>
							
							<div class="row">
								<div class="col-lg-6">
									<label class="control-label">Proveedor</label>
									<select class="form-control" id="inp_id_supplier" name="id_supplier" >
										<?php 	echo $catalogue->get_catalgue_options( 'supplier', 0 ); ?>
									</select>
								</div>
								
								<div class="col-lg-6">
									<label class="control-label">Categoría</label>
									<select class="form-control" id="inp_id_category" name="id_category" >
										<?php 	echo $catalogue->get_catalgue_options( 'product_category', 0 ); ?>
									</select>
								</div>
							</div>
							<div class="clearfix">&nbsp;</div>
							
						</div>  
					</fieldset> 
				</div>
				<div class="modal-footer">
					<input type='hidden' id='inp_id_product' name='id_product' value='' />
					<input type='hidden' id='inp_action'  name='action' value='edit_product' />
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