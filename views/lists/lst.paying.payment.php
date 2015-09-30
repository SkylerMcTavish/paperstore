<?php
 $payment = $record;
?> 
<tr>
	<td align='center'> <?php echo $payment['pdv'] ?> </td>
	<td > <?php echo $payment['folio'] ?> </td>
	<td > <?php echo $payment['method'] ?> </td>
	<td align='center'> <?php echo '$ '. number_format( $payment['amount'], 2, '.', ',') ?> </td> 
</tr>