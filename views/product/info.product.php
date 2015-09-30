<?php  
?>
<section class="wrapper" id='product-info'>
	<div class="row">
		<!-- contact-widget -->
		<div class="col-lg-12">
			<div class="contact-widget contact-widget-info">
				<div class="panel-body">
					<div class="col-lg-4 col-sm-4">
						<h4><?php echo utf8_encode($product->product); ?></h4>
							<span class="contact-avatar" style="width:70px;">
								<i class="fa fa-tag" style="font-size: 4em;"></i> &nbsp;&nbsp;&nbsp;&nbsp;
							</span>
						<div class="row">
							<h6> <?php //echo ( $product->rival == 1 ? 'Producto de la Competencia' : 'Producto Propio' );  ?> </h6>
						</div>	
						
					</div>
					
					<div class="col-lg-4 col-sm-4 follow-info">
						<div class="row">
							<span><i class="fa fa-calendar"></i><?php echo date('Y-m-d', $product->timestamp) ?></span>
						</div>
						
						<div class="row">
							<span><i class="fa fa-clock-o"></i><?php echo date('H:i:s', $product->timestamp) ?></span>
						</div>
						
					</div>
					
					<div class="col-lg-4 col-sm-4 follow-info "> 
						<h5>
						<p><i class="fa ">Marca</i> &nbsp; &nbsp; &nbsp; &nbsp; <?php echo $product->brand; ?> </p>
						<p><i class="fa ">Categoría</i> &nbsp; &nbsp; &nbsp; &nbsp; <?php echo $product->category; ?> </p>
						</h5> 
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- page start-->
	<div class="row">
		<div class="col-lg-12">
			<section class="panel">
				<div class="panel-heading tab-bg-info " style="padding-bottom: 0;">
					<ul class="nav nav-tabs">
						<li class="active">
							<a href="#product-information" data-toggle="tab"> <i class="fa fa-info "></i> <span class='hidden-xs'>&nbsp;Información</span> </a>
						</li>
					</ul>
				</div>
				<div class="panel-body">
					<div class="tab-content">
						<!-- Info -->
						<div class="tab-pane active" id="product-information">
							<section class="panel"> 
								<div class="panel-body bio-graph-info">
									<h1 > Información </h1> 
									<div class="row ">
										<div class="col-xs-12 col-sm-6">
											<p><label class="col-xs-4">Nombre </label>  &nbsp; <?php echo utf8_encode($product->product); ?> </p>
										</div>
										
									</div>
									
									<div class="row ">
										<div class="col-xs-12 col-sm-6">
											<p><label class="col-xs-4">SKU </label>  &nbsp; <?php echo $product->sku; ?> </p>
										</div>
										
										<div class="col-xs-12 col-sm-6">
											<p><label class="col-xs-4"> Alias</label>  &nbsp; <?php echo $product->alias; ?></p>
										</div>
									</div>
									
									<div class="row ">
										<div class="col-xs-12 col-sm-6">
											<p><label class="col-xs-4">Proveedor </label>  &nbsp; <?php echo $product->supplier; ?> </p>
										</div>
										
									</div>
									
									<div class="row ">
										<div class="col-xs-12 col-sm-6">
											<p><label class="col-xs-4"> Descripcion </label>  &nbsp; </p>
										</div>
									</div>
									
									<div class="row ">
										<div class="col-xs-12 col-sm-12">
											<p>&nbsp;<?php echo $product->description; ?> </p>
										</div>
										
									</div>
									
									<div class="row ">
										<div class="col-xs-12 col-sm-12">
											<p><label class="col-xs-4"> Inventario  Mostrador </label>  &nbsp; <?php echo $product->bar_stock['quantity'] ?> </p>
										</div>
									</div>
									
									<div class="row ">
										<div class="col-xs-12 col-sm-12">
											<p><label class="col-xs-4"> Inventario  Bodega </label>  &nbsp; <?php echo $product->storehouse['quantity'] . '&nbsp;' . $product->storehouse['pack'] ?> </p>
										</div>
									</div>
									
								</div>
							</section> 
						</div>
						 
					</div>
				</div>
			</section>
		</div>
	</div>
	<!-- page end-->
</section>