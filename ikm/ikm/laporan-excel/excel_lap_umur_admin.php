<?php
header("Content-type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=Kelompok-umur.xls");
header("Cache-Control: no-cache, must-revalidate");
header("Expires: IKM"); 

error_reporting(0);
include '../../services/config.php';
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
			return "Januari";
			break;
		case 2:
			return "Februari";
			break;
		case 3:
			return "Maret";
			break;
		case 4:
			return "April";
			break;
		case 5:
			return "Mei";
			break;
		case 6:
			return "Juni";
			break;
		case 7:
			return "Juli";
			break;
		case 8:
			return "Agustus";
			break;
		case 9:
			return "September";
			break;
		case 10:
			return "Oktober";
			break;
		case 11:
			return "November";
			break;
		case 12:
			return "Desember";
			break;
	}
} 
$tanggal = tgl_indo(date("Y-m-d"));

$idinstansi =trim($_GET['idinstansi']);
$tglawal =trim($_GET['tglawal']);$tglakhir =trim($_GET['tglakhir']);
$tglawal = date('Y-m-d', strtotime($tglawal));
$tglakhir = date('Y-m-d', strtotime($tglakhir));

$tanggalawal = tgl_indo($tglawal);
$tanggalakhir = tgl_indo($tglakhir);

$qriserver = ("SELECT nm_instansi FROM m_instansi WHERE id_instansi='".$idinstansi."'");
$dbserver = mysqli_query($dbconn,$qriserver);$s= mysqli_fetch_assoc($dbserver);
$nminstansi = strtoupper($s['nm_instansi']);
?>
REKAPITULASI SURVEI - KELOMPOK UMUR<br>
<?php echo $nminstansi;?><br>
<?php echo $tanggalawal;?> s/d <?php echo $tanggalakhir;?>

                 <table>
				  <thead>	  
                    <tr>
					  <th rowspan=2 style="background:#222;color:#fff;height:25px;width:450px"><center>Kelompok Umur</center></th>	
					  <th colspan=2 style="background:#444;color:#fff;height:25px;"><center>Rekap</center></th>	
                    </tr>
                    <tr>
					  <th style="background:#555;color:#fff;height:25px;width:70px"><center>Jumlah</center></th>
					  <th style="background:#666;color:#fff;height:25px;width:70px"><center>%</center></th>
					</tr>
				  </thead>
				  <tbody>
<?php
$sqltot = ("SELECT COUNT(id_ikm) AS jumTotal FROM trans_ikm WHERE tgl_edit >= '".$tglawal."' AND tgl_edit <= '".$tglakhir."'");			
$resultTot = mysqli_query($dbconn,$sqltot);$b= mysqli_fetch_assoc($resultTot);
$totalIKM=$b['jumTotal'];
	
$sql = ("SELECT p.umur,COUNT(p.id_ikm) AS totIKM FROM trans_ikm p
		WHERE p.tgl_edit >= '".$tglawal."' AND p.tgl_edit <= '".$tglakhir."'
		GROUP BY p.umur ORDER BY p.umur ASC");		
		$result = mysqli_query($dbconn,$sql);
$no=0;$Totpersen=0;
$Tot40bawah=0;$Tot40atas=0;//untuk umur
while($t=mysqli_fetch_array($result)){
	$no++;
	$sqlx = ("SELECT COUNT(id_ikm) AS jumIKM,COUNT(IF(umur <=40,0,null)) AS jum40Bawah,COUNT(IF(umur >=41,0,null)) AS jum40Atas FROM trans_ikm WHERE umur='".$t['umur']."' AND tgl_edit >= '".$tglawal."' AND tgl_edit <= '".$tglakhir."'");			
	$resultX = mysqli_query($dbconn,$sqlx);$p= mysqli_fetch_assoc($resultX);
	$umur=$t['umur'];
	$total=$t['totIKM'];
	
	$jumlah=$p['jumIKM'];
	$persen=round(($p['jumIKM']/$totalIKM)*100,2);
	$Totpersen = $Totpersen + ($p['jumIKM']/$totalIKM)*100;

	$Tot40bawah = $Tot40bawah + $p['jum40Bawah'];
	$Tot40atas = $Tot40atas + $p['jum40Atas'];
echo "	
	<tr style='height:25px;'>
        <td align='left' style='vertical-align:middle;border: 1px dotted #999;padding: 30px 15px;'>
			$umur thn
		</td>
        <td align='center' style='vertical-align:middle;border: 1px dotted #999;padding: 3px 5px;'>
			$jumlah
		</td>
        <td align='center' style='vertical-align:middle;border: 1px dotted #999;padding: 3px 5px;'>
			$persen %
		</td>	
	</tr>";
} 
$jmltotal = number_format($totalIKM,0,',','.');	
$Totpersen=round($Totpersen,2);

$JumTot40bawah = number_format($Tot40bawah,0,',','.');$Totpersen40bawah=round(($Tot40bawah/$totalIKM)*100,2);
$JumTot40atas = number_format($Tot40atas,0,',','.');$Totpersen40atas=round(($Tot40atas/$totalIKM)*100,2);	
echo "	
	<tr style='height:25px;'>
       <td align='center' style='vertical-align:middle;'>
			&nbsp;
		</td>	
        <td align='center' style='vertical-align:middle;border: 1px dotted #999;padding: 3px 5px;background:#F5F5DC;'>
			<b>$jmltotal</b>
		</td>
		<td align='center' style='vertical-align:middle;border: 1px dotted #999;padding: 3px 5px;background:#F5F5DC;'>
			$Totpersen &nbsp;%
		</td>		
	</tr>
	";	
mysqli_free_result($resultTot);mysqli_free_result($result);mysqli_free_result($resultX);mysqli_free_result($dbserver);
mysqli_close($dbconn); 
?>  
				  </tbody>
                  </table>				  
<br>
                 <table>
				  <thead>	  
                    <tr>
					  <th style="background:#222;color:#fff;height:25px;width:450px"><center>Rekapitulasi Kelompok Umur</center></th>
					  <th style="background:#222;color:#fff;height:25px;width:70px"><center>&nbsp;Jumlah&nbsp;</center></th>
					  <th style="background:#222;color:#fff;height:25px;width:70px"><center>%</center></th>
					</tr>
				  </thead>
				  <tbody>
				  
	<tr style='height:25px;'>
        <td align='left' style='vertical-align:middle;border: 1px dotted #999;padding: 15px 15px;'>
			Kelompok umur s/d 40 tahun
		</td>
        <td align='center' style='vertical-align:middle;border: 1px dotted #999;padding: 3px 5px;'>
			<?php echo $JumTot40bawah;?>
		</td>
        <td align='center' style='vertical-align:middle;border: 1px dotted #999;padding: 3px 5px;'>
			<?php echo $Totpersen40bawah;?> %
		</td>	
	</tr>				  				  
	<tr style='height:25px;'>
        <td align='left' style='vertical-align:middle;border: 1px dotted #999;padding: 15px 15px;'>
			Kelompok umur lebih dari 40 tahun
		</td>
        <td align='center' style='vertical-align:middle;border: 1px dotted #999;padding: 3px 5px;'>
			<?php echo $JumTot40atas;?>
		</td>
        <td align='center' style='vertical-align:middle;border: 1px dotted #999;padding: 3px 5px;'>
			<?php echo $Totpersen40atas;?> %
		</td>	
	</tr>				  				  
				  </tbody>
                  </table>				  