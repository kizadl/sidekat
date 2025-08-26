<?php
error_reporting(0);
include '../../services/config.php';
$dbconn = mysqli_connect($dbhost,$dbuser,$dbpass,$dbname)or die('Could not connect: '); 
date_default_timezone_set('Asia/Jakarta');

$tglserver = date("Y-m-d");

$sql = ("SELECT count(id_ikm) as jumikm FROM trans_ikm WHERE tgl_edit='".$tglserver."'");	
$resultcount = mysqli_query($dbconn,$sql);$row= mysqli_fetch_assoc($resultcount);	
if ($row['jumikm'] >= 1){
	$sqlx = ("SELECT SUM(jml_tp) AS jumTP,SUM(jml_kp) AS jumKP,SUM(jml_p) AS jumP,SUM(jml_sp) AS jumSP,SUM(jml_soal) AS jumTotal
		FROM trans_ikm WHERE tgl_edit='".$tglserver."'");			
	$result = mysqli_query($dbconn,$sqlx);$t= mysqli_fetch_assoc($result);
	
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

$sqlthn = ("SELECT count(id_ikm) as jumikm FROM trans_ikm WHERE tgl_edit <= NOW() AND tgl_edit >= DATE_ADD(NOW(),INTERVAL - 12 MONTH)");	
$resultthn = mysqli_query($dbconn,$sqlthn);$rthn= mysqli_fetch_assoc($resultthn);
if ($rthn['jumikm'] >= 1){
	$sqlx2 = ("SELECT SUM(jml_tp) AS jumtottp,SUM(jml_kp) AS jumtotkp,SUM(jml_p) AS jumtotp,SUM(jml_sp) AS jumtotsp,SUM(jml_soal) AS jumtotTotal 
		FROM trans_ikm WHERE tgl_edit <= NOW() AND tgl_edit >= DATE_ADD(NOW(),INTERVAL - 12 MONTH)");			
	$resultx = mysqli_query($dbconn,$sqlx2);$p= mysqli_fetch_assoc($resultx);
	
	$perTotTP=round($p['jumtottp']/$p['jumtotTotal']*100,1);
	$perTotKP=round($p['jumtotkp']/$p['jumtotTotal']*100,1);
	$perTotP=round($p['jumtotp']/$p['jumtotTotal']*100,1);
	$perTotSP=round($p['jumtotsp']/$p['jumtotTotal']*100,1);
	
	$jumtottp= number_format($p['jumtottp'],0,',','.');
	$jumtotkp= number_format($p['jumtotkp'],0,',','.');
	$jumtotp= number_format($p['jumtotp'],0,',','.');
	$jumtotsp= number_format($p['jumtotsp'],0,',','.');
	$jumtotTotal= number_format($p['jumtotTotal'],0,',','.');
	
} else if ($rthn['jumikm'] <= 0){
	$perTotTP=0;$perTotKP=0;$perTotP=0;$perTotSP=0;
	$jumtottp=0;$jumtotkp=0;$jumtotp=0;$jumtotsp=0;$jumtotTotal=0;
}


$data = array();

	$row_array = array();
	$row_array['jumTP']= $jumTP;
	$row_array['jumKP']= $jumKP;
	$row_array['jumP']= $jumP;
	$row_array['jumSP']= $jumSP;
	$row_array['jumTotal']= $jumTotal;

	$row_array['jumtottp']= $jumtottp;
	$row_array['jumtotkp']= $jumtotkp;
	$row_array['jumtotp']= $jumtotp;
	$row_array['jumtotsp']= $jumtotsp;
	$row_array['jumtotTotal']= $jumtotTotal;
	
	$row_array['perTP']=$perTP;$row_array['perKP']=$perKP;$row_array['perP']=$perP;$row_array['perSP']=$perSP;
	$row_array['perTotTP']=$perTotTP;$row_array['perTotKP']=$perTotKP;$row_array['perTotP']=$perTotP;$row_array['perTotSP']=$perTotSP;
	array_push($data,$row_array);
echo json_encode($data);

$result->close();$resultx->close();$resultcount->close();$resultthn->close();
$dbconn->close();
?>  
