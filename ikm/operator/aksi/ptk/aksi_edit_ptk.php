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
	$idptk = anti_injection(trim($_POST['idptk']));
	$sttsmengajar = anti_injection(trim($_POST['sttsmengajar']));
	$idmapel = anti_injection(trim($_POST['idmapel']));
	$nmmapel = anti_injection(trim($_POST['nmmapel']));
	$tglsk =trim($_POST['tglsk']);$tglsk = date('Y-m-d', strtotime($tglsk));
	$nosk = strtoupper(anti_injection(trim($_POST['nosk'])));

	$lokasi_akta    = $_FILES['upSKE']['tmp_name'];

	$pesanError = array();
	if (trim($idsekolah)=="") {
		$pesanError[] = "Data Sekolah Tidak Terdeteksi !";		
	}	
	if (trim($idptk)=="") {
		$pesanError[] = "Data PTK Tidak Terdeteksi";		
	}
	if (trim($sttsmengajar)=="") {
		$pesanError[] = "Status Mengajar Tidak Terdeteksi";		
	}
	if (trim($idmapel)=="" OR trim($nmmapel)=="") {
		$pesanError[] = "Data Mata Pelajaran Tidak Terdeteksi";		
	}
	if (trim($tglsk)=="") {
		$pesanError[] = "Data Tanggal SK Tidak Terdeteksi";		
	}
	if (trim($nosk)=="") {
		$pesanError[] = "Nomor SK Tidak Terdeteksi";		
	}
	if (count($pesanError)>=1 ){
			foreach ($pesanError as $indeks=>$pesan_tampil) { 
				$errMsg .="$pesan_tampil\n";	
				$status = 'err_val';
			} 
	}else{	

		$sql2  = "UPDATE spm_ptk SET status_guru='$sttsmengajar',id_mapel_diampu='$idmapel',mapel_diampu='$nmmapel',sk_mengajar='$nosk',tgl_sk_mengajar='$tglsk'
				WHERE id_ptk='".$idptk."'";
		$res=mysqli_query($dbconn,$sql2);			

		$mdsekolah = md5($idsekolah);
		$mdptk = md5($idptk);

		if(!is_dir("../../../data-sk/".$mdsekolah))
		mkdir("../../../data-sk/".$mdsekolah,0777,true); 
		$path1 = "../../../data-sk/".$mdsekolah."/".$mdptk.".pdf";	

		if (!($lokasi_akta)==''){
			move_uploaded_file($lokasi_akta, $path1);
		}

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
