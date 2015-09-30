<?php
if ( !isset( $_GET['cat']) && $_GET['cat'] != '' ){
	require_once DIRECTORY_BASE . "404.php";
	die();
} 
require_once DIRECTORY_CLASS . "class.admin.catalogue.php"; 
require_once DIRECTORY_CLASS . "class.catalogue.lst.php";
global $Index;

$cat = $_GET['cat'];
$cat_admin 	= new CatalogueAdmin( $cat ); 

$listado 	= new CatalogueList($cat);
?>
<script> 
	var command = '<?php echo $Index->command;  ?>';
	var catalogue = '<?php echo $cat;  ?>';

var unique;
$(document).ready(function() {
	load_catalogue_admin(); 
});
</script>
<div id="dashboard-header" class="row">
	<div class="col-xs-12 ">
		<h2> <?php echo $cat_admin->lbl ?> </h2>
	</div>  
</div>
<div id='catalogues-content' class='row content-info'> 
	<div class="col-xs-12 col-sm-12">
		<div class='row-fluid'>  
			<div id="dashboard-overview" class="row" style=""> 
				<div class="col-xs-9">
					<h3 id='lbl_table_catalogues'> Listado de <?php echo $cat_admin->lbl ?> </h3> 
				</div>
				<div id='fnc_table_catalogues' class='col-xs-3 pull-right ' style='padding-top: 15px;'> 
					<button class="btn btn-default pull-right" type="button" title="Crear <?php echo $cat_admin->lbl ?>" onclick="edit_catalogue(0);" >
						<i class="fa fa-plus"></i><span class='hidden-xs hidden-sm' >Crear <?php echo $cat_admin->lbl ?></span>
					</button> 
				</div> 
				<div class="col-xs-12 col-sm-12" style="min-height: 400px; overflow-x:auto;"> 
					<table class="table table-striped table-bordered table-hover datatable" id='tbl_<?php echo $cat ?>'>
						 <?php  $listado->get_list_html();  ?>
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
<div id="mdl_frm_catalogue" class="modal fade"  role="dialog" aria-labelledby="mdl_frm_catalogue" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true" onclick="clean_form();"> &times; </button>
				<h4 id="mdl_frm_catalogue_title" class="modal-title">Edición de <?php echo $cat_admin->lbl ?></h4>
			</div>
			<form id="frm_catalogue" class="form-horizontal" role="form" method="post" action="admin.catalogues.php" >
				<div class="modal-body">   
					<fieldset>  
						<?php if ( $cat_admin->parent ) { ?>
						<div class="form-group"> 
							<div class="col-xs-12">
								<label class="control-label"><?php echo $cat_admin->lbl_parent ?></label>
								<select id="inp_cat_id_parent" name="cat_id_parent" class="form-control" required data-validation="required" >
									<?php echo $catalogue->get_catalgue_options( $cat_admin->parent, 0 );  ?>
								</select>
							</div>  
						</div> 
						<?php }  else { ?>
							<input type="hidden" id="inp_cat_id_parent" name="cat_id_parent" value="0" />
						<?php }?> 
						<div class="form-group"> 
							<div class="col-xs-12">
								<label class="control-label"><?php echo $cat_admin->lbl ?></label>
								<input type="text" id="inp_cat_value" name="cat_value" class="form-control" value="" required  data-validation="required unique-catalogue-admin" />
							</div>  
						</div>  
					</fieldset> 
				</div>
				<div class="modal-footer">
					<input type='hidden' id='inp_id_catalogue' name='id_catalogue' value='' />
					<input type='hidden' id='inp_catalogue' name='catalogue' value='<?php echo $cat ?>' />
					<input type='hidden' id='inp_action'  name='action' value='edit_catalogue_admin' />
					<button type="button" class="btn btn-default" data-dismiss="modal" onclick="cancel_catalogue_edition();">
						<i class="fa fa-times"></i> Cancelar
					</button>
					<button type="submit" class="btn btn-check" onclick="save_catalogue_admin();" >
						<i class="fa fa-save"></i> Aceptar
					</button>
				</div>
			</form>
		</div>
	</div>
</div>  