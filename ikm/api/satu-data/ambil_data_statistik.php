<?php
error_reporting(0);
include '../../services/config.php';
$dbconn = mysqli_connect($dbhost,$dbuser,$dbpass,$dbname)or die('Could not connect: '); 

$data = array();
$sqlx = ("SELECT COUNT(id) AS jumSekolah,SUM(guru) AS jumGuru,SUM(siswa) AS jumSiswa FROM tbl_api_dispendik");
$resultx = mysqli_query($dbconn,$sqlx);$row= mysqli_fetch_assoc($resultx);

	$row_array = array();
	$row_array['jumSekolah']=number_format($row['jumSekolah'],0,",",".");
	$row_array['jumGuru']=number_format($row['jumGuru'],0,",",".");
	$row_array['jumSiswa']=number_format($row['jumSiswa'],0,",",".");

	array_push($data,$row_array);

  echo json_encode($data);
  $resultx->close();
  $dbconn->close();
?>