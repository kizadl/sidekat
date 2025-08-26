<?php
error_reporting(0);
include '../../services/config.php';
$dbconn = mysqli_connect($dbhost,$dbuser,$dbpass,$dbname)or die('Could not connect: '); 
date_default_timezone_set('Asia/Jakarta');

$tglawal =trim($_POST['tglawal']);
$tglakhir = trim($_POST['tglakhir']);
$tglawal = date('Y-m-d', strtotime($tglawal));
$tglakhir = date('Y-m-d', strtotime($tglakhir));

$sqlx = ("SELECT p.nama,p.umur,p.kelamin,p.n1,p.n2,p.n3,p.n4,p.n5,p.n6,p.n7,p.n8,p.n9,p.jml_skor,q.pendidikan as nmpendidikan,r.pekerjaan as nmpekerjaan
		FROM trans_ikm p LEFT JOIN ikm_m_pendidikan q ON p.id_pendidikan=q.id_pendidikan
		LEFT JOIN ikm_m_pekerjaan r ON p.id_pekerjaan=r.id_pekerjaan
		WHERE p.tgl_edit >= '".$tglawal."' AND p.tgl_edit <= '".$tglakhir."'
		ORDER BY p.id_ikm DESC");
$result = mysqli_query($dbconn,$sqlx);
$data = array();
$no=0;
while($t=mysqli_fetch_array($result)){
  $no++;
  $row_array = array();
  $row_array['no']=$no;
  $row_array['nama']=$t['nama'];$row_array['umur']=$t['umur'];$row_array['kelamin']=$t['kelamin'];
  $row_array['nmpendidikan']=$t['nmpendidikan'];$row_array['nmpekerjaan']=$t['nmpekerjaan'];
  $row_array['n1']=$t['n1'];$row_array['n2']=$t['n2'];$row_array['n3']=$t['n3'];$row_array['n4']=$t['n4'];$row_array['n5']=$t['n5'];
  $row_array['n6']=$t['n6'];$row_array['n7']=$t['n7'];$row_array['n8']=$t['n8'];$row_array['n9']=$t['n9'];
  $row_array['jmlskor']=$t['jml_skor'];
  array_push($data,$row_array);
}
echo json_encode($data);
$result->close();
$dbconn->close();
?>  
