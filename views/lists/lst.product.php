<?php
/*paperstore*/
global $Session;
$product = $record;
?>
<tr>
	<td align='center'> <?php echo $product['id_product'] ?> </td>
	<td> <?php echo $product['pd_product'] ?> </td>   
	<td> <?php echo $product['br_brand'] ?> </td>  
	<td> <?php echo $product['pd_alias'] ?> </td>    
	<td align='center'>   
		<button class='button' title="Detalle" 	 onclick='detail_product(<?php echo $product['id_product'] ?>);'><i class="fa fa-eye"></i></button>
	</td>
</tr>