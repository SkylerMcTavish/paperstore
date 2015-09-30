<?php
	$supervisor = $record;
?>

	<tr>
		<td align='center'> <?php echo $supervisor['id_user'] ?> </td>
		<td> <?php echo $supervisor['us_user'] ?> </td> 
		<td> <?php echo $supervisor['us_zone'] ?> </td> 
		<td> <?php echo $supervisor['pf_profile'] ?> </td> 
		<td align='center'>   
			<input
				type="checkbox" class="chck_asignation "
				id="chck_<?php echo $supervisor['id_user'] ?>"
				value="<?php echo $supervisor['id_user'] ?>"
				<?php echo ( $supervisor['asigned'] ) ? "checked='checked'" : ""; ?>
				onchange="asign_supervisor(<?php echo $supervisor['parent'].','.$supervisor['id_user'].',' ?>this)"
			/>
		</td>
	</tr>