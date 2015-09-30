<?php
 
?>
<div id='#form_question_<?php echo $question->id_question ?>' class="proyect_form_question border-bottom" style="margin: 10px auto;"> 
	<div class="row " >
		<div class="col-xs-1"> <span>Ord. <?php echo $question->order ?></span></div>
		<div class="col-xs-9"><h5><?php echo $question->question ?></h5></div> 
		<div class="col-xs-2 pull-right"> 
			<button type="button" class="btn btn-default" onclick="edit_question(<?php echo $section->id_section ?>, <?php echo $question->id_question?>);">
				<i class="fa fa-edit"></i>
		</button> &nbsp;
			<button type="button" class="btn btn-default" onclick="delete_question(<?php echo $section->id_section ?>, <?php echo $question->id_question?>);">
				<i class="fa fa-trash-o"></i>
			</button>
		</div>
	</div>
	<div class="row">
		<div class="col-xs-12 col-sm-6">
			<label> Tipo de Pregunta </label> <span> <?php echo $question->question_type ?></span>
		</div>
		<div class="col-xs-12 col-sm-6">
			<label> Ponderación </label> <span> <?php echo $question->weight ?></span>
		</div>
	</div>
	<div class="row">
		<div class="col-xs-12 col-sm-6">
			<label>  Opciones </label> <span> <?php echo $question->options ?></span>
		</div> 
		<div class="col-xs-12 col-sm-6">
			<label>  Opc. Correcta  </label> <span> <?php echo $question->correct ?></span>
		</div>
	</div>
</div>