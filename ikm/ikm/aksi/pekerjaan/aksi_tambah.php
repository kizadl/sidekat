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

	$idinstansi = trim($_POST['idinstansi']);
	$pekerjaan = anti_injection(trim($_POST['pekerjaan']));
	
	$sqlX = ("SELECT pekerjaan FROM ikm_m_pekerjaan WHERE pekerjaan='".$pekerjaan."'");			
	$resultx = mysqli_query($dbconn,$sqlX);$r= mysqli_fetch_assoc($resultx);
	
	$pesanError = array();
	if (strtolower($r['pekerjaan'])==strtolower($pekerjaan)) {
		$pesanError[] = $pekerjaan." terdeteksi sudah ada\nInput pekerjaan tidak boleh sama";	
	}		
	if (trim($pekerjaan)=="") {
		$pesanError[] = "Pekerjaan Tidak Terdeteksi";		
	}
	if (count($pesanError)>=1 ){
			foreach ($pesanError as $indeks=>$pesan_tampil) { 
				$errMsg .="$pesan_tampil\n";	
				$status = 'err_val';
			} 
	}else{	
		$sql2  = "INSERT INTO ikm_m_pekerjaan (pekerjaan) VALUES ('$pekerjaan')";
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
	mysqli_free_result($resultx);
	mysqli_close($dbconn);
?>
