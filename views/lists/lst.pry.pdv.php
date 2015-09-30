<?php 
$pdv = $record;
?>
	<tr>
		<td align='center'> <?php echo $pdv['id_pdv'] ?> </td> 
		<td> <?php echo $pdv['pdv_name'] ?> </td> 
		<td> <?php echo $pdv['pvt_pdv_type'] ?> </td> 
		<td> <?php echo $pdv['pdv_zone'] ?> </td>  
		<td> <?php echo $pdv['ch_channel'] ?> </td>  
		<td> <?php echo $pdv['gr_group'] ?> </td>  
		<td> <?php echo $pdv['fo_format'] ?> </td>  
		<td align='center'>
		<?php if ( $this->which == 'lst_pry_pdv_asignation'){ ?>
			<input
				type="checkbox" class="chck_asignation "
				id="chck_<?php echo $pdv['id_pdv'] ?>"
				value="<?php echo $pdv['id_pdv'] ?>"
				<?php echo ( $pdv['asigned'] ) ? "checked='checked'" : ""; ?>
				onchange="asign_to_proyect('pdv', this)"
			/>
		
		<?php } else if ( $this->which == 'lst_pry_pdv_activation'){ ?>
			<input
				type="checkbox" class="chck_activation "
				id="chck_<?php echo $pdv['id_pdv'] ?>"
				value="<?php echo $pdv['id_pdv'] ?>"
				<?php echo ( $pdv['active'] ) ? "checked='checked'" : ""; ?>
				onchange="activate_in_proyect('pdv', this)"
			/>
		
		<?php } else { ?>
			<button class='button' title="Consultar" onclick='detail_pdv(<?php echo $pdv['id_pdv'] ?>);'><i class="fa fa-eye"></i></button>
		<?php } ?>
		</td>
	</tr>
