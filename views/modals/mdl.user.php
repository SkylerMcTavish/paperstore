<!-- User Detail Modal  -->
<div id="mdl_detail_user" class="modal fade"  role="dialog" aria-labelledby="mdl_detail_user" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true" onclick="clean_form();"> &times; </button>
				<h4 id="mdl_frm_user_title" class="modal-title">Detalle de Usuario</h4>
			</div> 
			<div class="modal-body" id='detail_user_content'>
				
			</div>  
			<div class="modal-footer">
				<input type='hidden' id='inp_detail_id_user' name='detail_id_user' value='0' />  
				<button type="button" class="btn btn-default" data-dismiss="modal">
					<i class='fa fa-times'></i> &nbsp;Cerrar
				</button>
			</div> 
		</div>
	</div>
</div> 