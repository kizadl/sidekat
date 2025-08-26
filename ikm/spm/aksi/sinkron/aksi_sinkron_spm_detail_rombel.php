<?php
error_reporting(0);
require_once '../../../services/config.php';
$dbconn = mysqli_connect($dbhost,$dbuser,$dbpass,$dbname)or die('Could not connect: ');

$kodekabupaten= "052400";

$qri="TRUNCATE TABLE spm_rombel";	
$resqri=mysqli_query($dbconn,$qri);

$sqlx = ("SELECT id_sekolah,id_rombel,tingkat_pendidikan_id,tingkat_pendidikan,kurikulum_id,kurikulum,jenis_rombel,jenis_rombel_keterangan,
sks,jumlah_pembelajaran,jumlah_anggota_rombel FROM import_spm_rombel");
		
$resultx = mysqli_query($dbconn,$sqlx);
$no=0;
while($t=mysqli_fetch_array($resultx)){	
    $no++;
	$sql2  = "INSERT INTO spm_rombel (id_sekolah,id_rombel,tingkat_pendidikan_id,tingkat_pendidikan,kurikulum_id,kurikulum,jenis_rombel,jenis_rombel_keterangan,
				  sks,jumlah_pembelajaran,jumlah_anggota_rombel) 
                  VALUES ('".$t['id_sekolah']."','".$t['id_rombel']."','".$t['tingkat_pendidikan_id']."','".$t['tingkat_pendidikan']."','".$t['kurikulum_id']."','".$t['kurikulum']."','".$t['jenis_rombel']."'
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
