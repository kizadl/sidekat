<?php
error_reporting(0);
include '../../services/config.php';
$dbconn = mysqli_connect($dbhost,$dbuser,$dbpass,$dbname)or die('Could not connect: '); 
function anti_injection($data){
	global $dbconn;
	$filter = mysqli_real_escape_string($dbconn,stripslashes(strip_tags(htmlspecialchars($data,ENT_QUOTES))));
	return $filter;
  }
$iddesa= anti_injection(trim($_POST['iddesa']));
$data = array();

	$sqlcount = ("SELECT SUM(IF(bentuk_pendidikan='SD',jumlah_lulus,0)) AS jumSD,
	SUM(IF(bentuk_pendidikan='SMP',jumlah_lulus,0)) AS jumSMP FROM spm_sekolah WHERE id_desa='".$iddesa."'");
	$resultcount = mysqli_query($dbconn,$sqlcount);$s= mysqli_fetch_assoc($resultcount);

	$row_array = array();
	$row_array['jumSD']= $s['jumSD'];$row_array['jumSMP']= $s['jumSMP'];
	array_push($data,$row_array);

echo json_encode($data);
$resultcount->close();
$dbconn->close();
?>  
