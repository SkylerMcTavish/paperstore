function load_detail_map(){
	var latitude  = parseFloat($('#det_pdv_latitude').val());
	var longitude = parseFloat($('#det_pdv_longitude').val());
	
	var mapOptions = {  
				center: { lat: latitude, lng: longitude }, 
				zoom: 8,
	            mapTypeControl: true,
		        streetViewControl: true
			}; 
	map = new google.maps.Map(document.getElementById('map-pdv'), mapOptions); 
	
	var image = 'img/marker.png'; 
	pdv_marker = new google.maps.Marker({ 
		position: { lat: latitude, lng: longitude}, 
		animation: google.maps.Animation.DROP,
		icon: image,
		map: 	map
	}); 
}

function detail_pdv( which, force ){
	if (which > 0){
		if ( which != $('#inp_detail_id_pdv').val() || force == true ){
			$.ajax({
				url: "ajax.php",
				type: "POST",
				async: false,
				data: {
			  		resource: 	'pdv',
			  		action: 	'get_pdv_info_html',
		    		id_pdv: 	which
				},
			  	dataType: "json",
			 	success: function(data) {
					if (data.success == true )  {
						var html = data.html;
						$('#inp_detail_id_pdv').val( which );
						$('#detail_pdv_content').html( html );
						
						$('#mdl_detail_pdv').modal('show');
						load_detail_map();
					}
					else {  
						show_error( data.error );
						return false;
					}
				}
			}); 
		} else {
			$('#mdl_detail_pdv').modal('show');
		}
	} 
}

function initialize_frm_map() {
  	var mapOptions = {  
				center: { lat: ini_lat, lng: ini_lng }, 
				zoom: 8,
	            mapTypeControl: true,
		        streetViewControl: true
			}; 
	map = new google.maps.Map(document.getElementById('map-pdv'), mapOptions); 
	
	var image = 'img/marker.png'; 
	pdv_marker = new google.maps.Marker({ 
		position: { lat: ini_lat, lng: ini_lng}, 
		draggable:true, 
		animation: google.maps.Animation.DROP,
		icon: image,
		map: 	map
	});
	   
	google.maps.event.addListener(pdv_marker, "dragend", function() { 
		var coords  = pdv_marker.getPosition(); 
		$('#inp_latitude' ).val( coords.B );
		$('#inp_longitude').val( coords.k );
	});
}