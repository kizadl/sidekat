<?php
header("Content-type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=Laporan-detail.xls");
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

<center>TABEL DETAIL HASIL SURVEI KEPUASAN MASYARAKAT</center>
<center><?php echo $nminstansi;?></center>
<center><?php echo $tanggalawal;?> s/d <?php echo $tanggalakhir;?></center>
<center>TP (Tidak Puas), KP (Kurang Puas), P (Puas), SP (Sangat Puas)</center>

                 <table>
				  <thead>	  
                    <tr>
					  <th rowspan=2 style="background:#222;color:#fff;height:25px;width:50px"><center>&nbsp;&nbsp;No&nbsp;&nbsp;</center></th>
					  <th rowspan=2 style="background:#222;color:#fff;height:25px;width:200px"><center>Nama</center></th>	
					  <th rowspan=2 style="background:#222;color:#fff;height:25px;width:40px"><center>Umur</center></th>
					  <th rowspan=2 style="background:#222;color:#fff;height:25px;width:40px"><center>L/P</center></th>
					  <th rowspan=2 style="background:#222;color:#fff;height:25px;width:90px"><center>Pendidikan</center></th>
					  <th rowspan=2 style="background:#222;color:#fff;height:25px;width:180px"><center>Pekerjaan</center></th>
					  
					  <th colspan=9 style="background:#444;color:#fff;height:25px;width:450px"><center>Jawaban Soal</center></th>
					  <th colspan=4 style="background:#222;color:#fff;height:25px;width:200px"><center>Jumlah Jawaban</center></th>
					  <th colspan=9 style="background:#666;color:#fff;height:25px;width:450px"><center>Nilai Unsur Pelayanan</center></th>	
					  <th rowspan=2 style="background:#222;color:#fff;height:25px;width:65px"><center>&nbsp;&nbsp;Jumlah&nbsp;&nbsp;</center></th>
                    </tr>
                    <tr>
					  <th style="background:#666;color:#fff;height:25px;width:50px"><center>&nbsp;&nbsp;&nbsp;&nbsp;1&nbsp;&nbsp;&nbsp;&nbsp;</center></th>
					  <th style="background:#666;color:#fff;height:25px;width:50px"><center>&nbsp;&nbsp;&nbsp;&nbsp;2&nbsp;&nbsp;&nbsp;&nbsp;</center></th>
					  <th style="background:#666;color:#fff;height:25px;width:50px"><center>&nbsp;&nbsp;&nbsp;&nbsp;3&nbsp;&nbsp;&nbsp;&nbsp;</center></th>
					  <th style="background:#666;color:#fff;height:25px;width:50px"><center>&nbsp;&nbsp;&nbsp;&nbsp;4&nbsp;&nbsp;&nbsp;&nbsp;</center></th>
					  <th style="background:#666;color:#fff;height:25px;width:50px"><center>&nbsp;&nbsp;&nbsp;&nbsp;5&nbsp;&nbsp;&nbsp;&nbsp;</center></th>
					  <th style="background:#666;color:#fff;height:25px;width:50px"><center>&nbsp;&nbsp;&nbsp;&nbsp;6&nbsp;&nbsp;&nbsp;&nbsp;</center></th>
					  <th style="background:#666;color:#fff;height:25px;width:50px"><center>&nbsp;&nbsp;&nbsp;&nbsp;7&nbsp;&nbsp;&nbsp;&nbsp;</center></th>
					  <th style="background:#666;color:#fff;height:25px;width:50px"><center>&nbsp;&nbsp;&nbsp;&nbsp;8&nbsp;&nbsp;&nbsp;&nbsp;</center></th>
					  <th style="background:#666;color:#fff;height:25px;width:50px"><center>&nbsp;&nbsp;&nbsp;&nbsp;9&nbsp;&nbsp;&nbsp;&nbsp;</center></th>
					  <th style="background:#444;color:#fff;height:25px;width:50px"><center>TP</center></th>
					  <th style="background:#444;color:#fff;height:25px;width:50px"><center>KP</center></th>
					  <th style="background:#444;color:#fff;height:25px;width:50px"><center>P</center></th>
					  <th style="background:#444;color:#fff;height:25px;width:50px"><center>SP</center></th>
					  
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
$sqlx = ("SELECT p.nama,p.umur,p.kelamin,p.jwb_1,p.jwb_2,p.jwb_3,p.jwb_4,p.jwb_5,p.jwb_6,p.jwb_7,p.jwb_8,p.jwb_9,p.jml_tp,p.jml_kp,p.jml_p,p.jml_sp,
		p.n1,p.n2,p.n3,p.n4,p.n5,p.n6,p.n7,p.n8,p.n9,p.jml_skor,q.pendidikan as nmpendidikan,r.pekerjaan as nmpekerjaan
		FROM trans_ikm p LEFT JOIN ikm_m_pendidikan q ON p.id_pendidikan=q.id_pendidikan
		LEFT JOIN ikm_m_pekerjaan r ON p.id_pekerjaan=r.id_pekerjaan
		WHERE p.tgl_edit >= '".$tglawal."' AND p.tgl_edit <= '".$tglakhir."'
		ORDER BY p.id_ikm DESC");		

$result = mysqli_query($dbconn,$sqlx);
$no=0;
$jmltotal=0;$jml1=0;$jml2=0;$jml3=0;$jml4=0;$jml5=0;$jml6=0;$jml7=0;$jml8=0;$jml9=0;
$jmlTP=0;$jmlKP=0;$jmlP=0;$jmlSP=0;
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
	
	$jmlTP=$jmlTP+$t['jml_tp'];
	$jmlKP=$jmlKP+$t['jml_kp'];
	$jmlP=$jmlP+$t['jml_p'];
	$jmlSP=$jmlSP+$t['jml_sp'];
	
	$nama=ucwords(strtolower($t['nama']));$umur=$t['umur'];$kelamin=$t['kelamin'];
	$nmpendidikan=$t['nmpendidikan'];$nmpekerjaan=$t['nmpekerjaan'];

	$n1=$t['n1'];$n2=$t['n2'];$n3=$t['n3'];$n4=$t['n4'];$n5=$t['n5'];$n6=$t['n6'];$n7=$t['n7'];$n8=$t['n8'];$n9=$t['n9'];
	$jmlskor=$t['jml_skor'];
	
	if($t['jwb_1']=="TIDAK PUAS"){$J1="TP";}else if($t['jwb_1']=="KURANG PUAS"){$J1="KP";}else if($t['jwb_1']=="PUAS"){$J1="P";}else if($t['jwb_1']=="SANGAT PUAS"){$J1="SP";}
	if($t['jwb_2']=="TIDAK PUAS"){$J2="TP";}else if($t['jwb_2']=="KURANG PUAS"){$J2="KP";}else if($t['jwb_2']=="PUAS"){$J2="P";}else if($t['jwb_2']=="SANGAT PUAS"){$J2="SP";}
	if($t['jwb_3']=="TIDAK PUAS"){$J3="TP";}else if($t['jwb_3']=="KURANG PUAS"){$J3="KP";}else if($t['jwb_3']=="PUAS"){$J3="P";}else if($t['jwb_3']=="SANGAT PUAS"){$J3="SP";}
	if($t['jwb_4']=="TIDAK PUAS"){$J4="TP";}else if($t['jwb_4']=="KURANG PUAS"){$J4="KP";}else if($t['jwb_4']=="PUAS"){$J4="P";}else if($t['jwb_4']=="SANGAT PUAS"){$J4="SP";}
	if($t['jwb_5']=="TIDAK PUAS"){$J5="TP";}else if($t['jwb_5']=="KURANG PUAS"){$J5="KP";}else if($t['jwb_5']=="PUAS"){$J5="P";}else if($t['jwb_5']=="SANGAT PUAS"){$J5="SP";}
	if($t['jwb_6']=="TIDAK PUAS"){$J6="TP";}else if($t['jwb_6']=="KURANG PUAS"){$J6="KP";}else if($t['jwb_6']=="PUAS"){$J6="P";}else if($t['jwb_6']=="SANGAT PUAS"){$J6="SP";}
	if($t['jwb_7']=="TIDAK PUAS"){$J7="TP";}else if($t['jwb_7']=="KURANG PUAS"){$J7="KP";}else if($t['jwb_7']=="PUAS"){$J7="P";}else if($t['jwb_7']=="SANGAT PUAS"){$J7="SP";}
	if($t['jwb_8']=="TIDAK PUAS"){$J8="TP";}else if($t['jwb_8']=="KURANG PUAS"){$J8="KP";}else if($t['jwb_8']=="PUAS"){$J8="P";}else if($t['jwb_8']=="SANGAT PUAS"){$J8="SP";}
	if($t['jwb_9']=="TIDAK PUAS"){$J9="TP";}else if($t['jwb_9']=="KURANG PUAS"){$J9="KP";}else if($t['jwb_9']=="PUAS"){$J9="P";}else if($t['jwb_9']=="SANGAT PUAS"){$J9="SP";}
	$JTP=$t['jml_tp'];$JKP=$t['jml_kp'];$JP=$t['jml_p'];$JSP=$t['jml_sp'];
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
			$J1
		</td>
        <td align='center' style='vertical-align:middle;border: 1px dotted #999;padding: 3px 5px;'>
			$J2
		</td>
        <td align='center' style='vertical-align:middle;border: 1px dotted #999;padding: 3px 5px;'>
			$J3
		</td>
        <td align='center' style='vertical-align:middle;border: 1px dotted #999;padding: 3px 5px;'>
			$J4
		</td>
        <td align='center' style='vertical-align:middle;border: 1px dotted #999;padding: 3px 5px;'>
			$J5
		</td>
        <td align='center' style='vertical-align:middle;border: 1px dotted #999;padding: 3px 5px;'>
			$J6
		</td>
        <td align='center' style='vertical-align:middle;border: 1px dotted #999;padding: 3px 5px;'>
			$J7
		</td>
        <td align='center' style='vertical-align:middle;border: 1px dotted #999;padding: 3px 5px;'>
			$J8
		</td>
        <td align='center' style='vertical-align:middle;border: 1px dotted #999;padding: 3px 5px;'>
			$J9
		</td>

        <td align='center' style='vertical-align:middle;border: 1px dotted #999;padding: 3px 5px;background:#FFFAF0;'>
			$JTP
		</td>
        <td align='center' style='vertical-align:middle;border: 1px dotted #999;padding: 3px 5px;'>
			$JKP
		</td>
        <td align='center' style='vertical-align:middle;border: 1px dotted #999;padding: 3px 5px;background:#FFFAF0;'>
			$JP
		</td>
        <td align='center' style='vertical-align:middle;border: 1px dotted #999;padding: 3px 5px;'>
			$JSP
		</td>
		
        <td align='center' style='vertical-align:middle;border: 1px dotted #999;padding: 3px 5px;background:#F0FFFF;'>
			$n1
		</td>
        <td align='center' style='vertical-align:middle;border: 1px dotted #999;padding: 3px 5px;'>
			$n2
		</td>
        <td align='center' style='vertical-align:middle;border: 1px dotted #999;padding: 3px 5px;background:#F0FFFF;'>
			$n3
		</td>
        <td align='center' style='vertical-align:middle;border: 1px dotted #999;padding: 3px 5px;'>
			$n4
		</td>
        <td align='center' style='vertical-align:middle;border: 1px dotted #999;padding: 3px 5px;background:#F0FFFF;'>
			$n5
		</td>
        <td align='center' style='vertical-align:middle;border: 1px dotted #999;padding: 3px 5px;'>
			$n6
		</td>
        <td align='center' style='vertical-align:middle;border: 1px dotted #999;padding: 3px 5px;background:#F0FFFF;'>
			$n7
		</td>
        <td align='center' style='vertical-align:middle;border: 1px dotted #999;padding: 3px 5px;'>
			$n8
		</td>
        <td align='center' style='vertical-align:middle;border: 1px dotted #999;padding: 3px 5px;background:#F0FFFF;'>
			$n9
		</td>
        <td align='center' style='vertical-align:middle;border: 1px dotted #999;padding: 3px 5px;'>
			<b>$jmlskor</b>
		</td>		
	</tr>";
} 
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

	$TOTjmlTP = number_format($jmlTP,0,',','.');
	$TOTjmlKP = number_format($jmlKP,0,',','.');
	$TOTjmlP = number_format($jmlP,0,',','.');
	$TOTjmlSP = number_format($jmlSP,0,',','.');
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
        <td align='center' style='vertical-align:middle;'>
			&nbsp;
		</td>
        <td align='center' style='vertical-align:middle;'>
			&nbsp;
		</td>
        <td align='center' style='vertical-align:middle;'>
			&nbsp;
		</td>
        <td align='center' style='vertical-align:middle;'>
			&nbsp;
		</td>
        <td align='center' style='vertical-align:middle;'>
			&nbsp;
		</td>
        <td align='center' style='vertical-align:middle;'>
			&nbsp;
		</td>
        <td align='center' style='vertical-align:middle;'>
			&nbsp;
		</td>
        <td align='center' style='vertical-align:middle;'>
			&nbsp;
		</td>
        <td align='center' style='vertical-align:middle;'>
			&nbsp;
		</td>
        <td align='center' style='vertical-align:middle;'>
			&nbsp;
		</td>
		
        <td align='center' style='vertical-align:middle;border: 1px dotted #999;padding: 3px 5px;background:#FFEBCD;'>
			$TOTjmlTP
		</td>
        <td align='center' style='vertical-align:middle;border: 1px dotted #999;padding: 3px 5px;background:#FFEBCD;'>
			$TOTjmlKP
		</td>
        <td align='center' style='vertical-align:middle;border: 1px dotted #999;padding: 3px 5px;background:#FFEBCD;'>
			$TOTjmlP
		</td>
        <td align='center' style='vertical-align:middle;border: 1px dotted #999;padding: 3px 5px;background:#FFEBCD;'>
			$TOTjmlSP
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
	";
	
mysqli_free_result($result);mysqli_free_result($dbserver);
mysqli_close($dbconn); 
?>  
				  </tbody>
                  </table>