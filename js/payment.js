function detail_payment(id_payment)
{

	$.ajax
	({
		url: "ajax.php",
		type: "POST",
		async: false,
		data:
		{
			resource: 	'payment',
			action: 	'get_payment_info_html',
			id_payment: id_payment
		},
		dataType: "json",
		success: function(data)
		{
			if (data.success == true )
			{
				var html = data.html;
				$('#inp_detail_id_payment').val( id_payment );
				$('#detail_payment_content').html( html );
				
				$("#mdl_detail_payment").modal('show');
			}
			else
			{  
				show_error( data.error );
				return false;
			}
		}
	}); 
}