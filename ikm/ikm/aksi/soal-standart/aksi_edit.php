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

	$idsoal = trim($_POST['idsoal']);$idunsur = trim($_POST['idunsur']);
	$soal = anti_injection(trim($_POST['soal']));
	$TP = anti_injection(trim($_POST['TP']));$KP = anti_injection(trim($_POST['KP']));
	$P = anti_injection(trim($_POST['P']));$SP = anti_injection(trim($_POST['SP']));
	
	$pesanError = array();	
	if (trim($idsoal)=="") {
		$pesanError[] = "Soal tidak terdeteksi";		
	}	
	if (trim($idunsur)=="") {
		$pesanError[] = "Unsur penilaian masih kosong";		
	}
	if (trim($soal)=="") {
		$pesanError[] = "Soal masih kosong";		
	}
	if (trim($TP)=="") {
		$pesanError[] = "Skor tidak puas masih kosong";		
	}
	if (trim($KP)=="") {
		$pesanError[] = "Skor kurang puas masih kosong";		
	}
	if (trim($P)=="") {
		$pesanError[] = "Skor puas masih kosong";		
	}
	if (trim($SP)=="") {
		$pesanError[] = "Skor sangat puas masih kosong";		
	}	
	if (count($pesanError)>=1 ){
			foreach ($pesanError as $indeks=>$pesan_tampil) { 
				$errMsg .="$pesan_tampil\n";	
				$status = 'err_val';
			} 
	}else{			
		$sql2  = "UPDATE ikm_soal_standart SET id_unsur='$idunsur',soal='$soal',tidak_puas='$TP',kurang_puas='$KP',puas='$P',sangat_puas='$SP' WHERE id_soal='".$idsoal."'";
				$res=mysqli_query($dbconn,$sql2);	
				
		if($res){
			$errMsg = "SUKSESS !!! Data sudah disimpan !!!";
			$status = 'ok';
		}else{
			$errMsg = "GAGAL !!! Data tidak bisa disimpan !!!";
			$status = 'err';
		}
	}			
	$data = array('msg1'=>$errMsg,'msg2'=>$status);
	echo json_encode($data);
	
	mysqli_free_result($res);
	mysqli_close($dbconn);
?>
