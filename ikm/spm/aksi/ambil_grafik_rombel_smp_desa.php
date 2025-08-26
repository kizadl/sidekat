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

$sqlx = ("SELECT SUM(p.rombel_7) AS jumRombel7,SUM(p.rombel_8) AS jumRombel8,SUM(p.rombel_9) AS jumRombel9
		FROM spm_sekolah p WHERE p.bentuk_pendidikan='SMP' AND p.id_desa='".$iddesa."'");

$resultx = mysqli_query($dbconn,$sqlx);
$data = array();
while($s=mysqli_fetch_array($resultx)){		

	$row_array = array();
	$row_array['jumRombel7']= $s['jumRombel7'];$row_array['jumRombel8']= $s['jumRombel8'];
	$row_array['jumRombel9']= $s['jumRombel9'];
	array_push($data,$row_array);
}
echo json_encode($data);
$resultx->close();
$dbconn->close();
?>  
