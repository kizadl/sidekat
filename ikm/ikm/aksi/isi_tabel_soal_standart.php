<?php
error_reporting(0);
include '../../services/config.php';
$dbconn = mysqli_connect($dbhost,$dbuser,$dbpass,$dbname)or die('Could not connect: '); 

$sqlx = ("SELECT id_soal,soal,tidak_puas,kurang_puas,puas,sangat_puas FROM ikm_soal_standart ORDER BY id_soal ASC");			
$result = mysqli_query($dbconn,$sqlx);
$data = array();
$no=0;
while($t=mysqli_fetch_array($result)){
	$no++;	 	
	$row_array = array();
	$row_array['no']=$no;
	$row_array['idsoal']=$t['id_soal'];$row_array['soal']=$t['soal'];
	$row_array['TP']=strtoupper($t['tidak_puas']);$row_array['KP']=strtoupper($t['kurang_puas']);
	$row_array['P']=strtoupper($t['puas']);$row_array['SP']=strtoupper($t['sangat_puas']);
	array_push($data,$row_array);
}
echo json_encode($data);
$result->close();
$dbconn->close();
?>  
