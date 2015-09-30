<?php
 $city = $record;
 global $Session; 
?> 
<tr>
	<td align='center'> <?php echo $city['id_city'] ?> </td>
	<td > <?php echo $city['ct_city'] ?> </td>
	<td > <?php echo $city['ct_code'] ?> </td>
	<td align='center'> <?php echo $city['ct_st_st_code'] ?> </td> 
	<td align='center'>    
		<button class='button' title="Consultar" onclick='detail_visit(<?php echo $city['id_city'] ?>);'><i class="fa fa-eye"></i></button>	
	</td>
</tr>