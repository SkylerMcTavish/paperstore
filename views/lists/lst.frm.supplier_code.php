<?php 
global $Session;
if ( $Session->is_admin() ){ ?>
	<div class="row ">
		<div class="col-xs-6"> <?php echo $code->supplier ?> </div>
		<div class="col-xs-6 text-center"> <?php echo $code->code ?> </div> 
	</div> 
<?php } ?>