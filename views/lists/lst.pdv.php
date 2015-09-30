<?php 
global $Session;
$pdv = $record;
?>
	<tr>
		<td align='center'> <?php echo $pdv['id_pdv'] ?> </td> 
		<td> <?php echo $pdv['pdv_name'] ?> </td>
		<td> <?php echo $pdv['pdv_jde'] ?> </td> 
		<td> <?php echo $pdv['ch_channel'] ?> </td>
		<td> <?php echo $pdv['dv_division'] ?> </td>  
		<td align='center'>   
			<button class='button' title="Detalle" 	 onclick='detail_pdv(<?php echo $pdv['id_pdv'] ?>);'><i class="fa fa-eye"></i></button>
<?php if ( $Session->is_admin() ){ ?>
			<button class='button' title="Editar" 	 onclick='edit_pdv(<?php echo $pdv['id_pdv'] ?>);'><i class="fa fa-edit"></i></button> 
			<button class='button' title="Borrar" 	 onclick='delete_pdv(<?php echo $pdv['id_pdv'] ?>);'><i class="fa fa-trash-o"></i></button>
<?php } ?>
		</td>
	</tr>