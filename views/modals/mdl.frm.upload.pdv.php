<!-- Pdv Upload Modal  -->
<div id="mdl_upload_pdv" class="modal fade"  role="dialog" aria-labelledby="mdl_upload_pdv" aria-hidden="true">
	<div class="modal-dialog modal-md">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true" > &times; </button>
				<h4 id="mdl_upload_pdv_title" class="modal-title">Carga de Plantilla de PDVs</h4>
			</div>
			<form id="frm_upload_pdv" class="form-horizontal" role="form" method="post" enctype="multipart/form-data" action="admin.pdv.php" >
				<div class="modal-body" id='upload_pdv_content'>
					<fieldset class="row">
						<div class="col-xs-12 col-sm-12">  
							<div class="clearfix">  
								<div class="col-xs-12 ">
									<div class="form-group ">
										<label class="control-label">Archivo</label>
										<input type="file" id='inp_csv_pdv' name='csv_pdv' class="form-control" value="" required  data-validation="required"/>
									</div> 
								</div>   
							</div>
						</div>
					</fieldset>
				</div>
				<div class="modal-footer">
					<input type="hidden" name="action" value="upload_pdv" />
					<button type="button" class="btn btn-default" data-dismiss="modal">
						<i class='fa fa-times'></i> &nbsp; Cerrar
					</button>
					<button type="submit" class="btn btn-default pull-right"><i class="fa fa-save"></i> Subir </button>
				</div>
			</form>
		</div>
	</div>
</div>