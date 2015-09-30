<?php 
 /*22/12/14 CS*/
 global $Session;
if ( !$Session->is_proyect_admin() || !$Session->is_proyect_admin()){  
	require_once DIRECTORY_VIEWS . "base/403.php";
	die();
} 
//require_once DIRECTORY_CLASS . "class.visit.php";
$id_proyect = $Session->get_proyect(); 
if ( !( $id_proyect > 0 ) ){ 
	$error .= "Proyecto inválido.";
	header( "Location:index.php?command=" . PRY_VISITS . "&err=" . urlencode($error) ); 
}
global $Index; 
//$proyect = new Proyect( $id_proyect ); 
require_once DIRECTORY_CLASS . "class.admin.proyect.lst.php";

if( isset ($_GET['user']) && isset($_GET['fecha'])){
	$user=$_GET['user'];
	$fecha=$_GET['fecha'];
}else{
	$user="";
	$fecha="";
}
?>



<script> var command = '<?php echo $Index->command;  ?>'; </script>
<style>
#map-canvas {
	height: 400px;
    width: 100%;
    margin: 1px;
    padding: 0px
}
</style>
<script src="https://maps.googleapis.com/maps/api/js?v=3.exp"></script>
    
<div id="section-header" class="row">
	<div class="col-xs-12 "> <h2> Visitas </h2> </div> 
</div>
<div id='form-content' class=' content-info row '> 
	<form id="frm_usr_visit" class="form-horizontal" role="form" method="GET">
		<div class="col-xs-12 col-sm-12">  
		<div class="row "> &nbsp; </div>
		<fieldset class="row">
			<div class="row ">
				<legend class="border-bottom"> Información del Formulario </legend>
			</div> 
			<div class="col ">
				<div class="col-xs-12 col-sm-6">  
					<label>Usuario </label> 
					<select id='inp_user' name='user' class="form-control" data-validation="select-option " >
						<?php if(isset($user) && $user>0){
							echo $catalogue->get_catalgue_options('frm_visit', $user); 
						} else{ 
							 echo $catalogue->get_catalgue_options('frm_visit'); 
						} ?>
					</select>  
				</div> 
			</div>
			<div class="col">
				<div class="col-xs-12 col-sm-6">  
					<label>Agendar en la fecha </label> 
					<input type="text" id="inp_fecha" name="fecha" value="<?php echo $fecha; ?>" class="form-control">				 
				</div> 
			</div>
			
				<div class="row form-group" id="edition_buttons" style="padding: 25px 5px 0px;">						
					<button type="submit"  class="btn btn-default pull-right" ><i class="fa fa-plus"></i> Generar </button>
					<button type="button"  class="btn btn-default pull-right" onclick="goBack();"><i class="fa fa-refresh"></i> Regresar </button>										
					<input type="hidden" name="command" value="<?php echo $Index->command ?>" />
				</div>  
		</fieldset>
	</form>	
	</div>
	<?php	
	$user=$_GET['user'];
	if(isset($user) && $user>0){  ?>		
		<script>			
			google.maps.event.addDomListener(window, 'load', initialize);
		</script>	
		<div style="clear: both;"></div>
		<div>
		<table class="table table-striped table-bordered table-hover datatable" id='tbl_visit'>
				<?php 					
					$list 	 = new AdminProyectList( 'lst_pry_visit' );
					$list->get_list_html();  
				?> 
		</table>		
	</div>
	
	<div>		
		<div style="width: 34%; float: left;">		
			<div style="border: solid 1px #C8C8C8; padding: 5px; text-align: center;">
				<strong>PDV's</strong>
			</div>
			<?php 
				$list = new AdminProyectList( 'lst_dpdv', 'ull_pdv' );
				echo $list->get_list_html(TRUE);  
			?>
		</div>
		<div style="width: 50px; float: left;">&nbsp;
		</div>
		<div style="width: 66%; float: left;">
		    <div id="map-canvas"></div>

		</div>
	</div> 
	
	
	<?php	} ?>
</div>