<?php 
global $Session;
$tax = $record;
?>
<tr>
	<td align='center'> <?php echo $tax['id_tax'] ?> </td>
	<td> <?php echo $tax['tx_tax'] ?> </td>
	<td align='center'> <?php echo '$ ' . number_format($tax['tx_hour_amount'], 2, "." , ","); ?> </td> 
	<td align='center'> <?php echo $tax['tx_tipo'] ?> </td>
	<td align='center'> <?php echo '$ ' . number_format($tax['tx_amount_fraction'], 2, "." , ","); ?> </td>
	<td align='center'> <?php echo '$ ' . number_format($tax['tx_amount_first_half'], 2, "." , ","); ?> </td>
	<td align='center'> <?php echo '$ ' . number_format($tax['tx_amount_second_half'], 2, "." , ","); ?> </td> 
	<td align='center'>   
		<button class='button' title="Detalle" 	 onclick='detail_tax(<?php echo $tax['id_tax'] ?>);'><i class="fa fa-eye"></i></button>
		<?php if( $Session->is_admin() ) { ?>
		<button class='button' title="Editar" 	 onclick='edit_tax(<?php echo $tax['id_tax'] ?>);'><i class="fa fa-edit"></i></button>
		<button class='button' title="Eliminar"  onclick='delete_tax(<?php echo $tax['id_tax'] ?>);'><i class="fa fa-trash-o"></i></button>
		<button class='button' title="Usar" 	 onclick='use_tax(<?php echo $tax['id_tax'] ?>);'><i class="fa fa-plus"></i></button>
		<?php } ?>
	</td>
</tr>