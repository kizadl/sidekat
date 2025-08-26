<?php
error_reporting(0);
include '../../services/config.php';
$dbconn = mysqli_connect($dbhost,$dbuser,$dbpass,$dbname)or die('Could not connect: ');
include "../../services/tgl_indo.php";

$filterinfo = trim($_POST['filterinfo']);
$idsekolah = trim($_POST['idsekolah']);

if ($filterinfo == "semua"){
	$sqlx = ("SELECT id_kegiatan,judul,headline,isi_kegiatan,hari,tanggal,jam FROM kegiatan_sekolah
	WHERE id_sekolah = '".$idsekolah."' AND aktif='Y' ORDER BY headline='Y',id_kegiatan DESC");
} else if ($filterinfo == "Y"){
	$sqlx = ("SELECT id_kegiatan,judul,headline,isi_kegiatan,hari,tanggal,jam FROM kegiatan_sekolah
	WHERE id_sekolah = '".$idsekolah."' AND aktif='Y' ORDER BY headline='Y',id_kegiatan DESC");
} else if ($filterinfo == "N"){
	$sqlx = ("SELECT id_kegiatan,judul,headline,isi_kegiatan,hari,tanggal,jam FROM kegiatan_sekolah
	WHERE id_sekolah = '".$idsekolah."' AND aktif='N' ORDER BY headline='Y',id_kegiatan DESC");
}

$result = mysqli_query($dbconn,$sqlx);
$data = array();
$no=0;
while($t=mysqli_fetch_array($result)){
	$no++;	 	

	$isikegiatan = strip_tags($t['isi_kegiatan']); 
	$isi = substr($isikegiatan,0,300); 
	$row_array = array();
	$row_array['no']=$no;
	$row_array['idkegiatan']=$t['id_kegiatan'];
	$row_array['judul']=ucwords(strtolower($t['judul']));
	$row_array['headline']=$t['headline'];
	$row_array['hari']=$t['hari'];
	$row_array['tanggal']=tgl_indo($t['tanggal']);
	$row_array['jam']=$t['jam'];
	$row_array['isikegiatan']=$isi;
	array_push($data,$row_array);
}
echo json_encode($data);
$result->close();
$dbconn->close();
?>  
