
/**
 *  edit_form()
 * 
 * @param id_form 
 */
function edit_form( id_form ){
	if ( !id_form > 0 ) id_form = 0;
	window.location = 'index.php?command=' + frm_command + '&id_form=' + id_form + '&cb=' + command ;
}

/**
 *  delete_form()
 * 
 * @param id_form 
 */
function delete_form( id_form ){
	if ( id_form > 0 && confirm('¿Está seguro que desea borrar el formulario?') ){
		$.ajax({
			url: "ajax.php", type: "POST",  
			data: {
		  		resource: 	'admin.form', 
		  		action: 	'delete_form', 
		  		id_form: 	id_form 
			},
		  	dataType: "json",
		 	success: function(data) {
				if (data.success == true )  {
					show_message( "El formulario se borró exitosamente." ); 
					reload_table( 'lst_pry_form'); 
				} else {  
					show_error( data.error );
					return false;
				}
			}
		}); 
	}
}

function clean_section_form(){
	$('#inp_fms_title'	).val(''); 
	$('#inp_fms_description').html(''); 
	$('#inp_id_section'	).val( 0 );
}

function clean_question_form(){
	$('#inp_id_question').val( 0 );
	$('#inp_qs_id_section').val( 0 ); 
	$('#inp_qs_id_question_type').val( 0 ); 
	$('#inp_qs_order').val( 0 );
	$('#inp_qs_question').val( "" );
	$('#inp_qs_options').val( "" );
	$('#inp_qs_correct').val( "" );
	$('#inp_qs_weight').val( "" ); 
}

/**
 * edit_section
 * 
 * @param id_section
 */
function edit_section( id_section ){
	if ( id_section > 0 ){
		$.ajax({
			url: "ajax.php",
			type: "POST",
			async: false,
			data: {
		  		resource: 	'pry.form',
		  		action: 	'get_section_info',
	    		id_section: id_section ,
	    		id_form: $('#inp_id_form').val() 
			},
		  	dataType: "json",
		 	success: function(data) {
				if (data.success == true ) {
					var section = data.info;
					$('#inp_id_section').val( section.id_section ); 
					$('#inp_fms_title').val( section.title );
					$('#inp_fms_description').val( section.description ); 
					$('#mdl_frm_section').modal('show');
				}
				else {  
					show_error( data.error );
					return false;
				}
			}
		}); 
	} else {
		clean_section_form(); 
		$('#inp_id_section').val( 0 ); 
		$('#mdl_frm_section').modal('show');
	} 
}

/**
 * save_section
 *  
 */
function save_section( ){
	if ( $('#inp_id_form').val() > 0 ){ 
		var id_section=  $('#inp_id_section').val(); 
		var sec_title =  $('#inp_fms_title'	).val();
		var sec_descr =  $('#inp_fms_description').val(); 
		$.ajax({
			url: "ajax.php", type: "POST",  
			data: {
		  		resource: 	 'admin.pry.form', 
		  		action: 	 'save_section', 
		  		id_section:	 id_section, 
		  		title:		 sec_title, 
		  		description: sec_descr,
		  		id_form: 	 $('#inp_id_form').val() 
			},
		  	dataType: "json",
		 	success: function(data) {
				if (data.success == true )  {
					
					$('#frm_form_content').html( data.html ); 
					show_message( "La sección se guardó correctamente." ); 
					$('#mdl_frm_section').modal('hide');
					clean_section_form();
					
				} else {  
					show_error( data.error );
					return false;
				}
			}
		});
	}
}


/**
 * edit_question
 * 
 * @param id_question
 */
function edit_question( id_section, id_question ){
	if ( id_question > 0 ){
		$.ajax({
			url: "ajax.php",
			type: "POST",
			async: false,
			data: {
		  		resource: 	'pry.form',
		  		action: 	'get_question_info',
	    		id_question: id_question ,
	    		id_section:  id_section ,
	    		id_form: 	 $('#inp_id_form').val() 
			},
		  	dataType: "json",
		 	success: function(data) {
				if (data.success == true ) {
					var question = data.info;
					$('#inp_id_question').val( question.id_question );
					$('#inp_qs_id_section').val( question.id_section ); 
					$('#inp_qs_id_question_type').val( question.id_question_type ); 
					$('#inp_qs_order').val( question.order );
					$('#inp_qs_question').val( question.question );
					$('#inp_qs_options').val( question.options );
					$('#inp_qs_correct').val( question.correct );
					$('#inp_qs_weight').val( question.weight ); 
					 
					$('#mdl_frm_question').modal('show');
				}
				else {  
					show_error( data.error );
					$('#mdl_frm_question').modal('hide');
					return false;
				}
			}
		}); 
	} else {
		clean_question_form();   
		$('#inp_id_question').val( 0 );
		$('#inp_qs_id_section').val( id_section ); 
		$('#mdl_frm_question').modal('show');
	}
}

/**
 * save_question
 *  
 */
function save_question( ){
	if ( $('#inp_id_form').val() > 0 ){ 
		var id_question =  $('#inp_id_question').val(); 
		var id_section 	=  $('#inp_qs_id_section').val();
		var id_type		=  $('#inp_qs_id_question_type').val();
		var order 		=  $('#inp_qs_order').val(); 
		var question 	=  $('#inp_qs_question').val();
		var options 	=  $('#inp_qs_options').val(); 
		var correct 	=  $('#inp_qs_correct').val();
		var weight 		=  $('#inp_qs_weight').val();  
		
		$.ajax({
			url: "ajax.php", type: "POST",  
			data: {
		  		resource: 	 'admin.pry.form', 
		  		action: 	 'save_question',
		  		id_form: 	 $('#inp_id_form').val() , 
		  		id_section:	 id_section, 
		  		id_question: id_question, 
		  		id_question_type: id_type , 
		  		order:		 order, 
		  		question:	 question, 
		  		options: 	 options, 
		  		correct:	 correct,
		  		weight:		 weight
			},
		  	dataType: "json",
		 	success: function(data) {
				if (data.success == true )  { 
					$('#form_section_' + id_section + ' .proyect_form_section_questions').html( data.html ); 
					show_message( "La pregunta se guardó correctamente." ); 
					
					$('#mdl_frm_question').modal('hide');
					clean_question_form();
					
				} else {  
					show_error( data.error );
					return false;
				}
			}
		});
	}
}
