<?php
/*Paperstore*/
global $Session;
$sell = $record;
?>
<tr>
	<td align='center'> <?php echo $sell['id_sell'] ?> </td> 
	<td> <?php echo date('Y-m-d g:i A', $sell['sl_date']) ?> </td>
	<td> $ <?php echo number_format($sell['sl_subtotal'], 2, '.',',') ?> </td> 
	<td> $ <?php echo number_format($sell['sl_total'], 2, '.',',') ?> </td>
	<td> <?php echo $sell['us_user'] ?> </td>
	<td align='center'>   
		<button class='button' title="Detalle" 	 onclick='detail_sell(	<?php echo $sell['id_sell'] ?>);'><i class="fa fa-eye"></i></button>
<?php if ( $Session->is_admin() ){ ?>
		<button class='button' title="Borrar" 	 onclick='delete_sell(	<?php echo $sell['id_sell'] ?>);'><i class="fa fa-trash-o"></i></button>
<?php } ?>
	</td>
</tr>