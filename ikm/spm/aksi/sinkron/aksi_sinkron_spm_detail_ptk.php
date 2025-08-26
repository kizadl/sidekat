<?php
error_reporting(0);
require_once '../../../services/config.php';
$dbconn = mysqli_connect($dbhost,$dbuser,$dbpass,$dbname)or die('Could not connect: ');

$qri="TRUNCATE TABLE spm_ptk_mapel";	
$resqri=mysqli_query($dbconn,$qri);

$sqlx = ("SELECT DISTINCT id_ptk,id_sekolah,nama_ptk,jk,id_status_kepegawaian,status_kepegawaian,id_jenis_ptk,jenis_ptk,id_mapel,nama_mapel FROM import_spm_ptk_mapel");

$resultx = mysqli_query($dbconn, $sqlx);
$no = 0;
while ($t = mysqli_fetch_array($resultx)) {
    $no++;
    //jumlah record 32864
	$sql2  = "INSERT INTO spm_ptk_mapel (id_ptk,id_sekolah,nama_ptk,jk,id_status_kepegawaian,status_kepegawaian,id_jenis_ptk,jenis_ptk,id_mapel,nama_mapel) 
                  VALUES ('".$t['id_ptk']."','".$t['id_sekolah']."','".$t['nama_ptk']."','".$t['jk']."','".$t['id_status_kepegawaian']."',
                  '".$t['status_kepegawaian']."','".$t['id_jenis_ptk']."','".$t['jenis_ptk']."','".$t['id_mapel']."','".$t['nama_mapel']."')";
                  $res=mysqli_query($dbconn,$sql2);
    $jmlrecord = $no;
}

if($res){
    $status = 'OK';
}else{
    $status = 'ERR';
}

$data = array('msg1'=>$jmlrecord,'msg2'=>$status);
echo json_encode($data);
	
mysqli_free_result($res);
mysqli_close($dbconn);
?>  
