<?php
error_reporting(0);
include '../../../services/config.php';
$dbconn = mysqli_connect($dbhost,$dbuser,$dbpass,$dbname)or die('Could not connect: ');

$ketsekolah = "SMP";
$filterkebutuhan = trim($_POST['filterkebutuhan']);

$qrijam = ("SELECT id_mapel,jumlah_jam
FROM m_jam_mapel WHERE bentuk_pendidikan='".$ketsekolah."' AND aktif='Y'");
$dbjumlahjam = mysqli_query($dbconn, $qrijam);
while($s=mysqli_fetch_array($dbjumlahjam)){
	if ($s['id_mapel'] == "200010000"){$jmljamPPKN = $s['jumlah_jam'];}
	if ($s['id_mapel'] == "300110000"){$jmljamBIN = $s['jumlah_jam'];}
	if ($s['id_mapel'] == "300210000"){$jmljamBING = $s['jumlah_jam'];}
	if ($s['id_mapel'] == "401000000"){$jmljamMAT = $s['jumlah_jam'];}
	if ($s['id_mapel'] == "401200000"){$jmljamIPS = $s['jumlah_jam'];}
	if ($s['id_mapel'] == "401100000"){$jmljamIPA = $s['jumlah_jam'];}
	if ($s['id_mapel'] == "600070000"){$jmljamPRAKARYA = $s['jumlah_jam'];}
	if ($s['id_mapel'] == "600011000"){$jmljamSENI = $s['jumlah_jam'];}
	if ($s['id_mapel'] == "500010000"){$jmljamPJOK = $s['jumlah_jam'];}
	if ($s['id_mapel'] == "100011070" OR $s['id_mapel'] == "100012050"){$jmljamPAI = $s['jumlah_jam'];}
	if ($s['id_mapel'] == "802000300"){$jmljamTIK = $s['jumlah_jam'];}
}

$qriBK = ("SELECT id_mapel,jumlah_siswa,minimal_siswa_rombel
FROM m_jam_bk WHERE bentuk_pendidikan='".$ketsekolah."' AND aktif='Y'");
$dbjumlahbk = mysqli_query($dbconn, $qriBK);
while($r=mysqli_fetch_array($dbjumlahbk)){
	if ($r['id_mapel'] == "500050000"){
		$jmlsiswaBK = $r['jumlah_siswa'];
		$jmlminimumRombel = $r['minimal_siswa_rombel'];
	}
}

if ($filterkebutuhan == "semua"){

	$sqlx = ("SELECT DISTINCT p.id_sekolah,p.npsn,
	p.rombel_7,p.rombel_8,p.rombel_9,
	p.nama_sekolah,p.status_sekolah,p.bentuk_pendidikan,
	(p.ptk_l+p.ptk_p) AS JumPtk,
	(p.ptk_guru_l+p.ptk_guru_p) AS JumGuru
	FROM spm_sekolah p 
	WHERE p.bentuk_pendidikan='".$ketsekolah."' GROUP BY p.id_sekolah");

} else if ($filterkebutuhan == "KMB"){

	$sqlx = ("SELECT DISTINCT p.id_sekolah,p.npsn,
	p.rombel_7,p.rombel_8,p.rombel_9,
	p.nama_sekolah,p.status_sekolah,p.bentuk_pendidikan,
	(p.ptk_l+p.ptk_p) AS JumPtk,
	(p.ptk_guru_l+p.ptk_guru_p) AS JumGuru
	FROM spm_sekolah p 
	LEFT JOIN spm_rombel r ON p.id_sekolah=r.id_sekolah
	WHERE p.bentuk_pendidikan='".$ketsekolah."' AND r.kurikulum='Kurikulum SMP Merdeka' AND p.id_sekolah=r.id_sekolah GROUP BY p.id_sekolah");
	
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

	$qrijml = ("SELECT COUNT(IF(r.kurikulum='Kurikulum SMP Merdeka',r.kurikulum,NULL)) AS jumKMB,
				COUNT(IF(r.kurikulum='Kurikulum SMP 2013',r.kurikulum,NULL)) AS jumK13 
				FROM spm_rombel r WHERE r.id_sekolah='".$t['id_sekolah']."'");
	$dbjumlah = mysqli_query($dbconn, $qrijml);$c = mysqli_fetch_assoc($dbjumlah);
	$jumKMB = $c['jumKMB'];$jumK13 = $c['jumK13'];

	$jmlrombel = $t['rombel_7'] + $t['rombel_8'] + $t['rombel_9'] ;

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

		COUNT(IF(id_mapel_diampu='200010000',id,NULL)) AS jumRealPPKN,
		COUNT(IF(id_mapel_diampu='300110000',id,NULL)) AS jumRealBIN,
		COUNT(IF(id_mapel_diampu='300210000',id,NULL)) AS jumRealBING,
		COUNT(IF(id_mapel_diampu='401000000',id,NULL)) AS jumRealMAT,
		COUNT(IF(id_mapel_diampu='401200000',id,NULL)) AS jumRealIPS,
		COUNT(IF(id_mapel_diampu='401100000',id,NULL)) AS jumRealIPA,
		COUNT(IF(id_mapel_diampu='600070000',id,NULL)) AS jumRealPRAKARYA,
		COUNT(IF(id_mapel_diampu='600011000',id,NULL)) AS jumRealSENI,
		COUNT(IF(id_mapel_diampu='500010000',id,NULL)) AS jumRealPJOK,
		COUNT(IF(id_mapel_diampu='100011070' OR id_mapel_diampu='100012050',id,NULL)) AS jumRealPAI,
		COUNT(IF(id_mapel_diampu='802000300',id,NULL)) AS jumRealTIK,
		COUNT(IF(id_mapel_diampu='500050000',id,NULL)) AS jumRealBK

		FROM spm_ptk WHERE id_sekolah='".$t['id_sekolah']."'");
	$dbjumlahpeg = mysqli_query($dbconn, $qrijmlpeg);$d = mysqli_fetch_assoc($dbjumlahpeg);

	$jumPNS = $d['jumPNS']+$d['jumCPNS']+$d['jumPNSBantu']+$d['jumPNSDepag'];
	$jumPPPK = $d['jumP3K'];
	$jumGTY = $d['jumGTY'];
	$jumHonorer = $d['jumHonor']+$d['jumGuruHonor']+$d['jumTenagaHonor']+$d['jumHonorDaerah']+$d['jumLainnya']+$d['jumNONPNS']+$d['jumPengganti'];

	//// jumlah real guru mapel ////
	$jumRealPPKN =  $d['jumRealPPKN'];
	$jumRealBIN =  $d['jumRealBIN'];
	$jumRealBING =  $d['jumRealBING'];
	$jumRealMAT =  $d['jumRealMAT'];
	$jumRealIPS =  $d['jumRealIPS'];
	$jumRealIPA =  $d['jumRealIPA'];
	$jumRealPRAKARYA =  $d['jumRealPRAKARYA'];
	$jumRealSENI =  $d['jumRealSENI'];
	$jumRealPJOK =  $d['jumRealPJOK'];
	$jumRealPAI =  $d['jumRealPAI'];
	$jumRealTIK =  $d['jumRealTIK'];
	$jumRealBK =  $d['jumRealBK'];
	$jumTotalReal = $d['jumRealPPKN']+$d['jumRealBIN']+$d['jumRealBING']+$d['jumRealMAT']+$d['jumRealIPS']+$d['jumRealIPA']+$d['jumRealPRAKARYA']+$d['jumRealSENI']+$d['jumRealPJOK']+$d['jumRealPAI']+$d['jumRealTIK']+$d['jumRealBK'];
	//// ideal kebutuhan guru ////
	$jumguruPPKNideal =($jmlrombel * $jmljamPPKN)/24;
	$jumguruBINideal =($jmlrombel * $jmljamBIN)/24;
	$jumguruBINGideal = ($jmlrombel * $jmljamBING)/24;
	$jumguruMATideal = ($jmlrombel * $jmljamMAT)/24;
	$jumguruIPSideal = ($jmlrombel * $jmljamIPS)/24;
	$jumguruIPAideal = ($jmlrombel * $jmljamIPA)/24;
	
	$jumguruPrakaryaideal = ($jmlrombel * $jmljamPRAKARYA)/24;
	$jumguruSeniideal = ($jmlrombel * $jmljamSENI)/24;
	$jumguruPJOKideal = ($jmlrombel * $jmljamPJOK)/24;
	$jumguruPAIideal = ($jmlrombel * $jmljamPAI)/24;
	$jumguruTIKideal = ($jmlrombel * $jmljamTIK)/24;

	$jumguruBKideal = ($jmlrombel * $jmlminimumRombel)/$jmlsiswaBK;

	$jumguruTOTALideal = round($jumguruPPKNideal) + round($jumguruBINideal) + round($jumguruBINGideal) + round($jumguruMATideal)
		 + round($jumguruIPSideal) + round($jumguruIPAideal) + round($jumguruPrakaryaideal) + round($jumguruSeniideal)
		 + round($jumguruPJOKideal) + round($jumguruPAIideal) + round($jumguruTIKideal) + round($jumguruBKideal);
	
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
	$row_array['rombel7']=$t['rombel_7'];
	$row_array['rombel8']=$t['rombel_8'];
	$row_array['rombel9']=$t['rombel_9'];

	$row_array['jumKMB']=$jumKMB;
	$row_array['jumK13']=$jumK13;

	$row_array['jumPNS']=$jumPNS;
	$row_array['jumPPPK']=$jumPPPK;
	$row_array['jumGTY']=$jumGTY;
	$row_array['jumHonorer']=$jumHonorer;

	$row_array['jumguruPPKNideal']=round($jumguruPPKNideal); //number_format($jumguruPPKNideal);
	$row_array['jumguruBINideal']=round($jumguruBINideal);
	$row_array['jumguruBINGideal']=round($jumguruBINGideal);
	$row_array['jumguruMATideal']=round($jumguruMATideal);
	$row_array['jumguruIPSideal']=round($jumguruIPSideal);
	$row_array['jumguruIPAideal']=round($jumguruIPAideal);
	$row_array['jumguruPrakaryaideal']=round($jumguruPrakaryaideal);
	$row_array['jumguruSeniideal']=round($jumguruSeniideal);
	$row_array['jumguruPJOKideal']=round($jumguruPJOKideal);
	$row_array['jumguruPAIideal']=round($jumguruPAIideal);
	$row_array['jumguruTIKideal']=round($jumguruTIKideal);
	$row_array['jumguruBKideal']=round($jumguruBKideal);

	$row_array['jumRealPPKN']=round($jumRealPPKN); 
	$row_array['jumRealBIN']=round($jumRealBIN);
	$row_array['jumRealBING']=round($jumRealBING);
	$row_array['jumRealMAT']=round($jumRealMAT);
	$row_array['jumRealIPS']=round($jumRealIPS);
	$row_array['jumRealIPA']=round($jumRealIPA);
	$row_array['jumRealPRAKARYA']=round($jumRealPRAKARYA);
	$row_array['jumRealSENI']=round($jumRealSENI);
	$row_array['jumRealPJOK']=round($jumRealPJOK);
	$row_array['jumRealPAI']=round($jumRealPAI);
	$row_array['jumRealTIK']=round($jumRealTIK);
	$row_array['jumRealBK']=round($jumRealBK);

	$row_array['jumTotalReal']=round($jumTotalReal);
	$row_array['jumguruTOTALideal']=round($jumguruTOTALideal);

	$row_array['kurangguru']=round($kurangguru);
	array_push($data,$row_array);

}
echo json_encode($data);
$result->close();$dbjumlah->close();$dbjumlahjam->close();
$dbconn->close();
