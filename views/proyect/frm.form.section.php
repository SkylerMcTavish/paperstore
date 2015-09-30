<?php 
?>
<section id='#form_section_<?php echo $section->id_section ?>' class="proyect_form_section">
	<div class="row " ><h3 id='#form_section_title_<?php echo $section->id_section ?>'> <?php echo $section->title ?> </h3></div>
	<div class="row " >
		<div class="col-xs-7 proyect_form_section_description"><?php echo $section->description ?></div>
		<div class="col-xs-5 text-right">
			<button type="button"  class="btn btn-default" onclick="edit_section(<?php echo $section->id_section ?>);">
				<i class="fa fa-edit"></i> <span class="hidden-xs hidden-sm"> Editar Sección </span> 
			</button>
			<button type="button"  class="btn btn-default" onclick="delete_section(<?php echo $section->id_section ?>);">
				<i class="fa fa-trash-o"></i> <span class="hidden-xs hidden-sm"> Borrar Sección </span>
			</button>
		</div>
	</div>
	<div class="row border-bottom"> &nbsp; </div>
	<div class="row "> 
		<h4 class="col-xs-9"> Preguntas </h4>
		<div class="col-xs-3 text-right">
			<button type="button" class="btn btn-default" onclick="edit_question(<?php echo $section->id_section ?>, 0);">
				<i class="fa fa-plus"></i>
				<span class="hidden-xs hidden-sm"> Crear pregunta </span>
			</button>
		</div>
	</div>
	<div class="row "> 
		<div class="col-xs-12 proyect_form_section_questions border-top border-sides border-bottom "> 
			<?php 
				if ( count( $section->questions ) > 0 ){
					foreach ($section->questions as $j => $question){ 
						require "frm.form.question.php";
					}
				} else {
					?> <div class="row text-center" style="margin: 10px auto;" > No existen preguntas en ésta sección. </div> <?php
				}
			?>
		</div>
	</div>
	<div class="row "> &nbsp; </div>
</section>