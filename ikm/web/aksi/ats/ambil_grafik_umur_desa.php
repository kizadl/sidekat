<?php
error_reporting(0);
include '../../../services/config.php';
$dbconn = mysqli_connect($dbhost,$dbuser,$dbpass,$dbname)or die('Could not connect: '); 
$iddesa= trim($_POST['iddesa']);

$data = array();
$sqlcount = ("SELECT COUNT(IF(umur >= 7 AND umur <= 12,0,null)) AS jum7_12,
		COUNT(IF(umur >= 13 AND umur <= 15,0,null)) AS jum13_15,
		COUNT(IF(umur >= 16 AND umur <= 18,0,null)) AS jum16_18 FROM tbl_ats WHERE desa='".$iddesa."'");
$resultcount = mysqli_query($dbconn, $sqlcount);
$s = mysqli_fetch_assoc($resultcount);
$row_array = array();
$row_array['jum7_12'] = $s['jum7_12'];
$row_array['jum13_15'] = $s['jum13_15'];
$row_array['jum16_18'] = $s['jum16_18'];
array_push($data, $row_array);

echo json_encode($data);
$dbconn->close();
