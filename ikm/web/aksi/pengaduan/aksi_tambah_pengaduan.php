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

	$nik = anti_injection(trim($_POST['nik']));
	$nama = anti_injection(strtoupper(trim($_POST['nama'])));
	$alamat = anti_injection(trim($_POST['alamat']));
	$telepon = anti_injection(trim($_POST['telepon']));
	$uraian = anti_injection(trim($_POST['uraian']));

	$lokasi_akta    = $_FILES['upFoto']['tmp_name'];

	$pesanError = array();
	if (trim($nik)=="") {
		$pesanError[] = "Data NIK Tidak Terdeteksi";		
	}
	if (trim($nama)=="") {
		$pesanError[] = "Data Nama Tidak Terdeteksi";		
	}
	if (trim($alamat)=="") {
		$pesanError[] = "Data Alamat Tidak Terdeteksi";		
	}
	if (trim($telepon)=="") {
		$pesanError[] = "Data telepom tidak boleh kosong";		
	}	
	if (trim($uraian)=="") {
		$pesanError[] = "Data uraian permasalahan tidak boleh kosong";		
	}	
	if (count($pesanError)>=1 ){
			foreach ($pesanError as $indeks=>$pesan_tampil) { 
				$errMsg .="$pesan_tampil\n";	
				$status = 'err_val';
			} 
	}else{	

		$sql2  = "INSERT INTO pengaduan (nik,nm_pengadu,alamat,no_telepon,uraian_masalah,tanggal,jam,stts_pengaduan) 
				VALUES ('$nik','$nama','$alamat','$telepon','$uraian',CURDATE(),CURTIME(),'belum')";
		$res=mysqli_query($dbconn,$sql2);

		$qri = ("SELECT MAX(id_pengaduan) AS idnepengaduan FROM pengaduan ORDER BY id_pengaduan DESC");
		$dbquery = mysqli_query($dbconn,$qri);$c= mysqli_fetch_assoc($dbquery);
		$idnepengaduan = md5($c['idnepengaduan']);

		if(!is_dir("../../../data-pengaduan"))
		mkdir("../../../data-pengaduan",0777,true); 
		$path1 = "../../../data-pengaduan/".$idnepengaduan.".png";	
		
		if (!($lokasi_akta)==''){
			move_uploaded_file($lokasi_akta, $path1);
		}

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
	mysqli_free_result($resultx);mysqli_free_result($dbquery);
	mysqli_close($dbconn);
?>
