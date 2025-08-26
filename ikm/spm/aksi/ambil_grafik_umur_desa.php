<?php
error_reporting(0);
include '../../services/config.php';
$dbconn = mysqli_connect($dbhost,$dbuser,$dbpass,$dbname)or die('Could not connect: '); 
$iddesa= trim($_POST['iddesa']);
$data = array();

	$sqlcount = ("SELECT SUM(umur_5) AS umur5,SUM(umur_6) AS umur6,SUM(umur_7) AS umur7,SUM(umur_8) AS umur8,
	SUM(umur_9) AS umur9,SUM(umur_10) AS umur10,SUM(umur_11) AS umur11,SUM(umur_12) AS umur12,SUM(umur_13) AS umur13,
	SUM(umur_14) AS umur14,SUM(umur_15) AS umur15,SUM(umur_16) AS umur16,SUM(umur_17) AS umur17,SUM(umur_18) AS umur18
		FROM spm_sekolah WHERE id_desa='".$iddesa."'");
	$resultcount = mysqli_query($dbconn,$sqlcount);$s= mysqli_fetch_assoc($resultcount);

	$row_array = array();
	$row_array['umur5']= $s['umur5'];$row_array['umur6']= $s['umur6'];
	$row_array['umur7']= $s['umur7'];$row_array['umur8']= $s['umur8'];
	$row_array['umur9']= $s['umur9'];$row_array['umur10']= $s['umur10'];
	$row_array['umur11']= $s['umur11'];$row_array['umur12']= $s['umur12'];
	$row_array['umur13']= $s['umur13'];$row_array['umur14']= $s['umur14'];
	$row_array['umur15']= $s['umur15'];$row_array['umur16']= $s['umur16'];
	$row_array['umur17']= $s['umur17'];$row_array['umur18']= $s['umur18'];
	array_push($data,$row_array);

echo json_encode($data);
$resultcount->close();
$dbconn->close();
?>  
