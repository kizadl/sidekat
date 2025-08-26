<?php
//error_reporting(0);
require_once '../../../services/config.php';
$dbconn = mysqli_connect($dbhost,$dbuser,$dbpass,$dbname)or die('Could not connect: ');

$data = array();
$sqlX = ("SELECT COUNT(id_ptk) AS jumPTK FROM spm_ptk");			
$resultx = mysqli_query($dbconn,$sqlX);$r= mysqli_fetch_assoc($resultx);
$jumPTK = number_format($r['jumPTK'],0,".",",");

$row_array = array();
$row_array['jumPTK']=$jumPTK;

array_push($data,$row_array);
echo json_encode($data);

$resultx->close();
mysqli_close($dbconn);
?>