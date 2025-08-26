<?php
error_reporting(0);
require_once '../../../services/config.php';
$dbconn = mysqli_connect($dbhost,$dbuser,$dbpass,$dbname)or die('Could not connect: ');

include '../../../services/config-datamart.php';
$kodekabupaten= "052400";

$qri="TRUNCATE TABLE spm_pembelajaran";	
$resqri=mysqli_query($dbconn,$qri);

$sqldtmart = $pdo->prepare("SELECT q.sekolah_id,p.pembelajaran_id,p.rombongan_belajar_id,p.mata_pelajaran_id,p.nama_mata_pelajaran,
p.ptk_id,p.nama_ptk,p.jam_mengajar_per_minggu,p.status_di_kurikulum,p.ket_stat_di_kurikulum,p.nama_mata_pelajaran_lokal,p.soft_delete
FROM datamart.sekolah q 
LEFT JOIN datamart.pembelajaran p ON p.sekolah_id=q.sekolah_id
WHERE q.kode_kabupaten='052400' AND p.sekolah_id=q.sekolah_id");   

$sqldtmart->execute();
$no=0;
while($t=$sqldtmart->fetch(PDO::FETCH_ASSOC)){
    $no++;
	$sql2  = "INSERT INTO spm_pembelajaran (id_sekolah,id_pembelajaran,id_rombel,id_mapel,nama_mapel,id_ptk,nama_ptk,jam_mengajar,
				  status_kurikulum,ket_status_kurikulum,nama_mapel_lokal,soft_delete) 
                  VALUES ('".$t['sekolah_id']."','".$t['pembelajaran_id']."','".$t['rombongan_belajar_id']."','".$t['mata_pelajaran_id']."','".$t['nama_mata_pelajaran']."','".$t['ptk_id']."','".$t['nama_ptk']."'
                  ,'".$t['jam_mengajar_per_minggu']."','".$t['status_di_kurikulum']."','".$t['ket_stat_di_kurikulum']."'
                  ,'".$t['nama_mata_pelajaran_lokal']."','".$t['soft_delete']."')";
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
