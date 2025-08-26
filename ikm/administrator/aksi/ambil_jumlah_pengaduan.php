<?php
error_reporting(0);
require_once '../../services/config.php';
$dbconn = mysqli_connect($dbhost,$dbuser,$dbpass,$dbname)or die('Could not connect: ');

$sqlX = ("SELECT COUNT(id_pengaduan) AS jumpengaduan FROM pengaduan WHERE stts_pengaduan='belum'");			
$resultx = mysqli_query($dbconn,$sqlX);$r= mysqli_fetch_assoc($resultx);
$jumpengaduan = number_format($r['jumpengaduan'],0,".",",");
echo $jumpengaduan;

mysqli_close($dbconn);
?>