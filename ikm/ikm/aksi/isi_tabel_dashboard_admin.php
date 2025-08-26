<?php
error_reporting(0);
include '../../services/config.php';
$dbconn = mysqli_connect($dbhost,$dbuser,$dbpass,$dbname)or die('Could not connect: '); 

$sqlx = ("SELECT id_unsur,unsur FROM ikm_m_unsur ORDER BY id_unsur ASC");
$result = mysqli_query($dbconn,$sqlx);
$data = array();
$no=0;
$JumTotalTP = 0;$JumTP1 = 0;$JumTP2 = 0;$JumTP3 = 0;$JumTP4 = 0;$JumTP5 = 0;$JumTP6 = 0;$JumTP7 = 0;$JumTP8 = 0;$JumTP9 = 0;
$JumTotalKP = 0;$jumKP1 = 0;$jumKP2 = 0;$jumKP3 = 0;$jumKP4 = 0;$jumKP5 = 0;$jumKP6 = 0;$jumKP7 = 0;$jumKP8 = 0;$jumKP9 = 0;
$JumTotalP = 0;$jumP1 = 0;$jumP2 = 0;$jumP3 = 0;$jumP4 = 0;$jumP5 = 0;$jumP6 = 0;$jumP7 = 0;$jumP8 = 0;$jumP9 = 0;
$JumTotalSP = 0;$jumSP1 = 0;$jumSP2 = 0;$jumSP3 = 0;$jumSP4 = 0;$jumSP5 = 0;$jumSP6 = 0;$jumSP7 = 0;$jumSP8 = 0;$jumSP9 = 0;
$JumTotalIKM = 0;
while($t=mysqli_fetch_array($result)){
  $no++;
  $sql = ("SELECT count(id_ikm) as jumikm FROM trans_ikm WHERE tgl_edit <= NOW() AND tgl_edit >= DATE_ADD(NOW(),INTERVAL - 12 MONTH)");	
  $resultcount = mysqli_query($dbconn,$sql);$row= mysqli_fetch_assoc($resultcount);	
  if ($row['jumikm'] >= 1){
	if ($t['id_unsur']=="1"){
		$sqlCOUNT = ("SELECT count(if(jwb_1='TIDAK PUAS',0,null)) AS jumTP1,
			count(if(jwb_1='KURANG PUAS',0,null)) AS jumKP1,
			count(if(jwb_1='PUAS',0,null)) AS jumP1,
			count(if(jwb_1='SANGAT PUAS',0,null)) AS jumSP1,count(id_ikm) AS jumIKM
			FROM trans_ikm	
			WHERE tgl_edit <= NOW() AND tgl_edit >= DATE_ADD(NOW(),INTERVAL - 12 MONTH)");		
		$resultx1 = mysqli_query($dbconn,$sqlCOUNT);$p= mysqli_fetch_assoc($resultx1);
		$JumTP1=$p['jumTP1'];$jumKP1=$p['jumKP1'];$jumP1=$p['jumP1'];$jumSP1=$p['jumSP1'];$JumTotalIKM = $p['jumIKM'];	
		
		$JumTotalTP = round($JumTP1/$JumTotalIKM*100,1);
		$JumTotalKP = round($jumKP1/$JumTotalIKM*100,1);
		$JumTotalP = round($jumP1/$JumTotalIKM*100,1);
		$JumTotalSP = round($jumSP1/$JumTotalIKM*100,1);
	}
	if ($t['id_unsur']=="2"){
		$sqlCOUNT2 = ("SELECT count(if(jwb_2='TIDAK PUAS',0,null)) AS JumTP2,
			count(if(jwb_2='KURANG PUAS',0,null)) AS jumKP2,
			count(if(jwb_2='PUAS',0,null)) AS jumP2,
			count(if(jwb_2='SANGAT PUAS',0,null)) AS jumSP2,count(id_ikm) AS jumIKM
			FROM trans_ikm	
			WHERE tgl_edit <= NOW() AND tgl_edit >= DATE_ADD(NOW(),INTERVAL - 12 MONTH)");		
		$resultx2 = mysqli_query($dbconn,$sqlCOUNT2);$p= mysqli_fetch_assoc($resultx2);
		$JumTP2=$p['JumTP2'];$jumKP2=$p['jumKP2'];$jumP2=$p['jumP2'];$jumSP2=$p['jumSP2'];$JumTotalIKM = $p['jumIKM'];	
		
		$JumTotalTP = round($JumTP2/$JumTotalIKM*100,1);
		$JumTotalKP = round($jumKP2/$JumTotalIKM*100,1);
		$JumTotalP = round($jumP2/$JumTotalIKM*100,1);
		$JumTotalSP = round($jumSP2/$JumTotalIKM*100,1);		
	}
	if ($t['id_unsur']=="3"){
		$sqlCOUNT3 = ("SELECT count(if(jwb_3='TIDAK PUAS',0,null)) AS jumTP3,
			count(if(jwb_3='KURANG PUAS',0,null)) AS jumKP3,
			count(if(jwb_3='PUAS',0,null)) AS jumP3,
			count(if(jwb_3='SANGAT PUAS',0,null)) AS jumSP3,count(id_ikm) AS jumIKM
			FROM trans_ikm	
			WHERE tgl_edit <= NOW() AND tgl_edit >= DATE_ADD(NOW(),INTERVAL - 12 MONTH)");		
		$resultx3 = mysqli_query($dbconn,$sqlCOUNT3);$p= mysqli_fetch_assoc($resultx3);
		$JumTP3=$p['jumTP3'];$jumKP3=$p['jumKP3'];$jumP3=$p['jumP3'];$jumSP3=$p['jumSP3'];$JumTotalIKM = $p['jumIKM'];	
		
		$JumTotalTP = round($JumTP3/$JumTotalIKM*100,1);
		$JumTotalKP = round($jumKP3/$JumTotalIKM*100,1);
		$JumTotalP = round($jumP3/$JumTotalIKM*100,1);
		$JumTotalSP = round($jumSP3/$JumTotalIKM*100,1);		
	}
	if ($t['id_unsur']=="4"){
		$sqlCOUNT4 = ("SELECT count(if(jwb_4='TIDAK PUAS',0,null)) AS jumTP4,
			count(if(jwb_4='KURANG PUAS',0,null)) AS jumKP4,
			count(if(jwb_4='PUAS',0,null)) AS jumP4,
			count(if(jwb_4='SANGAT PUAS',0,null)) AS jumSP4,count(id_ikm) AS jumIKM
			FROM trans_ikm	
			WHERE tgl_edit <= NOW() AND tgl_edit >= DATE_ADD(NOW(),INTERVAL - 12 MONTH)");		
		$resultx4 = mysqli_query($dbconn,$sqlCOUNT4);$p= mysqli_fetch_assoc($resultx4);
		$JumTP4=$p['jumTP4'];$jumKP4=$p['jumKP4'];$jumP4=$p['jumP4'];$jumSP4=$p['jumSP4'];$JumTotalIKM = $p['jumIKM'];	
		
		$JumTotalTP = round($JumTP4/$JumTotalIKM*100,1);
		$JumTotalKP = round($jumKP4/$JumTotalIKM*100,1);
		$JumTotalP = round($jumP4/$JumTotalIKM*100,1);
		$JumTotalSP = round($jumSP4/$JumTotalIKM*100,1);			
	}
	if ($t['id_unsur']=="5"){
		$sqlCOUNT5 = ("SELECT count(if(jwb_5='TIDAK PUAS',0,null)) AS jumTP5,
			count(if(jwb_5='KURANG PUAS',0,null)) AS jumKP5,
			count(if(jwb_5='PUAS',0,null)) AS jumP5,
			count(if(jwb_5='SANGAT PUAS',0,null)) AS jumSP5,count(id_ikm) AS jumIKM
			FROM trans_ikm	
			WHERE tgl_edit <= NOW() AND tgl_edit >= DATE_ADD(NOW(),INTERVAL - 12 MONTH)");		
		$resultx5 = mysqli_query($dbconn,$sqlCOUNT5);$p= mysqli_fetch_assoc($resultx5);
		$JumTP5=$p['jumTP5'];$jumKP5=$p['jumKP5'];$jumP5=$p['jumP5'];$jumSP5=$p['jumSP5'];$JumTotalIKM = $p['jumIKM'];	
		
		$JumTotalTP = round($JumTP5/$JumTotalIKM*100,1);
		$JumTotalKP = round($jumKP5/$JumTotalIKM*100,1);
		$JumTotalP = round($jumP5/$JumTotalIKM*100,1);
		$JumTotalSP = round($jumSP5/$JumTotalIKM*100,1);			
	}
	if ($t['id_unsur']=="6"){
		$sqlCOUNT6 = ("SELECT count(if(jwb_6='TIDAK PUAS',0,null)) AS jumTP6,
			count(if(jwb_6='KURANG PUAS',0,null)) AS jumKP6,
			count(if(jwb_6='PUAS',0,null)) AS jumP6,
			count(if(jwb_6='SANGAT PUAS',0,null)) AS jumSP6,count(id_ikm) AS jumIKM
			FROM trans_ikm	
			WHERE tgl_edit <= NOW() AND tgl_edit >= DATE_ADD(NOW(),INTERVAL - 12 MONTH)");		
		$resultx6 = mysqli_query($dbconn,$sqlCOUNT6);$p= mysqli_fetch_assoc($resultx6);
		$JumTP6=$p['jumTP6'];$jumKP6=$p['jumKP6'];$jumP6=$p['jumP6'];$jumSP6=$p['jumSP6'];$JumTotalIKM = $p['jumIKM'];	
		
		$JumTotalTP = round($JumTP6/$JumTotalIKM*100,1);
		$JumTotalKP = round($jumKP6/$JumTotalIKM*100,1);
		$JumTotalP = round($jumP6/$JumTotalIKM*100,1);
		$JumTotalSP = round($jumSP6/$JumTotalIKM*100,1);			
	}
	if ($t['id_unsur']=="7"){
		$sqlCOUNT7 = ("SELECT count(if(jwb_7='TIDAK PUAS',0,null)) AS jumTP7,
			count(if(jwb_7='KURANG PUAS',0,null)) AS jumKP7,
			count(if(jwb_7='PUAS',0,null)) AS jumP7,
			count(if(jwb_7='SANGAT PUAS',0,null)) AS jumSP7,count(id_ikm) AS jumIKM
			FROM trans_ikm	
			WHERE tgl_edit <= NOW() AND tgl_edit >= DATE_ADD(NOW(),INTERVAL - 12 MONTH)");		
		$resultx7 = mysqli_query($dbconn,$sqlCOUNT7);$p= mysqli_fetch_assoc($resultx7);
		$JumTP7=$p['jumTP7'];$jumKP7=$p['jumKP7'];$jumP7=$p['jumP7'];$jumSP7=$p['jumSP7'];$JumTotalIKM = $p['jumIKM'];	
		
		$JumTotalTP = round($JumTP7/$JumTotalIKM*100,1);
		$JumTotalKP = round($jumKP7/$JumTotalIKM*100,1);
		$JumTotalP = round($jumP7/$JumTotalIKM*100,1);
		$JumTotalSP = round($jumSP7/$JumTotalIKM*100,1);			
	}
	if ($t['id_unsur']=="8"){
		$sqlCOUNT8 = ("SELECT count(if(jwb_8='TIDAK PUAS',0,null)) AS jumTP8,
			count(if(jwb_8='KURANG PUAS',0,null)) AS jumKP8,
			count(if(jwb_8='PUAS',0,null)) AS jumP8,
			count(if(jwb_8='SANGAT PUAS',0,null)) AS jumSP8,count(id_ikm) AS jumIKM
			FROM trans_ikm	
			WHERE tgl_edit <= NOW() AND tgl_edit >= DATE_ADD(NOW(),INTERVAL - 12 MONTH)");		
		$resultx8 = mysqli_query($dbconn,$sqlCOUNT8);$p= mysqli_fetch_assoc($resultx8);
		$JumTP8=$p['jumTP8'];$jumKP8=$p['jumKP8'];$jumP8=$p['jumP8'];$jumSP8=$p['jumSP8'];$JumTotalIKM = $p['jumIKM'];	
		
		$JumTotalTP = round($JumTP8/$JumTotalIKM*100,1);
		$JumTotalKP = round($jumKP8/$JumTotalIKM*100,1);
		$JumTotalP = round($jumP8/$JumTotalIKM*100,1);
		$JumTotalSP = round($jumSP8/$JumTotalIKM*100,1);				
	}
	if ($t['id_unsur']=="9"){
		$sqlCOUNT9 = ("SELECT count(if(jwb_9='TIDAK PUAS',0,null)) AS jumTP9,
			count(if(jwb_9='KURANG PUAS',0,null)) AS jumKP9,
			count(if(jwb_9='PUAS',0,null)) AS jumP9,
			count(if(jwb_9='SANGAT PUAS',0,null)) AS jumSP9,count(id_ikm) AS jumIKM
			FROM trans_ikm	
			WHERE tgl_edit <= NOW() AND tgl_edit >= DATE_ADD(NOW(),INTERVAL - 12 MONTH)");		
		$resultx9 = mysqli_query($dbconn,$sqlCOUNT9);$p= mysqli_fetch_assoc($resultx9);
		$JumTP9=$p['jumTP9'];$jumKP9=$p['jumKP9'];$jumP9=$p['jumP9'];$jumSP9=$p['jumSP9'];$JumTotalIKM = $p['jumIKM'];	
		
		$JumTotalTP = round($JumTP9/$JumTotalIKM*100,1);
		$JumTotalKP = round($jumKP9/$JumTotalIKM*100,1);
		$JumTotalP = round($jumP9/$JumTotalIKM*100,1);
		$JumTotalSP = round($jumSP9/$JumTotalIKM*100,1);		
	}
  }
  
  $row_array = array();
  $row_array['no']=$no;
  $row_array['unsur']=$t['unsur'];
  $row_array['idunsur']=$t['id_unsur'];
  $row_array['jumTP']=$JumTotalTP;$row_array['jumKP']=$JumTotalKP;$row_array['jumP']=$JumTotalP;$row_array['jumSP']=$JumTotalSP;
  array_push($data,$row_array);
}
echo json_encode($data);
$result->close();
$dbconn->close();
?>  
