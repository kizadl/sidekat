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
	
	$idjam = anti_injection(trim($_POST['idjam']));
	$kode = strtoupper(anti_injection(trim($_POST['kode'])));
	$nmmapel = anti_injection(trim($_POST['nmmapel']));
	$jam = anti_injection(trim($_POST['jam']));	
	$bentuk = strtoupper(anti_injection(trim($_POST['bentuk'])));

	$pesanError = array();
	if (trim($idjam)=="") {
		$pesanError[] = "ID Mata Pelajaran Tidak Terdeteksi";		
	}
	if (trim($kode)=="") {
		$pesanError[] = "Kode Mata Pelajaran Tidak Terdeteksi";		
	}
	if (trim($nmmapel)=="") {
		$pesanError[] = "Nama Mata Pelajaran Tidak Terdeteksi";		
	}
	if (trim($jam)=="") {
		$pesanError[] = "Jumlah Jam Tidak Terdeteksi";		
	}	
	if (trim($bentuk)=="") {
		$pesanError[] = "Bentuk Pendidikan Tidak Terdeteksi";		
	}	
	if (count($pesanError)>=1 ){
			foreach ($pesanError as $indeks=>$pesan_tampil) { 
				$errMsg .="$pesan_tampil\n";	
				$status = 'err_val';
			} 
	}else{	

		$sql2  = "UPDATE m_jam_mapel set id_mapel='$kode',mata_pelajaran='$nmmapel',jumlah_jam='$jam',bentuk_pendidikan='$bentuk' WHERE id_jam='".$idjam."'";
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
