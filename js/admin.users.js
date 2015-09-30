
function edit_contact( id_user ){
	if ( id_user > 0 ){
		window.location = 'index.php?command=' + cmd_frm_contact + "&u=" + id_user + '&cb=' + command;
	}
}

function edit_user( which ){
	if (which > 0){
		$.ajax({
			url: "ajax.php",
			type: "POST",
			async: false,
			data: {
		  		resource: 	'user',
		  		action: 	'get_user_info',
	    		id_user: 	which
			},
		  	dataType: "json",
		 	success: function(data) {
				if (data.success == true )  {
					var user = data.info;
					$('#opc_password').hide();
					$('#inp_id_user').val( user.id_user ); 
					$('#inp_user').val( user.user ); 
					$('#inp_profile').val( user.id_profile );					
					$('#inp_id_viamente').val( user.id_viamente );
					$('#inp_zone').val( user.zone ); 					
					$('#mdl_frm_user').modal('show');
					return false;
				}
			}
		}); 
	}else{
		clean_form();
		$('#inp_profile').val( id_profile );
		$('#opc_password').show();
	} 
}

function detail_user( which ){
	if (which > 0){
		if ( which != $('#inp_detail_id_user').val() ){
			$.ajax({
				url: "ajax.php",
				type: "POST",
				async: false,
				data: {
			  		resource: 	'user',
			  		action: 	'get_user_info_html',
		    		id_user: 	which
				},
			  	dataType: "json",
			 	success: function(data) {
					if (data.success == true )  {
						var html = data.html;
						$('#inp_detail_id_user').val( which );
						$('#detail_user_content').html( html );
						
						$('#mdl_detail_user').modal('show');
					}
					else {  
						show_error( data.error );
						return false;
					}
				}
			}); 
		} else {
			$('#mdl_detail_user').modal('show');
		}
	} 
}
 function change_password( which ){
 	
	if (which > 0){
		if ( which != $('#inp_detail_id_user').val() ){		
			$.ajax({
			url: "ajax.php",
			type: "POST",
			async: false,
			data: {
		  		resource: 	'user',
		  		action: 	'get_user_info',
	    		id_user: 	which
			},
		  	dataType: "json",
		 	success: function(data) {
				if (data.success == true )  {
					var user = data.info;					
					$('#form_pass_inp_id_user').val( user.id_user ); 						
					$('#mdl_form_pass').modal('show');
					return true;
				}
			}
		}); 
		}else{
			
			alert("no es el usuario");
			return false;
		}
	}
		 
}


function delete_user( which ){
	var r=confirm("¿Desea eliminar el usuario?");
 	if(r==true){
	if (which > 0){
			$.ajax({
				url: "ajax.php",
				type: "POST",
				async: false,
				data: {
			  		resource: 	'user',
			  		action: 	'delete',
		    		id_user: 	which
				},
			  	dataType: "json",
			 	success: function(data) {
					if (data.success == true )  {
						var html = data.html;
						location.reload();						
					}
					else {  
						show_error( data.error );
						return false;
					}
				}
			}); 
		} else {
			$('#mdl_detail_user').modal('show');
		}
	}
}

function change_password_option( option ){
	
	if ( option == 'pwd_manual'){
	
		$('#div_password').show('slide', '{ direction: "down" }');
	} else { 
		$('#frm_inp_password, #frm_inp_password_match').val(''); 
		$('#div_password').hide('slide'); 
	}
}

function clean_form(){
	$('#inp_id_user').val(0);
	$('#inp_user').val('');
	$('#inp_profile').val(0);
	
	$('#inp_pwd_option_manual').removeAttr('checked');
	$('#inp_pwd_option_email').removeAttr('checked'); 
	$('#frm_user').get(0).reset();
}

function set_instance_option(){
	if ( $('#inp_instance_option').prop('checked') ){
		$('#div_instance').show('slide', '{ direction: "down" }'); 
	} else {
		$('#div_instance').hide('slide'); 
	}
}

//Is Unique User
function is_unique( user ){
	$.ajax({
		url: "ajax.php",
		type: "POST",
		async: false,
		data: {
	  		resource: 	'user',
	  		action: 	'is_unique_user',
    		id_user: 	$('#inp_id_user').val(), 
    		user: 		user
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


// Is Unique Id_Viamente

function is_unique_id_viamente( user ){
	$.ajax({
		url: "ajax.php",
		type: "POST",
		async: false,
		data: {
	  		resource: 	'user',
	  		action: 	'is_unique_id_viamente',
    		id_user: 	$('#inp_id_user').val(), 
    		user: 		user
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
		name : 'password-match',
		validatorFunction : function(value, $el, config, language, $form) {
			var source = $el[0].id;
			var target = $('#' + source).attr( 'data-validation-target' );
			var compare =  $('#' + target).val();
			return ( value == compare );
		},
		errorMessage : 'Las contraseñas deben coincidir ',
		errorMessageKey: 'badPasswordMatch'
	});
	
	$.formUtils.addValidator({
		name : 'unique-user',
		validatorFunction : function(value, $el, config, language, $form) {
			if (value.length > 5){
				is_unique( value );
				return unique;
			} else 
				return true;
		},
		errorMessage : 'El usuario ya existe ',
		errorMessageKey: 'badUserUnique'
	});
	
	$.validate({
		form : '#frm_user',
		language : validate_language
	}); 
});


/*
 * 
 * */
function ValidaRfc(rfcStr) {
	var strCorrecta;
	strCorrecta = rfcStr;	
	if (rfcStr.length == 12){
	var valid = '^(([A-Z]|[a-z]){3})([0-9]{6})((([A-Z]|[a-z]|[0-9]){3}))';
	}else{
	var valid = '^(([A-Z]|[a-z]|\s){1})(([A-Z]|[a-z]){3})([0-9]{6})((([A-Z]|[a-z]|[0-9]){3}))';
	}
	var validRfc=new RegExp(valid);
	var matchArray=strCorrecta.match(validRfc);
	if (matchArray==null) {
		alert('Cadena incorrecta');

		return false;
	}
	else
	{
		//alert('Cadena correcta:' + strCorrecta);
		return true;
	}
	
}