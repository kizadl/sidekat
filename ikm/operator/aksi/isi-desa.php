<?php
error_reporting(0);

$idkecamatan= trim($_POST['idkecamatan']);

include '../../services/config.php';
$dbconn = mysqli_connect($dbhost,$dbuser,$dbpass,$dbname)or die('Could not connect: '); 

$sqlx = ("SELECT DISTINCT id_desa,desa_kelurahan FROM tbl_api_dispendik WHERE id_kecamatan='".$idkecamatan."'");			
$result = mysqli_query($dbconn,$sqlx);

$data = array();
while($t=mysqli_fetch_array($result)){

	$row_array = array();
	$row_array['kddesa']=$t['id_desa'];
    $row_array['nmdesa']=ucwords(strtolower($t['desa_kelurahan']));
	array_push($data,$row_array);
}
echo json_encode($data);

$result->close();
$dbconn->close();
?>  
