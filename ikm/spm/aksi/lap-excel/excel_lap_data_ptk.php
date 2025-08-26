<?php
header("Content-type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=data-ptk.xls");
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

$filtersekolah = trim($_GET['filtersekolah']);

if ($filtersekolah == "semua") {
	$ketupload = "SEMUA TINGKAT SEKOLAH";
} else if ($filtersekolah == "SD") {
	$ketupload = "SEKOLAH DASAR (SD)";
} else if ($filtersekolah == "SMP") {
	$ketupload = "SEKOLAH MENENGAH PERTAMA (SMP)";
}

?>
<center>DATA KEPEGAWAIAN (PTK)</center>
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
				<center>PTK</center>
			</th>
			<th colspan=4 style="background:#222;color:#fff;height:25px;">
				<center>Status Kepegawaian</center>
			</th>
		</tr>
		<tr>
			<th style="background:#555;color:#fff;height:25px;width:70px">
				<center>PTT</center>
			</th>
			<th style="background:#666;color:#fff;height:25px;width:70px">
				<center>Guru</center>
			</th>
			<th style="background:#555;color:#fff;height:25px;width:70px">
				<center>Jumlah</center>
			</th>

			<th style="background:#666;color:#fff;height:25px;width:70px">
				<center>PNS</center>
			</th>
			<th style="background:#555;color:#fff;height:25px;width:70px">
				<center>PPPK</center>
			</th>
			<th style="background:#666;color:#fff;height:25px;width:70px">
				<center>GTT</center>
			</th>
			<th style="background:#555;color:#fff;height:25px;width:70px">
				<center>Honorer</center>
			</th>
		</tr>
	</thead>
	<tbody>
		<?php

		if ($filtersekolah == "semua"){

			$sqlx = ("SELECT DISTINCT p.id_sekolah,p.npsn,
			p.nama_sekolah,p.status_sekolah,p.bentuk_pendidikan,
			(p.ptk_l+p.ptk_p) AS JumPtk,
			(p.ptk_guru_l+p.ptk_guru_p) AS JumGuru
			FROM spm_sekolah p 
			GROUP BY p.id_sekolah ORDER BY p.bentuk_pendidikan ASC");

		} else {

			$sqlx = ("SELECT DISTINCT p.id_sekolah,p.npsn,
			p.nama_sekolah,p.status_sekolah,p.bentuk_pendidikan,
			(p.ptk_l+p.ptk_p) AS JumPtk,
			(p.ptk_guru_l+p.ptk_guru_p) AS JumGuru
			FROM spm_sekolah p 
			WHERE p.bentuk_pendidikan ='".$filtersekolah."' GROUP BY p.id_sekolah ORDER BY p.bentuk_pendidikan ASC");
			
		} 

		$result = mysqli_query($dbconn, $sqlx);

		$no = 0;
		while ($t = mysqli_fetch_array($result)) {
			$no++;

			if (substr($t['nama_sekolah'],0,53) == "UNIT PELAKSANA TEKNIS DAERAH (UPTD) SATUAN PENDIDIKAN"){
				$nmsekolah = substr($t['nama_sekolah'],54);
			} else {
				$nmsekolah = $t['nama_sekolah'];
			}
		
			$JumPtk=$t['JumPtk'];
			$JumPTT=$t['JumPtk']-$t['JumGuru'];
			$JumGuru=$t['JumGuru'];

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
				FROM spm_ptk WHERE id_sekolah='".$t['id_sekolah']."'");
			$dbjumlahpeg = mysqli_query($dbconn, $qrijmlpeg);$d = mysqli_fetch_assoc($dbjumlahpeg);
		
			$jumPNS = $d['jumPNS']+$d['jumCPNS']+$d['jumPNSBantu']+$d['jumPNSDepag'];
			$jumPPPK = $d['jumP3K'];
			$jumGTY = $d['jumGTY'];
			$jumHonorer = $d['jumHonor']+$d['jumGuruHonor']+$d['jumTenagaHonor']+$d['jumHonorDaerah']+$d['jumLainnya']+$d['jumNONPNS']+$d['jumPengganti'];		

			$npsn = $t['npsn'];
			$sttssekolah = $t['status_sekolah'];
			$nmsekolah = $nmsekolah;

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
			$JumPTT
		</td>
		<td align='center' style='vertical-align:middle;border: 1px dotted #999;padding: 3px 5px;'>
			$JumGuru
		</td>
		<td align='center' style='vertical-align:middle;border: 1px dotted #999;padding: 3px 5px;'>
			$JumPtk
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
	</tr>";
		}

		mysqli_free_result($result);
		mysqli_close($dbconn);
		?>
	</tbody>
</table>