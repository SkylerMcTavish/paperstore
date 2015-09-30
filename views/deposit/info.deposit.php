<?php 
	ini_set('display_errors', TRUE);
?>
<section class="wrapper" id='deposit-info'>
	<div class="row">
		<!-- contact-widget -->
		<div class="col-lg-12">
			<div class="contact-widget contact-widget-info">
				<div class="panel-body">
					<div class="col-lg-4 col-sm-4">
						<h4><?php echo $deposit->user; ?></h4>
							<span class="contact-avatar" style="width:70px;">
								<i class="fa fa-tag" style="font-size: 4em;"></i> &nbsp;&nbsp;&nbsp;&nbsp;
							</span>
						
					</div>
					
					<div class="col-lg-4 col-sm-4 follow-info">
						<div class="row">
							<span><i class="fa fa-calendar"></i><?php echo date('Y-m-d', $deposit->date) ?></span>
						</div>
						
						<div class="row">
							<span><i class="fa fa-clock-o"></i><?php echo date('H:i:s', $deposit->date) ?></span>
						</div>
						
					</div>
					
					<div class="col-lg-4 col-sm-4 follow-info">
						<div class="row">
							<span><i class="fa "></i><strong><?php echo $deposit->folio; ?></strong></span>
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
										<div class="col-xs-12 col-sm-12">
											<p><label class="col-xs-4">Usuario </label>  &nbsp; <?php echo $deposit->user; ?> </p>
										</div>
										
									</div>
									
									<div class="row ">
										<div class="col-xs-12 col-sm-12">
											<p><label class="col-xs-4">Folio </label>  &nbsp; <?php echo $deposit->folio; ?> </p>
										</div>
										
									</div>
									
									<div class="row ">
										<div class="col-xs-12 col-sm-12">
											<p><label class="col-xs-4">Fecha</label>  &nbsp; <?php echo date('Y-m-d', $deposit->date) ?> </p>
										</div>
										
									</div>
									
									<div class="row ">
										<div class="col-xs-12 col-sm-12">
											<p><label class="col-xs-4">Total </label>  &nbsp; <?php echo '$ '.number_format($deposit->total, 2, "." , ",") ?> </p>
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