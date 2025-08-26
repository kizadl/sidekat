<?php
error_reporting(0);
include '../../../services/config.php';
$dbconn = mysqli_connect($dbhost,$dbuser,$dbpass,$dbname)or die('Could not connect: '); 
date_default_timezone_set('Asia/Jakarta');
function tgl_indo($tgl){
	$tanggal = substr($tgl,8,2);
	$bulan = getBulan(substr($tgl,5,2));
	$tahun = substr($tgl,0,4);
	return $tanggal.' '.$bulan.' '.$tahun;		 
}

function getBulan($bln){
	switch ($bln){
		case 1: 
			return "Jan";
			break;
		case 2:
			return "Feb";
			break;
		case 3:
			return "Mar";
			break;
		case 4:
			return "Apr";
			break;
		case 5:
			return "Mei";
			break;
		case 6:
			return "Jun";
			break;
		case 7:
			return "Jul";
			break;
		case 8:
			return "Agu";
			break;
		case 9:
			return "Sep";
			break;
		case 10:
			return "Okt";
			break;
		case 11:
			return "Nov";
			break;
		case 12:
			return "Des";
			break;
	}
} 

$kata= trim($_POST['kata']);

$sqlx = ("SELECT p.id_pengaduan,p.nik,p.nm_pengadu,p.alamat,p.no_telepon,p.uraian_masalah,
p.tanggal,p.stts_pengaduan
FROM pengaduan p
WHERE p.nik = '".$kata."' AND p.aktif='Y'");			
$result = mysqli_query($dbconn,$sqlx);
$data = array();
$no=0;
while($sm=mysqli_fetch_array($result)){
	$no++;
	$idpengaduan = $sm['id_pengaduan'];
	$tanggal = tgl_indo($sm['tanggal']);
	$nik = $sm['nik'];
	$nmpengadu = $sm['nm_pengadu'];
    $alamat = $sm['alamat'];
	$notelepon = $sm['no_telepon'];
	$uraianmasalah = $sm['uraian_masalah'];
	$sttspengaduan = strtoupper($sm['stts_pengaduan']);
	
	$row_array = array();
	$row_array['no']=$no;
	$row_array['idpengaduan']=$idpengaduan;
	$row_array['tanggal']=$tanggal;
	$row_array['nik']=$nik;
	$row_array['nmpengadu']=$nmpengadu;
	$row_array['alamat']=$alamat;
	$row_array['alamat']=$alamat;
	$row_array['notelepon']=$notelepon;
	$row_array['uraianmasalah']=$uraianmasalah;
	$row_array['sttspengaduan']=$sttspengaduan;

	array_push($data,$row_array);
}
echo json_encode($data);
$result->close();
$dbconn->close();
?>  
