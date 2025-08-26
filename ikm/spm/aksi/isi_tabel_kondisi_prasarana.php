<?php
error_reporting(0);
include '../../services/config.php';
$dbconn = mysqli_connect($dbhost,$dbuser,$dbpass,$dbname)or die('Could not connect: '); 

$filtermedia = trim($_POST['filtermedia']);

if ($filtermedia == "semua"){
	$sqlx = ("SELECT * FROM tbl_api_dispendik p LEFT JOIN detail_persetujuan_pupr q ON p.npsn=q.npsn
	WHERE p.npsn=q.npsn");
} else if ($filtermedia == "baik"){
	$sqlx = ("SELECT * FROM tbl_api_dispendik p LEFT JOIN detail_persetujuan_pupr q ON p.npsn=q.npsn
	WHERE p.npsn=q.npsn AND
	  asrama_siswa_rusak_ringan=0 AND asrama_siswa_rusak_sedang=0 AND asrama_siswa_rusak_berat=0
	  AND tempat_ibadah_rusak_ringan=0 AND tempat_ibadah_rusak_sedang=0 AND tempat_ibadah_rusak_berat=0
	  AND wc_guru_rusak_ringan=0 AND wc_guru_rusak_sedang=0 AND wc_guru_rusak_berat=0
	  AND wc_siswa_rusak_ringan=0 AND wc_siswa_rusak_sedang=0 AND wc_siswa_rusak_berat=0
	  AND wc_umum_rusak_ringan=0 AND wc_umum_rusak_sedang=0 AND wc_umum_rusak_berat=0
	  AND laboratorium_bahasa_rusak_ringan=0 AND laboratorium_bahasa_rusak_sedang=0 AND laboratorium_bahasa_rusak_berat=0
	  AND laboratorium_ipa_rusak_ringan=0 AND laboratorium_ipa_rusak_sedang=0 AND laboratorium_ipa_rusak_berat=0
	  AND laboratorium_ips_rusak_ringan=0 AND laboratorium_ips_rusak_sedang=0 AND laboratorium_ips_rusak_berat=0
	  AND laboratorium_komputer_rusak_ringan=0 AND laboratorium_komputer_rusak_sedang=0 AND laboratorium_komputer_rusak_berat=0
	  AND laboratorium_multimedia_rusak_ringan=0 AND laboratorium_multimedia_rusak_sedang=0 AND laboratorium_multimedia_rusak_berat=0
	  AND ruang_bina_rusak_ringan=0 AND ruang_bina_rusak_sedang=0 AND ruang_bina_rusak_berat=0
	  AND ruang_guru_rusak_ringan=0 AND ruang_guru_rusak_sedang=0 AND ruang_guru_rusak_berat=0
	  AND ruang_kepala_sekolah_rusak_ringan=0 AND ruang_kepala_sekolah_rusak_sedang=0 AND ruang_kepala_sekolah_rusak_berat=0
	  AND ruang_perpustakaan_rusak_ringan=0 AND ruang_perpustakaan_rusak_sedang=0 AND ruang_perpustakaan_rusak_berat=0
	  AND ruang_kelas_rusak_ringan=0 AND ruang_kelas_rusak_sedang=0 AND ruang_kelas_rusak_berat=0");
} else if ($filtermedia == "ringan"){
	$sqlx = ("SELECT * FROM tbl_api_dispendik p LEFT JOIN detail_persetujuan_pupr q ON p.npsn=q.npsn
      WHERE p.npsn=q.npsn AND
      asrama_siswa_rusak_ringan>0
		OR tempat_ibadah_rusak_ringan>0 AND  p.npsn=q.npsn
		OR wc_guru_rusak_ringan>0 AND  p.npsn=q.npsn
		OR wc_siswa_rusak_ringan>0 AND  p.npsn=q.npsn
		OR wc_umum_rusak_ringan>0 AND  p.npsn=q.npsn
		OR laboratorium_bahasa_rusak_ringan>0 AND  p.npsn=q.npsn
		OR laboratorium_ipa_rusak_ringan>0 AND  p.npsn=q.npsn
		OR laboratorium_ips_rusak_ringan>0 AND  p.npsn=q.npsn
		OR laboratorium_komputer_rusak_ringan>0 AND  p.npsn=q.npsn
		OR laboratorium_multimedia_rusak_ringan>0 AND  p.npsn=q.npsn
		OR ruang_bina_rusak_ringan>0 AND  p.npsn=q.npsn
		OR ruang_guru_rusak_ringan>0 AND  p.npsn=q.npsn
		OR ruang_kepala_sekolah_rusak_ringan>0 AND  p.npsn=q.npsn
		OR ruang_perpustakaan_rusak_ringan>0 AND  p.npsn=q.npsn
		OR ruang_kelas_rusak_ringan>0 AND  p.npsn=q.npsn");	
} else if ($filtermedia == "sedang"){
	$sqlx = ("SELECT *
	FROM tbl_api_dispendik p LEFT JOIN detail_persetujuan_pupr q ON p.npsn=q.npsn
	WHERE  p.npsn=q.npsn AND
	asrama_siswa_rusak_sedang>0
	  OR tempat_ibadah_rusak_sedang>0 AND  p.npsn=q.npsn
	  OR wc_guru_rusak_sedang>0 AND  p.npsn=q.npsn
	  OR wc_siswa_rusak_sedang>0 AND  p.npsn=q.npsn
	  OR wc_umum_rusak_sedang>0 AND  p.npsn=q.npsn
	  OR laboratorium_bahasa_rusak_sedang>0 AND  p.npsn=q.npsn
	  OR laboratorium_ipa_rusak_sedang>0 AND  p.npsn=q.npsn
	  OR laboratorium_ips_rusak_sedang>0 AND  p.npsn=q.npsn
	  OR laboratorium_komputer_rusak_sedang>0 AND  p.npsn=q.npsn
	  OR laboratorium_multimedia_rusak_sedang>0 AND  p.npsn=q.npsn
	  OR ruang_bina_rusak_sedang>0 AND  p.npsn=q.npsn
	  OR ruang_guru_rusak_sedang>0 AND  p.npsn=q.npsn
	  OR ruang_kepala_sekolah_rusak_sedang>0 AND  p.npsn=q.npsn
	  OR ruang_perpustakaan_rusak_sedang>0 AND  p.npsn=q.npsn
	  OR ruang_kelas_rusak_sedang>0 AND  p.npsn=q.npsn");
} else if ($filtermedia == "berat"){
	$sqlx = ("SELECT *
	FROM tbl_api_dispendik p LEFT JOIN detail_persetujuan_pupr q ON p.npsn=q.npsn
	WHERE p.npsn=q.npsn AND
	asrama_siswa_rusak_berat>0
	  OR tempat_ibadah_rusak_berat>0 AND  p.npsn=q.npsn
	  OR wc_guru_rusak_berat>0 AND  p.npsn=q.npsn
	  OR wc_siswa_rusak_berat>0 AND  p.npsn=q.npsn
	  OR wc_umum_rusak_berat>0 AND  p.npsn=q.npsn
	  OR laboratorium_bahasa_rusak_berat>0 AND  p.npsn=q.npsn
	  OR laboratorium_ipa_rusak_berat>0 AND  p.npsn=q.npsn
	  OR laboratorium_ips_rusak_berat>0 AND  p.npsn=q.npsn
	  OR laboratorium_komputer_rusak_berat>0 AND  p.npsn=q.npsn
	  OR laboratorium_multimedia_rusak_berat>0 AND  p.npsn=q.npsn
	  OR ruang_bina_rusak_berat>0 AND  p.npsn=q.npsn
	  OR ruang_guru_rusak_berat>0 AND  p.npsn=q.npsn
	  OR ruang_kepala_sekolah_rusak_berat>0 AND  p.npsn=q.npsn
	  OR ruang_perpustakaan_rusak_berat>0 AND  p.npsn=q.npsn
	  OR ruang_kelas_rusak_berat>0 AND  p.npsn=q.npsn");	
}

$result = mysqli_query($dbconn,$sqlx);
$data = array();
$no=0;
while($sm=mysqli_fetch_array($result)){
	$no++;	 	

	$npsn = $sm['npsn'];
	if (substr($sm['nama'],0,53) == "UNIT PELAKSANA TEKNIS DAERAH (UPTD) SATUAN PENDIDIKAN"){
		$nminstansi = substr($sm['nama'],54);
	} else {
		$nminstansi = $sm['nama'];
	}

	$qri = ("SELECT npsn FROM detail_persetujuan_pupr WHERE npsn='" . $npsn . "'");
	$dbquery = mysqli_query($dbconn, $qri);//$c = mysqli_fetch_assoc($dbquery);
	$jumlah = mysqli_num_rows($dbquery);
	if ($jumlah > 0){$statussetuju = "DISETUJUI";} else {$statussetuju = "";}

	$koordinat = $sm['lintang'].",".$sm['bujur'];
	if ($filtermedia == "baik" OR $filtermedia == "semua"){
		$kelas = $sm['ruang_kelas_baik'];$perpustakaan = $sm['ruang_perpustakaan_baik'];$kepsek = $sm['ruang_kepala_sekolah_baik'];
		$guru = $sm['ruang_guru_baik'];$bina = $sm['ruang_bina_baik'];$multimedia = $sm['laboratorium_multimedia_baik'];
		$komputer = $sm['laboratorium_komputer_baik'];$ips = $sm['laboratorium_ips_baik'];$ipa = $sm['laboratorium_ipa_baik'];
		$bahasa = $sm['laboratorium_bahasa_baik'];$wcumum = $sm['wc_umum_baik'];$wcsiswa = $sm['wc_siswa_baik'];
		$wcguru = $sm['wc_guru_baik'];$ibadah = $sm['tempat_ibadah_baik'];$asrama = $sm['asrama_siswa_baik'];
		$jmltotal = $kelas + $perpustakaan + $kepsek + $guru + $bina + $multimedia + $komputer + $ips +
		$ipa + $bahasa + $wcumum + $wcsiswa + $wcguru + $ibadah + $asrama;
	} else if ($filtermedia == "ringan"){
		$kelas = $sm['ruang_kelas_rusak_ringan'];$perpustakaan = $sm['ruang_perpustakaan_rusak_ringan'];$kepsek = $sm['ruang_kepala_sekolah_rusak_ringan'];
		$guru = $sm['ruang_guru_rusak_ringan'];$bina = $sm['ruang_bina_rusak_ringan'];$multimedia = $sm['laboratorium_multimedia_rusak_ringan'];
		$komputer = $sm['laboratorium_komputer_rusak_ringan'];$ips = $sm['laboratorium_ips_rusak_ringan'];$ipa = $sm['laboratorium_ipa_rusak_ringan'];
		$bahasa = $sm['laboratorium_bahasa_rusak_ringan'];$wcumum = $sm['wc_umum_rusak_ringan'];$wcsiswa = $sm['wc_siswa_rusak_ringan'];
		$wcguru = $sm['wc_guru_rusak_ringan'];$ibadah = $sm['tempat_ibadah_rusak_ringan'];$asrama = $sm['asrama_siswa_rusak_ringan'];
		$jmltotal = $kelas + $perpustakaan + $kepsek + $guru + $bina + $multimedia + $komputer + $ips +
		$ipa + $bahasa + $wcumum + $wcsiswa + $wcguru + $ibadah + $asrama;
	} else if ($filtermedia == "sedang"){
		$kelas = $sm['ruang_kelas_rusak_sedang'];$perpustakaan = $sm['ruang_perpustakaan_rusak_sedang'];$kepsek = $sm['ruang_kepala_sekolah_rusak_sedang'];
		$guru = $sm['ruang_guru_rusak_sedang'];$bina = $sm['ruang_bina_rusak_sedang'];$multimedia = $sm['laboratorium_multimedia_rusak_sedang'];
		$komputer = $sm['laboratorium_komputer_rusak_sedang'];$ips = $sm['laboratorium_ips_rusak_sedang'];$ipa = $sm['laboratorium_ipa_rusak_sedang'];
		$bahasa = $sm['laboratorium_bahasa_rusak_sedang'];$wcumum = $sm['wc_umum_rusak_sedang'];$wcsiswa = $sm['wc_siswa_rusak_sedang'];
		$wcguru = $sm['wc_guru_rusak_sedang'];$ibadah = $sm['tempat_ibadah_rusak_sedang'];$asrama = $sm['asrama_siswa_rusak_sedang'];
		$jmltotal = $kelas + $perpustakaan + $kepsek + $guru + $bina + $multimedia + $komputer + $ips +
		$ipa + $bahasa + $wcumum + $wcsiswa + $wcguru + $ibadah + $asrama;
	} else if ($filtermedia == "berat"){
		$kelas = $sm['ruang_kelas_rusak_berat'];$perpustakaan = $sm['ruang_perpustakaan_rusak_berat'];$kepsek = $sm['ruang_kepala_sekolah_rusak_berat'];
		$guru = $sm['ruang_guru_rusak_berat'];$bina = $sm['ruang_bina_rusak_berat'];$multimedia = $sm['laboratorium_multimedia_rusak_berat'];
		$komputer = $sm['laboratorium_komputer_rusak_berat'];$ips = $sm['laboratorium_ips_rusak_berat'];$ipa = $sm['laboratorium_ipa_rusak_berat'];
		$bahasa = $sm['laboratorium_bahasa_rusak_berat'];$wcumum = $sm['wc_umum_rusak_berat'];$wcsiswa = $sm['wc_siswa_rusak_berat'];
		$wcguru = $sm['wc_guru_rusak_berat'];$ibadah = $sm['tempat_ibadah_rusak_berat'];$asrama = $sm['asrama_siswa_rusak_berat'];
		$jmltotal = $kelas + $perpustakaan + $kepsek + $guru + $bina + $multimedia + $komputer + $ips +
		$ipa + $bahasa + $wcumum + $wcsiswa + $wcguru + $ibadah + $asrama;
	}

	$row_array = array();
	$row_array['id']=$sm['id'];$row_array['mdid']=md5($sm['id']);
	$row_array['npsn']=$sm['npsn'];
	$row_array['nminstansi']=$nminstansi;
	$row_array['koordinat']=floatval($sm['lintang']).",".floatval($sm['bujur']);
	$row_array['kelas']=$kelas;
	$row_array['perpustakaan']=$perpustakaan;
	$row_array['kepsek']=$kepsek;
	$row_array['guru']=$guru;
	$row_array['pembinaan']=$bina;
	$row_array['multimedia']=$multimedia;
	$row_array['komputer']=$komputer;
	$row_array['ips']=$ips;
	$row_array['ipa']=$ipa;
	$row_array['bahasa']=$bahasa;
	$row_array['wcumum']=$wcumum;
	$row_array['wcsiswa']=$wcsiswa;
	$row_array['wcguru']=$wcguru;
	$row_array['ibadah']=$ibadah;
	$row_array['asrama']=$asrama;
	$row_array['jmltotal']=$jmltotal;
	$row_array['statussetuju']=$statussetuju;	
	array_push($data,$row_array);
}
echo json_encode($data);
$result->close();
$dbconn->close();
?>  
