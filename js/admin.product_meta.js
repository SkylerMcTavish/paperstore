function clean_product_meta_form(){
	$('#inp_product_meta_label').val('');
	$('#inp_product_meta_data_type').val(0);
	$('#inp_product_meta_options').val('');
	$('#inp_product_meta_id').val(0);
}

function edit_option( id ){
	if ( id > 0 ) {
		$.ajax({
			url: "ajax.php",
			type: "POST",
			async: false,
			data: {
		  		resource: 			'meta',
		  		action: 			'get_product_option',
	    		id_product_option: 	id
			},
		  	dataType: "json",
		 	success: function(data) {
				if (data.success == true )  {
					$('#inp_product_meta_label'		).val(data.info.label);
					$('#inp_product_meta_data_type'	).val(data.info.id_data_type);
					$('#inp_product_meta_options'	).val(data.info.options);
					$('#inp_product_meta_id'		).val(data.info.id_option);
					$('#inp_product_meta_label' 	).focus();
					window.scrollTo(0,75);
				}
				else {
					show_error( data.error );
					return false;
				}
			}
		}); 
	}
}

function save_product_meta(){ 
	var id 		= $('#inp_product_meta_id' ).val();
	var label 	= "";
	var type 	= "";
	
	if ( $('#inp_product_meta_label' ).val() != '' ){
		label = $('#inp_product_meta_label' ).val();
	} else {
		$('#inp_product_meta_label' ).focus();
		return false;
	} 
	if ( $('#inp_product_meta_data_type' ).val() > 0  ){
		type = $('#inp_product_meta_data_type' ).val();
	} else {
		$('#inp_product_meta_data_type' ).focus();
		return false;
	} 
	var options = $('#inp_product_meta_options' ).val();
	if ( type > 6 && options == '' ){
		show_error( 'Escriba al menos una opción.' );
		$('#inp_product_meta_data_type' ).focus();
		return false; 
	}
	
	$.ajax({
		url: "ajax.php",
		type: "POST",
		async: false,
		data: {
	  		resource: 			'meta',
	  		action: 			'save_product_option',
    		id_product_option: 	id,
    		label: 				label,
    		id_data_type: 		type,
    		options:			options
		},
	  	dataType: "json",
	 	success: function(data) {
			if (data.success == true )  {
				var html = data.html; 
				$('#lst_product_options').html( html ); 
				clean_product_meta_form();
				show_message('El registro se guardó correctamente.');
			}
			else {  
				show_error( data.error );
				return false;
			}
		}
	});
}

function delete_option( id ){
	if (confirm('¿Está seguro que desea borrar el registro?')){
		$.ajax({
			url: "ajax.php",
			type: "POST",
			async: false,
			data: {
		  		resource: 			'meta',
		  		action: 			'delete_product_option',
	    		id_product_option: 	id
			},
		  	dataType: "json",
		 	success: function(data) {
				if (data.success == true )  {
					var html = data.html; 
					$('#lst_product_options').html( html ); 
					show_message('El registro se borró correctamente.');
				}
				else {
					show_error( data.error );
					return false;
				}
			}
		});
	}
}