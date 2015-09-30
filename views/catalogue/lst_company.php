<?php 
global $Index; 
$listado = new DataTable('lst_company'); 

?>
<script> 
	var command = '<?php echo $Index->command;  ?>';

var unique;
$(document).ready(function() {
	load_companies();
	
});
</script>
<div id="dashboard-header" class="row">
	<div class="col-xs-12 ">
		<h2> Compañías </h2>
	</div>  
</div> 
<div id='companys-content' class='row content-info'> 
	<div class="col-xs-12 col-sm-12">
		<div class='row-fluid'>  
			<div id="dashboard-overview" class="row" style=""> 
				<div class="col-xs-9">
					<h3 id='lbl_table_companys'> Listado de Compañías </h3> 
				</div>
				<div id='fnc_table_companys' class='col-xs-3 pull-right ' style='padding-top: 15px;'> 
					<button class="btn btn-default pull-right" type="button" title="Crear Proyecto" onclick="edit_copmany(0);" >
						<i class="fa fa-plus"></i><span class='hidden-xs hidden-sm' >Crear Compañía</span>
					</button> 
				</div> 
				<div class="col-xs-12 col-sm-12" style="min-height: 400px; overflow-x:auto;"> 
					<table class="table table-striped table-bordered table-hover datatable" id='tbl_usuarios'>
						 <?php $listado->get_list_html();  ?>
					</table> 
				</div>
			</div> 
			<div class="clearfix"></div>
		</div>
	</div>
</div>


		</div>
	</div>
</div>
<!-- Modal --> 
<div id="mdl_frm_company" class="modal fade"  role="dialog" aria-labelledby="mdl_frm_company" aria-hidden="true">
	<div class="modal-dialog modal-sm">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true" onclick="clean_form();"> &times; </button>
				<h4 id="mdl_frm_company_title" class="modal-title">Edición de Compañía</h4>
			</div>
			<form id="frm_company" class="form-horizontal" role="form" method="post" action="companys.php" >
				<div class="modal-body">   
					<fieldset>  
						<div class="form-group"> 
							<div class="col-xs-12">
								<label class="control-label">Compañía</label>
								<input type="text" id="inp_company" name="company" class="form-control" value="" required  data-validation="required unique-company" />
							</div>  
						</div>  
					</fieldset> 
				</div>
				<div class="modal-footer">
					<input type='hidden' id='inp_id_company' name='id_company' value='' />
					<input type='hidden' id='inp_action'  name='action' value='edit_company' />
					<button type="button" class="btn btn-default" data-dismiss="modal" onclick="cancel_company_edition();">
						Cancelar
					</button>
					<button type="button" class="btn btn-default" onclick="save_company();" >
						Aceptar
					</button>
				</div>
			</form>
		</div>
	</div>
</div>  