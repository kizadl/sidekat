<?php
error_reporting(0);
require_once '../../../services/config.php';
$dbconn = mysqli_connect($dbhost,$dbuser,$dbpass,$dbname)or die('Could not connect: ');

include '../../../services/config-datamart.php';
$kodekabupaten= "052400";

$qri="TRUNCATE TABLE spm_ptk_mapel";	
$resqri=mysqli_query($dbconn,$qri);


$sqldtmart = $pdo->prepare("SELECT DISTINCT p.ptk_id,p.sekolah_id,p.nama,p.jenis_kelamin,p.status_kepegawaian_id,
p.status_kepegawaian,p.jenis_ptk_id,p.jenis_ptk,
r.mata_pelajaran_id,r.nama_mata_pelajaran
FROM datamart.sekolah q 
LEFT JOIN datamart.ptk p ON p.sekolah_id=q.sekolah_id
LEFT JOIN datamart.pembelajaran r ON p.ptk_id=r.ptk_id
WHERE q.kode_kabupaten='052400' AND p.sekolah_id=q.sekolah_id AND p.ptk_id=r.ptk_id");   

$sqldtmart->execute();
$no=0;
while($t=$sqldtmart->fetch(PDO::FETCH_ASSOC)){
    $no++;
    //jumlah record 32864
	$sql2  = "INSERT INTO spm_ptk_mapel (id_ptk,id_sekolah,nama_ptk,jk,id_status_kepegawaian,status_kepegawaian,id_jenis_ptk,jenis_ptk,id_mapel,nama_mapel) 
                  VALUES ('".$t['ptk_id']."','".$t['sekolah_id']."','".$t['nama']."','".$t['jenis_kelamin']."','".$t['status_kepegawaian_id']."',
                  '".$t['status_kepegawaian']."','".$t['jenis_ptk_id']."','".$t['jenis_ptk']."','".$t['mata_pelajaran_id']."','".$t['nama_mata_pelajaran']."')";
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
