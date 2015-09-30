<?php 
if ( IS_ADMIN ){
	$company = $record;
?>
<tr>
	<td align='center'> <?php echo $company['id_company'] ?> </td> 
	<td> <?php echo $company['cm_company'] ?> </td> 
	<td align='center'>   
		<button class='button' title="Editar" 	 onclick='edit_company(<?php echo $company['id_company'] ?>);'><i class="fa fa-edit"></i></button> 
		<button class='button' title="Borrar" 	 onclick='delete_company(<?php echo $company['id_company'] ?>);'><i class="fa fa-trash-o"></i></button>
	</td>
</tr>
<?php } ?>