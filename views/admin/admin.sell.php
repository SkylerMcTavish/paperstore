<?php
global $Session;
if ( !$Session->is_admin() ){
	require_once DIRECTORY_VIEWS . "base/403.php";
	die();
}
else
{ 
	require_once DIRECTORY_CLASS . "class.admin.sell.php";
	if ( isset( $_GET['id_sell'] ) && $_GET['id_sell'] > 0 )
	{ 
		$id_sell = $_GET['id_sell'];	
	}
	else
	{
		$id_sell = 0; 
	}  
	$sell = new AdminSell( $id_sell ); 
?>

<script> 
	var command 	= '<?php echo $Index->command;  ?>';
	var cb = '<?php echo PAPERSTORE; ?>';
</script>

<div id="section-header" class="row">
	<div class="col-xs-12 "> <h2> Registro de Venta </h2> </div>
	<input type="hidden" id="inp_id_sell" value="<?php echo $id_sell ?>" />
</div>
<div id='form-content' class=' content-info row '> 
	<form id="frm_product" class="form-horizontal" role="form" method="post" action="admin.product.php" >
	<div class="col-xs-12 col-sm-12">  
		<div class="row "> &nbsp; </div>
		<fieldset class="row">
			<div class="row ">
				<legend class="border-bottom"> Catálogo de Productos </legend>
			</div>
			
			<div class="row "> &nbsp; </div>
			<div class="row ">
				<div class="col-xs-4 col-sm-4">  
					<label>Papeleria: </label> 
					<select id='inp_sel_id_product_paper' name='sel_id_product_paper'  class="form-control" onchange="select_product()" > 
					<?php echo $catalogue->get_catalgue_options( 'product_stock_paperstore') ?>
					</select>  
				</div>
				
				<div class="col-xs-4 col-sm-4">  
					<label>Merceria: </label> 
					<select id='inp_sel_id_product_cloth' name='sel_id_product_cloth'  class="form-control" onchange="select_product_cloth()" > 
					<?php echo $catalogue->get_catalgue_options( 'product_stock_cloth') ?>
					</select>  
				</div>
				
				<div class="col-xs-4 col-sm-4">  
					<label>Regalos: </label> 
					<select id='inp_sel_id_product_gift' name='sel_id_product_gift'  class="form-control" onchange="select_product_gift()" > 
					<?php echo $catalogue->get_catalgue_options( 'product_stock_gift') ?>
					</select>  
				</div>
			</div>
			
			<div class="row "> &nbsp; </div>
			<label>Buscar Producto </label> 
			<div class="row ">
				<div class="col-xs-12 col-sm-9">  
					<input type="text" id="inp_srch_product" name="srch_product" class="form-control" maxlength="60" /> 
				</div>
				<div class="col-xs-12 col-sm-3">  
					<button class="btn btn-default pull-left" type="button" title="Buscar Producto" onclick="search_product()"  > 
						<i class="fa fa-plus"></i> <span class='hidden-xs hidden-sm' >Buscar</span>
					</button>
				</div> 
			</div>
			
			<div class="row "> &nbsp; </div>
			<div class="row ">
				<div class="col-xs-12 col-sm-6">  
					<label>Producto: </label>
					<input type="text" id="inp_product" name="product" class="form-control" maxlength="60" readonly="readonly" /> 
					<input type="hidden" id="inp_id_product" name="id_product" class="form-control" />
					<input type="hidden" id="inp_id_stock" name="id_stock" class="form-control" /> 
				</div>
				
				<div class="col-xs-12 col-sm-3">  
					<label>Precio: </label> 
					<input type="text" id="inp_price" name="price" class="form-control" readonly="readonly" />   
				</div>
				
				<div class="col-xs-12 col-sm-3">  
					<label>Cantidad: </label> 
					<input type="number" id="inp_quantity" name="quantity" class="form-control" max="3" min="1" value="1" />   
				</div>
			</div>
			<div class="row ">
				<div class="col-xs-12 col-sm-12">  
					<button class="btn btn-default pull-right" type="button" title="Agregar Producto"  onclick="add_product()"> 
						<i class="fa fa-plus"></i> <span class='hidden-xs hidden-sm' >Agregar</span>
					</button>
				</div>
			</div>
			
			<div class="row form-group" id="edition_buttons" style="padding: 25px 5px 0px;">
				<input type="hidden" name="id_sell" id='inp_id_sell' value="<?php echo $sell->id_sell ?>" />
				<input type="hidden" name="cb" value="<?php echo $_GET['cb'] ?>" />
				<button type="reset"  class="btn btn-default" onclick="cancel_sell()" ><i class="fa fa-refresh"></i> Cancelar </button>
				<button type="button" class="btn btn-default pull-right" onclick="confirm_paybox()"><i class="fa fa-save"></i> Confirmar </button>
			</div> 
			
		<div class="row "> &nbsp; </div>
		<fieldset class="row" style="margin: 10px 0;"> 
			<div class="row ">
				<legend class="border-bottom"> Detalle de la venta </legend>
			</div>
			
			<div class="row">
				<div id="tbl_sell_detail" ><?php echo $sell->get_sell_detail_html(); ?></div>
			</div>
			
		</fieldset>
		
			 
			
			<div class="row  border-bottom">&nbsp;</div>
			<div class="row ">&nbsp;</div>
			<div class="row ">&nbsp;</div>
			
	
	</div>
	<div class="col-xs-12 border-top"  > &nbsp; </div> 
	<div class="row "> &nbsp; </div> 
	</form>
</div>
<?php } ?>