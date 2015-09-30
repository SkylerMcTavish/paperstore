<?php 
global $Session;
$type = $record;
?>
<tr>
	<td align='center'> <?php echo $type['id_task_type'] ?> </td> 
	<td> <?php echo $type['tt_task_type'] ?> </td>
	<td align='center'>
		<button class='button' title="Editar" 	 onclick='detail_task_type(<?php echo $type['id_task_type'] ?>);'><i class="fa fa-eye"></i></button> 
<?php if ( $Session->is_admin() ){ ?>
		<button class='button' title="Editar" 	 onclick='edit_task_type(<?php echo $type['id_task_type'] ?>);'><i class="fa fa-edit"></i></button> 
		<button class='button' title="Borrar" 	 onclick='delete_task_type(<?php echo $type['id_task_type'] ?>);'><i class="fa fa-trash-o"></i></button>
<?php } ?>
	</td>
</tr>