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
	
	$kode = strtoupper(anti_injection(trim($_POST['kode'])));
	$nmmapel = anti_injection(trim($_POST['nmmapel']));
	$jumlahsiswa = anti_injection(trim($_POST['jumlahsiswa']));	
	$maxsiswaperrombel = strtoupper(anti_injection(trim($_POST['maxsiswaperrombel'])));

	$pesanError = array();
	if (trim($kode)=="") {
		$pesanError[] = "Kode Mata Pelajaran Tidak Terdeteksi";		
	}
	if (trim($nmmapel)=="") {
		$pesanError[] = "Nama Mata Pelajaran Tidak Terdeteksi";		
	}
	if (trim($jumlahsiswa)=="") {
		$pesanError[] = "Jumlah Siswa Setara 24 Jam Tidak Terdeteksi";		
	}	
	if (trim($maxsiswaperrombel)=="") {
		$pesanError[] = "Jumlah Siswa Maximum Per Rombel Tidak Terdeteksi";		
	}	
	if (count($pesanError)>=1 ){
			foreach ($pesanError as $indeks=>$pesan_tampil) { 
				$errMsg .="$pesan_tampil\n";	
				$status = 'err_val';
			} 
	}else{	

		$sql2  = "UPDATE m_jam_bk set id_mapel='$kode',mata_pelajaran='$nmmapel',jumlah_siswa='$jumlahsiswa',minimal_siswa_rombel='$maxsiswaperrombel' WHERE id_jam='1'";
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
	mysqli_free_result($resultx);
	mysqli_close($dbconn);
?>
