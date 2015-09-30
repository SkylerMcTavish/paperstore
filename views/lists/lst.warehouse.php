<?php 
global $Session;
$stock = $record;
?>
<tr>
	<td align='center'> <?php echo $stock['id_storehouse_stock'] ?> </td>
	<td> <?php echo $stock['pd_product'] ?> </td>
	<td align='center'> <?php echo $stock['pp_product_packing'] ?> </td>
	<td align='center'> <?php echo $stock['pp_unity_quantity'] ?> </td>
	<td align='center'> <?php echo $stock['ss_quantity'] ?> </td>
	<td> <?php echo $stock['ss_total'] ?></td>    
	<td align='center'> <?php echo $stock['ss_min'] ?> </td>
	<td align='center'> <?php echo $stock['ss_max'] ?> </td>
	<td align='center'>   
		<button class='button' title="Detalle" 	 onclick='detail_warehouse(<?php echo $stock['id_storehouse_stock'] ?>);'><i class="fa fa-eye"></i></button>
		<?php if( $Session->is_admin() ) { ?>
		<button class='button' title="Surtir" 	 onclick='supply_warehouse(<?php echo $stock['id_storehouse_stock'] ?>);'><i class="fa fa-truck"></i></button>
		<button class='button' title="Eliminar"  onclick='delete_warehouse(<?php echo $stock['id_storehouse_stock'] ?>);'><i class="fa fa-trash-o"></i></button>
		<?php } ?>
	</td>
</tr>