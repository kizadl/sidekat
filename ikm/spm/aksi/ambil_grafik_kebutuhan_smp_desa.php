<?php
error_reporting(0);
include '../../services/config.php';
$dbconn = mysqli_connect($dbhost,$dbuser,$dbpass,$dbname)or die('Could not connect: ');
function anti_injection($data){
	global $dbconn;
	$filter = mysqli_real_escape_string($dbconn,stripslashes(strip_tags(htmlspecialchars($data,ENT_QUOTES))));
	return $filter;
  }
$iddesa= anti_injection(trim($_POST['iddesa']));
$ketsekolah = "SMP";

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
	if ($s['id_mapel'] == "850010100" OR $s['id_mapel'] == "300311900"){$jmljamMULOK = $s['jumlah_jam'];}
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

$sqlx = ("SELECT SUM(p.rombel_7) AS jumRombel7,SUM(p.rombel_8) AS jumRombel8,SUM(p.rombel_9) AS jumRombel9,
	SUM(p.ptk_guru_l+p.ptk_guru_p) AS JumGuru
	FROM spm_sekolah p 
	WHERE p.bentuk_pendidikan='".$ketsekolah."' AND p.id_desa='".$iddesa."'");

$result = mysqli_query($dbconn,$sqlx);
$data = array();
while($t=mysqli_fetch_array($result)){

	$qrijml = ("SELECT COUNT(IF(r.kurikulum='Kurikulum SMP Merdeka',r.kurikulum,NULL)) AS jumKMB,
				COUNT(IF(r.kurikulum='Kurikulum SMP 2013',r.kurikulum,NULL)) AS jumK13 
				FROM spm_rombel r LEFT JOIN spm_sekolah p ON r.id_sekolah=p.id_sekolah
				WHERE p.id_desa='".$iddesa."'");
	$dbjumlah = mysqli_query($dbconn, $qrijml);$c = mysqli_fetch_assoc($dbjumlah);
	$jumKMB = $c['jumKMB'];$jumK13 = $c['jumK13'];

	$jmlrombel = $t['jumRombel7'] + $t['jumRombel8'] + $t['jumRombel9'];
	
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
	$row_array['JumGuru']=$t['JumGuru'];
	$row_array['jmlrombel']=$jmlrombel;

	$row_array['jumKMB']=$jumKMB;
	$row_array['jumK13']=$jumK13;

	$row_array['jumguruPPKNideal']=round($jumguruPPKNideal);
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

	$row_array['jumguruTOTALideal']=round($jumguruTOTALideal);
	$row_array['kurangguru']=round($kurangguru);
	array_push($data,$row_array);
}
echo json_encode($data);
$result->close();$dbjumlah->close();
$dbconn->close();
?>  
