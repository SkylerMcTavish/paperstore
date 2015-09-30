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
						<h4><?php echo $activity->activity; ?></h4>
							<span class="contact-avatar" style="width:70px;">
								<i class="fa fa-tag" style="font-size: 4em;"></i> &nbsp;&nbsp;&nbsp;&nbsp;
							</span>
						
					</div>
					
					<div class="col-lg-4 col-sm-4 follow-info">
						<div class="row">
							<span><i class="fa fa-calendar"></i><?php echo date('Y-m-d', $activity->timestamp) ?></span>
						</div>
						
						<div class="row">
							<span><i class="fa fa-clock-o"></i><?php echo date('H:i:s', $activity->timestamp) ?></span>
						</div>
						
					</div>
					
					<div class="col-lg-4 col-sm-4 follow-info">
						<div class="row">
							<span><i class="fa "></i>Tipo de Actividad</span>
						</div>
						
						<div class="row">
							<span><i class="fa "></i><strong><?php echo ($activity->default_activity > 0 ? 'Por Defecto' : 'Creada por el usuario' ) ?></strong></span>
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
						<?php if($activity->id_aux > 0  ){ ?>
						<li><a href="#activity-auxiliar" data-toggle="tab"><i class="fa fa-list"></i> <span class='hidden-xs'>&nbsp;Apoyo</span> </a> </li>
						<?php }?>
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
										<div class="col-xs-12 col-sm-6">
											<p><label class="col-xs-4">Nombre </label>  &nbsp; <?php echo $activity->activity; ?> </p>
										</div>
									</div>
									
									<div class="row ">
										<div class="col-xs-12 col-sm-12">
											<p><label class="col-xs-4">Tipo de Actividad </label>  &nbsp; <?php echo $activity->activity_type->activity_type; ?></p>
										</div>
									</div>
									
									<div class="row ">
										<div class="col-xs-12 col-sm-12">
											<p><label class="col-xs-12">
											<?php echo ($activity->default_activity > 0 ? 'Actividad por defecto, no puede ser modificada.' : '' ) ?> </label> </p>
										</div>
									</div>
									
									<div class="row ">
										<div class="col-xs-12 col-sm-12">
											<p><label class="col-xs-4">Descripción </label>  &nbsp; </p>
										</div>
									</div>
									
									<div class="row ">
										<div class="col-xs-12 col-sm-12">
											<textarea readonly="true" class="form-control" style="resize: none" >  &nbsp; <?php echo $activity->description; ?>  </textarea>
										</div>
									</div>
									
									<div class="clearfix">&nbsp;</div>
									
								</div>
							</section> 
						</div>
						
						<!-- Info -->
						<div class="tab-pane" id="activity-auxiliar">
							<section class="panel"> 
								<div class="panel-body bio-graph-info">
									<h1 > Material de Apoyo </h1> 
									<div class="row ">
										<div class="col-xs-12 col-sm-6">
											<p><label class="col-xs-6">Tabla Auxiliar</label>  &nbsp; <?php echo $activity->activity_type->label_table_aux; ?> </p>
										</div>
									</div>
									
									<div class="row ">
										<div class="col-xs-12 col-sm-6">
											<p><label class="col-xs-6">Articulo Auxiliar</label>  &nbsp; <?php echo $activity->lbl_aux; ?> </p>
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