<?php 
global $Session;
$deposit = $record;
?>
<tr>
	<td align='center'> <?php echo $deposit['id_deposit'] ?> </td> 
	<td align='center'> <?php echo $deposit['us_user'] ?> </td>  
	<td> <?php echo $deposit['dp_folio'] ?> </td>  
	<td> <?php echo date('Y-m-d', $deposit['dp_date'] ) ?> </td>
	<td> <?php echo '$ '.number_format($deposit['dp_total'], 2, "," , ".") ?> </td>
	<td align='center'>
		<!--<button class='button' title="Evidencia" 	 onclick='evidence_deposit('<?php echo $deposit['ev_route'] ?>');'><i class="fa fa-camera"></i></button>-->
		<a target="_blank" href="file.php?<?php echo 'id='.$deposit['dp_ev_id_evidence'].'&type=ev' ?>" <i class="fa fa-camera"></i></a>
	</td>
	<td align='center'>   
		<button class='button' title="Detalle" 	 onclick='detail_deposit(<?php echo $deposit['id_deposit'] ?>);'><i class="fa fa-eye"></i></button>
	</td>
</tr>