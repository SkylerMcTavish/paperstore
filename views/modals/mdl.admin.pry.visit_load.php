<?php 
?>
<!-- Load Visits Form Modal --> 
<div id="mdl_upload_visit" class=" modal fade"  role="dialog" aria-labelledby="mdl_upload_visit" aria-hidden="true">
	<div class="modal-dialog modal-md">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true" onclick="clean_form();"> &times; </button>
				<h4 id="mdl_frm_load_visit_title" class="modal-title">Carga de Plantilla de Visitas</h4>
			</div>
			<form id="frm_load_visit" class="form-horizontal" role="form" method="post" action="admin.visit.php" enctype="multipart/form-data" >
				<div class="modal-body">   
					<fieldset>
						<div class="clearfix">  
							<div class="col-xs-12 ">
								<div class="form-group ">
									<label class="control-label">Archivo</label>
									<input type="file" id="inp_file" name="file" class="form-control" value="" required  data-validation="required" /> 
								</div> 
							</div>   
						</div>
					</fieldset> 
				</div>
				<div class="modal-footer"> 
					<input type='hidden' id='inp_action'  name='action' value='load_visit' />
					<button type="button" class="btn btn-default" data-dismiss="modal" onclick="cancel_load_visit();">
						<i class="fa fa-times"></i> Cancelar
					</button>
					<button type="submit" class="btn btn-check" onclick="load_visit();" >
						<i class="fa fa-save"></i> Aceptar
					</button>
				</div>
			</form>
		</div>
	</div>
</div> 