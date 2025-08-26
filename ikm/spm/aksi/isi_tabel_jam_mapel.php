<?php
error_reporting(0);
include '../../services/config.php';
$dbconn = mysqli_connect($dbhost,$dbuser,$dbpass,$dbname)or die('Could not connect: '); 

$sqlx = ("SELECT p.id_jam,p.id_mapel,p.mata_pelajaran,p.jumlah_jam,p.bentuk_pendidikan FROM m_jam_mapel p WHERE p.aktif='Y' ORDER BY p.bentuk_pendidikan,p.id_mapel ASC");			
$result = mysqli_query($dbconn,$sqlx);
$data = array();
$no=0;
while($t=mysqli_fetch_array($result)){
	$no++;	 	

	$row_array = array();
	$row_array['no']=$no;
	$row_array['idjam']=$t['id_jam'];$row_array['idmapel']=$t['id_mapel'];
	$row_array['matapelajaran']=$t['mata_pelajaran'];
	$row_array['jumlahjam']=$t['jumlah_jam'];
	$row_array['bentukpendidikan']=$t['bentuk_pendidikan'];	
	
	array_push($data,$row_array);
}
echo json_encode($data);
$result->close();
$dbconn->close();
?>  
