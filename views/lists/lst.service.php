<?php 
global $Session;
$service = $record;
?>
<tr>
	<td align='center'> <?php echo $service['id_service'] ?> </td>
	<td> <?php echo $service['sr_service'] ?> </td>
	<td> <?php echo '$ '.number_format($service['sr_price'], 2) ?> </td>
	<td align='center'>   
		<button class='button' title="Detalle" 	 onclick='detail_service(<?php echo $service['id_service'] ?>);'><i class="fa fa-eye"></i></button>
		<?php if($Session->is_admin()) { ?>
			<button class='button' title="Editar" 	 onclick='edit_service(<?php echo $service['id_service'] ?>);'><i class="fa fa-edit"></i></button> 
			<button class='button' title="Borrar" 	 onclick='delete_service(<?php echo $service['id_service'] ?>);'><i class="fa fa-trash-o"></i></button>
		<?php } ?>
	</td>
</tr>