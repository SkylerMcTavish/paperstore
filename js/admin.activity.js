function edit_activity_type(id_activity_type)
{
	clean_activity_type_form();
	if (id_activity_type > 0)
	{
		$.ajax
		({
			url: "ajax.php",
			type: "POST",
			async: false,
			data:
			{
		  		resource: 			'admin.activity',
		  		action: 			'get_activity_type_info',
	    		id_activity_type: 	id_activity_type 
			},
		  	dataType: "json",
		 	success: function(data)
			{
				if (data.success == true )
				{
					var actype = data.info;
					$("#inp_id_activity_type").val(actype.id_activity_type);
					$("#inp_activity_type").val(actype.activity_type);
					$("#inp_table_aux").val(actype.table_aux);
					
					$("#mdl_frm_activity_type").modal('show');
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
		$("#mdl_frm_activity_type").modal('show');
	}
}

function clean_activity_type_form()
{
	$("#inp_id_activity_type").val(0);
	$("#inp_activity_type").val('');
	$("#inp_table_aux").val('');
}

function filter_table_aux()
{
	var actype = $("#inp_activity_type_id") .val();
	if (actype > 0) 
	{	
		$.ajax
		({
			url: "ajax.php",
			type: "POST",
			async: false,
			data:
			{
				resource: 			'admin.activity',
				action: 			'get_activity_type_aux_table',
				id_activity_type: 	actype
			},
			dataType: "json",
			success: function(data)
			{
				if (data.success == true )
				{
					var req = data.required;
					
					$("#inp_activity_aux").attr('required', req);
					$("#inp_activity_aux").prop('disabled', !req);
					
					if (req) 
						$("#inp_activity_aux").html(data.html);
					
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

function clean_activity_form()
{
	$("#inp_activity").val('');
	$("#inp_activity_type_id").val(0);
	$("#inp_activity_aux").html('<option value="" disabled>Sin Auxiliar</option>');
	$("#inp_activity_aux").val('');
	$("#inp_activity_aux").prop('disabled', 'disabled');
	$("#inp_activity_description").val('');
	$("#inp_id_activity").val(0);
}

function edit_activity(id_activity)
{

	clean_activity_form();
	if (id_activity > 0)
	{
		$.ajax
		({
			url: "ajax.php",
			type: "POST",
			async: false,
			data:
			{
		  		resource: 		'admin.activity',
		  		action: 		'get_activity_info',
	    		id_activity: 	id_activity 
			},
		  	dataType: "json",
		 	success: function(data)
			{
				if (data.success == true )
				{
					var info = data.info;
					var actype = info.activity_type;
					
					$("#inp_activity").val(info.activity);
					$("#inp_activity_type_id").val(actype.id_activity_type);
					$("#inp_activity_description").val(info.description);
					$("#inp_id_activity").val(info.id_activity);
					
					filter_table_aux();
					$("#inp_activity_aux").val(info.id_aux);
					
					
					$("#mdl_frm_activity").modal('show');
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
		$("#mdl_frm_activity").modal('show');
	}
}

function detail_activity(id_activity)
{
	if (id_activity > 0)
	{
		
		$.ajax
		({
			url: "ajax.php",
			type: "POST",
			async: false,
			data:
			{
		  		resource: 		'admin.activity',
		  		action: 		'get_activity_info_html',
	    		id_activity: 	id_activity 
			},
		  	dataType: "json",
		 	success: function(data)
			{
				if (data.success == true )
				{
					$("#detail_activity_content").html(data.html);
					$("#mdl_detail_activity").modal('show');
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

function delete_activity_type(id_activity_type)
{
	if (id_activity_type > 0)
	{
		if (confirm('¿Eliminar el registro?'))
		{
			$.ajax
			({
				url: "ajax.php",
				type: "POST",
				async: false,
				data:
				{
					resource: 			'admin.activity',
					action: 			'delete_activity_type',
					id_activity_type: 	id_activity_type 
				},
				dataType: "json",
				success: function(data)
				{
					if (data.success == true )
					{
						show_message('El registro se eliminó exitosamente.');
						reload_table('lst_activity_type');
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
}