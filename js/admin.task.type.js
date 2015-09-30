function edit_task_type(id_task_type)
{
	clean_task_type_form();
	if (id_task_type > 0)
	{
		$.ajax
		({
			url: "ajax.php",
			type: "POST",
			async: false,
			data:
			{
				resource: 		'admin.task.type',
				action: 		'get_task_type_info',
				id_task_type: 	id_task_type 
			},
			dataType: "json",
			success: function(data)
			{
				if (data.success == true )
				{
					var info = data.info;
					
					$("#inp_task_type").val(info.task_type);
					$("#inp_description").val(info.description);
					$("#inp_id_task_type").val(info.id_task_type);
					
					$("#mdl_frm_task_type").modal('show');
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
		$("#mdl_frm_task_type").modal('show');
	}
}

function clean_task_type_form()
{
	$("#inp_task_type").val('');
	$("#inp_description").val('');
	$("#inp_id_task_type").val(0);
}

function asgn_ttype_activity()
{
	clean_asgn_task_type_activity();
	$("#mdl_frm_ttype_activity").modal('show');
}

function set_ttype_activity()
{
	var id_ttype = $("#inp_asgn_id_task_type").val();
	var id_activity = $("#inp_asgn_id_activity").val();
	
	if (id_ttype > 0 )
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
					resource: 		'admin.task.type',
					action: 		'set_task_type_activity',
					status:			1,
					id_ttype:		id_ttype,
					id_activity:	id_activity
				},
				dataType: "json",
				success: function(data)
				{
					if (data.success == true )
					{
						reload_table('lst_task_type_activities');
						$("#mdl_frm_ttype_activity").modal('hide');
						show_message('Actividad asignada con exito.');
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
			show_error('Invalid Activity');
		}
	}
	else
	{
		show_error('Invalid Task Type');
	}
}

function clean_asgn_task_type_activity()
{
	$("#inp_asgn_id_task_type").val(0);
	$("#inp_asgn_id_activity").val(0);
}

function delete_task_activity(id_ttype, id_activity)
{
	if (id_ttype > 0 )
	{
		if (id_activity > 0)
		{
			if (confirm('¿Desasignar la actividad?'))
			{
				$.ajax
				({
					url: "ajax.php",
					type: "POST",
					async: false,
					data:
					{
						resource: 		'admin.task.type',
						action: 		'set_task_type_activity',
						status:			0,
						id_ttype:		id_ttype,
						id_activity:	id_activity
					},
					dataType: "json",
					success: function(data)
					{
						if (data.success == true )
						{
							reload_table('lst_task_type_activities');
							show_message('Actividad desasignada con exito.');
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
		else
		{
			show_error('Invalid Activity');
		}
	}
	else
	{
		show_error('Invalid Task Type');
	}
}

function task_type_activities(id_ttype)
{
	if (id_ttype > 0)
	{
		$.ajax
		({
			url: "ajax.php",
			type: "POST",
			async: false,
			data:
			{
				resource: 		'admin.task.type',
				action: 		'get_task_type_activity_info_html',
				id_ttype:		id_ttype,
			},
			dataType: "json",
			success: function(data)
			{
				if (data.success == true )
				{
					$("#detail_ttype_activity_content").html(data.html);
					$("#mdl_detail_ttype_activity").modal('show');
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
		show_error('Invalid Activity');
	}
}

function detail_task_type(id_task_type)
{
	if (id_task_type > 0)
	{
		$.ajax
		({
			url: "ajax.php",
			type: "POST",
			async: false,
			data:
			{
				resource: 		'admin.task.type',
				action: 		'get_task_type_info',
				id_task_type: 	id_task_type 
			},
			dataType: "json",
			success: function(data)
			{
				if (data.success == true )
				{
					var info = data.info;
					
					$("#detail_task_type").html(info.task_type);
					$("#detail_description").html(info.description);
					
					$("#mdl_detail_task_type").modal('show');
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
		$("#mdl_frm_task_type").modal('show');
	}
}

function delete_task_type(id_ttype)
{
	if ( confirm('¿Eliminar el tipo de tarea?') )
	{
		$.ajax
		({
			url: "ajax.php",
			type: "POST",
			async: false,
			data:
			{
				resource: 		'admin.task.type',
				action: 		'delete_task_type',
				id_ttype: 		id_ttype 
			},
			dataType: "json",
			success: function(data)
			{
				if (data.success == true )
				{
					show_message('Tipo de tarea eliminada con exito.');
					reload_table('lst_task_type');
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