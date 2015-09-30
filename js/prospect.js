function detail_prospect(id_prospect)
{
	if (id_prospect > 0)
	{
		$.ajax(
		{
			url: "ajax.php",
			type: "POST",
			async: false,
			data:
			{
				resource: 		'prospect',
				action: 		'get_prospect_info_html',
				id_prospect:  	id_prospect
			},
			dataType: "json",
			success: function(data)
			{
				if (data.success == true )
				{
					var html = data.html;
					$("#detail_prospect_content").html(html);
					$("#mdl_detail_prospect").modal('show');
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
		show_error('Invalid Prospect');
	}
}