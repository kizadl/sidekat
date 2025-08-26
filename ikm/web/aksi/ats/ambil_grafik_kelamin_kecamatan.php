<?php
error_reporting(0);
include '../../../services/config.php';
$dbconn = mysqli_connect($dbhost,$dbuser,$dbpass,$dbname)or die('Could not connect: '); 
$idkecamatan= trim($_POST['idkecamatan']);

$data = array();
$sqlcount = ("SELECT COUNT(IF(jenis_kelamin='L',0,null)) AS jumL,
		COUNT(IF(jenis_kelamin='P',0,null)) AS jumP FROM tbl_ats WHERE kd_kecamatan='".$idkecamatan."'");
$resultcount = mysqli_query($dbconn, $sqlcount);
$s = mysqli_fetch_assoc($resultcount);
$row_array = array();
$row_array['jumL'] = $s['jumL'];
$row_array['jumP'] = $s['jumP'];
array_push($data, $row_array);

echo json_encode($data);
$dbconn->close();
