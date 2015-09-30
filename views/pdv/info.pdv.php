<?php 
 //global $pdv; 
 //$pdv = new PDV();
?>
<section class="wrapper" id='pdv-info'>
	<div class="row">
		<!-- contact-widget -->
		<div class="col-lg-12">
			<div class="contact-widget contact-widget-info">
				<div class="panel-body">
					<div class="col-lg-4 col-sm-4">
						<h4> <?php echo $pdv->name ?></h4> 
						<div class="row text-center">
							<span class="contact-avatar" style="width:70px;">
								<i class="fa fa-map-marker" style="font-size: 4em;"></i> &nbsp;&nbsp;
							</span>
						</div>
						<div class="row">
							<h6> <?php echo $pdv->pdv_type ?> </h6>
						</div>
					</div>
					<div class="col-lg-4 col-sm-4 follow-info">  
						<p> &nbsp; </p>
						<h6>
							<span><i class="fa fa-calendar"></i><?php echo date('Y-m-d',$pdv->timestamp) ?></span><br/>
							<span><i class="fa fa-flag"></i><?php echo $pdv->address->country ?></span><br/>
							<span><i class="fa fa-book"></i><?php echo $pdv->contact->business_name ?></span><br/>
							<span><i class="fa fa-envelope-o"></i><?php echo $pdv->contact->email ?></span>
						</h6>
					</div>
					<div class="col-lg-4 col-sm-4 follow-info "> 
						<h5>
						<p><i class="fa ">Canal</i> &nbsp; &nbsp; &nbsp; &nbsp; <?php echo $pdv->channel ?></p>
						<p><i class="fa ">Grupo</i> &nbsp; &nbsp; &nbsp; &nbsp; <?php echo $pdv->group 	?></p>
						<p><i class="fa ">Formato</i> &nbsp; &nbsp; &nbsp; &nbsp; <?php echo $pdv->format ?></p> 
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
							<a href="#pdv-information" data-toggle="tab"> <i class="fa fa-info "></i> <span class='hidden-xs'>&nbsp;Información</span> </a>
						</li>
						<li><a href="#pdv-contact" data-toggle="tab"><i class="fa fa-envelope-o"></i> <span class='hidden-xs'>&nbsp;Contacto</span> </a> </li>
						<li><a href="#pdv-address" data-toggle="tab"><i class="fa fa-map-marker"></i> <span class='hidden-xs'>&nbsp;Dirección</span> </a> </li>
						<!--<li><a href="#pdv-schedule" data-toggle="tab"><i class="fa fa-calendar"></i> <span class='hidden-xs'>&nbsp;Horario</span> </a> </li>-->
						<li><a href="#pdv-meta" data-toggle="tab"><i class="fa fa-info"></i> <span class='hidden-xs'>&nbsp;Extra </span> </a> </li> 
					</ul>
				</div>
				<div class="panel-body">
					<div class="tab-content">
						<!-- Info -->
						<div class="tab-pane active" id="pdv-information">
							<section class="panel"> 
								<div class="panel-body bio-graph-info">
									<h1 > Información </h1> 
									<div class="row ">
										<div class="col-xs-12 col-sm-6">
											<p><label class="col-xs-4">Nombre </label> <?php echo $pdv->name ?> &nbsp; </p>
										</div>
										<div class="col-xs-12 col-sm-6">
											<p><label class="col-xs-4">Ruta </label> <?php echo $pdv->route ?> &nbsp; </p>
										</div>
										<div class="col-xs-12 col-sm-6">
											<p><label class="col-xs-4">JDE </label> <?php echo $pdv->jde ?> &nbsp; </p>
										</div>
										<div class="col-xs-12 col-sm-6">
											<p><label class="col-xs-4">Canal </label> <?php echo $pdv->channel ?> &nbsp; </p>
										</div>
										<div class="col-xs-12 col-sm-6">
											<p><label class="col-xs-4">Grupo </label> <?php echo $pdv->group ?> &nbsp; </p>
										</div>
										<div class="col-xs-12 col-sm-6">
											<p><label class="col-xs-4">Formato </label> <?php echo $pdv->format ?> &nbsp; </p>
										</div>
									</row>
								</div>
							</section> 
							<section class="panel"> 
								<div class="panel-body bio-graph-info">
									<h1 > Horario </h1> 
									<div class="row ">
										<div class="col-xs-12 col-sm-6">
											<p><label class="col-xs-4">Frecuencia </label> <?php echo $pdv->schedule->business_name ?> &nbsp; </p>
										</div>
										<div class="col-xs-12 col-sm-6">
											<p><label class="col-xs-4">Horario </label> <?php echo $pdv->schedule->schedule_from . ":00 - " . $pdv->schedule->schedule_to . ":00"  ?> &nbsp; </p>
										</div>
										<div class="col-xs-12 col-sm-6">
											<p><label class="col-xs-4">Días de Visita </label> <?php echo $pdv->schedule->weekdays_str ?> &nbsp; </p>
										</div>  
									</row>
								</div>
							</section>
						</div>
						<div class="tab-pane " id="pdv-contact">
							<section class="panel"> 
								<div class="panel-body bio-graph-info">
									<h1 > Contacto </h1> 
									<div class="row ">
										<div class="col-xs-12 col-sm-6">
											<p><label class="col-xs-4">Razón Social </label> <?php echo $pdv->contact->business_name ?> &nbsp; </p>
										</div>
										<div class="col-xs-12 col-sm-6">
											<p><label class="col-xs-4">RFC </label> <?php echo $pdv->contact->rfc ?> &nbsp; </p>
										</div>
										<div class="col-xs-12 col-sm-6">
											<p><label class="col-xs-4">Teléfono 1 </label> <?php echo $pdv->contact->phone_1 ?> &nbsp; </p>
										</div>
										<div class="col-xs-12 col-sm-6">
											<p><label class="col-xs-4">CURP </label> <?php echo $pdv->contact->curp ?> &nbsp; </p>
										</div>
										<div class="col-xs-12 col-sm-6">
											<p><label class="col-xs-4">E-mail </label> <?php echo $pdv->contact->email ?> &nbsp; </p>
										</div> 
									</row>
								</div>
							</section>
						</div>	
						<div class="tab-pane " id="pdv-address">
							<section class="panel"> 
								<div class="panel-body bio-graph-info">
									<h1 > Dirección </h1> 
									<div class="row ">
										<div class="col-xs-12">
											<p><label class="col-xs-4">Calle </label> <?php echo $pdv->address->street ?> &nbsp; </p>
										</div>
										<div class="col-xs-6">
											<p><label class="col-xs-4">Num. Ext. </label> <?php echo $pdv->address->ext_num ?> &nbsp; </p>
										</div>
										<div class="col-xs-6">
											<p><label class="col-xs-4">Int. Ext. </label> <?php echo $pdv->address->ext_num ?> &nbsp; </p>
										</div>
										<div class="col-xs-12 col-sm-6">
											<p><label class="col-xs-4">Colonia </label> <?php echo $pdv->address->locality ?> &nbsp; </p>
										</div>
										<div class="col-xs-12 col-sm-6">
											<p><label class="col-xs-4">Municipio / Delegación </label> <?php echo $pdv->address->district ?> &nbsp; </p>
										</div>
										<div class="col-xs-12 col-sm-6">
											<p><label class="col-xs-4">Ciudad </label> <?php echo $pdv->address->city_code ?> &nbsp; </p>
										</div> 
										<div class="col-xs-12 col-sm-6">
											<p><label class="col-xs-4">C.P. </label> <?php echo $pdv->address->zipcode ?> &nbsp; </p>
										</div> 
										<div class="col-xs-12 col-sm-6">
											<p><label class="col-xs-4">Estado </label> <?php echo $pdv->address->state ?> &nbsp; </p>
										</div> 
										<div class="col-xs-12 col-sm-6">
											<p><label class="col-xs-4">Paìs </label> <?php echo $pdv->address->country ?> &nbsp; </p>
										</div> 
									</row>
									<div class="row"> &nbsp; </div>
									<section >
										<h2> Mapa </h2> 
										<div class="row "> 
											<div class="col-xs-6">
												<p><label class="col-xs-4">Latitud </label> <?php echo $pdv->latitude ?> &nbsp; </p>
												<input type="hidden" id='det_pdv_latitude' value='<?php echo $pdv->latitude ?>' />
											</div>
											<div class="col-xs-6">
												<p><label class="col-xs-4">Longitud </label> <?php echo $pdv->longitude ?> &nbsp; </p>
												<input type="hidden" id='det_pdv_longitude' value='<?php echo $pdv->longitude ?>' />
											</div>
										</div>
										<div id='map-pdv' style="height: 400px;">
											
										</div>
									</section>
								</div>
							</section>
						</div>	
						<div class="tab-pane " id="pdv-meta">
							<section class="panel"> 
								<div class="panel-body bio-graph-info">
									<h1 > Datos Extras </h1>
									<div class="row "> 
									<?php echo $pdv->meta->get_values_list(); ?>
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