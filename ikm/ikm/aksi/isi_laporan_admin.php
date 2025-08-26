<?php
error_reporting(0);
include '../../services/config.php';
$dbconn = mysqli_connect($dbhost,$dbuser,$dbpass,$dbname)or die('Could not connect: '); 
date_default_timezone_set('Asia/Jakarta');

$tglawal =trim($_POST['tglawal']);
$tglakhir = trim($_POST['tglakhir']);
$tglawal = date('Y-m-d', strtotime($tglawal));
$tglakhir = date('Y-m-d', strtotime($tglakhir));

$sql = ("SELECT COUNT(id_ikm) as jumikm FROM trans_ikm WHERE tgl_edit >= '".$tglawal."' AND tgl_edit <= '".$tglakhir."'");	
$resultcount = mysqli_query($dbconn,$sql);$row= mysqli_fetch_assoc($resultcount);	
if ($row['jumikm'] >= 1){
	$sqlx = ("SELECT SUM(jml_tp) AS jumTP,SUM(jml_kp) AS jumKP,SUM(jml_p) AS jumP,SUM(jml_sp) AS jumSP,SUM(jml_soal) AS jumTotal
		FROM trans_ikm WHERE tgl_edit >= '".$tglawal."' AND tgl_edit <= '".$tglakhir."'");			
	$resultx = mysqli_query($dbconn,$sqlx);$t= mysqli_fetch_assoc($resultx);
	
	$perTP=round($t['jumTP']/$t['jumTotal']*100,1);
	$perKP=round($t['jumKP']/$t['jumTotal']*100,1);
	$perP=round($t['jumP']/$t['jumTotal']*100,1);
	$perSP=round($t['jumSP']/$t['jumTotal']*100,1);
	
	$jumTP= number_format($t['jumTP'],0,',','.');
	$jumKP= number_format($t['jumKP'],0,',','.');
	$jumP= number_format($t['jumP'],0,',','.');
	$jumSP= number_format($t['jumSP'],0,',','.');
	$jumTotal= number_format($t['jumTotal'],0,',','.');
	
} else if ($row['jumikm'] <= 0){
	$perTP=0;$perKP=0;$perP=0;$perSP=0;
	$jumTP=0;$jumKP=0;$jumP=0;$jumSP=0;$jumTotal=0;
}

$data = array();

	$row_array = array();
	$row_array['jumTP']= $jumTP;
	$row_array['jumKP']= $jumKP;
	$row_array['jumP']= $jumP;
	$row_array['jumSP']= $jumSP;
	$row_array['jumTotal']= $jumTotal;
	
	$row_array['perTP']=$perTP;$row_array['perKP']=$perKP;$row_array['perP']=$perP;$row_array['perSP']=$perSP;
	array_push($data,$row_array);
echo json_encode($data);

$resultx->close();$resultcount->close();
$dbconn->close();
?>  
