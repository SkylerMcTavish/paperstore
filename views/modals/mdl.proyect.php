<!-- Proyect Detail Modal  -->
<div id="mdl_detail_proyect" class="modal fade"  role="dialog" aria-labelledby="mdl_detail_proyect" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true" onclick="clean_form();"> &times; </button>
				<h4 id="mdl_frm_proyect_title" class="modal-title">Información de proyecto</h4>
			</div> 
			<div class="modal-body" id='detail_proyect_content'>
				
			</div>  
			<div class="modal-footer">
				<input type='hidden' id='inp_detail_id_proyect' name='detail_id_proyect' value='0' />  
				<button type="button" class="btn btn-default" data-dismiss="modal">
					<i class='fa fa-times'></i> &nbsp;Cerrar
				</button>
			</div> 
		</div>
	</div>
</div>