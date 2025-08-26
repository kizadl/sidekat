<?php
error_reporting(0);
include '../../../services/config.php';
$dbconn = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname) or die('Could not connect: ');
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
			return "Jan";
			break;
		case 2:
			return "Feb";
			break;
		case 3:
			return "Mar";
			break;
		case 4:
			return "Apr";
			break;
		case 5:
			return "Mei";
			break;
		case 6:
			return "Jun";
			break;
		case 7:
			return "Jul";
			break;
		case 8:
			return "Agu";
			break;
		case 9:
			return "Sep";
			break;
		case 10:
			return "Okt";
			break;
		case 11:
			return "Nov";
			break;
		case 12:
			return "Des";
			break;
	}
} 

$idpengaduan = trim($_POST['idpengaduan']);

$sqlx = ("SELECT p.id_pengaduan,p.nik,p.nm_pengadu,p.alamat,p.no_telepon,p.uraian_masalah,p.uraian_penyelesaian,
p.tanggal,p.jam,p.tgl_distribusi,p.jam_distribusi,p.tgl_jawab,p.jam_jawab,p.stts_pengaduan,p.id_bidang,
p.id_operator_distribusi,p.id_operator_jawab,p.aktif,
q.nm_bidang
FROM pengaduan p LEFT JOIN m_bidang q ON p.id_bidang=q.id_bidang
WHERE p.id_pengaduan = '".$idpengaduan."' AND p.aktif='Y'");			
$result = mysqli_query($dbconn,$sqlx);$sm = mysqli_fetch_assoc($result);

$idpengaduan = $sm['id_pengaduan'];

$tanggal = tgl_indo($sm['tanggal']);
$jam = date("H:i", strtotime($sm['jam']));
$tgldistribusi = tgl_indo($sm['tgl_distribusi']);
$jamdistribusi = date("H:i", strtotime($sm['jam_distribusi']));
$tgljawab = tgl_indo($sm['tgl_jawab']);
$jamjawab = date("H:i", strtotime($sm['jam_jawab']));

$nik = $sm['nik'];
$nmpengadu = $sm['nm_pengadu'];
$alamat = $sm['alamat'];
$notelepon = $sm['no_telepon'];
$uraianmasalah = $sm['uraian_masalah'];

$nmbidang = $sm['nm_bidang'];
$uraianpenyelesaian = $sm['uraian_penyelesaian'];
$sttspengaduan = strtoupper($sm['stts_pengaduan']);
    
if ($sm['stts_pengaduan']=="belum"){
    $status = "Belum Ditindak Lanjuti";
    $hidentgldistribusi = "display:none;";
    $hidentglselesai = "display:none;";

    $tandadistribusi = "timeline-success timeline-current";
    $tandabidang = "timeline-default timeline-current";

} else if ($sm['stts_pengaduan']=="distribusi"){
    $status = "Sudah Ditindak Lanjuti";
    $hidentgldistribusi = "";
    $hidentglselesai = "display:none;";

    $tandadistribusi = "timeline-primary timeline-current";
    $tandabidang = "timeline-success timeline-current";

} else if ($sm['stts_pengaduan']=="jawaban"){
    $status = "Sudah Selesai";
    $hidentgldistribusi = "";
    $hidentglselesai = "";

    $tandadistribusi = "timeline-primary timeline-current";
    $tandabidang = "timeline-primary timeline-current";
}
  
$result->close();
$dbconn->close();
?>

<div class="row g-3 timeline timeline-primary timeline-past pb-card">
    <div class="col-auto ps-4 ms-2">
        <div class="ps-2">
            <div class="icon-item icon-item-sm rounded-circle bg-200 shadow-none"><span class="text-primary fas fa-user-tie"></span></div>
        </div>
    </div>
    <div class="col">
        <div class="row gx-0 border-bottom pb-card">
            <div class="col">
                <h6 class="text-800 mb-1"><?php echo $nmpengadu ?></h6>
                <p class="fs--1 text-800 mb-0"><?php echo $tanggal ?> - <?php echo $jam ?></p>
                <p class="fs--1 text-600 mb-0"><br/><strong>Uraian Masalah :</strong><br /><?php echo $uraianmasalah ?></p>
            </div>
        </div>
    </div>
</div>

<div class="row g-3 timeline <?php echo $tandadistribusi ?> pb-card">
    <div class="col-auto ps-4 ms-2">
        <div class="ps-2">
            <div class="icon-item icon-item-sm rounded-circle bg-200 shadow-none"><span class="text-primary fas fa-headphones"></span></div>
        </div>
    </div>
    <div class="col">
        <div class="row gx-0 border-bottom pb-card">
            <div class="col">
                <h6 class="text-800 mb-1">Pelimpahan Ke Bidang <?php echo $nmbidang ?></h6>
                <p class="fs--1 text-600 mb-0" style="<?php echo $hidentgldistribusi ?>"><?php echo $tgldistribusi ?> - <?php echo $jamdistribusi ?></p>
                <p class="fs--1 text-600 mb-0">Status <?php echo $status ?></p>
            </div>

        </div>
    </div>
</div>

<div class="row g-3 timeline <?php echo $tandabidang ?>">
    <div class="col-auto ps-4 ms-2">
        <div class="ps-2">
            <div class="icon-item icon-item-sm rounded-circle bg-200 shadow-none"><span class="text-primary fas fa-chalkboard-teacher"></span></div>
        </div>
    </div>
    <div class="col">
        <div class="row gx-0">
            <div class="col">
                <h6 class="text-800 mb-1">Bidang <?php echo $nmbidang ?></h6>
                <p class="fs--1 text-600 mb-0" style="<?php echo $hidentglselesai ?>"><?php echo $tgljawab ?> - <?php echo $jamjawab ?></p>
                <p class="fs--1 text-600 mb-0">Status Akhir : <?php echo $status ?></p>

                <p class="fs--1 text-800 mb-0" style="<?php echo $hidentglselesai ?>"><br /><strong>Uraian Penyelesaian Masalah :</strong><br /><?php echo $uraianpenyelesaian ?></p>
            </div>

        </div>
    </div>
</div>
