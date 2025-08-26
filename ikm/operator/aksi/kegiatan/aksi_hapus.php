<?php
error_reporting(0);
require_once '../../../services/config.php';
$dbconn = mysqli_connect($dbhost,$dbuser,$dbpass,$dbname)or die('Could not connect: ');
$idkegiatan=trim($_POST['idkegiatan']);

$sql4  = "UPDATE kegiatan_sekolah SET aktif='N',headline='N' WHERE id_kegiatan='".$idkegiatan."'";
$res=mysqli_query($dbconn,$sql4);	

if($res){
	$errMsg ="Selamat, proses menghapus surat sukses.";
}else{
	$errMsg ="GAGAL ! Data tidak terhapus !<br>Error time limit.";
}	
echo json_encode($errMsg);
mysqli_free_result($res);
mysqli_close($dbconn);	
?>
