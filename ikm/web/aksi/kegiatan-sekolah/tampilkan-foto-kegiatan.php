<?php
error_reporting(0);
require_once '../../../services/config.php';
$dbconn = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname) or die('Could not connect: ');
date_default_timezone_set('Asia/Jakarta');

$idkegiatan = trim($_POST['idkegiatan']);
$nmsekolah = trim($_POST['nmsekolah']);

$qri = ("SELECT p.judul,p.isi_kegiatan FROM kegiatan_sekolah p 
  WHERE p.id_kegiatan='" . $idkegiatan . "'");
$dblayanan = mysqli_query($dbconn, $qri);
$d = mysqli_fetch_assoc($dblayanan);

$judul = ucwords(strtolower($d['judul']));
$isikegiatan = $d['isi_kegiatan'];

mysqli_free_result($dblayanan);
mysqli_close($dbconn);
?>
<div class="modal-body py-3 px-4">

  <input class="form-control form-control-sm datetimepicker fs--1" id="txtidkegiatanUpload" value="<?php echo $idkegiatan ?>" type="text" hidden />

      <div class="row mx-n1">

        <?php
        error_reporting(0);
        $idkegiatan = trim($_POST['idkegiatan']);

        $dir = "../../../data-media/foto/kegiatan/" . $idkegiatan . "/";
        $dirfile = "data-media/foto/kegiatan/" . $idkegiatan . "/";
        $source_files = glob($dir . "*.jpeg");


        if (count($source_files) == 0) {
          echo "<p class='fs--1 mb-0 text-center'><strong>Terdeteksi tidak ada file yang ditemukan !!</strong></p>";
        }

        for ($i = 0; $i < count($source_files); $i++) {

          $thumbfile = $dirfile . basename($source_files[$i]);

          echo "
            <div class='col-4 p-1'>
              <a class='post1' data-toggle='lightbox' href='$thumbfile' target='_blank' data-gallery='gallery-1'>
                <img class='img-fluid rounded' src='$thumbfile' alt='' />
              </a>
            </div>";
        }
        ?>

      </div>


</div>
