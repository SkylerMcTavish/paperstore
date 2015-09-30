<?php 
global $Session;
$type = $record;
?>
<tr>
	<td align='center'> <?php echo $type['tta_tt_id_task_type'] ?> </td> 
	<td> <?php echo $type['tt_task_type'] ?> </td>
	<td> <?php echo $type['ac_activity'] ?> </td> 
	<td align='center'>
		<button class='button' title="Ver" 	 onclick='task_type_activities(<?php echo $type['tta_tt_id_task_type'] ?>);'><i class="fa fa-eye"></i></button> 
<?php if ( $Session->is_admin() ){ ?>
		<button class='button' title="Borrar" 	 onclick='delete_task_activity(<?php echo $type['tta_tt_id_task_type'].','.$type['tta_ac_id_activity'] ?>);'><i class="fa fa-trash-o"></i></button>
<?php } ?>
	</td>
</tr>