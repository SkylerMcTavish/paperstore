<?php
 $product = $record;
?>

<tr>
	<td align='center'> <?php echo $product['id_product'] ?> </td> 
	<td align='center'> <?php echo $product['pd_rival'] == 0 ? "P" : "C" ?> </td>  
	<td> <?php echo $product['ba_brand'] ?> </td>  
	<td> <?php echo $product['fa_family'] ?> </td> 
	<td> <?php echo $product['pd_sku'] ?> </td>    
	<td> <?php echo $product['pd_product'] ?> </td>   
	<td align='center'>   
		<?php if ( $this->which == 'lst_pry_product_asignation'){ ?>
			<input
				type="checkbox" class="chck_asignation "
				id="chck_<?php echo $product['id_product'] ?>"
				value="<?php echo $product['id_product'] ?>"
				<?php echo ( $product['asigned'] ) ? "checked='checked'" : ""; ?>
				onchange="asign_to_proyect('product', this)"
			/>
		
		<?php } else if ( $this->which == 'lst_pry_product_activation'){ ?>
			<input
				type="checkbox" class="chck_activation "
				id="chck_<?php echo $product['id_product'] ?>"
				value="<?php echo $product['id_product'] ?>"
				<?php echo ( $product['active'] ) ? "checked='checked'" : ""; ?>
				onchange="activate_in_proyect('product', this)"
			/>
		
		<?php } else { ?>
			<button class='button' title="Consultar" onclick='detail_product(<?php echo $product['id_product'] ?>);'><i class="fa fa-eye"></i></button>
		<?php } ?>
	</td>
</tr>