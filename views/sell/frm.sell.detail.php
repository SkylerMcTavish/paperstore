<div class="col-xs-12 col-sm-12" style="min-height: 400px; overflow-x:auto;"> 
	<table id='tbl_sell_product' class="table table-striped table-bordered table-hover datatable">
		<thead>
			<tr>
				<th>Producto</th>
				<th>Cantidad</th>
				<th>Precio</th>
				<th>Costo</th>
				<th>Acciones</th>
			</tr>
		</thead>
		<tbody>
			<?php echo $sell->get_sell_detail_list_html();  ?>
			<tr>
				<td></td>
				<td></td>
				<td align="right">Subtotal:</td>
				<td><?php echo '$&nbsp;'.number_format($sell->subtotal, 2,'.',','); ?></td>
				<td></td>
			</tr>
			
			<tr>
				<td></td>
				<td></td>
				<td align="right">Total:</td>
				<td><?php echo '$&nbsp;'.number_format($sell->total, 2,'.',','); ?></td>
				<td><input type="hidden" id="inp_total" value="<?php echo $sell->total; ?>" /></td>
			</tr>
		 </tbody>
	</table> 
</div>