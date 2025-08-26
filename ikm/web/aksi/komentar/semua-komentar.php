<?php
error_reporting(0);
require_once '../../../services/config.php';
$dbconn = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname) or die('Could not connect: ');
?>

<div class="modal-header px-4 position-relative modal-shape-header bg-shape">
    <div class="position-relative z-index-1 light">
        <h5 class="mb-0 fs-1 text-white">Data Komentar Anda</h5>
        <p class="fs--1 mb-0 text-white">List semua data komentar</p>
    </div>
    <button class="btn-close btn-close-white position-absolute top-0 end-0 mt-2 me-2" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<div class="modal-body py-1 px-2">

    <div class="offcanvas-body scrollbar-overlay px-card h-100 mt-0 mb-4" id="area-semua-komentar">
    
    </div>
  

</div>

<script type="text/javascript" charset="utf-8">
    $(document).ready(function() {
        IsiSemuaKomentar();
    });

    function IsiSemuaKomentar() {
        $('#area-semua-komentar').html("");
        $.ajax({
            type: "POST",
            url: "web/aksi/komentar/isi_area_semua_komentar.php",
            beforeSend: function(e) {
                document.body.style.cursor = "wait";
            },
            success: function(data) {
                document.body.style.cursor = "default";
                $('#area-semua-komentar').html(data);
            },
            error: function() {
                document.body.style.cursor = "default";
            },
        });
    }
</script>