<?php

if(ISSET($_REQUEST['latitud'])){
	$lat=$_REQUEST['latitud'];
	echo "<script>var latitude=$lat;</script>";	
}
if(ISSET($_REQUEST['longitud'])){
	$long=(string)$_REQUEST['longitud'];
		echo "<script>var longitude=$long;</script>";	
}

if(ISSET($_REQUEST['title'])){
	$title=$_REQUEST['title'];
		echo "<script>var title=$title;</script>";	
}
 /**/
?>

    <script src="https://maps.googleapis.com/maps/api/js?v=3.exp"></script>
    <script>
 
function setmap() {
 
  var myLatlng = new google.maps.LatLng(latitude,longitude);
  var mapOptions = {
    zoom: 11,
    center: myLatlng
  }
  var map = new google.maps.Map(document.getElementById('mapvisit'), mapOptions);

  var marker = new google.maps.Marker({
      position: myLatlng,
      map: map,
      title: title     
  });
}

google.maps.event.addDomListener(window, 'load', setmap);

    </script>

    <div id="mapvisit" style="height: 400px;"></div>


