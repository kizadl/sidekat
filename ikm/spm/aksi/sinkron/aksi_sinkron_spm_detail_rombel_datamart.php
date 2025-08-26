<?php
error_reporting(0);
require_once '../../../services/config.php';
$dbconn = mysqli_connect($dbhost,$dbuser,$dbpass,$dbname)or die('Could not connect: ');

include '../../../services/config-datamart.php';
$kodekabupaten= "052400";

$qri="TRUNCATE TABLE spm_rombel";	
$resqri=mysqli_query($dbconn,$qri);

$sqldtmart = $pdo->prepare("SELECT p.sekolah_id,
q.rombongan_belajar_id,q.tingkat_pendidikan_id,q.tingkat_pendidikan,q.kurikulum_id,q.kurikulum,q.jenis_rombel,q.jenis_rombel_keterangan,q.sks,q.jumlah_pembelajaran,q.jumlah_anggota_rombel
FROM datamart.sekolah p 
LEFT JOIN datamart.rombongan_belajar q ON p.sekolah_id=q.sekolah_id
WHERE p.kode_kabupaten='052400' AND p.sekolah_id IS NOT NULL AND p.npsn IS NOT NULL");   

$sqldtmart->execute();
$no=0;
while($t=$sqldtmart->fetch(PDO::FETCH_ASSOC)){
    $no++;
	$sql2  = "INSERT INTO spm_rombel (id_sekolah,id_rombel,tingkat_pendidikan_id,tingkat_pendidikan,kurikulum_id,kurikulum,jenis_rombel,jenis_rombel_keterangan,
				  sks,jumlah_pembelajaran,jumlah_anggota_rombel) 
                  VALUES ('".$t['sekolah_id']."','".$t['rombongan_belajar_id']."','".$t['tingkat_pendidikan_id']."','".$t['tingkat_pendidikan']."','".$t['kurikulum_id']."','".$t['kurikulum']."','".$t['jenis_rombel']."'
                  ,'".$t['jenis_rombel_keterangan']."','".$t['sks']."','".$t['jumlah_pembelajaran']."'
                  ,'".$t['jumlah_anggota_rombel']."')";
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
