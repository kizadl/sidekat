<?php
error_reporting(0);
require_once '../../../services/config.php';
$dbconn = mysqli_connect($dbhost,$dbuser,$dbpass,$dbname)or die('Could not connect: ');

include '../../../services/config-datamart.php';
$kodekabupaten= "052400";//trim($_POST['kabupaten']);

$qri="TRUNCATE TABLE spm_sekolah";	
$resqri=mysqli_query($dbconn,$qri);
/*
$sqldtcountmart = $pdo->prepare("SELECT COUNT(jenis_keluar_id) AS jmllulus FROM [datamart].[peserta_didik] WHERE jenis_keluar = 'Putus Sekolah'");   
$sqldtcountmart->execute();
while($x=$sqldtcountmart->fetch(PDO::FETCH_ASSOC)){
    $jumlahlulus = $x['jmllulus']; 
}
*/
$sqldtmart = $pdo->prepare("SELECT DISTINCT p.sekolah_id,p.npsn,p.nama,p.bentuk_pendidikan,p.status_sekolah,p.akreditasi,
q.rombel_kb,q.rombel_sps,q.rombel_tpa,q.rombel_kelompok_A,q.rombel_kelompok_B,q.rombel_keaksaraan,q.rombel_multi_keaksaraan,q.rombel_usaha_mandiri,q.rombel_life_skill,q.rombel_paket_gaya,q.rombel_tbm,
q.rombel_1,q.rombel_2,q.rombel_3,q.rombel_4,q.rombel_5,q.rombel_6,q.rombel_7,q.rombel_8,q.rombel_9,q.rombel_10,q.rombel_11,q.rombel_12,q.rombel_13,
r.ptk_l,r.ptk_p,r.ptk_guru_l,r.ptk_guru_p,
(s.pd_umur_5_l+s.pd_umur_5_p) AS umur5,
(s.pd_umur_6_l+s.pd_umur_6_p) AS umur6,
(s.pd_umur_7_l+s.pd_umur_7_p) AS umur7,
(s.pd_umur_8_l+s.pd_umur_8_p) AS umur8,
(s.pd_umur_9_l+s.pd_umur_9_p) AS umur9,
(s.pd_umur_10_l+s.pd_umur_10_p) AS umur10,
(s.pd_umur_11_l+s.pd_umur_11_p) AS umur11,
(s.pd_umur_12_l+s.pd_umur_12_p) AS umur12,
(s.pd_umur_13_l+s.pd_umur_13_p) AS umur13,
(s.pd_umur_14_l+s.pd_umur_14_p) AS umur14,
(s.pd_umur_15_l+s.pd_umur_15_p) AS umur15,
(s.pd_umur_16_l+s.pd_umur_16_p) AS umur16,
(s.pd_umur_17_l+s.pd_umur_17_p) AS umur17,
(s.pd_umur_18_l+s.pd_umur_18_p) AS umur18,
p.kode_desa_kelurahan,p.desa_kelurahan,p.kode_kecamatan,p.kecamatan
FROM datamart.sekolah p 
LEFT JOIN datamart.sekolah_rombongan_belajar q ON p.sekolah_id=q.sekolah_id
LEFT JOIN datamart.sekolah_ptk r ON p.sekolah_id=r.sekolah_id
LEFT JOIN datamart.sekolah_peserta_didik s ON p.sekolah_id=s.sekolah_id
WHERE p.kode_kabupaten='052400' AND p.sekolah_id IS NOT NULL AND p.npsn IS NOT NULL");   

$sqldtmart->execute();
$no=0;
while($t=$sqldtmart->fetch(PDO::FETCH_ASSOC)){
    $no++;
    //$jumlahlulus = $t['jmllulus'];

    $sqldtcountmart = $pdo->prepare("SELECT COUNT(jenis_keluar_id) AS jmllulus FROM [datamart].[peserta_didik] WHERE sekolah_id = '".$t['sekolah_id']."' AND jenis_keluar='Lulus'");   
    $sqldtcountmart->execute();
    while($x=$sqldtcountmart->fetch(PDO::FETCH_ASSOC)){
        $jumlahlulus = $x['jmllulus']; 
    }
    $sqldtcountmart2 = $pdo->prepare("SELECT COUNT(jenis_keluar_id) AS jmlputus FROM [datamart].[peserta_didik] WHERE sekolah_id = '".$t['sekolah_id']."' AND jenis_keluar='Putus Sekolah'");   
    $sqldtcountmart2->execute();
    while($x2=$sqldtcountmart2->fetch(PDO::FETCH_ASSOC)){
        $jumlahputus = $x2['jmlputus']; 
    }

	$sql2  = "INSERT INTO spm_sekolah (id_sekolah,npsn,nama_sekolah,bentuk_pendidikan,status_sekolah,akreditasi,
                  ptk_l,ptk_p,ptk_guru_l,ptk_guru_p,
                  rombel_kb,rombel_sps,rombel_tpa,rombel_kelompok_A,rombel_kelompok_B,
				  rombel_keaksaraan,rombel_multi_keaksaraan,rombel_usaha_mandiri,rombel_life_skill,rombel_paket_gaya,rombel_tbm,
                  rombel_1,rombel_2,rombel_3,rombel_4,rombel_5,rombel_6,rombel_7,rombel_8,rombel_9,rombel_10,rombel_11,rombel_12,rombel_13,jumlah_putus_sekolah,jumlah_lulus,
                  umur_5,umur_6,umur_7,umur_8,umur_9,umur_10,umur_11,umur_12,umur_13,umur_14,umur_15,umur_16,umur_17,umur_18,
                  id_desa,desa,id_kecamatan,kecamatan) 
                  VALUES ('".$t['sekolah_id']."','".$t['npsn']."','".$t['nama']."','".$t['bentuk_pendidikan']."','".$t['status_sekolah']."','".$t['akreditasi']."'
                  ,'".$t['ptk_l']."','".$t['ptk_p']."','".$t['ptk_guru_l']."','".$t['ptk_guru_p']."'
                  ,'".$t['rombel_kb']."','".$t['rombel_sps']."','".$t['rombel_tpa']."','".$t['rombel_kelompok_A']."'
                  ,'".$t['rombel_kelompok_B']."','".$t['rombel_keaksaraan']."','".$t['rombel_multi_keaksaraan']."'
                  ,'".$t['rombel_usaha_mandiri']."','".$t['rombel_life_skill']."','".$t['rombel_paket_gaya']."','".$t['rombel_tbm']."'
                  ,'".$t['rombel_1']."','".$t['rombel_2']."',
                  '".$t['rombel_3']."','".$t['rombel_4']."','".$t['rombel_5']."','".$t['rombel_6']."',
                  '".$t['rombel_7']."','".$t['rombel_8']."','".$t['rombel_9']."','".$t['rombel_10']."',   
                  '".$t['rombel_11']."','".$t['rombel_12']."','".$t['rombel_13']."','$jumlahputus','$jumlahlulus',

                  '".$t['umur5']."','".$t['umur6']."','".$t['umur7']."','".$t['umur8']."','".$t['umur9']."',
                  '".$t['umur10']."','".$t['umur11']."','".$t['umur12']."','".$t['umur13']."','".$t['umur14']."',
                  '".$t['umur15']."','".$t['umur16']."','".$t['umur17']."','".$t['umur18']."',

                  '".$t['kode_desa_kelurahan']."','".$t['desa_kelurahan']."','".$t['kode_kecamatan']."','".$t['kecamatan']."')";
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
	
//mysqli_free_result($res);
mysqli_close($dbconn);
?>