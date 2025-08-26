<?php
error_reporting(0);
include '../../services/config.php';
$dbconn = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname) or die('Could not connect: ');

$sqlx = ("SELECT id_sekolah,nm_cp,alamat_cp,telepon_cp,telepon_kepsek,email_cp FROM m_operator_1612 WHERE nm_cp IS NOT NULL");
$result = mysqli_query($dbconn, $sqlx);
while ($t = mysqli_fetch_array($result)) {
	$idsekolah = $t['id_sekolah'];
	$nmcp = $t['nm_cp'];
	$alamatcp = $t['alamat_cp'];
	$teleponcp = $t['telepon_cp'];
	$teleponkepsek = $t['telepon_kepsek'];
	$emailcp = $t['email_cp'];

	$sql2  = "UPDATE m_operator SET nm_cp='$nmcp',alamat_cp='$alamatcp',telepon_cp='$teleponcp',telepon_kepsek='$teleponkepsek',email_cp='$emailcp' WHERE id_sekolah='" . $idsekolah . "'";
	$res = mysqli_query($dbconn, $sql2);

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
