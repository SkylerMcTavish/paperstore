<?php	$form = $record; 	?>
<tr>
	<td align='center'> <?php echo $form['id_form'] ?> </td> 
	<td> <?php echo $form['fmt_form_type'] ?> </td> 
	<td> 
		<strong> <?php echo $form['frm_title'] ?> </strong>
		<p class="hidden-xs"> <?php echo $form['frm_description'] ?> </p>
	</td>  
	<td align='center'>
		<button class='button' title="Consultar" onclick='detail_form(<?php echo $form['id_form'] ?>);'><i class="fa fa-eye"></i></button> 
		<button class='button' title="Consultar" onclick='edit_form(<?php echo $form['id_form'] ?>);'><i class="fa fa-edit"></i></button>
		<button class='button' title="Consultar" onclick='delete_form(<?php echo $form['id_form'] ?>);'><i class="fa fa-trash-o"></i></button> 
	</td>
</tr>