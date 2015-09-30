<?php 
	ini_set('display_errors', TRUE);
?>
<section class="wrapper" id='payment-info'>
	<div class="row">
		<!-- contact-widget -->
		<div class="col-lg-12">
			<div class="contact-widget contact-widget-info">
				<div class="panel-body">
					<div class="col-lg-4 col-sm-4">
						<h4><?php echo $payment->user; ?></h4>
							<span class="contact-avatar" style="width:70px;">
								<i class="fa fa-tag" style="font-size: 4em;"></i> &nbsp;&nbsp;&nbsp;&nbsp;
							</span>
						
					</div>
					
					<div class="col-lg-4 col-sm-4 follow-info">
						<div class="row">
							<span><i class="fa fa-calendar"></i><?php echo date('Y-m-d', $payment->date_payment) ?></span>
						</div>
						
						<div class="row">
							<span><i class="fa fa-clock-o"></i><?php echo date('H:i:s', $payment->date_payment) ?></span>
						</div>
						
					</div>
					
					<div class="col-lg-4 col-sm-4 follow-info">
						<div class="row">
							<span><i class="fa "></i>Tipo de Pago</span>
						</div>
						
						<div class="row">
							<span><i class="fa "></i><strong><?php echo $payment->payment_method; ?></strong></span>
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
						<?php if($payment->id_invoice > 0  ){ ?>
						<li><a href="#payment_invoice" data-toggle="tab"><i class="fa fa-money"></i> <span class='hidden-xs'>&nbsp;Factura</span> </a> </li>
						<?php }?>
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
											<p><label class="col-xs-4">Usuario </label>  &nbsp; <?php echo $payment->user; ?> </p>
										</div>
										
									</div>
									
									<div class="row ">
										<div class="col-xs-12 col-sm-6">
											<p><label class="col-xs-4">PDV </label>  &nbsp; <?php echo $payment->pdv; ?> </p>
										</div>
										
									</div>
									
									<div class="row ">
										<div class="col-xs-12 col-sm-6">
											<p><label class="col-xs-4">Tipo de Pago </label>  &nbsp; <?php echo $payment->payment_method; ?> </p>
										</div>
										
									</div>
									
									<div class="row ">
										<div class="col-xs-12 col-sm-6">
											<p><label class="col-xs-4"> Fecha del Pago</label>
											&nbsp; <?php echo date('Y-m-d',$payment->date_payment) ?></p>
										</div>
										
										<div class="col-xs-12 col-sm-6">
											<p><label class="col-xs-4"> Fecha de registro </label>
											&nbsp;<?php echo date('Y-m-d',$payment->date) ?> </p>
										</div>
										
									</div>
									
									<div class="row ">	
										<div class="col-xs-12 col-sm-6">
											<p><label class="col-xs-4"> Factura </label>
											&nbsp;<?php echo $payment->invoice->folio; ?> </p>
										</div>
										
										<div class="col-xs-12 col-sm-6">
											<p><label class="col-xs-4"> Total </label>
											&nbsp;<?php echo '$ ' . number_format($payment->total, 2, "." , ","); ?> </p>
										</div>
										
									</div>
									
								</div>
							</section> 
						</div>
						<div class="tab-pane " id="payment_invoice">
							<section class="panel"> 
								<div class="panel-body bio-graph-info">
									<h1 > Factura </h1> 
									<div class="row ">
										<div class="row ">
											<div class="col-xs-12 col-sm-12">
												<p><label class="col-xs-4">Folio </label>  &nbsp; <?php echo $payment->invoice->folio; ?> </p>
											</div>
										</div>
										
										<div class="row ">
											<div class="col-xs-12 col-sm-12">
												<p><label class="col-xs-4">Fecha </label>  &nbsp; <?php echo date('Y-m-d, H:i:s', $payment->invoice->date ); ?> </p>
											</div>
										</div>
										
										<div class="row ">
											<div class="col-xs-12 col-sm-12">
												<p><label class="col-xs-4">Total</label>  &nbsp; <?php echo '$ '.number_format($payment->invoice->total, 2, "." , ","); ?> </p>
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