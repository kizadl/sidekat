<?php
error_reporting(0);
include '../../services/config.php';
$dbconn = mysqli_connect($dbhost,$dbuser,$dbpass,$dbname)or die('Could not connect: '); 
include "../../services/tgl_indo.php";

$sqlx = ("SELECT p.id_pengumuman,p.judul,p.aktif,p.isi_pengumuman,p.hari,p.tanggal,p.jam,p.dibaca FROM pengumuman p WHERE aktif='Y' ORDER BY p.id_pengumuman DESC");			
$result = mysqli_query($dbconn,$sqlx);
$data = array();
$no=0;
while($t=mysqli_fetch_array($result)){
	$no++;	 	

	$isipengumuman = strip_tags($t['isi_pengumuman']); 
	$isi = substr($isipengumuman,0,150); 
	$isi = substr($isipengumuman,0,strrpos($isi," ")); 

	$row_array = array();
	$row_array['no']=$no;
	$row_array['idpengumuman']=$t['id_pengumuman'];
	$row_array['judul']=ucwords(strtolower($t['judul']));
	$row_array['hari']=$t['hari'];
	$row_array['tanggal']=tgl_indo($t['tanggal']);
	$row_array['jam']=$t['jam'];
	$row_array['isipengumuman']=$isi;	
	array_push($data,$row_array);
}
echo json_encode($data);
$result->close();
$dbconn->close();
?>  
