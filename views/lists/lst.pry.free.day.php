<?php	$form = $record; 	?>
<tr>
	<td align='center'> <?php echo $form['id_free_day'] ?> </td>	 
	<td> <?php echo $form['fd_date_string'] ?> </td>
	<td> <?php 	
	$date=date("d-m-Y", $form['fd_date_timestamp']);
	echo $date; ?> </td>  
	<td align='center'> 
		<button class='button' title="Editar" onclick='edit_free_day(<?php echo $form['id_free_day'] ?>);'><i class="fa fa-edit"></i></button>
		<button class='button' title="Eliminar" onclick='delete_free_day(<?php echo $form['id_free_day'] ?>);'><i class="fa fa-trash-o"></i></button> 
	</td>
</tr>