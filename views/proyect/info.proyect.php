<?php 
 //global $proyect; 
?>
<section class="wrapper" id='user-info'>
	<div class="row">
		<!-- contact-widget -->
		<div class="col-lg-12">
			<div class="contact-widget contact-widget-info">
				<div class="panel-body">
					<div class="col-lg-4 col-sm-4">
						<h4> <?php echo $proyect->proyect ?></h4> 
						<div class="row text-center" style="font-size: 4em; margin-left: -40px;"> 
							<i class='fa fa-puzzle-piece'></i>  
						</div>
						<div class="row">
							<h6> <?php echo $proyect->proyect_type ?> </h6>
						</div>
					</div>
					<div class="col-lg-4 col-sm-4 follow-info">
						<p> 
							<span>Compañía:  <?php echo $proyect->company; ?></span>
						</p>
						<p>
							<span>Region:  <?php echo $proyect->region; ?></span>
						</p> 
						<p> &nbsp; </p> 
					</div>
					<div class="col-lg-4 col-sm-4 follow-info "> 
						<p><i class="fa fa-male"></i> Usuarios <h4><?php echo "" //$proyect->user->client ?></h4></p>
						<p><i class="fa fa-barcode"></i> Productos <h4><?php echo "" //$proyect->user->client ?></h4></p>
						<p><i class="fa fa-thumb-tack"></i> PDVs <h4><?php echo "" //$proyect->user->client ?></h4></p>  
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
							<a href="#contact" data-toggle="tab"> <i class="fa fa-info-circle "></i> <span class='hidden-xs'>&nbsp;Información</span> </a>
						</li>
						<li>
							<a href="#recent-activity" data-toggle="tab"><i class="fa fa-clock-o"></i> <span class='hidden-xs'>&nbsp;Actividad reciente</span> </a>
						</li> 
					</ul>
				</div>
				<div class="panel-body">
					<div class="tab-content">
						<!-- contact -->
						<div class="tab-pane active" id="contact">
							<section class="panel"> 
								<div class="panel-body bio-graph-info">
									<h1 class="col-xs-10"> Información </h1>
									<div class="col-xs-2">
										<button class="btn btn-default pull-right" style='margin-top: -10px;' onclick="edit_proyect(<?php echo $proyect->id_proyect ?>)" >
											<i class="fa fa-edit"></i> Editar 
										</button> 
									</div>
									<div class="row ">
										<div class="col-xs-12 col-sm-6">
											<p>
												<label class="col-xs-4">Jornada </label> <?php echo $proyect->shift_start . ":00 - " . $proyect->shift_end . ":00" ?> &nbsp;
											</p> 
											<p>
												<label class="col-xs-4">Visitas al día </label> <?php echo $proyect->day_visits ?> &nbsp;
											</p> 
											<p>
												<label class="col-xs-4">Días laborales </label> <?php echo $proyect->str_workdays ?> &nbsp;
											</p>
										</div>
										<div class="col-xs-12 col-sm-6">
											<label> Cíclos </label>
											<p>
												<ul>
													<li>  </li> 
												</ul> 
											</p>
										</div>
									</div>
									<div class='row'>&nbsp;</div> 
								</div>
							</section>
							<section>
								<div class="row"></div>
							</section>
						</div>
						<!-- recent-activity -->
						<div class="tab-pane" id="recent-activity">
							<div class="contact-activity">
								<div class="act-time">
									<div class="activity-body act-in">
										<span class="arrow"></span>
										<div class="text"> 
											 
										</div>
									</div>
								</div>
								<div class="act-time">
									<div class="activity-body act-in">
										<span class="arrow"></span>
										<div class="text"> 
											 
										</div>
									</div>
								</div>  
							</div>
						</div> 
					</div>
				</div>
			</section>
		</div>
	</div>
	<!-- page end-->
</section>