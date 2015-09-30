<?php
global $Session;
if ( !$Session->is_proyect_admin() ){  
	require_once DIRECTORY_VIEWS . "base/403.php";
	die();
}  
require_once DIRECTORY_CLASS . "class.admin.pry.form.php";
$id_proyect = $Session->get_proyect(); 
if ( !( $id_proyect > 0 ) ){ 
	$error .= "Proyecto inválido.";
	header( "Location:index.php?command=" . LST_PROYECT . "&err=" . urlencode($error) ); 
}

if ( isset($_GET['id_form']) && $_GET['id_form'] > 0 )
	$id_form = $_GET['id_form'];
else 
	$id_form = 0;

$form = new AdminProyectForm( $id_form );
?>
<!-- Mapa --> 
<script type="text/javascript" >
var id_form = <?php echo $form->id_form ?>;
$(document).ready(function() { 
	$.validate({
		form : '#frm_form',
		language : validate_language
	});
});
</script>
<div id="section-header" class="row">
	<div class="col-xs-12 "> <h2> Edición de Formulario </h2> </div> 
</div>
<div id='form-content' class=' content-info row '> 
	<form id="frm_form" class="form-horizontal" role="form" method="post" action="admin.proyect.php" >
	<div class="col-xs-12 col-sm-12">  
		<div class="row "> &nbsp; </div>
		<fieldset class="row">
			<div class="row ">
				<legend class="border-bottom"> Información del Formulario </legend>
			</div> 
			<div class="row ">
				<div class="col-xs-12 col-sm-6">  
					<label>Tipo de Formulario *</label> 
					<select id='inp_id_form_type' name='id_form_type' class="form-control" data-validation="select-option " > 
					<?php echo $catalogue->get_catalgue_options( 'form_type', $form->id_form_type ) ?>
					</select>  
				</div> 
			</div>
			<div class="row ">
				<div class="col-xs-12 ">  
					<label>Título *</label> 
					<input type="text" id="inp_title" name="title" class="form-control" maxlength="60" data-validation="required unique-form" value="<?php echo $form->title ?>" /> 
				</div> 
			</div>
			<div class="row ">
				<div class="col-xs-12 ">  
					<label>Descripción </label> 
					<textarea id="inp_description" name="description" class="form-control" ><?php echo $form->description ?></textarea>  
				</div> 
			</div> 
			<div class="row form-group" id="edition_buttons" style="padding: 25px 5px 0px;">
				<input type="hidden" name="action" value="edit_form" />
				<input type="hidden" name="id_form" id='inp_id_form' value="<?php echo $form->id_form ?>" />
				<input type="hidden" name="cb" value="<?php echo $_GET['cb'] ?>" />
				<button type="reset"  class="btn btn-default" onclick="call_back();"><i class="fa fa-refresh"></i> Cancelar </button>
				<button type="submit" class="btn btn-default pull-right" ><i class="fa fa-save"></i> <?php echo $form->id_form > 0 ? "Actualizar" : "Guardar" ?> </button>
			</div>  
		</fieldset>  
	</form>
	<div class="row  border-bottom">&nbsp;</div>
	<div class="row ">&nbsp;</div> 
<?php  if ( $form->id_form > 0 ) { ?>  
	<fieldset> 
		<div class="row">
			<div class="col-xs-12 ">
				<div class="row ">
					<div class="col-xs-1 "> &nbsp; </div> 
					<h4 class="col-xs-10 ">
						<span> Contenido </span>
						<button type="button" class="btn btn-default pull-right" onclick="edit_section(0);">
							<i class="fa fa-plus"></i> <span class="hidden-xs hidden-sm"> Crear sección </span>
						</button>
					</h4> 
					<div class="col-xs-1 "> &nbsp; </div> 
				</div>
			</div>	
			<div class="col-xs-12  border-top border-sides border-bottom ">  
				<div class="row" style="margin: 10px auto;" >
					<div class="col-xs-1 "> &nbsp; </div> 
					<div class="col-xs-10 ">
						 <div class="row" id="frm_form_content" >
						 	<?php echo $form->get_sections_form_html() ?>
						 </div>
					</div>
					<div class="col-xs-1 "> &nbsp; </div> 
				</div> 
				<div class="row "> &nbsp; </div>
			</div>
			<div class="row "> &nbsp; </div>
		</div>  
	</fieldset>  
	<div class="row "> &nbsp; </div>  
<?php } ?> 
	</div> 
	<div class="row "> &nbsp; </div> 
</div> 

		</div>
	</div>
</div>

<!-- Supplier Form Modal --> 
<div id="mdl_frm_section" class="modal fade"  role="dialog" aria-labelledby="mdl_frm_section" aria-hidden="true">
	<div class="modal-dialog modal-md">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true" onclick="clean_section_form();"> &times; </button>
				<h4 id="mdl_frm_section_title" class="modal-title">Edición de Sección</h4>
			</div> 
			<div class="modal-body">   
				<fieldset>   
					<div class="form-group"> 
						<div class="col-xs-12">
							<label class="control-label">Título* </label>
							<input type="text" id="inp_fms_title" name="fms_title" class="form-control" value="" required  data-validation="required " />
						</div>  
						<div class="col-xs-12">
							<label>Descripción: </label> 
							<textarea id="inp_fms_description" name="fms_description" class="form-control" ></textarea>
						</div>  
					</div>
				</fieldset> 
			</div>
			<div class="modal-footer">
				<input type='hidden' id='inp_id_section' name='id_section' value='' />  
				<input type='hidden' id='inp_fms_action' name='action' value='edit_section' />
				<button type="button" class="btn btn-default" data-dismiss="modal" onclick="clean_section_form();">
					<i class="fa fa-times"></i> Cancelar
				</button>
				<button type="button" class="btn btn-check" onclick="save_section();" >
					<i class="fa fa-save"></i> Aceptar
				</button>
			</div> 
		</div>
	</div>
</div>


<!-- Question Form Modal --> 
<div id="mdl_frm_question" class="modal fade"  role="dialog" aria-labelledby="mdl_frm_question" aria-hidden="true">
	<div class="modal-dialog modal-md">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true" onclick="clean_question_form();"> &times; </button>
				<h4 id="mdl_frm_question_title" class="modal-title">Edición de Pregunta</h4>
			</div>
			
				<div class="modal-body">   
					<fieldset>   
						<div class="form-group"> 
							<div class="col-xs-12 col-sm-6">
								<label class="control-label">Tipo de pregunta * </label>
								<select id='inp_qs_id_question_type' name='id_question_type'  class="form-control" data-validation="select-option " > 
								<?php echo $catalogue->get_catalgue_options( 'question_type' ) ?>
								</select>
							</div>  
							<div class="col-xs-12 col-sm-6">
								<label class="control-label">Orden </label>
								<input type="number" id="inp_qs_order" name="order" class="form-control" value="" />
							</div>  
							<div class="col-xs-12">
								<label class="control-label">Pregunta * </label> 
								<textarea id="inp_qs_question" name="question" class="form-control" required  data-validation="required " ></textarea>
							</div>
							<div class="col-xs-12 col-sm-6">
								<label class="control-label">Opciones: </label> 
								<input type="text" id="inp_qs_options" name="options" class="form-control" value="" />
							</div>
							<div class="col-xs-12 col-sm-6">
								<label class="control-label">Opción Correcta: </label> 
								<input type="text" id="inp_qs_correct" name="correct" class="form-control" value="" />
							</div>
							<div class="col-xs-12 col-sm-6">
								<label class="control-label">Ponderación: </label> 
								<input type="text" id="inp_qs_weight" name="weight" class="form-control" value="" />
							</div> 
						</div>
					</fieldset> 
				</div>
				<div class="modal-footer">
					<input type='hidden' id='inp_id_question' 	name='id_question' value='' />  
					<input type='hidden' id='inp_qs_id_section' name='id_section'  value='' />
					<input type='hidden' id='inp_qs_action' name='action' value='edit_question' />
					 
					<button type="button" class="btn btn-default" data-dismiss="modal" onclick="clean_question_form();">
						<i class="fa fa-times"></i> Cancelar
					</button>
					<button type="button" class="btn btn-check" onclick="save_question();" >
						<i class="fa fa-save"></i> Aceptar
					</button>
				</div> 
		</div>
	</div>
</div>  