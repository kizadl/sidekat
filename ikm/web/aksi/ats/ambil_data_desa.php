<?php
error_reporting(0);
include '../../../services/config.php';
$dbconn = mysqli_connect($dbhost,$dbuser,$dbpass,$dbname)or die('Could not connect: ');
$idkecamatan= trim($_POST['idkecamatan']);

$sqlx = ("SELECT DISTINCT desa FROM tbl_ats WHERE kd_kecamatan='".$idkecamatan."' GROUP BY desa");
$result = mysqli_query($dbconn,$sqlx);
$data = array();
while($t=mysqli_fetch_array($result)){
	$row_array = array();
	$row_array['nmdesa']=ucwords(strtolower($t['desa']));
	array_push($data,$row_array);
}
echo json_encode($data);
$result->close();
$dbconn->close();
 ?>