<!-- Products Upload Modal  -->
<div id="mdl_upload_products" class="modal fade"  role="dialog" aria-labelledby="mdl_upload_products" aria-hidden="true">
	<div class="modal-dialog modal-md">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true" > &times; </button>
				<h4 id="mdl_upload_products_title" class="modal-title">Carga de Plantilla de Productos</h4>
			</div>
			<form id="frm_upload_products" class="form-horizontal" role="form" method="post" enctype="multipart/form-data" action="admin.product.php" >
				<div class="modal-body" id='upload_products_content'>
					<fieldset class="row">
						<div class="col-xs-12 col-sm-12">  
							<div class="clearfix">  
								<div class="col-xs-12 ">
									<div class="form-group ">
										<label class="control-label">Archivo</label>
										<input type="file" id='inp_csv_products' name='csv_products' class="form-control" value="" required  data-validation="required"/>
									</div> 
								</div>   
							</div>
						</div>
					</fieldset>
				</div>
				<div class="modal-footer">
					<input type="hidden" name="action" value="upload_products" />
					<button type="button" class="btn btn-default" data-dismiss="modal">
						<i class='fa fa-times'></i> &nbsp; Cerrar
					</button>
					<button type="submit" class="btn btn-default pull-right"><i class="fa fa-save"></i> Subir </button>
				</div>
			</form>
		</div>
	</div>
</div>