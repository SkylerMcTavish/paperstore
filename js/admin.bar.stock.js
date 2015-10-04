function supply_bar_stock(id_stock)
{
	clean_bar_supply_form();
	if (id_stock > 0)
	{
		$.ajax
		({
			url: "ajax.php",
			type: "POST",
			async: false,
			data:
			{
				resource: 	'stock',
				action: 	'get_bar_stock_info',
				id_stock: 	id_stock
			},
			dataType: "json",
			success: function(data)
			{				
				if (data.success == true )
				{
					var info = data.info;
					$("#inp_id_bar_supply").val(info.id_stock);
					$("#inp_id_product").html('<option value='+info.id_product+'>'+info.product+'</option>');
					$("#inp_id_product").val(info.id_product);
					$("#inp_quantity").val(info.quantity);
					$("#inp_min").val(info.min);
					//$("#inp_max").val(info.max);
					$("#inp_price").val(info.sell_price);
					$("#inp_buy_price").val(info.buy_price);
					$("#inp_supply").val(0);//max_supplier
					//$("#inp_supply").attr('max' , info.max_supplier);
					$("#inp_supply").attr('min' , 0);
					
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
	
	$("#mdl_frm_bar_supply").modal('show');
}

function clean_bar_supply_form()
{
	$("#inp_id_bar_supply").val(0);
	$("#inp_id_product").val(0);
	$("#inp_quantity").val(0);
	$("#inp_min").val(0);
	$("#inp_max").val(0);
	$("#inp_price").val(0);
	$("#inp_supply").val(0);
}

function supply_list()
{
	$.ajax
	({
		url: "ajax.php",
		type: "POST",
		async: false,
		data:
		{
			resource: 	'stock',
			action: 	'get_supply_list_html'
		},
		dataType: "json",
		success: function(data)
		{
			if (data.success == true )
			{
				var html = data.html;			
				$("#supply_list").html(html);
				return true;
			}
			else
			{
				show_error( data.error );
				return false;
			}
		}
	}); 	
	$("#mdl_frm_supply_list").modal('show');
}

function add_to_list(id_product, stock)
{
	var pd = ':pd_' + id_product;
	var pds = $("#inp_supply_list_pd").val();
	var state = $("#chk_"+stock).is(':checked');	
	
	if (state)
	{
		//alert("Action [ADD] product ["+pd+"] into ["+pds+"]" );
		pds = pds + pd;
	}
	else
	{
		//alert("Action [DEL] product ["+pd+"] into ["+pds+"]" );
		pds = pds.replace(pd, "");
	}
	//alert("Result ["+pds+"]");
	$("#inp_supply_list_pd").val(pds);
}

function load_products()
{
	$("#inp_csv_products").val('');	
	$("#mdl_upload_products").modal('show');
}