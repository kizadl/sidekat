<?php
error_reporting(0);
include '../../../services/config.php';
$dbconn = mysqli_connect($dbhost,$dbuser,$dbpass,$dbname)or die('Could not connect: ');

$ketsekolah = trim($_POST['ketsekolah']);
$idsekolah = trim($_POST['idsekolah']);

	$sqlx = ("SELECT p.id_mapel,p.nama_mapel,
	p.nama_ptk,p.jam_mengajar,p.ket_status_kurikulum,
	r.tingkat_pendidikan
	FROM spm_pembelajaran p 
	LEFT JOIN spm_rombel r ON p.id_rombel=r.id_rombel
	WHERE p.id_sekolah='".$idsekolah."'");

$result = mysqli_query($dbconn,$sqlx);
$data = array();
$no=0;
while($t=mysqli_fetch_array($result)){
	$no++;

	$idmapel = $t['id_mapel'];
	$namamapel = $t['nama_mapel'];
	$namaptk = $t['nama_ptk'];
	$jammengajar = $t['jam_mengajar'];
	$ketstatuskurikulum = $t['ket_status_kurikulum'];
	$tingkatpendidikan = $t['tingkat_pendidikan'];

	$row_array = array();
	$row_array['no']=$no;
	$row_array['idmapel']=$idmapel;
	$row_array['namamapel']=$namamapel;
	$row_array['namaptk']=$namaptk;
	$row_array['jammengajar']=$jammengajar;
	$row_array['ketstatuskurikulum']=$ketstatuskurikulum;
	$row_array['tingkatpendidikan']=$tingkatpendidikan;

	array_push($data,$row_array);
}
echo json_encode($data);
$result->close();
$dbconn->close();
?>  
