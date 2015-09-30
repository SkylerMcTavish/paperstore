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
						<h4><?php echo $sell->us_user; ?></h4>
							<span class="contact-avatar" style="width:70px;">
								<i class="fa fa-tag" style="font-size: 4em;"></i> &nbsp;&nbsp;&nbsp;&nbsp;
							</span>
						
					</div>
					
					<div class="col-lg-4 col-sm-4 follow-info">
						<div class="row">
							<span><i class="fa fa-calendar"></i><?php echo date('Y-m-d', $sell->date) ?></span>
						</div>
						
						<div class="row">
							<span><i class="fa fa-clock-o"></i><?php echo date('g:i A', $sell->date) ?></span>
						</div>
						
					</div>
					
					<div class="col-lg-4 col-sm-4 follow-info">
						<div class="row">
							<span><i class="fa "></i>Total:&nbsp;&nbsp;<strong><?php echo '$'.number_format($sell->total,2,'.',',') ?></strong></span>
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
									<h1 > Lista de Productos </h1> 
									<div class="row ">
										<div class="col-xs-12 col-sm-12" style="min-height: 400px; overflow-x:auto;"> 
											<table id='tbl_sell_product' class="table table-striped table-bordered table-hover datatable">
												<thead>
													<tr>
														<th>Producto</th>
														<th>Cantidad</th>
														<th>Precio</th>
													</tr>
												</thead>
												<tbody>
													<?php echo $sell->get_detail_list_html();  ?>
													<tr>
														<td></td>
														<td>Subtotal:</td>
														<td><?php echo '$&nbsp;'.number_format($sell->subtotal, 2,'.',','); ?></td>
													</tr>
													
													<tr>
														<td></td>
														<td>Total:</td>
														<td><?php echo '$&nbsp;'.number_format($sell->total, 2,'.',','); ?></td>
													</tr>
												 </tbody>
											</table> 
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