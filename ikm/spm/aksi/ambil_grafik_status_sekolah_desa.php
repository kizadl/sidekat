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
$sqlx = ("SELECT DISTINCT (bentuk_pendidikan) AS nmbentuksekolah FROM spm_sekolah WHERE id_desa='".$iddesa."'");
		
$resultx = mysqli_query($dbconn,$sqlx);
$data = array();
while($t=mysqli_fetch_array($resultx)){		

	$sqlcount = ("SELECT COUNT(IF(status_sekolah='SWASTA',0,null)) AS jumSwasta,
		COUNT(IF(status_sekolah='NEGERI',0,null)) AS jumNegeri FROM spm_sekolah WHERE bentuk_pendidikan = '".$t['nmbentuksekolah']."' AND id_desa='".$iddesa."'");
	$resultcount = mysqli_query($dbconn,$sqlcount);$s= mysqli_fetch_assoc($resultcount);

	$row_array = array();
	$row_array['nmbentuksekolah']=$t['nmbentuksekolah'];
	$row_array['jumSwasta']= $s['jumSwasta'];$row_array['jumNegeri']= $s['jumNegeri'];
	array_push($data,$row_array);
}
echo json_encode($data);
$resultx->close();
$dbconn->close();
?>  
