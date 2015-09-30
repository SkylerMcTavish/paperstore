<?php 
global $Session;
if ( $Session->is_admin() ){
	$channel = $record;
	?>
	<tr>
		<td align='center'> <?php echo $channel['id_channel'] ?> </td> 
		<td> <?php echo $channel['ch_channel'] ?> </td> 
		<td align='center'>   
			<button class='button' title="Editar" 	 onclick='edit_channel(<?php echo $channel['id_channel'] ?>);'><i class="fa fa-edit"></i></button> 
			<button class='button' title="Borrar" 	 onclick='delete_channel(<?php echo $channel['id_channel'] ?>);'><i class="fa fa-trash-o"></i></button>
		</td>
	</tr>
<?php } ?>