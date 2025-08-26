<?php
error_reporting(0);
include '../../services/config.php';
$dbconn = mysqli_connect($dbhost,$dbuser,$dbpass,$dbname)or die('Could not connect: '); 
function anti_injection($data){
	global $dbconn;
	$filter = mysqli_real_escape_string($dbconn,stripslashes(strip_tags(htmlspecialchars($data,ENT_QUOTES))));
	return $filter;
  }
$idkecamatan= anti_injection(trim($_POST['idkecamatan']));

$sqlx = ("SELECT SUM(p.rombel_1) AS jumRombel1,SUM(p.rombel_2) AS jumRombel2,SUM(p.rombel_3) AS jumRombel3,
		SUM(p.rombel_4) AS jumRombel4,SUM(p.rombel_5) AS jumRombel5,SUM(p.rombel_6) AS jumRombel6
		FROM spm_sekolah p WHERE p.bentuk_pendidikan='SD' AND p.id_kecamatan='".$idkecamatan."'");

$resultx = mysqli_query($dbconn,$sqlx);
$data = array();
while($s=mysqli_fetch_array($resultx)){		

	$row_array = array();
	$row_array['jumRombel1']= $s['jumRombel1'];$row_array['jumRombel2']= $s['jumRombel2'];$row_array['jumRombel3']= $s['jumRombel3'];
	$row_array['jumRombel4']= $s['jumRombel4'];$row_array['jumRombel5']= $s['jumRombel5'];$row_array['jumRombel6']= $s['jumRombel6'];
	array_push($data,$row_array);
}
echo json_encode($data);
$resultx->close();
$dbconn->close();
?>  
