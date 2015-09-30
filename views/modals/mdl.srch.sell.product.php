<!-- Supplier Form Modal --> 
<div id="mdl_frm_sell_product" class=" modal fade"  role="dialog" aria-labelledby="mdl_frm_sell_product" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true" onclick="clean_sell_product_form();"> &times; </button>
				<h4 id="mdl_frm_sell_product_title" class="modal-title">Busqueda de Productos</h4>
			</div>
			<form id="frm_sell_product" class="form-horizontal" role="form" method="post" action="admin.sell_product.php" >
				<div class="modal-body">   
					<div class="row">
						<div class="col-xs-12 ">
							<div id="div_html_srch"></div>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<input type='hidden' id='inp_id_sell_product' name='id_sell_product' value='' />
					<input type='hidden' id='inp_action'  name='action' value='edit_sell_product' />
					<button type="button" class="btn btn-default" data-dismiss="modal" >
						<i class="fa fa-times"></i> Cancelar
					</button>
				</div>
			</form>
		</div>
	</div>
</div>  