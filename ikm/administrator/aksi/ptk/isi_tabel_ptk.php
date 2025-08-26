<?php
error_reporting(0);
include '../../../services/config.php';
$dbconn = mysqli_connect($dbhost,$dbuser,$dbpass,$dbname)or die('Could not connect: ');

$filtersekolah = trim($_POST['filtersekolah']);

if ($filtersekolah == "semua"){

	$sqlx = ("SELECT DISTINCT p.id_sekolah,p.npsn,
	p.nama_sekolah,p.status_sekolah,p.bentuk_pendidikan,
	(p.ptk_l+p.ptk_p) AS JumPtk,
	(p.ptk_guru_l+p.ptk_guru_p) AS JumGuru
	FROM spm_sekolah p 
	GROUP BY p.id_sekolah ORDER BY p.bentuk_pendidikan ASC");

} else {

	$sqlx = ("SELECT DISTINCT p.id_sekolah,p.npsn,
	p.nama_sekolah,p.status_sekolah,p.bentuk_pendidikan,
	(p.ptk_l+p.ptk_p) AS JumPtk,
	(p.ptk_guru_l+p.ptk_guru_p) AS JumGuru
	FROM spm_sekolah p 
	WHERE p.bentuk_pendidikan ='".$filtersekolah."' GROUP BY p.id_sekolah ORDER BY p.bentuk_pendidikan ASC");
	
} 

$result = mysqli_query($dbconn,$sqlx);
$data = array();
$no=0;
while($t=mysqli_fetch_array($result)){
	$no++;

	if (substr($t['nama_sekolah'],0,53) == "UNIT PELAKSANA TEKNIS DAERAH (UPTD) SATUAN PENDIDIKAN"){
		$nmsekolah = substr($t['nama_sekolah'],54);
	} else {
		$nmsekolah = $t['nama_sekolah'];
	}

	////////////////// status kepegawaian ////////////////////
	$qrijmlpeg = ("SELECT COUNT(IF(status_kepegawaian='PNS',id,NULL)) AS jumPNS,
		COUNT(IF(status_kepegawaian='CPNS',id,NULL)) AS jumCPNS,
		COUNT(IF(status_kepegawaian='PNS Diperbantukan',id,NULL)) AS jumPNSBantu,
		COUNT(IF(status_kepegawaian='PNS Depag',id,NULL)) AS jumPNSDepag,
		COUNT(IF(status_kepegawaian='PPPK',id,NULL)) AS jumP3K,
		COUNT(IF(status_kepegawaian='GTY/PTY',id,NULL)) AS jumGTY,
		COUNT(IF(status_kepegawaian='Honor Daerah TK.II Kab/Kota',id,NULL)) AS jumHonor,
		COUNT(IF(status_kepegawaian='Guru Honor Sekolah',id,NULL)) AS jumGuruHonor,
		COUNT(IF(status_kepegawaian='Tenaga Honor Sekolah',id,NULL)) AS jumTenagaHonor,
		COUNT(IF(status_kepegawaian='Honor Daerah TK.I Provinsi',id,NULL)) AS jumHonorDaerah,
		COUNT(IF(status_kepegawaian='Lainnya',id,NULL)) AS jumLainnya,
		COUNT(IF(status_kepegawaian='NON PNS',id,NULL)) AS jumNONPNS,
		COUNT(IF(status_kepegawaian='Guru Pengganti',id,NULL)) AS jumPengganti
		FROM spm_ptk WHERE id_sekolah='".$t['id_sekolah']."'");
	$dbjumlahpeg = mysqli_query($dbconn, $qrijmlpeg);$d = mysqli_fetch_assoc($dbjumlahpeg);

	$jumPNS = $d['jumPNS']+$d['jumCPNS']+$d['jumPNSBantu']+$d['jumPNSDepag'];
	$jumPPPK = $d['jumP3K'];
	$jumGTY = $d['jumGTY'];
	$jumHonorer = $d['jumHonor']+$d['jumGuruHonor']+$d['jumTenagaHonor']+$d['jumHonorDaerah']+$d['jumLainnya']+$d['jumNONPNS']+$d['jumPengganti'];

	$row_array = array();
	$row_array['no']=$no;
	$row_array['idsekolah']=$t['id_sekolah'];
	$row_array['npsn']=$t['npsn'];
	$row_array['sttssekolah']=$t['status_sekolah'];
	$row_array['nmsekolah']=$nmsekolah;

	$row_array['JumPTT']=$t['JumPtk']-$t['JumGuru'];
	$row_array['JumGuru']=$t['JumGuru'];

	$row_array['jumPNS']=$jumPNS;
	$row_array['jumPPPK']=$jumPPPK;
	$row_array['jumGTY']=$jumGTY;
	$row_array['jumHonorer']=$jumHonorer;

	array_push($data,$row_array);
}
echo json_encode($data);
$result->close();$dbjumlahpeg->close();
$dbconn->close();
