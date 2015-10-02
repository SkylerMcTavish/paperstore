<div class="bs-example">
	<div class="panel-group" id="accordion">
<?php
	foreach($data->products as $k => $product)
	{
		//print_r($product->head);		
		?>
		<div class="panel panel-default">
			<div class="panel-heading" data-toggle="collapse" data-parent="#accordion"  href="#collapse_product_<?php echo $product->head->id_product ?>" style="cursor: pointer">
				<h4 class="panel-title">
					<span><?php echo $product->head->product ?></span>
					<span class="pull-right">Inventario:&nbsp;<strong id="lbl_order_total" class="badge"><?php echo $product->head->stock; ?></strong></span>
					<span class="pull-right">Total Surtido:&nbsp;<strong id="lbl_order_total" class="badge"><?php echo $product->head->total; ?></strong></span>
				</h4>
			</div>			
		</div>
		<div id="collapse_product_<?php echo $product->head->id_product ?>" class="panel-collapse collapse">
				<div class="panel-body">
					<table id='tbl_detail_product_<?php echo $product->head->id_product ?>' class="table table-striped table-bordered table-hover datatable">
						<thead>
							<tr>
								<th>Fecha</th>
								<th>En inventario</th>
								<th>Surtido</th>
							</tr>
						</thead>
						<tbody>													
		<?php		
		foreach($product->detail as $j => $detail )
		{
			//print_r($detail);
			?>
						<tr>
							<td><?php echo date('Y-m-d', $detail->timestamp); ?></td>
							<td align="right"><?php echo $detail->current; ?></td>
							<td align="right"><?php echo $detail->supplied; ?></td>
						</tr>
			<?php
		}
		?>
						</tbody>
				   </table> 
				</div>
			</div>
		<?php
	}

?>
	</div>
</div>