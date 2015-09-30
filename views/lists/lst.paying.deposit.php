<?php
 $deposit = $record;
?> 
<tr>
	<td align='center'> <?php echo $deposit['folio'] ?> </td>
	<td align='center'> <?php echo '$ '. number_format( $deposit['quantity'], 2, '.', ',') ?> </td> 
</tr>