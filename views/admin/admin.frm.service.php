<?php
global $Session;
if ( !$Session->is_admin() ){
	require_once DIRECTORY_VIEWS . "base/403.php";
	die();
}
else
{ 
	require_once DIRECTORY_CLASS . "class.admin.service.php";
	if ( isset( $_GET['id_service'] ) && $_GET['id_service'] > 0 )
	{ 
		$id_service = $_GET['id_service'];	
	}
	else
	{
		$id_service = 0; 
	}  
	$service = new AdminService( $id_service ); 
?>

<script> 
	var command 	= '<?php echo $Index->command;  ?>';
	var cb = '<?php echo LST_SERVICE; ?>';
	var id_service = '<?php echo $id_service; ?>';
</script>

<div id="section-header" class="row">
	<div class="col-xs-12 "> <h2> Asignar Productos al Servicio <?php echo $service->service; ?> </h2> </div>
	<input type="hidden" id="inp_id_sell" value="<?php echo $id_service ?>" />
</div>
<div id='form-content' class=' content-info row '> 
	<form id="frm_product" class="form-horizontal" role="form" method="post" action="admin.service.php" >
	<div class="col-xs-12 col-sm-12">  
		<div class="row "> &nbsp; </div>
		<fieldset class="row">
			<div class="row ">
				<legend class="border-bottom"> Catálogo de Productos </legend>
			</div>
			
			<div class="row "> &nbsp; </div>
			<div class="row ">
				<div class="col-xs-12 col-sm-12">  
					<label>Papeleria: </label> 
					<select id='inp_sel_id_product_paper' name='sel_id_product_paper'  class="form-control" onchange="select_product()" > 
					<?php echo $catalogue->get_catalgue_options( 'product_stock_paperstore') ?>
					</select>  
				</div>
			</div>
			
			<div class="row ">
				<div class="col-xs-12 col-sm-12">  
					<button class="btn btn-default pull-right" type="button" title="Agregar Producto"  onclick="add_product()"> 
						<i class="fa fa-plus"></i> <span class='hidden-xs hidden-sm' >Agregar</span>
					</button>
				</div>
			</div> 
			
		<div class="row "> &nbsp; </div>
		<fieldset class="row" style="margin: 10px 0;"> 
			<div class="row ">
				<legend class="border-bottom"> Productos Asignados </legend>
			</div>
			
			<div class="row">
				<div id="tbl_service_detail" ><?php echo $service->get_list_html(); ?></div>
			</div>
			
		</fieldset>
		
			<div class="row form-group" id="edition_buttons" style="padding: 25px 5px 0px;">
				<input type="hidden" name="id_sell" id='inp_id_sell' value="<?php echo $service->id_service ?>" />
				<input type="hidden" name="cb" value="<?php echo $_GET['cb'] ?>" />
				<button type="reset"  class="btn btn-default" onclick="cancel_sell()" ><i class="fa fa-refresh"></i> Cancelar </button>
				<button type="button" class="btn btn-default pull-right" onclick="confirm_service()"><i class="fa fa-save"></i> Confirmar </button>
			</div>  
			
			<div class="row  border-bottom">&nbsp;</div>
			<div class="row ">&nbsp;</div>
			<div class="row ">&nbsp;</div>
			
	
	</div>
	<div class="col-xs-12 border-top"  > &nbsp; </div> 
	<div class="row "> &nbsp; </div> 
	</form>
</div>
<?php } ?>