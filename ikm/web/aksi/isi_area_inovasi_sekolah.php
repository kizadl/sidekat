<?php
error_reporting(0);
include '../../services/config.php';
$dbconn = mysqli_connect($dbhost,$dbuser,$dbpass,$dbname)or die('Could not connect: '); 

$sqlx = ("SELECT id_inovasi,judul,id_sekolah
FROM inovasi_sekolah WHERE aktif='Y' AND headline='Y' ORDER BY dibaca DESC LIMIT 4");			
$result = mysqli_query($dbconn,$sqlx);
$data = array();
while($t=mysqli_fetch_array($result)){ 	

	$sqldet = ("SELECT nama_sekolah FROM spm_sekolah WHERE id_sekolah ='".$t['id_sekolah']."'");			
	$resultdet = mysqli_query($dbconn,$sqldet);$c = mysqli_fetch_assoc($resultdet);

	$row_array = array();
	$row_array['idinovasi']=$t['id_inovasi'];
	$row_array['nmsekolah']=strtoupper($c['nama_sekolah']);
	$row_array['judul']=$t['judul'];
	array_push($data,$row_array);
}
echo json_encode($data);
$result->close();$resultdet->close();
$dbconn->close();

?>  
