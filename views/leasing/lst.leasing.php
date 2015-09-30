<?php 
global $Session;
if ( !$Session->is_admin() ){  
	require_once DIRECTORY_VIEWS . "base/403.php";
	die();
}
global $Index;
require_once DIRECTORY_CLASS . "class.admin.lst.php";	
$list = new AdminList( 'lst_leasing' ); 

?>
<script> 
	var command 	= '<?php echo $Index->command;  ?>';
</script>
<div id="dashboard-header" class="row">
	<div class="col-xs-12 ">
		<h2> <i class="fa fa-clipboard"> </i> &nbsp; Rentas </h2> 
	</div>  
</div>
<div id='leasing-content' class='row content-info'> 
	<div class="col-xs-12 col-sm-12">
		<div class='row-fluid'>  
			<div id="dashboard-overview" class="row" style=""> 
				<div class="col-xs-12">
					<h3 id='lbl_table_leasing'> Rentas </h3> 
				</div>
				<div class="col-xs-12 col-sm-12" style="min-height: 400px; overflow-x:auto;">
					<table class="table table-striped table-bordered table-hover datatable" id='tbl_leasing'>
						 <?php $list->get_list_html();  ?>
					</table> 
				</div>
			</div> 
			<div class="clearfix"></div>
		</div>
	</div>
</div>