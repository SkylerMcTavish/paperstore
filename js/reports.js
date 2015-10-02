function generate_report() {
	var id_product = $("#flt_product").val();
	var fini = $("#flt_fini").val();
	var ffin = $("#flt_ffin").val();
	$.ajax({
		url: "ajax.php",
		type: "POST",
		async: false,
		data:
		{
			resource: 		'reports',
			action: 		'rep.balance.generate_report',
			id_product: 	id_product,
			fini:			fini,
			ffin:			ffin
		},
		dataType: "json",
		success: function(data)
		{
			if (data.success == true )
			{
				var html = data.html;
				$("#product_tabs").html(html);				
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