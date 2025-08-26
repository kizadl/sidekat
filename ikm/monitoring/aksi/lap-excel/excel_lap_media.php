<?php
header("Content-type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=Laporan-media.xls");
header("Cache-Control: no-cache, must-revalidate");
header("Expires: IKM"); 

error_reporting(0);
include '../../../services/config.php';
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

$filtermedia= trim($_GET['filtermedia']);

if ($filtermedia == "semua"){
	$ketupload = "SEMUA DATA MEDIA";
} else if ($filtermedia == "Y"){
	$ketupload = "SUDAH UPLOAD DATA MEDIA";	
} else if ($filtermedia == "N"){
	$ketupload = "BELUM UPLOAD DATA MEDIA";	
}

?>
<center>REKAP JUMLAH DATA UPLOAD MEDIA</center>
<center><?php echo $ketupload;?></center>
<center>Sampai Dengan Tanggal <?php echo $tanggal;?></center>

                 <table>
				  <thead>	  
                    <tr>
					  <th rowspan=2 style="background:#222;color:#fff;height:25px;width:75px"><center>NPSN</center></th>
					  <th rowspan=2 style="background:#222;color:#fff;height:25px;width:250px"><center>Nama Sekolah</center></th>	
					  <th colspan=16 style="background:#444;color:#fff;height:25px;"><center>Data Media Upload</center></th>
					  <th rowspan=2 style="background:#222;color:#fff;height:25px;width:80px"><center>Jumlah</center></th>	
                    </tr>
                    <tr>
					  <th style="background:#555;color:#fff;height:25px;width:60px"><center>Video</center></th>
					  <th style="background:#666;color:#fff;height:25px;width:60px"><center>Kelas</center></th>
					  <th style="background:#555;color:#fff;height:25px;width:60px"><center>Perpus</center></th>
					  <th style="background:#666;color:#fff;height:25px;width:60px"><center>Kepsek</center></th>
					  <th style="background:#555;color:#fff;height:25px;width:60px"><center>Guru</center></th>
					  <th style="background:#666;color:#fff;height:25px;width:60px"><center>Bina</center></th>
					  <th style="background:#555;color:#fff;height:25px;width:60px"><center>MM</center></th>
					  <th style="background:#666;color:#fff;height:25px;width:60px"><center>Komp</center></th>
					  <th style="background:#555;color:#fff;height:25px;width:60px"><center>IPS</center></th>
					  <th style="background:#666;color:#fff;height:25px;width:60px"><center>IPA</center></th>
					  <th style="background:#555;color:#fff;height:25px;width:60px"><center>Bhs</center></th>
					  <th style="background:#666;color:#fff;height:25px;width:60px"><center>Wc Umum</center></th>
					  <th style="background:#555;color:#fff;height:25px;width:60px"><center>Wc Siswa</center></th>
					  <th style="background:#666;color:#fff;height:25px;width:60px"><center>Wc Guru</center></th>
					  <th style="background:#555;color:#fff;height:25px;width:60px"><center>Ibadah</center></th>
					  <th style="background:#666;color:#fff;height:25px;width:60px"><center>Asrama</center></th>
					</tr>
				  </thead>
				  <tbody>
<?php
if ($filtermedia == "semua"){
	$sqlx = ("SELECT p.id,p.npsn,p.video,p.kelas,p.perpustakaan,p.kepsek,p.guru,p.pembinaan,p.multimedia,p.komputer,p.ips,p.ipa,
		p.bahasa,p.wc_umum,p.wc_siswa,p.wc_guru,p.ibadah,p.asrama,p.jml_media,q.nama,q.lintang,q.bujur
		FROM tbl_media p LEFT JOIN tbl_api_dispendik q ON p.id=q.id");		
} else if ($filtermedia == "Y"){
	$sqlx = ("SELECT p.id,p.npsn,p.video,p.kelas,p.perpustakaan,p.kepsek,p.guru,p.pembinaan,p.multimedia,p.komputer,p.ips,p.ipa,
		p.bahasa,p.wc_umum,p.wc_siswa,p.wc_guru,p.ibadah,p.asrama,p.jml_media,q.nama,q.lintang,q.bujur
		FROM tbl_media p LEFT JOIN tbl_api_dispendik q ON p.id=q.id
		WHERE p.jml_media > 0");		
} else if ($filtermedia == "N"){
	$sqlx = ("SELECT p.id,p.npsn,p.video,p.kelas,p.perpustakaan,p.kepsek,p.guru,p.pembinaan,p.multimedia,p.komputer,p.ips,p.ipa,
		p.bahasa,p.wc_umum,p.wc_siswa,p.wc_guru,p.ibadah,p.asrama,p.jml_media,q.nama,q.lintang,q.bujur
		FROM tbl_media p LEFT JOIN tbl_api_dispendik q ON p.id=q.id
		WHERE p.jml_media = 0");		
}
$result = mysqli_query($dbconn,$sqlx);

$no=0;
while($t=mysqli_fetch_array($result)){
	$no++;
	
	if (substr($t['nama'],0,53) == "UNIT PELAKSANA TEKNIS DAERAH (UPTD) SATUAN PENDIDIKAN"){
		$nminstansi = substr($t['nama'],54);
	} else {
		$nminstansi = $t['nama'];
	}

	$npsn = $t['npsn'];
	$video = $t['video'];
	$kelas = $t['kelas'];
	$perpustakaan = $t['perpustakaan'];
	$kepsek = $t['kepsek'];
	$guru = $t['guru'];
	$pembinaan = $t['pembinaan'];
	$multimedia = $t['multimedia'];
	$komputer = $t['komputer'];
	$ips = $t['ips'];
	$ipa = $t['ipa'];
	$bahasa = $t['bahasa'];
	$wcumum = $t['wc_umum'];
	$wcsiswa = $t['wc_siswa'];
	$wcguru = $t['wc_guru'];
	$ibadah = $t['ibadah'];
	$asrama = $t['asrama'];
	$jmlmedia = $t['jml_media'];	

echo "	
	<tr style='height:25px;'>
        <td align='center' style='vertical-align:middle;border: 1px dotted #999;padding: 30px 15px;'>
			$npsn
		</td>
        <td align='left' style='vertical-align:middle;border: 1px dotted #999;padding: 3px 5px;'>
			$nminstansi
		</td>
        <td align='center' style='vertical-align:middle;border: 1px dotted #999;padding: 3px 5px;'>
			$video
		</td>
		<td align='center' style='vertical-align:middle;border: 1px dotted #999;padding: 3px 5px;'>
			$kelas
		</td>
		<td align='center' style='vertical-align:middle;border: 1px dotted #999;padding: 3px 5px;'>
			$perpustakaan
		</td>
		<td align='center' style='vertical-align:middle;border: 1px dotted #999;padding: 3px 5px;'>
			$kepsek
		</td>
		<td align='center' style='vertical-align:middle;border: 1px dotted #999;padding: 3px 5px;'>
			$guru
		</td>
		<td align='center' style='vertical-align:middle;border: 1px dotted #999;padding: 3px 5px;'>
			$pembinaan
		</td>
		<td align='center' style='vertical-align:middle;border: 1px dotted #999;padding: 3px 5px;'>
			$multimedia
		</td>
		<td align='center' style='vertical-align:middle;border: 1px dotted #999;padding: 3px 5px;'>
			$komputer
		</td>
		<td align='center' style='vertical-align:middle;border: 1px dotted #999;padding: 3px 5px;'>
			$ips
		</td>
		<td align='center' style='vertical-align:middle;border: 1px dotted #999;padding: 3px 5px;'>
			$ipa
		</td>
		<td align='center' style='vertical-align:middle;border: 1px dotted #999;padding: 3px 5px;'>
			$bahasa
		</td>
		<td align='center' style='vertical-align:middle;border: 1px dotted #999;padding: 3px 5px;'>
			$wcumum
		</td>
		<td align='center' style='vertical-align:middle;border: 1px dotted #999;padding: 3px 5px;'>
			$wcsiswa
		</td>
		<td align='center' style='vertical-align:middle;border: 1px dotted #999;padding: 3px 5px;'>
			$wcguru
		</td>
		<td align='center' style='vertical-align:middle;border: 1px dotted #999;padding: 3px 5px;'>
			$ibadah
		</td>
		<td align='center' style='vertical-align:middle;border: 1px dotted #999;padding: 3px 5px;'>
			$asrama
		</td>
		<td align='center' style='vertical-align:middle;border: 1px dotted #999;padding: 3px 5px;'>
			$jmlmedia
		</td>	
	</tr>";
} 

mysqli_free_result($result);
mysqli_close($dbconn); 
?>  
				  </tbody>
                  </table>				  
