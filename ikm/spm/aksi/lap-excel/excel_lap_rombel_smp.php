<?php
header("Content-type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=rombel-smp.xls");
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

$filterrombel = trim($_GET['filterrombel']);

if ($filterrombel == "semua") {
	$ketupload = "KURIKULUM SMP 2013 & KURIKULUM SMP MERDEKA";
} else if ($filterrombel == "KMB") {
	$ketupload = "KURIKULUM SMP MERDEKA";
}

?>
<center>ROMBONGAN BELAJAR SEKOLAH MENENGAH PERTAMA (SMP)</center>
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
				<center>Rombongan Belajar</center>
			</th>
			<th rowspan=2 style="background:#222;color:#fff;height:25px;width:80px">
				<center>Jumlah</center>
			</th>
			<th colspan=2 style="background:#444;color:#fff;height:25px;">
				<center>Kurikulum</center>
			</th>
		</tr>
		<tr>
			<th style="background:#555;color:#fff;height:25px;width:60px">
				<center>7</center>
			</th>
			<th style="background:#666;color:#fff;height:25px;width:60px">
				<center>8</center>
			</th>
			<th style="background:#555;color:#fff;height:25px;width:60px">
				<center>9</center>
			</th>

			<th style="background:#555;color:#fff;height:25px;width:60px">
				<center>K-13</center>
			</th>
			<th style="background:#666;color:#fff;height:25px;width:60px">
				<center>KMB</center>
			</th>
		</tr>
	</thead>
	<tbody>
		<?php
		$ketsekolah = "SMP";

		if ($filterrombel == "semua") {

			$sqlx = ("SELECT DISTINCT p.id_sekolah,p.npsn,
	p.rombel_1,p.rombel_2,p.rombel_3,p.rombel_4,p.rombel_5,p.rombel_6,p.rombel_7,p.rombel_8,p.rombel_9,
	q.nama,q.status_sekolah,q.bentuk_pendidikan
	FROM spm_sekolah p 
	LEFT JOIN tbl_api_dispendik q ON p.npsn=q.npsn
	WHERE q.bentuk_pendidikan='" . $ketsekolah . "' GROUP BY p.id_sekolah");
		} else if ($filterrombel == "KMB") {

			$sqlx = ("SELECT DISTINCT p.id_sekolah,p.npsn,
	p.rombel_1,p.rombel_2,p.rombel_3,p.rombel_4,p.rombel_5,p.rombel_6,p.rombel_7,p.rombel_8,p.rombel_9,
	q.nama,q.status_sekolah,q.bentuk_pendidikan
	FROM spm_sekolah p 
	LEFT JOIN tbl_api_dispendik q ON p.npsn=q.npsn
	LEFT JOIN spm_rombel r ON p.id_sekolah=r.id_sekolah
	WHERE q.bentuk_pendidikan='" . $ketsekolah . "' AND r.kurikulum='Kurikulum SMP Merdeka' AND p.id_sekolah=r.id_sekolah GROUP BY p.id_sekolah");
		}

		$result = mysqli_query($dbconn, $sqlx);

		$no = 0;
		while ($t = mysqli_fetch_array($result)) {
			$no++;

			if (substr($t['nama'], 0, 53) == "UNIT PELAKSANA TEKNIS DAERAH (UPTD) SATUAN PENDIDIKAN") {
				$nmsekolah = substr($t['nama'], 54);
			} else {
				$nmsekolah = $t['nama'];
			}

			if ($ketsekolah == "SD") {
				$qrijml = ("SELECT COUNT(IF(r.kurikulum='Kurikulum SD Merdeka',r.kurikulum,NULL)) AS jumKMB,
				COUNT(IF(r.kurikulum='Kurikulum SD 2013',r.kurikulum,NULL)) AS jumK13 
				FROM spm_rombel r WHERE r.id_sekolah='" . $t['id_sekolah'] . "'");
				$dbjumlah = mysqli_query($dbconn, $qrijml);
				$c = mysqli_fetch_assoc($dbjumlah);
			} else if ($ketsekolah == "SMP") {
				$qrijml = ("SELECT COUNT(IF(r.kurikulum='Kurikulum SMP Merdeka',r.kurikulum,NULL)) AS jumKMB,
				COUNT(IF(r.kurikulum='Kurikulum SMP 2013',r.kurikulum,NULL)) AS jumK13 
				FROM spm_rombel r WHERE r.id_sekolah='" . $t['id_sekolah'] . "'");
				$dbjumlah = mysqli_query($dbconn, $qrijml);
				$c = mysqli_fetch_assoc($dbjumlah);
			}

			$jumKMB = $c['jumKMB'];
			$jumK13 = $c['jumK13'];

			$jmlrombel = $t['rombel_1'] + $t['rombel_2'] + $t['rombel_3'] + $t['rombel_4'] + $t['rombel_5'] + $t['rombel_6'] + $t['rombel_7'] + $t['rombel_8'] + $t['rombel_9'];

			$npsn = $t['npsn'];
			$sttssekolah = $t['status_sekolah'];
			$nmsekolah = $nmsekolah;
			$rombel1 = $t['rombel_1'];
			$rombel2 = $t['rombel_2'];
			$rombel3 = $t['rombel_3'];
			$rombel4 = $t['rombel_4'];
			$rombel5 = $t['rombel_5'];
			$rombel6 = $t['rombel_6'];
			$rombel7 = $t['rombel_7'];
			$rombel8 = $t['rombel_8'];
			$rombel9 = $t['rombel_9'];

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
			$rombel7
		</td>
		<td align='center' style='vertical-align:middle;border: 1px dotted #999;padding: 3px 5px;'>
			$rombel8
		</td>
		<td align='center' style='vertical-align:middle;border: 1px dotted #999;padding: 3px 5px;'>
			$rombel9
		</td>
		<td align='center' style='vertical-align:middle;border: 1px dotted #999;padding: 3px 5px;'>
			$jmlrombel
		</td>
		<td align='center' style='vertical-align:middle;border: 1px dotted #999;padding: 3px 5px;'>
			$jumK13
		</td>
		<td align='center' style='vertical-align:middle;border: 1px dotted #999;padding: 3px 5px;'>
			$jumKMB
		</td>
	</tr>";
		}

		mysqli_free_result($result);
		mysqli_close($dbconn);
		?>
	</tbody>
</table>