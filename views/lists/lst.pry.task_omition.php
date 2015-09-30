<?php 
	$cause = $record;
?>
<tr>
	<td align='center'> <?php echo $cause['id_task_omition_cause'] ?> </td>
	<td> <?php echo $cause['parent'] ?> </td>
	<td> <?php echo $cause['toc_task_omition_cause'] ?> </td>
	<?php if ( $this->which == 'lst_pry_task_omition_asignation'){ ?>
	<td align='center'>
		<input
			type="checkbox" class="chck_asignation "
			id="chck_<?php echo $cause['id_task_omition_cause'] ?>"
			value="<?php echo $cause['id_task_omition_cause'] ?>"
			<?php echo ( $cause['asigned'] ) ? "checked='checked'" : ""; ?>
			onchange="asign_to_proyect('task_omition', this)"
		/>
	</td>
	<?php } ?>
</tr>