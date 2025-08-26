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
	$nmoperator = strtoupper(anti_injection(trim($_POST['nmoperator'])));
	$alamat = anti_injection(trim($_POST['alamat']));
	$telepon = anti_injection(trim($_POST['telepon']));$telpkepsek = anti_injection(trim($_POST['telpkepsek']));
	$email = anti_injection(trim($_POST['email']));

	$pesanError = array();
	if (trim($idsekolah)=="") {
		$pesanError[] = "Data Sekolah Tidak Terdeteksi !";		
	}	
	if (trim($nmoperator)=="") {
		$pesanError[] = "Nama Operator Tidak Terdeteksi";		
	}
	if (trim($alamat)=="") {
		$pesanError[] = "Alamat Tidak Terdeteksi";		
	}
	if (trim($telepon)=="") {
		$pesanError[] = "No. Telepon Tidak Terdeteksi";		
	}
	if (trim($telpkepsek)=="") {
		$pesanError[] = "No. Telepon Kepala Sekolah Tidak Terdeteksi";		
	}
	if (trim($email)=="") {
		$pesanError[] = "Email Tidak Terdeteksi";		
	}
	if (count($pesanError)>=1 ){
			foreach ($pesanError as $indeks=>$pesan_tampil) { 
				$errMsg .="$pesan_tampil\n";	
				$status = 'err_val';
			} 
	}else{	

		$sql2  = "UPDATE m_operator SET nm_cp='$nmoperator',alamat_cp='$alamat',telepon_cp='$telepon',telepon_kepsek='$telpkepsek',email_cp='$email'
				WHERE id_instansi='".$idsekolah."'";
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
