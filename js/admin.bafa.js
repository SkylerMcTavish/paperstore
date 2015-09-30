function filter_rivals( source, target ){
	
	var rival = false; 
	if ( $('#'+ source + '_f:checked' ).val() == "1" ) 
		rival = true;
	
	var catalogue = rival ? "brand_rival" : "brand_own";
	
	filter_options( target , catalogue, 0); 
}

/**
 * Form functions
 */
function clean_form(){
	
}

function clean_brand_form(){
	$('#inp_brand'	 		).val(''); 
	$('#inp_id_brand'		).val( 0 );
}

function clean_family_form(){
	$('#inp_family'	 		).val(''); 
	$('#inp_ba_id_brand'    ).val( 0 );
	$('#inp_id_family'		).val( 0 );
}

function edit_brand( id_brand ){
	if ( id_brand > 0 ){
		$.ajax({
			url: "ajax.php",
			type: "POST",
			async: false,
			data: {
		  		resource: 	'product',
		  		action: 	'get_brand_info',
	    		id_brand: 	id_brand 
			},
		  	dataType: "json",
		 	success: function(data) {
				if (data.success == true ) {
					var brand = data.info;
					$('#inp_id_brand').val( brand.id_brand ); 
					$('#inp_brand').val( brand.brand );
					if ( brand.rival == 1 )
					{
						$('#inp_ba_rival_f').prop("checked", true);
						//$('#inp_ba_rival_t').prop("checked", true);		/*<==*/
					}
					else
					{
						$('#inp_ba_rival_t').prop("checked", true);
						//$('#inp_ba_rival_f').prop("checked", true);		/*<==*/
					}
					$('#mdl_frm_brand').modal('show');
				}
				else {  
					show_error( data.error );
					return false;
				}
			}
		}); 
	} else {
		clean_brand_form(); 
		$('#inp_id_brand').val( 0 ); 
		$('#mdl_frm_brand').modal('show');
	} 
}

function edit_family( id_family ){
	if ( id_family > 0 ){
		$.ajax({
			url: "ajax.php",
			type: "POST",
			async: false,
			data: {
		  		resource: 	'product',
		  		action: 	'get_family_info',
	    		id_family: 	id_family 
			},
		  	dataType: "json",
		 	success: function(data) {
				if (data.success == true ) {
					var family = data.info;   
					$('#inp_fa_id_brand').val( family.id_brand ); 
					$('#inp_id_family').val( family.id_family ); 
					$('#inp_fa_family').val( family.family ); 
					if ( family.rival == 1 ) 
						$('#inp_fa_rival_f').prop("checked", true);
					else 
						$('#inp_fa_rival_t').prop("checked", true);
					$('#mdl_frm_family').modal('show');
				}
				else {  
					show_error( data.error );
					return false;
				}
			}
		}); 
	} else {
		clean_family_form(); 
		$('#inp_id_family').val( 0 ); 
		$('#mdl_frm_family').modal('show');
	} 
}

function delete_brand( which ){
	if (which > 0 && confirm('ÀEst‡ seguro que desea borrar la marca seleccionado?') ){
		$.ajax({
			url: "ajax.php", type: "POST",  
			data: {
		  		resource: 	'admin.product', 
		  		action: 	'delete_brand', 
		  		id_brand: which 
			},
		  	dataType: "json",
		 	success: function(data) {
				if (data.success == true )  {
					show_message( "La marca se borr— exitosamente." ); 
					filter_options( 'flt_brand', 'brand' );  
					filter_options( 'inp_fa_id_brand', 'brand' );
				} else {  
					show_error( data.error );
					return false;
				}
			}
		}); 
	} 
}

function delete_family( which ){
	if (which > 0 && confirm('ÀEst‡ seguro que desea borrar el familia seleccionado?') ){
		$.ajax({
			url: "ajax.php", type: "POST",  
			data: {
		  		resource: 	'admin.product', 
		  		action: 	'delete_family', 
		  		id_family: which 
			},
		  	dataType: "json",
		 	success: function(data) {
				if (data.success == true )  {
					show_message( "La familia se borr— exitosamente." ); 
					filter_options( 'flt_family', 'family' );  
				} else {  
					show_error( data.error );
					return false;
				}
			}
		}); 
	} 
}

 
function delete_product( which ){
	if (which > 0 && confirm('ÀEst‡ seguro que desea borrar el producto seleccionado?') ){
		$.ajax({
			url: "ajax.php", type: "POST",  
			data: {
		  		resource: 	'admin.product', 
		  		action: 	'delete_product', 
		  		id_product: which 
			},
		  	dataType: "json",
		 	success: function(data) {
				if (data.success == true )  {
					show_message( "El producto se borr— exitosamente." );
					reload_table( 'lst_product' );
				} else {  
					show_error( data.error );
					return false;
				}
			}
		}); 
	} 
}


function edit_product( product ){
	window.location = "index.php?command=" + cmd_frm + "&cb=" + command + "&id_pd=" + product ;
}
