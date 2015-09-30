function adjust_sitemap_size()
{
	var x = $("#inp_map_x").val();
	var y = $("#inp_map_y").val();
	
	$.ajax({
		url: "ajax.php",
		type: "POST",
		async: false,
		data:
		{
			resource: 	'sitemap',
			action: 	'set_sitemap_size',
			x:			x,
			y:			y
		},
		dataType: "json",
		success: function(data) {
			
			if (data.success == true )
			{
				$("#sitemap").html(data.html);
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

function asign_computer(state, site)
{
	if (site > 0)
	{
		if (state > 0) 
		{
			$("#inp_site").val(site);
			$("#inp_id_computer").val(0);
			$("#mdl_frm_sitemap").modal('show');
		}
		else
		{
			if (confirm('¿Eliminar computadora de este espacio?'))
			{
				set_computer(0, site);
			}
		}
	}
}

function set_computer(state, site)
{
	if ( !site > 0)
	{
		site = $("#inp_site").val();
	}
	
	var computer = $("#inp_id_computer").val();
	
	$.ajax({
		url: "ajax.php",
		type: "POST",
		async: false,
		data:
		{
			resource: 	'sitemap',
			action: 	'set_computer',
			site:		site,
			status:		state,
			computer:	computer
		},
		dataType: "json",
		success: function(data)
		{
			if (data.success == true )
			{
				$("#sitemap").html(data.html);
				show_message('Computadora asignada con exito.');
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