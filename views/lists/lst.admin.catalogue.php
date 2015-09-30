<?php 
global $Session;
if ( $Session->is_admin() ){
	$cat = $record;
?>
<tr>
	<td align='center'> <?php echo $cat['id'] ?> </td>
	<?php if ( isset( $cat['parent']) ){ ?>
		<td> <?php echo $cat['parent'] ?> </td>
	<?php } ?> 
	<td> <?php echo $cat['value'] ?> </td> 
	<td align='center'>
		<?php if ( isset( $cat['detail']) ){ ?>
		<button class='button' title="Detalle" 	 onclick='info_catalogue(<?php echo $cat['id'] ?>);'><i class="fa fa-eye"></i></button>
		<?php } ?> 
		<button class='button' title="Editar" 	 onclick='edit_catalogue(<?php echo $cat['id'] ?>);'><i class="fa fa-edit"></i></button> 
		<button class='button' title="Borrar" 	 onclick='delete_catalogue(<?php echo $cat['id'] ?>);'><i class="fa fa-trash-o"></i></button>
	</td>
</tr>
<?php } ?>