<?php 
global $Session;
if ( !$Session->is_admin() ){  
	require_once DIRECTORY_VIEWS . "base/403.php";
	die();
}
global $Index;
require_once DIRECTORY_CLASS . "class.paying.php";	
$list = new Paying();
?>
<script> 
	var command 	= '<?php echo $Index->command;  ?>';
</script>
<div id="dashboard-header" class="row">
	<div class="col-xs-12 ">
		<h2> <i class="fa fa-suitcase"> </i> &nbsp; Liquidación </h2> 
	</div>  
</div>
<div id='paying-content' class='row'> 
	<div class="col-xs-12 col-sm-12">
		<div class='row-fluid'>
		
			<div id="paying_links" class="col-xs-12 col-sm-2 pull-right tabs-links" >
				<ul class="nav nav-pills nav-stacked"> 
					<li>
						<span clas='tab-link'>
							<div class="row "> 
								<div class="col-xs-12 " style="margin-bottom: 7px;">
									<select class="form-control" id="inp_id_user" >
									<?php 	echo $catalogue->get_catalgue_options( 'user', 0, 'Usuario' ); ?>
									</select>
								</div>
							</div>
						</span>
					</li>
					
					<li>
						<span clas='tab-link'>
							<div class="row "> 
								<div class="col-xs-12 " style="margin-bottom: 7px;">
									<div id="datetimepicker4" class="input-append">
										<input type="text" id="inp_fecha" name="fecha" value="<?php echo date('d/m/Y'); ?>" class="form-control">				 
									</div>
								</div>
							</div>
						</span>
					</li>
					
					<li>
						<span clas='tab-link'>
							<div class="row "> 
								<div class="col-xs-12 " style="margin-bottom: 7px;">
									<div id="datetimepicker4" class="input-append">
										<button class="btn btn-default" type="button" title="Consultar" onclick='load_info();' > 
											<i class="fa fa-info"></i> <span class='hidden-xs hidden-sm' >Consultar Reporte</span>
										</button>
									</div>
								</div>
							</div>
						</span>
					</li>
				</ul>
			</div>
			
			<div id="paying_tabs" class="col-xs-12 col-sm-10 tabs-content content-info" style='margin-top: 0;'>
				<div class="row" style="visibility: visible; position: relative;"> 
					<div class="col-xs-12">
						<h3 id='lbl_table_payings'> Liquidación </h3> 
					</div>
					<div id='fnc_table_payings' class='col-xs-3 pull-right ' style='padding-top: 15px;'>
						
					</div> 
					<div class="col-xs-12 col-sm-12" id="paying_report" style=" overflow-x:auto;"> 
						<?php $list->get_list_html(); ?>
					</div>
				</div>
			</div> 
		
			
			<div class="clearfix"></div>
		</div>
	</div>
</div>