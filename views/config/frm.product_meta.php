<?php 
global $Session;
require_once DIRECTORY_CLASS . "class.product_meta.php";
$product_meta = new ProductMeta();
?>
<script>
$(document).ready(function() {
	$.validate({
		form : '#frm_product_meta',
		language : validate_language
		//, modules : 'file'
	});
});
</script>
<div id="section-header" class="row">
	<div class="col-xs-12 ">
		<h2> Configuración de Información de Producto </h2>
	</div> 
</div> 
<?php if ( $Session->is_admin() ){ ?>
<div id='form-content' class=' content-info row '> 
	<form id="frm_product_meta" class="form-horizontal" role="form" method="post" action="configuration.php" >
	<div class="col-xs-12 col-sm-12">
		<fieldset class='row' >
			<legend class="border-bottom"> Meta datos de producto </legend> 
			<div class='row'>
				<div class="col-xs-12 col-sm-6 col-md-4 "> 
					<label class="control-label">Etiqueta<span class="text-danger">*</span>:</label>
					<input type="text" id='inp_product_meta_label' name='product_meta_label' data-validation='required' 
						class='form-control' value=''/> 
				</div> 
				<div class="col-xs-12 col-sm-6 col-md-4 "> 
					<label class="control-label">Tipo de dato<span class="text-danger">*</span>:</label>
					<select id='inp_product_meta_data_type' name='product_meta_data_type' class='form-control' data-validation='required' >
						<?php echo $catalogue->get_catalgue_options('data_type'); ?>
					</select>  
				</div> 
				<div class="col-xs-12 col-sm-6 col-md-4 "> 
					<label class="control-label">Opciones:</label>
					<input type="text" id='inp_product_meta_options' name='product_meta_options' 
						class='form-control' value=''/> 
					<small> Separar cada opción con ';' (punto y coma). </small>
				</div> 
			</div>
		</fieldset> 
		<div class="row border-top" style="margin: 10px 0;"></div>
		<div class="row ">
			<input type="hidden" name="action" value="edit_product_meta" />
			<input type="hidden" id='inp_product_meta_id' name="product_meta_id" value="edit_appearance" />
			<button type="button" class="btn btn-default" 			 onclick="clean_product_meta_form();"><i class="fa fa-refresh"></i> Cancelar </button>
			<button type="button" class="btn btn-default pull-right" onclick="save_product_meta();"><i class="fa fa-save"></i> Guardar </button>
		</div>
	</div>
	</form>
</div>
<?php } ?>
<div id='form-content' class=' content-info row '> 
	<div class="col-xs-12 col-sm-12">
		<fieldset class='row'>
			<legend class="border-bottom"> Opciones de producto </legend>
			<div class="col-xs-12 col-sm-12">
				<ul id='lst_product_options' class="list-group">
					<?php echo $product_meta->get_list_html( TRUE ) ?>
				</ul>
			</div>
		</fieldset>
	</div>
</div> 