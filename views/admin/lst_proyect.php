<?php
require_once DIRECTORY_CLASS . "class.proyect.lst.php";

global $Index; 
$listado = new ProyectList('lst_proyect'); 
?>
<script> 
	var command = '<?php echo $Index->command;  ?>'; 
	var frm_command = '<?php echo FRM_PROYECT;  ?>'; 
</script>
<div id="dashboard-header" class="row">
	<div class="col-xs-12 ">
		<h2> Proyectos </h2>
	</div>  
</div> 
<div id='proyects-content' class='row content-info'> 
	<div class="col-xs-12 col-sm-12">
		<div class='row-fluid'>  
			<div id="dashboard-overview" class="row" style=""> 
				<div class="col-xs-9">
					<h3 id='lbl_table_proyects'> Listado de Proyectos </h3> 
				</div>
				<div id='fnc_table_proyects' class='col-xs-3 pull-right ' style='padding-top: 15px;'>
					<a href='index.php?command=<?php echo FRM_PROYECT ?>' > 
						<button class="btn btn-default pull-right" type="button" title="Crear Proyecto" >
							<i class="fa fa-plus"></i><span class='hidden-xs hidden-sm' >Crear Proyecto</span>
						</button>
					</a>
				</div> 
				<div class="col-xs-12 col-sm-12" style="min-height: 400px; overflow-x:auto;"> 
					<table class="table table-striped table-bordered table-hover datatable" id='tbl_proyect'>
						 <?php $listado->get_list_html();  ?>
					</table> 
				</div>
			</div> 
			<div class="clearfix"></div>
		</div>
	</div>
</div> 