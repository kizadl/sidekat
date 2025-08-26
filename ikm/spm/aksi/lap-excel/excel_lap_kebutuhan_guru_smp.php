<?php
header("Content-type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=kebutuhan-guru-smp.xls");
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
	$ketupload = "KURIKULUM SMP 2013 & KURIKULUM SMP MERDEKA";
} else if ($filterkebutuhan == "KMB") {
	$ketupload = "KURIKULUM SMP MERDEKA";
}

?>
<center>KEBUTUHAN GURU SEKOLAH MENENGAH PERTAMA (SMP)</center>
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
			<th colspan=26 style="background:#222;color:#fff;height:25px;">
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
				<center>PPKN</center>
			</th>
			<th colspan=2 style="background:#555;color:#fff;height:25px;width:90px">
				<center>B. Indonesia</center>
			</th>
			<th colspan=2 style="background:#666;color:#fff;height:25px;width:90px">
				<center>B. Inggris</center>
			</th>
			<th colspan=2 style="background:#555;color:#fff;height:25px;width:90px">
				<center>Matematika</center>
			</th>
			<th colspan=2 style="background:#666;color:#fff;height:25px;width:90px">
				<center>IPS</center>
			</th>
			<th colspan=2 style="background:#555;color:#fff;height:25px;width:90px">
				<center>IPA</center>
			</th>
			<th colspan=2 style="background:#666;color:#fff;height:25px;width:90px">
				<center>Prakarya</center>
			</th>
			<th colspan=2 style="background:#555;color:#fff;height:25px;width:90px">
				<center>Seni Budaya</center>
			</th>
			<th colspan=2 style="background:#666;color:#fff;height:25px;width:90px">
				<center>PJOK</center>
			</th>
			<th colspan=2 style="background:#555;color:#fff;height:25px;width:90px">
				<center>Agama</center>
			</th>
			<th colspan=2 style="background:#666;color:#fff;height:25px;width:90px">
				<center>TIK</center>
			</th>
			<th colspan=2 style="background:#555;color:#fff;height:25px;width:90px">
				<center>BK</center>
			</th>
			<th colspan=2 style="background:#666;color:#fff;height:25px;width:90px">
				<center>Jumlah</center>
			</th>
		</tr>
	</thead>
	<tbody>
		<?php
		$ketsekolah = "SMP";

		$qrijam = ("SELECT id_mapel,jumlah_jam
		FROM m_jam_mapel WHERE bentuk_pendidikan='" . $ketsekolah . "' AND aktif='Y'");
		$dbjumlahjam = mysqli_query($dbconn, $qrijam);
		while ($s = mysqli_fetch_array($dbjumlahjam)) {
			if ($s['id_mapel'] == "200010000") {
				$jmljamPPKN = $s['jumlah_jam'];
			}
			if ($s['id_mapel'] == "300110000") {
				$jmljamBIN = $s['jumlah_jam'];
			}
			if ($s['id_mapel'] == "300210000") {
				$jmljamBING = $s['jumlah_jam'];
			}
			if ($s['id_mapel'] == "401000000") {
				$jmljamMAT = $s['jumlah_jam'];
			}
			if ($s['id_mapel'] == "401200000") {
				$jmljamIPS = $s['jumlah_jam'];
			}
			if ($s['id_mapel'] == "401100000") {
				$jmljamIPA = $s['jumlah_jam'];
			}
			if ($s['id_mapel'] == "600070000") {
				$jmljamPRAKARYA = $s['jumlah_jam'];
			}
			if ($s['id_mapel'] == "600011000") {
				$jmljamSENI = $s['jumlah_jam'];
			}
			if ($s['id_mapel'] == "500010000") {
				$jmljamPJOK = $s['jumlah_jam'];
			}
			if ($s['id_mapel'] == "100011070" or $s['id_mapel'] == "100012050") {
				$jmljamPAI = $s['jumlah_jam'];
			}
			if ($s['id_mapel'] == "802000300") {
				$jmljamTIK = $s['jumlah_jam'];
			}

			if ($s['id_mapel'] == "500050000") {
				$jmljamBK = $s['jumlah_jam'];
			}
		}

		$qriBK = ("SELECT id_mapel,jumlah_siswa,minimal_siswa_rombel
		FROM m_jam_bk WHERE bentuk_pendidikan='" . $ketsekolah . "' AND aktif='Y'");
		$dbjumlahbk = mysqli_query($dbconn, $qriBK);
		while ($r = mysqli_fetch_array($dbjumlahbk)) {
			if ($r['id_mapel'] == "500050000") {
				$jmlsiswaBK = $r['jumlah_siswa'];
				$jmlminimumRombel = $r['minimal_siswa_rombel'];
			}
		}

		if ($filterkebutuhan == "semua") {

			$sqlx = ("SELECT DISTINCT p.id_sekolah,p.npsn,
			p.rombel_7,p.rombel_8,p.rombel_9,
			p.nama_sekolah,p.status_sekolah,p.bentuk_pendidikan,
			(p.ptk_l+p.ptk_p) AS JumPtk,
			(p.ptk_guru_l+p.ptk_guru_p) AS JumGuru
			FROM spm_sekolah p 
			WHERE p.bentuk_pendidikan='" . $ketsekolah . "' GROUP BY p.id_sekolah");
		} else if ($filterkebutuhan == "KMB") {

			$sqlx = ("SELECT DISTINCT p.id_sekolah,p.npsn,
			p.rombel_7,p.rombel_8,p.rombel_9,
			p.nama_sekolah,p.status_sekolah,p.bentuk_pendidikan,
			(p.ptk_l+p.ptk_p) AS JumPtk,
			(p.ptk_guru_l+p.ptk_guru_p) AS JumGuru
			FROM spm_sekolah p 
			LEFT JOIN spm_rombel r ON p.id_sekolah=r.id_sekolah
			WHERE p.bentuk_pendidikan='" . $ketsekolah . "' AND r.kurikulum='Kurikulum SMP Merdeka' AND p.id_sekolah=r.id_sekolah GROUP BY p.id_sekolah");
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

			$qrijml = ("SELECT COUNT(IF(r.kurikulum='Kurikulum SMP Merdeka',r.kurikulum,NULL)) AS jumKMB,
			COUNT(IF(r.kurikulum='Kurikulum SMP 2013',r.kurikulum,NULL)) AS jumK13 
			FROM spm_rombel r WHERE r.id_sekolah='" . $t['id_sekolah'] . "'");
			$dbjumlah = mysqli_query($dbconn, $qrijml);
			$c = mysqli_fetch_assoc($dbjumlah);
			$jumKMB = $c['jumKMB'];
			$jumK13 = $c['jumK13'];

			$jmlrombel = $t['rombel_7'] + $t['rombel_8'] + $t['rombel_9'];

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
				
				COUNT(IF(id_mapel_diampu='200010000',id,NULL)) AS jumRealPPKN,
				COUNT(IF(id_mapel_diampu='300110000',id,NULL)) AS jumRealBIN,
				COUNT(IF(id_mapel_diampu='300210000',id,NULL)) AS jumRealBING,
				COUNT(IF(id_mapel_diampu='401000000',id,NULL)) AS jumRealMAT,
				COUNT(IF(id_mapel_diampu='401200000',id,NULL)) AS jumRealIPS,
				COUNT(IF(id_mapel_diampu='401100000',id,NULL)) AS jumRealIPA,
				COUNT(IF(id_mapel_diampu='600070000',id,NULL)) AS jumRealPRAKARYA,
				COUNT(IF(id_mapel_diampu='600011000',id,NULL)) AS jumRealSENI,
				COUNT(IF(id_mapel_diampu='500010000',id,NULL)) AS jumRealPJOK,
				COUNT(IF(id_mapel_diampu='100011070' OR id_mapel_diampu='100012050',id,NULL)) AS jumRealPAI,
				COUNT(IF(id_mapel_diampu='802000300',id,NULL)) AS jumRealTIK,
				COUNT(IF(id_mapel_diampu='500050000',id,NULL)) AS jumRealBK

				FROM spm_ptk WHERE id_sekolah='" . $t['id_sekolah'] . "'");
			$dbjumlahpeg = mysqli_query($dbconn, $qrijmlpeg);
			$d = mysqli_fetch_assoc($dbjumlahpeg);

			$jumPNS = $d['jumPNS'] + $d['jumCPNS'] + $d['jumPNSBantu'] + $d['jumPNSDepag'];
			$jumPPPK = $d['jumP3K'];
			$jumGTY = $d['jumGTY'];
			$jumHonorer = $d['jumHonor'] + $d['jumGuruHonor'] + $d['jumTenagaHonor'] + $d['jumHonorDaerah'] + $d['jumLainnya'] + $d['jumNONPNS'] + $d['jumPengganti'];

			//// jumlah real guru mapel ////
			$jumRealPPKN =  $d['jumRealPPKN'];
			$jumRealBIN =  $d['jumRealBIN'];
			$jumRealBING =  $d['jumRealBING'];
			$jumRealMAT =  $d['jumRealMAT'];
			$jumRealIPS =  $d['jumRealIPS'];
			$jumRealIPA =  $d['jumRealIPA'];
			$jumRealPRAKARYA =  $d['jumRealPRAKARYA'];
			$jumRealSENI =  $d['jumRealSENI'];
			$jumRealPJOK =  $d['jumRealPJOK'];
			$jumRealPAI =  $d['jumRealPAI'];
			$jumRealTIK =  $d['jumRealTIK'];
			$jumRealBK =  $d['jumRealBK'];
			$jumTotalReal = $d['jumRealPPKN']+$d['jumRealBIN']+$d['jumRealBING']+$d['jumRealMAT']+$d['jumRealIPS']+$d['jumRealIPA']+$d['jumRealPRAKARYA']+$d['jumRealSENI']+$d['jumRealPJOK']+$d['jumRealPAI']+$d['jumRealTIK']+$d['jumRealBK'];
	
			//// ideal kebutuhan guru ////
			$jumguruPPKNideal = ($jmlrombel * $jmljamPPKN) / 24;
			$jumguruBINideal = ($jmlrombel * $jmljamBIN) / 24;
			$jumguruBINGideal = ($jmlrombel * $jmljamBING) / 24;
			$jumguruMATideal = ($jmlrombel * $jmljamMAT) / 24;
			$jumguruIPSideal = ($jmlrombel * $jmljamIPS) / 24;
			$jumguruIPAideal = ($jmlrombel * $jmljamIPA) / 24;

			$jumguruPrakaryaideal = ($jmlrombel * $jmljamPRAKARYA) / 24;
			$jumguruSeniideal = ($jmlrombel * $jmljamSENI) / 24;
			$jumguruPJOKideal = ($jmlrombel * $jmljamPJOK) / 24;
			$jumguruPAIideal = ($jmlrombel * $jmljamPAI) / 24;
			$jumguruTIKideal = ($jmlrombel * $jmljamTIK) / 24;

			$jumguruBKideal = ($jmlrombel * $jmlminimumRombel) / $jmlsiswaBK;

			$jumguruTOTALideal = round($jumguruPPKNideal) + round($jumguruBINideal) + round($jumguruBINGideal) + round($jumguruMATideal)
				+ round($jumguruIPSideal) + round($jumguruIPAideal) + round($jumguruPrakaryaideal) + round($jumguruSeniideal)
				+ round($jumguruPJOKideal) + round($jumguruPAIideal) + round($jumguruTIKideal) + round($jumguruBKideal);

			$kurangguru = $t['JumGuru'] - $jumguruTOTALideal;
			$kurangguru = round($kurangguru);

			$kuranggurureal = $jumTotalReal - $jumguruTOTALideal;
			if ($kuranggurureal <= 0){$warnahurufreal = "red";} else if ($kuranggurureal >= 1) {$warnahurufreal = "blue";}

			if ($kurangguru <= 0) {
				$warnahuruf = "red";
			} else if ($kurangguru >= 1) {
				$warnahuruf = "blue";
			}

			$jmlguru = round($t['JumGuru']);
			$jmlptt = $t['JumPtk']-$t['JumGuru'];

			$jumguruTOTALideal = round($jumguruTOTALideal);

			$jumguruPPKNideal = round($jumguruPPKNideal);
			$jumguruBINideal = round($jumguruBINideal);
			$jumguruBINGideal = round($jumguruBINGideal);
			$jumguruMATideal = round($jumguruMATideal);
			$jumguruIPSideal = round($jumguruIPSideal);
			$jumguruIPAideal = round($jumguruIPAideal);

			$jumguruPrakaryaideal = round($jumguruPrakaryaideal);
			$jumguruSeniideal = round($jumguruSeniideal);
			$jumguruPJOKideal = round($jumguruPJOKideal);
			$jumguruPAIideal = round($jumguruPAIideal);
			$jumguruTIKideal = round($jumguruTIKideal);
			$jumguruBKideal = round($jumguruBKideal);

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
			$jumRealPPKN
		</td>
		<td align='center' style='vertical-align:middle;border: 1px dotted #999;padding: 3px 5px;'>
			$jumguruPPKNideal
		</td>

		<td align='center' style='vertical-align:middle;border: 1px dotted #999;padding: 3px 5px;color:blue;background:#F5F5DC;'>
			$jumRealBIN
		</td>
		<td align='center' style='vertical-align:middle;border: 1px dotted #999;padding: 3px 5px;'>
			$jumguruBINideal
		</td>

		<td align='center' style='vertical-align:middle;border: 1px dotted #999;padding: 3px 5px;color:blue;background:#F5F5DC;'>
			$jumRealBING
		</td>
		<td align='center' style='vertical-align:middle;border: 1px dotted #999;padding: 3px 5px;'>
			$jumguruBINGideal
		</td>

		<td align='center' style='vertical-align:middle;border: 1px dotted #999;padding: 3px 5px;color:blue;background:#F5F5DC;'>
			$jumRealMAT
		</td>
		<td align='center' style='vertical-align:middle;border: 1px dotted #999;padding: 3px 5px;'>
			$jumguruMATideal
		</td>

		<td align='center' style='vertical-align:middle;border: 1px dotted #999;padding: 3px 5px;color:blue;background:#F5F5DC;'>
			$jumRealIPS
		</td>
		<td align='center' style='vertical-align:middle;border: 1px dotted #999;padding: 3px 5px;'>
			$jumguruIPSideal
		</td>

		<td align='center' style='vertical-align:middle;border: 1px dotted #999;padding: 3px 5px;color:blue;background:#F5F5DC;'>
			$jumRealIPA
		</td>
		<td align='center' style='vertical-align:middle;border: 1px dotted #999;padding: 3px 5px;'>
			$jumguruIPAideal
		</td>

		<td align='center' style='vertical-align:middle;border: 1px dotted #999;padding: 3px 5px;color:blue;background:#F5F5DC;'>
			$jumRealPRAKARYA
		</td>
		<td align='center' style='vertical-align:middle;border: 1px dotted #999;padding: 3px 5px;'>
			$jumguruPrakaryaideal
		</td>

		<td align='center' style='vertical-align:middle;border: 1px dotted #999;padding: 3px 5px;color:blue;background:#F5F5DC;'>
			$jumRealSENI
		</td>
		<td align='center' style='vertical-align:middle;border: 1px dotted #999;padding: 3px 5px;'>
			$jumguruSeniideal
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
			$jumRealTIK
		</td>
		<td align='center' style='vertical-align:middle;border: 1px dotted #999;padding: 3px 5px;'>
			$jumguruTIKideal
		</td>

		<td align='center' style='vertical-align:middle;border: 1px dotted #999;padding: 3px 5px;color:blue;background:#F5F5DC;'>
			$jumRealBK
		</td>
		<td align='center' style='vertical-align:middle;border: 1px dotted #999;padding: 3px 5px;'>
			$jumguruBKideal
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