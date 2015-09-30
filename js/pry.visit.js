 
/**
 *  delete_visit()
 * 
 * @param id_visit 
 */
function delete_visit( id_visit ){
	if ( id_visit > 0 && confirm('¿Está seguro que desea borrar la visita?') ){
		$.ajax({
			url: "ajax.php", type: "POST",  
			data: {
		  		resource: 	'admin.visit', 
		  		action: 	'delete_visit', 
		  		id_visit: 	id_visit 
			},
		  	dataType: "json",
		 	success: function(data) {
				if (data.success == true )  {
					show_message( "El visitulario se borró exitosamente." ); 
					reload_table( 'lst_pry_visit'); 
				} else {  
					show_error( data.error );
					return false;
				}
			}
		}); 
	}
}
 
function detail_visit(which){
	if (which > 0){
			$.ajax({
				url: "ajax.php",
				type: "POST",
				async: false,
				data: {
			  		resource: 	'visit',
			  		action: 	'get_visit_info',
		    		id_visit: 	which
				},
			  	dataType: "json",
			 	success: function(data) {
					if (data.success == true )  {
						var html = data.html;
						$('#detail_visit_content').html( html );
						/*$('#inp_detail_id_pdv').val( which );*/
						$('#mdl_detail_visit').modal('show');
												
					}
					else {  
						show_error( data.error );
						return false;
					}
				}
			}); 
		
	} 
}


function load_visits(){
	upload_visits();
}

function upload_visits(){
	$("#inp_csv_visit").val('');
	$("#mdl_upload_visit").modal('show');
}
