<?php 
	$evidence = $record;
?>
<tr>
	<td align='center'> <?php echo $evidence['id_evidence_type'] ?> </td>
	<td> <?php echo $evidence['et_evidence_type'] ?> </td>
	
	<?php if ( $this->which == 'lst_pry_evidence_type_asignation'){ ?>
	<td align='center'>
		<input
			type="checkbox" class="chck_asignation "
			id="chck_<?php echo $evidence['id_evidence_type'] ?>"
			value="<?php echo $evidence['id_evidence_type'] ?>"
			<?php echo ( $evidence['asigned'] ) ? "checked='checked'" : ""; ?>
			onchange="asign_to_proyect('evidence_type', this)"
		/>
	</td>
	<?php } ?>
</tr>