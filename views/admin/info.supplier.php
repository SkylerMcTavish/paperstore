<?php 
 //global $supplier; 
?>
<section class="wrapper" id='supplier-info'>
	<div class="row">
		<!-- contact-widget -->
		<div class="col-lg-12">
			<div class="contact-widget contact-widget-info">
				<div class="panel-body">
					<div class="col-lg-6 col-sm-6">
						<h4> <?php echo $supplier->supplier ?></h4> 
						<div class="row text-center">
							<span class="contact-avatar">
								<i class="fa fa-truck"> </i>
							</span>
						</div>
						<div class="row">
							<h6> <?php echo "" ?> </h6>
						</div>
					</div>
					<div class="col-lg-6 col-sm-6 ">
						<p> <?php echo $supplier->supplier ; ?> </p> 
						<p> &nbsp; </p>
						<h6> 
							<span><i class="fa fa-suitcase"></i><?php echo count( $supplier->branches ) ?> Sucursales</span> 
						</h6>
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
							<a href="#branches" data-toggle="tab"> 
								<i class="fa fa-suitcase "></i> <span class='hidden-xs'> &nbsp; Sucursales</span> 
							</a>
						</li> 
					</ul>
				</div>
				<div class="panel-body">
					<div class="tab-content">
						<!-- contact -->
						<div class="tab-pane active" id="contact">
							<section class="panel"> 
								<div class="panel-body bio-graph-info">
									<h1 class="col-xs-10"> Sucursales </h1>
									<div class="col-xs-2">
										<button class="btn btn-default pull-right" style='margin-top: -10px;' onclick="edit_branch( <?php echo $supplier->id_supplier ?>, 0)" >
											<i class="fa fa-edit"></i> Agregar sucursal 
										</button> 
									</div>
									<div class="row "> 
										<table class="table table-striped table-bordered table-hover datatable" id='tbl_branches'>
											<thead><tr> <th> Sucursal </th> <th> No. </th> <th style="width: 100px;"> </th> </tr></thead>
											<tbody>
										<?php foreach ($supplier->branches as $k => $branch ) {
											?>
											<tr>
												<td> <?php echo $branch->branch ?> </td>
												<td align="center"> <?php echo $branch->num ?> </td>
												<td align="center">
													<button class='button' title="Editar" 	 onclick='edit_branch(<?php echo $supplier->id_supplier ?>, <?php echo $branch->id_branch ?>);'><i class="fa fa-edit"></i></button> 
													<button class='button' title="Borrar" 	 onclick='delete_branch(<?php echo $branch->id_branch ?>);'><i class="fa fa-trash-o"></i></button>
												</td>
											</tr> 
											<?php 
											}
										?> 	</tbody>
										</table>
									</div> 
								</div>
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