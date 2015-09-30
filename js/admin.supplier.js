
/**
 * Branches
 */
function clean_branch_form(){
	$('#inp_ba_id_supplier').val(0);
	$('#inp_id_branch').val(0);
	$('#inp_ba_branch').val(''); 
	$('#inp_ba_number').val(''); 
	$('#frm_branch').get(0).reset(); 
}

function edit_branch( id_supplier, id_branch ){
	if ( id_supplier > 0 ){
		if (id_branch > 0){
			$.ajax({
				url: "ajax.php",
				type: "POST",
				async: false,
				data: {
			  		resource: 	'supplier',
			  		action: 	'get_branch_info',
		    		id_supplier: id_supplier, 
		    		id_branch:	 id_branch
				},
			  	dataType: "json",
			 	success: function(data) {
					if (data.success == true ) {
						var branch = data.info;
						$('#inp_ba_id_supplier').val( branch.id_supplier ); 
						$('#inp_id_branch').val( branch.id_branch ); 
						$('#inp_ba_branch').val( branch.branch );
						$('#inp_ba_number').val( branch.num );
						$('#mdl_frm_branch').modal('show');
					}
					else {  
						show_error( data.error );
						return false;
					}
				}
			}); 
		} else {
			clean_branch_form(); 
			$('#inp_ba_id_supplier').val( id_supplier ); 
			$('#mdl_frm_branch').modal('show');
		} 
	} else { 
		return false;
	}
}

function delete_branch( id_branch ){
	if (id_branch > 0 && confirm('¿Está seguro que desea borrar la sucursal seleccionada?') ){
		$.ajax({
			url: "ajax.php", type: "POST",  
			data: {
		  		resource: 	'supplier', 
		  		action: 	'delete_branch', 
		  		id_branch:  id_branch 
			},
		  	dataType: "json",
		 	success: function(data) {
				if (data.success == true )  {
					show_message( "La sucursal se borró exitosamente." );
					detail_supplier( $('#inp_detail_id_supplier').val(), true );
				} else {  
					show_error( data.error );
					return false;
				}
			}
		}); 
	}
}


/**
 * Suppliers 
 */

function delete_supplier( which ){
	if (which > 0 && confirm('¿Está seguro que desea borrar el mayorista seleccionado?') ){
		$.ajax({
			url: "ajax.php", type: "POST",  
			data: {
		  		resource: 	'supplier', 
		  		action: 	'delete_supplier', 
		  		id_supplier: which 
			},
		  	dataType: "json",
		 	success: function(data) {
				if (data.success == true )  {
					show_message( "El mayorista se borró exitosamente." );
					reload_table( 'lst_supplier' );
				} else {  
					show_error( data.error );
					return false;
				}
			}
		}); 
	} 
}

function edit_supplier( which ){	
	if (which > 0){
		$.ajax({
			url: "ajax.php",
			type: "POST",
			async: false,
			data: {
		  		resource: 	'supplier',
		  		action: 	'get_supplier_info',
	    		id_supplier: 	which
			},
		  	dataType: "json",
		 	success: function(data) {
				if (data.success == true ) {
					var supplier = data.info;
					$('#inp_id_supplier').val( supplier.id_supplier ); 
					$('#inp_supplier').val( supplier.supplier );
					$('#mdl_frm_supplier').modal('show');
				}
				else {  
					show_error( data.error );
					return false;
				}
			}
		}); 
	} else {
		clean_form(); 
	} 
}

function detail_supplier( which, force ){
	if (which > 0){
		if ( which != $('#inp_detail_id_supplier').val() || force == true ){
			$.ajax({
				url: "ajax.php",
				type: "POST",
				async: false,
				data: {
			  		resource: 	'supplier',
			  		action: 	'get_supplier_info_html',
		    		id_supplier: 	which
				},
			  	dataType: "json",
			 	success: function(data) {
					if (data.success == true )  {
						var html = data.html;
						$('#inp_detail_id_supplier').val( which );
						$('#detail_supplier_content').html( html );
						
						$('#mdl_detail_supplier').modal('show');
					}
					else {  
						show_error( data.error );
						return false;
					}
				}
			}); 
		} else {
			$('#mdl_detail_supplier').modal('show');
		}
	} 
}
  
function clean_form(){
	$('#inp_id_supplier').val(0);
	$('#inp_supplier').val(''); 
	$('#frm_supplier').get(0).reset();
}

function is_unique( supplier ){
	
	$.ajax({
		url: "ajax.php",
		type: "POST",
		async: false,
		data: {
	  		resource: 		'supplier',
	  		action: 		'is_unique_supplier',
    		id_supplier: 	$('#inp_id_supplier').val(), 
    		supplier: 		supplier
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
		name : 'unique-supplier',
		validatorFunction : function(value, $el, config, language, $form) {
			if (value.length > 3){
				is_unique( value );
				return unique;
			} else 
				return true;
		},
		errorMessage : 'El mayorista ya existe ',
		errorMessageKey: 'badSupplierUnique'
	});
	

	$.validate({
		form : '#frm_supplier',
		language : validate_language
	}); 
});