<?php 
	$cause = $record;
?>
<tr>
	<td align='center'> <?php echo $cause['id_visit_reschedule_cause'] ?> </td>
	<td> <?php echo $cause['vrc_visit_reschedule_cause'] ?> </td>
	<?php if ( $this->which == 'lst_pry_visit_omition_asignation'){ ?>
	<td align='center'>
		<input
			type="checkbox" class="chck_asignation "
			id="chck_<?php echo $cause['id_visit_reschedule_cause'] ?>"
			value="<?php echo $cause['id_visit_reschedule_cause'] ?>"
			<?php echo ( $cause['asigned'] ) ? "checked='checked'" : ""; ?>
			onchange="asign_to_proyect('visit_omition', this)"
		/>
	</td>
	<?php } ?>
</tr>