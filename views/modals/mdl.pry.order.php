<!-- Order Detail Modal  -->
<div id="mdl_detail_order" class="modal fade"  role="dialog" aria-labelledby="mdl_detail_order" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true" onclick="clean_order();"> &times; </button>
				<h4 class="modal-title">Información de Pedido</h4>
			</div> 
			<div class="modal-body" id='detail_order_content'>
				
			</div>  
			<div class="modal-footer">
				<input type='hidden' id='inp_detail_id_order' name='detail_id_order' value='0' />  
				<button type="button" class="btn btn-default" data-dismiss="modal">
					<i class='fa fa-times'></i> &nbsp; Cerrar
				</button>
			</div> 
		</div>
	</div>
</div>