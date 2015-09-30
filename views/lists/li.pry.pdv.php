<?php $pdv = $record;  ?>

<div id="div-<?php echo $pdv['pdv_name']; ?>" style="border: solid 1px #C8C8C8; border-radius: 3px 3px 3px 3px; width: 100%; height: 75px; padding: 2px;">
	<div id="id_pdv_<?php echo $pdv['id_pdv'] ?>" style="float: left;">
			
		<ul  id='ull_pdv'>		
				<li>PDV:<span> <?php echo $pdv['pdv_name'] ?> </span> </li>
				<li>Tipo: <span><?php echo $pdv['pvt_pdv_type'] ?></span></li>				
				<li>Zona: <span> <?php echo $pdv['pdv_zone'] ?> </span>  </li>										
		</ul>
	</div>
	<div style="float: right; margin-right: 5px; margin-top: 10px;">
	<button type="button"  class="btn btn-default pull-right" title="Agregar" onclick="openerf('<?php echo $pdv['pdv_name']; ?>', '<?php echo $pdv['id_pdv']; ?>', '<?php echo $pdv['pdv_latitude'] ?>', '<?php echo $pdv['pdv_longitude'] ?>');">
		<i class="fa fa-plus" ></i> <span class='hidden-xs hidden-sm' >Agregar </span>
	</button>	
	</div>
</div>
