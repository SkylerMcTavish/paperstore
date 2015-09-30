/**
 * PDV Administration Functions
 */

/**
 * List Functions
 */
function reload_product_table()
{
	
	if ( $('#flt_brand').val() > 0 )
	{
		$('#inp_lst_product_exfval').val( $('#flt_brand').val() );
		$('#inp_lst_product_exfidx').val( 'id_brand' ); 
	}
	else
	{
		$('#inp_lst_product_exfval').val( '' );
		$('#inp_lst_product_exfidx').val( '' );  
	} 
	reload_table( 'lst_product' ); 
}

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
						$('#inp_ba_rival_f').prop("checked", true);
					else 
						$('#inp_ba_rival_t').prop("checked", true);
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
	if (which > 0 && confirm('¿Está seguro que desea borrar la marca seleccionado?') ){
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
					show_message( "La marca se borró exitosamente." ); 
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
	if (which > 0 && confirm('¿Está seguro que desea borrar el familia seleccionado?') ){
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
					show_message( "La familia se borró exitosamente." ); 
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
	if (which > 0 && confirm('¿Está seguro que desea borrar el producto seleccionado?') ){
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
					show_message( "El producto se borró exitosamente." );
					reload_table( 'lst_product' );
				} else {  
					show_error( data.error );
					return false;
				}
			}
		}); 
	} 
}


function edit_product( product )
{
	//window.location = "index.php?command=" + cmd_frm + "&cb=" + command + "&id_pd=" + product ;
	$("#mdl_frm_product").modal('show');
}

function save_price(){
	var id_product 	= $('#inp_id_product').val();
	var price 		= $('#inp_price').val();
	var id_pp	 	= $('#inp_product_presentation').val();
	var units 		= $('#inp_units').val();
	if ( !id_product > 0 ){
		show_error('No se tiene un producto válido.');
		return false;
	} else if ( !( parseFloat(price) > 0) ){
		show_error('Precio inválido.');
		return false; 
	} else if ( !( parseInt(id_pp) > 0) ){
		show_error('Contenedor inválido.');
		return false; 
	} else if ( !( parseInt(units) > 0) ){
		show_error('Unidades inválidas.');
		return false; 
	} else {
		$.ajax({
			url: "ajax.php",
			type: "POST",
			async: false,
			data: {
		  		resource: 	'admin.product',
		  		action: 	'save_price',
	    		id_product: id_product,
	    		price: 		price,
	    		id_product_presentation: id_pp,
	    		units: 		units
			},
		  	dataType: "json",
		 	success: function(data) {
				if (data.success == true )  {
					var html = data.html; 
					$('#prices_rows').html( html ); 
				}
				else {  
					show_error( data.error );
					return false;
				}
			}
		});
	}
}

function save_supplier_code(){
	var id_product 	= $('#inp_id_product').val();
	var code 		= $('#inp_code').val();
	var id_supplier	= $('#inp_id_supplier').val(); 
	if ( !id_product > 0 ){
		show_error('No se tiene un producto válido.');
		return false;
	} else if ( code == '' ){
		show_error('Código inválido.');
		return false; 
	}else if ( ! (parseInt(id_supplier) > 0) ){
		show_error('Mayorista inválido.');
		return false;  
	} else {
		$.ajax({
			url: "ajax.php",
			type: "POST",
			async: false,
			data: {
		  		resource: 	 'admin.product',
		  		action: 	 'save_supplier_code',
	    		id_product:  id_product,
	    		code: 		 code,
	    		id_supplier: id_supplier 
			},
		  	dataType: "json",
		 	success: function(data) {
				if (data.success == true )  {
					var html = data.html; 
					$('#supplier_codes_rows').html( html ); 
				}
				else {  
					show_error( data.error );
					return false;
				}
			}
		});
	}
}

function detail_product( which, force )
{
	if (which > 0)
	{
		if ( which != $('#inp_detail_id_product').val() || force == true )
		{
			
			$.ajax({
				url: "ajax.php",
				type: "POST",
				async: false,
				data: {
			  		resource: 	'product',
			  		action: 	'get_product_info_html',
		    		id_product: which
				},
			  	dataType: "json",
			 	success: function(data) {
					if (data.success == true )  {
						var html = data.html;
						$('#inp_detail_id_product').val( which );
						$('#detail_product_content').html( html );
						
						$('#mdl_detail_product').modal('show');
						load_detail_map();
					}
					else {  
						show_error( data.error );
						return false;
					}
				}
			}); 
		}
		else
		{
			$('#mdl_detail_product').modal('show');
		}
	} 
}
  
function is_unique( product ){
	$.ajax({
		url: "ajax.php",
		type: "POST",
		async: false,
		data: {
	  		resource: 	'admin.product',
	  		action: 	'is_unique_product',
    		id_product: 	$('#inp_id_product').val(), 
    		product: 		product
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

function is_unique_sku( product ){
	$.ajax({
		url: "ajax.php",
		type: "POST",
		async: false,
		data: {
	  		resource: 	'admin.product',
	  		action: 	'is_unique_sku',
    		id_product: 	$('#inp_id_product').val(), 
    		sku:	sku
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

function load_products()
{
	$("#inp_csv_products").val('');	
	$("#mdl_upload_products").modal('show');
}