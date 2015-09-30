<?php
	require_once DIRECTORY_CLASS .'class.paperstore.php';
	$report = new Paperstore();
?>

	<div class="row" id="dashboard-header">
		<div class="col-xs-10 col-sm-12">
			<h2> Dashboard </h2>
		</div>  
	</div> 
	<div id='dashboard-content' class='row'> 
		
		<div class="col-xs-12 col-sm-4">
			<div class="box ">
				<div class="box-header">
					<div class="box-name">
						<i class="fa fa-briefcase"></i>
						<span>V E N T A S</span>
					</div>
					
					<div class="no-move"></div>
				</div>
				<div class="box-content">
					<div style="min-height: 80px; position: relative;" >
						<div class="col-sm-12 text-center">
							<h1><?php echo '$ '.number_format($report->sales, 2); ?></h1>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="col-xs-12 col-sm-4">
			<div class="box">
				<div class="box-header">
					<div class="box-name">
						<i class="fa fa-desktop"></i>
						<span>C I B E R</span>
					</div>
					
					<div class="no-move"></div>
				</div>
				<div class="box-content">
					<div style="min-height: 80px; position: relative;" > 
						<div class="col-sm-12 text-center">
							<h1><?php echo '$ '.number_format($report->leasing, 2); ?></h1>
						</div>
					</div>
				</div>
			</div>
		</div>
		
		<div class="col-xs-12 col-sm-4">
			<div class="box ">
				<div class="box-header">
					<div class="box-name">
						<i class="fa fa-money"></i>
						<span>T O T A L </span>
							
					</div>
					
					<div class="no-move"></div>
				</div>
				<div class="box-content">
					<div style="min-height: 80px; position: relative;" >
						<div class="col-sm-12 text-center">
							<h1><?php echo '$ '.number_format($report->total, 2); ?></h1>
						</div>
					</div>
				</div>
			</div>
		</div>
		
		<div class="col-xs-12 col-sm-4">
			<div class="box ">
				<div class="box-header">
					<div class="box-name">
						<i class="fa fa-money"></i>
						<span>G A N A N C I A S</span>
							
					</div>
					
					<div class="no-move"></div>
				</div>
				<div class="box-content">
					<div style="min-height: 80px; position: relative;" >
						<div class="col-sm-12 text-center">
							<h1><?php echo '$ '.number_format($report->profit, 2); ?></h1>
						</div>
					</div>
				</div>
			</div>
		</div>
		
	</div>