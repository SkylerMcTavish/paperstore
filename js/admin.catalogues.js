/**** Catalogue Admin ***/
function load_catalogue_admin(){
	$.formUtils.addValidator({
		name : 'unique-catalogue-admin',
		validatorFunction : function(value, $el, config, language, $form) {
			if (value.length > 3){
				is_unique_catalogue( value );
				return unique;
			} else 
				return true;
		},
		errorMessage : 'El valor ya existe. ',
		errorMessageKey: 'badCatalogueAdminUnique'
	});	 
	$.validate({
		form : '#frm_catalogue',
		language : validate_language
	}); 
} 

function is_unique_catalogue( value ){
	$.ajax({
		url: "ajax.php",
		type: "POST",
		async: false,
		data: {
	  		resource: 	'admin.catalogues',
	  		action: 	'is_unique_catalogue',
    		id: 		$('#inp_id_catalogue').val(), 
    		catalogue:	catalogue, 
    		value: 		value
		},
	  	dataType: "json",
	 	success: function(data) {
			if (data.success == true )
			{
				unique = data.unique;
				return data.unique;
			}
			else
			{  
				return false;
			}
		}
	}); 
}

function edit_catalogue( id ) {
	if (id > 0){
		$.ajax({
			url: "ajax.php", type: "POST", async: false,
			data: {
		  		resource: 'admin.catalogues', 
		  		action: 'get_catalogue_admin_info', 
		  		id: id,
		  		catalogue: catalogue
			},
		  	dataType: "json",
		 	success: function(data) {
				if (data.success == true )  {
					var catalogue = data.info;
					$('#inp_id_catalogue' ).val( catalogue.id ); 
					$('#inp_cat_value' 	  ).val( catalogue.value );  
					$('#inp_cat_id_parent').val( catalogue.id_parent );  
					$('#mdl_frm_catalogue').modal('show');
				}
				else {  
					show_error( data.error );
					return false;
				}
			}
		}); 
	} else {
		clean_catalogue_form();
		$('#mdl_frm_catalogue').modal('show'); 
	} 
}

function delete_catalogue( id ) {
	if ( id > 0 && confirm('¿Está seguro que desea borrar el registro?') ){
		$.ajax({
			url: "ajax.php", type: "POST",  
			data: {
		  		resource: 	'admin.catalogues', 
		  		action: 	'delete_catalogue_element', 
		  		id: 		id,
		  		catalogue: 	catalogue
			},
		  	dataType: "json",
		 	success: function(data) {
				if (data.success == true )  {
					show_message( "El registro se borró exitosamente." );
					reload_table( catalogue );
				}
				else {  
					show_error( data.error );
					return false;
				}
			}
		}); 
	}
}

function save_catalogue_admin(){
	if ( $('#inp_cat_value').val() == '' ) { 
		show_error( "Valor inválido.");
		return false;
	}
}

function clean_catalogue_form(){
	$('#inp_id_catalogue').val( 0 ); 
	$('#inp_cat_value' 	 ).val( "" );  
	$('#inp_cat_parent'	 ).val( 0 );   
}

function cancel_catalogue_edition(){
	clean_catalogue_form();
	$('#mdl_frm_catalogue').modal('hide');  
}