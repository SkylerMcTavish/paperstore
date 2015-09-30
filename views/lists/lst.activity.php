<?php 
global $Session;
$activity = $record;
?>
	<tr>
		<td align='center'> <?php echo $activity['id_activity'] ?> </td> 
		<td> <?php echo $activity['ac_activity'] ?> </td>
		<td> <?php echo $activity['at_activity_type'] ?> </td> 
		<td align='center'>   
			<button class='button' title="Detalle" 	 onclick='detail_activity(<?php echo $activity['id_activity'] ?>);'><i class="fa fa-eye"></i></button>
<?php if ( $Session->is_admin() && $activity['ac_default'] == '0' ){ ?>
			<button class='button' title="Editar" 	 onclick='edit_activity(<?php echo $activity['id_activity'] ?>);'><i class="fa fa-edit"></i></button> 
			<button class='button' title="Borrar" 	 onclick='delete_activity(<?php echo $activity['id_activity'] ?>);'><i class="fa fa-trash-o"></i></button>
<?php } ?>
		</td>
	</tr>