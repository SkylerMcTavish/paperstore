<?php 
global $Session;
if ( !$Session->is_admin() ){  
	require_once DIRECTORY_VIEWS . "base/403.php";
	die();
}  
global $Index; 
require_once DIRECTORY_CLASS . "class.admin.lst.php";	
$list = new AdminList( 'lst_order' ); 
?>
<script> 
	var command 	= '<?php echo $Index->command;  ?>';
	var frm_command = '<?php echo PRY_FRM_FORM ?>';
</script>
<div id="dashboard-header" class="row">
	<div class="col-xs-12 ">
		<h2> <i class="fa fa-film"> </i> &nbsp; Pedidos </h2> 
	</div>  
</div>
<div id='orders-content' class='row content-info'>
	<div class="col-xs-12 col-sm-12">
		<div class='row-fluid'>  
			<div class="row" style=""> 
				<div class="col-xs-12">
					<h3 id='lbl_table_orders'> Pedidos </h3> 
				</div>  
				<div class="col-xs-12 col-sm-12" style="min-height: 400px; overflow-x:auto;"> 
					<table class="table table-striped table-bordered table-hover datatable" id='tbl_order'>
						 <?php $list->get_list_html(); ?>
					</table> 
				</div>
			</div> 
			<div class="clearfix"></div>
		</div>
	</div>
</div>