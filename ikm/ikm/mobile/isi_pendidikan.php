<?php
error_reporting(0);
include '../services/config.php';
$dbconn = mysqli_connect($dbhost,$dbuser,$dbpass,$dbname)or die('Could not connect: ');

 $sqlx = ("SELECT p.id_pendidikan,p.pendidikan FROM m_pendidikan p ORDER BY p.id_pendidikan ASC");			
 $myArray = array(); 
 $result = mysqli_query($dbconn,$sqlx);
 while($t = $result->fetch_array(MYSQLI_ASSOC)) {
	$row_array = array();
	$row_array['idpendidikan']=$t['id_pendidikan'];$row_array['pendidikan']=$t['pendidikan'];
	array_push($myArray,$row_array);
 }
echo json_encode($myArray);
$result->close();
$dbconn->close();
?>  
