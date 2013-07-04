<html>
<head>
<style type="text/css">
body {
	background-image: url(images/back.jpg);
	background-repeat:!important;
	text-align: center;
}
.button {
	background-color: #000;
	color: #FFF;
	font-weight: bold;
	text-transform: uppercase;
}
.title {
	letter-spacing: normal;
	word-spacing: normal;
}
.subtitle {
	background-image: url(images/transparent.png);
	background-repeat:inherit;
	font-size: x-large;
}
.container .content table tr td #form1 table tr td {
	text-align: left;
	font-weight: bold;
}
.container .content p {
	text-align: center;
	font-weight: bold;
	font-size: large;
	font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
}
#Myrules {
	margin-top: 100px;
	margin-right: auto;
	margin-bottom: auto;
	margin-left: 50px;
}
.container .content .overlay table tr td #form2 table tr td {
	text-align: left;
	font-weight: bold;
}
</style>
<!-- TemplateBeginEditable name="head" -->
<!-- TemplateEndEditable -->
<script src="SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<link href="SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css" />

<title>Distance finder</title>
<meta type="description" content="Find the distance between two places on the map and the shortest route."/>
<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=true"></script>
<script type="text/javascript">
	var location1;
	var location2;
	
	var address1;
	var address2;
	var latlng;
	var geocoder;
	var map;
	
	var distance;
	
	
	function initialize()
	{
		geocoder = new google.maps.Geocoder(); 
		
		
		address1 = document.getElementById("address1").value;
		address2 = document.getElementById("address2").value;
		
		
		if (geocoder) 
		{
			geocoder.geocode( { 'address': address1}, function(results, status) 
			{
				if (status == google.maps.GeocoderStatus.OK) 
				{
					
					location1 = results[0].geometry.location;
				} else 
				{
					alert("Geocode was not successful for the following reason: " + status);
				}
			});
			geocoder.geocode( { 'address': address2}, function(results, status) 
			{
				if (status == google.maps.GeocoderStatus.OK) 
				{
					
					location2 = results[0].geometry.location;
					
					showMap();
				} else 
				{
					alert("Geocode was not successful for the following reason: " + status);
				}
			});
		}
	}
		
	
	function showMap()
	{
		
		latlng = new google.maps.LatLng((location1.lat()+location2.lat())/2,(location1.lng()+location2.lng())/2);
		
		
		var mapOptions = 
		{
			zoom: 1,
			center: latlng,
			mapTypeId: google.maps.MapTypeId.HYBRID
		};
		
		map = new google.maps.Map(document.getElementById("map_canvas"), mapOptions);
		
		
		directionsService = new google.maps.DirectionsService();
		directionsDisplay = new google.maps.DirectionsRenderer(
		{
			suppressMarkers: true,
			suppressInfoWindows: true
		});
		directionsDisplay.setMap(map);
		var request = {
			origin:location1, 
			destination:location2,
			travelMode: google.maps.DirectionsTravelMode.DRIVING
		};
		directionsService.route(request, function(response, status) 
		{
			if (status == google.maps.DirectionsStatus.OK) 
			{
				directionsDisplay.setDirections(response);
				distance = "The distance between the two points on the chosen route is: "+response.routes[0].legs[0].distance.text;
				distance += "<br/>The aproximative driving time is: "+response.routes[0].legs[0].duration.text;
				document.getElementById("distance_road").innerHTML = distance;
			}
		});
		
		
		var line = new google.maps.Polyline({
			map: map, 
			path: [location1, location2],
			strokeWeight: 7,
			strokeOpacity: 0.8,
			strokeColor: "#FFAA00"
		});
		
		
		var marker1 = new google.maps.Marker({
			map: map, 
			position: location1,
			title: "First location"
		});
		var marker2 = new google.maps.Marker({
			map: map, 
			position: location2,
			title: "Second location"
		});
		
		
		var text1 = '<div id="content">'+
				'<h1 id="firstHeading">First location</h1>'+
				'<div id="bodyContent">'+
				'<p>Coordinates: '+location1+'</p>'+
				'<p>Address: '+address1+'</p>'+
				'</div>'+
				'</div>';
				
		var text2 = '<div id="content">'+
			'<h1 id="firstHeading">Second location</h1>'+
			'<div id="bodyContent">'+
			'<p>Coordinates: '+location2+'</p>'+
			'<p>Address: '+address2+'</p>'+
			'</div>'+
			'</div>';
		
		
		var infowindow1 = new google.maps.InfoWindow({
			content: text1
		});
		var infowindow2 = new google.maps.InfoWindow({
			content: text2
		});
		
		google.maps.event.addListener(marker1, 'click', function() {
			infowindow1.open(map,marker1);
		});
		google.maps.event.addListener(marker2, 'click', function() {
			infowindow2.open(map,marker1);
		});
		
		
		var R = 6371; 
		var dLat = toRad(location2.lat()-location1.lat());
		var dLon = toRad(location2.lng()-location1.lng()); 
		
		var dLat1 = toRad(location1.lat());
		var dLat2 = toRad(location2.lat());
		
		var a = Math.sin(dLat/2) * Math.sin(dLat/2) +
				Math.cos(dLat1) * Math.cos(dLat1) * 
				Math.sin(dLon/2) * Math.sin(dLon/2); 
		var c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1-a)); 
		var d = R * c;
		
		document.getElementById("distance_direct").innerHTML = "<br/>The distance between the two points (in a straight line) is: "+d;
	}
	
	function toRad(deg) 
	{
		return deg * Math.PI/180;
	}
</script>

</head>

	<div class="container" id="form" style="width:100%; height:50%">
		<div align="center">
		  <table align="center" valign="center">
		    <tr>
		      <td colspan="7" align="center"><b>Find the distance between two locations. You may also enter Lat &amp; Long</b></td>
		      </tr>
		    <tr>
		      <td colspan="7"><p>&nbsp;</p>
	          <p>&nbsp;</p>
	          <p>&nbsp;</p></td>
		      </tr>
		    <tr>
		      <td><strong>First address / Latitude-Longitude</strong>:</td>
		      <td>&nbsp;</td>
		      <td><input name="address1" type="text" class="container" id="address1" size="50"/></td>
		      <td>&nbsp;</td>
		      <td><strong>Second address / Latitude-Longitude</strong>:</td>
		      <td>&nbsp;</td>
		      <td><input name="address2" type="text" class="container" id="address2" size="50"/></td>
		      </tr>
		    <tr>
		      <td colspan="7"><p>&nbsp;</p>
	          <p>&nbsp;</p></td>
		      </tr>
		    <tr>
		      <td colspan="7" align="center"><input type="button" class="button" onClick="initialize();" value="Show"/></td>
		      </tr>
		    </table>
	  </div>
	</div>
    
<center><div style="width:100%; height:10%" id="distance_direct"></div></center>
	<center><div style="width:100%; height:10%" id="distance_road"></div></center>
	<center><div id="map_canvas" style="width:70%; height:100%"></div></center>
</body>

</html>
