<?php
error_reporting(0);
include '../services/config.php';
$dbconn = mysqli_connect($dbhost,$dbuser,$dbpass,$dbname)or die('Could not connect: '); 
 
$sql=("SELECT p.nm_tempat,p.alamat,p.pemilik,p.diskripsi,p.jenis,p.koordinat,q.nama_kecamatan 
		FROM m_tempat p LEFT JOIN m_kecamatan q ON p.id_kecamatan=q.id_kecamatan WHERE p.koordinat is not null");
$result = mysqli_query($dbconn,$sql);	
$data=array();
while($t=mysqli_fetch_array($result)) {
	$nmtempat = $t['nm_tempat'];
	$alamat = $t['alamat'];
	$pemilik = $t['pemilik'];
	$diskripsi = $t['diskripsi'];
	$jenis = $t['jenis'];
	$koordinat = $t['koordinat'];
	$kecamatan = $t['nama_kecamatan'];
	
	$row_array=array();
	$row_array['nmtempat']=$nmtempat;	
	$row_array['alamat']=$alamat;	
	$row_array['pemilik']=$pemilik;	
	$row_array['diskripsi']=$diskripsi;	
	$row_array['jenis']=$jenis;	
	$row_array['koordinat']=$koordinat;	
	$row_array['kecamatan']=$kecamatan;	
	array_push($data, $row_array);
}$result->close();

echo json_encode($data);
$dbconn->close();
 ?>