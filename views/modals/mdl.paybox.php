<?php
global $catalogue;
?>
<!-- Paybox Modal -->
<div id="mdl_frm_paybox" class="modal fade"  role="dialog" aria-labelledby="mdl_frm_paybox" aria-hidden="true">
	<div class="modal-dialog modal-sm">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true" onclick="clean_paybox_form();"> &times; </button>
				<h4 id="mdl_frm_paybox_title" class="modal-title">Caja de Cobro</h4>
			</div>
			<div class="modal-body">   
				<fieldset> 
					<div class="row">
						<div class="hidden-xs col-sm-1"> &nbsp; </div> 
						<div class="col-xs-12 col-sm-10">
							<label class="control-label">Total a pagar:</label>
							<input type="text" readonly="readonly" class="form-control" pattern="(\d{3})([\.])(\d{2})" id="inp_total" value="0.00" />
						</div>
					</div>
					
					<div class="row">
						<div class="hidden-xs col-sm-1"> &nbsp; </div> 
						<div class="col-xs-12 col-sm-10">
							<label class="control-label">Pago con:</label>
							<input type="number" class="form-control" id="inp_pay" pattern="(\d{3})([\.])(\d{2})" value="0.00" onblur="cash()" />
						</div>
					</div>
					
					<div class="row">
						<div class="hidden-xs col-sm-1"> &nbsp; </div> 
						<div class="col-xs-12 col-sm-10">
							<label class="control-label">Cambio:</label>
							<input type="number" class="form-control" readonly="readonly" pattern="(\d{3})([\.])(\d{2})" id="inp_cash" value="0.00"  />
						</div>
					</div>
				</fieldset> 
			</div>
			<div class="modal-footer">
				<input type='hidden' id='inp_site' name='site' 	value='0' />
				<input type='hidden' id='inp_action'   name='action'	value='edit_paybox' />
				<button type="button" class="btn btn-default" data-dismiss="modal" onclick="clean_paybox_form();">
					Cancelar
				</button>
				<button type="button" class="btn btn-default" data-dismiss="modal" onclick="set_computer(1, 0)">
					Aceptar
				</button>
			</div>
		</div>
	</div>
</div>

<script>
	function cash()
	{
		var total = $("#inp_total").val();
		var pay = $("#inp_pay").val();
		var cash = pay - total;
		
		$("#inp_cash").val(cash);
	}
</script>