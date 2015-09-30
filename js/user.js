
function edit_contact( id_user ){
	if ( id_user > 0 ){
		window.location = 'index.php?command=' + cmd_frm_contact + "&u=" + id_user + '&cb=' + command;
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

