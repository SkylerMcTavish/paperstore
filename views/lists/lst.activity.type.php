<?php 
global $Session;
$type = $record;
?>
	<tr>
		<td align='center'> <?php echo $type['id_activity_type'] ?> </td> 
		<td> <?php echo $type['at_activity_type'] ?> </td>
		<td> <?php echo $type['ac_label_table_aux'] ?> </td> 
		<td align='center'>   
<?php if ( $Session->is_admin() ){ ?>
			<button class='button' title="Editar" 	 onclick='edit_activity_type(<?php echo $type['id_activity_type'] ?>);'><i class="fa fa-edit"></i></button> 
			<button class='button' title="Borrar" 	 onclick='delete_activity_type(<?php echo $type['id_activity_type'] ?>);'><i class="fa fa-trash-o"></i></button>
<?php } ?>
		</td>
	</tr>