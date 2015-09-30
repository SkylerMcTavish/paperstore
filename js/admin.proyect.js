/**
 * Proyect Administration Functions
 */

function edit_proyect( id ) {
	if ( !id > 0 ) id = 0;
	window.location = 'index.php?command=' + frm_command + '&idp=' + id + '&cb=' + command ;
}

function delete_proyect( id ) {
	if ( id > 0 && confirm('¿Está seguro que desea borrar éste proyecto?') ){
		
	}
}


function delete_cycle( from, to ){
	if (from > 0 && to > 0 && confirm('¿Está seguro que desea borrar el cíclo seleccionado?') ){
		$.ajax({
			url: "ajax.php", type: "POST",  
			data: {
		  		resource: 	'admin.proyect', 
		  		action: 	'delete_cycle', 
		  		from: 		from, 
		  		to: 		to 
			},
		  	dataType: "json",
		 	success: function(data) {
				if (data.success == true )  {
					show_message( "El cíclo se borró exitosamente." ); 
					reload_table( 'lst_pry_cycle'); 
				} else {  
					show_error( data.error );
					return false;
				}
			}
		}); 
	} 
}

function asign_to_proyect( which, inp ){
	if ( confirm('¿Está seguro que desea ' + ( inp.checked ? "asignar" : "desasignar" ) + ' el registro seleccionado?') ){
		$.ajax({
			url: "ajax.php", type: "POST",  
			data: {
		  		resource: 	'admin.proyect.asignation', 
		  		action: 	'asign_record', 
		  		source:		which, 
		  		id:			inp.value,  
		  		value:		inp.checked 
			},
		  	dataType: "json",
		 	success: function(data) {
				if (data.success == true )  {
					show_message( "El registro se " + ( inp.checked ? "asigno" : "desasigno" ) + " correctamente. "); 
					return true;
				} else {  
					show_error( data.error );
					return false;
				}
			}
		}); 
	} 
}

function activate_in_proyect( which, inp) {

	if ( confirm('¿Está seguro que desea activar el registro seleccionado?') )
	{
		$.ajax({
			url: "ajax.php", type: "POST",  
			data: {
		  		resource: 	'admin.proyect.asignation', 
		  		action: 	'activate_record', 
		  		source:		which, 
		  		id:			inp.value,  
		  		value:		inp.checked 
			},
		  	dataType: "json",
		 	success: function(data)
			{
				if (data.success == true )
				{
					show_message( "El registro se " + ( inp.checked ? "activó" : "desactivó" ) + " correctamente. "); 
					return true;
				} else {  
					show_error( data.error );
					return false;
				}
			}
		}); 
	} 
}

function asign_records( which, id_sel )
{
	var chk = $("#" + id_sel).is(':checked');
	if ( confirm('¿Está seguro que desea asignar todos los registros en la vista?') )
	{
		$("input.chck_asignation:checkbox").prop('checked', chk);
		var ids = new Array();
		$("input.chck_asignation:checkbox").each( function(){ ids.push($(this).val()) } );
		var users = ids.join(';');
		
		$.ajax({
			url: "ajax.php", type: "POST",  
			data: {
		  		resource: 	'admin.proyect.asignation', 
		  		action: 	'asign_records', 
		  		source:		which, 
		  		ids:		users,
		  		state:		chk
			},
		  	dataType: "json",
		 	success: function(data) {
				if (data.success == true )
				{
					show_message( "Los registros se " + ( chk ? "asignaron" : "desasignaron" ) + " correctamente. "); 
					return true;
				}
				else
				{  
					show_error( data.error );
					return false;
				}
			}
		}); 
	}
	else
	{
		$("#" + id_sel).prop('checked', !chk);
	}
	
}

function activate_records(which, id_sel )
{
	var chk = $("#" + id_sel).is(':checked');
	if ( confirm('¿Está seguro que desea activar todos los registros en la vista?') )
	{
		$("input.chck_activation:checkbox").prop('checked', chk);
		var ids = new Array();
		$("input.chck_activation:checkbox").each( function(){ ids.push($(this).val()) } );
		var users = ids.join(';');
		
		$.ajax({
			url: "ajax.php", type: "POST",  
			data: {
		  		resource: 	'admin.proyect.asignation', 
		  		action: 	'activate_records', 
		  		source:		which, 
		  		ids:		users,
		  		state:		chk
			},
		  	dataType: "json",
		 	success: function(data) {
				if (data.success == true )
				{
					show_message( "Los registros se " + ( chk ? "activaron" : "desactivaron" ) + " correctamente. "); 
					return true;
				}
				else
				{  
					show_error( data.error );
					return false;
				}
			}
		}); 
	}
	else
	{
		$("#" + id_sel).prop('checked', !chk);
	}
}

function asign_all(which, state)
{
	if ( confirm('¿Está seguro que desea ' + ( state ? "asignar" : "desasignar" ) + ' todos los registros existentes?') )
	{
		
		$.ajax({
			url: "ajax.php", type: "POST",  
			data: {
		  		resource: 	'admin.proyect.asignation', 
		  		action: 	'asign_all', 
		  		source:		which,
				state:		(state == true ? 1 : 0)
			},
		  	dataType: "json",
		 	success: function(data) {
				if (data.success == true )
				{
					show_message( "Todos los registros se " + ( state ? "asignaron" : "desasignaron" ) + " correctamente. "); 
					return true;
				}
				else
				{  
					show_error( data.error );
					return false;
				}
			}
		}); 
	}
}

function activate_all(which, state)
{
	if ( confirm('¿Está seguro que desea ' + ( state ? "activar" : "desactivar" ) + ' todos los registros existentes?') )
	{
		
		$.ajax({
			url: "ajax.php", type: "POST",  
			data: {
		  		resource: 	'admin.proyect.asignation', 
		  		action: 	'activate_all', 
		  		source:		which,
				state:		(state == true ? 1 : 0)
			},
		  	dataType: "json",
		 	success: function(data) {
				if (data.success == true )
				{
					show_message( "Todos los registros se " + ( state ? "activaron" : "desactivaron" ) + " correctamente. "); 
					return true;
				}
				else
				{  
					show_error( data.error );
					return false;
				}
			}
		}); 
	}
}





function load_table_supervisor(table)
{	
	$.ajax({
		url: "ajax.php",
		type: "POST",
		async: false,
		data: {
			resource: 		'lists',
			action:	 		'lst_pry_supervisor',
			table_id:		table,
			parent: $("#inp_id_supervisor").val()
		},
		dataType: "json",
		success: function(data)
		{
			if (data.success == true )
			{
				$('#' + table +'_tbody').html( data.html );
				$('#' + table +'_lbl_foot').html( data.lbl_foot );
				$('#' + table +'_lbl_tpages').html( data.tpages );
				
				$('#inp_' + table +'_rows').val( data.rows );
				$('#inp_' + table +'_page').val( data.page );
				
				set_header( table );
				
				$("#proyect-supervisor-overview").show();
			}
			else {  
				show_error( data.error );
				return false;
			}
		}
	}); 

	
}


function load_table_agenda(table)
{	
	$.ajax({
		url: "ajax.php",
		type: "POST",
		async: false,
		data: {
			resource: 		'lists',
			action:	 		'lst_pry_agenda',
			table_id:		table,
			parent: $("#inp_id_supervisor_agenda").val()
		},
		dataType: "json",
		success: function(data)
		{
			if (data.success == true )
			{
				$('#' + table +'_tbody').html( data.html );
				$('#' + table +'_lbl_foot').html( data.lbl_foot );
				$('#' + table +'_lbl_tpages').html( data.tpages );
				
				$('#inp_' + table +'_rows').val( data.rows );
				$('#inp_' + table +'_page').val( data.page );
				
				set_header( table );
				
				$("#proyect-agenda-overview").show();
			}
			else {  
				show_error( data.error );
				return false;
			}
		}
	}); 

	
}
function set_header( table ){
	
	var sidx = $('#inp_' + table + '_sidx').val();
	var str_sidx = table + '_hd_' + sidx;
	$('.' + table + '_head.sortable ' ).each( function( index ){ 
		var col  = this.id; 
		if ( col == str_sidx ){
			var sord =  $('#inp_' + table + '_sord').val() ;
			$('#' + this.id ).attr( 'class',  table + '_head sortable sorting_' + ( ( sord == 'DESC') ? 'asc' : 'desc'));
		} else
			$('#' + this.id ).attr( 'class',  table + '_head sortable sorting' );
			
	} );
	
}

function asign_supervisor(id_supervisor, id_usuario ,input)
{
	if ( confirm('¿Está seguro que desea ' + ( input.checked ? "asignar" : "desasignar" ) + ' el registro seleccionado?') )
	{
		$.ajax({
			url: "ajax.php", type: "POST",  
			data: {
				resource: 	'admin.proyect.supervisor', 
				action: 	'asign_user_supervisor', 
				state:		(input.checked ? 1 : 0),
				id_parent:	id_supervisor,
				id_user:	id_usuario
			},
			dataType: "json",
			success: function(data)
			{
				if (data.success == true )
				{
					show_message( "Usuario " + (input.checked ? "asignado" : "desasignado") + " correctamente."); 
					return true;
				}
				else
				{  
					show_error( data.error );
					return false;
				}
			}
		});
	}
	else
	{
		input.checked = !input.checked;
	}
}

