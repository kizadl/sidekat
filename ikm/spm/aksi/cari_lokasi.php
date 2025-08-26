<?php
error_reporting(0);
include '../../services/config.php';
$dbconn = mysqli_connect($dbhost,$dbuser,$dbpass,$dbname)or die('Could not connect: '); 

$kata= trim($_POST['kata']);

$sqlx = ("SELECT nama_sekolah,npsn,status_sekolah,bentuk_pendidikan FROM spm_sekolah WHERE 
nama_sekolah like '%".$kata."%' OR npsn like '%".$kata."%' OR status_sekolah like '%".$kata."%' OR bentuk_pendidikan like '%".$kata."%'");			
$result = mysqli_query($dbconn,$sqlx);
$data = array();
$no=0;
while($t=mysqli_fetch_array($result)){
	$no++;	 	
	$row_array = array();
	$row_array['no']=$no;
	$row_array['nama']=ucwords(strtolower($t['nama_sekolah']));
	array_push($data,$row_array);
}
echo json_encode($data);
$result->close();
$dbconn->close();
?>  
