<?php
error_reporting(0);
require_once '../../../services/config.php';
$dbconn = mysqli_connect($dbhost,$dbuser,$dbpass,$dbname)or die('Could not connect: ');
$idkomentar=trim($_POST['idkomentar']);
	
$qri="DELETE FROM komentar WHERE id_komentar='".$idkomentar."'";	
$res=mysqli_query($dbconn,$qri);

$qri2="DELETE FROM komentar WHERE id_balas='".$idkomentar."'";	
$res=mysqli_query($dbconn,$qri2);

if($res){
	$errMsg .="SUKSES ! Selamat, data sudah dihapus.";
}else{
	$errMsg .="GAGAL ! Data tidak terhapus !<br>Error time limit.";
}	
echo json_encode($errMsg);
mysqli_free_result($res);
mysqli_close($dbconn);	
?>
