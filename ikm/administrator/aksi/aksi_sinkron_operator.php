<?php
error_reporting(0);
include '../../services/config.php';
$dbconn = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname) or die('Could not connect: ');

$sqlx = ("SELECT DISTINCT id,id_sekolah,npsn,nama FROM tbl_api_dispendik GROUP BY id ASC");
$result = mysqli_query($dbconn, $sqlx);
$idne = 0;
while ($t = mysqli_fetch_array($result)) {
	$idnya = $t['id'];
	$idsekolah = $t['id_sekolah'];
	$npsn = $t['npsn'];
	$nama = $t['nama'];
	$password = md5("operator");
	$idne++;

	$sqlXmax = ("SELECT id_sekolah FROM m_operator WHERE id_sekolah='".$t['id_sekolah']."' AND akses='operator'");
        $resultxmax = mysqli_query($dbconn, $sqlXmax);
        $jumlah = mysqli_num_rows ($resultxmax);

		if($jumlah >= 1){
			$sql2  = "UPDATE m_operator SET nm_operator='$nama',username='$npsn',id_instansi='$idnya' WHERE id_sekolah='" . $idsekolah . "'";
			$res = mysqli_query($dbconn, $sql2);
		} else if($jumlah <= 0){
			$sql2  = "INSERT INTO m_operator (nm_operator,username,password,akses,id_instansi,id_sekolah) 
	                 VALUES ('" . $nama . "','" . $npsn . "','".$password."','operator','" . $idnya . "','" . $idsekolah . "')";
			$res = mysqli_query($dbconn, $sql2);
		}

	if ($res) {
		$errMsg = "SUKSESS !!! Data sudah disimpan !!!";
		$status = 'ok';
	} else {
		$errMsg = "GAGAL !!! Data tidak bisa disimpan !!!";
		$status = 'err';
	}
}
$data = array('msg1' => $errMsg, 'msg2' => $status);
echo json_encode($data);

mysqli_free_result($res);
mysqli_close($dbconn);
