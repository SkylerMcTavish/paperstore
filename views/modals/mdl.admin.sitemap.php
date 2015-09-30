<?php
global $catalogue;
?>
<!-- Asign Computer Modal -->
<div id="mdl_frm_sitemap" class="modal fade"  role="dialog" aria-labelledby="mdl_frm_sitemap" aria-hidden="true">
	<div class="modal-dialog modal-sm">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true" onclick="clean_sitemap_form();"> &times; </button>
				<h4 id="mdl_frm_sitemap_title" class="modal-title">Edición de Actividad</h4>
			</div>
			<div class="modal-body">   
				<fieldset> 
					<div class="form-group">
						<div class="hidden-xs col-sm-1"> &nbsp; </div> 
						<div class="col-xs-12 col-sm-10">
							<label class="control-label">Asignar Computadora</label>
							
							<select id="inp_id_computer" name="id_computer" class="form-control" >
								<?php echo $catalogue->get_catalgue_options('sitemap_available_computer'); ?>
							</select>
							
						</div>
					</div>
				</fieldset> 
			</div>
			<div class="modal-footer">
				<input type='hidden' id='inp_site' name='site' 	value='0' />
				<input type='hidden' id='inp_action'   name='action'	value='edit_sitemap' />
				<button type="button" class="btn btn-default" data-dismiss="modal" onclick="clean_sitemap_form();">
					Cancelar
				</button>
				<button type="button" class="btn btn-default" data-dismiss="modal" onclick="set_computer(1, 0)">
					Aceptar
				</button>
			</div>
		</div>
	</div>
</div> 