<?php

?>
<!--Product Detail-->
<div id="mdl_detail_product" class="modal fade"  role="dialog" aria-labelledby="mdl_detail_product" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true" > &times; </button>
				<h4 id="mdl_frm_product_title" class="modal-title">Información del Producto</h4>
			</div> 
			<div class="modal-body" id='detail_product_content'>  </div>
			<div class="modal-footer">
				<input type='hidden' id='inp_detail_id_product' name='detail_id_pdv' value='0' />  
				<button type="button" class="btn btn-default" data-dismiss="modal">
					<i class='fa fa-times'></i> &nbsp; Cerrar
				</button>
			</div> 
		</div>
	</div>
</div> 