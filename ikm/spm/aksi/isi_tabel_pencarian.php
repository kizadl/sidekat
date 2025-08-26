<?php
error_reporting(0);
include '../../services/config.php';
$dbconn = mysqli_connect($dbhost,$dbuser,$dbpass,$dbname)or die('Could not connect: '); 
$kata= trim($_POST['kata']);

$sqlx = ("SELECT id_sekolah,nama_sekolah,npsn,status_sekolah,bentuk_pendidikan
FROM spm_sekolah
WHERE nama_sekolah like '%".$kata."%' OR npsn like '%".$kata."%' OR status_sekolah like '%".$kata."%' OR bentuk_pendidikan like '%".$kata."%'");			
$result = mysqli_query($dbconn,$sqlx);
$data = array();
$no=0;
while($sm=mysqli_fetch_array($result)){
	$no++;

	if (substr($sm['nama_sekolah'],0,53) == "UNIT PELAKSANA TEKNIS DAERAH (UPTD) SATUAN PENDIDIKAN"){
		$nmsekolah = substr($sm['nama_sekolah'],54);
	} else {
		$nmsekolah = $sm['nama_sekolah'];
	}

	$idsekolah = $sm['id_sekolah'];
    $npsn = $sm['npsn'];$bentukpendidikan = $sm['bentuk_pendidikan'];
	$statussekolah = strtoupper($sm['status_sekolah']);
	
	$row_array = array();
	$row_array['no']=$no;
	$row_array['idsekolah']=$idsekolah;
	$row_array['nmsekolah']=$nmsekolah;
	$row_array['npsn']=$npsn;
	$row_array['bentukpendidikan']=$bentukpendidikan;
	$row_array['statussekolah']=$statussekolah;

	array_push($data,$row_array);
}
echo json_encode($data);
$result->close();
$dbconn->close();
?>  
