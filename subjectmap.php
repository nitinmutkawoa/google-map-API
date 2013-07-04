<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"> 
<head>

<title>locations of Habitual criminals and Potential offenders</title>

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
	font-size: large;
	font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
	font-weight: bold;
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

<script src="SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<link href="SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css" />


    <meta http-equiv="content-type" content="text/html; charset=utf-8"/>
    
    <script src="http://maps.google.com/maps/api/js?sensor=false"
            type="text/javascript"></script>
    <script type="text/javascript">
  

    var customIcons = {
      criminal: {
        icon: 'http://labs.google.com/ridefinder/images/mm_20_blue.png',
        shadow: 'http://labs.google.com/ridefinder/images/mm_20_shadow.png'
      },
      offender: {
        icon: 'http://labs.google.com/ridefinder/images/mm_20_red.png',
        shadow: 'http://labs.google.com/ridefinder/images/mm_20_shadow.png'
      }
    };
     
   

    function load() {
      var map = new google.maps.Map(document.getElementById("map"), {
        center: new google.maps.LatLng(-20.1666591, 57.503457),
        zoom: 11,
        mapTypeId: 'roadmap'
      });
      var infoWindow = new google.maps.InfoWindow;
	  
      downloadUrl("subjectmap-script.php", function(data) {
        var xml = data.responseXML;
        var markers = xml.documentElement.getElementsByTagName("marker");
		
        for (var i = 0; i < markers.length; i++) {
          var subid      = markers[i].getAttribute("subid");
          var subfname = markers[i].getAttribute("subfname");
		  var sublname = markers[i].getAttribute("sublname");
          var subtype    = markers[i].getAttribute("subtype");
          var point      = new google.maps.LatLng(
              parseFloat(markers[i].getAttribute("sublat")),
              parseFloat(markers[i].getAttribute("sublng")));
          var html       = "<b id>" + subid + "</b> <br/>" +  subfname + "</b> <br/>" + sublname + "</b id> <br/>" + subtype ;
          var icon       = customIcons[subtype] || {};
          var marker     = new google.maps.Marker({
            map: map,
            position: point,
            icon: icon.icon,
            
		
		  });
          bindInfoWindow(marker, map, infoWindow, html);
        }
		
      });
    }
	
	

    function bindInfoWindow(marker, map, infoWindow, html) {
      google.maps.event.addListener(marker, 'click', function() {
        infoWindow.setContent(html);
        infoWindow.open(map, marker);
      });
    }
	
	

    function downloadUrl(url, callback) {
      var request = window.ActiveXObject ?
          new ActiveXObject('Microsoft.XMLHTTP') :
          new XMLHttpRequest;

      request.onreadystatechange = function() {
        if (request.readyState == 4) {
          request.onreadystatechange = doNothing;
          callback(request, request.status);
        }
      };

      request.open('GET', url, true);
      request.send(null);
    }

    function doNothing() {}

 
  </script>
  </head>

  <body onLoad="load()">
    <div id="map" style="width: 900px; height: 1000px"></div>
  </body>
</html>
