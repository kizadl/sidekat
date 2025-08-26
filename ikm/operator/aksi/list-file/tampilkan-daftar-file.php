<?php

  if (trim($_POST['sttsupload']) == "on"){
    $dishapus = "";
  } else if (trim($_POST['sttsupload']) == "off"){
    $dishapus = "disabled";
  }

  if (trim($_POST['ruang']) == "video"){
    $namaruang = ucwords(strtolower(trim($_POST['ruang'])));
  } else {
    $namaruang = "Ruang ". ucwords(strtolower(trim($_POST['ruang'])));
  }
?>

<div class="modal-header px-4 position-relative modal-shape-header bg-shape">
  <div class="position-relative z-index-1 light">
    <h5 class="mb-0 text-white">File <?php echo $namaruang ?></h5>
      <p class="fs--1 mb-0 text-white">Sorot icon file untuk menghapus atau mengunduh file</p>
  </div>
  <button class="btn-close btn-close-white position-absolute top-0 end-0 mt-2 me-2" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<div class="modal-body py-3 px-4 bg-light">
  <?php
  error_reporting(0);
  $idsekolah = trim($_POST['idsekolah']);
  $ruang = trim($_POST['ruang']);
  if ($ruang == "video") {
    $dir = "../../../data-media/video/";
    $dirfile = "../data-media/video/";
    //////// hapus file ///////////
    $urlhapusfile = $_SERVER['DOCUMENT_ROOT']."/data-media/video/";
    ///////////////////////////////
    $source_files = glob($dir . $idsekolah . ".mp4");
  } else  {
    $dir = "../../../data-media/foto/" . $idsekolah . "/" . $ruang . "/";
    $dirfile = "../data-media/foto/" . $idsekolah . "/" . $ruang . "/";
    //////// hapus file ///////////
    $urlhapusfile = $_SERVER['DOCUMENT_ROOT']."/data-media/foto/" . $idsekolah . "/" . $ruang . "/";
    //////// //////////////////////
    $source_files = glob($dir . "*.jpeg");
  }

  if (count($source_files) == 0){
    echo "<p class='fs--1 mb-0 text-center'><strong>Terdeteksi tidak ada file yang ditemukan !!</strong></p>";
  }

  for ($i = 0; $i < count($source_files); $i++) {
 
    if ($ruang == "video") {
      $thumbfile = "../data-media/video.png";
    } else {
      $thumbfile = $dirfile . basename($source_files[$i]);
    }

    echo "
      <div class='d-flex mb-3 hover-actions-trigger align-items-center'>
        <div class='file-thumbnail'><img class='border h-100 w-100 fit-cover rounded-2' src='" . $thumbfile . "' alt='' />
        </div>
        <div class='ms-3 flex-shrink-1 flex-grow-1'>
          <h6 class='mb-1'><a class='stretched-link text-900 fw-semi-bold' href='#!'>" . basename($source_files[$i]) . "</a></h6>
            <div class='hover-actions end-0 top-50 translate-middle-y'><a class='btn btn-light border-300 btn-sm me-1 text-600' data-bs-toggle='tooltip' data-bs-placement='top' title='Download' href='" . $dirfile . basename($source_files[$i]) . "' download='". basename($source_files[$i]) ."'><img src='../assets/img/icons/cloud-download.svg' alt='' width='15' /></a>
              <button class='btn btn-light border-300 btn-sm me-1 text-600 shadow-none cmdHapusFile' type='button' data-ruang='".$ruang."' data-urlfile='".$urlhapusfile . basename($source_files[$i])."' data-bs-toggle='tooltip' data-bs-placement='top' title='Hapus' ".$dishapus." ><img src='../assets/img/icons/delete.svg' alt='' width='15' /></button>
            </div>
          </div>
        </div>
      <hr class='text-200' />";
  }
  ?>


</div>

<script type="text/javascript" charset="utf-8">
  $(".cmdHapusFile").on("click",function() {

    var idsekolah = $("#lblidinstansi").val();
    var ruang = $(this).data("ruang");
    var urlfile = $(this).data("urlfile");

    if (idsekolah.length <= 0) {
      alert('Sekolah tidak terdeteksi')
    } else if (ruang.length <= 0 || urlfile.length <= 0) {
      alert('Data ruangan tidak terdeteksi')
    } else {
      $.ajax({
        type: "POST",
        url: 'aksi/list-file/hapus_file.php',
        data: {idsekolah: idsekolah,ruang: ruang,urlfile: urlfile},
        beforeSend: function(e) {
          $(".cmdHapusFile").attr("disabled", "disabled");
        },
        success: function(resp) {
          $(".cmdHapusFile").removeAttr("disabled");
          if (resp == "ok"){
            alert("Proses hapus file sukses")
            $('#modBebasData').modal('hide');
          } else if (resp == "err"){
            alert("Gagal menghapus file kesalahan server\nAtau file tidak ditemukan")
            $('#modBebasData').modal('hide');
          }
        },
        error: function() {
          alert('Koneksi bermasalah periksa internet');
          $(".cmdHapusFile").removeAttr("disabled");
        },
      });
    };
  });

</script>