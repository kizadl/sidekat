<?php
error_reporting(0);
include '../../services/config.php';
$dbconn = mysqli_connect($dbhost,$dbuser,$dbpass,$dbname)or die('Could not connect: ');

$ketsekolah = "SD";

$qrijam = ("SELECT id_mapel,jumlah_jam
FROM m_jam_mapel WHERE bentuk_pendidikan='".$ketsekolah."' AND aktif='Y'");
$dbjumlahjam = mysqli_query($dbconn, $qrijam);
while($s=mysqli_fetch_array($dbjumlahjam)){
	if ($s['id_mapel'] == "500010000"){$jmljamPJOK = $s['jumlah_jam'];}
	if ($s['id_mapel'] == "100011000" OR $s['id_mapel'] == "100011070"){$jmljamPAI = $s['jumlah_jam'];}
	if ($s['id_mapel'] == "300210000"){$jmljamBING = $s['jumlah_jam'];}
	//if ($s['id_mapel'] != "400200000" OR $s['id_mapel'] != "500010000" OR $s['id_mapel'] != "100011000" OR $s['id_mapel'] != "100011070" OR $s['id_mapel'] != "300210000"){$jmljamLAIN = 4;}
	if ($s['id_mapel'] == "802000300"){$jmljamTIK = $s['jumlah_jam'];}
}

$sqlx = ("SELECT SUM(p.rombel_1) AS jumRombel1,SUM(p.rombel_2) AS jumRombel2,SUM(p.rombel_3) AS jumRombel3,
	SUM(p.rombel_4) AS jumRombel4,SUM(p.rombel_5) AS jumRombel5,SUM(p.rombel_6) AS jumRombel6,
	SUM(p.ptk_guru_l+p.ptk_guru_p) AS JumGuru
	FROM spm_sekolah p 
	WHERE p.bentuk_pendidikan='".$ketsekolah."'");

$result = mysqli_query($dbconn,$sqlx);
$data = array();
while($t=mysqli_fetch_array($result)){

	$qrijml = ("SELECT COUNT(IF(r.kurikulum='Kurikulum SD Merdeka',r.kurikulum,NULL)) AS jumKMB,
				COUNT(IF(r.kurikulum='Kurikulum SD 2013',r.kurikulum,NULL)) AS jumK13 
				FROM spm_rombel r");
	$dbjumlah = mysqli_query($dbconn, $qrijml);$c = mysqli_fetch_assoc($dbjumlah);
	$jumKMB = $c['jumKMB'];$jumK13 = $c['jumK13'];

	$jmlrombel = $t['jumRombel1'] + $t['jumRombel2'] + $t['jumRombel3'] + $t['jumRombel4'] + $t['jumRombel5'] + $t['jumRombel6'];
	
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
	$row_array['JumGuru']=$t['JumGuru'];
	$row_array['jmlrombel']=$jmlrombel;

	$row_array['jumKMB']=$jumKMB;
	$row_array['jumK13']=$jumK13;

	$row_array['jumgurukelasideal']=round($jumgurukelasideal);
	$row_array['jumguruPJOKideal']=round($jumguruPJOKideal);
	$row_array['jumguruPAIideal']=round($jumguruPAIideal);
	$row_array['jumguruBINGideal']=$jumguruBINGideal;//round($jumguruBINGideal);
	$row_array['jumguruTIKideal']=round($jumguruTIKideal);
	$row_array['jumguruTOTALideal']=$jumguruTOTALideal;
	$row_array['kurangguru']=$kurangguru;
	array_push($data,$row_array);
}
echo json_encode($data);
$result->close();$dbjumlah->close();
$dbconn->close();
?>  
