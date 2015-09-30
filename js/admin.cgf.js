/**
 * CGF Administration Functions
 */

/**
 * List Functions
 */
 function reload_cgf_table()
 {
	alert();
	if ( $('#flt_format ').val() > 0 )
	{
		$('#inp_lst_pdv_exfval').val( $('#flt_format').val() );
		$('#inp_lst_pdv_exfidx').val( 'id_format' ); 
	}
	else if ( $('#flt_group').val() > 0 )
	{
		$('#inp_lst_pdv_exfval').val( $('#flt_group').val() );
		$('#inp_lst_pdv_exfidx').val( 'id_group' ); 
	}
	else if ( $('#flt_channel').val() > 0 )
	{
		$('#inp_lst_pdv_exfval').val($( '#flt_channel' ).val() );
		$('#inp_lst_pdv_exfidx').val( 'id_channel' ); 
	}
	else
	{
		$('#inp_lst_pdv_exfval').val( '' );
		$('#inp_lst_pdv_exfidx').val( '' );  
	}
	
	reload_table( 'tbl_channel' ); 
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
	$('#inp_fr_id_channel'  ).val( 0 );
	$('#inp_fr_id_group'    ).val( 0 );
	$('#inp_id_format'		).val( 0 );
}

function edit_channel( id_channel )
{
	if ( id_channel > 0 )
	{
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
	}
	else
	{
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
		clean_channel_form(); 
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
		clean_channel_form(); 
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
