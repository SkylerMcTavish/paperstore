<?php
 $usr = $record;
?>
<tr>
	<td align='center'> <?php echo $usr['id_user'] ?> </td> 
	<td> <?php echo $usr['us_zone'] ?> </td> 
	<td> <?php echo $usr['us_user'] ?> </td>
	<td> <?php echo $usr['name'] ?> </td>
	<td> <?php echo $usr['pf_profile'] ?> </td> 
	<td align='center'> 
	<?php if ( $this->which == 'lst_pry_user_asignation'){ ?>  
		<input type="checkbox" class="chck_asignation " 
			id="chck_<?php echo $usr['id_user'] ?>"
		<?php echo ( $usr['asigned'] ) ? "checked='checked'" : ""; ?>  
			value="<?php echo $usr['id_user'] ?>"
			onchange="asign_to_proyect('user', this)"
			/>
	<?php } else if ( $this->which == 'lst_pry_user_activation'){ ?>
		<input type="checkbox" class="chck_activation " 
			id="chck_<?php echo $usr['id_user'] ?>"
		<?php echo ( $usr['active'] ) ? "checked='checked'" : ""; ?>  
			value="<?php echo $usr['id_user'] ?>"
			onchange="activate_in_proyect('user', this)"
	<?php } else { ?>
		<button class='button' title="Consultar" onclick='detail_user(<?php echo $usr['id_user'] ?>);'><i class="fa fa-eye"></i></button>	
	<?php } ?>
	</td>
</tr>