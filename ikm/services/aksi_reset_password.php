<?php
error_reporting(0);
include 'config.php';
$dbconn = mysqli_connect($dbhost,$dbuser,$dbpass,$dbname)or die('Could not connect: ');

$idoperator = trim($_POST['idoperator']);$passlama = trim($_POST['passlama']);
$passbaru = trim($_POST['passbaru']);

$mdpasswordlama = md5($passlama);
$mdpasswordbaru = md5($passbaru);

$sql = ("SELECT p.password FROM m_operator p WHERE p.id_operator='".$idoperator."'");		
$resultx = mysqli_query($dbconn,$sql);
$jumlah = mysqli_num_rows($resultx);

$myArray = array();
if($jumlah>0){
 while($t = $resultx->fetch_array(MYSQLI_ASSOC)) {
	if ($mdpasswordlama == $t['password']){
		$ketpassword = "Y";

		$sql3  = "UPDATE m_operator SET password='$mdpasswordbaru' WHERE id_operator='".$idoperator."'";
			$res=mysqli_query($dbconn,$sql3);
			
	} else if ($mdpasswordlama != $t['password']) {
		$ketpassword = "N";
	}

	$row_array = array();
	$row_array['ketpassword']=$ketpassword;
	$row_array['pmi']=$t['pmi'];
	$row_array['jumlah']=$jumlah;
    array_push($myArray,$row_array);
 }
} else {
	$row_array = array();
	$row_array['ketpassword']="";$row_array['pmi']="";
	$row_array['jumlah']=$jumlah;
    array_push($myArray,$row_array);
}

echo json_encode($myArray);
$resultx->close();
$dbconn->close();
?>