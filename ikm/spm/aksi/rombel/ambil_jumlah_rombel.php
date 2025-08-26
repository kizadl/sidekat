<?php
error_reporting(0);
require_once '../../../services/config.php';
$dbconn = mysqli_connect($dbhost,$dbuser,$dbpass,$dbname)or die('Could not connect: ');

$data = array();
$sqlX = ("SELECT COUNT(IF(bentuk_pendidikan='SD',npsn,NULL)) AS jumSD, COUNT(IF(bentuk_pendidikan='SMP',npsn,NULL)) AS jumSMP FROM spm_sekolah");			
$resultx = mysqli_query($dbconn,$sqlX);$r= mysqli_fetch_assoc($resultx);
$jmlSD = number_format($r['jumSD'],0,".",",");
$jmlSMP = number_format($r['jumSMP'],0,".",",");

$row_array = array();
$row_array['jumSD']=$jmlSD;
$row_array['jmlSMP']=$jmlSMP;

array_push($data,$row_array);
echo json_encode($data);

$resultx->close();
mysqli_close($dbconn);
?>