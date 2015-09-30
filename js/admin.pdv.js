/**
 * PDV Administration Functions
 */
	var map;
	var pdv_marker;    
	var unique_pdv;
	var unique_viamente; 
/**
 * List Functions
 */
function reload_pdv_table(){
	
	if( $('#flt_division').val() > 0 )
	{
		$('#inp_lst_pdv_exfval').val( $( '#flt_division' ).val() );
		$('#inp_lst_pdv_exfidx').val( 'id_division' );  
	}
	else if( $('#flt_channel').val() > 0 )
	{
		$('#inp_lst_pdv_exfval').val( $( '#flt_channel' ).val() );
		$('#inp_lst_pdv_exfidx').val( 'id_channel' );  
	}
	else
	{
		$('#inp_lst_pdv_exfval').val( '' );
		$('#inp_lst_pdv_exfidx').val( '' ); 
	}
	
	
	reload_table( 'lst_pdv' ); 
}

/**
 * Form functions
 */
function clean_form(){
	
}

function clean_channel_form(){
	$('#inp_channel'	).val('');
	$('#inp_id_channel'	).val( 0 );
}

function clean_group_form(){
	$('#inp_group'	 		).val('');
	$('#inp_gr_id_channel'  ).val( 0 );
	$('#inp_id_group'		).val( 0 );
}

function clean_format_form(){
	$('#inp_format'	 		).val('');
	$('#inp_fo_id_channel'  ).val( 0 );
	$('#inp_fo_id_group'    ).val( 0 );
	$('#inp_id_format'		).val( 0 );
}

function edit_channel( id_channel ){
	if ( id_channel > 0 ){
		$.ajax({
			url: "ajax.php",
			type: "POST",
			async: false,
			data: {
		  		resource: 	'pdv',
		  		action: 	'get_channel_info',
	    		id_channel:  id_channel 
			},
		  	dataType: "json",
		 	success: function(data) {
				if (data.success == true ) {
					var channel = data.info; 
					$('#inp_id_channel').val( channel.id_channel ); 
					$('#inp_channel').val( channel.channel ); 
					$('#mdl_frm_channel').modal('show');
				}
				else {  
					show_error( data.error );
					return false;
				}
			}
		}); 
	} else {
		clean_channel_form(); 
		$('#inp_id_channel').val( id_channel ); 
		$('#mdl_frm_channel').modal('show');
	} 
}

function edit_group( id_group ){
	if ( id_group > 0 ){
		$.ajax({
			url: "ajax.php",
			type: "POST",
			async: false,
			data: {
		  		resource: 	'pdv',
		  		action: 	'get_group_info',
	    		id_group: 	id_group 
			},
		  	dataType: "json",
		 	success: function(data) {
				if (data.success == true ) {
					var group = data.info; 
					$('#inp_gr_id_channel').val( group.id_channel ); 
					$('#inp_id_group').val( group.id_group ); 
					$('#inp_gr_group').val( group.group ); 
					$('#mdl_frm_group').modal('show');
				}
				else {  
					show_error( data.error );
					return false;
				}
			}
		}); 
	} else {
		clean_group_form(); 
		$('#inp_id_group').val( 0 ); 
		$('#mdl_frm_group').modal('show');
	} 
}

function edit_format( id_format ){
	if ( id_format > 0 ){
		$.ajax({
			url: "ajax.php",
			type: "POST",
			async: false,
			data: {
		  		resource: 	'pdv',
		  		action: 	'get_format_info',
	    		id_format: 	id_format 
			},
		  	dataType: "json",
		 	success: function(data) {
				if (data.success == true ) {
					var format = data.info; 
					$('#inp_fo_id_channel').val( format.id_channel ); 
					$('#inp_fo_id_group').val( format.id_group ); 
					$('#inp_id_format').val( format.id_format ); 
					$('#inp_fo_format').val( format.format ); 
					$('#mdl_frm_format').modal('show');
				}
				else {  
					show_error( data.error );
					return false;
				}
			}
		}); 
	} else {
		clean_format_form(); 
		$('#inp_id_format').val( 0 ); 
		$('#mdl_frm_format').modal('show');
	} 
}

function delete_channel( which ){
	if (which > 0 && confirm('¿Está seguro que desea borrar el canal seleccionado?') ){
		$.ajax({
			url: "ajax.php", type: "POST",  
			data: {
		  		resource: 	'admin.pdv', 
		  		action: 	'delete_channel', 
		  		id_channel: which 
			},
		  	dataType: "json",
		 	success: function(data) {
				if (data.success == true )  {
					show_message( "El canal se borró exitosamente." ); 
					filter_options( 'flt_channel', 'channel' ); 
					filter_options( 'inp_gr_id_channel', 'channel' );
					filter_options( 'inp_fo_id_channel', 'channel' );
				} else {  
					show_error( data.error );
					return false;
				}
			}
		}); 
	} 
}

function delete_group( which ){
	if (which > 0 && confirm('¿Está seguro que desea borrar el grupo seleccionado?') ){
		$.ajax({
			url: "ajax.php", type: "POST",  
			data: {
		  		resource: 	'admin.pdv', 
		  		action: 	'delete_group', 
		  		id_group: which 
			},
		  	dataType: "json",
		 	success: function(data) {
				if (data.success == true )  {
					show_message( "El grupo se borró exitosamente." ); 
					filter_options( 'flt_group', 'group' );  
					filter_options( 'inp_fo_id_group', 'group' );
				} else {  
					show_error( data.error );
					return false;
				}
			}
		}); 
	} 
}

function delete_format( which ){
	if (which > 0 && confirm('¿Está seguro que desea borrar el formato seleccionado?') ){
		$.ajax({
			url: "ajax.php", type: "POST",  
			data: {
		  		resource: 	'admin.pdv', 
		  		action: 	'delete_format', 
		  		id_format: which 
			},
		  	dataType: "json",
		 	success: function(data) {
				if (data.success == true )  {
					show_message( "El formato se borró exitosamente." ); 
					filter_options( 'flt_format', 'format' );  
				} else {  
					show_error( data.error );
					return false;
				}
			}
		}); 
	} 
}


 
function switch_pdv_type( inp ){ 
	$('.frm_pdv_type_fldst').hide(); 
	switch(  inp.value ){
		case 1:
		case "1":
			$('#fldst_type_drugstore').show(); 
			break;
		case 2:
		case "2":
			$('#fldst_type_droffice').show(); 
			break;
		default:
			break;
	}
}

function initialize_frm_map() {
  	var mapOptions = {  
				center: { lat: ini_lat, lng: ini_lng }, 
				zoom: 8,
	            mapTypeControl: true,
		        streetViewControl: true
			}; 
	map = new google.maps.Map(document.getElementById('map-pdv'), mapOptions); 
	
	var image = 'img/marker.png'; 
	pdv_marker = new google.maps.Marker({ 
		position: { lat: ini_lat, lng: ini_lng}, 
		draggable:true, 
		animation: google.maps.Animation.DROP,
		icon: image,
		map: 	map
	});
	   
	google.maps.event.addListener(pdv_marker, "dragend", function() { 
		var coords  = pdv_marker.getPosition(); 
		$('#inp_latitude' ).val( coords.B );
		$('#inp_longitude').val( coords.k );
	});
}

function delete_pdv( which ){
	if (which > 0 && confirm('¿Está seguro que desea borrar el pdv seleccionado?') ){
		$.ajax({
			url: "ajax.php", type: "POST",  
			data: {
		  		resource: 	'admin.pdv', 
		  		action: 	'delete_pdv', 
		  		id_pdv: which 
			},
		  	dataType: "json",
		 	success: function(data) {
				if (data.success == true )  {
					show_message( "El pdv se borró exitosamente." );
					reload_table( 'lst_pdv' );
				} else {  
					show_error( data.error );
					return false;
				}
			}
		}); 
	} 
}


function edit_pdv( pdv ){
	window.location = "index.php?command=" + cmd_frm + "&cb=" + command + "&pdv=" + pdv ;
}

function load_detail_map(){
	var latitude  = parseFloat($('#det_pdv_latitude').val());
	var longitude = parseFloat($('#det_pdv_longitude').val());
	
	var mapOptions = {  
				center: { lat: latitude, lng: longitude }, 
				zoom: 8,
	            mapTypeControl: true,
		        streetViewControl: true
			}; 
	map = new google.maps.Map(document.getElementById('map-pdv'), mapOptions); 
	
	var image = 'img/marker.png'; 
	pdv_marker = new google.maps.Marker({ 
		position: { lat: latitude, lng: longitude}, 
		animation: google.maps.Animation.DROP,
		icon: image,
		map: 	map
	}); 
}

function detail_pdv( which, force ){
	if (which > 0){
		if ( which != $('#inp_detail_id_pdv').val() || force == true ){
			$.ajax({
				url: "ajax.php",
				type: "POST",
				async: false,
				data: {
			  		resource: 	'pdv',
			  		action: 	'get_pdv_info_html',
		    		id_pdv: 	which
				},
			  	dataType: "json",
			 	success: function(data) {
					if (data.success == true )  {
						var html = data.html;
						$('#inp_detail_id_pdv').val( which );
						$('#detail_pdv_content').html( html );
						
						$('#mdl_detail_pdv').modal('show');
						load_detail_map();
					}
					else {  
						show_error( data.error );
						return false;
					}
				}
			}); 
		} else {
			$('#mdl_detail_pdv').modal('show');
		}
	} 
}
  
function is_unique( pdv ){
	$.ajax({
		url: "ajax.php",
		type: "POST",
		async: false,
		data: {
	  		resource: 	'pdv',
	  		action: 	'is_unique_pdv',
    		id_pdv: 	$('#inp_id_pdv').val(), 
    		pdv: 		pdv
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

function is_unique_viamente( pdv ){
	$.ajax({
		url: "ajax.php",
		type: "POST",
		async: false,
		data: {
	  		resource: 	'pdv',
	  		action: 	'is_unique_viamente',
    		id_pdv: 	$('#inp_id_pdv').val(), 
    		viamente:	viamente
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

function upload_pdvs()
{
	$("#inp_csv_pdv").val('');
	$("#mdl_upload_pdv").modal('show');
}

    
var unique;
$(document).ready(function() {
	$.formUtils.addValidator({
		name : 'unique-pdv',
		validatorFunction : function(value, $el, config, language, $form) {
			if (value.length > 3){				
				is_unique(value);				
				return unique;
			} else 
				return true;
		},
		errorMessage : 'El pdv ya existe. ',
		errorMessageKey: 'badPDVUnique'
	});
	
	$.formUtils.addValidator({
		name : 'unique-viamente',
		validatorFunction : function(value, $el, config, language, $form) {
			if (value.length > 3){
				is_unique_viamente( value );
				return unique;
			} else 
				return true;
		},
		errorMessage : 'El id viamente ya fue asignado. ',
		errorMessageKey: 'badViamenteUnique'
	});
	
	$.validate({
		form : '#frm_pdv',
		language : validate_language 
	});
	
	initialize_frm_map();
	
	$('#inp_dr_birthdate').datepicker({setDate: new Date()});
});

