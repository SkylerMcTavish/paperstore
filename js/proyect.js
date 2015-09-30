/**
 * Proyect Functions
 */ 

function detail_proyect( id ) {
	if (id > 0){
		if ( id != $('#inp_detail_id_proyect').val() ){
			$.ajax({
				url: "ajax.php",
				type: "POST",
				async: false,
				data: {
			  		resource: 	'proyect',
			  		action: 	'get_proyect_info_html',
		    		id_proyect: id
				},
			  	dataType: "json",
			 	success: function(data) {
					if (data.success == true )  {
						var html = data.html;
						$('#inp_detail_id_proyect').val( id );
						$('#detail_proyect_content').html( html );
						
						$('#mdl_detail_proyect').modal('show');
					}
					else {
						show_error( data.error );
						return false;
					}
				}
			}); 
		} else {
			$('#mdl_detail_proyect').modal('show');
		}
	} 
}


function load_proyect( id ){
	if (id > 0){
		window.location = "proyect.php?action=load_proyect&idp=" + id + "&cb=" + command;
	}
}
