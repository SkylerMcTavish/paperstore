<?php 
global $Session;
if ( $Session->is_admin() ){
	$family = $record;
	?>
	<tr>
		<td align='center'> <?php echo $family['id_family'] ?> </td> 
		<td> <?php echo $family['fa_family'] ?> </td>
		<td> <?php echo $family['ba_brand'] ?> </td>
		<td align='center'> <?php echo $family['fa_rival'] == 0 ? "P" : "C" ?> </td> 
		<td align='center'>   
			<button class='button' title="Editar" 	 onclick='edit_family(<?php echo $family['id_family'] ?>);'><i class="fa fa-edit"></i></button> 
			<button class='button' title="Borrar" 	 onclick='delete_family(<?php echo $family['id_family'] ?>);'><i class="fa fa-trash-o"></i></button>
		</td>
	</tr>
<?php } ?>