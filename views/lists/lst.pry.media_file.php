<?php	$media = $record; 	?>
<tr>
	<td align='center'> <?php echo $media['id_media_file'] ?> </td> 
	<td>
		<img src="img/<?php echo $media['ft_icon'] ?>" alt="<?php echo $media['ft_file_type'] ?>"  style='height: 16px; width: 16px;'/>  
	</td> 
	<td> <?php echo $media['mt_media_type'] ?> </td>
	<td> 
		<strong> <?php echo $media['mf_title'] ?> </strong>
		<p class="hidden-xs"> <?php echo $media['mf_description'] ?> </p>
	</td>  
	<td align='center'>
		<!--<button class='button' title="Consultar" onclick='detail_media_file(<?php echo $media['id_media_file'] ?>);'><i class="fa fa-eye"></i></button>-->
		<button class='button' title="Descargar" onclick='open_file("mf",<?php echo $media['id_media_file'] ?>);'><i class="fa fa-download"></i></button>
	</td>
</tr>