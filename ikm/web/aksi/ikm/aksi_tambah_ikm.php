<?php
error_reporting(0);
require_once '../../../services/config.php';
$dbconn = mysqli_connect($dbhost,$dbuser,$dbpass,$dbname)or die('Could not connect: ');

function anti_injection($data){
  global $dbconn;
  $filter = mysqli_real_escape_string($dbconn,stripslashes(strip_tags(htmlspecialchars($data,ENT_QUOTES))));
  return $filter;
}

	$tanggal = trim($_POST['tanggal']);$tanggal = date('Y-m-d', strtotime($tanggal));
	$nama =strtoupper(trim($_POST['nama']));$kelamin =trim($_POST['kelamin']);$umur =trim($_POST['umur']);
	$idpendidikan =trim($_POST['idpendidikan']);$idpekerjaan =trim($_POST['idpekerjaan']);
	
	$jwb1 =strtoupper(trim($_POST['jwb1']));$jwb2 =strtoupper(trim($_POST['jwb2']));$jwb3 =strtoupper(trim($_POST['jwb3']));
	$jwb4 =strtoupper(trim($_POST['jwb4']));$jwb5 =strtoupper(trim($_POST['jwb5']));$jwb6 =strtoupper(trim($_POST['jwb6']));
	$jwb7 =strtoupper(trim($_POST['jwb7']));$jwb8 =strtoupper(trim($_POST['jwb8']));$jwb9 =strtoupper(trim($_POST['jwb9']));
	
	$nilai1 =trim($_POST['nilai1']);$nilai2 =trim($_POST['nilai2']);$nilai3 =trim($_POST['nilai3']);
	$nilai4 =trim($_POST['nilai4']);$nilai5 =trim($_POST['nilai5']);$nilai6 =trim($_POST['nilai6']);
	$nilai7 =trim($_POST['nilai7']);$nilai8 =trim($_POST['nilai8']);$nilai9 =trim($_POST['nilai9']);

	$jumsoal =trim($_POST['jumsoal']);
	$totnilai =trim($_POST['totnilai']);
	$saran = anti_injection(trim($_POST['saran']));
	if ($saran == ""){$ketsaran="N";}else{$ketsaran="Y";}
	
	if ($jwb1=="TIDAK PUAS"){$jmlTP1 = 1;}else{$jmlTP1 = 0;}
	if ($jwb2=="TIDAK PUAS"){$jmlTP2 = 1;}else{$jmlTP2 = 0;}
	if ($jwb3=="TIDAK PUAS"){$jmlTP3 = 1;}else{$jmlTP3 = 0;}
	if ($jwb4=="TIDAK PUAS"){$jmlTP4 = 1;}else{$jmlTP4 = 0;}
	if ($jwb5=="TIDAK PUAS"){$jmlTP5 = 1;}else{$jmlTP5 = 0;}
	if ($jwb6=="TIDAK PUAS"){$jmlTP6 = 1;}else{$jmlTP6 = 0;}
	if ($jwb7=="TIDAK PUAS"){$jmlTP7 = 1;}else{$jmlTP7 = 0;}
	if ($jwb8=="TIDAK PUAS"){$jmlTP8 = 1;}else{$jmlTP8 = 0;}
	if ($jwb9=="TIDAK PUAS"){$jmlTP9 = 1;}else{$jmlTP9 = 0;}
	$jumtidakpuas = $jmlTP1 + $jmlTP2 + $jmlTP3 + $jmlTP4 + $jmlTP5 + $jmlTP6 + $jmlTP7 + $jmlTP8 + $jmlTP9;	
	
	if ($jwb1=="KURANG PUAS"){$jmlKP1 = 1;}else{$jmlKP1 = 0;}
	if ($jwb2=="KURANG PUAS"){$jmlKP2 = 1;}else{$jmlKP2 = 0;}
	if ($jwb3=="KURANG PUAS"){$jmlKP3 = 1;}else{$jmlKP3 = 0;}
	if ($jwb4=="KURANG PUAS"){$jmlKP4 = 1;}else{$jmlKP4 = 0;}
	if ($jwb5=="KURANG PUAS"){$jmlKP5 = 1;}else{$jmlKP5 = 0;}
	if ($jwb6=="KURANG PUAS"){$jmlKP6 = 1;}else{$jmlKP6 = 0;}
	if ($jwb7=="KURANG PUAS"){$jmlKP7 = 1;}else{$jmlKP7 = 0;}
	if ($jwb8=="KURANG PUAS"){$jmlKP8 = 1;}else{$jmlKP8 = 0;}
	if ($jwb9=="KURANG PUAS"){$jmlKP9 = 1;}else{$jmlKP9 = 0;}
	$jumkurangpuas = $jmlKP1 + $jmlKP2 + $jmlKP3 + $jmlKP4 + $jmlKP5 + $jmlKP6 + $jmlKP7 + $jmlKP8 + $jmlKP9;
	
	if ($jwb1=="PUAS"){$jmlP1 = 1;}else{$jmlP1 = 0;}
	if ($jwb2=="PUAS"){$jmlP2 = 1;}else{$jmlP2 = 0;}
	if ($jwb3=="PUAS"){$jmlP3 = 1;}else{$jmlP3 = 0;}
	if ($jwb4=="PUAS"){$jmlP4 = 1;}else{$jmlP4 = 0;}
	if ($jwb5=="PUAS"){$jmlP5 = 1;}else{$jmlP5 = 0;}
	if ($jwb6=="PUAS"){$jmlP6 = 1;}else{$jmlP6 = 0;}
	if ($jwb7=="PUAS"){$jmlP7 = 1;}else{$jmlP7 = 0;}
	if ($jwb8=="PUAS"){$jmlP8 = 1;}else{$jmlP8 = 0;}
	if ($jwb9=="PUAS"){$jmlP9 = 1;}else{$jmlP9 = 0;}
	$jumpuas = $jmlP1 + $jmlP2 + $jmlP3 + $jmlP4 + $jmlP5 + $jmlP6 + $jmlP7 + $jmlP8 + $jmlP9;

	if ($jwb1=="SANGAT PUAS"){$jmlSP1 = 1;}else{$jmlSP1 = 0;}
	if ($jwb2=="SANGAT PUAS"){$jmlSP2 = 1;}else{$jmlSP2 = 0;}
	if ($jwb3=="SANGAT PUAS"){$jmlSP3 = 1;}else{$jmlSP3 = 0;}
	if ($jwb4=="SANGAT PUAS"){$jmlSP4 = 1;}else{$jmlSP4 = 0;}
	if ($jwb5=="SANGAT PUAS"){$jmlSP5 = 1;}else{$jmlSP5 = 0;}
	if ($jwb6=="SANGAT PUAS"){$jmlSP6 = 1;}else{$jmlSP6 = 0;}
	if ($jwb7=="SANGAT PUAS"){$jmlSP7 = 1;}else{$jmlSP7 = 0;}
	if ($jwb8=="SANGAT PUAS"){$jmlSP8 = 1;}else{$jmlSP8 = 0;}
	if ($jwb9=="SANGAT PUAS"){$jmlSP9 = 1;}else{$jmlSP9 = 0;}
	$jumsangatpuas = $jmlSP1 + $jmlSP2 + $jmlSP3 + $jmlSP4 + $jmlSP5 + $jmlSP6 + $jmlSP7 + $jmlSP8 + $jmlSP9;
	
	$pesanError = array();
	if (trim($nama)=="") {
		$pesanError[] = "Data <b>Nama</b> Tidak Terdeteksi !";		
	}
	if (trim($kelamin)=="") {
		$pesanError[] = "Data <b>Kelamin</b> tidak boleh kosong !";		
	}
	if (trim($umur)=="") {
		$pesanError[] = "Data <b>umur</b> tidak boleh kosong !";		
	}	
	if (trim($idpendidikan)=="") {
		$pesanError[] = "Data <b>Pendidikan</b> tidak boleh kosong !";		
	}
	if (trim($idpekerjaan)=="") {
		$pesanError[] = "Data <b>Pekerjaan</b> tidak boleh kosong !";		
	}	
	
	if (trim($jwb1)=="") {
		$pesanError[] = "Data <b>Jawab</b> tidak boleh kosong !";		
	}	
	if (trim($jwb2)=="") {
		$pesanError[] = "Data <b>Jawab</b> tidak boleh kosong !";		
	}	
	if (trim($jwb3)=="") {
		$pesanError[] = "Data <b>Jawab</b> tidak boleh kosong !";		
	}
	if (trim($jwb4)=="") {
		$pesanError[] = "Data <b>Jawab</b> tidak boleh kosong !";		
	}
	if (trim($jwb5)=="") {
		$pesanError[] = "Data <b>Jawab</b> tidak boleh kosong !";		
	}
	if (trim($jwb6)=="") {
		$pesanError[] = "Data <b>Jawab</b> tidak boleh kosong !";		
	}
	if (trim($jwb7)=="") {
		$pesanError[] = "Data <b>Jawab</b> tidak boleh kosong !";		
	}
	if (trim($jwb8)=="") {
		$pesanError[] = "Data <b>Jawab</b> tidak boleh kosong !";		
	}
	if (trim($jwb9)=="") {
		$pesanError[] = "Data <b>Jawab</b> tidak boleh kosong !";		
	}
	
	if (trim($nilai1)=="") {
		$pesanError[] = "Data <b>Nilai</b> tidak boleh kosong !";		
	}
	if (trim($nilai2)=="") {
		$pesanError[] = "Data <b>Nilai</b> tidak boleh kosong !";		
	}
	if (trim($nilai3)=="") {
		$pesanError[] = "Data <b>Nilai</b> tidak boleh kosong !";		
	}
	if (trim($nilai4)=="") {
		$pesanError[] = "Data <b>Nilai</b> tidak boleh kosong !";		
	}
	if (trim($nilai5)=="") {
		$pesanError[] = "Data <b>Nilai</b> tidak boleh kosong !";		
	}
	if (trim($nilai6)=="") {
		$pesanError[] = "Data <b>Nilai</b> tidak boleh kosong !";		
	}
	if (trim($nilai7)=="") {
		$pesanError[] = "Data <b>Nilai</b> tidak boleh kosong !";		
	}
	if (trim($nilai8)=="") {
		$pesanError[] = "Data <b>Nilai</b> tidak boleh kosong !";		
	}
	if (trim($nilai9)=="") {
		$pesanError[] = "Data <b>Nilai</b> tidak boleh kosong !";		
	}	
	if (count($pesanError)>=1 ){
			$noPesan=0;
			foreach ($pesanError as $indeks=>$pesan_tampil) { 
			$noPesan++;
				$errMsg .="&nbsp;&nbsp; $noPesan. $pesan_tampil<br>";	
				$status = 'err_val';
			} 
	}else{	
	
		$sql2  = "INSERT INTO trans_ikm (id_instansi,id_pendidikan,id_pekerjaan,nama,umur,kelamin,
				jwb_1,jwb_2,jwb_3,jwb_4,jwb_5,jwb_6,jwb_7,jwb_8,jwb_9,jml_soal,
				n1,n2,n3,n4,n5,n6,n7,n8,n9,jml_skor,jml_tp,jml_kp,jml_p,jml_sp,saran,ket_saran,tgl_edit,jam_edit)
				VALUES ('1','$idpendidikan','$idpekerjaan','$nama','$umur','$kelamin',
				'$jwb1','$jwb2','$jwb3','$jwb4','$jwb5','$jwb6','$jwb7','$jwb8','$jwb9','$jumsoal',
				'$nilai1','$nilai2','$nilai3','$nilai4','$nilai5','$nilai6','$nilai7','$nilai8','$nilai9','$totnilai','$jumtidakpuas','$jumkurangpuas','$jumpuas','$jumsangatpuas','$saran','$ketsaran','$tanggal',CURTIME())";
				$res=mysqli_query($dbconn,$sql2);

		if($res){
			$errMsg .= "<strong>Selamat!</strong> Data sukses tersimpan.";
			$status = 'ok';
		}else{
			$errMsg .= "<strong>Sorry!</strong> GAGAL !!! Data tidak bisa disimpan !!!";
			$status = 'err';
		}					
	}		
	
	$data = array('msg1'=>$errMsg,'msg2'=>$status);
	echo json_encode($data);
	
	mysqli_free_result($res);
	mysqli_close($dbconn);
?>
