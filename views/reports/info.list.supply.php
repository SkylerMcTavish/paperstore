<?php
	
?>

<table id='tbl_supply_product_<?php echo $product->head->id_product ?>' class="table table-striped table-bordered table-hover datatable">
    <thead>
        <tr>
            <th>Producto</th>
            <th>Minimo</th>
            <th>En inventario</th>
			<th>Surtir</th>
        </tr>
    </thead>
    <tbody>
		<?php foreach($data->products as $k => $pd){ ?>
        <tr>
            <td><?php echo $pd->product; ?></td>            
            <td align="right"><?php echo $pd->min; ?></td>
			<td align="right" style="color:<?php echo $pd->marker; ?>"><?php echo $pd->current; ?></td>
			<td align="center"><input id="chk_<?php echo $pd->id_stock; ?>" type="checkbox" onclick="add_to_list(<?php echo $pd->id_product ?>, <?php echo $pd->id_stock; ?>)"/></td>
        </tr>
		<?php } ?>
    </tbody>
</table> 