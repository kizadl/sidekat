<?php
error_reporting(0);
include '../../../services/config.php';
$dbconn = mysqli_connect($dbhost,$dbuser,$dbpass,$dbname)or die('Could not connect: ');

$ketsekolah = "SD";
$filterkebutuhan = trim($_POST['filterkebutuhan']);

$qrijam = ("SELECT id_mapel,jumlah_jam
FROM m_jam_mapel WHERE bentuk_pendidikan='".$ketsekolah."' AND aktif='Y'");
$dbjumlahjam = mysqli_query($dbconn, $qrijam);
while($s=mysqli_fetch_array($dbjumlahjam)){
	if ($s['id_mapel'] == "500010000"){$jmljamPJOK = $s['jumlah_jam'];}
	if ($s['id_mapel'] == "100011000" OR $s['id_mapel'] == "100011070"){$jmljamPAI = $s['jumlah_jam'];}
	if ($s['id_mapel'] == "300210000"){$jmljamBING = $s['jumlah_jam'];}
	if ($s['id_mapel'] != "400200000" OR $s['id_mapel'] != "500010000" OR $s['id_mapel'] != "100011000" OR $s['id_mapel'] != "100011070" OR $s['id_mapel'] != "300210000"){$jmljamLAIN = 4;}
	if ($s['id_mapel'] == "802000300"){$jmljamTIK = $s['jumlah_jam'];}
}

if ($filterkebutuhan == "semua"){

	$sqlx = ("SELECT DISTINCT p.id_sekolah,p.npsn,
	p.rombel_1,p.rombel_2,p.rombel_3,p.rombel_4,p.rombel_5,p.rombel_6,
	p.nama_sekolah,p.status_sekolah,p.bentuk_pendidikan,
	(p.ptk_l+p.ptk_p) AS JumPtk,
	(p.ptk_guru_l+p.ptk_guru_p) AS JumGuru
	FROM spm_sekolah p 
	WHERE p.bentuk_pendidikan='".$ketsekolah."' GROUP BY p.id_sekolah");

} else if ($filterkebutuhan == "KMB"){

	$sqlx = ("SELECT DISTINCT p.id_sekolah,p.npsn,
	p.rombel_1,p.rombel_2,p.rombel_3,p.rombel_4,p.rombel_5,p.rombel_6,
	p.nama_sekolah,p.status_sekolah,p.bentuk_pendidikan,
	(p.ptk_l+p.ptk_p) AS JumPtk,
	(p.ptk_guru_l+p.ptk_guru_p) AS JumGuru
	FROM spm_sekolah p 
	LEFT JOIN spm_rombel r ON p.id_sekolah=r.id_sekolah
	WHERE p.bentuk_pendidikan='".$ketsekolah."' AND r.kurikulum='Kurikulum SD Merdeka' AND p.id_sekolah=r.id_sekolah GROUP BY p.id_sekolah");
	
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

	$qrijml = ("SELECT COUNT(IF(r.kurikulum='Kurikulum SD Merdeka',r.kurikulum,NULL)) AS jumKMB,
				COUNT(IF(r.kurikulum='Kurikulum SD 2013',r.kurikulum,NULL)) AS jumK13 
				FROM spm_rombel r WHERE r.id_sekolah='".$t['id_sekolah']."'");
	$dbjumlah = mysqli_query($dbconn, $qrijml);$c = mysqli_fetch_assoc($dbjumlah);
	$jumKMB = $c['jumKMB'];$jumK13 = $c['jumK13'];

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
				COUNT(IF(status_kepegawaian='Guru Pengganti',id,NULL)) AS jumPengganti,

				COUNT(IF(id_mapel_diampu='500010000',id,NULL)) AS jumRealPJOK,
				COUNT(IF(id_mapel_diampu='400200000',id,NULL)) AS jumRealGURUKELAS,
				COUNT(IF(id_mapel_diampu='100011000' OR id_mapel_diampu='100011070',id,NULL)) AS jumRealPAI,
				COUNT(IF(id_mapel_diampu='300210000',id,NULL)) AS jumRealBING,
				COUNT(IF(id_mapel_diampu='802000300',id,NULL)) AS jumRealTIK
				
				FROM spm_ptk WHERE id_sekolah='".$t['id_sekolah']."'");
	$dbjumlahpeg = mysqli_query($dbconn, $qrijmlpeg);$d = mysqli_fetch_assoc($dbjumlahpeg);

	$jumPNS = $d['jumPNS']+$d['jumCPNS']+$d['jumPNSBantu']+$d['jumPNSDepag'];
	$jumPPPK = $d['jumP3K'];
	$jumGTY = $d['jumGTY'];
	$jumHonorer = $d['jumHonor']+$d['jumGuruHonor']+$d['jumTenagaHonor']+$d['jumHonorDaerah']+$d['jumLainnya']+$d['jumNONPNS']+$d['jumPengganti'];

	//// jumlah real guru mapel ////
	$jumRealGURUKELAS =  $d['jumRealGURUKELAS'];
	$jumRealPJOK =  $d['jumRealPJOK'];
	$jumRealPAI =  $d['jumRealPAI'];
	$jumRealBING =  $d['jumRealBING'];
	$jumRealTIK =  $d['jumRealTIK'];

	$jumTotalReal = $d['jumRealGURUKELAS']+$d['jumRealPJOK']+$d['jumRealPAI']+$d['jumRealBING']+$d['jumRealTIK'];

	$jmlrombel = $t['rombel_1'] + $t['rombel_2'] + $t['rombel_3'] + $t['rombel_4'] + $t['rombel_5'] + $t['rombel_6'];
	
	//// ideal kebutuhan guru ////
	$jumgurukelasideal = $jumKMB + $jumK13;
	$jumguruPJOKideal = ($jmlrombel * $jmljamPJOK)/24;
	$jumguruPAIideal = ($jmlrombel * $jmljamPAI)/24;
	$jumguruTIKideal = ($jmlrombel * $jmljamTIK)/24;
	$jumguruBINGideal = ($jumKMB * $jmljamBING)/24;
	if ($jumKMB >= 1){
		if ($jumguruBINGideal <= 1){$jumguruBINGideal = 1;} else {$jumguruBINGideal = round($jumguruBINGideal);}
	} else if ($jumKMB <= 0){$jumguruBINGideal = 0;}
	$jumguruTOTALideal = round($jumgurukelasideal) + round($jumguruPJOKideal) + round($jumguruPAIideal) + $jumguruBINGideal + round($jumguruTIKideal);
	
	$kurangguru = $t['JumGuru'] - $jumguruTOTALideal ;

	$row_array = array();
	$row_array['no']=$no;
	$row_array['idsekolah']=$t['id_sekolah'];
	$row_array['npsn']=$t['npsn'];
	$row_array['sttssekolah']=$t['status_sekolah'];
	$row_array['nmsekolah']=$nmsekolah;

	$row_array['JumPTT']=$t['JumPtk']-$t['JumGuru'];
	$row_array['JumGuru']=$t['JumGuru'];

	$row_array['jmlrombel']=$jmlrombel;
	$row_array['rombel1']=$t['rombel_1'];
	$row_array['rombel2']=$t['rombel_2'];
	$row_array['rombel3']=$t['rombel_3'];
	$row_array['rombel4']=$t['rombel_4'];
	$row_array['rombel5']=$t['rombel_5'];
	$row_array['rombel6']=$t['rombel_6'];

	$row_array['jumKMB']=$jumKMB;
	$row_array['jumK13']=$jumK13;

	$row_array['jumPNS']=$jumPNS;
	$row_array['jumPPPK']=$jumPPPK;
	$row_array['jumGTY']=$jumGTY;
	$row_array['jumHonorer']=$jumHonorer;

	$row_array['jumgurukelasideal']=round($jumgurukelasideal);
	$row_array['jumguruPJOKideal']=round($jumguruPJOKideal);
	$row_array['jumguruPAIideal']=round($jumguruPAIideal);
	$row_array['jumguruBINGideal']=$jumguruBINGideal;//round($jumguruBINGideal);
	$row_array['jumguruTIKideal']=round($jumguruTIKideal);
	$row_array['jumguruTOTALideal']=$jumguruTOTALideal;

	$row_array['jumRealGURUKELAS']=round($jumRealGURUKELAS); 
	$row_array['jumRealPJOK']=round($jumRealPJOK);
	$row_array['jumRealPAI']=round($jumRealPAI);
	$row_array['jumRealBING']=round($jumRealBING);
	$row_array['jumRealTIK']=round($jumRealTIK);
	
	$row_array['jumTotalReal']=round($jumTotalReal);

	$row_array['kurangguru']=$kurangguru;
	array_push($data,$row_array);
}
echo json_encode($data);
$result->close();$dbjumlah->close();$dbjumlahpeg->close();
$dbjumlahguru->close();
$dbconn->close();
?>  
