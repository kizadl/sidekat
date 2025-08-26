<?php
error_reporting(0);
require_once '../../../services/config.php';
$dbconn = mysqli_connect($dbhost,$dbuser,$dbpass,$dbname)or die('Could not connect: ');

$kodekabupaten= "052400";

$qri="TRUNCATE TABLE spm_pembelajaran";	
$resqri=mysqli_query($dbconn,$qri);

$sqlx = ("SELECT id_sekolah,id_pembelajaran,id_rombel,id_mapel,nama_mapel,id_ptk,nama_ptk,jam_mengajar,
status_kurikulum,ket_status_kurikulum,nama_mapel_lokal,soft_delete FROM import_spm_pembelajaran");
		
$resultx = mysqli_query($dbconn,$sqlx);
$no=0;
while($t=mysqli_fetch_array($resultx)){	
    $no++;
	$sql2  = "INSERT INTO spm_pembelajaran (id_sekolah,id_pembelajaran,id_rombel,id_mapel,nama_mapel,id_ptk,nama_ptk,jam_mengajar,
				  status_kurikulum,ket_status_kurikulum,nama_mapel_lokal,soft_delete) 
                  VALUES ('".$t['id_sekolah']."','".$t['id_pembelajaran']."','".$t['id_rombel']."','".$t['id_mapel']."','".$t['nama_mapel']."','".$t['id_ptk']."','".$t['nama_ptk']."'
                  ,'".$t['jam_mengajar']."','".$t['status_kurikulum']."','".$t['ket_status_kurikulum']."'
                  ,'".$t['nama_mapel_lokal']."','".$t['soft_delete']."')";
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
