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
						<h4><?php echo $pvt->pdv_type; ?></h4>
							<span class="contact-avatar" style="width:70px;">
								<i class="fa fa-tag" style="font-size: 4em;"></i> &nbsp;&nbsp;&nbsp;&nbsp;
							</span>
						
					</div>
					
					<div class="col-lg-6 col-sm-6 follow-info">
						<div class="row">
							<span><i class="fa "></i>Numero de Tareas Asignadas</span>
						</div>
						
						<div class="row">
							<span><i class="fa "></i><strong><?php echo count($pvt->task_types); ?></strong></span>
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
							<a href="#activity-information" data-toggle="tab"> <i class="fa fa-info "></i> <span class='hidden-xs'>&nbsp;Información</span> </a>
						</li>
					</ul>
				</div>
				<div class="panel-body">
					<div class="tab-content">
						<!-- Info -->
						<div class="tab-pane active" id="activity-information">
							<section class="panel"> 
								<div class="panel-body bio-graph-info">
									<h1 > Información </h1> 
									<div class="row ">
										<div class="col-xs-12 col-sm-12">
											<p><label class="col-xs-12">Tareas </label>  &nbsp; </p>
										</div>
									</div>
									
									<div class="row ">
										<div class="col-xs-12 col-sm-12" style="max-height: 200px; overflow-y: scroll; ">
											<table id='tbl_task_type' class="table table-striped table-bordered table-hover">
												<thead>
													<tr>
														<th>ID</th>
														<th>Actividad</th>
													</tr>
												</thead>
												
												<tbody>
													<?php echo $pvt->get_task_type_html(); ?>
												</tbody>
												
										   </table>
										</div>
									</div>
									
									
									
									<div class="clearfix">&nbsp;</div>
									
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