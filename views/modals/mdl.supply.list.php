<?php

?>
<!-- Supply list Form Modal -->
<div id="mdl_frm_supply_list" class="modal fade"  role="dialog" aria-labelledby="mdl_frm_supply_list" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true" onclick="clean_supply_list_form();"> &times; </button>
				<h4 id="mdl_frm_supply_list_title" class="modal-title">Productos existentes para surtir</h4>
			</div>
			<form id="frm_supply_list" class="form-horizontal" role="form" method="post" action="admin.stock.php" >
				<div class="modal-body">   
					<div id="supply_list" style="height: 500px; overflow-y: scroll;"></div>
				</div>
				<div class="modal-footer">
					<input type='hidden' id='inp_supply_list_pd' name='supply_list_pd' 	value='$' />
					<input type='hidden' id='inp_action'   name='action'	value='supply_list' />
					<input type="hidden" name="cb" value="<?php echo $Index->command ?>" />
					<button type="button" class="btn btn-default" data-dismiss="modal" onclick="">
						Cerrar
					</button>
					<button type="submit" class="btn btn-default" >
						Generar
					</button>
				</div>
			</form>
		</div>
	</div>
</div>  
