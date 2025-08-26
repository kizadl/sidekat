<?php
error_reporting(0);
include '../../services/config.php';
$dbconn = mysqli_connect($dbhost,$dbuser,$dbpass,$dbname)or die('Could not connect: '); 
include "../../services/tgl_indo.php";

$sqlx = ("SELECT p.id_podcast,p.judul,p.aktif,p.isi_podcast,p.hari,p.tanggal,p.jam FROM podcast p WHERE aktif='Y' ORDER BY p.id_podcast DESC");			
$result = mysqli_query($dbconn,$sqlx);
$data = array();
$no=0;
while($t=mysqli_fetch_array($result)){
	$no++;	 	

	$isipodcast = strip_tags($t['isi_podcast']); 
	$isi = substr($isipodcast,0,150); 
	$isi = substr($isipodcast,0,strrpos($isi," ")); 

	$row_array = array();
	$row_array['no']=$no;
	$row_array['idpodcast']=$t['id_podcast'];
	$row_array['judul']=$t['judul'];
	$row_array['hari']=$t['hari'];
	$row_array['tanggal']=tgl_indo($t['tanggal']);
	$row_array['jam']=$t['jam'];
	$row_array['isipodcast']=$isi;	
	array_push($data,$row_array);
}
echo json_encode($data);
$result->close();
$dbconn->close();
?>  
