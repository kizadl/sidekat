<?php
header("Content-type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=Laporan-kritik.xls");
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

<center>TABEL KRITIK DAN SARAN HASIL SURVEI KEPUASAN MASYARAKAT</center>
<center><?php echo $nminstansi;?></center>
<center><?php echo $tanggalawal;?> s/d <?php echo $tanggalakhir;?></center>

                 <table>
				  <thead>	  
                    <tr>
					  <th style="background:#222;color:#fff;height:25px;width:50px"><center>&nbsp;&nbsp;No&nbsp;&nbsp;</center></th>
					  <th style="background:#222;color:#fff;height:25px;width:200px"><center>Nama</center></th>	
					  <th style="background:#222;color:#fff;height:25px;width:40px"><center>Umur</center></th>
					  <th style="background:#222;color:#fff;height:25px;width:40px"><center>L/P</center></th>
					  <th style="background:#222;color:#fff;height:25px;width:90px"><center>Pendidikan</center></th>
					  <th style="background:#222;color:#fff;height:25px;width:180px"><center>Pekerjaan</center></th>
					  <th style="background:#222;color:#fff;height:25px;width:450px"><center>Kritik & Saran</center></th>		  
					</tr>
				  </thead>
				  <tbody>
<?php
$sqlx = ("SELECT p.nama,p.umur,p.kelamin,p.saran,q.pendidikan as nmpendidikan,r.pekerjaan as nmpekerjaan
		FROM trans_ikm p LEFT JOIN ikm_m_pendidikan q ON p.id_pendidikan=q.id_pendidikan
		LEFT JOIN ikm_m_pekerjaan r ON p.id_pekerjaan=r.id_pekerjaan
		WHERE p.ket_saran='Y' AND p.tgl_edit >= '".$tglawal."' AND p.tgl_edit <= '".$tglakhir."'
		ORDER BY p.id_ikm DESC");		

$result = mysqli_query($dbconn,$sqlx);
$no=0;
while($t=mysqli_fetch_array($result)){
$no++;
	$nama=ucwords(strtolower($t['nama']));$umur=$t['umur'];$kelamin=$t['kelamin'];
	$nmpendidikan=$t['nmpendidikan'];$nmpekerjaan=$t['nmpekerjaan'];
	$saran=$t['saran'];
	
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
			$nmpekerjaan 
		</td>
        <td style='vertical-align:middle;border: 1px dotted #999;padding: 3px 5px;'>
			$saran
		</td>		
	</tr>";
} 	
mysqli_free_result($result);mysqli_free_result($dbserver);
mysqli_close($dbconn); 
?>  
				  </tbody>
                  </table>