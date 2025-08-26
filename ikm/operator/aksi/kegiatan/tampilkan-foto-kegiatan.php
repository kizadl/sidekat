<?php
error_reporting(0);
require_once '../../../services/config.php';
$dbconn = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname) or die('Could not connect: ');
date_default_timezone_set('Asia/Jakarta');

$idkegiatan = trim($_POST['idkegiatan']);

$qri = ("SELECT judul,isi_kegiatan FROM kegiatan_sekolah WHERE id_kegiatan='" . $idkegiatan . "'");
$dblayanan = mysqli_query($dbconn, $qri);
$d = mysqli_fetch_assoc($dblayanan);

$judul = ucwords(strtolower($d['judul']));
$isikegiatan = $d['isi_kegiatan'];

mysqli_free_result($dblayanan);
mysqli_close($dbconn);
?>

<div class="modal-header px-4 position-relative modal-shape-header bg-shape">
  <div class="position-relative z-index-1 light">
    <h5 class="mb-0 text-white">Foto Kegiatan Sekolah</h5>
    <p class="fs--1 mb-0 text-white"><?php echo $judul ?></p>
  </div>
  <button class="btn-close btn-close-white position-absolute top-0 end-0 mt-2 me-2" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<div class="modal-body py-3 px-4">

  <input class="form-control form-control-sm datetimepicker fs--1" id="txtidkegiatanUpload" value="<?php echo $idkegiatan ?>" type="text" hidden />

  <div class="card mb-3">
    <div class="card-header">
      <h5 class="mb-0 fs--1">Headline</h5>
    </div>
    <div class="card-body bg-light">

      <div class="row mx-n1">
        <div class="col-6 p-1">
          <a class="post1" data-toggle="lightbox" href="../data-media/foto/headline/<?php echo $idkegiatan ?>.jpeg" target="_blank" data-gallery="gallery-1">
            <img class="img-fluid rounded" src="../data-media/foto/headline/<?php echo $idkegiatan ?>.jpeg" alt="" onerror=this.onerror=null;this.src="../data-media/headline.jpeg" />
          </a>
        </div>
      </div>

    </div>
  </div>

  <div class="card mb-0">
    <div class="card-header">
      <h5 class="mb-0 fs--1">Kegiatan Sekolah</h5>
    </div>
    <div class="card-body bg-light">


      <div class="row mx-n1">

        <?php
        error_reporting(0);
        $idkegiatan = trim($_POST['idkegiatan']);

        $dir = "../../../data-media/foto/kegiatan/" . $idkegiatan . "/";
        $dirfile = "../data-media/foto/kegiatan/" . $idkegiatan . "/";
        $source_files = glob($dir . "*.jpeg");


        if (count($source_files) == 0) {
          echo "<p class='fs--1 mb-0 text-center'><strong>Terdeteksi tidak ada file yang ditemukan !!</strong></p>";
        }

        for ($i = 0; $i < count($source_files); $i++) {

          $thumbfile = $dirfile . basename($source_files[$i]);

          echo "
            <div class='col-6 p-1'>
              <a class='post1' data-toggle='lightbox' href='$thumbfile' target='_blank' data-gallery='gallery-1'>
                <img class='img-fluid rounded' src='$thumbfile' alt='' />
              </a>
            </div>";
        }
        ?>

      </div>
    </div>
  </div>

</div>
<div class="modal-footer">
  <button class="btn btn-sm btn-falcon-danger" type="button" data-bs-dismiss="modal">Close</button>
</div>