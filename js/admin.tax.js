function edit_tax(id_tax)
{
	clean_tax_form();
	if (id_tax > 0)
	{
		$.ajax({
			url: "ajax.php",
			type: "POST",
			async: false,
			data: {
				resource: 	'tax',
				action: 	'get_tax_info',
				id_tax: 	id_tax
			},
			dataType: "json",
			success: function(data)
			{
				if (data.success == true )
				{
					var info = data.info;
					
					$("#inp_tax").val(info.tax);
					$("#inp_hour").val(info.hour);
					$("#inp_type").val(info.id_type);
					$("#inp_fraction").val(info.fraction);
					$("#inp_first_half").val(info.fhalf);
					$("#inp_second_half").val(info.shalf);
					$("#inp_id_tax").val(info.id_tax);
					
					$("#mdl_frm_tax").modal('show');
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
		$("#mdl_frm_tax").modal('show');
}

function clean_tax_form()
{
	$("#inp_tax").val('');
	$("#inp_hour").val(1);
	$("#inp_type").val('');
	$("#inp_fraction").val('');
	$("#inp_first_half").val('');
	$("#inp_second_half").val('');
	$("#inp_id_tax").val(0);
}

function delete_tax(id_tax)
{
	if (id_tax > 0)
	{
		if (confirm('¿Desea eliminar la tarifa?'))
		{
			$.ajax({
				url: "ajax.php",
				type: "POST",
				async: false,
				data: {
					resource: 	'tax',
					action: 	'delete_tax',
					id_tax: 	id_tax
				},
				dataType: "json",
				success: function(data)
				{
					if (data.success == true )
					{
						reload_table('lst_tax');
						show_message('La tarifa se elimino con exito.');
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
		$("#mdl_frm_tax").modal('show');
}

function use_tax(id_tax)
{
	if (id_tax > 0)
	{
		if (confirm('¿Usar esta tarifa?'))
		{
			$.ajax({
				url: "ajax.php",
				type: "POST",
				async: false,
				data: {
					resource: 	'tax',
					action: 	'use_tax',
					id_tax: 	id_tax
				},
				dataType: "json",
				success: function(data)
				{
					if (data.success == true )
					{
						show_message('La tarifa se selecciono con exito.');
						
						var info = data.info;
						$("#sp_def_tax").html(info.tax);
						$("#sp_def_hour").html(info.hour);
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