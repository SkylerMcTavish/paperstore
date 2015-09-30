<?php 
if ( IS_ADMIN ){
	$proy = $record;
?>
<tr>
	<td align='center'> <?php echo $proy['id_proyect'] ?> </td> 
	<td> <?php echo $proy['pr_proyect'] ?> </td>
	<td> <?php echo $proy['prt_proyect_type'] ?> </td>
	<td> <?php echo $proy['cm_company'] ?> </td>
	<td> <?php echo $proy['re_region'] ?> </td>
	<td align='center'> 
		<button class='button' title="Cargar" 	 onclick='load_proyect(<?php echo $proy['id_proyect'] ?>);'><i class="fa fa-eject"></i></button>
		<button class='button' title="Consultar" onclick='detail_proyect(<?php echo $proy['id_proyect'] ?>);'><i class="fa fa-eye"></i></button> 
		<button class='button' title="Editar" 	 onclick='edit_proyect(<?php echo $proy['id_proyect'] ?>);'><i class="fa fa-edit"></i></button> 
		<button class='button' title="Borrar" 	 onclick='delete_proyect(<?php echo $proy['id_proyect'] ?>);'><i class="fa fa-trash-o"></i></button>
	</td>
</tr>
<?php } ?>