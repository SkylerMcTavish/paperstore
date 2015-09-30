//22/12/14 cs

//Funciones del mapa 
var map2;
var newpoint=[];	

function mapinfo(){

	alert("Entro");
}

function initialize() {
  var mapOptions = {
    zoom: 10,
    center: new google.maps.LatLng(19.432602,-99.133205)
  };
  var map = new google.maps.Map(document.getElementById('map-canvas'),mapOptions);

  setMarkers(map, newpoint);
}

function setMarkers(map, locations) {
  
  var image = {
    url: 'img/marker.png',    
    size: new google.maps.Size(26, 46),
    origin: new google.maps.Point(0,0),
    anchor: new google.maps.Point(0, 46)
  };

  for (var i = 0; i < locations.length; i++) {
    var lipoints = locations[i];
    var myLatLng = new google.maps.LatLng(lipoints[1], lipoints[2]);
    var marker = new google.maps.Marker({
        position: myLatLng,
        map: map,
        icon: image,
        title: lipoints[0]
    });
  }
}


function newMarker(newpointmk,oldpoints, oldvalues) {
	var mapOptions = {
    zoom: 10,
    center: new google.maps.LatLng(19.432602,-99.133205)
 };
  var map = new google.maps.Map(document.getElementById('map-canvas'),mapOptions);
  
	setMarkers(map, oldpoints);
	var mwpoint=[];
	mwpoint.push(newpointmk);		
	var image = {
    	url: 'img/marker2.png',
    	size: new google.maps.Size(26, 46),
    	origin: new google.maps.Point(0,0),
    	anchor: new google.maps.Point(0, 46)
  };
  	 for (var i = 0; i < mwpoint.length; i++) {
		    var nwpoints = mwpoint[i];
		    var myLatLng = new google.maps.LatLng(nwpoints[1], nwpoints[2]);
			var marker = new google.maps.Marker({
		    	position: myLatLng,
		    	map: map,
		   		icon: image, 
		   		title: nwpoints[0]
		 	});
	}
	
}


function openerf(pdv_name, id_pdv, latitud, longitud){
	
	
	$("#inp_pdv").val(pdv_name);
	$("#inp_id_pdv").val(id_pdv);
	$('#mdl_frm_visit').modal('show');
	$("#inp_latitude").val(latitud);
	$("#inp_longitude").val(longitud);

}


/*Booking functions*/
function savetr(value){	
	
	inp_id=value.substring(5);	
	var trdata=$("#inp-"+inp_id).val();
	alert(trdata);
	res=trdata.split(",");	
	var c0=res[0];
	var c1=res[1];
	var c2=res[2];
	var c3=res[3];
	var c4=res[4];
	var c5=res[5];
	var c6=res[6];
	var c7=res[7];
	var c8=res[8];		

	$.ajax({
		url: "ajax.php",
		type: "POST",
		async: false,
		data: {
			resource: 	'admin.visit',
			action: 	'bookingsave',
		    c0: 	c0,
		    c1: 	c1,
		    c2: 	c2,
		    c3: 	c3,
		    c4: 	c4,
		    c5: 	c5,
		    c6: 	c6,
		    c7: 	c7,
		    c8: 	c8
		},
		dataType: "json",
		success: function(data) {
			if (data.success == true )  {
				var html = data.html;			
				$(".trlist_add"+c6).remove();
				$("#div-"+c0 ).hide();
				location.reload(); 
				return true;
			}else{
				show_error( data.error );
				return false;
			}
		}
	});
	
}
 
function elimiatetr(value, oldmarkers){
	var mapOptions = {
	    zoom: 10,
	    center: new google.maps.LatLng(19.432602,-99.133205)
	};
  var map = new google.maps.Map(document.getElementById('map-canvas'),mapOptions);

  setMarkers(map, oldmarkers);
	var r=confirm("¿Desea eliminar la visita "+value+"?");
 	if(r==true){	
		$("#div-"+value ).show();
		$(".trlist_add"+value).remove();
	}
	newpoint=oldmarkers;
}

function booking(){
	var latitude=$("#inp_latitude").val(); 
	var longitude=$("#inp_longitude").val(); 
	var fecha=$("#inp_fecha").val(); 
	fecha = fecha.split("/").reverse().join("/");	
	var hora_inicio=$("#inp_time_start").val();
	var hora_fin=$("#inp_time_end").val();
	hora_inicio=hora_inicio+":00";
	hora_fin=hora_fin+":00";
	var id_pdv=$("#inp_id_pdv").val();
	var pdv=$("#inp_pdv").val();
	var user=$("#inp_user").val();	
	var inicio_prog=fecha+" "+hora_inicio;
	var final_prog=fecha+" "+hora_fin;
	var inicio_real=fecha+" 00:00:00";
	var final_real=fecha+" 00:00:00";
	var col0=id_pdv;
	var col1=inicio_prog;
	var col2=final_prog;
	var col3=inicio_real;
	var col4=final_real;
	var col5=user; 
	var col6=pdv;
	
	var col1a=(Date.parse(col1))/1000;
	var col2a=(Date.parse(col2))/1000;
	var col3a=(Date.parse(col3))/1000;
	var col4a=(Date.parse(col4))/1000;
	var col7="Pre-agendada";
		
	oldpoints=newpoint.length;
	
	if(newpoint.length>0){
		oldmarkers=newpoint;
	}
	newpoint=[ pdv, latitude, longitude];
	newMarker(newpoint, oldmarkers);   
	
	var trdata=col0+","+col1a+","+col2a+","+col3a+","+col4a+","+col5+","+col6+","+latitude+","+longitude;	
	var col8="<button id='"+pdv+"' class='button' title='Eliminar' onclick='elimiatetr(this.id, oldmarkers);' ><i class='fa fa-trash-o'></i></button><button id='save-"+pdv+"' class='button' title='Guardar' onclick='savetr(this.id);'><i class='fa fa-plus' ></i></button><input type='hidden' id='inp-"+pdv+"' value='"+trdata+"' /><input type='hidden' id='nwmarker-"+newpoint[0]+"' value='"+newpoint[0]+"' />";
	var tr="<tr class='trlist_add"+pdv+"' style='background: #0F93E6;'><td>*</td><td>"+col1+"</td><td>"+col2+"</td><td>"+col3+"</td><td>"+col4+"</td><td>"+col5+"</td><td>"+col6+"</td><td>"+col7+"</td><td>"+col8+"</td></tr>";
		
	$("#lst_pry_visit_tbody").append(tr);
	$("#div-"+pdv ).hide();
	$("#mdl_frm_visit").modal("hide");
	
	/*añade un nuevo marcador  */
	
    
	alert("Visita Pre-agendada");
	
}



function clean_form(){
	
	$('#frm_usr_visit').reset();
}

function detail_visit( which){
	if (which > 0){
			$.ajax({
				url: "ajax.php",
				type: "POST",
				async: false,
				data: {
			  		resource: 	'visit',
			  		action: 	'get_visit_info_html',
		    		id_visit: 	which
				},
			  	dataType: "json",
			 	success: function(data) {
					if (data.success == true )  {
						var html = data.html;
				        $("#inp_detail_id_pdv").val(which);
						$('#mdl_detail_visit').modal('show');				
    			
						$('#detail_visit_content').html( html );
						/*$('#inp_detail_id_pdv').val( which );*/
												
					}
					else {  
						show_error( data.error );
						return false;
					}
				}
			}); 
		
	} 
}

function load_visits(){
	upload_visits();
}

function upload_visits(){
	$("#inp_csv_visit").val('');
	$("#mdl_upload_visit").modal('show');
}