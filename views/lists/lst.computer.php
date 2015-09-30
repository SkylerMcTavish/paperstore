<?php 
global $Session;
$pc = $record;
?>
<tr>
	<td align='center'> <?php echo $pc['id_computer'] ?> </td>
	<td> <?php echo $pc['cm_computer'] ?> </td>
	<td> <?php echo $pc['ct_computer_type'] ?> </td>
	<td> <?php echo $pc['cm_brand'] ?> </td>    
	<td> <?php echo $pc['cm_model'] ?> </td>
	<td align='center'>   
		<button class='button' title="Detalle" 	 onclick='detail_computer(<?php echo $pc['id_computer'] ?>);'><i class="fa fa-eye"></i></button>
		<?php if($Session->is_admin()) { ?>
			<button class='button' title="Editar" 	 onclick='edit_computer(<?php echo $pc['id_computer'] ?>);'><i class="fa fa-edit"></i></button> 
			<button class='button' title="Borrar" 	 onclick='delete_computer(<?php echo $pc['id_computer'] ?>);'><i class="fa fa-trash-o"></i></button>
		<?php } ?>
	</td>
</tr>