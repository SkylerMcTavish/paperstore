<?php 
	ini_set('display_errors', TRUE);
?>
<section class="wrapper" id='prospect-info'>
	<div class="row">
		<!-- contact-widget -->
		<div class="col-lg-12">
			<div class="contact-widget contact-widget-info">
				<div class="panel-body">
					<div class="col-lg-4 col-sm-4">
						<h4><?php echo $prospect->name; ?></h4>
							<span class="contact-avatar" style="width:70px;">
								<i class="fa fa-tag" style="font-size: 4em;"></i> &nbsp;&nbsp;&nbsp;&nbsp;
							</span>
						
					</div>
					
					<div class="col-lg-4 col-sm-4 follow-info">
						<div class="row">
							<span><i class="fa fa-calendar"></i><?php echo date('Y-m-d', $prospect->timestamp) ?></span>
						</div>
						
						<div class="row">
							<span><i class="fa fa-clock-o"></i><?php echo date('H:i:s', $prospect->timestamp) ?></span>
						</div>
						
					</div>
					
					<div class="col-lg-4 col-sm-4 follow-info">
						<div class="row">
							<span><i class="fa "></i>Usuario</span>
						</div>
						
						<div class="row">
							<span><i class="fa "></i><strong><?php echo $prospect->user; ?></strong></span>
						</div>
						
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
						<li><a href="#prospect_address" data-toggle="tab"><i class="fa fa-money"></i> <span class='hidden-xs'>&nbsp;Direccion</span> </a> </li>
						<li><a href="#prospect_contact" data-toggle="tab"><i class="fa fa-money"></i> <span class='hidden-xs'>&nbsp;Contacto</span> </a> </li>
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
											<p><label class="col-xs-4">Usuario </label>  &nbsp; <?php echo $prospect->user; ?> </p>
										</div>
										
									</div>
									
									<div class="row ">
										<div class="col-xs-12 col-sm-6">
											<p><label class="col-xs-4">Nombre </label>  &nbsp; <?php echo $prospect->name; ?> </p>
										</div>
										
									</div>
									
									<div class="row ">
										<div class="col-xs-12 col-sm-6">
											<p><label class="col-xs-4">Lastname</label>  &nbsp; <?php echo $prospect->lastname; ?> </p>
										</div>
										
									</div>
									
									<div class="row ">
										<div class="col-xs-12 col-sm-6">
											<p><label class="col-xs-4">Lastname2</label>  &nbsp; <?php echo $prospect->lastname2; ?> </p>
										</div>
										
									</div>
									
									<div class="row ">
										<div class="col-xs-12 col-sm-6">
											<p><label class="col-xs-4">Canal</label>  &nbsp; <?php echo $prospect->channel; ?> </p>
										</div>
										
									</div>
									
									<div class="row ">
										<div class="col-xs-12 col-sm-6">
											<p><label class="col-xs-4">Division</label>  &nbsp; <?php echo $prospect->division; ?> </p>
										</div>
										
									</div>
									
									<div class="row ">
										<div class="col-xs-12 col-sm-6">
											<p><label class="col-xs-4">Ruta</label>  &nbsp; <?php echo $prospect->route; ?> </p>
										</div>
										
									</div>
									
								</div>
							</section> 
						</div>
						<div class="tab-pane " id="prospect_address">
							<section class="panel"> 
								<div class="panel-body bio-graph-info">
									<h1 > Direccion </h1> 
									<div class="row ">
										<div class="row ">
											<div class="col-xs-12 col-sm-12">
												<p><label class="col-xs-4">Latitud </label>  &nbsp; <?php echo $prospect->latitude; ?> </p>
											</div>
										</div>
										
										<div class="row ">
											<div class="col-xs-12 col-sm-12">
												<p><label class="col-xs-4">Longitud </label>  &nbsp; <?php echo $prospect->longitude; ?> </p>
											</div>
										</div>
										
										<div class="row ">
											<div class="col-xs-12 col-sm-12">
												<p><label class="col-xs-4">Calle </label>  &nbsp; <?php echo $prospect->street; ?> </p>
											</div>
										</div>
										<div class="row ">
											<div class="col-xs-12 col-sm-12">
												<p><label class="col-xs-4">Num. Exterior </label>  &nbsp; <?php echo $prospect->ext_num; ?> </p>
											</div>
										</div>
										<div class="row ">
											<div class="col-xs-12 col-sm-12">
												<p><label class="col-xs-4">Num. Interior </label>  &nbsp; <?php echo $prospect->int_num; ?> </p>
											</div>
										</div>
										<div class="row ">
											<div class="col-xs-12 col-sm-12">
												<p><label class="col-xs-4">Localidad </label>  &nbsp; <?php echo $prospect->district; ?> </p>
											</div>
										</div>
										<div class="row ">
											<div class="col-xs-12 col-sm-12">
												<p><label class="col-xs-4">Ciudad </label>  &nbsp; <?php echo $prospect->city	; ?> </p>
											</div>
										</div>
										<div class="row ">
											<div class="col-xs-12 col-sm-12">
												<p><label class="col-xs-4">Estado </label>  &nbsp; <?php echo $prospect->state; ?> </p>
											</div>
										</div>	
										
										
									</div>
								</div>
							</section>
						</div>
						
						<div class="tab-pane " id="prospect_contact">
							<section class="panel"> 
								<div class="panel-body bio-graph-info">
									<h1 > Contacto </h1> 
									<div class="row ">
										<div class="row ">
											<div class="col-xs-12 col-sm-12">
												<p><label class="col-xs-4">Telefono </label>  &nbsp; <?php echo $prospect->phone; ?> </p>
											</div>
										</div>
										
										<div class="row ">
											<div class="col-xs-12 col-sm-12">
												<p><label class="col-xs-4">Email </label>  &nbsp; <?php echo $prospect->email; ?> </p>
											</div>
										</div>
										
										<div class="row ">
											<div class="col-xs-12 col-sm-12">
												<p><label class="col-xs-4">RFC </label>  &nbsp; <?php echo $prospect->rfc; ?> </p>
											</div>
										</div>
										
										<div class="row ">
											<div class="col-xs-12 col-sm-12">
												<p><label class="col-xs-4">CURP </label>  &nbsp; <?php echo $prospect->curp; ?> </p>
											</div>
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