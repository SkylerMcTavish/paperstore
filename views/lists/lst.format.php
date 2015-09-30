<?php 
global $Session;
if ( $Session->is_admin() ){
	$format = $record;
	?>
	<tr>
		<td align='center'> <?php echo $format['id_format'] ?> </td>
		<td> <?php echo $format['fo_format'] ?> </td> 
		<td> <?php echo $format['gr_group'] ?> </td> 
		<td align='center'>   
			<button class='button' title="Editar" 	 onclick='edit_format(<?php echo $format['id_format'] ?>);'><i class="fa fa-edit"></i></button> 
			<button class='button' title="Borrar" 	 onclick='delete_format(<?php echo $format['id_format'] ?>);'><i class="fa fa-trash-o"></i></button>
		</td>
	</tr>
<?php } ?>