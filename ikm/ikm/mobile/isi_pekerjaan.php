<?php
error_reporting(0);
include '../services/config.php';
$dbconn = mysqli_connect($dbhost,$dbuser,$dbpass,$dbname)or die('Could not connect: ');

 $sqlx = ("SELECT p.id_pekerjaan,p.pekerjaan FROM m_pekerjaan p ORDER BY p.id_pekerjaan ASC");			
 $myArray = array(); 
 $result = mysqli_query($dbconn,$sqlx);
 while($t = $result->fetch_array(MYSQLI_ASSOC)) {
	$row_array = array();
	$row_array['idpekerjaan']=$t['id_pekerjaan'];$row_array['pekerjaan']=$t['pekerjaan'];
	array_push($myArray,$row_array);
 }
echo json_encode($myArray);
$result->close();
$dbconn->close();
?>  
