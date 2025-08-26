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

	$idsekolah = anti_injection(trim($_POST['idsekolah']));
	$nmsekolah = strtoupper(anti_injection(trim($_POST['nmsekolah'])));
	$lintang = anti_injection(trim($_POST['lintang']));$bujur = anti_injection(trim($_POST['bujur']));
	$npsn = strtoupper(anti_injection(trim($_POST['npsn'])));
	$jmlsiswa = anti_injection(trim($_POST['jmlsiswa']));$jmlguru = anti_injection(trim($_POST['jmlguru']));
	
	$tingkat = anti_injection(trim($_POST['tingkat']));
	$statussekolah = strtoupper(anti_injection(trim($_POST['statussekolah'])));
	$akreditasi = anti_injection(trim($_POST['akreditasi']));

	$alamat = anti_injection(trim($_POST['alamat']));
	$rt = anti_injection(trim($_POST['rt']));$rw = anti_injection(trim($_POST['rw']));
	$dusun = anti_injection(trim($_POST['dusun']));

	$idkecamatan = anti_injection(trim($_POST['idkecamatan']));$iddesa = anti_injection(trim($_POST['iddesa']));
	$nmkecamatan = anti_injection(trim($_POST['nmkecamatan']));$nmdesa = anti_injection(trim($_POST['nmdesa']));

	$pesanError = array();
	if (trim($idsekolah)=="") {
		$pesanError[] = "Data Sekolah Tidak Terdeteksi !";		
	}	
	if (trim($nmsekolah)=="") {
		$pesanError[] = "Nama Sekolah Tidak Terdeteksi";		
	}
	if (trim($lintang)=="" OR trim($bujur)=="") {
		$pesanError[] = "Data Koordinat Tidak Terdeteksi";		
	}
	if (trim($npsn)=="") {
		$pesanError[] = "Data NPSN Tidak Terdeteksi";		
	}
	if (trim($jmlsiswa)=="") {
		$pesanError[] = "Jumlah Siswa Tidak Terdeteksi";		
	}
	if (trim($jmlguru)=="") {
		$pesanError[] = "Jumlah Guru Tidak Terdeteksi";		
	}
	if (trim($tingkat)=="") {
		$pesanError[] = "Tingkat Pendidikan Tidak Terdeteksi";		
	}
	if (trim($statussekolah)=="") {
		$pesanError[] = "Status Sekolah Tidak Terdeteksi";		
	}
	if (trim($akreditasi)=="") {
		$pesanError[] = "Data Akreditasi Tidak Terdeteksi";		
	}
	if (trim($alamat)=="" OR  trim($rt)=="" OR trim($rw)=="" ) {
		$pesanError[] = "Data Alamat Tidak Terdeteksi";		
	}
	if (trim($dusun)=="") {
		$pesanError[] = "Data Dusun Tidak Terdeteksi";		
	}
	if (trim($idkecamatan)=="") {
		$pesanError[] = "Data Kecamatan Tidak Terdeteksi";		
	}
	if (trim($iddesa)=="") {
		$pesanError[] = "Data Desa / Kelurahan Tidak Terdeteksi";		
	}

	if (count($pesanError)>=1 ){
			foreach ($pesanError as $indeks=>$pesan_tampil) { 
				$errMsg .="$pesan_tampil\n";	
				$status = 'err_val';
			} 
	}else{	

		$sql2  = "UPDATE tbl_api_dispendik set npsn='$npsn',nama='$nmsekolah',siswa='$jmlsiswa',guru='$jmlguru',bentuk_pendidikan='$tingkat',alamat_jalan='$alamat',
				rt='$rt',rw='$rw',nama_dusun='$dusun',desa_kelurahan='$nmdesa',kecamatan='$nmkecamatan',lintang='$lintang',bujur='$bujur',status_sekolah='$statussekolah',
				akreditasi='$akreditasi',id_kecamatan='$idkecamatan',id_desa='$iddesa'
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
