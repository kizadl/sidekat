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

$sqlx = ("SELECT DISTINCT id_desa,desa FROM spm_sekolah WHERE id_kecamatan='".$idkecamatan."' GROUP BY id_desa");
$result = mysqli_query($dbconn,$sqlx);
$data = array();
while($t=mysqli_fetch_array($result)){
	$row_array = array();
	$row_array['iddesa']=$t['id_desa'];
	$row_array['nmdesa']=ucwords(strtolower($t['desa']));
	array_push($data,$row_array);
}
echo json_encode($data);
$result->close();
$dbconn->close();
 ?>