<?php


session_start();
$staffname= $_SESSION['username'];

echo "$staffname";
require 'db.php';

$remarks = $_GET['remarks'];
$lat = $_GET['lat'];
$lng = $_GET['lng'];
$subject = $_GET['subject'];
$id = $_GET['criminal'];
$fname = $_GET['fname'];
$addressfound = $_GET['addressfound'];
$date = $_GET['date'];
$time = $_GET['time'];


        $insert=0;
	
	
	
 if ($subject == "criminalrecord")
 { 
 
$mysql_insert_value = sprintf("INSERT INTO criminalrecord (id, remarks, addressfound, date, time, lat, lng, criminalid, staffname) 
                               VALUES (NULL, '$remarks', '$addressfound', '$date', '$time', '$lat', '$lng', '$id', '$staffname')");
       
if( mysql_query($mysql_insert_value))
    {
		
          $insert=1;  
         echo "sucessful insertion!"; 
	 }
	 
 }
if ($subject == "offenderrecord")
{

$mysql_insert_value = sprintf("INSERT INTO offenderrecord (id, remarks, addressfound, date, time, lat, lng, offenderid, staffname)
                              VALUES (NULL, '$remarks', '$addressfound', '$date', '$time', '$lat', '$lng', '$id', '$staffname')");
        
 if( mysql_query($mysql_insert_value))
    {
        $insert=1;
		echo "sucessful insertion!";
    }

 }
 ?>
