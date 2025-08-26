<?php
error_reporting(0);
include '../../../services/config.php';
$dbconn = mysqli_connect($dbhost,$dbuser,$dbpass,$dbname)or die('Could not connect: ');

$idsekolah = trim($_POST['idsekolah']);

$sqlx = ("SELECT id_ptk,nama_ptk,jenis_ptk,status_kepegawaian,status_guru,id_mapel_diampu,mapel_diampu
	FROM spm_ptk
	WHERE id_sekolah='".$idsekolah."' ORDER BY jenis_ptk ASC");

$result = mysqli_query($dbconn,$sqlx);
$data = array();
$no=0;
while($t=mysqli_fetch_array($result)){
	$no++;
	$idptk = $t['id_ptk'];$mdidptk = md5($t['id_ptk']);
	$namaptk = $t['nama_ptk'];
	$jenisptk = $t['jenis_ptk'];
	$statuskepegawaian = $t['status_kepegawaian'];
	$statusguru = $t['status_guru'];

	if ($statusguru == "Y"){
		$idmapel = $t['id_mapel_diampu'];
		$namamapel = $t['mapel_diampu'];
	} else if ($statusguru == "N"){
		$idmapel = "-";
		$namamapel = "-";
	}

	$row_array = array();
	$row_array['no']=$no;
	$row_array['idptk']=$idptk;$row_array['mdidptk']=$mdidptk;
	$row_array['idmapel']=$idmapel;
	$row_array['namamapel']=$namamapel;
	$row_array['namaptk']=$namaptk;
	$row_array['jenisptk']=$jenisptk;
	$row_array['statuskepegawaian']=$statuskepegawaian;
	$row_array['statusguru']=$statusguru;

	array_push($data,$row_array);
}
echo json_encode($data);
$result->close();
$dbconn->close();
?>  
