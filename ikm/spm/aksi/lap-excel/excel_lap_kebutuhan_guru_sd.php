<?php
header("Content-type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=kebutuhan-guru-sd.xls");
header("Cache-Control: no-cache, must-revalidate");
header("Expires: IKM");

error_reporting(0);
include '../../../services/config.php';
$dbconn = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname) or die('Could not connect: ');
date_default_timezone_set('Asia/Jakarta');
function tgl_indo($tgl)
{
	$tanggal = substr($tgl, 8, 2);
	$bulan = getBulan(substr($tgl, 5, 2));
	$tahun = substr($tgl, 0, 4);
	return $tanggal . ' ' . $bulan . ' ' . $tahun;
}
function getBulan($bln)
{
	switch ($bln) {
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

$filterkebutuhan = trim($_GET['filterkebutuhan']);

if ($filterkebutuhan == "semua") {
	$ketupload = "KURIKULUM SD 2013 & KURIKULUM SD MERDEKA";
} else if ($filterkebutuhan == "KMB") {
	$ketupload = "KURIKULUM SD MERDEKA";
}

?>
<center>KEBUTUHAN GURU SEKOLAH DASAR (SD)</center>
<center><?php echo $ketupload; ?></center>
<center>Tanggal Cetak <?php echo $tanggal; ?></center>

<table>
	<thead>
		<tr>
			<th rowspan=2 style="background:#444;color:#fff;height:25px;width:45px">
				<center>NO</center>
			</th>
			<th rowspan=2 style="background:#222;color:#fff;height:25px;width:75px">
				<center>NPSN</center>
			</th>
			<th rowspan=2 style="background:#444;color:#fff;height:25px;width:250px">
				<center>Nama Sekolah</center>
			</th>
			<th rowspan=2 style="background:#222;color:#fff;height:25px;width:75px">
				<center>Status</center>
			</th>
			<th colspan=3 style="background:#444;color:#fff;height:25px;">
				<center>Rombel</center>
			</th>
			<th colspan=2 style="background:#222;color:#fff;height:25px;">
				<center>PTK</center>
			</th>
			<th colspan=4 style="background:#444;color:#fff;height:25px;">
				<center>Status Kepegawaian</center>
			</th>
			<th colspan=12 style="background:#222;color:#fff;height:25px;">
				<center>Jumlah Guru Pengampu : Ideal Kebutuhan Guru</center>
			</th>
			<th rowspan=2 colspan=2 style="background:#444;color:#fff;height:25px;width:100px">
				<center>Kurang/Lebih</center>
			</th>
		</tr>
		<tr>
			<th style="background:#555;color:#fff;height:25px;width:60px">
				<center>K-13</center>
			</th>
			<th style="background:#666;color:#fff;height:25px;width:60px">
				<center>K-MB</center>
			</th>
			<th style="background:#555;color:#fff;height:25px;width:60px">
				<center>Rombel</center>
			</th>

			<th style="background:#666;color:#fff;height:25px;width:60px">
				<center>PTT</center>
			</th>
			<th style="background:#555;color:#fff;height:25px;width:60px">
				<center>Guru</center>
			</th>

			<th style="background:#666;color:#fff;height:25px;width:60px">
				<center>PNS</center>
			</th>
			<th style="background:#555;color:#fff;height:25px;width:60px">
				<center>PPPK</center>
			</th>
			<th style="background:#666;color:#fff;height:25px;width:60px">
				<center>GTT</center>
			</th>
			<th style="background:#555;color:#fff;height:25px;width:75px">
				<center>HONORER</center>
			</th>

			<th colspan=2 style="background:#666;color:#fff;height:25px;width:90px">
				<center>Guru Kelas</center>
			</th>
			<th colspan=2 style="background:#555;color:#fff;height:25px;width:90px">
				<center>PJOK</center>
			</th>
			<th colspan=2 style="background:#666;color:#fff;height:25px;width:90px">
				<center>PAI</center>
			</th>
			<th colspan=2 style="background:#555;color:#fff;height:25px;width:90px">
				<center>B. Inggris</center>
			</th>
			<th colspan=2 style="background:#666;color:#fff;height:25px;width:90px">
				<center>TIK</center>
			</th>
			<th colspan=2 style="background:#555;color:#fff;height:25px;width:90px">
				<center>Jumlah</center>
			</th>
		</tr>
	</thead>
	<tbody>
		<?php
		$ketsekolah = "SD";

		$qrijam = ("SELECT id_mapel,jumlah_jam
		FROM m_jam_mapel WHERE bentuk_pendidikan='".$ketsekolah."' AND aktif='Y'");
		$dbjumlahjam = mysqli_query($dbconn, $qrijam);
		while($s=mysqli_fetch_array($dbjumlahjam)){
			if ($s['id_mapel'] == "500010000"){$jmljamPJOK = $s['jumlah_jam'];}
			if ($s['id_mapel'] == "100011000" OR $s['id_mapel'] == "100011070"){$jmljamPAI = $s['jumlah_jam'];}
			if ($s['id_mapel'] == "300210000"){$jmljamBING = $s['jumlah_jam'];}
			if ($s['id_mapel'] != "400200000" OR $s['id_mapel'] != "500010000" OR $s['id_mapel'] != "100011000" OR $s['id_mapel'] != "100011070" OR $s['id_mapel'] != "300210000"){$jmljamLAIN = 4;}
			if ($s['id_mapel'] == "802000300"){$jmljamTIK = $s['jumlah_jam'];}
		}

		if ($filterkebutuhan == "semua"){

			$sqlx = ("SELECT DISTINCT p.id_sekolah,p.npsn,
				p.rombel_1,p.rombel_2,p.rombel_3,p.rombel_4,p.rombel_5,p.rombel_6,
				p.nama_sekolah,p.status_sekolah,p.bentuk_pendidikan,
				(p.ptk_l+p.ptk_p) AS JumPtk,
				(p.ptk_guru_l+p.ptk_guru_p) AS JumGuru
				FROM spm_sekolah p 
				WHERE p.bentuk_pendidikan='".$ketsekolah."' GROUP BY p.id_sekolah");
		
		} else if ($filterkebutuhan == "KMB"){
		
			$sqlx = ("SELECT DISTINCT p.id_sekolah,p.npsn,
				p.rombel_1,p.rombel_2,p.rombel_3,p.rombel_4,p.rombel_5,p.rombel_6,
				p.nama_sekolah,p.status_sekolah,p.bentuk_pendidikan,
				(p.ptk_l+p.ptk_p) AS JumPtk,
				(p.ptk_guru_l+p.ptk_guru_p) AS JumGuru
				FROM spm_sekolah p 
				LEFT JOIN spm_rombel r ON p.id_sekolah=r.id_sekolah
				WHERE p.bentuk_pendidikan='".$ketsekolah."' AND r.kurikulum='Kurikulum SD Merdeka' AND p.id_sekolah=r.id_sekolah GROUP BY p.id_sekolah");
				
		} 

		$result = mysqli_query($dbconn, $sqlx);

		$no = 0;
		while ($t = mysqli_fetch_array($result)) {
			$no++;

			$npsn = $t['npsn'];
			$sttssekolah = $t['status_sekolah'];

			if (substr($t['nama_sekolah'], 0, 53) == "UNIT PELAKSANA TEKNIS DAERAH (UPTD) SATUAN PENDIDIKAN") {
				$nmsekolah = substr($t['nama_sekolah'], 54);
			} else {
				$nmsekolah = $t['nama_sekolah'];
			}

			$qrijml = ("SELECT COUNT(IF(r.kurikulum='Kurikulum SD Merdeka',r.kurikulum,NULL)) AS jumKMB,
			COUNT(IF(r.kurikulum='Kurikulum SD 2013',r.kurikulum,NULL)) AS jumK13 
			FROM spm_rombel r WHERE r.id_sekolah='".$t['id_sekolah']."'");
			$dbjumlah = mysqli_query($dbconn, $qrijml);$c = mysqli_fetch_assoc($dbjumlah);
			$jumKMB = $c['jumKMB'];$jumK13 = $c['jumK13'];

			////////////////// status kepegawaian ////////////////////
			$qrijmlpeg = ("SELECT COUNT(IF(status_kepegawaian='PNS',id,NULL)) AS jumPNS,
				COUNT(IF(status_kepegawaian='CPNS',id,NULL)) AS jumCPNS,
				COUNT(IF(status_kepegawaian='PNS Diperbantukan',id,NULL)) AS jumPNSBantu,
				COUNT(IF(status_kepegawaian='PNS Depag',id,NULL)) AS jumPNSDepag,
				COUNT(IF(status_kepegawaian='PPPK',id,NULL)) AS jumP3K,
				COUNT(IF(status_kepegawaian='GTY/PTY',id,NULL)) AS jumGTY,
				COUNT(IF(status_kepegawaian='Honor Daerah TK.II Kab/Kota',id,NULL)) AS jumHonor,
				COUNT(IF(status_kepegawaian='Guru Honor Sekolah',id,NULL)) AS jumGuruHonor,
				COUNT(IF(status_kepegawaian='Tenaga Honor Sekolah',id,NULL)) AS jumTenagaHonor,
				COUNT(IF(status_kepegawaian='Honor Daerah TK.I Provinsi',id,NULL)) AS jumHonorDaerah,
				COUNT(IF(status_kepegawaian='Lainnya',id,NULL)) AS jumLainnya,
				COUNT(IF(status_kepegawaian='NON PNS',id,NULL)) AS jumNONPNS,
				COUNT(IF(status_kepegawaian='Guru Pengganti',id,NULL)) AS jumPengganti,

				COUNT(IF(id_mapel_diampu='500010000',id,NULL)) AS jumRealPJOK,
				COUNT(IF(id_mapel_diampu='400200000',id,NULL)) AS jumRealGURUKELAS,
				COUNT(IF(id_mapel_diampu='100011000' OR id_mapel_diampu='100011070',id,NULL)) AS jumRealPAI,
				COUNT(IF(id_mapel_diampu='300210000',id,NULL)) AS jumRealBING,
				COUNT(IF(id_mapel_diampu='802000300',id,NULL)) AS jumRealTIK

				FROM spm_ptk WHERE id_sekolah='".$t['id_sekolah']."'");
			$dbjumlahpeg = mysqli_query($dbconn, $qrijmlpeg);$d = mysqli_fetch_assoc($dbjumlahpeg);

			$jumPNS = $d['jumPNS']+$d['jumCPNS']+$d['jumPNSBantu']+$d['jumPNSDepag'];
			$jumPPPK = $d['jumP3K'];
			$jumGTY = $d['jumGTY'];
			$jumHonorer = $d['jumHonor']+$d['jumGuruHonor']+$d['jumTenagaHonor']+$d['jumHonorDaerah']+$d['jumLainnya']+$d['jumNONPNS']+$d['jumPengganti'];

			//// jumlah real guru mapel ////
			$jumRealGURUKELAS =  $d['jumRealGURUKELAS'];
			$jumRealPJOK =  $d['jumRealPJOK'];
			$jumRealPAI =  $d['jumRealPAI'];
			$jumRealBING =  $d['jumRealBING'];
			$jumRealTIK =  $d['jumRealTIK'];
			$jumTotalReal = $d['jumRealGURUKELAS']+$d['jumRealPJOK']+$d['jumRealPAI']+$d['jumRealBING']+$d['jumRealTIK'];

			$jmlrombel = $t['rombel_1'] + $t['rombel_2'] + $t['rombel_3'] + $t['rombel_4'] + $t['rombel_5'] + $t['rombel_6'];
	
			//// ideal kebutuhan guru ////
			$jumgurukelasideal = $jumKMB + $jumK13;
			$jumguruPJOKideal = ($jmlrombel * $jmljamPJOK)/24;
			$jumguruPAIideal = ($jmlrombel * $jmljamPAI)/24;
			$jumguruTIKideal = ($jmlrombel * $jmljamTIK)/24;
			$jumguruBINGideal = ($jumKMB * $jmljamBING)/24;
			if ($jumKMB >= 1){
				if ($jumguruBINGideal <= 1){$jumguruBINGideal = 1;} else {$jumguruBINGideal = round($jumguruBINGideal);}
			} else if ($jumKMB <= 0){$jumguruBINGideal = 0;}
			$jumguruTOTALideal = round($jumgurukelasideal) + round($jumguruPJOKideal) + round($jumguruPAIideal) + $jumguruBINGideal + round($jumguruTIKideal);
			
			$kurangguru = $t['JumGuru'] - $jumguruTOTALideal ;
			if ($kurangguru <= 0){$warnahuruf = "red";} else if ($kurangguru >= 1) {$warnahuruf = "blue";}

			$kuranggurureal = $jumTotalReal - $jumguruTOTALideal;
			if ($kuranggurureal <= 0){$warnahurufreal = "red";} else if ($kuranggurureal >= 1) {$warnahurufreal = "blue";}

			$jmlguru = $t['JumGuru'];
			$jmlptt = $t['JumPtk']-$t['JumGuru'];
			$jumguruTOTALideal = round($jumguruTOTALideal);
			
			$npsn = $t['npsn'];
			$sttssekolah = $t['status_sekolah'];
			$nmsekolah = $nmsekolah;

			$jumguruPJOKideal = round($jumguruPJOKideal);
			$jumguruPAIideal = round($jumguruPAIideal);
			$jumguruTIKideal = round($jumguruTIKideal);
			$jumguruBINGideal = round($jumguruBINGideal);

			echo "	
	<tr style='height:25px;'>
		<td align='center' style='vertical-align:middle;border: 1px dotted #999;padding: 30px 15px;'>
			$no
		</td>
        <td align='center' style='vertical-align:middle;border: 1px dotted #999;padding: 30px 15px;'>
			$npsn
		</td>
        <td align='left' style='vertical-align:middle;border: 1px dotted #999;padding: 3px 5px;'>
			$nmsekolah
		</td>
		<td align='center' style='vertical-align:middle;border: 1px dotted #999;padding: 30px 15px;'>
			$sttssekolah
		</td>
        <td align='center' style='vertical-align:middle;border: 1px dotted #999;padding: 3px 5px;'>
			$jumK13
		</td>
		<td align='center' style='vertical-align:middle;border: 1px dotted #999;padding: 3px 5px;'>
			$jumKMB
		</td>
		<td align='center' style='vertical-align:middle;border: 1px dotted #999;padding: 3px 5px;'>
			$jmlrombel
		</td>
		<td align='center' style='vertical-align:middle;border: 1px dotted #999;padding: 3px 5px;'>
			$jmlptt
		</td>
		<td align='center' style='vertical-align:middle;border: 1px dotted #999;padding: 3px 5px;'>
			$jmlguru
		</td>

		<td align='center' style='vertical-align:middle;border: 1px dotted #999;padding: 3px 5px;'>
			$jumPNS
		</td>
		<td align='center' style='vertical-align:middle;border: 1px dotted #999;padding: 3px 5px;'>
			$jumPPPK
		</td>
		<td align='center' style='vertical-align:middle;border: 1px dotted #999;padding: 3px 5px;'>
			$jumGTY
		</td>
		<td align='center' style='vertical-align:middle;border: 1px dotted #999;padding: 3px 5px;'>
			$jumHonorer
		</td>

		<td align='center' style='vertical-align:middle;border: 1px dotted #999;padding: 3px 5px;color:blue;background:#F5F5DC;'>
			$jumRealGURUKELAS
		</td>
		<td align='center' style='vertical-align:middle;border: 1px dotted #999;padding: 3px 5px;'>
			$jumgurukelasideal
		</td>

		<td align='center' style='vertical-align:middle;border: 1px dotted #999;padding: 3px 5px;color:blue;background:#F5F5DC;'>
			$jumRealPJOK
		</td>
		<td align='center' style='vertical-align:middle;border: 1px dotted #999;padding: 3px 5px;'>
			$jumguruPJOKideal
		</td>

		<td align='center' style='vertical-align:middle;border: 1px dotted #999;padding: 3px 5px;color:blue;background:#F5F5DC;'>
			$jumRealPAI
		</td>
		<td align='center' style='vertical-align:middle;border: 1px dotted #999;padding: 3px 5px;'>
			$jumguruPAIideal
		</td>

		<td align='center' style='vertical-align:middle;border: 1px dotted #999;padding: 3px 5px;color:blue;background:#F5F5DC;'>
			$jumRealBING
		</td>
		<td align='center' style='vertical-align:middle;border: 1px dotted #999;padding: 3px 5px;'>
			$jumguruBINGideal
		</td>

		<td align='center' style='vertical-align:middle;border: 1px dotted #999;padding: 3px 5px;color:blue;background:#F5F5DC;'>
			$jumRealTIK
		</td>
		<td align='center' style='vertical-align:middle;border: 1px dotted #999;padding: 3px 5px;'>
			$jumguruTIKideal
		</td>

		<td align='center' style='vertical-align:middle;border: 1px dotted #999;padding: 3px 5px;color:blue;background:#F5F5DC;'>
			<strong>$jumTotalReal</strong>
		</td>
		<td align='center' style='vertical-align:middle;border: 1px dotted #999;padding: 3px 5px;'>
			<strong>$jumguruTOTALideal</strong>
		</td>

		<td align='center' style='vertical-align:middle;border: 1px dotted #999;padding: 3px 5px;color:$warnahurufreal ;'>
			<strong>$kuranggurureal</strong>
		</td>
		<td align='center' style='vertical-align:middle;border: 1px dotted #999;padding: 3px 5px;color:$warnahuruf ;'>
			<strong>$kurangguru</strong>
		</td>
	</tr>";
		}

		mysqli_free_result($result);
		mysqli_close($dbconn);
		?>
	</tbody>
</table>