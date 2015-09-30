<?php 
global $Session;
$stock = $record;
?>
<tr>
	<td align='center'> <?php echo $stock['id_bar_stock'] ?> </td>
	<td> <?php echo $stock['pd_product'] ?> </td>
	<td align='center'> <?php echo $stock['bs_unity_quantity'] ?> </td>
	<td> <?php echo '$ ' . number_format($stock['bs_sell_price'], 2, "." , ","); ?> </td>
	<td> <?php echo '$ ' . number_format($stock['bs_buy_price'], 2, "." , ","); ?> </td>
	<td align='center'> <?php echo $stock['bs_min'] ?> </td>	
	<td align='center'>   
		<button class='button' title="Detalle" 	 onclick='detail_bar_stock(<?php echo $stock['id_bar_stock'] ?>);'><i class="fa fa-eye"></i></button>
		<?php if( $Session->is_admin() ) { ?>
		<button class='button' title="Surtir" 	 onclick='supply_bar_stock(<?php echo $stock['id_bar_stock'] ?>);'><i class="fa fa-truck"></i></button>
		<button class='button' title="Eliminar"  onclick='delete_bar_stock(<?php echo $stock['id_bar_stock'] ?>);'><i class="fa fa-trash-o"></i></button>
		<?php } ?>
	</td>
</tr>