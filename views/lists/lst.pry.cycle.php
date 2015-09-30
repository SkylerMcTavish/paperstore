<?php  
global $Session;
if ( $Session->is_proyect_admin() ){
	$cycle = $record;
	?>
	<tr>
		<td align='center'> <?php echo date('Y/m/d',$cycle['cy_from']) ?> </td> 
		<td align='center'> <?php echo date('Y/m/d',$cycle['cy_to']) ?> </td> 
		<td align='center'> 
			<!-- <button class='button' title="Editar" 	 onclick='edit_cycle(<?php echo $cycle['cy_from'] . "," .  $cycle['cy_to']  ?>);'><i class="fa fa-edit"></i></button> --> 
			<button class='button' title="Borrar" 	 onclick='delete_cycle(<?php echo $cycle['cy_from'] . "," .  $cycle['cy_to']  ?>);'><i class="fa fa-trash-o"></i></button>
		</td>
	</tr>
<?php } ?>