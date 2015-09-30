<?php	$form = $record;  ?>
<tr>
	<td align='center'> <?php echo $form['id_form_type'] ?> </td> 
	<td> <?php echo $form['fmt_form_type'] ?> </td> 
	<td align='center'>  
		<button class='button' title="Editar" onclick='edit_form_type(<?php echo $form['id_form_type'] ?>);'><i class="fa fa-edit"></i></button>
		<button class='button' title="Borrar" onclick='delete_form_type(<?php echo $form['id_form_type'] ?>);'><i class="fa fa-trash-o"></i></button> 
	</td>
</tr>