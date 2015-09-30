function edit_sell(id_sell)
{
	$("#mdl_frm_sell").modal('show');
}

function detail_sell(id_sell)
{
	if (id_sell > 0)
	{
		$.ajax({
			url: "ajax.php",
			type: "POST",
			async: false,
			data: {
				resource: 	'sell',
				action: 	'get_sell_info_html',
				id_sell: 	id_sell
			},
			dataType: "json",
			success: function(data)
			{
				if (data.success == true )
				{
					var html = data.html;
					$('#detail_sell_content').html( html );
					$("#mdl_detail_sell").modal('show');
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