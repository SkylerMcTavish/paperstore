<?php
?>
<section class="wrapper" id='order-info'> 
	<div class="row">
		<div class="col-lg-12">
			<section class="panel"> 
				<div class="panel-body">
					<div class="tab-content">
						<!-- Info -->
						<div class="tab-pane active" id="order-information">
							<section class="panel"> 
								<div class="panel-body bio-graph-info">
									<h1 > Información </h1> 
									<div class="row ">
										<div class="col-xs-12 col-sm-6">
											<p><label class="col-xs-4">Folio </label>  &nbsp; <?php echo $order->folio; ?> </p>
										</div> 
										<div class="col-xs-12 col-sm-6">
											<p><label class="col-xs-4">Fecha </label>  &nbsp; <?php echo date('Y-m-d H:i', $order->date); ?> </p>
										</div> 
									</div> 
									<div class="row "> 
										<div class="col-xs-12 col-sm-6">
											<p><label class="col-xs-4">PDV </label>  &nbsp; <?php echo $order->pdv; ?> </p>
										</div>
										
										<div class="col-xs-12 col-sm-16">
											<p><label class="col-xs-4"> Usuario</label>  &nbsp; <?php echo $order->user; ?></p>
										</div>
									</div> 
									<div class="row "> &nbsp; </div> 
									<div class="row ">
										<div class="col-xs-12 col-sm-12">
											<table class="table table-striped table-bordered table-hover ">
												<thead>
													<tr> <th> Cantidad </th><th> Producto </th><th> Precio </th><th> Subtotal </th> </tr>
												</thead>
												<tbody>
													<?php
														$subtot = 0;  
														foreach ($order->detail as $k => $det) {
													?>
														<tr>
															<td align='center'> <?php echo $det->quantity ?></td>
															<td> <?php echo $det->product ?></td>
															<td align='right'>$ <?php echo number_format( $det->price, 2 ) ?></td>
															<td align='right'>$ <?php echo number_format(($det->price * $det->quantity), 2 ) ?></td>
														</tr>
													<?php
														$subtot += $det->price * $det->quantity; 
													} ?> 
												</tbody>
												<tfoot>
													<tr>
														<td colspan='2'>&nbsp; </td>
														<td align='right'>Subtotal: </td>
														<td align='right'>$ <?php echo number_format( $subtot, 2 ) ?></td> 
													</tr>
													<tr>
														<td colspan='2'>&nbsp; </td>
														<td align='right'>IVA: </td>
														<td align='right'>$ <?php echo number_format( $subtot * 0.15, 2 ) ?></td> 
													</tr>
													<tr>
														<td colspan='2'>&nbsp; </td>
														<td align='right'>Total: </td>
														<td align='right'>$ <?php echo number_format( $subtot * 1.15, 2 ) ?></td> 
													</tr>
												</tfoot>
											</table> 
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