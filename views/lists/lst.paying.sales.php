<?php
 $sale = $record;
?> 
<tr>
	<td align='center'> <?php echo $sale['pdv'] ?> </td>
	<td align='center'> <?php echo $sale['order'] ?> </td>
	<td align='center'> <?php echo $sale['folio'] ?> </td>
	<td align='center'> <?php echo '$ '. number_format( $sale['total'], 2, '.', ',') ?> </td>
</tr>