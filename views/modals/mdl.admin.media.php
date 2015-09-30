<?php global $catalogue; ?>
<!-- Media File Form Modal --> 
<div id="mdl_frm_media_file" class=" modal fade"  role="dialog" aria-labelledby="mdl_frm_media_file" aria-hidden="true">
	<div class="modal-dialog modal-md">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true" onclick="clean_form();"> &times; </button>
				<h4 id="mdl_frm_media_file_title" class="modal-title">Edición de Material</h4>
			</div>
			<form id="frm_media_file" class="form-horizontal" role="form" method="post" action="admin.proyect.php" enctype="multipart/form-data" >
				<div class="modal-body">   
					<fieldset>
						<div class=" clearfix">
							<div class="col-xs-12 col-sm-5">
								<div class="form-group">  
									<label class="control-label">Tipo de Material</label>
									<select id="inp_media_type" name="id_media_type" class="form-control" >
										<?php echo $catalogue->get_catalgue_options('media_type'); ?>
									</select>
								</div>  
							</div>
							<div class="hidden-xs col-sm-1">&nbsp;</div>
							<div class="col-xs-12 col-sm-6">
								<div class="form-group ">
									<label class="control-label">Título</label>
									<input type="text" id="inp_title" name="title" class="form-control" value="" required  data-validation="required" /> 
								</div> 
							</div>
							
							<div class="col-xs-12 col-sm-5">
								<div class="form-group ">
									<label class="control-label">Archivo</label>
									<input type="file" id="inp_media_file" name="media_file" class="form-control" value="" required  data-validation="required" /> 
								</div> 
							</div>
							
							<div class="hidden-xs col-sm-1">&nbsp;</div>
							<div class="col-xs-12 col-sm-6">
								<div class="form-group ">
									<label class="control-label">Descripción</label>
									<textarea id="inp_description" name="description" class="form-control" ></textarea>
								</div> 
							</div>
					</fieldset> 
				</div>
				<div class="modal-footer">
					<input type='hidden' id='inp_id_media_file' name='id_media_file' value='' />
					<input type='hidden' id='inp_action'  name='action' value='edit_media_file' />
					<button type="button" class="btn btn-default" data-dismiss="modal" onclick="cancel_media_file_edition();">
						<i class="fa fa-times"></i> Cancelar
					</button>
					<button type="submit" class="btn btn-check" onclick="save_media_file();" >
						<i class="fa fa-save"></i> Aceptar
					</button>
				</div>
			</form>
		</div>
	</div>
</div> 