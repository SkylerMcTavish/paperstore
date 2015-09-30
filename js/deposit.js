function detail_deposit(id_deposit)
{
	$.ajax
	({
		url: "ajax.php",
		type: "POST",
		async: false,
		data:
		{
			resource: 	'deposit',
			action: 	'get_deposit_info_html',
			id_deposit: id_deposit
		},
		dataType: "json",
		success: function(data)
		{
			if (data.success == true )
			{
				var html = data.html;
				$('#inp_detail_id_deposit').val( id_deposit );
				$('#detail_deposit_content').html( html );
				
				$("#mdl_detail_deposit").modal('show');
			}
			else
			{  
				show_error( data.error );
				return false;
			}
		}
	}); 
}

function evidence_deposit(which)
{
	
}