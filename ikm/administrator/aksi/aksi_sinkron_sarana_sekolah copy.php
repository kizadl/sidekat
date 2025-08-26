<?php
//error_reporting(0);
require_once '../../services/config.php';
$dbconn = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname) or die('Could not connect: ');

include '../../services/config-datamart.php';

function anti_injection($data)
{
    global $dbconn;
    $filter = mysqli_real_escape_string($dbconn, stripslashes(strip_tags(htmlspecialchars($data, ENT_QUOTES))));
    return $filter;
}

$kodekabupaten = "052400"; //trim($_POST['kabupaten']);
$password = md5("operator");

//$qri="TRUNCATE TABLE tbl_api_dispendik";	
//$resqri=mysqli_query($dbconn,$qri);

$sqldtmart = $pdo->prepare("SELECT DISTINCT p.sekolah_id,p.npsn,p.nama,p.bentuk_pendidikan,
p.alamat_jalan,p.rt,p.rw,p.nama_dusun,p.desa_kelurahan,p.kecamatan,
p.lintang,p.bujur,p.status_sekolah,p.akreditasi,

q.ptk_guru_l,q.ptk_guru_p,

r.pd_tkt_kb_l,r.pd_tkt_kb_p,
r.pd_tkt_sps_l,r.pd_tkt_sps_p,
r.pd_tkt_tpa_l,r.pd_tkt_tpa_p,
r.pd_tkt_kelompok_A_l,r.pd_tkt_kelompok_A_p,
r.pd_tkt_kelompok_B_l,r.pd_tkt_kelompok_B_p,
r.pd_tkt_keaksaraan_l,r.pd_tkt_keaksaraan_p,
r.pd_tkt_multi_keaksaraan_l,r.pd_tkt_multi_keaksaraan_p,
r.pd_tkt_usaha_mandiri_l,r.pd_tkt_usaha_mandiri_p,
r.pd_tkt_life_skill_l,r.pd_tkt_life_skill_p,
r.pd_tkt_paket_gaya_l,r.pd_tkt_paket_gaya_p,
r.pd_tkt_tbm_l,r.pd_tkt_tbm_p,
r.pd_tkt_1_l,r.pd_tkt_1_p,
r.pd_tkt_2_l,r.pd_tkt_2_p,
r.pd_tkt_3_l,r.pd_tkt_3_p,
r.pd_tkt_4_l,r.pd_tkt_4_p,
r.pd_tkt_5_l,r.pd_tkt_5_p,
r.pd_tkt_6_l,r.pd_tkt_6_p,
r.pd_tkt_7_l,r.pd_tkt_7_p,
r.pd_tkt_8_l,r.pd_tkt_8_p,
r.pd_tkt_9_l,r.pd_tkt_9_p,
r.pd_tkt_10_l,r.pd_tkt_10_p,
r.pd_tkt_11_l,r.pd_tkt_11_p,
r.pd_tkt_12_l,r.pd_tkt_12_p,
r.pd_tkt_13_l,r.pd_tkt_13_p,

r.tkt_kb_l_islam,r.tkt_kb_p_islam,
r.tkt_sps_l_islam,r.tkt_sps_p_islam,
r.tkt_tpa_l_islam,r.tkt_tpa_p_islam,
r.tkt_kelompok_A_l_islam,r.tkt_kelompok_A_p_islam,
r.tkt_kelompok_B_l_islam,r.tkt_kelompok_B_p_islam,
r.tkt_keaksaraan_l_islam,r.tkt_keaksaraan_p_islam,
r.tkt_multi_keaksaraan_l_islam,r.tkt_multi_keaksaraan_p_islam,
r.tkt_usaha_mandiri_l_islam,r.tkt_usaha_mandiri_p_islam,
r.tkt_life_skill_l_islam,r.tkt_life_skill_p_islam,
r.tkt_paket_gaya_l_islam,r.tkt_paket_gaya_p_islam,
r.tkt_tbm_l_islam,r.tkt_tbm_p_islam,
r.tkt_1_l_islam,r.tkt_1_p_islam,
r.tkt_2_l_islam,r.tkt_2_p_islam,
r.tkt_3_l_islam,r.tkt_3_p_islam,
r.tkt_4_l_islam,r.tkt_4_p_islam,
r.tkt_5_l_islam,r.tkt_5_p_islam,
r.tkt_6_l_islam,r.tkt_6_p_islam,
r.tkt_7_l_islam,r.tkt_7_p_islam,
r.tkt_8_l_islam,r.tkt_8_p_islam,
r.tkt_9_l_islam,r.tkt_9_p_islam,
r.tkt_10_l_islam,r.tkt_10_p_islam,
r.tkt_11_l_islam,r.tkt_11_p_islam,
r.tkt_12_l_islam,r.tkt_12_p_islam,
r.tkt_13_l_islam,r.tkt_13_p_islam,

r.tkt_kb_l_kristen,r.tkt_kb_p_kristen,
r.tkt_sps_l_kristen,r.tkt_sps_p_kristen,
r.tkt_tpa_l_kristen,r.tkt_tpa_p_kristen,
r.tkt_kelompok_A_l_kristen,r.tkt_kelompok_A_p_kristen,
r.tkt_kelompok_B_l_kristen,r.tkt_kelompok_B_p_kristen,
r.tkt_keaksaraan_l_kristen,r.tkt_keaksaraan_p_kristen,
r.tkt_multi_keaksaraan_l_kristen,r.tkt_multi_keaksaraan_p_kristen,
r.tkt_usaha_mandiri_l_kristen,r.tkt_usaha_mandiri_p_kristen,
r.tkt_life_skill_l_kristen,r.tkt_life_skill_p_kristen,
r.tkt_paket_gaya_l_kristen,r.tkt_paket_gaya_p_kristen,
r.tkt_tbm_l_kristen,r.tkt_tbm_p_kristen,
r.tkt_1_l_kristen,r.tkt_1_p_kristen,
r.tkt_2_l_kristen,r.tkt_2_p_kristen,
r.tkt_3_l_kristen,r.tkt_3_p_kristen,
r.tkt_4_l_kristen,r.tkt_4_p_kristen,
r.tkt_5_l_kristen,r.tkt_5_p_kristen,
r.tkt_6_l_kristen,r.tkt_6_p_kristen,
r.tkt_7_l_kristen,r.tkt_7_p_kristen,
r.tkt_8_l_kristen,r.tkt_8_p_kristen,
r.tkt_9_l_kristen,r.tkt_9_p_kristen,
r.tkt_10_l_kristen,r.tkt_10_p_kristen,
r.tkt_11_l_kristen,r.tkt_11_p_kristen,
r.tkt_12_l_kristen,r.tkt_12_p_kristen,
r.tkt_13_l_kristen,r.tkt_13_p_kristen,

r.tkt_kb_l_katholik,r.tkt_kb_p_katholik,
r.tkt_sps_l_katholik,r.tkt_sps_p_katholik,
r.tkt_tpa_l_katholik,r.tkt_tpa_p_katholik,
r.tkt_kelompok_A_l_katholik,r.tkt_kelompok_A_p_katholik,
r.tkt_kelompok_B_l_katholik,r.tkt_kelompok_B_p_katholik,
r.tkt_keaksaraan_l_katholik,r.tkt_keaksaraan_p_katholik,
r.tkt_multi_keaksaraan_l_katholik,r.tkt_multi_keaksaraan_p_katholik,
r.tkt_usaha_mandiri_l_katholik,r.tkt_usaha_mandiri_p_katholik,
r.tkt_life_skill_l_katholik,r.tkt_life_skill_p_katholik,
r.tkt_paket_gaya_l_katholik,r.tkt_paket_gaya_p_katholik,
r.tkt_tbm_l_katholik,r.tkt_tbm_p_katholik,
r.tkt_1_l_katholik,r.tkt_1_p_katholik,
r.tkt_2_l_katholik,r.tkt_2_p_katholik,
r.tkt_3_l_katholik,r.tkt_3_p_katholik,
r.tkt_4_l_katholik,r.tkt_4_p_katholik,
r.tkt_5_l_katholik,r.tkt_5_p_katholik,
r.tkt_6_l_katholik,r.tkt_6_p_katholik,
r.tkt_7_l_katholik,r.tkt_7_p_katholik,
r.tkt_8_l_katholik,r.tkt_8_p_katholik,
r.tkt_9_l_katholik,r.tkt_9_p_katholik,
r.tkt_10_l_katholik,r.tkt_10_p_katholik,
r.tkt_11_l_katholik,r.tkt_11_p_katholik,
r.tkt_12_l_katholik,r.tkt_12_p_katholik,
r.tkt_13_l_katholik,r.tkt_13_p_katholik,

r.tkt_kb_l_hindu,r.tkt_kb_p_hindu,
r.tkt_sps_l_hindu,r.tkt_sps_p_hindu,
r.tkt_tpa_l_hindu,r.tkt_tpa_p_hindu,
r.tkt_kelompok_A_l_hindu,r.tkt_kelompok_A_p_hindu,
r.tkt_kelompok_B_l_hindu,r.tkt_kelompok_B_p_hindu,
r.tkt_keaksaraan_l_hindu,r.tkt_keaksaraan_p_hindu,
r.tkt_multi_keaksaraan_l_hindu,r.tkt_multi_keaksaraan_p_hindu,
r.tkt_usaha_mandiri_l_hindu,r.tkt_usaha_mandiri_p_hindu,
r.tkt_life_skill_l_hindu,r.tkt_life_skill_p_hindu,
r.tkt_paket_gaya_l_hindu,r.tkt_paket_gaya_p_hindu,
r.tkt_tbm_l_hindu,r.tkt_tbm_p_hindu,
r.tkt_1_l_hindu,r.tkt_1_p_hindu,
r.tkt_2_l_hindu,r.tkt_2_p_hindu,
r.tkt_3_l_hindu,r.tkt_3_p_hindu,
r.tkt_4_l_hindu,r.tkt_4_p_hindu,
r.tkt_5_l_hindu,r.tkt_5_p_hindu,
r.tkt_6_l_hindu,r.tkt_6_p_hindu,
r.tkt_7_l_hindu,r.tkt_7_p_hindu,
r.tkt_8_l_hindu,r.tkt_8_p_hindu,
r.tkt_9_l_hindu,r.tkt_9_p_hindu,
r.tkt_10_l_hindu,r.tkt_10_p_hindu,
r.tkt_11_l_hindu,r.tkt_11_p_hindu,
r.tkt_12_l_hindu,r.tkt_12_p_hindu,
r.tkt_13_l_hindu,r.tkt_13_p_hindu,

r.tkt_kb_l_budha,r.tkt_kb_p_budha,
r.tkt_sps_l_budha,r.tkt_sps_p_budha,
r.tkt_tpa_l_budha,r.tkt_tpa_p_budha,
r.tkt_kelompok_A_l_budha,r.tkt_kelompok_A_p_budha,
r.tkt_kelompok_B_l_budha,r.tkt_kelompok_B_p_budha,
r.tkt_keaksaraan_l_budha,r.tkt_keaksaraan_p_budha,
r.tkt_multi_keaksaraan_l_budha,r.tkt_multi_keaksaraan_p_budha,
r.tkt_usaha_mandiri_l_budha,r.tkt_usaha_mandiri_p_budha,
r.tkt_life_skill_l_budha,r.tkt_life_skill_p_budha,
r.tkt_paket_gaya_l_budha,r.tkt_paket_gaya_p_budha,
r.tkt_tbm_l_budha,r.tkt_tbm_p_budha,
r.tkt_1_l_budha,r.tkt_1_p_budha,
r.tkt_2_l_budha,r.tkt_2_p_budha,
r.tkt_3_l_budha,r.tkt_3_p_budha,
r.tkt_4_l_budha,r.tkt_4_p_budha,
r.tkt_5_l_budha,r.tkt_5_p_budha,
r.tkt_6_l_budha,r.tkt_6_p_budha,
r.tkt_7_l_budha,r.tkt_7_p_budha,
r.tkt_8_l_budha,r.tkt_8_p_budha,
r.tkt_9_l_budha,r.tkt_9_p_budha,
r.tkt_10_l_budha,r.tkt_10_p_budha,
r.tkt_11_l_budha,r.tkt_11_p_budha,
r.tkt_12_l_budha,r.tkt_12_p_budha,
r.tkt_13_l_budha,r.tkt_13_p_budha,

r.tkt_kb_l_kong_hu_chu,r.tkt_kb_p_kong_hu_chu,
r.tkt_sps_l_kong_hu_chu,r.tkt_sps_p_kong_hu_chu,
r.tkt_tpa_l_kong_hu_chu,r.tkt_tpa_p_kong_hu_chu,
r.tkt_kelompok_A_l_kong_hu_chu,r.tkt_kelompok_A_p_kong_hu_chu,
r.tkt_kelompok_B_l_kong_hu_chu,r.tkt_kelompok_B_p_kong_hu_chu,
r.tkt_keaksaraan_l_kong_hu_chu,r.tkt_keaksaraan_p_kong_hu_chu,
r.tkt_multi_keaksaraan_l_kong_hu_chu,r.tkt_multi_keaksaraan_p_kong_hu_chu,
r.tkt_usaha_mandiri_l_kong_hu_chu,r.tkt_usaha_mandiri_p_kong_hu_chu,
r.tkt_life_skill_l_kong_hu_chu,r.tkt_life_skill_p_kong_hu_chu,
r.tkt_paket_gaya_l_kong_hu_chu,r.tkt_paket_gaya_p_kong_hu_chu,
r.tkt_tbm_l_kong_hu_chu,r.tkt_tbm_p_kong_hu_chu,
r.tkt_1_l_kong_hu_chu,r.tkt_1_p_kong_hu_chu,
r.tkt_2_l_kong_hu_chu,r.tkt_2_p_kong_hu_chu,
r.tkt_3_l_kong_hu_chu,r.tkt_3_p_kong_hu_chu,
r.tkt_4_l_kong_hu_chu,r.tkt_4_p_kong_hu_chu,
r.tkt_5_l_kong_hu_chu,r.tkt_5_p_kong_hu_chu,
r.tkt_6_l_kong_hu_chu,r.tkt_6_p_kong_hu_chu,
r.tkt_7_l_kong_hu_chu,r.tkt_7_p_kong_hu_chu,
r.tkt_8_l_kong_hu_chu,r.tkt_8_p_kong_hu_chu,
r.tkt_9_l_kong_hu_chu,r.tkt_9_p_kong_hu_chu,
r.tkt_10_l_kong_hu_chu,r.tkt_10_p_kong_hu_chu,
r.tkt_11_l_kong_hu_chu,r.tkt_11_p_kong_hu_chu,
r.tkt_12_l_kong_hu_chu,r.tkt_12_p_kong_hu_chu,
r.tkt_13_l_kong_hu_chu,r.tkt_13_p_kong_hu_chu,

r.tkt_kb_l_kepercayaan,r.tkt_kb_p_kepercayaan,
r.tkt_sps_l_kepercayaan,r.tkt_sps_p_kepercayaan,
r.tkt_tpa_l_kepercayaan,r.tkt_tpa_p_kepercayaan,
r.tkt_kelompok_A_l_kepercayaan,r.tkt_kelompok_A_p_kepercayaan,
r.tkt_kelompok_B_l_kepercayaan,r.tkt_kelompok_B_p_kepercayaan,
r.tkt_keaksaraan_l_kepercayaan,r.tkt_keaksaraan_p_kepercayaan,
r.tkt_multi_keaksaraan_l_kepercayaan,r.tkt_multi_keaksaraan_p_kepercayaan,
r.tkt_usaha_mandiri_l_kepercayaan,r.tkt_usaha_mandiri_p_kepercayaan,
r.tkt_life_skill_l_kepercayaan,r.tkt_life_skill_p_kepercayaan,
r.tkt_paket_gaya_l_kepercayaan,r.tkt_paket_gaya_p_kepercayaan,
r.tkt_tbm_l_kepercayaan,r.tkt_tbm_p_kepercayaan,
r.tkt_1_l_kepercayaan,r.tkt_1_p_kepercayaan,
r.tkt_2_l_kepercayaan,r.tkt_2_p_kepercayaan,
r.tkt_3_l_kepercayaan,r.tkt_3_p_kepercayaan,
r.tkt_4_l_kepercayaan,r.tkt_4_p_kepercayaan,
r.tkt_5_l_kepercayaan,r.tkt_5_p_kepercayaan,
r.tkt_6_l_kepercayaan,r.tkt_6_p_kepercayaan,
r.tkt_7_l_kepercayaan,r.tkt_7_p_kepercayaan,
r.tkt_8_l_kepercayaan,r.tkt_8_p_kepercayaan,
r.tkt_9_l_kepercayaan,r.tkt_9_p_kepercayaan,
r.tkt_10_l_kepercayaan,r.tkt_10_p_kepercayaan,
r.tkt_11_l_kepercayaan,r.tkt_11_p_kepercayaan,
r.tkt_12_l_kepercayaan,r.tkt_12_p_kepercayaan,
r.tkt_13_l_kepercayaan,r.tkt_13_p_kepercayaan,

r.tkt_kb_l_lainnya,r.tkt_kb_p_lainnya,
r.tkt_sps_l_lainnya,r.tkt_sps_p_lainnya,
r.tkt_tpa_l_lainnya,r.tkt_tpa_p_lainnya,
r.tkt_kelompok_A_l_lainnya,r.tkt_kelompok_A_p_lainnya,
r.tkt_kelompok_B_l_lainnya,r.tkt_kelompok_B_p_lainnya,
r.tkt_keaksaraan_l_lainnya,r.tkt_keaksaraan_p_lainnya,
r.tkt_multi_keaksaraan_l_lainnya,r.tkt_multi_keaksaraan_p_lainnya,
r.tkt_usaha_mandiri_l_lainnya,r.tkt_usaha_mandiri_p_lainnya,
r.tkt_life_skill_l_lainnya,r.tkt_life_skill_p_lainnya,
r.tkt_paket_gaya_l_lainnya,r.tkt_paket_gaya_p_lainnya,
r.tkt_tbm_l_lainnya,r.tkt_tbm_p_lainnya,
r.tkt_1_l_lainnya,r.tkt_1_p_lainnya,
r.tkt_2_l_lainnya,r.tkt_2_p_lainnya,
r.tkt_3_l_lainnya,r.tkt_3_p_lainnya,
r.tkt_4_l_lainnya,r.tkt_4_p_lainnya,
r.tkt_5_l_lainnya,r.tkt_5_p_lainnya,
r.tkt_6_l_lainnya,r.tkt_6_p_lainnya,
r.tkt_7_l_lainnya,r.tkt_7_p_lainnya,
r.tkt_8_l_lainnya,r.tkt_8_p_lainnya,
r.tkt_9_l_lainnya,r.tkt_9_p_lainnya,
r.tkt_10_l_lainnya,r.tkt_10_p_lainnya,
r.tkt_11_l_lainnya,r.tkt_11_p_lainnya,
r.tkt_12_l_lainnya,r.tkt_12_p_lainnya,
r.tkt_13_l_lainnya,r.tkt_13_p_lainnya,

s.asrama_siswa_baik,s.asrama_siswa_rusak_ringan,s.asrama_siswa_rusak_sedang,s.asrama_siswa_rusak_berat,
s.tempat_ibadah_baik,s.tempat_ibadah_rusak_ringan,s.tempat_ibadah_rusak_sedang,s.tempat_ibadah_rusak_berat,
s.wc_guru_baik,s.wc_guru_rusak_ringan,s.wc_guru_rusak_sedang,s.wc_guru_rusak_berat,
s.wc_siswa_baik,s.wc_siswa_rusak_ringan,s.wc_siswa_rusak_sedang,s.wc_siswa_rusak_berat,
s.wc_umum_baik,s.wc_umum_rusak_ringan,s.wc_umum_rusak_sedang,s.wc_umum_rusak_berat,
s.laboratorium_bahasa_baik,s.laboratorium_bahasa_rusak_ringan,s.laboratorium_bahasa_rusak_sedang,s.laboratorium_bahasa_rusak_berat,
s.laboratorium_ipa_baik,s.laboratorium_ipa_rusak_ringan,s.laboratorium_ipa_rusak_sedang,s.laboratorium_ipa_rusak_berat,
s.laboratorium_ips_baik,s.laboratorium_ips_rusak_ringan,s.laboratorium_ips_rusak_sedang,s.laboratorium_ips_rusak_berat,
s.laboratorium_komputer_baik,s.laboratorium_komputer_rusak_ringan,s.laboratorium_komputer_rusak_sedang,s.laboratorium_komputer_rusak_berat,
s.laboratorium_multimedia_baik,s.laboratorium_multimedia_rusak_ringan,s.laboratorium_multimedia_rusak_sedang,s.laboratorium_multimedia_rusak_berat,
s.ruang_bina_baik,s.ruang_bina_rusak_ringan,s.ruang_bina_rusak_sedang,s.ruang_bina_rusak_berat,
s.ruang_guru_baik,s.ruang_guru_rusak_ringan,s.ruang_guru_rusak_sedang,s.ruang_guru_rusak_berat,
s.ruang_kepala_sekolah_baik,s.ruang_kepala_sekolah_rusak_ringan,s.ruang_kepala_sekolah_rusak_sedang,s.ruang_kepala_sekolah_rusak_berat,
s.ruang_perpustakaan_baik,s.ruang_perpustakaan_rusak_ringan,s.ruang_perpustakaan_rusak_sedang,s.ruang_perpustakaan_rusak_berat,
s.ruang_kelas_baik,s.ruang_kelas_rusak_ringan,s.ruang_kelas_rusak_sedang,s.ruang_kelas_rusak_berat

FROM datamart.sekolah p 
LEFT JOIN datamart.sekolah_ptk q ON p.sekolah_id=q.sekolah_id
LEFT JOIN datamart.sekolah_peserta_didik r ON p.sekolah_id=r.sekolah_id
LEFT JOIN datamart.sekolah_ruang s ON p.sekolah_id=s.sekolah_id
WHERE p.kode_kabupaten='$kodekabupaten' AND p.sekolah_id IS NOT NULL AND p.npsn IS NOT NULL AND NOT p.bentuk_pendidikan = 'Pondok Pesantren'");

$sqldtmart->execute();
$no = 0;
while ($row = $sqldtmart->fetch(PDO::FETCH_ASSOC)) {
    $no++;

    $jmlgurutotal = $row['ptk_guru_l'] + $row['ptk_guru_p'];

    $jmlsiswaL = $row['pd_tkt_kb_l'] + $row['pd_tkt_sps_l'] + $row['pd_tkt_tpa_l'] + $row['pd_tkt_kelompok_A_l'] + $row['pd_tkt_kelompok_B_l'] +
        $row['pd_tkt_keaksaraan_l'] + $row['pd_tkt_multi_keaksaraan_l'] + $row['pd_tkt_usaha_mandiri_l'] + $row['pd_tkt_life_skill_l'] + $row['pd_tkt_paket_gaya_l'] +
        $row['pd_tkt_tbm_l'] + $row['pd_tkt_1_l'] + $row['pd_tkt_2_l'] + $row['pd_tkt_3_l'] + $row['pd_tkt_4_l'] +
        $row['pd_tkt_5_l'] + $row['pd_tkt_6_l'] + $row['pd_tkt_7_l'] + $row['pd_tkt_8_l'] + $row['pd_tkt_9_l'] +
        $row['pd_tkt_10_l'] + $row['pd_tkt_11_l'] + $row['pd_tkt_12_l'] + $row['pd_tkt_13_l'];

    $jmlsiswaP = $row['pd_tkt_kb_p'] + $row['pd_tkt_sps_p'] + $row['pd_tkt_tpa_p'] + $row['pd_tkt_kelompok_A_p'] + $row['pd_tkt_kelompok_B_p'] +
        $row['pd_tkt_keaksaraan_p'] + $row['pd_tkt_multi_keaksaraan_p'] + $row['pd_tkt_usaha_mandiri_p'] + $row['pd_tkt_life_skill_p'] + $row['pd_tkt_paket_gaya_p'] +
        $row['pd_tkt_tbm_p'] + $row['pd_tkt_1_p'] + $row['pd_tkt_2_p'] + $row['pd_tkt_3_p'] + $row['pd_tkt_4_p'] +
        $row['pd_tkt_5_p'] + $row['pd_tkt_6_p'] + $row['pd_tkt_7_p'] + $row['pd_tkt_8_p'] + $row['pd_tkt_9_p'] +
        $row['pd_tkt_10_p'] + $row['pd_tkt_11_p'] + $row['pd_tkt_12_p'] + $row['pd_tkt_13_p'];

    $jmlsiswatotal = $jmlsiswaL + $jmlsiswaP;

    /////////// AGAMA ///////////    
    $jmlsiswaL_islam = $row['tkt_kb_l_islam'] + $row['tkt_sps_l_islam'] + $row['tkt_tpa_l_islam'] + $row['tkt_kelompok_A_l_islam'] + $row['tkt_kelompok_B_l_islam'] +
        $row['tkt_keaksaraan_l_islam'] + $row['tkt_multi_keaksaraan_l_islam'] + $row['tkt_usaha_mandiri_l_islam'] + $row['tkt_life_skill_l_islam'] + $row['tkt_paket_gaya_l_islam'] +
        $row['tkt_tbm_l_islam'] + $row['tkt_1_l_islam'] + $row['tkt_2_l_islam'] + $row['tkt_3_l_islam'] + $row['tkt_4_l_islam'] +
        $row['tkt_5_l_islam'] + $row['tkt_6_l_islam'] + $row['tkt_7_l_islam'] + $row['tkt_8_l_islam'] + $row['tkt_9_l_islam'] +
        $row['tkt_10_l_islam'] + $row['tkt_11_l_islam'] + $row['tkt_12_l_islam'] + $row['tkt_13_l_islam'];

    $jmlsiswaP_Islam = $row['tkt_kb_p_islam'] + $row['tkt_sps_p_islam'] + $row['tkt_tpa_p_islam'] + $row['tkt_kelompok_A_p_islam'] + $row['tkt_kelompok_B_p_islam'] +
        $row['tkt_keaksaraan_p_islam'] + $row['tkt_multi_keaksaraan_p_islam'] + $row['tkt_usaha_mandiri_p_islam'] + $row['tkt_life_skill_p_islam'] + $row['tkt_paket_gaya_p_islam'] +
        $row['tkt_tbm_p_islam'] + $row['tkt_1_p_islam'] + $row['tkt_2_p_islam'] + $row['tkt_3_p_islam'] + $row['tkt_4_p_islam'] +
        $row['tkt_5_p_islam'] + $row['tkt_6_p_islam'] + $row['tkt_7_p_islam'] + $row['tkt_8_p_islam'] + $row['tkt_9_p_islam'] +
        $row['tkt_10_p_islam'] + $row['tkt_11_p_islam'] + $row['tkt_12_p_islam'] + $row['tkt_13_p_islam'];
    $jmlsiswaislamTotal = $jmlsiswaL_islam + $jmlsiswaP_Islam;

    $jmlsiswaL_kristen = $row['tkt_kb_l_kristen'] + $row['tkt_sps_l_kristen'] + $row['tkt_tpa_l_kristen'] + $row['tkt_kelompok_A_l_kristen'] + $row['tkt_kelompok_B_l_kristen'] +
        $row['tkt_keaksaraan_l_kristen'] + $row['tkt_multi_keaksaraan_l_kristen'] + $row['tkt_usaha_mandiri_l_kristen'] + $row['tkt_life_skill_l_kristen'] + $row['tkt_paket_gaya_l_kristen'] +
        $row['tkt_tbm_l_kristen'] + $row['tkt_1_l_kristen'] + $row['tkt_2_l_kristen'] + $row['tkt_3_l_kristen'] + $row['tkt_4_l_kristen'] +
        $row['tkt_5_l_kristen'] + $row['tkt_6_l_kristen'] + $row['tkt_7_l_kristen'] + $row['tkt_8_l_kristen'] + $row['tkt_9_l_kristen'] +
        $row['tkt_10_l_kristen'] + $row['tkt_11_l_kristen'] + $row['tkt_12_l_kristen'] + $row['tkt_13_l_kristen'];

    $jmlsiswaP_kristen = $row['tkt_kb_p_kristen'] + $row['tkt_sps_p_kristen'] + $row['tkt_tpa_p_kristen'] + $row['tkt_kelompok_A_p_kristen'] + $row['tkt_kelompok_B_p_kristen'] +
        $row['tkt_keaksaraan_p_kristen'] + $row['tkt_multi_keaksaraan_p_kristen'] + $row['tkt_usaha_mandiri_p_kristen'] + $row['tkt_life_skill_p_kristen'] + $row['tkt_paket_gaya_p_kristen'] +
        $row['tkt_tbm_p_kristen'] + $row['tkt_1_p_kristen'] + $row['tkt_2_p_kristen'] + $row['tkt_3_p_kristen'] + $row['tkt_4_p_kristen'] +
        $row['tkt_5_p_kristen'] + $row['tkt_6_p_kristen'] + $row['tkt_7_p_kristen'] + $row['tkt_8_p_kristen'] + $row['tkt_9_p_kristen'] +
        $row['tkt_10_p_kristen'] + $row['tkt_11_p_kristen'] + $row['tkt_12_p_kristen'] + $row['tkt_13_p_kristen'];
    $jmlsiswakristenTotal = $jmlsiswaL_kristen + $jmlsiswaP_kristen;

    $jmlsiswaL_katholik = $row['tkt_kb_l_katholik'] + $row['tkt_sps_l_katholik'] + $row['tkt_tpa_l_katholik'] + $row['tkt_kelompok_A_l_katholik'] + $row['tkt_kelompok_B_l_katholik'] +
        $row['tkt_keaksaraan_l_katholik'] + $row['tkt_multi_keaksaraan_l_katholik'] + $row['tkt_usaha_mandiri_l_katholik'] + $row['tkt_life_skill_l_katholik'] + $row['tkt_paket_gaya_l_katholik'] +
        $row['tkt_tbm_l_katholik'] + $row['tkt_1_l_katholik'] + $row['tkt_2_l_katholik'] + $row['tkt_3_l_katholik'] + $row['tkt_4_l_katholik'] +
        $row['tkt_5_l_katholik'] + $row['tkt_6_l_katholik'] + $row['tkt_7_l_katholik'] + $row['tkt_8_l_katholik'] + $row['tkt_9_l_katholik'] +
        $row['tkt_10_l_katholik'] + $row['tkt_11_l_katholik'] + $row['tkt_12_l_katholik'] + $row['tkt_13_l_katholik'];

    $jmlsiswaP_katholik = $row['tkt_kb_p_katholik'] + $row['tkt_sps_p_katholik'] + $row['tkt_tpa_p_katholik'] + $row['tkt_kelompok_A_p_katholik'] + $row['tkt_kelompok_B_p_katholik'] +
        $row['tkt_keaksaraan_p_katholik'] + $row['tkt_multi_keaksaraan_p_katholik'] + $row['tkt_usaha_mandiri_p_katholik'] + $row['tkt_life_skill_p_katholik'] + $row['tkt_paket_gaya_p_katholik'] +
        $row['tkt_tbm_p_katholik'] + $row['tkt_1_p_katholik'] + $row['tkt_2_p_katholik'] + $row['tkt_3_p_katholik'] + $row['tkt_4_p_katholik'] +
        $row['tkt_5_p_katholik'] + $row['tkt_6_p_katholik'] + $row['tkt_7_p_katholik'] + $row['tkt_8_p_katholik'] + $row['tkt_9_p_katholik'] +
        $row['tkt_10_p_katholik'] + $row['tkt_11_p_katholik'] + $row['tkt_12_p_katholik'] + $row['tkt_13_p_katholik'];
    $jmlsiswakatholikTotal = $jmlsiswaL_katholik + $jmlsiswaP_katholik;

    $jmlsiswaL_hindu = $row['tkt_kb_l_hindu'] + $row['tkt_sps_l_hindu'] + $row['tkt_tpa_l_hindu'] + $row['tkt_kelompok_A_l_hindu'] + $row['tkt_kelompok_B_l_hindu'] +
        $row['tkt_keaksaraan_l_hindu'] + $row['tkt_multi_keaksaraan_l_hindu'] + $row['tkt_usaha_mandiri_l_hindu'] + $row['tkt_life_skill_l_hindu'] + $row['tkt_paket_gaya_l_hindu'] +
        $row['tkt_tbm_l_hindu'] + $row['tkt_1_l_hindu'] + $row['tkt_2_l_hindu'] + $row['tkt_3_l_hindu'] + $row['tkt_4_l_hindu'] +
        $row['tkt_5_l_hindu'] + $row['tkt_6_l_hindu'] + $row['tkt_7_l_hindu'] + $row['tkt_8_l_hindu'] + $row['tkt_9_l_hindu'] +
        $row['tkt_10_l_hindu'] + $row['tkt_11_l_hindu'] + $row['tkt_12_l_hindu'] + $row['tkt_13_l_hindu'];

    $jmlsiswaP_hindu = $row['tkt_kb_p_hindu'] + $row['tkt_sps_p_hindu'] + $row['tkt_tpa_p_hindu'] + $row['tkt_kelompok_A_p_hindu'] + $row['tkt_kelompok_B_p_hindu'] +
        $row['tkt_keaksaraan_p_hindu'] + $row['tkt_multi_keaksaraan_p_hindu'] + $row['tkt_usaha_mandiri_p_hindu'] + $row['tkt_life_skill_p_hindu'] + $row['tkt_paket_gaya_p_hindu'] +
        $row['tkt_tbm_p_hindu'] + $row['tkt_1_p_hindu'] + $row['tkt_2_p_hindu'] + $row['tkt_3_p_hindu'] + $row['tkt_4_p_hindu'] +
        $row['tkt_5_p_hindu'] + $row['tkt_6_p_hindu'] + $row['tkt_7_p_hindu'] + $row['tkt_8_p_hindu'] + $row['tkt_9_p_hindu'] +
        $row['tkt_10_p_hindu'] + $row['tkt_11_p_hindu'] + $row['tkt_12_p_hindu'] + $row['tkt_13_p_hindu'];
    $jmlsiswahinduTotal = $jmlsiswaL_hindu + $jmlsiswaP_hindu;

    $jmlsiswaL_budha = $row['tkt_kb_l_budha'] + $row['tkt_sps_l_budha'] + $row['tkt_tpa_l_budha'] + $row['tkt_kelompok_A_l_budha'] + $row['tkt_kelompok_B_l_budha'] +
        $row['tkt_keaksaraan_l_budha'] + $row['tkt_multi_keaksaraan_l_budha'] + $row['tkt_usaha_mandiri_l_budha'] + $row['tkt_life_skill_l_budha'] + $row['tkt_paket_gaya_l_budha'] +
        $row['tkt_tbm_l_budha'] + $row['tkt_1_l_budha'] + $row['tkt_2_l_budha'] + $row['tkt_3_l_budha'] + $row['tkt_4_l_budha'] +
        $row['tkt_5_l_budha'] + $row['tkt_6_l_budha'] + $row['tkt_7_l_budha'] + $row['tkt_8_l_budha'] + $row['tkt_9_l_budha'] +
        $row['tkt_10_l_budha'] + $row['tkt_11_l_budha'] + $row['tkt_12_l_budha'] + $row['tkt_13_l_budha'];

    $jmlsiswaP_budha = $row['tkt_kb_p_budha'] + $row['tkt_sps_p_budha'] + $row['tkt_tpa_p_budha'] + $row['tkt_kelompok_A_p_budha'] + $row['tkt_kelompok_B_p_budha'] +
        $row['tkt_keaksaraan_p_budha'] + $row['tkt_multi_keaksaraan_p_budha'] + $row['tkt_usaha_mandiri_p_budha'] + $row['tkt_life_skill_p_budha'] + $row['tkt_paket_gaya_p_budha'] +
        $row['tkt_tbm_p_budha'] + $row['tkt_1_p_budha'] + $row['tkt_2_p_budha'] + $row['tkt_3_p_budha'] + $row['tkt_4_p_budha'] +
        $row['tkt_5_p_budha'] + $row['tkt_6_p_budha'] + $row['tkt_7_p_budha'] + $row['tkt_8_p_budha'] + $row['tkt_9_p_budha'] +
        $row['tkt_10_p_budha'] + $row['tkt_11_p_budha'] + $row['tkt_12_p_budha'] + $row['tkt_13_p_budha'];
    $jmlsiswabudhaTotal = $jmlsiswaL_budha + $jmlsiswaP_budha;

    $jmlsiswaL_kong_hu_chu = $row['tkt_kb_l_kong_hu_chu'] + $row['tkt_sps_l_kong_hu_chu'] + $row['tkt_tpa_l_kong_hu_chu'] + $row['tkt_kelompok_A_l_kong_hu_chu'] + $row['tkt_kelompok_B_l_kong_hu_chu'] +
        $row['tkt_keaksaraan_l_kong_hu_chu'] + $row['tkt_multi_keaksaraan_l_kong_hu_chu'] + $row['tkt_usaha_mandiri_l_kong_hu_chu'] + $row['tkt_life_skill_l_kong_hu_chu'] + $row['tkt_paket_gaya_l_kong_hu_chu'] +
        $row['tkt_tbm_l_kong_hu_chu'] + $row['tkt_1_l_kong_hu_chu'] + $row['tkt_2_l_kong_hu_chu'] + $row['tkt_3_l_kong_hu_chu'] + $row['tkt_4_l_kong_hu_chu'] +
        $row['tkt_5_l_kong_hu_chu'] + $row['tkt_6_l_kong_hu_chu'] + $row['tkt_7_l_kong_hu_chu'] + $row['tkt_8_l_kong_hu_chu'] + $row['tkt_9_l_kong_hu_chu'] +
        $row['tkt_10_l_kong_hu_chu'] + $row['tkt_11_l_kong_hu_chu'] + $row['tkt_12_l_kong_hu_chu'] + $row['tkt_13_l_kong_hu_chu'];

    $jmlsiswaP_kong_hu_chu = $row['tkt_kb_p_kong_hu_chu'] + $row['tkt_sps_p_kong_hu_chu'] + $row['tkt_tpa_p_kong_hu_chu'] + $row['tkt_kelompok_A_p_kong_hu_chu'] + $row['tkt_kelompok_B_p_kong_hu_chu'] +
        $row['tkt_keaksaraan_p_kong_hu_chu'] + $row['tkt_multi_keaksaraan_p_kong_hu_chu'] + $row['tkt_usaha_mandiri_p_kong_hu_chu'] + $row['tkt_life_skill_p_kong_hu_chu'] + $row['tkt_paket_gaya_p_kong_hu_chu'] +
        $row['tkt_tbm_p_kong_hu_chu'] + $row['tkt_1_p_kong_hu_chu'] + $row['tkt_2_p_kong_hu_chu'] + $row['tkt_3_p_kong_hu_chu'] + $row['tkt_4_p_kong_hu_chu'] +
        $row['tkt_5_p_kong_hu_chu'] + $row['tkt_6_p_kong_hu_chu'] + $row['tkt_7_p_kong_hu_chu'] + $row['tkt_8_p_kong_hu_chu'] + $row['tkt_9_p_kong_hu_chu'] +
        $row['tkt_10_p_kong_hu_chu'] + $row['tkt_11_p_kong_hu_chu'] + $row['tkt_12_p_kong_hu_chu'] + $row['tkt_13_p_kong_hu_chu'];
    $jmlsiswakonghuchuTotal = $jmlsiswaL_kong_hu_chu + $jmlsiswaP_kong_hu_chu;

    $jmlsiswaL_kepercayaan = $row['tkt_kb_l_kepercayaan'] + $row['tkt_sps_l_kepercayaan'] + $row['tkt_tpa_l_kepercayaan'] + $row['tkt_kelompok_A_l_kepercayaan'] + $row['tkt_kelompok_B_l_kepercayaan'] +
        $row['tkt_keaksaraan_l_kepercayaan'] + $row['tkt_multi_keaksaraan_l_kepercayaan'] + $row['tkt_usaha_mandiri_l_kepercayaan'] + $row['tkt_life_skill_l_kepercayaan'] + $row['tkt_paket_gaya_l_kepercayaan'] +
        $row['tkt_tbm_l_kepercayaan'] + $row['tkt_1_l_kepercayaan'] + $row['tkt_2_l_kepercayaan'] + $row['tkt_3_l_kepercayaan'] + $row['tkt_4_l_kepercayaan'] +
        $row['tkt_5_l_kepercayaan'] + $row['tkt_6_l_kepercayaan'] + $row['tkt_7_l_kepercayaan'] + $row['tkt_8_l_kepercayaan'] + $row['tkt_9_l_kepercayaan'] +
        $row['tkt_10_l_kepercayaan'] + $row['tkt_11_l_kepercayaan'] + $row['tkt_12_l_kepercayaan'] + $row['tkt_13_l_kepercayaan'];

    $jmlsiswaP_kepercayaan = $row['tkt_kb_p_kepercayaan'] + $row['tkt_sps_p_kepercayaan'] + $row['tkt_tpa_p_kepercayaan'] + $row['tkt_kelompok_A_p_kepercayaan'] + $row['tkt_kelompok_B_p_kepercayaan'] +
        $row['tkt_keaksaraan_p_kepercayaan'] + $row['tkt_multi_keaksaraan_p_kepercayaan'] + $row['tkt_usaha_mandiri_p_kepercayaan'] + $row['tkt_life_skill_p_kepercayaan'] + $row['tkt_paket_gaya_p_kepercayaan'] +
        $row['tkt_tbm_p_kepercayaan'] + $row['tkt_1_p_kepercayaan'] + $row['tkt_2_p_kepercayaan'] + $row['tkt_3_p_kepercayaan'] + $row['tkt_4_p_kepercayaan'] +
        $row['tkt_5_p_kepercayaan'] + $row['tkt_6_p_kepercayaan'] + $row['tkt_7_p_kepercayaan'] + $row['tkt_8_p_kepercayaan'] + $row['tkt_9_p_kepercayaan'] +
        $row['tkt_10_p_kepercayaan'] + $row['tkt_11_p_kepercayaan'] + $row['tkt_12_p_kepercayaan'] + $row['tkt_13_p_kepercayaan'];
    $jmlsiswakepercayaanTotal = $jmlsiswaL_kepercayaan + $jmlsiswaP_kepercayaan;

    $jmlsiswaL_lainnya = $row['tkt_kb_l_lainnya'] + $row['tkt_sps_l_lainnya'] + $row['tkt_tpa_l_lainnya'] + $row['tkt_kelompok_A_l_lainnya'] + $row['tkt_kelompok_B_l_lainnya'] +
        $row['tkt_keaksaraan_l_lainnya'] + $row['tkt_multi_keaksaraan_l_lainnya'] + $row['tkt_usaha_mandiri_l_lainnya'] + $row['tkt_life_skill_l_lainnya'] + $row['tkt_paket_gaya_l_lainnya'] +
        $row['tkt_tbm_l_lainnya'] + $row['tkt_1_l_lainnya'] + $row['tkt_2_l_lainnya'] + $row['tkt_3_l_lainnya'] + $row['tkt_4_l_lainnya'] +
        $row['tkt_5_l_lainnya'] + $row['tkt_6_l_lainnya'] + $row['tkt_7_l_lainnya'] + $row['tkt_8_l_lainnya'] + $row['tkt_9_l_lainnya'] +
        $row['tkt_10_l_lainnya'] + $row['tkt_11_l_lainnya'] + $row['tkt_12_l_lainnya'] + $row['tkt_13_l_lainnya'];

    $jmlsiswaP_lainnya = $row['tkt_kb_p_lainnya'] + $row['tkt_sps_p_lainnya'] + $row['tkt_tpa_p_lainnya'] + $row['tkt_kelompok_A_p_lainnya'] + $row['tkt_kelompok_B_p_lainnya'] +
        $row['tkt_keaksaraan_p_lainnya'] + $row['tkt_multi_keaksaraan_p_lainnya'] + $row['tkt_usaha_mandiri_p_lainnya'] + $row['tkt_life_skill_p_lainnya'] + $row['tkt_paket_gaya_p_lainnya'] +
        $row['tkt_tbm_p_lainnya'] + $row['tkt_1_p_lainnya'] + $row['tkt_2_p_lainnya'] + $row['tkt_3_p_lainnya'] + $row['tkt_4_p_lainnya'] +
        $row['tkt_5_p_lainnya'] + $row['tkt_6_p_lainnya'] + $row['tkt_7_p_lainnya'] + $row['tkt_8_p_lainnya'] + $row['tkt_9_p_lainnya'] +
        $row['tkt_10_p_lainnya'] + $row['tkt_11_p_lainnya'] + $row['tkt_12_p_lainnya'] + $row['tkt_13_p_lainnya'];
    $jmlsiswalainnyaTotal = $jmlsiswaL_lainnya + $jmlsiswaP_lainnya;

    $jmlasrama = $row['asrama_siswa_baik'] + $row['asrama_siswa_rusak_ringan'] + $row['asrama_siswa_rusak_sedang'] + $row['asrama_siswa_rusak_berat'];
    $jmltempatibadah = $row['tempat_ibadah_baik'] + $row['tempat_ibadah_rusak_ringan'] + $row['tempat_ibadah_rusak_sedang'] + $row['tempat_ibadah_rusak_berat'];

    $jmlwcguru = $row['wc_guru_baik'] + $row['wc_guru_rusak_ringan'] + $row['wc_guru_rusak_sedang'] + $row['wc_guru_rusak_berat'];
    $jmlwcsiswa = $row['wc_siswa_baik'] + $row['wc_siswa_rusak_ringan'] + $row['wc_siswa_rusak_sedang'] + $row['wc_siswa_rusak_berat'];
    $jmlwcumum = $row['wc_umum_baik'] + $row['wc_umum_rusak_ringan'] + $row['wc_umum_rusak_sedang'] + $row['wc_umum_rusak_berat'];

    $jmllabbahasa = $row['laboratorium_bahasa_baik'] + $row['laboratorium_bahasa_rusak_ringan'] + $row['laboratorium_bahasa_rusak_sedang'] + $row['laboratorium_bahasa_rusak_berat'];
    $jmllabipa = $row['laboratorium_ipa_baik'] + $row['laboratorium_ipa_rusak_ringan'] + $row['laboratorium_ipa_rusak_sedang'] + $row['laboratorium_ipa_rusak_berat'];
    $jmllabips = $row['laboratorium_ips_baik'] + $row['laboratorium_ips_rusak_ringan'] + $row['laboratorium_ips_rusak_sedang'] + $row['laboratorium_ips_rusak_berat'];
    $jmllabkomputer = $row['laboratorium_komputer_baik'] + $row['laboratorium_komputer_rusak_ringan'] + $row['laboratorium_komputer_rusak_sedang'] + $row['laboratorium_komputer_rusak_berat'];
    $jmllabmultimedia = $row['laboratorium_multimedia_baik'] + $row['laboratorium_multimedia_rusak_ringan'] + $row['laboratorium_multimedia_rusak_sedang'] + $row['laboratorium_multimedia_rusak_berat'];

    $jmlruangbina = $row['ruang_bina_baik'] + $row['ruang_bina_rusak_ringan'] + $row['ruang_bina_rusak_sedang'] + $row['ruang_bina_rusak_berat'];
    $jmlruangguru = $row['ruang_guru_baik'] + $row['ruang_guru_rusak_ringan'] + $row['ruang_guru_rusak_sedang'] + $row['ruang_guru_rusak_berat'];
    $jmlruangkepalasekolah = $row['ruang_kepala_sekolah_baik'] + $row['ruang_kepala_sekolah_rusak_ringan'] + $row['ruang_kepala_sekolah_rusak_sedang'] + $row['ruang_kepala_sekolah_rusak_berat'];
    $jmlruangperpustakaan = $row['ruang_perpustakaan_baik'] + $row['ruang_perpustakaan_rusak_ringan'] + $row['ruang_perpustakaan_rusak_sedang'] + $row['ruang_perpustakaan_rusak_berat'];
    $jmlruangkelas = $row['ruang_kelas_baik'] + $row['ruang_kelas_rusak_ringan'] + $row['ruang_kelas_rusak_sedang'] + $row['ruang_kelas_rusak_berat'];

    $sqlx = ("SELECT COUNT(id) AS jumKetemu FROM tbl_api_dispendik WHERE npsn = '" . $row['npsn'] . "'");
    $result = mysqli_query($dbconn, $sqlx);
    $b = mysqli_fetch_assoc($result);

    if ($b['jumKetemu'] <= 0) {

        $sqldispendik  = "INSERT INTO tbl_api_dispendik (id_sekolah,npsn,nama,
        siswa_islam,siswa_kristen,siswa_katholik,siswa_hindu,siswa_budha,siswa_konghuchu,siswa_kepercayaan,siswa_lainnya,siswa_l,siswa_p,siswa,
        guru_l,guru_p,guru,
        bentuk_pendidikan,alamat_jalan,rt,rw,nama_dusun,
        desa_kelurahan,kecamatan,lintang,bujur,status_sekolah,akreditasi,
        jml_asrama,asrama_siswa_baik,asrama_siswa_rusak_ringan,asrama_siswa_rusak_sedang,asrama_siswa_rusak_berat,
        jml_tempat_ibadah,tempat_ibadah_baik,tempat_ibadah_rusak_ringan,tempat_ibadah_rusak_sedang,tempat_ibadah_rusak_berat,
        jml_wc_guru,wc_guru_baik,wc_guru_rusak_ringan,wc_guru_rusak_sedang,wc_guru_rusak_berat,
        jml_wc_siswa,wc_siswa_baik,wc_siswa_rusak_ringan,wc_siswa_rusak_sedang,wc_siswa_rusak_berat,
        jml_wc_umum,wc_umum_baik,wc_umum_rusak_ringan,wc_umum_rusak_sedang,wc_umum_rusak_berat,
        jml_lab_bahasa,laboratorium_bahasa_baik,laboratorium_bahasa_rusak_ringan,laboratorium_bahasa_rusak_sedang,laboratorium_bahasa_rusak_berat,
        jml_lab_ipa,laboratorium_ipa_baik,laboratorium_ipa_rusak_ringan,laboratorium_ipa_rusak_sedang,laboratorium_ipa_rusak_berat,
        jml_lab_ips,laboratorium_ips_baik,laboratorium_ips_rusak_ringan,laboratorium_ips_rusak_sedang,laboratorium_ips_rusak_berat,
        jml_lab_komputer,laboratorium_komputer_baik,laboratorium_komputer_rusak_ringan,laboratorium_komputer_rusak_sedang,laboratorium_komputer_rusak_berat,
        jml_lab_multimedia,laboratorium_multimedia_baik,laboratorium_multimedia_rusak_ringan,laboratorium_multimedia_rusak_sedang,laboratorium_multimedia_rusak_berat,
        jml_ruang_bina,ruang_bina_baik,ruang_bina_rusak_ringan,ruang_bina_rusak_sedang,ruang_bina_rusak_berat,
        jml_ruang_guru,ruang_guru_baik,ruang_guru_rusak_ringan,ruang_guru_rusak_sedang,ruang_guru_rusak_berat,
        jml_ruang_kepala_sekolah,ruang_kepala_sekolah_baik,ruang_kepala_sekolah_rusak_ringan,ruang_kepala_sekolah_rusak_sedang,ruang_kepala_sekolah_rusak_berat,
        jml_ruang_perpustakaan,ruang_perpustakaan_baik,ruang_perpustakaan_rusak_ringan,ruang_perpustakaan_rusak_sedang,ruang_perpustakaan_rusak_berat,
        jml_ruang_kelas,ruang_kelas_baik,ruang_kelas_rusak_ringan,ruang_kelas_rusak_sedang,ruang_kelas_rusak_berat) 
        VALUES ('" . $row['sekolah_id'] . "','" . $row['npsn'] . "','" . anti_injection($row['nama']) . "',
        '" . $jmlsiswaislamTotal . "','" . $jmlsiswakristenTotal . "','" . $jmlsiswakatholikTotal . "','" . $jmlsiswahinduTotal . "','" . $jmlsiswabudhaTotal . "','" . $jmlsiswakonghuchuTotal . "',
        '" . $jmlsiswakepercayaanTotal . "','" . $jmlsiswalainnyaTotal . "','" . $jmlsiswaL . "','" . $jmlsiswaP . "','" . $jmlsiswatotal . "',
        '" . $row['ptk_guru_l'] . "','" . $row['ptk_guru_p'] . "','" . $jmlgurutotal . "',
        '" . $row['bentuk_pendidikan'] . "','" . anti_injection($row['alamat_jalan']) . "'
        ,'" . $row['rt'] . "','" . $row['rw'] . "','" . anti_injection($row['nama_dusun']) . "'
        ,'" . anti_injection($row['desa_kelurahan']) . "','" . anti_injection($row['kecamatan']) . "','" . $row['lintang'] . "','" . $row['bujur'] . "'
        ,'" . $row['status_sekolah'] . "','" . $row['akreditasi'] . "',
        '" . $jmlasrama . "',
        '" . $row['asrama_siswa_baik'] . "','" . $row['asrama_siswa_rusak_ringan'] . "','" . $row['asrama_siswa_rusak_sedang'] . "','" . $row['asrama_siswa_rusak_berat'] . "',
        '" . $jmltempatibadah . "',
        '" . $row['tempat_ibadah_baik'] . "','" . $row['tempat_ibadah_rusak_ringan'] . "','" . $row['tempat_ibadah_rusak_sedang'] . "','" . $row['tempat_ibadah_rusak_berat'] . "',   
        '" . $jmlwcguru . "',
        '" . $row['wc_guru_baik'] . "','" . $row['wc_guru_rusak_ringan'] . "','" . $row['wc_guru_rusak_sedang'] . "','" . $row['wc_guru_rusak_berat'] . "',
        '" . $jmlwcsiswa . "',
        '" . $row['wc_siswa_baik'] . "','" . $row['wc_siswa_rusak_ringan'] . "','" . $row['wc_siswa_rusak_sedang'] . "','" . $row['wc_siswa_rusak_berat'] . "',
        '" . $jmlwcumum . "',
        '" . $row['wc_umum_baik'] . "','" . $row['wc_umum_rusak_ringan'] . "','" . $row['wc_umum_rusak_sedang'] . "','" . $row['wc_umum_rusak_berat'] . "',
        '" . $jmllabbahasa . "',
        '" . $row['laboratorium_bahasa_baik'] . "','" . $row['laboratorium_bahasa_rusak_ringan'] . "','" . $row['laboratorium_bahasa_rusak_sedang'] . "','" . $row['laboratorium_bahasa_rusak_berat'] . "',
        '" . $jmllabipa . "',
        '" . $row['laboratorium_ipa_baik'] . "','" . $row['laboratorium_ipa_rusak_ringan'] . "','" . $row['laboratorium_ipa_rusak_sedang'] . "','" . $row['laboratorium_ipa_rusak_berat'] . "',
        '" . $jmllabips . "',
        '" . $row['laboratorium_ips_baik'] . "','" . $row['laboratorium_ips_rusak_ringan'] . "','" . $row['laboratorium_ips_rusak_sedang'] . "','" . $row['laboratorium_ips_rusak_berat'] . "',
        '" . $jmllabkomputer . "',
        '" . $row['laboratorium_komputer_baik'] . "','" . $row['laboratorium_komputer_rusak_ringan'] . "','" . $row['laboratorium_komputer_rusak_sedang'] . "','" . $row['laboratorium_komputer_rusak_berat'] . "',
        '" . $jmllabmultimedia . "',
        '" . $row['laboratorium_multimedia_baik'] . "','" . $row['laboratorium_multimedia_rusak_ringan'] . "','" . $row['laboratorium_multimedia_rusak_sedang'] . "','" . $row['laboratorium_multimedia_rusak_berat'] . "',
        '" . $jmlruangbina . "',
        '" . $row['ruang_bina_baik'] . "','" . $row['ruang_bina_rusak_ringan'] . "','" . $row['ruang_bina_rusak_sedang'] . "','" . $row['ruang_bina_rusak_berat'] . "',
        '" . $jmlruangguru . "',
        '" . $row['ruang_guru_baik'] . "','" . $row['ruang_guru_rusak_ringan'] . "','" . $row['ruang_guru_rusak_sedang'] . "','" . $row['ruang_guru_rusak_berat'] . "',
        '" . $jmlruangkepalasekolah . "',
        '" . $row['ruang_kepala_sekolah_baik'] . "','" . $row['ruang_kepala_sekolah_rusak_ringan'] . "','" . $row['ruang_kepala_sekolah_rusak_sedang'] . "','" . $row['ruang_kepala_sekolah_rusak_berat'] . "',
        '" . $jmlruangperpustakaan . "',
        '" . $row['ruang_perpustakaan_baik'] . "','" . $row['ruang_perpustakaan_rusak_ringan'] . "','" . $row['ruang_perpustakaan_rusak_sedang'] . "','" . $row['ruang_perpustakaan_rusak_berat'] . "',
        '" . $jmlruangkelas . "',
        '" . $row['ruang_kelas_baik'] . "','" . $row['ruang_kelas_rusak_ringan'] . "','" . $row['ruang_kelas_rusak_sedang'] . "','" . $row['ruang_kelas_rusak_berat'] . "')";
        $res = mysqli_query($dbconn, $sqldispendik);


        $sqlXmax = ("SELECT MAX(id) AS idne FROM tbl_api_dispendik ORDER BY id DESC");
        $resultxmax = mysqli_query($dbconn, $sqlXmax);
        $r = mysqli_fetch_assoc($resultxmax);

       // $sqlopt  = "INSERT INTO m_operator (nm_operator,username,password,akses,id_instansi,id_sekolah) 
        //                  VALUES ('" . anti_injection($row['nama']) . "','" . $row['npsn'] . "','$password','operator','" . $r['idne'] . "','" . $row['sekolah_id'] . "')";
        //$res = mysqli_query($dbconn, $sqlopt);

        $sqlmed  = "INSERT INTO tbl_media (id,id_sekolah,npsn) VALUES ('" . $r['idne'] . "','" . $row['sekolah_id'] . "','" . $row['npsn'] . "')";
        $res = mysqli_query($dbconn, $sqlmed);

    } else if ($b['jumKetemu'] >= 1) {

        $sql2as  = "UPDATE tbl_api_dispendik SET id_sekolah='" . $row['sekolah_id'] . "',nama='" . anti_injection($row['nama']) . "',siswa='" . $jmlsiswatotal . "',guru='" . $jmlgurutotal . "',bentuk_pendidikan='" . $row['bentuk_pendidikan'] . "',alamat_jalan='" . anti_injection($row['alamat_jalan']) . "',rt='" . $row['rt'] . "',rw='" . $row['rw'] . "',nama_dusun='" . anti_injection($row['nama_dusun']) . "',
                desa_kelurahan='" . anti_injection($row['desa_kelurahan']) . "',kecamatan='" . anti_injection($row['kecamatan']) . "',lintang='" . $row['lintang'] . "',bujur='" . $row['bujur'] . "',status_sekolah='" . $row['status_sekolah'] . "',akreditasi='" . $row['akreditasi'] . "' WHERE npsn = '" . $row['npsn'] . "'";
        $res = mysqli_query($dbconn, $sql2as);

        //$sql2asopt  = "UPDATE m_operator SET nm_operator='" . anti_injection($row['nama']) . "',id_sekolah='" . $row['sekolah_id'] . "' WHERE username = '" . $row['npsn'] . "'";
        //$res = mysqli_query($dbconn, $sql2asopt);

        $sql2asmed  = "UPDATE tbl_media SET id_sekolah='" . $row['sekolah_id'] . "' WHERE npsn = '" . $row['npsn'] . "'";
        $res = mysqli_query($dbconn, $sql2asmed);
    }

    $jmlrecord = $no;
    
}

if ($res) {
    $status = 'OK';
} else {
    $status = 'ERR';
}

$data = array('msg1' => $jmlrecord, 'msg2' => $status);
echo json_encode($data);
mysqli_close($dbconn);
