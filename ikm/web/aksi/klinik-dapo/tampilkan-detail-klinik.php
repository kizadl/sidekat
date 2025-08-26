<?php
error_reporting(0);
include '../../../services/config.php';
$dbconn = mysqli_connect($dbhost,$dbuser,$dbpass,$dbname)or die('Could not connect: '); 
include "../../../services/tgl_indo.php";

$sqlx = ("SELECT judul,isi_klinik,hari,tanggal,jam FROM klinik_dapo WHERE id_klinik='1'");
$result = mysqli_query($dbconn,$sqlx);$sm= mysqli_fetch_assoc($result);

$judul = $sm['judul'];
$isipengumuman = $sm['isi_klinik'];
$hari = $sm['hari'];
$tanggal = tgl_indo($sm['tanggal']); 

mysqli_free_result($result);
mysqli_close($dbconn);
?>
<!------------------MODAL PENCARIAN ------------------>
<div class="modal-header px-4 position-relative modal-shape-header bg-shape">
    <div class="position-relative z-index-1 light">
        <h5 class="mb-0 text-white">Klinik Dapo</h5>
        <p class="fs--1 mb-0 text-white">Klinik Dapo Dinas Pendidikan Kabupaten Jember</p>
    </div>
    <button class="btn-close btn-close-white position-absolute top-0 end-0 mt-2 me-2" data-bs-dismiss="modal"
        aria-label="Close"></button>
</div>
<div class="modal-body py-3">

    <div class="col-xxl-12 col-lg-12">
        <div class="card h-100 mb-3">
            <div class="card-body py-0 fs--1"> 
              <p class="mb-0 mt-3 fs-0 fw-semi-bold text-800"><?php echo $judul ?></p>
              <p class="mb-0 fs--1 text-600"><?php echo $hari.", ". $tanggal ?></p>
              <hr/>
              <p><?php echo $isipengumuman ?></p>
            </div>
        </div>
    </div>

</div>
