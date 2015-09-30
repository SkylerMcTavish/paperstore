<?php 
	$supplier = $record;
?>
<tr>
	<td align='center'> <?php echo $supplier['id_supplier'] ?> </td> 
	<td> <?php echo $supplier['su_supplier'] ?> </td> 
	<td align='center'>
	
	<?php if ( $this->which == 'lst_pry_supplier_asignation'){ ?>
		<input
			type="checkbox" class="chck_asignation "
			id="chck_<?php echo $supplier['id_supplier'] ?>"
			value="<?php echo $supplier['id_supplier'] ?>"
			<?php echo ( $supplier['asigned'] ) ? "checked='checked'" : ""; ?>
			onchange="asign_to_proyect('supplier', this)"
		/>
	<?php } else { ?>
		<button class='button' title="Detalle" 	 onclick='detail_supplier(<?php echo $supplier['id_supplier'] ?>);'><i class="fa fa-eye"></i></button>
	<?php } ?>
	</td>
</tr>