<?php
header("Content-type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=pembelajaran.xls");
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

$sqlx = ("SELECT npsn,nama_sekolah,bentuk_pendidikan,status_sekolah,(ptk_l+ptk_p) AS jumPTK,(ptk_guru_l+ptk_guru_p) AS jumPTKGuru,
  rombel_1,rombel_2,rombel_3,rombel_4,rombel_5,rombel_6,rombel_7,rombel_8,rombel_9
  FROM spm_sekolah WHERE id_sekolah='" . $idsekolah . "'");
$result = mysqli_query($dbconn, $sqlx);
$sm = mysqli_fetch_assoc($result);

$nmsekolah = $sm['nama_sekolah'];
$npsn = $sm['npsn'];
$bentukpendidikan = $sm['bentuk_pendidikan'];
$guru = $sm['jumPTKGuru'];
$ptk = $sm['jumPTK'];
$statussekolah = $sm['status_sekolah'];

$rombel1 = $sm['rombel_1'];
$rombel2 = $sm['rombel_2'];
$rombel3 = $sm['rombel_3'];
$rombel4 = $sm['rombel_4'];
$rombel5 = $sm['rombel_5'];
$rombel6 = $sm['rombel_6'];
$rombel7 = $sm['rombel_7'];
$rombel8 = $sm['rombel_8'];
$rombel9 = $sm['rombel_9'];

$jmlrombel = $rombel1 + $rombel2 + $rombel3 + $rombel4 + $rombel5 + $rombel6 + $rombel7 + $rombel8 + $rombel9;

?>
<center>DATA PEMBELAJARAN</center>
<center><?php echo $nmsekolah; ?></center>
<center>NPSN : <?php echo $npsn; ?> / <?php echo $bentukpendidikan; ?> / <?php echo $statussekolah; ?></center>
<center>JUMLAH PTK : <?php echo $ptk; ?> / GURU : <?php echo $guru; ?> / ROMBEL : <?php echo $jmlrombel; ?></center>
<table>
	<thead>
		<tr>
			<th style="background:#444;color:#fff;height:35px;width:45px">
				<center>NO</center>
			</th>
			<th style="background:#222;color:#fff;height:35px;width:85px">
				<center>Rombel</center>
			</th>
			<th style="background:#444;color:#fff;height:35px;width:250px">
				<center>Nama Guru</center>
			</th>
			<th style="background:#222;color:#fff;height:35px;width:90px">
				<center>Kode Mapel</center>
			</th>
			<th style="background:#444;color:#fff;height:35px;width:330px">
				<center>Mata Pelajaran</center>
			</th>
			<th style="background:#222;color:#fff;height:35px;width:60px">
				<center>Jam</center>
			</th>
			<th style="background:#444;color:#fff;height:35px;width:200px">
				<center>Status Kurikulum</center>
			</th>
		</tr>
	</thead>
	<tbody>
		<?php
	
		$sqlx = ("SELECT p.id_mapel,p.nama_mapel,
		p.nama_ptk,p.jam_mengajar,p.ket_status_kurikulum,
		r.tingkat_pendidikan
		FROM spm_pembelajaran p 
		LEFT JOIN spm_rombel r ON p.id_rombel=r.id_rombel
		WHERE p.id_sekolah='".$idsekolah."'");

		$result = mysqli_query($dbconn, $sqlx);
		$no = 0;
		while ($t = mysqli_fetch_array($result)) {
			$no++;

			$idmapel = $t['id_mapel'];
			$namamapel = $t['nama_mapel'];
			$namaptk = $t['nama_ptk'];
			$jam = $t['jam_mengajar'];
			$ketkurikulum = $t['ket_status_kurikulum'];
			$kelas = $t['tingkat_pendidikan'];
			echo "	
	<tr style='height:25px;'>
        <td align='center' style='vertical-align:middle;border: 1px dotted #999;padding: 30px 15px;'>
			$no
		</td>
		<td align='center' style='vertical-align:middle;border: 1px dotted #999;padding: 30px 15px;'>
			$kelas
		</td>
		<td align='left' style='vertical-align:middle;border: 1px dotted #999;padding: 30px 15px;'>
			$namaptk
		</td>
        <td align='center' style='vertical-align:middle;border: 1px dotted #999;padding: 3px 5px;'>
			$idmapel
		</td>
		<td align='left' style='vertical-align:middle;border: 1px dotted #999;padding: 30px 15px;'>
			$namamapel
		</td>
        <td align='center' style='vertical-align:middle;border: 1px dotted #999;padding: 3px 5px;'>
			$jam
		</td>
		<td align='left' style='vertical-align:middle;border: 1px dotted #999;padding: 30px 15px;'>
			$ketkurikulum
		</td>
	</tr>";
		}

		mysqli_free_result($result);
		mysqli_close($dbconn);
		?>
	</tbody>
</table>