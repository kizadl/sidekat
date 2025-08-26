<?php
header("Content-type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=Laporan-survei.xls");
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

<center>TABULASI DATA HASIL SURVEI KEPUASAN MASYARAKAT</center>
<center><?php echo $nminstansi;?></center>
<center><?php echo $tanggalawal;?> s/d <?php echo $tanggalakhir;?></center>

                 <table>
				  <thead>	  
                    <tr>
					  <th rowspan=2 style="background:#222;color:#fff;height:25px;width:50px"><center>&nbsp;&nbsp;No&nbsp;&nbsp;</center></th>
					  <th rowspan=2 style="background:#222;color:#fff;height:25px;width:200px"><center>Nama</center></th>	
					  <th rowspan=2 style="background:#222;color:#fff;height:25px;width:40px"><center>&nbsp;&nbsp;Umur&nbsp;&nbsp;</center></th>
					  <th rowspan=2 style="background:#222;color:#fff;height:25px;width:40px"><center>&nbsp;&nbsp;L/P&nbsp;&nbsp;</center></th>
					  <th rowspan=2 style="background:#222;color:#fff;height:25px;width:70px"><center>&nbsp;&nbsp;Pendidikan&nbsp;&nbsp;</center></th>
					  <th rowspan=2 style="background:#222;color:#fff;height:25px;width:180px"><center>Pekerjaan</center></th>

					  <th colspan=9 style="background:#666;color:#fff;height:25px;width:450px"><center>Nilai Unsur Pelayanan</center></th>	
					  <th rowspan=2 style="background:#222;color:#fff;height:25px;width:65px"><center>&nbsp;&nbsp;Jumlah&nbsp;&nbsp;</center></th>
                    </tr>
                    <tr>
					  <th style="background:#888;color:#fff;height:25px;width:50px"><center>&nbsp;&nbsp;&nbsp;&nbsp;U1&nbsp;&nbsp;&nbsp;&nbsp;</center></th>
					  <th style="background:#888;color:#fff;height:25px;width:50px"><center>&nbsp;&nbsp;&nbsp;&nbsp;U2&nbsp;&nbsp;&nbsp;&nbsp;</center></th>
					  <th style="background:#888;color:#fff;height:25px;width:50px"><center>&nbsp;&nbsp;&nbsp;&nbsp;U3&nbsp;&nbsp;&nbsp;&nbsp;</center></th>
					  <th style="background:#888;color:#fff;height:25px;width:50px"><center>&nbsp;&nbsp;&nbsp;&nbsp;U4&nbsp;&nbsp;&nbsp;&nbsp;</center></th>
					  <th style="background:#888;color:#fff;height:25px;width:50px"><center>&nbsp;&nbsp;&nbsp;&nbsp;U5&nbsp;&nbsp;&nbsp;&nbsp;</center></th>
					  <th style="background:#888;color:#fff;height:25px;width:50px"><center>&nbsp;&nbsp;&nbsp;&nbsp;U6&nbsp;&nbsp;&nbsp;&nbsp;</center></th>
					  <th style="background:#888;color:#fff;height:25px;width:50px"><center>&nbsp;&nbsp;&nbsp;&nbsp;U7&nbsp;&nbsp;&nbsp;&nbsp;</center></th>
					  <th style="background:#888;color:#fff;height:25px;width:50px"><center>&nbsp;&nbsp;&nbsp;&nbsp;U8&nbsp;&nbsp;&nbsp;&nbsp;</center></th>
					  <th style="background:#888;color:#fff;height:25px;width:50px"><center>&nbsp;&nbsp;&nbsp;&nbsp;U9&nbsp;&nbsp;&nbsp;&nbsp;</center></th>			  
					</tr>
				  </thead>
				  <tbody>
<?php
$sqlx = ("SELECT p.nama,p.umur,p.kelamin,p.n1,p.n2,p.n3,p.n4,p.n5,p.n6,p.n7,p.n8,p.n9,p.jml_skor,q.pendidikan as nmpendidikan,r.pekerjaan as nmpekerjaan
		FROM trans_ikm p LEFT JOIN ikm_m_pendidikan q ON p.id_pendidikan=q.id_pendidikan
		LEFT JOIN ikm_m_pekerjaan r ON p.id_pekerjaan=r.id_pekerjaan
		WHERE p.tgl_edit >= '".$tglawal."' AND p.tgl_edit <= '".$tglakhir."'
		ORDER BY p.id_ikm DESC");		

$result = mysqli_query($dbconn,$sqlx);
$no=0;$jmltotal=0;$jml1=0;$jml2=0;$jml3=0;$jml4=0;$jml5=0;$jml6=0;$jml7=0;$jml8=0;$jml9=0;
while($t=mysqli_fetch_array($result)){
$no++;
	$jmltotal=$jmltotal+$t['jml_skor'];
	$jml1=$jml1+$t['n1'];
	$jml2=$jml2+$t['n2'];
	$jml3=$jml3+$t['n3'];
	$jml4=$jml4+$t['n4'];
	$jml5=$jml5+$t['n5'];
	$jml6=$jml6+$t['n6'];
	$jml7=$jml7+$t['n7'];
	$jml8=$jml8+$t['n8'];
	$jml9=$jml9+$t['n9'];

	$nama=ucwords(strtolower($t['nama']));$umur=$t['umur'];$kelamin=$t['kelamin'];
	$nmpendidikan=$t['nmpendidikan'];$nmpekerjaan=$t['nmpekerjaan'];

	$n1=$t['n1'];$n2=$t['n2'];$n3=$t['n3'];$n4=$t['n4'];$n5=$t['n5'];$n6=$t['n6'];$n7=$t['n7'];$n8=$t['n8'];$n9=$t['n9'];
	$jmlskor=$t['jml_skor'];
	
echo "	
	<tr style='height:25px;'>
       <td align='center' style='vertical-align:middle;border: 1px dotted #999;padding: 3px 5px;'>
			$no
		</td>	
        <td align='left' style='vertical-align:middle;border: 1px dotted #999;padding: 3px 5px;'>
			$nama &nbsp;&nbsp;&nbsp;&nbsp;
		</td>
        <td align='center' style='vertical-align:middle;border: 1px dotted #999;padding: 3px 5px;'>
			$umur
		</td>
        <td align='center' style='vertical-align:middle;border: 1px dotted #999;padding: 3px 5px;'>
			$kelamin
		</td>	
        <td style='vertical-align:middle;border: 1px dotted #999;padding: 3px 5px;'>
			$nmpendidikan
		</td>
        <td style='vertical-align:middle;border: 1px dotted #999;padding: 3px 5px;'>
			$nmpekerjaan &nbsp;&nbsp;&nbsp;&nbsp;
		</td>
        <td align='center' style='vertical-align:middle;border: 1px dotted #999;padding: 3px 5px;'>
			$n1
		</td>
        <td align='center' style='vertical-align:middle;border: 1px dotted #999;padding: 3px 5px;'>
			$n2
		</td>
        <td align='center' style='vertical-align:middle;border: 1px dotted #999;padding: 3px 5px;'>
			$n3
		</td>
        <td align='center' style='vertical-align:middle;border: 1px dotted #999;padding: 3px 5px;'>
			$n4
		</td>
        <td align='center' style='vertical-align:middle;border: 1px dotted #999;padding: 3px 5px;'>
			$n5
		</td>
        <td align='center' style='vertical-align:middle;border: 1px dotted #999;padding: 3px 5px;'>
			$n6
		</td>
        <td align='center' style='vertical-align:middle;border: 1px dotted #999;padding: 3px 5px;'>
			$n7
		</td>
        <td align='center' style='vertical-align:middle;border: 1px dotted #999;padding: 3px 5px;'>
			$n8
		</td>
        <td align='center' style='vertical-align:middle;border: 1px dotted #999;padding: 3px 5px;'>
			$n9
		</td>
        <td align='center' style='vertical-align:middle;border: 1px dotted #999;padding: 3px 5px;'>
			<b>$jmlskor</b>
		</td>		
	</tr>";
} 
	
	$r1=round($jml1/$no,2);$r2=round($jml2/$no,2);$r3=round($jml3/$no,2);$r4=round($jml4/$no,2);
	$r5=round($jml5/$no,2);$r6=round($jml6/$no,2);$r7=round($jml7/$no,2);$r8=round($jml8/$no,2);$r9=round($jml9/$no,2);
	$rTotal=round(($jmltotal)/$no,2);//$rTotal=round(($jmltotal/9)/$no,2);
	
	$nrr1=round(($jml1/$no)*0.1111,2);$nrr2=round(($jml2/$no)*0.1111,2);$nrr3=round(($jml3/$no)*0.1111,2);$nrr4=round(($jml4/$no)*0.1111,2);
	$nrr5=round(($jml5/$no)*0.1111,2);$nrr6=round(($jml6/$no)*0.1111,2);$nrr7=round(($jml7/$no)*0.1111,2);$nrr8=round(($jml8/$no)*0.1111,2);$nrr9=round(($jml9/$no)*0.1111,2);
	$nrrTotal=round(($jmltotal/$no)*0.1111,2);

	$NilaiSKM=round(($jmltotal/$no)*0.1111,2);

	if ($NilaiSKM >= 1.00 AND $NilaiSKM <= 1.75){$tersebut = "D : TIDAK BAIK";}
	else if ($NilaiSKM >= 1.76 AND $NilaiSKM <= 2.50){$tersebut = "C : KURANG BAIK";}
	else if ($NilaiSKM >= 2.51 AND $NilaiSKM <= 3.25){$tersebut = "B : BAIK";}
	else if ($NilaiSKM >= 3.26 AND $NilaiSKM <= 4.00){$tersebut = "A : SANGAT BAIK";}
	
/*	if ($NilaiSKM >= 23.00 AND $NilaiSKM <= 43.75){$tersebut = "D : TIDAK BAIK";}
	else if ($NilaiSKM >= 43.76 AND $NilaiSKM <= 62.50){$tersebut = "C : KURANG BAIK";}
	else if ($NilaiSKM >= 62.51 AND $NilaiSKM <= 81.25){$tersebut = "B : BAIK";}
	else if ($NilaiSKM >= 81.26 AND $NilaiSKM <= 100.00){$tersebut = "A : SANGAT BAIK";}
*/	
	$jmltotal = number_format($jmltotal,0,',','.');	
	$jml1 = number_format($jml1,0,',','.');	
	$jml2 = number_format($jml2,0,',','.');	
	$jml3 = number_format($jml3,0,',','.');	
	$jml4 = number_format($jml4,0,',','.');	
	$jml5 = number_format($jml5,0,',','.');	
	$jml6 = number_format($jml6,0,',','.');	
	$jml7 = number_format($jml7,0,',','.');	
	$jml8 = number_format($jml8,0,',','.');	
	$jml9 = number_format($jml9,0,',','.');	
echo "	
	<tr style='height:25px;'>
       <td align='center' style='vertical-align:middle;'>
			&nbsp;
		</td>	
        <td align='center' style='vertical-align:middle;'>
			&nbsp;
		</td>
        <td align='center' style='vertical-align:middle;'>
			&nbsp;
		</td>
        <td style='vertical-align:middle;'>
			&nbsp;
		</td>
        <td align='center' style='vertical-align:middle;'>
			&nbsp;
		</td>		
        <td style='vertical-align:middle;'>
			Jumlah Nilai Unsur
		</td>
        <td align='center' style='vertical-align:middle;border: 1px dotted #999;padding: 3px 5px;background:#F5F5DC;'>
			$jml1
		</td>		
        <td align='center' style='vertical-align:middle;border: 1px dotted #999;padding: 3px 5px;background:#F5F5DC;'>
			$jml2
		</td>
        <td align='center' style='vertical-align:middle;border: 1px dotted #999;padding: 3px 5px;background:#F5F5DC;'>
			$jml3
		</td>	        
		<td align='center' style='vertical-align:middle;border: 1px dotted #999;padding: 3px 5px;background:#F5F5DC;'>
			$jml4
		</td>	        
		<td align='center' style='vertical-align:middle;border: 1px dotted #999;padding: 3px 5px;background:#F5F5DC;'>
			$jml5
		</td>
		<td align='center' style='vertical-align:middle;border: 1px dotted #999;padding: 3px 5px;background:#F5F5DC;'>
			$jml6
		</td>
		<td align='center' style='vertical-align:middle;border: 1px dotted #999;padding: 3px 5px;background:#F5F5DC;'>
			$jml7
		</td>
		<td align='center' style='vertical-align:middle;border: 1px dotted #999;padding: 3px 5px;background:#F5F5DC;'>
			$jml8
		</td>
		<td align='center' style='vertical-align:middle;border: 1px dotted #999;padding: 3px 5px;background:#F5F5DC;'>
			$jml9
		</td>
		<td align='center' style='vertical-align:middle;border: 1px dotted #999;padding: 3px 5px;background:#F5F5DC;'>
			<b>$jmltotal</b>
		</td>		
	</tr>
	
	<tr style='height:25px;'>
       <td align='center' style='vertical-align:middle;'>
			&nbsp;
		</td>	
        <td align='center' style='vertical-align:middle;'>
			&nbsp;
		</td>
        <td align='center' style='vertical-align:middle;'>
			&nbsp;
		</td>
        <td style='vertical-align:middle;'>
			&nbsp;
		</td>
        <td align='center' style='vertical-align:middle;'>
			&nbsp;
		</td>		
        <td style='vertical-align:middle;'>
			Nilai Rata-Rata
		</td>
        <td align='center' style='vertical-align:middle;border: 1px dotted #999;padding: 3px 5px;background:#FFEBCD;'>
			$r1
		</td>		
        <td align='center' style='vertical-align:middle;border: 1px dotted #999;padding: 3px 5px;background:#FFEBCD;'>
			$r2
		</td>
        <td align='center' style='vertical-align:middle;border: 1px dotted #999;padding: 3px 5px;background:#FFEBCD;'>
			$r3
		</td>	        
		<td align='center' style='vertical-align:middle;border: 1px dotted #999;padding: 3px 5px;background:#FFEBCD;'>
			$r4
		</td>	        
		<td align='center' style='vertical-align:middle;border: 1px dotted #999;padding: 3px 5px;background:#FFEBCD;'>
			$r5
		</td>
		<td align='center' style='vertical-align:middle;border: 1px dotted #999;padding: 3px 5px;background:#FFEBCD;'>
			$r6
		</td>
		<td align='center' style='vertical-align:middle;border: 1px dotted #999;padding: 3px 5px;background:#FFEBCD;'>
			$r7
		</td>
		<td align='center' style='vertical-align:middle;border: 1px dotted #999;padding: 3px 5px;background:#FFEBCD;'>
			$r8
		</td>
		<td align='center' style='vertical-align:middle;border: 1px dotted #999;padding: 3px 5px;background:#FFEBCD;'>
			$r9
		</td>
		<td align='center' style='vertical-align:middle;border: 1px dotted #999;padding: 3px 5px;background:#FFEBCD;'>
			$rTotal
		</td>		
	</tr>	
	
	<tr style='height:25px;'>
       <td align='center' style='vertical-align:middle;'>
			&nbsp;
		</td>	
        <td align='center' style='vertical-align:middle;'>
			&nbsp;
		</td>
        <td align='center' style='vertical-align:middle;'>
			&nbsp;
		</td>
        <td style='vertical-align:middle;'>
			&nbsp;
		</td>
        <td align='center' style='vertical-align:middle;'>
			&nbsp;
		</td>		
        <td style='vertical-align:middle;'>
			NRR Tertimbang / Unsur
		</td>
        <td align='center' style='vertical-align:middle;border: 1px dotted #999;padding: 3px 5px;background:#FFFACD;'>
			$nrr1
		</td>		
        <td align='center' style='vertical-align:middle;border: 1px dotted #999;padding: 3px 5px;background:#FFFACD;'>
			$nrr2
		</td>
        <td align='center' style='vertical-align:middle;border: 1px dotted #999;padding: 3px 5px;background:#FFFACD;'>
			$nrr3
		</td>	        
		<td align='center' style='vertical-align:middle;border: 1px dotted #999;padding: 3px 5px;background:#FFFACD;'>
			$nrr4
		</td>	        
		<td align='center' style='vertical-align:middle;border: 1px dotted #999;padding: 3px 5px;background:#FFFACD;'>
			$nrr5
		</td>
		<td align='center' style='vertical-align:middle;border: 1px dotted #999;padding: 3px 5px;background:#FFFACD;'>
			$nrr6
		</td>
		<td align='center' style='vertical-align:middle;border: 1px dotted #999;padding: 3px 5px;background:#FFFACD;'>
			$nrr7
		</td>
		<td align='center' style='vertical-align:middle;border: 1px dotted #999;padding: 3px 5px;background:#FFFACD;'>
			$nrr8
		</td>
		<td align='center' style='vertical-align:middle;border: 1px dotted #999;padding: 3px 5px;background:#FFFACD;'>
			$nrr9
		</td>
		<td align='center' style='vertical-align:middle;border: 1px dotted #999;padding: 3px 5px;background:#FFFACD;'>
			$nrrTotal
		</td>		
	</tr>	
	
	<tr style='height:25px;'>
       <td align='center' style='vertical-align:middle;'>
			&nbsp;
		</td>	
        <td align='center' style='vertical-align:middle;'>
			&nbsp;
		</td>
        <td align='center' style='vertical-align:middle;'>
			&nbsp;
		</td>
        <td style='vertical-align:middle;'>
			&nbsp;
		</td>
        <td align='center' style='vertical-align:middle;'>
			&nbsp;
		</td>		
        <td style='vertical-align:middle;'>
			NILAI SKM
		</td>
        <td align='center' style='vertical-align:middle;border-left: 1px dotted #999;border-top: 1px dotted #999;border-bottom: 1px dotted #999;padding: 3px 5px;background:#E0FFFF;'>
			&nbsp;
		</td>		
        <td align='center' style='vertical-align:middle;border-top: 1px dotted #999;border-bottom: 1px dotted #999;padding: 3px 5px;background:#E0FFFF;'>
			&nbsp;
		</td>
        <td align='center' style='vertical-align:middle;border-top: 1px dotted #999;border-bottom: 1px dotted #999;padding: 3px 5px;background:#E0FFFF;'>
			&nbsp;
		</td>	        
		<td align='center' style='vertical-align:middle;border-top: 1px dotted #999;border-bottom: 1px dotted #999;padding: 3px 5px;background:#E0FFFF;'>
			&nbsp;
		</td>	        
		<td align='center' style='vertical-align:middle;border-top: 1px dotted #999;border-bottom: 1px dotted #999;padding: 3px 5px;background:#E0FFFF;'>
			&nbsp;
		</td>	 
		<td align='center' style='vertical-align:middle;border-top: 1px dotted #999;border-bottom: 1px dotted #999;padding: 3px 5px;background:#E0FFFF;'>
			&nbsp;
		</td>	 
		<td align='center' style='vertical-align:middle;border-top: 1px dotted #999;border-bottom: 1px dotted #999;padding: 3px 5px;background:#E0FFFF;'>
			&nbsp;
		</td>	 
		<td align='center' style='vertical-align:middle;border-top: 1px dotted #999;border-bottom: 1px dotted #999;padding: 3px 5px;background:#E0FFFF;'>
			&nbsp;
		</td>	 
		<td align='center' style='vertical-align:middle;border-top: 1px dotted #999;border-bottom: 1px dotted #999;padding: 3px 5px;background:#E0FFFF;'>
			&nbsp;
		</td>	 
		<td align='center' style='vertical-align:middle;border: 1px dotted #999;padding: 3px 5px;background:#E0FFFF;font-size:17px;'>
			<b>$NilaiSKM</b>
		</td>		
	</tr>	
	";
	
mysqli_free_result($result);mysqli_free_result($dbserver);
?>  
				  </tbody>
                  </table>
<br>
<table>
	<tr style='height:25px;'>
		<td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td>
		<td colspan=2 style='vertical-align:middle;border: 1px solid #999;padding: 3px 5px;background:#AFEEEE;'>Bobot</td>
		<td colspan=2 align='center' style='vertical-align:middle;border: 1px solid #999;padding: 3px 5px;background:#AFEEEE;'>1</td>
	</tr>
	<tr style='height:25px;'>
		<td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td>
		<td colspan=2 style='vertical-align:middle;border: 1px solid #999;padding: 3px 5px;background:#AFEEEE;'>Unsur</td>
		<td colspan=2 align='center' style='vertical-align:middle;border: 1px solid #999;padding: 3px 5px;background:#AFEEEE;'>9</td>
	</tr>
	<tr style='height:25px;'>
		<td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td>
		<td colspan=2 style='vertical-align:middle;border: 1px solid #999;padding: 3px 5px;background:#AFEEEE;'>Bobot NRR Tertimbang</td>
		<td colspan=2 align='center' style='vertical-align:middle;border: 1px solid #999;padding: 3px 5px;background:#AFEEEE;'>0.1111</td>
	</tr>
	<tr style='height:25px;'>
		<td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td>
		<td colspan=2 style='vertical-align:middle;border: 1px solid #999;padding: 3px 5px;background:#AFEEEE;'>Nilai Penimbang</td>
		<td colspan=2 align='center' style='vertical-align:middle;border: 1px solid #999;padding: 3px 5px;background:#AFEEEE;'><?php echo $no;?></td>
	</tr>
</table>

<b>KETERANGAN :</b>
<br>
	U1 - U9&#9;&#9;&#9;: Unsur-Unsur Pelayanan<br>
	NRR&#9;&#9;&#9;: Nilai Rata-Rata<br>
	SKM&#9;&#9;&#9;: Survei Kepuasan Masyarakat<br>
	*)&#9;&#9;&#9;: Jumlah NRR IKM Tertimbang<br>
	**)&#9;&#9;&#9;: Jumlah NRR Tertimbang * <?php echo $no;?><br>
	NRR Per Unsur&#9;&#9;&#9;: Jumlah nilai per unsur dibagi jumlah kuesioner yang terisi<br>
	NRR Tertimbang Per Unsur&#9;&#9;&#9;: NRR per unsur x 0.1111<br>

<br>
<table>
	<tr style='height:25px;'>
		<td colspan=3 style='vertical-align:middle;border: 1px solid #999;padding: 3px 5px;background:#AFEEEE;'>SKM UNIT PELAYANAN</td>
		<td colspan=2 align='center' style='vertical-align:middle;border: 1px solid #999;padding: 3px 5px;background:#87CEEB;'><b><?php echo $NilaiSKM;?></b></td>
	</tr>
	<tr style='height:25px;'>
		<td colspan=3 style='vertical-align:middle;border: 1px solid #999;padding: 3px 5px;background:#AFEEEE;'>MUTU PELAYANAN</td>
		<td colspan=2 align='center' style='vertical-align:middle;border: 1px solid #999;padding: 3px 5px;background:#87CEEB;'><b><?php echo $tersebut;?></b></td>
	</tr>
</table>
<br>
<table>
	<thead>	  
        <tr>
		<th colspan=2 style="background:#AFEEEE;color:#000;height:25px;border: 1px dotted #999;"><center>NILAI PERSEPSI</center></th>
		<th colspan=3 style="background:#AFEEEE;color:#000;height:25px;border: 1px dotted #999;"><center>NILAI INTERVAL SKM</center></th>	
		<th colspan=2 style="background:#AFEEEE;color:#000;height:25px;border: 1px dotted #999;"><center>NILAI INTERVAL KONVERSI SKM</center></th>	
		<th colspan=4 style="background:#AFEEEE;color:#000;height:25px;border: 1px dotted #999;"><center>MUTU PELAYANAN</center></th>
		<th colspan=5 style="background:#AFEEEE;color:#000;height:25px;border: 1px dotted #999;"><center>KINERJA UNIT PELAYANAN</center></th>	
        </tr>
	</thead>
	<tbody>
		<tr style='height:25px;'>
			<td colspan=2 align='center' style='vertical-align:middle;border: 1px dotted #999;padding: 3px 5px;'>1</td>
			<td colspan=3 align='center' style='vertical-align:middle;border: 1px dotted #999;padding: 3px 5px;'>1.00 - 1.75</td>
			<td colspan=2 align='center' style='vertical-align:middle;border: 1px dotted #999;padding: 3px 5px;'>23.00 - 43.75</td>
			<td colspan=4 align='center' style='vertical-align:middle;border: 1px dotted #999;padding: 3px 5px;'>D</td>
			<td colspan=5 align='center' style='vertical-align:middle;border: 1px dotted #999;padding: 3px 5px;'>TIDAK BAIK</td>
		</tr>
		<tr style='height:25px;'>
			<td colspan=2 align='center' style='vertical-align:middle;border: 1px dotted #999;padding: 3px 5px;'>2</td>
			<td colspan=3 align='center' style='vertical-align:middle;border: 1px dotted #999;padding: 3px 5px;'>1.76 - 2.50</td>
			<td colspan=2 align='center' style='vertical-align:middle;border: 1px dotted #999;padding: 3px 5px;'>43.76 - 62.50</td>
			<td colspan=4 align='center' style='vertical-align:middle;border: 1px dotted #999;padding: 3px 5px;'>C</td>
			<td colspan=5 align='center' style='vertical-align:middle;border: 1px dotted #999;padding: 3px 5px;'>KURANG BAIK</td>
		</tr>
		<tr style='height:25px;'>
			<td colspan=2 align='center' style='vertical-align:middle;border: 1px dotted #999;padding: 3px 5px;'>3</td>
			<td colspan=3 align='center' style='vertical-align:middle;border: 1px dotted #999;padding: 3px 5px;'>2.51 - 3.25</td>
			<td colspan=2 align='center' style='vertical-align:middle;border: 1px dotted #999;padding: 3px 5px;'>62.51 - 81.25</td>
			<td colspan=4 align='center' style='vertical-align:middle;border: 1px dotted #999;padding: 3px 5px;'>B</td>
			<td colspan=5 align='center' style='vertical-align:middle;border: 1px dotted #999;padding: 3px 5px;'>BAIK</td>
		</tr>
		<tr style='height:25px;'>
			<td colspan=2 align='center' style='vertical-align:middle;border: 1px dotted #999;padding: 3px 5px;'>4</td>
			<td colspan=3 align='center' style='vertical-align:middle;border: 1px dotted #999;padding: 3px 5px;'>3.26 - 4.00</td>
			<td colspan=2 align='center' style='vertical-align:middle;border: 1px dotted #999;padding: 3px 5px;'>81.26 - 100.00</td>
			<td colspan=4 align='center' style='vertical-align:middle;border: 1px dotted #999;padding: 3px 5px;'>A</td>
			<td colspan=5 align='center' style='vertical-align:middle;border: 1px dotted #999;padding: 3px 5px;'>SANGAT BAIK</td>
		</tr>
	</tbody>
</table>

<br>
<table>
	<thead>	  
        <tr>
		<th style="background:#222;color:#fff;height:25px;"><center>NO</center></th>
		<th colspan=12 style="background:#222;color:#fff;height:25px;"><center>UNSUR PELAYANAN</center></th>	
		<th colspan=3 style="background:#222;color:#fff;height:25px;"><center>NILAI RATA-RATA</center></th>	
        </tr>
	</thead>
	<tbody>
<?php
$sqlx = ("SELECT id_unsur,unsur FROM ikm_m_unsur ORDER BY id_unsur ASC");
$result2 = mysqli_query($dbconn,$sqlx);
$data = array();
$nor=0;
$jumRR = 0;
while($t=mysqli_fetch_array($result2)){
  $nor++;
  $nmunsur = $t['unsur'];
  $sql = ("SELECT count(id_ikm) as jumikm FROM trans_ikm WHERE tgl_edit >= '".$tglawal."' AND tgl_edit <= '".$tglakhir."'");	
  $resultcount = mysqli_query($dbconn,$sql);$row= mysqli_fetch_assoc($resultcount);	
  if ($row['jumikm'] >= 1){
	if ($t['id_unsur']=="1"){
		$sqlCOUNT1 = ("SELECT SUM(n1) AS jum1 FROM trans_ikm	
			WHERE  tgl_edit >= '".$tglawal."' AND tgl_edit <= '".$tglakhir."'");		
		$resultx1 = mysqli_query($dbconn,$sqlCOUNT1);$q= mysqli_fetch_assoc($resultx1);
		$jumRR=round($q['jum1']/$no,2);
	}
	if ($t['id_unsur']=="2"){
		$sqlCOUNT2 = ("SELECT SUM(n2) AS jum2 FROM trans_ikm	
			WHERE  tgl_edit >= '".$tglawal."' AND tgl_edit <= '".$tglakhir."'");		
		$resultx2 = mysqli_query($dbconn,$sqlCOUNT2);$q= mysqli_fetch_assoc($resultx2);
		$jumRR=round($q['jum2']/$no,2);
	}
	if ($t['id_unsur']=="3"){
		$sqlCOUNT3 = ("SELECT SUM(n3) AS jum3 FROM trans_ikm	
			WHERE  tgl_edit >= '".$tglawal."' AND tgl_edit <= '".$tglakhir."'");		
		$resultx3 = mysqli_query($dbconn,$sqlCOUNT3);$q= mysqli_fetch_assoc($resultx3);
		$jumRR=round($q['jum3']/$no,2);
	}
	if ($t['id_unsur']=="4"){
		$sqlCOUNT4 = ("SELECT SUM(n4) AS jum4 FROM trans_ikm	
			WHERE  tgl_edit >= '".$tglawal."' AND tgl_edit <= '".$tglakhir."'");		
		$resultx4 = mysqli_query($dbconn,$sqlCOUNT4);$q= mysqli_fetch_assoc($resultx4);
		$jumRR=round($q['jum4']/$no,2);
	}
	if ($t['id_unsur']=="5"){
		$sqlCOUNT5 = ("SELECT SUM(n5) AS jum5 FROM trans_ikm	
			WHERE  tgl_edit >= '".$tglawal."' AND tgl_edit <= '".$tglakhir."'");		
		$resultx5 = mysqli_query($dbconn,$sqlCOUNT5);$q= mysqli_fetch_assoc($resultx5);
		$jumRR=round($q['jum5']/$no,2);
	}
	if ($t['id_unsur']=="6"){
		$sqlCOUNT6 = ("SELECT SUM(n6) AS jum6 FROM trans_ikm	
			WHERE  tgl_edit >= '".$tglawal."' AND tgl_edit <= '".$tglakhir."'");		
		$resultx6 = mysqli_query($dbconn,$sqlCOUNT6);$q= mysqli_fetch_assoc($resultx6);
		$jumRR=round($q['jum6']/$no,2);
	}
	if ($t['id_unsur']=="7"){
		$sqlCOUNT7 = ("SELECT SUM(n7) AS jum7 FROM trans_ikm	
			WHERE  tgl_edit >= '".$tglawal."' AND tgl_edit <= '".$tglakhir."'");		
		$resultx7 = mysqli_query($dbconn,$sqlCOUNT7);$q= mysqli_fetch_assoc($resultx7);
		$jumRR=round($q['jum7']/$no,2);
	}
	if ($t['id_unsur']=="8"){
		$sqlCOUNT8 = ("SELECT SUM(n8) AS jum8 FROM trans_ikm	
			WHERE  tgl_edit >= '".$tglawal."' AND tgl_edit <= '".$tglakhir."'");		
		$resultx8 = mysqli_query($dbconn,$sqlCOUNT8);$q= mysqli_fetch_assoc($resultx8);
		$jumRR=round($q['jum8']/$no,2);
	}
	if ($t['id_unsur']=="9"){
		$sqlCOUNT9 = ("SELECT SUM(n9) AS jum9 FROM trans_ikm	
			WHERE  tgl_edit >= '".$tglawal."' AND tgl_edit <= '".$tglakhir."'");		
		$resultx9 = mysqli_query($dbconn,$sqlCOUNT9);$q= mysqli_fetch_assoc($resultx9);
		$jumRR=round($q['jum9']/$no,2);
	}
  }
	
echo "	
		<tr style='height:25px;'>
			<td align='center' style='vertical-align:middle;border: 1px dotted #999;padding: 3px 5px;'>$nor</td>
			<td colspan=12 align='left' style='vertical-align:middle;border: 1px dotted #999;padding: 3px 5px;'>$nmunsur</td>
			<td colspan=3 align='center' style='vertical-align:middle;border: 1px dotted #999;padding: 3px 5px;'>$jumRR</td>
		</tr>";
}
mysqli_free_result($result2);mysqli_free_result($resultcount);
mysqli_free_result($resultx1);mysqli_free_result($resultx2);mysqli_free_result($resultx3);mysqli_free_result($resultx4);mysqli_free_result($resultx5);
mysqli_free_result($resultx6);mysqli_free_result($resultx7);mysqli_free_result($resultx8);mysqli_free_result($resultx9);
?>  
	</tbody>
</table>


<?php
$sqlCOUNTAD = ("SELECT count(if(jwb_1='TIDAK PUAS',0,null)) AS jumTP1,count(if(jwb_1='KURANG PUAS',0,null)) AS jumKP1,count(if(jwb_1='PUAS',0,null)) AS jumP1,count(if(jwb_1='SANGAT PUAS',0,null)) AS jumSP1,
	count(if(jwb_2='TIDAK PUAS',0,null)) AS jumTP2,count(if(jwb_2='KURANG PUAS',0,null)) AS jumKP2,count(if(jwb_2='PUAS',0,null)) AS jumP2,count(if(jwb_2='SANGAT PUAS',0,null)) AS jumSP2,
	count(if(jwb_3='TIDAK PUAS',0,null)) AS jumTP3,count(if(jwb_3='KURANG PUAS',0,null)) AS jumKP3,count(if(jwb_3='PUAS',0,null)) AS jumP3,count(if(jwb_3='SANGAT PUAS',0,null)) AS jumSP3,
	count(if(jwb_4='TIDAK PUAS',0,null)) AS jumTP4,count(if(jwb_4='KURANG PUAS',0,null)) AS jumKP4,count(if(jwb_4='PUAS',0,null)) AS jumP4,count(if(jwb_4='SANGAT PUAS',0,null)) AS jumSP4,
	count(if(jwb_5='TIDAK PUAS',0,null)) AS jumTP5,count(if(jwb_5='KURANG PUAS',0,null)) AS jumKP5,count(if(jwb_5='PUAS',0,null)) AS jumP5,count(if(jwb_5='SANGAT PUAS',0,null)) AS jumSP5,
	count(if(jwb_6='TIDAK PUAS',0,null)) AS jumTP6,count(if(jwb_6='KURANG PUAS',0,null)) AS jumKP6,count(if(jwb_6='PUAS',0,null)) AS jumP6,count(if(jwb_6='SANGAT PUAS',0,null)) AS jumSP6,
	count(if(jwb_7='TIDAK PUAS',0,null)) AS jumTP7,count(if(jwb_7='KURANG PUAS',0,null)) AS jumKP7,count(if(jwb_7='PUAS',0,null)) AS jumP7,count(if(jwb_7='SANGAT PUAS',0,null)) AS jumSP7,
	count(if(jwb_8='TIDAK PUAS',0,null)) AS jumTP8,count(if(jwb_8='KURANG PUAS',0,null)) AS jumKP8,count(if(jwb_8='PUAS',0,null)) AS jumP8,count(if(jwb_8='SANGAT PUAS',0,null)) AS jumSP8,
	count(if(jwb_9='TIDAK PUAS',0,null)) AS jumTP9,count(if(jwb_9='KURANG PUAS',0,null)) AS jumKP9,count(if(jwb_9='PUAS',0,null)) AS jumP9,count(if(jwb_9='SANGAT PUAS',0,null)) AS jumSP9
	FROM trans_ikm	
	WHERE tgl_edit >= '".$tglawal."' AND tgl_edit <= '".$tglakhir."'");		
	$resultcount1 = mysqli_query($dbconn,$sqlCOUNTAD);$p= mysqli_fetch_assoc($resultcount1);
	
	$jumTP1=$p['jumTP1'];$jumKP1=$p['jumKP1'];$jumP1=$p['jumP1'];$jumSP1=$p['jumSP1'];
	$jumTP2=$p['jumTP2'];$jumKP2=$p['jumKP2'];$jumP2=$p['jumP2'];$jumSP2=$p['jumSP2'];
	$jumTP3=$p['jumTP3'];$jumKP3=$p['jumKP3'];$jumP3=$p['jumP3'];$jumSP3=$p['jumSP3'];
	$jumTP4=$p['jumTP4'];$jumKP4=$p['jumKP4'];$jumP4=$p['jumP4'];$jumSP4=$p['jumSP4'];
	$jumTP5=$p['jumTP5'];$jumKP5=$p['jumKP5'];$jumP5=$p['jumP5'];$jumSP5=$p['jumSP5'];
	$jumTP6=$p['jumTP6'];$jumKP6=$p['jumKP6'];$jumP6=$p['jumP6'];$jumSP6=$p['jumSP6'];
	$jumTP7=$p['jumTP7'];$jumKP7=$p['jumKP7'];$jumP7=$p['jumP7'];$jumSP7=$p['jumSP7'];
	$jumTP8=$p['jumTP8'];$jumKP8=$p['jumKP8'];$jumP8=$p['jumP8'];$jumSP8=$p['jumSP8'];
	$jumTP9=$p['jumTP9'];$jumKP9=$p['jumKP9'];$jumP9=$p['jumP9'];$jumSP9=$p['jumSP9'];
	
	$jumtotTP = $jumTP1 + $jumTP2 + $jumTP3 + $jumTP4 + $jumTP5 + $jumTP6 + $jumTP7 + $jumTP8 + $jumTP9;
	$jumtotKP = $jumKP1 + $jumKP2 + $jumKP3 + $jumKP4 + $jumKP5 + $jumKP6 + $jumKP7 + $jumKP8 + $jumKP9;
	$jumtotP = $jumP1 + $jumP2 + $jumP3 + $jumP4 + $jumP5 + $jumP6 + $jumP7 + $jumP8 + $jumP9;
	$jumtotSP = $jumSP1 + $jumSP2 + $jumSP3 + $jumSP4 + $jumSP5 + $jumSP6 + $jumSP7 + $jumSP8 + $jumSP9;

	if ($jumtotTP >= 1){
		$PjumTP1=round(($p['jumTP1']/$jumtotTP)*100,1);
		$PjumTP2=round(($p['jumTP2']/$jumtotTP)*100,1);
		$PjumTP3=round(($p['jumTP3']/$jumtotTP)*100,1);
		$PjumTP4=round(($p['jumTP4']/$jumtotTP)*100,1);
		$PjumTP5=round(($p['jumTP5']/$jumtotTP)*100,1);
		$PjumTP6=round(($p['jumTP6']/$jumtotTP)*100,1);
		$PjumTP7=round(($p['jumTP7']/$jumtotTP)*100,1);
		$PjumTP8=round(($p['jumTP8']/$jumtotTP)*100,1);
		$PjumTP9=round(($p['jumTP9']/$jumtotTP)*100,1);
	} else {
		$PjumTP1=0;$PjumTP2=0;$PjumTP3=0;$PjumTP4=0;$PjumTP5=0;$PjumTP6=0;$PjumTP7=0;$PjumTP8=0;$PjumTP9=0;
	}
	
	if ($jumtotKP >= 1){	
		$PjumKP1=round(($p['jumKP1']/$jumtotKP)*100,1);
		$PjumKP2=round(($p['jumKP2']/$jumtotKP)*100,1);
		$PjumKP3=round(($p['jumKP3']/$jumtotKP)*100,1);
		$PjumKP4=round(($p['jumKP4']/$jumtotKP)*100,1);
		$PjumKP5=round(($p['jumKP5']/$jumtotKP)*100,1);
		$PjumKP6=round(($p['jumKP6']/$jumtotKP)*100,1);
		$PjumKP7=round(($p['jumKP7']/$jumtotKP)*100,1);
		$PjumKP8=round(($p['jumKP8']/$jumtotKP)*100,1);
		$PjumKP9=round(($p['jumKP9']/$jumtotKP)*100,1);
	} else {
		$PjumKP1=0;$PjumKP2=0;$PjumKP3=0;$PjumKP4=0;$PjumKP5=0;$PjumKP6=0;$PjumKP7=0;$PjumKP8=0;$PjumKP9=0;
	}

	if ($jumtotP >= 1){	
		$PjumP1=round(($p['jumP1']/$jumtotP)*100,1);
		$PjumP2=round(($p['jumP2']/$jumtotP)*100,1);
		$PjumP3=round(($p['jumP3']/$jumtotP)*100,1);
		$PjumP4=round(($p['jumP4']/$jumtotP)*100,1);
		$PjumP5=round(($p['jumP5']/$jumtotP)*100,1);
		$PjumP6=round(($p['jumP6']/$jumtotP)*100,1);
		$PjumP7=round(($p['jumP7']/$jumtotP)*100,1);
		$PjumP8=round(($p['jumP8']/$jumtotP)*100,1);
		$PjumP9=round(($p['jumP9']/$jumtotP)*100,1);
	} else {
		$PjumP1=0;$PjumP2=0;$PjumP3=0;$PjumP4=0;$PjumP5=0;$PjumP6=0;$PjumP7=0;$PjumP8=0;$PjumP9=0;
	}

	if ($jumtotSP >= 1){		
		$PjumSP1=round(($p['jumSP1']/$jumtotSP)*100,1);
		$PjumSP2=round(($p['jumSP2']/$jumtotSP)*100,1);
		$PjumSP3=round(($p['jumSP3']/$jumtotSP)*100,1);
		$PjumSP4=round(($p['jumSP4']/$jumtotSP)*100,1);
		$PjumSP5=round(($p['jumSP5']/$jumtotSP)*100,1);
		$PjumSP6=round(($p['jumSP6']/$jumtotSP)*100,1);
		$PjumSP7=round(($p['jumSP7']/$jumtotSP)*100,1);
		$PjumSP8=round(($p['jumSP8']/$jumtotSP)*100,1);
		$PjumSP9=round(($p['jumSP9']/$jumtotSP)*100,1);
	} else {
		$PjumSP1=0;$PjumSP2=0;$PjumSP3=0;$PjumSP4=0;$PjumSP5=0;$PjumSP6=0;$PjumSP7=0;$PjumSP8=0;$PjumSP9=0;
	}	
	mysqli_free_result($resultcount1);mysqli_close($dbconn); 
?>

<br>
<b>KESIMPULAN GABUNGAN</b>
<table>
	<thead>	  
        <tr>
		<th colspan=7 style="background:#222;color:#fff;height:25px;"><center>NOMOR CHECKLIST</center></th>
		<th style="background:#666;color:#fff;height:25px;"><center>1</center></th>	
		<th style="background:#222;color:#fff;height:25px;"><center>2</center></th>	
		<th style="background:#666;color:#fff;height:25px;"><center>3</center></th>	
		<th style="background:#222;color:#fff;height:25px;"><center>4</center></th>	
		<th style="background:#666;color:#fff;height:25px;"><center>5</center></th>	
		<th style="background:#222;color:#fff;height:25px;"><center>6</center></th>	
		<th style="background:#666;color:#fff;height:25px;"><center>7</center></th>	
		<th style="background:#222;color:#fff;height:25px;"><center>8</center></th>	
		<th style="background:#666;color:#fff;height:25px;"><center>9</center></th>	
        </tr>
	</thead>
	<tbody>
		<tr style='height:25px;'>
			<td colspan=7 align='left' style='vertical-align:middle;border: 1px dotted #999;padding: 3px 5px;'>Jumlah Menjawab Tidak Puas / Nilai 1</td>
			<td align='center' style='vertical-align:middle;border: 1px dotted #999;padding: 3px 5px;'><?php echo $jumTP1;?></td>
			<td align='center' style='vertical-align:middle;border: 1px dotted #999;padding: 3px 5px;'><?php echo $jumTP2;?></td>
			<td align='center' style='vertical-align:middle;border: 1px dotted #999;padding: 3px 5px;'><?php echo $jumTP3;?></td>
			<td align='center' style='vertical-align:middle;border: 1px dotted #999;padding: 3px 5px;'><?php echo $jumTP4;?></td>
			<td align='center' style='vertical-align:middle;border: 1px dotted #999;padding: 3px 5px;'><?php echo $jumTP5;?></td>
			<td align='center' style='vertical-align:middle;border: 1px dotted #999;padding: 3px 5px;'><?php echo $jumTP6;?></td>
			<td align='center' style='vertical-align:middle;border: 1px dotted #999;padding: 3px 5px;'><?php echo $jumTP7;?></td>
			<td align='center' style='vertical-align:middle;border: 1px dotted #999;padding: 3px 5px;'><?php echo $jumTP8;?></td>
			<td align='center' style='vertical-align:middle;border: 1px dotted #999;padding: 3px 5px;'><?php echo $jumTP9;?></td>
		</tr>
		<tr style='height:25px;'>
			<td colspan=7 align='left' style='vertical-align:middle;border: 1px dotted #999;padding: 3px 5px;'>Jumlah Menjawab Kurang Puas / Nilai 2</td>
			<td align='center' style='vertical-align:middle;border: 1px dotted #999;padding: 3px 5px;'><?php echo $jumKP1;?></td>
			<td align='center' style='vertical-align:middle;border: 1px dotted #999;padding: 3px 5px;'><?php echo $jumKP2;?></td>
			<td align='center' style='vertical-align:middle;border: 1px dotted #999;padding: 3px 5px;'><?php echo $jumKP3;?></td>
			<td align='center' style='vertical-align:middle;border: 1px dotted #999;padding: 3px 5px;'><?php echo $jumKP4;?></td>
			<td align='center' style='vertical-align:middle;border: 1px dotted #999;padding: 3px 5px;'><?php echo $jumKP5;?></td>
			<td align='center' style='vertical-align:middle;border: 1px dotted #999;padding: 3px 5px;'><?php echo $jumKP6;?></td>
			<td align='center' style='vertical-align:middle;border: 1px dotted #999;padding: 3px 5px;'><?php echo $jumKP7;?></td>
			<td align='center' style='vertical-align:middle;border: 1px dotted #999;padding: 3px 5px;'><?php echo $jumKP8;?></td>
			<td align='center' style='vertical-align:middle;border: 1px dotted #999;padding: 3px 5px;'><?php echo $jumKP9;?></td>
		</tr>
		<tr style='height:25px;'>
			<td colspan=7 align='left' style='vertical-align:middle;border: 1px dotted #999;padding: 3px 5px;'>Jumlah Menjawab Puas / Nilai 3</td>
			<td align='center' style='vertical-align:middle;border: 1px dotted #999;padding: 3px 5px;'><?php echo $jumP1;?></td>
			<td align='center' style='vertical-align:middle;border: 1px dotted #999;padding: 3px 5px;'><?php echo $jumP2;?></td>
			<td align='center' style='vertical-align:middle;border: 1px dotted #999;padding: 3px 5px;'><?php echo $jumP3;?></td>
			<td align='center' style='vertical-align:middle;border: 1px dotted #999;padding: 3px 5px;'><?php echo $jumP4;?></td>
			<td align='center' style='vertical-align:middle;border: 1px dotted #999;padding: 3px 5px;'><?php echo $jumP5;?></td>
			<td align='center' style='vertical-align:middle;border: 1px dotted #999;padding: 3px 5px;'><?php echo $jumP6;?></td>
			<td align='center' style='vertical-align:middle;border: 1px dotted #999;padding: 3px 5px;'><?php echo $jumP7;?></td>
			<td align='center' style='vertical-align:middle;border: 1px dotted #999;padding: 3px 5px;'><?php echo $jumP8;?></td>
			<td align='center' style='vertical-align:middle;border: 1px dotted #999;padding: 3px 5px;'><?php echo $jumP9;?></td>
		</tr>
		<tr style='height:25px;'>
			<td colspan=7 align='left' style='vertical-align:middle;border: 1px dotted #999;padding: 3px 5px;'>Jumlah Menjawab Sangat Puas / Nilai 4</td>
			<td align='center' style='vertical-align:middle;border: 1px dotted #999;padding: 3px 5px;'><?php echo $jumSP1;?></td>
			<td align='center' style='vertical-align:middle;border: 1px dotted #999;padding: 3px 5px;'><?php echo $jumSP2;?></td>
			<td align='center' style='vertical-align:middle;border: 1px dotted #999;padding: 3px 5px;'><?php echo $jumSP3;?></td>
			<td align='center' style='vertical-align:middle;border: 1px dotted #999;padding: 3px 5px;'><?php echo $jumSP4;?></td>
			<td align='center' style='vertical-align:middle;border: 1px dotted #999;padding: 3px 5px;'><?php echo $jumSP5;?></td>
			<td align='center' style='vertical-align:middle;border: 1px dotted #999;padding: 3px 5px;'><?php echo $jumSP6;?></td>
			<td align='center' style='vertical-align:middle;border: 1px dotted #999;padding: 3px 5px;'><?php echo $jumSP7;?></td>
			<td align='center' style='vertical-align:middle;border: 1px dotted #999;padding: 3px 5px;'><?php echo $jumSP8;?></td>
			<td align='center' style='vertical-align:middle;border: 1px dotted #999;padding: 3px 5px;'><?php echo $jumSP9;?></td>
		</tr>		
	</tbody>
</table>
<br>
<b>PERSENTASE JAWABAN</b>
<table>
		<tr style='height:25px;'>
			<td colspan=7 align='left' style='vertical-align:middle;border: 1px dotted #999;padding: 3px 5px;'>% Menjawab Tidak Puas / Nilai 1</td>
			<td align='center' style='vertical-align:middle;border: 1px dotted #999;padding: 3px 5px;'><?php echo $PjumTP1;?> %</td>
			<td align='center' style='vertical-align:middle;border: 1px dotted #999;padding: 3px 5px;'><?php echo $PjumTP2;?> %</td>
			<td align='center' style='vertical-align:middle;border: 1px dotted #999;padding: 3px 5px;'><?php echo $PjumTP3;?> %</td>
			<td align='center' style='vertical-align:middle;border: 1px dotted #999;padding: 3px 5px;'><?php echo $PjumTP4;?> %</td>
			<td align='center' style='vertical-align:middle;border: 1px dotted #999;padding: 3px 5px;'><?php echo $PjumTP5;?> %</td>
			<td align='center' style='vertical-align:middle;border: 1px dotted #999;padding: 3px 5px;'><?php echo $PjumTP6;?> %</td>
			<td align='center' style='vertical-align:middle;border: 1px dotted #999;padding: 3px 5px;'><?php echo $PjumTP7;?> %</td>
			<td align='center' style='vertical-align:middle;border: 1px dotted #999;padding: 3px 5px;'><?php echo $PjumTP8;?> %</td>
			<td align='center' style='vertical-align:middle;border: 1px dotted #999;padding: 3px 5px;'><?php echo $PjumTP9;?> %</td>
		</tr>
		<tr style='height:25px;'>
			<td colspan=7 align='left' style='vertical-align:middle;border: 1px dotted #999;padding: 3px 5px;'>% Menjawab Kurang Puas / Nilai 2</td>
			<td align='center' style='vertical-align:middle;border: 1px dotted #999;padding: 3px 5px;'><?php echo $PjumKP1;?> %</td>
			<td align='center' style='vertical-align:middle;border: 1px dotted #999;padding: 3px 5px;'><?php echo $PjumKP2;?> %</td>
			<td align='center' style='vertical-align:middle;border: 1px dotted #999;padding: 3px 5px;'><?php echo $PjumKP3;?> %</td>
			<td align='center' style='vertical-align:middle;border: 1px dotted #999;padding: 3px 5px;'><?php echo $PjumKP4;?> %</td>
			<td align='center' style='vertical-align:middle;border: 1px dotted #999;padding: 3px 5px;'><?php echo $PjumKP5;?> %</td>
			<td align='center' style='vertical-align:middle;border: 1px dotted #999;padding: 3px 5px;'><?php echo $PjumKP6;?> %</td>
			<td align='center' style='vertical-align:middle;border: 1px dotted #999;padding: 3px 5px;'><?php echo $PjumKP7;?> %</td>
			<td align='center' style='vertical-align:middle;border: 1px dotted #999;padding: 3px 5px;'><?php echo $PjumKP8;?> %</td>
			<td align='center' style='vertical-align:middle;border: 1px dotted #999;padding: 3px 5px;'><?php echo $PjumKP9;?> %</td>
		</tr>
		<tr style='height:25px;'>
			<td colspan=7 align='left' style='vertical-align:middle;border: 1px dotted #999;padding: 3px 5px;'>% Menjawab Puas / Nilai 3</td>
			<td align='center' style='vertical-align:middle;border: 1px dotted #999;padding: 3px 5px;'><?php echo $PjumP1;?> %</td>
			<td align='center' style='vertical-align:middle;border: 1px dotted #999;padding: 3px 5px;'><?php echo $PjumP2;?> %</td>
			<td align='center' style='vertical-align:middle;border: 1px dotted #999;padding: 3px 5px;'><?php echo $PjumP3;?> %</td>
			<td align='center' style='vertical-align:middle;border: 1px dotted #999;padding: 3px 5px;'><?php echo $PjumP4;?> %</td>
			<td align='center' style='vertical-align:middle;border: 1px dotted #999;padding: 3px 5px;'><?php echo $PjumP5;?> %</td>
			<td align='center' style='vertical-align:middle;border: 1px dotted #999;padding: 3px 5px;'><?php echo $PjumP6;?> %</td>
			<td align='center' style='vertical-align:middle;border: 1px dotted #999;padding: 3px 5px;'><?php echo $PjumP7;?> %</td>
			<td align='center' style='vertical-align:middle;border: 1px dotted #999;padding: 3px 5px;'><?php echo $PjumP8;?> %</td>
			<td align='center' style='vertical-align:middle;border: 1px dotted #999;padding: 3px 5px;'><?php echo $PjumP9;?> %</td>
		</tr>
		<tr style='height:25px;'>
			<td colspan=7 align='left' style='vertical-align:middle;border: 1px dotted #999;padding: 3px 5px;'>% Menjawab Sangat Puas / Nilai 4</td>
			<td align='center' style='vertical-align:middle;border: 1px dotted #999;padding: 3px 5px;'><?php echo $PjumSP1;?> %</td>
			<td align='center' style='vertical-align:middle;border: 1px dotted #999;padding: 3px 5px;'><?php echo $PjumSP2;?> %</td>
			<td align='center' style='vertical-align:middle;border: 1px dotted #999;padding: 3px 5px;'><?php echo $PjumSP3;?> %</td>
			<td align='center' style='vertical-align:middle;border: 1px dotted #999;padding: 3px 5px;'><?php echo $PjumSP4;?> %</td>
			<td align='center' style='vertical-align:middle;border: 1px dotted #999;padding: 3px 5px;'><?php echo $PjumSP5;?> %</td>
			<td align='center' style='vertical-align:middle;border: 1px dotted #999;padding: 3px 5px;'><?php echo $PjumSP6;?> %</td>
			<td align='center' style='vertical-align:middle;border: 1px dotted #999;padding: 3px 5px;'><?php echo $PjumSP7;?> %</td>
			<td align='center' style='vertical-align:middle;border: 1px dotted #999;padding: 3px 5px;'><?php echo $PjumSP8;?> %</td>
			<td align='center' style='vertical-align:middle;border: 1px dotted #999;padding: 3px 5px;'><?php echo $PjumSP9;?> %</td>
		</tr>		
</table>
<br><br>