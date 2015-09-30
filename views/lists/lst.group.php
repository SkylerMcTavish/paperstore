<?php 
global $Session;
if ( $Session->is_admin() ){
	$group = $record;
	?>
	<tr>
		<td align='center'> <?php echo $group['id_group'] ?> </td>
		<td> <?php echo $group['gr_group'] ?> </td> 
		<td> <?php echo $group['ch_channel'] ?> </td> 
		<td align='center'>   
			<button class='button' title="Editar" 	 onclick='edit_group(<?php echo $group['id_group'] ?>);'><i class="fa fa-edit"></i></button> 
			<button class='button' title="Borrar" 	 onclick='delete_group(<?php echo $group['id_group'] ?>);'><i class="fa fa-trash-o"></i></button>
		</td>
	</tr>
<?php } ?>