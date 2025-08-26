<?php
error_reporting(0);
include '../../../services/config.php';
$dbconn = mysqli_connect($dbhost,$dbuser,$dbpass,$dbname)or die('Could not connect: ');

$idsekolah = trim($_POST['idsekolah']);

$sqlx = ("SELECT id_ptk,nama_ptk,jenis_ptk,status_kepegawaian,riwayat_pendidikan_formal_bidang_studi,riwayat_pendidikan_formal_gelar_akademik,status_guru,id_mapel_diampu,mapel_diampu
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
	$pendidikanbidstudi = $t['riwayat_pendidikan_formal_bidang_studi'];
	$pendidikangelar = $t['riwayat_pendidikan_formal_gelar_akademik'];

	$sqldet = ("SELECT DISTINCT id_mapel,nama_mapel FROM spm_ptk_mapel WHERE id_ptk='".$idptk."'");
	$resultdet = mysqli_query($dbconn,$sqldet);
	$nongajar = 0;$mengajar = "";
	while($d=mysqli_fetch_array($resultdet)){	
		$nongajar++;
		if ($t['id_mapel_diampu'] == $d['id_mapel']){
			$mengajar = $mengajar.$nongajar.". "."<span class='badge badge-soft-primary'>".$d['nama_mapel']."</span><br/>";
		} else if ($t['id_mapel_diampu'] != $d['id_mapel']){
			$mengajar = "<span class='text-800'>".$mengajar.$nongajar.". ".$d['nama_mapel']."</span><br/>";
		}
	}

	$row_array = array();
	$row_array['no']=$no;
	$row_array['idptk']=$idptk;$row_array['mdidptk']=$mdidptk;
	$row_array['mengajar']=$mengajar;
	$row_array['namaptk']=$namaptk;
	$row_array['jenisptk']=$jenisptk;
	$row_array['statuskepegawaian']=$statuskepegawaian;
	$row_array['statusguru']=$statusguru;
	$row_array['pendidikanbidstudi']=$pendidikanbidstudi;
	$row_array['pendidikangelar']=$pendidikangelar;
	array_push($data,$row_array);
}
echo json_encode($data);
$result->close();
$dbconn->close();
?>  
