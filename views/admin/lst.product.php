<?php
/*paperstore*/
require_once DIRECTORY_CLASS . "class.admin.lst.php";	
global $Index; 
$list = new AdminList( 'lst_product' ); 
?>
<script> 
	var command = '<?php echo $Index->command;  ?>';  
	var cmd_frm = '<?php echo FRM_PRODUCT;  ?>';  
	var map;
	var product_marker;  
</script>
<style>
	.tabs-links .nav { background-color: #454545; }
</style>
<div id="dashboard-header" class="row">
	<div class="col-xs-12 ">
		<h2> <i class="fa fa-tag"> </i>&nbsp; Productos </h2>
	</div> 
</div> 
<div id='products-content' class='row '>
	<div class="col-xs-12 col-sm-12">
		<div class='row-fluid'>
			<div id="product_links" class="col-xs-12 col-sm-2 pull-right tabs-links" >
				<ul class="nav nav-pills nav-stacked"> 
					<li>
						<span clas='tab-link'>
							<div class="row "> 
								<div class="col-xs-12 " style="margin-bottom: 7px;">
									<select class="form-control" id="flt_brand" onchange="reload_product_table();" >
								<?php 	echo $catalogue->get_catalgue_options( 'brand', 0, 'Marca' ); ?>
									</select>
								</div>
								<div id='btns_brand' class="col-xs-12 text-right " style="display:none;"> 
									<button onclick="edit_brand(0)"> <i class='fa fa-plus'></i> </button>
									<button onclick="edit_brand($('#flt_brand').val())"> <i class='fa fa-pencil'></i> </button>
									<button onclick="delete_brand($('#flt_brand').val())"> <i class='fa fa-trash-o'></i> </button> 
								</div>	
								<div class="col-xs-12 text-center" style="cursor:pointer;" onclick="$('#btns_brand').toggle();" >
									<span class="text-center"> <i class="fa fa-angle-down"></i> </span>
								</div>
							</div>
						</span>
					</li>
				</ul>
			</div>
			<div id="product_tabs" class="col-xs-12 col-sm-10 tabs-content content-info" style='margin-top: 0;'>
				<div class="row" style="visibility: visible; position: relative;"> 
					<div class="col-xs-9">
						<h3 id='lbl_table_products'> Listado de Productos </h3> 
					</div>
					<div id='fnc_table_products' class='col-xs-3 pull-right ' style='padding-top: 15px;'>
						<!--
						<button class="btn btn-default pull-right" type="button" title="Crear Producto" onclick='edit_product(0);' > 
							<i class="fa fa-plus"></i> <span class='hidden-xs hidden-sm' >Crear Producto</span>
						</button>
						<button class="btn btn-default pull-right" type="button" title="Cargar Producto" onclick='load_products()' > 
							<i class="fa fa-upload"></i> <span class='hidden-xs hidden-sm' >Cargar Productos</span>
						</button>
						--> 
						<div class="btn-group pull-right">
							<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
								<i class="fa fa-plus"></i><span class='hidden-xs hidden-sm' >Cargar Productos</span> <span class="caret"></span>
							</button>
							<ul class="dropdown-menu" role="menu">
								<li><a href="#" title="Crear Producto" onclick='edit_product(0);' data-target="#mdl_frm_product" data-toggle="modal">Crear Productos</a></li> 
								<li><a href="#" title="Importar Visitas" onclick='load_products();' data-target="#mdl_upload_product" data-toggle="modal">Importar Productos</a></li> 
								<li><a href="uploads/tmpl.product_load.csv" title="Descargar Plantilla" target="_blank" > Descargar Plantilla </a></li>  
							</ul>
						</div>
					</div> 
					<div class="col-xs-12 col-sm-12" style="min-height: 400px; overflow-x:auto;"> 
						<table id='tbl_product' class="table table-striped table-bordered table-hover datatable">
							 <?php $list->get_list_html();  ?>
						</table> 
					</div>
				</div>
			</div> 
			<div class="clearfix"></div>
		</div>
	</div>
</div> 