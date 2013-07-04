<?php
require("db.php");

function parseToXML($htmlStr) 
{ 
$xmlStr=str_replace('<','&lt;',$htmlStr);  
$xmlStr=str_replace('>','&gt;',$xmlStr); 
$xmlStr=str_replace('"','&quot;',$xmlStr); 
$xmlStr=str_replace("'",'&#39;',$xmlStr); 
$xmlStr=str_replace("&",'&amp;',$xmlStr); 
return $xmlStr; 
} 

$query5 = mysql_query ("DELETE FROM subject");
 
$query = mysql_query ("SELECT criminalid, fname, lname, lat, lng,'criminal'  FROM criminal");

while ($row = mysql_fetch_array($query))
{

$insert = mysql_query("insert into subject (subid,subfname,sublname,sublat,sublng,subtype)
                       values ('$row[0]','$row[1]','$row[2]','$row[3]','$row[4]','$row[5]') ");

}


$query1 = mysql_query ("SELECT offenderid, fname, lname, lat, lng, 'offender' FROM offender");

while ($row1 = mysql_fetch_array($query1))
{


$insert1 = mysql_query("insert into subject (subid,subfname,sublname,sublat,sublng,subtype) 
                        values ('$row1[0]','$row1[1]','$row1[2]','$row1[3]','$row1[4]','$row1[5]') ");

}


$query2 = mysql_query ("SELECT subid,subfname,sublname,sublat,sublng,subtype FROM subject");



header("Content-type: text/xml");
echo '<markers>';


while ($row2 = @mysql_fetch_assoc($query2)){
	
	
  // ADD TO XML DOCUMENT NODE
  echo '<marker ';
  echo 'subid="' .      parseToXML($row2['subid']) . '" ';
  echo 'subfname="' . parseToXML($row2['subfname']) . '" ';
  echo 'sublname="' . parseToXML($row2['sublname']) . '" ';
  echo 'sublat="' .                $row2['sublat'] . '" ';
  echo 'sublng="' .                $row2['sublng'] . '" ';
  echo 'subtype="' .               $row2['subtype'] . '" ';
 

  echo '/>';
}

// End XML file
echo '</markers>';



?>
