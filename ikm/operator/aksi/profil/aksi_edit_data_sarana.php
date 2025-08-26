<?php
error_reporting(0);
require_once '../../../services/config.php';
$dbconn = mysqli_connect($dbhost,$dbuser,$dbpass,$dbname)or die('Could not connect: ');

function anti_injection($data){
  global $dbconn;
  $filter = mysqli_real_escape_string($dbconn,stripslashes(strip_tags(htmlspecialchars($data,ENT_QUOTES))));
  return $filter;
}
date_default_timezone_set('Asia/Jakarta');
	
	$idsekolah = trim($_POST['idsekolah']);

	$kelasB = trim($_POST['kelasB']);$kelasRR = trim($_POST['kelasRR']);$kelasRS = trim($_POST['kelasRS']);$kelasRB = trim($_POST['kelasRB']);
	$perpustakaanB = trim($_POST['perpustakaanB']);$perpustakaanRR = trim($_POST['perpustakaanRR']);$perpustakaanRS = trim($_POST['perpustakaanRS']);$perpustakaanRB = trim($_POST['perpustakaanRB']);
	$kepsekB = trim($_POST['kepsekB']);$kepsekRR = trim($_POST['kepsekRR']);$kepsekRS = trim($_POST['kepsekRS']);$kepsekRB = trim($_POST['kepsekRB']);
	$guruB = trim($_POST['guruB']);$guruRR = trim($_POST['guruRR']);$guruRS = trim($_POST['guruRS']);$guruRB = trim($_POST['guruRB']);
	$binaB = trim($_POST['binaB']);$binaRR = trim($_POST['binaRR']);$binaRS = trim($_POST['binaRS']);$binaRB = trim($_POST['binaRB']);

	$multimediaB = trim($_POST['multimediaB']);$multimediaRR = trim($_POST['multimediaRR']);$multimediaRS = trim($_POST['multimediaRS']);$multimediaRB = trim($_POST['multimediaRB']);
	$komputerB = trim($_POST['komputerB']);$komputerRR = trim($_POST['komputerRR']);$komputerRS = trim($_POST['komputerRS']);$komputerRB = trim($_POST['komputerRB']);
	$IPSB = trim($_POST['IPSB']);$IPSRR = trim($_POST['IPSRR']);$IPSRS = trim($_POST['IPSRS']);$IPSRB = trim($_POST['IPSRB']);
	$IPAB = trim($_POST['IPAB']);$IPARR = trim($_POST['IPARR']);$IPARS = trim($_POST['IPARS']);$IPARB = trim($_POST['IPARB']);
	$bahasaB = trim($_POST['bahasaB']);$bahasaRR = trim($_POST['bahasaRR']);$bahasaRS = trim($_POST['bahasaRS']);$bahasaRB = trim($_POST['bahasaRB']);

	$wcumumsB = trim($_POST['wcumumsB']);$wcumumsRR = trim($_POST['wcumumsRR']);$wcumumsRS = trim($_POST['wcumumsRS']);$wcumumsRB = trim($_POST['wcumumsRB']);
	$wcsiswaB = trim($_POST['wcsiswaB']);$wcsiswaRR = trim($_POST['wcsiswaRR']);$wcsiswaRS = trim($_POST['wcsiswaRS']);$wcsiswaRB = trim($_POST['wcsiswaRB']);
	$wcguruB = trim($_POST['wcguruB']);$wcguruRR = trim($_POST['wcguruRR']);$wcguruRS = trim($_POST['wcguruRS']);$wcguruRB = trim($_POST['wcguruRB']);
	$ibadahB = trim($_POST['ibadahB']);$ibadahRR = trim($_POST['ibadahRR']);$ibadahRS = trim($_POST['ibadahRS']);$ibadahRB = trim($_POST['ibadahRB']);
	$asramaB = trim($_POST['asramaB']);$asramaRR = trim($_POST['asramaRR']);$asramaRS = trim($_POST['asramaRS']);$asramaRB = trim($_POST['asramaRB']);

	$jmlkelas = $kelasB + $kelasRR + $kelasRS + $kelasRB;
	$jmlperpustakaan = $perpustakaanB + $perpustakaanRR + $perpustakaanRS + $perpustakaanRB;
	$jmlkepsek = $kepsekB + $kepsekRR + $kepsekRS + $kepsekRB;
	$jmlguru = $guruB + $guruRR + $guruRS + $guruRB;
	$jmlbina = $binaB + $binaRR + $binaRS + $binaRB;

	$jmlmultimedia = $multimediaB + $multimediaRR + $multimediaRS + $multimediaRB;
	$jmlkomputer = $komputerB + $komputerRR + $komputerRS + $komputerRB;
	$jmlIPS = $IPSB + $IPSRR + $IPSRS + $IPSRB;
	$jmlIPA = $IPAB + $IPARR + $IPARS + $IPARB;
	$jmlbahasa = $bahasaB + $bahasaRR + $bahasaRS + $bahasaRB;

	$jmlwcumums = $wcumumsB + $wcumumsRR + $wcumumsRS + $wcumumsRB;
	$jmlwcsiswa = $wcsiswaB + $wcsiswaRR + $wcsiswaRS + $wcsiswaRB;
	$jmlwcguru = $wcguruB + $wcguruRR + $wcguruRS + $wcguruRB;
	$jmlibadah = $ibadahB + $ibadahRR + $ibadahRS + $ibadahRB;
	$jmlasrama = $asramaB + $asramaRR + $asramaRS + $asramaRB;

	$pesanError = array();
	if (trim($idsekolah)=="") {
		$pesanError[] = "Data Sekolah Tidak Terdeteksi !";		
	}	
	if (count($pesanError)>=1 ){
			foreach ($pesanError as $indeks=>$pesan_tampil) { 
				$errMsg .="$pesan_tampil\n";	
				$status = 'err_val';
			} 
	}else{	

		$sql2  = "UPDATE tbl_api_dispendik SET 
				jml_ruang_kelas='$jmlkelas',ruang_kelas_baik='$kelasB',ruang_kelas_rusak_ringan='$kelasRR',ruang_kelas_rusak_sedang='$kelasRS',ruang_kelas_rusak_berat='$kelasRB',
				jml_ruang_perpustakaan='$jmlperpustakaan',ruang_perpustakaan_baik='$perpustakaanB',ruang_perpustakaan_rusak_ringan='$perpustakaanRR',ruang_perpustakaan_rusak_sedang='$perpustakaanRS',ruang_perpustakaan_rusak_berat='$perpustakaanRB',
				jml_ruang_kepala_sekolah='$jmlkepsek',ruang_kepala_sekolah_baik='$kepsekB',ruang_kepala_sekolah_rusak_ringan='$kepsekRR',ruang_kepala_sekolah_rusak_sedang='$kepsekRS',ruang_kepala_sekolah_rusak_berat='$kepsekRB',
				jml_ruang_guru='$jmlguru',ruang_guru_baik='$guruB',ruang_guru_rusak_ringan='$guruRR',ruang_guru_rusak_sedang='$guruRS',ruang_guru_rusak_berat='$guruRB',
				jml_ruang_bina='$jmlbina',ruang_bina_baik='$binaB',ruang_bina_rusak_ringan='$binaRR',ruang_bina_rusak_sedang='$binaRS',ruang_bina_rusak_berat='$binaRB',

				jml_lab_multimedia='$jmlmultimedia',laboratorium_multimedia_baik='$multimediaB',laboratorium_multimedia_rusak_ringan='$multimediaRR',laboratorium_multimedia_rusak_sedang='$multimediaRS',laboratorium_multimedia_rusak_berat='$multimediaRB',
				jml_lab_komputer='$jmlkomputer',laboratorium_komputer_baik='$komputerB',laboratorium_komputer_rusak_ringan='$komputerRR',laboratorium_komputer_rusak_sedang='$komputerRS',laboratorium_komputer_rusak_berat='$komputerRB',
				jml_lab_ips='$jmlIPS',laboratorium_ips_baik='$IPSB',laboratorium_ips_rusak_ringan='$IPSRR',laboratorium_ips_rusak_sedang='$IPSRS',laboratorium_ips_rusak_berat='$IPSRB',
				jml_lab_ipa='$jmlIPA',laboratorium_ipa_baik='$IPAB',laboratorium_ipa_rusak_ringan='$IPARR',laboratorium_ipa_rusak_sedang='$IPARS',laboratorium_ipa_rusak_berat='$IPARB',
				jml_lab_bahasa='$jmlbahasa',laboratorium_bahasa_baik='$bahasaB',laboratorium_bahasa_rusak_ringan='$bahasaRR',laboratorium_bahasa_rusak_sedang='$bahasaRS',laboratorium_bahasa_rusak_berat='$bahasaRB',

				jml_wc_umum='$jmlwcumums',wc_umum_baik='$wcumumsB',wc_umum_rusak_ringan='$wcumumsRR',wc_umum_rusak_sedang='$wcumumsRS',wc_umum_rusak_berat='$wcumumsRB',
				jml_wc_siswa='$jmlwcsiswa',wc_siswa_baik='$wcsiswaB',wc_siswa_rusak_ringan='$wcsiswaRR',wc_siswa_rusak_sedang='$wcsiswaRS',wc_siswa_rusak_berat='$wcsiswaRB',
				jml_wc_guru='$jmlwcguru',wc_guru_baik='$wcguruB',wc_guru_rusak_ringan='$wcguruRR',wc_guru_rusak_sedang='$wcguruRS',wc_guru_rusak_berat='$wcguruRB',
				jml_tempat_ibadah='$jmlibadah',tempat_ibadah_baik='$ibadahB',tempat_ibadah_rusak_ringan='$ibadahRR',tempat_ibadah_rusak_sedang='$ibadahRS',tempat_ibadah_rusak_berat='$ibadahRB',
				jml_asrama='$jmlasrama',asrama_siswa_baik='$asramaB',asrama_siswa_rusak_ringan='$asramaRR',asrama_siswa_rusak_sedang='$asramaRS',asrama_siswa_rusak_berat='$asramaRB'
				WHERE id='".$idsekolah."'";
		$res=mysqli_query($dbconn,$sql2);			

		if($res){
			$errMsg .= "SUKSESS !!! Data sudah disimpan !!!";
			$status = 'ok';
		}else{
			$errMsg .= "GAGAL !!! Data tidak bisa disimpan !!!";
			$status = 'err';
		}
	}			
	$data = array('msg1'=>$errMsg,'msg2'=>$status);
	echo json_encode($data);
	
	mysqli_free_result($res);
	mysqli_close($dbconn);
	
?>
