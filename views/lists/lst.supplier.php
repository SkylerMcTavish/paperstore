<?php 
global $Session;
if ( $Session->is_admin() ){
	$supplier = $record;
	?>
	<tr>
		<td align='center'> <?php echo $supplier['id_supplier'] ?> </td> 
		<td> <?php echo $supplier['su_supplier'] ?> </td> 
		<td align='center'>   
			<button class='button' title="Detalle" 	 onclick='detail_supplier(<?php echo $supplier['id_supplier'] ?>);'><i class="fa fa-eye"></i></button>
			<button class='button' title="Editar" 	 onclick='edit_supplier(<?php echo $supplier['id_supplier'] ?>);'><i class="fa fa-edit"></i></button> 
			<button class='button' title="Borrar" 	 onclick='delete_supplier(<?php echo $supplier['id_supplier'] ?>);'><i class="fa fa-trash-o"></i></button>
		</td>
	</tr>
<?php } ?>