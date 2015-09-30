<?php
 $visit = $record;
 global $Session; 
?> 
<tr>
	<td align='center'> <?php echo $visit['id_visit'] ?> </td>    
	<td align='center'> <?php echo date('Y/m/d H:i',$visit['vi_scheduled_start']) ?> </td>
	<!--<td align='center'> <?php echo date('Y/m/d H:i',$visit['vi_scheduled_end']) ?> </td>-->
	<td align='center'> <?php echo $visit['vi_real_start'] 	? date('Y/m/d H:i',$visit['vi_real_start'])  	: "-"; ?> </td>
	<!--<td align='center'> <?php echo $visit['vi_real_end'] 	? date('Y/m/d H:i',$visit['vi_real_end'])  	: "-"; ?> </td>-->
	<td > <?php echo $visit['us_user'] ?> </td>
	<td > <?php echo $visit['pdv_name'] ?> </td>
	<td align='center'> <?php echo $visit['vs_visit_status'] ?> </td>  
	<td align='center'>    
		<button class='button' title="Consultar" onclick='detail_visit(<?php echo $visit['id_visit'] ?>);'><i class="fa fa-eye"></i></button>	
		<script>	 
			var new_location=[ '<?php echo $visit['pdv_name']; ?>', <?php echo $visit['vi_latitude']; ?>, <?php echo $visit['vi_longitude']; ?>];
 			newpoint.push(new_location);
 			$(document).ready(function(){
 				$("#div-<?php echo $visit['pdv_jde']; ?>").hide();
 			});
		</script>	
	</td>
</tr>