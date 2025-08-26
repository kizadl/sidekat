<?php
error_reporting(0);
include '../../services/config.php';
$dbconn = mysqli_connect($dbhost,$dbuser,$dbpass,$dbname)or die('Could not connect: '); 
function anti_injection($data){
	global $dbconn;
	$filter = mysqli_real_escape_string($dbconn,stripslashes(strip_tags(htmlspecialchars($data,ENT_QUOTES))));
	return $filter;
  }
$idkecamatan= anti_injection(trim($_POST['idkecamatan']));

$sqlx = ("SELECT DISTINCT (a.bentuk_pendidikan) AS nmbentuksekolah
		FROM spm_sekolah a");
 $result = mysqli_query($dbconn,$sqlx);
 
 $data = array();
 $totaldetail =0;
 while($t=mysqli_fetch_array($result)){
	
	$sqlcount = ("SELECT COUNT(IF(p.jenis_sertifikasi IS NOT NULL OR p.jenis_sertifikasi <> '',p.id,NULL)) as jumDetSekolah 
	FROM spm_ptk p LEFT JOIN spm_sekolah q ON p.id_sekolah=q.id_sekolah
	WHERE q.bentuk_pendidikan = '".$t['nmbentuksekolah']."' AND q.id_kecamatan = '".$idkecamatan."'");
	$resultcount = mysqli_query($dbconn,$sqlcount);$s= mysqli_fetch_assoc($resultcount);
	$totaldetail = $totaldetail + $s['jumDetSekolah'];

	$row_array = array();
	$row_array['nmbentuksekolah']=$t['nmbentuksekolah'];
	$row_array['jumDetSekolah']=$s['jumDetSekolah'];	
	$row_array['totaldetail']=$totaldetail;
	array_push($data,$row_array);
}

echo json_encode($data);

$result->close();
$resultcount->close();
$dbconn->close();
 ?>