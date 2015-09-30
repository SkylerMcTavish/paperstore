<?php 
global $Session;
if ( $Session->is_admin() ){  
	?>
	<div class="row">
		<div class="col-xs-6"> <?php echo $price->product_presentation ?> </div>
		<div class="col-xs-2 text-center"> <?php echo $price->units ?> </div>
		<div class="col-xs-4 text-right"> $ <?php echo number_format( $price->price, 2 ) ?> </div> 
	</div> 
<?php } ?>