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

	$idunsur = trim($_POST['idunsur']);
	$soal = anti_injection(trim($_POST['soal']));
	$TP = anti_injection(trim($_POST['TP']));$KP = anti_injection(trim($_POST['KP']));
	$P = anti_injection(trim($_POST['P']));$SP = anti_injection(trim($_POST['SP']));
	
	$sqlX = ("SELECT id_unsur FROM ikm_soal_standart WHERE id_unsur='".$idunsur."'");			
	$resultx = mysqli_query($dbconn,$sqlX);$r= mysqli_fetch_assoc($resultx);
	
	$pesanError = array();
	if ($r['id_unsur']==$idunsur) {
		$pesanError[] = "Unsur soal terdeteksi sudah ada\nInput data unsur soal tidak boleh sama";	
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
		
		$qrid = ("SELECT max(id_soal) as idmaks FROM ikm_soal_standart");
		$restcari = mysqli_query($dbconn,$qrid);$s= mysqli_fetch_assoc($restcari);
		$idnesoal = $s['idmaks']+1;
		
		$sql2  = "INSERT INTO ikm_soal_standart (id_soal,id_unsur,soal,tidak_puas,kurang_puas,puas,sangat_puas) VALUES ('$idnesoal','$idunsur','$soal','$TP','$KP','$P','$SP')";
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
	
	mysqli_free_result($res);mysqli_free_result($resultx);mysqli_free_result($restcari);
	mysqli_close($dbconn);
?>
