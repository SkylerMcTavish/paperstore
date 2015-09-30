<?php 
global $Session;
$payment = $record;
?>
<tr>
	<td align='center'> <?php echo $payment['id_payment'] ?> </td> 
	<td align='center'> <?php echo $payment['pdv_name'] ?> </td>  
	<td> <?php echo $payment['us_user'] ?> </td>  
	<td> <?php echo date('Y-m-d', $payment['py_date_payment'] ) ?> </td>
	<td> <?php echo $payment['pm_payment_method'] ?> </td>
	<td> <?php echo '$ ' . number_format($payment['py_total'], 2, "." , ","); ?> </td>    
	<td align='center'>   
		<button class='button' title="Detalle" 	 onclick='detail_payment(<?php echo $payment['id_payment'] ?>);'><i class="fa fa-eye"></i></button>
	</td>
</tr>