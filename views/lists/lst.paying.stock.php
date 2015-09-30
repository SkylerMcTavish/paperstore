<?php
 $stock = $record;
?> 
<tr>
	<td align='center'> <?php echo $stock['product'] ?> </td>
	<td align='center'> <?php echo $stock['jde'] ?> </td>
	<td align='center'> <?php echo $stock['unity'] ?> </td>
	<td align='center'> <?php echo number_format( $stock['box'], 2, '.', ',') ?> </td>
</tr>