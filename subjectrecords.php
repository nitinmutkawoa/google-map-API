<?php

session_start();
$staffname=$_SESSION['username'];

require 'db.php';
$id = $_GET['id'];

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><head>
  <head>
    <meta name="viewport" content="initial-scale=1.0, user-scalable=no" />
    <meta http-equiv="content-type" content="text/html; charset=UTF-8"/>
    <title>Insertion of Subject (Habitual criminal & Potential Offender ) on the system</title>
    
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
    
    <script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"></script>
    <script type="text/javascript">
    var marker;
    var infowindow;

    function initialize() {
      var latlng = new google.maps.LatLng(-20.1666591, 57.503457);
      var options = {
        zoom: 15,
        center: latlng,
        mapTypeId: google.maps.MapTypeId.ROADMAP
      }
      var map = new google.maps.Map(document.getElementById("map_canvas"), options);
      var html = "<table>" +
	  			 "<tr><td>Subject ID:</td> <td><input type='text' value='<?php echo $id;?>' id='criminal'/></td> </tr>" +
				 "<tr><td>Staff Name:</td> <td><input type='text' value='<?php echo $staffname;?>' id='staffname'/></td> </tr>" +
                 "<tr><td>Remarks(Hint: Dress,cap,activity,etc.. ):</td> <td><input type='text' id='remarks'/></td> </tr>" +
				 "<tr><td>Address Found (known to you):</td> <td><input type='text' id='addressfound'/></td> </tr>" +
				 "<tr><td>Date Found (yyyy:mm:dd Ex. 2013:06:28):</td> <td><input type='text' id='date'/></td> </tr>" +
				 "<tr><td>Time Found(hr:mm:ss Ex. 21:32:10 / 21:32):</td> <td><input type='text' id='time'/></td> </tr>" +
                 "<tr><td>You may choose another Subject:</td> <td><select id='subject'>" +
                 "<option value='criminalrecord' SELECTED>criminalrecord</option>" +
                 "<option value='offenderrecord'>offenderrecord</option>" +
                 "</select> </td></tr>" +
                 "<tr><td></td><td><input type='button' value='Save & Close' onclick='saveData()'/></td></tr>";
          infowindow = new google.maps.InfoWindow({
          content: html
    });

          google.maps.event.addListener(map, "click", function(event) {
          marker = new google.maps.Marker({
          position: event.latLng,
          map: map
        });
          google.maps.event.addListener(marker, "click", function() {
          infowindow.open(map, marker);
        });
    });
    }

          function saveData() {
      var remarks = escape(document.getElementById("remarks").value);
      var addressfound = escape(document.getElementById("addressfound").value);
	  var date = escape(document.getElementById("date").value);
	  var time = escape(document.getElementById("time").value);
      var subject = document.getElementById("subject").value;
	  var criminal = document.getElementById("criminal").value;
	  var staffname = document.getElementById("staffname").value;
      var latlng = marker.getPosition();

      var url = "subjectrecords-script.php?remarks=" + remarks + "&criminal=" + criminal + "&staffname=" + staffname +
	   "&addressfound=" + addressfound + "&date=" + date + "&time=" + time +
                "&subject=" + subject + "&lat=" + latlng.lat() + "&lng=" + latlng.lng();
         downloadUrl(url, function(data, responseCode) {
        if (responseCode == 200 && data.length <= 1) {
          infowindow.close();
          document.getElementById("message").innerHTML = "Location added.";
        }
      });
    }

    function downloadUrl(url, callback) {
      var request = window.ActiveXObject ?
          new ActiveXObject('Microsoft.XMLHTTP') :
          new XMLHttpRequest;

      request.onreadystatechange = function() {
        if (request.readyState == 4) {
          request.onreadystatechange = doNothing;
          callback(request.responseText, request.status);
        }
      };

      request.open('GET', url, true);
      request.send(null);
    }

    function doNothing() {}
    </script>
  </head>
  <body style="margin:60px; padding:0px;" onload="initialize()">
    <div id="map_canvas" style="width: 900px; height: 1000px">
     

  
      
    </div>
    
  <div id="message"></div>
  <div class="footer">
    <p>&nbsp;</p>
<p>Copyright 2013 - CDTS </p>
  </div>

</body>
</html>
