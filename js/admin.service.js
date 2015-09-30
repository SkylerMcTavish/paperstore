function edit_service(id_service)
{
	clean_service_form();
	if (id_service > 0 ) 
	{
		$.ajax({
			url: "ajax.php",
			type: "POST",
			async: false,
			data:
			{
		  		resource: 		'service',
		  		action: 		'info_service',
				id_service:		id_service,
			},
		  	dataType: "json",
		 	success: function(data)
			{
				if (data.success == true )
				{
					var info = data.info;
					$("#inp_service").val(info.service);
					$("#inp_price").val(info.price);
					$("#inp_id_service").val(info.id_service);
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
	$("#mdl_frm_service").modal('show');
	
}

function delete_service(id_service)
{
	if (id_service > 0 ) 
	{
		if (confirm('¿Segura que desea eliminar el servicio?'))
		{
			$.ajax({
				url: "ajax.php",
				type: "POST",
				async: false,
				data:
				{
					resource: 		'service',
					action: 		'delete_service',
					id_service:		id_service,
				},
				dataType: "json",
				success: function(data)
				{
					if (data.success == true )
					{
						show_message('Servicio eliminado con éxito.');
						reload_table('lst_service');
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

function clean_service_form()
{
	$("#inp_service").val('');
	$("#inp_price").val(0);
	$("#inp_id_service").val(0);
}

function add_product()
{
	var id_product = $("#inp_sel_id_product_paper").val();
	
	$.ajax({
			url: "ajax.php",
			type: "POST",
			async: false,
			data:
			{
		  		resource: 		'service',
		  		action: 		'add_service_product',
				id_service:		id_service,
	    		id_product: 	id_product 
			},
		  	dataType: "json",
		 	success: function(data)
			{
				if (data.success == true )
				{
					var html = data.html;
					$("#tbl_service_detail").html(html);
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

function delete_product_service(id_product)
{
	alert(id_product);
	$.ajax({
			url: "ajax.php",
			type: "POST",
			async: false,
			data:
			{
		  		resource: 		'service',
		  		action: 		'delete_service_product',
				id_service:		id_service,
	    		id_product: 	id_product 
			},
		  	dataType: "json",
		 	success: function(data)
			{
				if (data.success == true )
				{
					var html = data.html;
					alert(html);
					$("#tbl_service_detail").html(html);
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

function confirm_service()
{
	var link = 'index.php?command='+cb;
	window.location = link;
}