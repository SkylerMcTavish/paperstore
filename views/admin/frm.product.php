<?php
global $Session;
if ( !$Session->is_admin() ){
	require_once DIRECTORY_VIEWS . "base/403.php";
	die();
} else { 
	require_once DIRECTORY_CLASS . "class.product.php";
	if ( isset( $_GET['id_pd'] ) && $_GET['id_pd'] > 0 ){ 
		$id_product = $_GET['id_pd'];	
	} else {
		$id_product = 0; 
	}  
	$product = new Product( $id_product ); 
?>
<!-- Mapa --> 
<script type="text/javascript" > 
	var unique_product;
	var unique_sku;
$(document).ready(function() {
	
	$.formUtils.addValidator({
		name : 'unique-product',
		validatorFunction : function(value, $el, config, language, $form) {
			if (value.length > 5){
				is_unique( value );
				return unique;
			} else 
				return true;
		},
		errorMessage : 'El producto ya existe. ',
		errorMessageKey: 'badProductUnique'
	});
	
	$.formUtils.addValidator({
		name : 'unique-viamente',
		validatorFunction : function(value, $el, config, language, $form) {
			if (value.length > 5){
				is_unique_viamente( value );
				return unique;
			} else 
				return true;
		},
		errorMessage : 'El sku ya existe. ',
		errorMessageKey: 'badSKUUnique'
	});
	
	$.validate({
		form : '#frm_product',
		language : validate_language 
	}); 
});
</script>
<div id="section-header" class="row">
	<div class="col-xs-12 "> <h2> Edición de Producto </h2> </div> 
</div>
<div id='form-content' class=' content-info row '> 
	<form id="frm_product" class="form-horizontal" role="form" method="post" action="admin.product.php" >
	<div class="col-xs-12 col-sm-12">  
		<div class="row "> &nbsp; </div>
		<fieldset class="row">
			<div class="row ">
				<legend class="border-bottom"> Información de Producto </legend>
			</div>
			<div class="row ">
				<div class="col-xs-12 col-sm-6">   
					<div class="col-xs-6 ">  
						<div class="input-group">
					      	<span class="input-group-addon">
					        	<input type="radio" id='inp_rival_t' name='rival' value="0" <?php echo  $product->rival ? "" : "checked='checked'"; ?> onchange="filter_rivals('inp_rival', 'inp_id_brand' )"/>
					      	</span> <label class='form-control'>Propio</label>
					    </div><!-- /input-group -->
					</div> 
					<div class="col-xs-6 ">  
						<div class="input-group">
					      	<span class="input-group-addon">
					      		<input type="radio" id='inp_rival_f' name='rival' value="1" <?php echo  $product->rival ? "checked='checked'" : ""; ?> onchange="filter_rivals('inp_rival', 'inp_id_brand' )"/>
					      	</span> <label class='form-control'>Competencia</label>
					    </div><!-- /input-group -->
					</div>   
				</div>
			</div> 
			<div class="row "> &nbsp; </div>
			<div class="row ">
				<div class="col-xs-12 col-sm-12">  
					<label>Marca: </label> 
					<select id='inp_id_brand' name='id_brand'  class="form-control"
						 data-validation="select-option " onchange="filter_options('inp_id_family',  'family', this.value );" > 
					<?php echo $catalogue->get_catalgue_options( 'brand', $product->id_brand ) ?>
					</select>  
				</div>
				
			</div>
			<div class="row ">
				<div class="col-xs-12 col-sm-6">  
					<label>Producto </label> 
					<input type="text" id="inp_product" name="product" class="form-control" maxlength="60"
						data-validation="required unique-product" value="<?php echo $product->product ?>" /> 
				</div>
				<div class="col-xs-12 col-sm-6">  
					<label>Sku </label>
					<input type="text" id="inp_sku" name="sku" class="form-control" maxlength="40"
						data-validation="required unique-sku" value="<?php echo $product->sku ?>" /> 
				</div> 
			</div>
			<div class="row ">
				<div class="col-xs-12 col-sm-6">  
					<label>Descripción: </label> 
					<textarea id="inp_description" name="description" class="form-control" ><?php echo $product->description ?></textarea>  
				</div>
				<div class="col-xs-12 col-sm-6">  
					<label>Caducidad: </label> 
					<input type="text" id="inp_expiration" name="expiration" class="form-control" maxlength="40"
						data-validation=" " value="<?php echo $product->expiration ?>" />   
				</div>
			</div> 
			
		<div class="row "> &nbsp; </div>
		<fieldset class="row" style="margin: 10px 0;"> 
			<div class="row ">
				<legend class="border-bottom"> Información de producto </legend>
			</div>
			<?php echo $product->meta->get_frm_html( 'inp_',"col-xs-12 col-sm-6"   ); ?> 
		</fieldset>
		
			<div class="row form-group" id="edition_buttons" style="padding: 25px 5px 0px;">
				<input type="hidden" name="action" value="edit_product" />
				<input type="hidden" name="id_product" id='inp_id_product' value="<?php echo $product->id_product ?>" />
				<input type="hidden" name="cb" value="<?php echo $_GET['cb'] ?>" />
				<button type="reset"  class="btn btn-default" onclick="window.location='index.php?command=<?php echo LST_PRODUCT ?>'"><i class="fa fa-refresh"></i> Regresar </button>
				<button type="submit" class="btn btn-default pull-right"><i class="fa fa-save"></i> <?php echo $product->id_product > 0 ? "Guardar" : "Actualizar" ?> </button>
			</div>  
			
			<div class="row  border-bottom">&nbsp;</div>
			<div class="row ">&nbsp;</div>
			<div class="row ">&nbsp;</div>
			
	<?php  if ( $product->id_product > 0 ) { ?>  
			<div class="row">
				<div class="col-xs-12 col-md-6"> 
					<fieldset title="Precios" class=" row">
						<legend> Precios </legend> 
						<div class="col-xs-12">
							<div class="row border-top border-sides border-bottom " style="padding: 5%; border-radius: 5px;"> 
								<div class="form-group">
									<div class="col-xs-12 col-sm-6 ">  
										<label>Precio: </label> 
										<input type="text" id="inp_price" class="form-control" maxlength="120" value="" />   
									</div> 
									<div class="col-xs-12 col-sm-6 ">
										<label>Contenedor: </label>  
										<select id='inp_product_presentation' class="form-control" >
										<?php echo $catalogue->get_catalgue_options( 'product_presentation' ) ?>
										</select>
									</div> 
									<div class="col-xs-12 col-sm-6 ">
										<label>Unidades: </label> 
										<input type="number" id="inp_units" class="form-control" min="0" value="" />   
									</div> 
									<div class="col-xs-12 col-sm-6 text-center" style="padding: 25px 5px 0px;">
										<button type="button" class="btn btn-default" onclick="save_price();" > Agregar </button>
									</div>
								</div>  
							</div>
							<div class="row ">
								<div class="col-xs-1 "> &nbsp; </div> 
								<div class="col-xs-10 ">
									 <div class="row" id="prices_rows">
									 	<?php echo $product->get_prices_frm_lst() ?>
									 </div>
								</div> 
								<div class="col-xs-1 "> &nbsp; </div> 
							</div>
						</div>
					</fieldset> 
				</div> 
				<div class="col-xs-12 col-md-1 "> &nbsp;</div>
				<div class="col-xs-12 col-md-5 "> 
					<fieldset title="Códigos de Mayorista" class="row">
						<legend> Códigos de Mayorista </legend> 
						<div class="col-xs-12">
							<div class="row border-top border-sides border-bottom" style="padding: 5%; border-radius: 5px;"> 
								<div class="form-group">
									<div class="col-xs-12 col-sm-6 ">  
										<label>Mayorista: </label>
										<select id='inp_id_supplier' class="form-control" >
										<?php echo $catalogue->get_catalgue_options( 'supplier' ) ?>
										</select>     
									</div> 
									<div class="col-xs-12 col-sm-6 ">
										<label>Código: </label> 
										<input type="text" id="inp_code" class="form-control" maxlength="20" value="" />   
									</div> 
									<div class="col-xs-12 col-sm-6 text-center" style="padding: 25px 5px 0px; ">
										<button type="button" class="btn btn-default" onclick="save_supplier_code();"> Agregar </button>
									</div>
								</div>  
							</div>
							<div class="row ">
								<div class="col-xs-1 "> &nbsp; </div> 
								<div class="col-xs-10 "> 
									 <div class="row" id="supplier_codes_rows">
									 	<?php echo $product->get_supplier_codes_frm_lst() ?>
									 </div>
								</div> 
								<div class="col-xs-1 "> &nbsp; </div> 
							</div>
						</div>  
					</fieldset>
				</div>
			</div> 
			
		</fieldset>  
		<div class="row "> &nbsp; </div>  
	<?php } ?> 
	</div>
	<div class="col-xs-12 border-top"  > &nbsp; </div> 
	<div class="row "> &nbsp; </div> 
	</form>
</div>
<?php } ?>