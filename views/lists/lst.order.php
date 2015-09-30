<?php
$order = $record;
global $Session;
?> 
<tr>
	<td align='center'> <?php echo $order['id_order'] ?> </td>    
	<td align='center'> <?php echo date('Y/m/d',$order['or_date']) ?> </td> 
	<td > <?php echo $order['us_user'] ?> </td>
	<td > <?php echo $order['pdv_name'] ?> </td>
	<td align='right'> <span style="float:left;">  $  </span> <?php echo number_format( $order['total'], 2 ) ?> </td>  
	<td align='center'>    
		<button class='button' title="Consultar" onclick='detail_order(<?php echo $order['id_order'] ?>);'><i class="fa fa-eye"></i></button> 
	</td>
</tr>