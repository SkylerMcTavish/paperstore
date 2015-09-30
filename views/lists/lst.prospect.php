<?php 
global $Session;
$prospect = $record;
?>
	<tr>
		<td align='center'> <?php echo $prospect['id_prospect'] ?> </td>  
		<td> <?php echo utf8_encode($prospect['pro_name']) ?> </td>  
		<td> <?php echo $prospect['pro_rfc'] ?> </td>
		<td> <?php echo $prospect['pro_email'] ?> </td>
		<td> <?php echo $prospect['pro_route'] ?> </td>      
		<td align='center'>   
			<button class='button' title="Detalle" 	 onclick='detail_prospect(<?php echo $prospect['id_prospect'] ?>);'><i class="fa fa-eye"></i></button> 
		</td>
	</tr>