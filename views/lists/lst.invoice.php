<?php 
global $Session;
$invoice = $record;
?>
<tr>
	<td align='center'> <?php echo $invoice['id_invoice'] ?> </td>
	<td> <?php echo $invoice['in_folio'] ?> </td>
	<td align='center'> <?php echo $invoice['pdv_name'] ?> </td>
	<td> <?php echo '$ ' . number_format($invoice['in_total'], 2, "." , ","); ?> </td>    
	<td> <?php echo date('Y-m-d', $invoice['in_date'] ) ?> </td>
	<td align='center'>   
		<button class='button' title="Detalle" 	 onclick='detail_invoice(<?php echo $invoice['id_invoice'] ?>);'><i class="fa fa-eye"></i></button>
	</td>
</tr>