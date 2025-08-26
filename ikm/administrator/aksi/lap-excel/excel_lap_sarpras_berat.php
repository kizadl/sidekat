<?php
header("Content-type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=Laporan-sarpras-rusak-berat.xls");
header("Cache-Control: no-cache, must-revalidate");
header("Expires: MYDISPENDIK"); 

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

$ketwilayah= trim($_GET['ketwilayah']);
$idwilayah= trim($_GET['idwilayah']);
$nmwilayah= trim($_GET['nmwilayah']);

if ($ketwilayah=="kota"){$namawilayah = "Kabupaten Jember";}
else if ($ketwilayah=="kecamatan"){$namawilayah = "Kecamatan ".$nmwilayah;}
else if ($ketwilayah=="desa"){$namawilayah ="Desa ". $nmwilayah;}

?>
<center>REKAP DATA SARPRAS SEKOLAH KONDISI RUSAK BERAT</center>
<center><?php echo $namawilayah;?></center>
<center>Sampai Dengan Tanggal <?php echo $tanggal;?></center>

                 <table>
				  <thead>	  
                    <tr>
					  <th style="background:#666;color:#fff;height:25px;width:60px"><center>NO</center></th>
					  <th style="background:#555;color:#fff;height:25px;width:80px"><center>NPSN</center></th>
					  <th style="background:#666;color:#fff;height:25px;width:250px"><center>NAMA SEKOLAH</center></th>
					  <th style="background:#555;color:#fff;height:25px;width:400px"><center>ALAMAT</center></th>
					  <th style="background:#666;color:#fff;height:25px;width:160px"><center>DESA/KELURAHAN</center></th>
					  <th style="background:#555;color:#fff;height:25px;width:160px"><center>KECAMATAN</center></th>
					  <th style="background:#666;color:#fff;height:25px;width:70px"><center>SISWA</center></th>
					  <th style="background:#555;color:#fff;height:25px;width:70px"><center>GURU</center></th>
					</tr>
				  </thead>
				  <tbody>
<?php
if ($ketwilayah == "kota"){
    $sqlx = ("SELECT id,npsn,nama,alamat_jalan,desa_kelurahan,kecamatan,guru,siswa,bentuk_pendidikan,lintang,bujur
      FROM tbl_api_dispendik
      WHERE 
	  asrama_siswa_rusak_berat>0
		OR tempat_ibadah_rusak_berat>0
		OR wc_guru_rusak_berat>0
		OR wc_siswa_rusak_berat>0
		OR wc_umum_rusak_berat>0
		OR laboratorium_bahasa_rusak_berat>0
		OR laboratorium_ipa_rusak_berat>0
		OR laboratorium_ips_rusak_berat>0
		OR laboratorium_komputer_rusak_berat>0
		OR laboratorium_multimedia_rusak_berat>0
		OR ruang_bina_rusak_berat>0
		OR ruang_guru_rusak_berat>0
		OR ruang_kepala_sekolah_rusak_berat>0
		OR ruang_perpustakaan_rusak_berat>0
		OR ruang_kelas_rusak_berat>0");
} else if ($ketwilayah == "kecamatan"){
    $sqlx = ("SELECT id,npsn,nama,alamat_jalan,desa_kelurahan,kecamatan,guru,siswa,bentuk_pendidikan,lintang,bujur
      FROM tbl_api_dispendik
      WHERE 
	  asrama_siswa_rusak_berat>0 AND id_kecamatan = '".$idwilayah."'
		OR tempat_ibadah_rusak_berat>0 AND id_kecamatan = '".$idwilayah."'
		OR wc_guru_rusak_berat>0 AND id_kecamatan = '".$idwilayah."'
		OR wc_siswa_rusak_berat>0 AND id_kecamatan = '".$idwilayah."'
		OR wc_umum_rusak_berat>0 AND id_kecamatan = '".$idwilayah."'
		OR laboratorium_bahasa_rusak_berat>0 AND id_kecamatan = '".$idwilayah."'
		OR laboratorium_ipa_rusak_berat>0 AND id_kecamatan = '".$idwilayah."'
		OR laboratorium_ips_rusak_berat>0 AND id_kecamatan = '".$idwilayah."'
		OR laboratorium_komputer_rusak_berat>0 AND id_kecamatan = '".$idwilayah."'
		OR laboratorium_multimedia_rusak_berat>0 AND id_kecamatan = '".$idwilayah."'
		OR ruang_bina_rusak_berat>0 AND id_kecamatan = '".$idwilayah."'
		OR ruang_guru_rusak_berat>0 AND id_kecamatan = '".$idwilayah."'
		OR ruang_kepala_sekolah_rusak_berat>0 AND id_kecamatan = '".$idwilayah."'
		OR ruang_perpustakaan_rusak_berat>0 AND id_kecamatan = '".$idwilayah."'
		OR ruang_kelas_rusak_berat>0
        AND id_kecamatan = '".$idwilayah."'");
} else if ($ketwilayah == "desa"){
    $sqlx = ("SELECT id,npsn,nama,alamat_jalan,desa_kelurahan,kecamatan,guru,siswa,bentuk_pendidikan,lintang,bujur
      FROM tbl_api_dispendik
      WHERE 
	  asrama_siswa_rusak_berat>0 AND id_desa = '".$idwilayah."'
		OR tempat_ibadah_rusak_berat>0 AND id_desa = '".$idwilayah."'
		OR wc_guru_rusak_berat>0 AND id_desa = '".$idwilayah."'
		OR wc_siswa_rusak_berat>0 AND id_desa = '".$idwilayah."'
		OR wc_umum_rusak_berat>0 AND id_desa = '".$idwilayah."'
		OR laboratorium_bahasa_rusak_berat>0 AND id_desa = '".$idwilayah."'
		OR laboratorium_ipa_rusak_berat>0 AND id_desa = '".$idwilayah."'
		OR laboratorium_ips_rusak_berat>0 AND id_desa = '".$idwilayah."'
		OR laboratorium_komputer_rusak_berat>0 AND id_desa = '".$idwilayah."'
		OR laboratorium_multimedia_rusak_berat>0 AND id_desa = '".$idwilayah."'
		OR ruang_bina_rusak_berat>0 AND id_desa = '".$idwilayah."'
		OR ruang_guru_rusak_berat>0 AND id_desa = '".$idwilayah."'
		OR ruang_kepala_sekolah_rusak_berat>0 AND id_desa = '".$idwilayah."'
		OR ruang_perpustakaan_rusak_berat>0 AND id_desa = '".$idwilayah."'
		OR ruang_kelas_rusak_berat>0
        AND id_desa = '".$idwilayah."'");
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
	$alamatjalan = $t['alamat_jalan'];
	$desakelurahan = $t['desa_kelurahan'];
	$kecamatan = $t['kecamatan'];
	$siswa = $t['siswa'];
	$guru = $t['guru'];

echo "	
	<tr style='height:25px;'>
        <td align='center' style='vertical-align:middle;border: 1px dotted #999;padding: 30px 15px;'>
			$no
		</td>
		<td align='center' style='vertical-align:middle;border: 1px dotted #999;padding: 30px 15px;'>
			$npsn
		</td>
        <td align='left' style='vertical-align:middle;border: 1px dotted #999;padding: 3px 5px;'>
			$nminstansi
		</td>
        <td align='left' style='vertical-align:middle;border: 1px dotted #999;padding: 3px 5px;'>
			$alamatjalan
		</td>
		<td align='left' style='vertical-align:middle;border: 1px dotted #999;padding: 3px 5px;'>
			$desakelurahan
		</td>
		<td align='left' style='vertical-align:middle;border: 1px dotted #999;padding: 3px 5px;'>
			$kecamatan
		</td>
		<td align='center' style='vertical-align:middle;border: 1px dotted #999;padding: 3px 5px;'>
			$siswa
		</td>
		<td align='center' style='vertical-align:middle;border: 1px dotted #999;padding: 3px 5px;'>
			$guru
		</td>
	</tr>";
} 

mysqli_free_result($result);
mysqli_close($dbconn); 
?>  
				  </tbody>
                  </table>				  
