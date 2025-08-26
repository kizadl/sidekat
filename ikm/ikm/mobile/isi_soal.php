<?php
error_reporting(0);
include '../services/config.php';
$dbconn = mysqli_connect($dbhost,$dbuser,$dbpass,$dbname)or die('Could not connect: ');
$idinstansi= trim($_POST['idinstansi']);

 $sqlx = ("SELECT p.id_soal,p.soal,p.tidak_puas,p.kurang_puas,p.puas,p.sangat_puas FROM soal p WHERE p.id_instansi='".$idinstansi."' ORDER BY p.id_unsur ASC");
 $myArray = array(); 
 $result = mysqli_query($dbconn,$sqlx);
 $nourut=0;
 while($t = $result->fetch_array(MYSQLI_ASSOC)) {
	$nourut++;
	$row_array = array();
	$row_array['nourut']=$nourut;
	$row_array['idsoal']=$t['id_soal'];$row_array['soal']=$t['soal'];
	$row_array['tp']=$t['tidak_puas'];$row_array['kp']=$t['kurang_puas'];
	$row_array['p']=$t['puas'];$row_array['sp']=$t['sangat_puas'];
	array_push($myArray,$row_array);
 }
echo json_encode($myArray);
$result->close();
$dbconn->close();
?>  
