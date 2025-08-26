<?php
header("Content-type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=detail-ptk.xls");
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

$idsekolah = trim($_GET['idsekolah']);

$sqlx = ("SELECT npsn,nama_sekolah,bentuk_pendidikan,status_sekolah,(ptk_l+ptk_p) AS jumPTK,(ptk_guru_l+ptk_guru_p) AS jumPTKGuru
  FROM spm_sekolah WHERE id_sekolah='" . $idsekolah . "'");
$result = mysqli_query($dbconn, $sqlx);
$sm = mysqli_fetch_assoc($result);

$npsn = $sm['npsn'];
$namasekolah = $sm['nama_sekolah'];
$bentukpendidikan = $sm['bentuk_pendidikan'];
$guru = $sm['jumPTKGuru'];
$ptt = $sm['jumPTK'] - $sm['jumPTKGuru'];
$statussekolah = $sm['status_sekolah'];

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
COUNT(IF(status_kepegawaian='Guru Pengganti',id,NULL)) AS jumPengganti
FROM spm_ptk WHERE id_sekolah='".$idsekolah."'");
$dbjumlahpeg = mysqli_query($dbconn, $qrijmlpeg);$d = mysqli_fetch_assoc($dbjumlahpeg);

$jumPNS = $d['jumPNS']+$d['jumCPNS']+$d['jumPNSBantu']+$d['jumPNSDepag'];
$jumPPPK = $d['jumP3K'];
$jumGTY = $d['jumGTY'];
$jumHonorer = $d['jumHonor']+$d['jumGuruHonor']+$d['jumTenagaHonor']+$d['jumHonorDaerah']+$d['jumLainnya']+$d['jumNONPNS']+$d['jumPengganti'];

mysqli_free_result($result);mysqli_free_result($dbjumlahpeg);
?>
<center>DATA KEPEGAWAIAN (PTK)</center>
<center><?php echo $namasekolah; ?></center>
<center>NPSN : <?php echo $npsn; ?> / <?php echo $bentukpendidikan; ?> / <?php echo $statussekolah; ?></center>
<center>JUMLAH PTT : <?php echo $ptt; ?> / JUMLAH GURU : <?php echo $guru; ?></center>
<center>PNS : <?php echo $jumPNS; ?> / PPPK : <?php echo $jumPPPK; ?> / GTT : <?php echo $jumGTY; ?> / HONORER : <?php echo $jumHonorer; ?></center>
<table>
	<thead>
		<tr>
			<th style="background:#222;color:#fff;height:35px;width:45px">
				<center>NO</center>
			</th>
			<th style="background:#444;color:#fff;height:35px;width:210px">
				<center>Nama Guru</center>
			</th>
			<th style="background:#222;color:#fff;height:35px;width:210px">
				<center>Jenis PTK</center>
			</th>
			<th style="background:#444;color:#fff;height:35px;width:350px">
				<center>Mata Pelajaran</center>
			</th>
			<th style="background:#222;color:#fff;height:35px;width:180px">
				<center>Status Kepegawaian</center>
			</th>
		</tr>
	</thead>
	<tbody>
		<?php
	
		$sqlxdet = ("SELECT nama_ptk,jenis_ptk,status_kepegawaian,status_guru,id_mapel_diampu,mapel_diampu
		FROM spm_ptk
		WHERE id_sekolah='".$idsekolah."' ORDER BY jenis_ptk ASC");

		$resultdet = mysqli_query($dbconn, $sqlxdet);
		$no = 0;
		while ($t = mysqli_fetch_array($resultdet)) {
			$no++;
			$namaptk = $t['nama_ptk'];
			$jenisptk = $t['jenis_ptk'];
			$statuskepegawaian = $t['status_kepegawaian'];
			$statusguru = $t['status_guru'];

			if ($statusguru == "Y"){
				$idmapel = $t['id_mapel_diampu'];
				$namamapel = $t['mapel_diampu'];
			} else if ($statusguru == "N"){
				$idmapel = "-";
				$namamapel = "-";
			}

			echo "	
	<tr style='height:25px;'>
        <td align='center' style='vertical-align:middle;border: 1px dotted #999;padding: 30px 15px;'>
			$no
		</td>
		<td align='left' style='vertical-align:middle;border: 1px dotted #999;padding: 30px 15px;'>
			$namaptk
		</td>
		<td align='left' style='vertical-align:middle;border: 1px dotted #999;padding: 30px 15px;'>
			$jenisptk
		</td>
		<td align='left' style='vertical-align:middle;border: 1px dotted #999;padding: 30px 15px;'>
			$namamapel
		</td>
		<td align='left' style='vertical-align:middle;border: 1px dotted #999;padding: 30px 15px;'>
			$statuskepegawaian
		</td>
	</tr>";
		}

		mysqli_free_result($resultdet);
		mysqli_close($dbconn);
		?>
	</tbody>
</table>