<?php
global $catalogue;
?>
<!-- Task Type Modal -->
<div id="mdl_detail_task_type" class="modal fade"  role="dialog" aria-labelledby="mdl_detail_task_type" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true" onclick=""> &times; </button>
				<h4 id="mdl_detail_task_type_title" class="modal-title">Información de Tipo de Tarea</h4>
			</div>
			<div class="modal-body">   
				<fieldset> 
					<div class="form-group">
						<div class="hidden-xs col-sm-1"> &nbsp; </div> 
						<div class="col-xs-12 col-sm-10">
							<label class="control-label">Tipo de Tarea</label>
							<label id="detail_task_type" class="form-control"></label>
							
							<label class="control-label">Descripción</label>
							<textarea id="detail_description" class="form-control" value="" disabled="disabled" required style="resize: none"></textarea>
						</div>
					</div>
				</fieldset> 
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal" onclick="">
					Cerrar
				</button>
				
			</div>
		</div>
	</div>
</div>  