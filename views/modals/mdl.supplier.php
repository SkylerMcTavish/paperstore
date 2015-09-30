<!-- Supplier Detail Modal  -->
<div id="mdl_detail_supplier" class="modal fade"  role="dialog" aria-labelledby="mdl_detail_supplier" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true" onclick="clean_form();"> &times; </button>
				<h4 id="mdl_frm_supplier_title" class="modal-title">Información de Mayorista</h4>
			</div> 
			<div class="modal-body" id='detail_supplier_content'>
				
			</div>  
			<div class="modal-footer">
				<input type='hidden' id='inp_detail_id_supplier' name='detail_id_supplier' value='0' />  
				<button type="button" class="btn btn-default" data-dismiss="modal">
					<i class='fa fa-times'></i> &nbsp; Cerrar
				</button>
			</div> 
		</div>
	</div>
</div>