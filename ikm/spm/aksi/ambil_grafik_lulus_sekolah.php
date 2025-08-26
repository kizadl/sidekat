<?php
error_reporting(0);
include '../../services/config.php';
$dbconn = mysqli_connect($dbhost,$dbuser,$dbpass,$dbname)or die('Could not connect: '); 

$data = array();

	$sqlcount = ("SELECT SUM(IF(bentuk_pendidikan='SD',jumlah_lulus,0)) AS jumSD,
	SUM(IF(bentuk_pendidikan='SMP',jumlah_lulus,0)) AS jumSMP FROM spm_sekolah");
	$resultcount = mysqli_query($dbconn,$sqlcount);$s= mysqli_fetch_assoc($resultcount);

	$row_array = array();
	$row_array['jumSD']= $s['jumSD'];$row_array['jumSMP']= $s['jumSMP'];
	array_push($data,$row_array);

echo json_encode($data);
$resultcount->close();
$dbconn->close();
?>  
