function detail_invoice(id_invoice)
{
	$.ajax
	({
		url: "ajax.php",
		type: "POST",
		async: false,
		data:
		{
			resource: 	'invoice',
			action: 	'get_invoice_info_html',
			id_invoice: id_invoice
		},
		dataType: "json",
		success: function(data)
		{
			if (data.success == true )
			{
				var html = data.html;
				$('#inp_detail_id_invoice').val( id_invoice );
				$('#detail_invoice_content').html( html );
				
				$("#mdl_detail_invoice").modal('show');
			}
			else
			{  
				show_error( data.error );
				return false;
			}
		}
	}); 
}
