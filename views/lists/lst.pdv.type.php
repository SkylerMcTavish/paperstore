<?php 
global $Session;
$type = $record;
?>
<tr>
	<td align='center'> <?php echo $type['id_pdv_type'] ?> </td> 
	<td> <?php echo $type['pvt_pdv_type'] ?> </td>
	<td align='center'>   
<?php if ( $Session->is_admin() ){ ?>
		<button class='button' title="Editar" 	 onclick='edit_pdv_type(<?php echo $type['id_pdv_type'] ?>);'><i class="fa fa-edit"></i></button>
		<?php if($type['id_pdv_type'] > 1 ) { ?>
		<button class='button' title="Borrar" 	 onclick='delete_pdv_type(<?php echo $type['id_pdv_type'] ?>);'><i class="fa fa-trash-o"></i></button>
		<?php } ?>
<?php } ?>
	</td>
</tr>