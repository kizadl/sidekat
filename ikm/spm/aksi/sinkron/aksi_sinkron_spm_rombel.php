<?php
error_reporting(0);
require_once '../../../services/config.php';
$dbconn = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname) or die('Could not connect: ');

$kodekabupaten = "052400"; //trim($_POST['kabupaten']);

$qri = "TRUNCATE TABLE spm_sekolah";
$resqri = mysqli_query($dbconn, $qri);

$sqlx = ("SELECT id_sekolah,npsn,nama_sekolah,bentuk_pendidikan,status_sekolah,akreditasi,
ptk_l,ptk_p,ptk_guru_l,ptk_guru_p,
rombel_kb,rombel_sps,rombel_tpa,rombel_kelompok_A,rombel_kelompok_B,
rombel_keaksaraan,rombel_multi_keaksaraan,rombel_usaha_mandiri,rombel_life_skill,rombel_paket_gaya,rombel_tbm,
rombel_1,rombel_2,rombel_3,rombel_4,rombel_5,rombel_6,rombel_7,rombel_8,rombel_9,rombel_10,rombel_11,rombel_12,rombel_13,
umur_5,umur_6,umur_7,umur_8,umur_9,umur_10,umur_11,umur_12,umur_13,umur_14,umur_15,umur_16,umur_17,umur_18,
id_desa,desa,id_kecamatan,kecamatan FROM import_spm_sekolah");

$resultx = mysqli_query($dbconn, $sqlx);
$no = 0;
while ($t = mysqli_fetch_array($resultx)) {
    $no++;

    $jumlahlulus = 0;
    $jumlahputus = 0;

    $sql2  = "INSERT INTO spm_sekolah (id_sekolah,npsn,nama_sekolah,bentuk_pendidikan,status_sekolah,akreditasi,
                  ptk_l,ptk_p,ptk_guru_l,ptk_guru_p,
                  rombel_kb,rombel_sps,rombel_tpa,rombel_kelompok_A,rombel_kelompok_B,
				  rombel_keaksaraan,rombel_multi_keaksaraan,rombel_usaha_mandiri,rombel_life_skill,rombel_paket_gaya,rombel_tbm,
                  rombel_1,rombel_2,rombel_3,rombel_4,rombel_5,rombel_6,rombel_7,rombel_8,rombel_9,rombel_10,rombel_11,rombel_12,rombel_13,jumlah_putus_sekolah,jumlah_lulus,
                  umur_5,umur_6,umur_7,umur_8,umur_9,umur_10,umur_11,umur_12,umur_13,umur_14,umur_15,umur_16,umur_17,umur_18,
                  id_desa,desa,id_kecamatan,kecamatan) 
                  VALUES ('" . $t['id_sekolah'] . "','" . $t['npsn'] . "','" . $t['nama_sekolah'] . "','" . $t['bentuk_pendidikan'] . "','" . $t['status_sekolah'] . "','" . $t['akreditasi'] . "'
                  ,'" . $t['ptk_l'] . "','" . $t['ptk_p'] . "','" . $t['ptk_guru_l'] . "','" . $t['ptk_guru_p'] . "'
                  ,'" . $t['rombel_kb'] . "','" . $t['rombel_sps'] . "','" . $t['rombel_tpa'] . "','" . $t['rombel_kelompok_A'] . "'
                  ,'" . $t['rombel_kelompok_B'] . "','" . $t['rombel_keaksaraan'] . "','" . $t['rombel_multi_keaksaraan'] . "'
                  ,'" . $t['rombel_usaha_mandiri'] . "','" . $t['rombel_life_skill'] . "','" . $t['rombel_paket_gaya'] . "','" . $t['rombel_tbm'] . "'
                  ,'" . $t['rombel_1'] . "','" . $t['rombel_2'] . "',
                  '" . $t['rombel_3'] . "','" . $t['rombel_4'] . "','" . $t['rombel_5'] . "','" . $t['rombel_6'] . "',
                  '" . $t['rombel_7'] . "','" . $t['rombel_8'] . "','" . $t['rombel_9'] . "','" . $t['rombel_10'] . "',   
                  '" . $t['rombel_11'] . "','" . $t['rombel_12'] . "','" . $t['rombel_13'] . "','$jumlahputus','$jumlahlulus',

                  '" . $t['umur_5'] . "','" . $t['umur_6'] . "','" . $t['umur_7'] . "','" . $t['umur_8'] . "','" . $t['umur_9'] . "',
                  '" . $t['umur_10'] . "','" . $t['umur_11'] . "','" . $t['umur_12'] . "','" . $t['umur_13'] . "','" . $t['umur_14'] . "',
                  '" . $t['umur_15'] . "','" . $t['umur_16'] . "','" . $t['umur_17'] . "','" . $t['umur_18'] . "',

                  '" . $t['id_desa'] . "','" . $t['desa'] . "','" . $t['id_kecamatan'] . "','" . $t['kecamatan'] . "')";
    $res = mysqli_query($dbconn, $sql2);
    $jmlrecord = $no;
}

if ($res) {
    $status = 'OK';
} else {
    $status = 'ERR';
}

$data = array('msg1' => $jmlrecord, 'msg2' => $status);
echo json_encode($data);

//mysqli_free_result($res);
mysqli_close($dbconn);
