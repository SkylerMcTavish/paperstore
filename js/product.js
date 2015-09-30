function detail_product( which, force )
{
	if (which > 0)
	{
		if ( which != $('#inp_detail_id_product').val() || force == true )
		{
			
			$.ajax({
				url: "ajax.php",
				type: "POST",
				async: false,
				data: {
			  		resource: 	'product',
			  		action: 	'get_product_info_html',
		    		id_product: which
				},
			  	dataType: "json",
			 	success: function(data) {
					if (data.success == true )  {
						var html = data.html;
						$('#inp_detail_id_product').val( which );
						$('#detail_product_content').html( html );
						
						$('#mdl_detail_product').modal('show');
						load_detail_map();
					}
					else {  
						show_error( data.error );
						return false;
					}
				}
			}); 
		}
		else
		{
			$('#mdl_detail_product').modal('show');
		}
	} 
}