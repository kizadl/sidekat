<?php
error_reporting(0);
require_once '../../../services/config.php';
$dbconn = mysqli_connect($dbhost,$dbuser,$dbpass,$dbname)or die('Could not connect: ');

$sqlx = ("SELECT DISTINCT id_ptk,id_sekolah,nama_ptk,jk,id_status_kepegawaian,status_kepegawaian,id_jenis_ptk,jenis_ptk,jenis_sertifikasi,riwayat_pendidikan_formal_bidang_studi,riwayat_pendidikan_formal_gelar_akademik FROM import_spm_ptk");

$resultx = mysqli_query($dbconn, $sqlx);
$no = 0;
while ($t = mysqli_fetch_array($resultx)) {
    $no++;
    ///////////////////////////////////////////////////////////
    //// dicari dulu jika tidak ada insert jika ada update ////
    ///////////////////////////////////////////////////////////
    $sqlcr = ("SELECT DISTINCT COUNT(id_ptk) AS jumKetemu FROM spm_ptk WHERE id_ptk = '" . $t['id_ptk'] . "'");
    $resultcr = mysqli_query($dbconn, $sqlcr);
    $b = mysqli_fetch_assoc($resultcr);

    if ($b['jumKetemu'] <= 0) {
	    $sql2  = "INSERT INTO spm_ptk (id_ptk,id_sekolah,nama_ptk,jk,id_status_kepegawaian,status_kepegawaian,id_jenis_ptk,jenis_ptk,jenis_sertifikasi,riwayat_pendidikan_formal_bidang_studi,riwayat_pendidikan_formal_gelar_akademik) 
                  VALUES ('".$t['id_ptk']."','".$t['id_sekolah']."','".$t['nama_ptk']."','".$t['jk']."','".$t['id_status_kepegawaian']."',
                  '".$t['status_kepegawaian']."','".$t['id_jenis_ptk']."','".$t['jenis_ptk']."','".$t['jenis_sertifikasi']."','".$t['riwayat_pendidikan_formal_bidang_studi']."','".$t['riwayat_pendidikan_formal_gelar_akademik']."')";
                  $res=mysqli_query($dbconn,$sql2);
    } else if ($b['jumKetemu'] >= 1) {
	    $sql2  = "UPDATE spm_ptk SET id_sekolah='".$t['id_sekolah']."',nama_ptk='".$t['nama_ptk']."',jk='".$t['jk']."',
                id_status_kepegawaian='".$t['id_status_kepegawaian']."',status_kepegawaian='".$t['status_kepegawaian']."',id_jenis_ptk='".$t['id_jenis_ptk']."',jenis_ptk='".$t['jenis_ptk']."',
                jenis_sertifikasi='".$t['jenis_sertifikasi']."',riwayat_pendidikan_formal_bidang_studi='".$t['riwayat_pendidikan_formal_bidang_studi']."',
                riwayat_pendidikan_formal_gelar_akademik='".$t['riwayat_pendidikan_formal_gelar_akademik']."' WHERE id_ptk='".$t['id_ptk']."'";
                  $res=mysqli_query($dbconn,$sql2);
    }

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
