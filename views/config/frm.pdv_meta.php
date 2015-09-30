<?php 
global $Session;
require_once DIRECTORY_CLASS . "class.pdv_meta.php";
$pdv_meta = new PDVMeta();
?>
<script>
$(document).ready(function() {
	$.validate({
		form : '#frm_pdv_meta',
		language : validate_language
		//, modules : 'file'
	});
});
</script>
<div id="section-header" class="row">
	<div class="col-xs-12 ">
		<h2> Configuración de Información de PDV </h2>
	</div> 
</div> 
<?php if ( $Session->is_admin() ){ ?>
<div id='form-content' class=' content-info row '> 
	<form id="frm_pdv_meta" class="form-horizontal" role="form" method="post" action="configuration.php" >
	<div class="col-xs-12 col-sm-12">
		<fieldset class='row' >
			<legend class="border-bottom"> Meta datos de PDV </legend> 
			<div class='row'>
				<div class="col-xs-12 col-sm-6 col-md-4 "> 
					<label class="control-label">Etiqueta<span class="text-danger">*</span>:</label>
					<input type="text" id='inp_pdv_meta_label' name='pdv_meta_label' data-validation='required' 
						class='form-control' value=''/> 
				</div> 
				<div class="col-xs-12 col-sm-6 col-md-4 "> 
					<label class="control-label">Tipo de dato<span class="text-danger">*</span>:</label>
					<select id='inp_pdv_meta_data_type' name='pdv_meta_data_type' class='form-control' data-validation='required' >
						<?php echo $catalogue->get_catalgue_options('data_type'); ?>
					</select>  
				</div> 
				<div class="col-xs-12 col-sm-6 col-md-4 "> 
					<label class="control-label">Opciones:</label>
					<input type="text" id='inp_pdv_meta_options' name='pdv_meta_options' 
						class='form-control' value=''/> 
					<small> Separar cada opción con ';' (punto y coma). </small>
				</div> 
			</div>
		</fieldset> 
		<div class="row border-top" style="margin: 10px 0;"></div>
		<div class="row ">
			<input type="hidden" name="action" value="edit_pdv_meta" />
			<input type="hidden" id='inp_pdv_meta_id' name="pdv_meta_id" value="edit_appearance" />
			<button type="button" class="btn btn-default" 			 onclick="clean_pdv_meta_form();"><i class="fa fa-refresh"></i> Cancelar </button>
			<button type="button" class="btn btn-default pull-right" onclick="save_pdv_meta();"><i class="fa fa-save"></i> Guardar </button>
		</div>
	</div>
	</form>
</div>
<?php } ?>
<div id='form-content' class=' content-info row '> 
	<div class="col-xs-12 col-sm-12">
		<fieldset class='row'>
			<legend class="border-bottom"> Opciones de PDV </legend>
			<div class="col-xs-12 col-sm-12">
				<ul id='lst_pdv_options' class="list-group">
					<?php echo $pdv_meta->get_list_html( TRUE ) ?>
				</ul>
			</div>
		</fieldset>
	</div>
</div> 