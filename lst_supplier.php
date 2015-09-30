<?php 
require_once DIRECTORY_CLASS . "class.admin.lst.php";	
global $Index; 
$list = new AdminList( 'lst_supplier' ); 
?>
<script> 
	var command = '<?php echo $Index->command;  ?>';  
</script>
<div id="dashboard-header" class="row">
	<div class="col-xs-12 ">
		<h2> Mayoristas </h2>
	</div>  
</div> 
<div id='suppliers-content' class='row content-info'> 
	<div class="col-xs-12 col-sm-12">
		<div class='row-fluid'>  
			<div id="dashboard-overview" class="row" style=""> 
				<div class="col-xs-9">
					<h3 id='lbl_table_suppliers'> Listado de Mayoristas </h3> 
				</div>
				<div id='fnc_table_suppliers' class='col-xs-3 pull-right ' style='padding-top: 15px;'> 
					<button class="btn btn-default pull-right" type="button" title="Crear Mayorista" onclick='edit_supplier(0);' data-target="#mdl_frm_supplier" data-toggle="modal"> 
						<i class="fa fa-plus"></i><span class='hidden-xs hidden-sm' >Crear Mayorista</span>
					</button> 
				</div> 
				<div class="col-xs-12 col-sm-12" style="min-height: 400px; overflow-x:auto;"> 
					<table class="table table-striped table-bordered table-hover datatable" id='tbl_supplier'>
						 <?php $list->get_list_html();  ?>
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

<!-- Supplier Detail Modal  -->
<div id="mdl_detail_supplier" class="modal fade"  role="dialog" aria-labelledby="mdl_detail_supplier" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true" onclick="clean_form();"> &times; </button>
				<h4 id="mdl_frm_supplier_title" class="modal-title">Información de Mayorista</h4>
			</div> 
			<div class="modal-body" id='detail_supplier_content'>
				
			</div>  
			<div class="modal-footer">
				<input type='hidden' id='inp_detail_id_supplier' name='detail_id_supplier' value='0' />  
				<button type="button" class="btn btn-default" data-dismiss="modal">
					<i class='fa fa-times'></i> &nbsp; Cerrar
				</button>
			</div> 
		</div>
	</div>
</div>

<!-- Supplier Form Modal --> 
<div id="mdl_frm_supplier" class=" modal fade"  role="dialog" aria-labelledby="mdl_frm_supplier" aria-hidden="true">
	<div class="modal-dialog modal-sm">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true" onclick="clean_form();"> &times; </button>
				<h4 id="mdl_frm_supplier_title" class="modal-title">Edición de Mayorista</h4>
			</div>
			<form id="frm_supplier" class="form-horizontal" role="form" method="post" action="admin.supplier.php" >
				<div class="modal-body">   
					<fieldset>   
						<div class="form-group"> 
							<div class="col-xs-12">
								<label class="control-label">Mayorista</label>
								<input type="text" id="inp_supplier" name="supplier" class="form-control" value="" required  data-validation="required unique-supplier" />
							</div>  
						</div>  
					</fieldset> 
				</div>
				<div class="modal-footer">
					<input type='hidden' id='inp_id_supplier' name='id_supplier' value='' />
					<input type='hidden' id='inp_action'  name='action' value='edit_supplier' />
					<button type="button" class="btn btn-default" data-dismiss="modal" onclick="cancel_supplier_edition();">
						<i class="fa fa-times"></i> Cancelar
					</button>
					<button type="submit" class="btn btn-check" onclick="save_supplier_admin();" >
						<i class="fa fa-save"></i> Aceptar
					</button>
				</div>
			</form>
		</div>
	</div>
</div>  

<!-- Branch Form Modal --> 
<div id="mdl_frm_branch" class="modal fade"  role="dialog" aria-labelledby="mdl_frm_branch" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true" onclick="clean_branch_form();"> &times; </button>
				<h4 id="mdl_frm_branch_title" class="modal-title">Edición de Sucursal</h4>
			</div>
			<form id="frm_branch" class="form-horizontal" role="form" method="post" action="admin.supplier.php" >
				<div class="modal-body">   
					<fieldset>   
						<div class="form-group"> 
							<div class="col-xs-12">
								<label class="control-label">Sucursal </label>
								<input type="text" id="inp_ba_branch" name="branch" class="form-control" value="" required  data-validation="required " />
							</div>  
							<div class="col-xs-12">
								<label class="control-label">Número </label>
								<input type="text" id="inp_ba_number" name="number" class="form-control" value="" required  data-validation="required " />
							</div>  
						</div>
					</fieldset> 
				</div>
				<div class="modal-footer">
					<input type='hidden' id='inp_ba_id_supplier' name='id_supplier' value='' />
					<input type='hidden' id='inp_id_branch' 	 name='id_branch' value='' />
					<input type='hidden' id='inp_action'  		 name='action' value='edit_branch' />
					<button type="button" class="btn btn-default" data-dismiss="modal" onclick="clean_branch_form();">
						<i class="fa fa-times"></i> Cancelar
					</button>
					<button type="submit" class="btn btn-check" onclick="save_branch_admin();" >
						<i class="fa fa-save"></i> Aceptar
					</button>
				</div>
			</form>
		</div>
	</div>
</div>  