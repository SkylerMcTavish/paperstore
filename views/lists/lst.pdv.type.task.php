<?php 
global $Session;
$type = $record;
?>
<tr>
	<td align='center'> <?php echo $type['ptt_pvt_id_pdv_type'] ?> </td> 
	<td> <?php echo $type['pvt_pdv_type'] ?> </td>
	<td> <?php echo $type['tt_task_type'] ?> </td> 
	<td align='center'>
		<button class='button' title="Ver" 	 onclick='detail_pdv_type_task_type(<?php echo $type['ptt_pvt_id_pdv_type'] ?>);'><i class="fa fa-eye"></i></button> 
<?php if ( $Session->is_admin() ){ ?>
		<button class='button' title="Borrar" 	 onclick='delete_pdv_type_task_type(<?php echo $type['ptt_pvt_id_pdv_type'].','.$type['ptt_tt_id_task_type'] ?>);'><i class="fa fa-trash-o"></i></button>
<?php } ?>
	</td>
</tr>