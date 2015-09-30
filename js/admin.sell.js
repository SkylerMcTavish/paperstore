function use_product(id_product)
{
	if (id_product > 0)
	{
		$.ajax({
			url: "ajax.php",
			type: "POST",
			async: false,
			data:
			{
		  		resource: 		'sell',
		  		action: 		'get_sell_info_product',
	    		id_product: 	id_product 
			},
		  	dataType: "json",
		 	success: function(data)
			{
				if (data.success == true )
				{
					var info = data.info;
					$("#inp_id_product").val(info.id_product);
					$("#inp_id_stock").val(info.id_stock);
					$("#inp_product").val(info.product);
					$("#inp_price").val(info.price);
					$("#inp_quantity").attr('max', info.max);
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

function select_product()
{
	var id_product = $("#inp_sel_id_product_paper").val();
	use_product(id_product);
}

function select_product_cloth()
{
	var id_product = $("#inp_sel_id_product_cloth").val();
	use_product(id_product);
}

function select_product_gift()
{
	var id_product = $("#inp_sel_id_product_gift").val();
	use_product(id_product);
}

function add_product()
{
	var id_product 	= $("#inp_id_product").val();
	var id_sell		=  $("#inp_id_sell").val();
	var id_stock	=  $("#inp_id_stock").val();
	
	var price		=  $("#inp_price").val();
	var quantity	=  $("#inp_quantity").val();
	
	if (id_product > 0 && id_sell > 0)
	{
		$.ajax({
			url: "ajax.php",
			type: "POST",
			async: false,
			data:
			{
		  		resource: 		'sell',
		  		action: 		'add_product_sell',
	    		id_product: 	id_product,
				id_sell:		id_sell,
				id_stock:		id_stock,
				price:			price,
				quantity:		quantity
			},
		  	dataType: "json",
		 	success: function(data)
			{
				if (data.success == true )
				{
					var html = data.html;
					$("#tbl_sell_detail").html(html);
					$("#inp_quantity").val(1);
					show_message("Producto Agregado.");
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

function edit_product_sell(id_detail)
{
	var id_sell		=  $("#inp_id_sell").val();
	if (id_detail > 0 && id_sell > 0)
	{
		var quantity = prompt('Ingrese la nueva cantidad: ');
		if ( !isNaN(quantity) && quantity > 0)
		{
			$.ajax({
				url: "ajax.php",
				type: "POST",
				async: false,
				data:
				{
					resource: 		'sell',
					action: 		'edit_product_sell',
					id_sell:		id_sell,
					id_detail:		id_detail,
					quantity:		quantity
				},
				dataType: "json",
				success: function(data)
				{
					if (data.success == true )
					{
						var html = data.html;
						$("#tbl_sell_detail").html(html);
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
			show_error('Cantidad Inválida.');
		}
	}
}

function delete_product_sell(id_detail)
{
	var id_sell		=  $("#inp_id_sell").val();
	if (id_detail > 0 && id_sell > 0)
	{
		if (confirm('¿Eliminar producto de la venta?'))
		{
			$.ajax({
				url: "ajax.php",
				type: "POST",
				async: false,
				data:
				{
					resource: 		'sell',
					action: 		'delete_product_sell',
					id_sell:		id_sell,
					id_detail:		id_detail
				},
				dataType: "json",
				success: function(data)
				{
					if (data.success == true )
					{
						var html = data.html;
						$("#tbl_sell_detail").html(html);
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

function confirm_paybox()
{
	$("#inp_total_paybox").val( $("#inp_total").val() );
	$("#mdl_frm_paybox").modal('show');
}

function confirm_sell()
{
	var id_sell		=  $("#inp_id_sell").val();
	var url = 'index.php?command=' + cb;
	
	if (id_sell > 0)
	{
		$.ajax({
			url: "ajax.php",
			type: "POST",
			async: false,
			data:
			{
				resource: 		'sell',
				action: 		'confirm_sell',
				id_sell:		id_sell
			},
			dataType: "json",
			success: function(data)
			{
				if (data.success == true )
				{
					var html = data.html;
					$("#tbl_sell_detail").html(html);
					
					
					window.location = url;
					
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

function cancel_sell()
{
	var id_sell		=  $("#inp_id_sell").val();
	var url			= 'index.php?command=' + cb;
	
	if (id_sell > 0)
	{
		if (confirm('¿Cancelar la venta?')) 
		{
			$.ajax({
				url: "ajax.php",
				type: "POST",
				async: false,
				data:
				{
					resource: 		'sell',
					action: 		'cancel_sell',
					id_sell:		id_sell
				},
				dataType: "json",
				success: function(data)
				{
					if (data.success == true )
					{
						window.location = url;
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

function search_product()
{
	var search		=  $("#inp_srch_product").val();
	
	if (search != '')
	{
		$.ajax({
			url: "ajax.php",
			type: "POST",
			async: false,
			data:
			{
				resource: 		'sell',
				action: 		'search_product',
				search:			search
			},
			dataType: "json",
			success: function(data)
			{
				if (data.success == true )
				{
					$("#div_html_srch").html(data.html);
					$("#mdl_frm_sell_product").modal('show');
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