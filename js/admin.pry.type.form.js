function edit_form_type(which){
	alert("admin.pry.type.form.js");
	
$('#mdl_type_form').modal('show');
	/*if (which > 0){
			$.ajax({which
				url: "ajax.php",
				type: "POST",
				async: false,
				data: {
			  		resource: 	'proyect',
			  		action: 	'edit_proyect',
		    		id_user: 	which
				},
			  	dataType: "json",
			 	success: function(data) {
					if (data.success == true )  {
						var html = data.html;
						$('#inp_detail_id_user').val( which );
						$('#detail_user_content').html( html );
						
						$('#mdl_type_form').modal('show');
					}
					else {  
						show_error( data.error );
						return false;
					}
				}
			}); 
		} else {
			$('#mdl_type_form').modal('show');
		}
	*/
}