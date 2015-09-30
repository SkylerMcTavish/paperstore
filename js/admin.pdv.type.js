function edit_pdv_type(id_pvt)
{
	clean_pdv_type_form();
	if (id_pvt > 0)
	{
		$.ajax
		({
			url: "ajax.php",
			type: "POST",
			async: false,
			data:
			{
				resource: 		'admin.pdv',
				action: 		'get_pdv_type_info',
				id_pdv_type: 	id_pvt 
			},
			dataType: "json",
			success: function(data)
			{
				if (data.success == true )
				{
					var info = data.info;
					
					$("#inp_pdv_type").val(info.pdv_type);
					$("#inp_id_pdv_type").val(info.id_pdv_type);
					
					$("#mdl_frm_pdv_type").modal('show');
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
		$("#mdl_frm_pdv_type").modal('show');
	}
}

function clean_pdv_type_form()
{
	$("#inp_pdv_type").val('');
	$("#inp_id_pdv_type").val(0);
}

function delete_pdv_type(id_pdv_type)
{
	if (id_pdv_type > 1)
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
					resource: 		'admin.pdv',
					action: 		'delete_pdv_type',
					id_pdv_type: 	id_pdv_type 
				},
				dataType: "json",
				success: function(data)
				{
					if (data.success == true )
					{
						show_message('Registro borrado con exito.');
						reload_table('lst_pdv_type');
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
		show_error('Invalid PDV Type');
	}
}

function clean_pdv_task_form()
{
	$("#inp_asgn_id_pdv_type").val(0);
	$("#inp_asgn_id_ttype").val(0);
}

function asgn_pdv_task()
{
	clean_pdv_task_form();
	$("#mdl_frm_pdvtype_ttype").modal('show');
}

function set_pdv_type_task_type()
{
	var id_pdv_type		= $("#inp_asgn_id_pdv_type").val();
	var id_ttype 		= $("#inp_asgn_id_ttype").val();
	
	if (id_pdv_type > 0 )
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
					resource: 		'admin.pdv',
					action: 		'set_pdv_type_task_type',
					status:			1,
					id_pdv_type:	id_pdv_type,
					id_ttype:		id_ttype
				},
				dataType: "json",
				success: function(data)
				{
					if (data.success == true )
					{
						reload_table('lst_pdv_type_task');
						$("#mdl_frm_pdvtype_ttype").modal('hide');
						show_message('Tarea asignada con exito.');
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

function delete_pdv_type_task_type(id_pdv_type, id_ttype )
{
	if (id_pdv_type > 0 )
	{
		if (id_ttype > 0)
		{
			if (confirm('¿Desasignar la tarea?'))
			{		
				$.ajax
				({
					url: "ajax.php",
					type: "POST",
					async: false,
					data:
					{
						resource: 		'admin.pdv',
						action: 		'set_pdv_type_task_type',
						status:			0,
						id_pdv_type:	id_pdv_type,
						id_ttype:		id_ttype
					},
					dataType: "json",
					success: function(data)
					{
						if (data.success == true )
						{
							reload_table('lst_pdv_type_task');
							$("#mdl_frm_pdvtype_ttype").modal('hide');
							show_message('Tarea asignada con exito.');
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

function detail_pdv_type_task_type(id_pdv_type)
{
	if (id_pdv_type > 0)
	{
		$.ajax
		({
			url: "ajax.php",
			type: "POST",
			async: false,
			data:
			{
				resource: 		'admin.pdv',
				action: 		'get_pdv_type_task_type_html',
				id_pdv_type:	id_pdv_type,
			},
			dataType: "json",
			success: function(data)
			{
				if (data.success == true )
				{
					$("#detail_pvt_ttype_content").html(data.html);
					$("#mdl_detail_pvt_ttype").modal('show');
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
