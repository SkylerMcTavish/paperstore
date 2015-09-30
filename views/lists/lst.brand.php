<?php 
global $Session;
if ( $Session->is_admin() ){
	$brand = $record;
	?>
	<tr>
		<td align='center'> <?php echo $brand['id_brand'] ?> </td> 
		<td> <?php echo $brand['ba_brand'] ?> </td>
		<td align='center'> <?php echo $brand['ba_rival'] == 0 ? "P" : "C" ?> </td> 
		<td align='center'>   
			<button class='button' title="Editar" 	 onclick='edit_brand(<?php echo $brand['id_brand'] ?>);'><i class="fa fa-edit"></i></button> 
			<button class='button' title="Borrar" 	 onclick='delete_brand(<?php echo $brand['id_brand'] ?>);'><i class="fa fa-trash-o"></i></button>
		</td>
	</tr>
<?php } ?>