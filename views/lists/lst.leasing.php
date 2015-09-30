<?php
	$leasing = $record;
?>
<tr>
	<td align='center'> <?php echo $leasing['id_leasing'] ?> </td> 
	<td> <?php echo $leasing['cm_computer'] ?> </td>
	<td> <?php echo date('Y-m-d',$leasing['ls_start']) ?> </td>
	<td align='center'> <?php echo date('H:i:s',$leasing['ls_start']) ?> </td>
	<td align='center'> <?php echo date('H:i:s',$leasing['ls_end']) ?> </td> 
	<td> <?php echo '$ '.number_format($leasing['ls_total'],2) ?> </td>
	<td> <?php echo $leasing['tx_tax'] ?> </td>
</tr>