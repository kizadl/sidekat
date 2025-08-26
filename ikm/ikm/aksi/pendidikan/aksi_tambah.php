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
	$pendidikan = strtoupper(anti_injection(trim($_POST['pendidikan'])));
	
	$sqlX = ("SELECT pendidikan FROM ikm_m_pendidikan WHERE pendidikan='".$pendidikan."'");			
	$resultx = mysqli_query($dbconn,$sqlX);$r= mysqli_fetch_assoc($resultx);
	
	$pesanError = array();
	if ($r['pendidikan']==$pendidikan) {
		$pesanError[] = $pendidikan." terdeteksi sudah ada\nInput pendidikan tidak boleh sama";	
	}		
	if (trim($pendidikan)=="") {
		$pesanError[] = "Pendidikan Tidak Terdeteksi";		
	}
	if (count($pesanError)>=1 ){
			foreach ($pesanError as $indeks=>$pesan_tampil) { 
				$errMsg .="$pesan_tampil\n";	
				$status = 'err_val';
			} 
	}else{	
		$sql2  = "INSERT INTO ikm_m_pendidikan (pendidikan) VALUES ('$pendidikan')";
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
