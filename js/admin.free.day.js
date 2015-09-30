
function edit_free_day(which){
	if (which > 0){
			$.ajax({				
				url: "ajax.php",
				type: "POST",
				async: false,
				data: {
			  		resource: 	'free.day',
			  		action: 	'get_free_day',
		    		id_free_day: 	which
				},
			  	dataType: "json",
			 	success: function(data) {
					if (data.success == true )  {
						var freeday = data.info;
						$('#inp_id_free_day').val( which );
						$('#inp_free_day').val( freeday.free_day);
						$('#inp_day').val( freeday.day);						
						$('#mdl_free_day').modal('show');
					}
					else {  
						show_error( data.error );
						return false;
					}
				}
			});
		} else {
			$('#mdl_free_day').modal('show');			
			clean_form();
		}
}

function delete_free_day( which ){
	if (which > 0 && confirm('¿Está seguro que desea borrar el tipo de formulario?') ){
		$.ajax({
			url: "ajax.php", type: "POST",  
			data: {
		  		resource: 	'free.day', 
		  		action: 	'delete_free_day', 
		  		id_free_day: which 
			},
		  	dataType: "json",
		 	success: function(data) {
				if (data.success == true )  {
					show_message( "El registro se borró exitosamente." );				
					reload_table( 'lst_pry_free_day' );
				} else {  
					show_error( data.error );
					return false;
				}
			}
		}); 
	} 
}

function is_unique( freeday ){
	
	$.ajax({
		url: "ajax.php",
		type: "POST",
		async: false,
		data: {
	  		resource: 		'free.day',
	  		action: 		'is_unique_day',
    		id_free_day: 	$('#inp_id_free_day').val(),
			//day: 			$('#inp_day').val(), 
    		free_day: 		freeday
		},
	  	dataType: "json",
	 	success: function(data) {
			if (data.success == true )  {
				unique = data.unique;  
				return data.unique;
			}
			else {  
				return false;
			}
		}
	}); 
}

var unique;
$(document).ready(function() { 
	
	$.formUtils.addValidator({
		name : 'unique-day',
		validatorFunction : function(value, $el, config, language, $form) {
			if (value.length > 4){
				is_unique( value );
				return unique;
			} else 
				return true;
		},
		errorMessage : 'El día ya existe ',
	});
	

	$.validate({
		form : '#frm_free_day',
		language : validate_language
	}); 
});
function clean_form(){
	$('#inp_id_free_day').val(0);
	$('#inp_free_day').val(''); 
	$('#frm_free_day').get(0).reset();
}
