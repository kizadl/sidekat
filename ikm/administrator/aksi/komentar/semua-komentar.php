<?php
error_reporting(0);
require_once '../../../services/config.php';
$dbconn = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname) or die('Could not connect: ');
?>

<div class="modal-header px-4 position-relative modal-shape-header bg-shape">
    <div class="position-relative z-index-1 light">
        <h5 class="mb-0 fs-1 text-white">Data Komentar</h5>
        <p class="fs--1 mb-0 text-white">List semua data komentar</p>
    </div>
    <button class="btn-close btn-close-white position-absolute top-0 end-0 mt-2 me-2" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<div class="modal-body py-1 px-2">
    <div class="offcanvas-body scrollbar-overlay px-card h-100 mt-0 mb-4" id="area-semua-komentar"></div>
</div>

<script type="text/javascript" charset="utf-8">
    $(document).ready(function() {
        IsiSemuaKomentar();
    });

    function IsiSemuaKomentar() {
        $('#area-semua-komentar').html("");
        $.ajax({
            type: "POST",
            url: "aksi/komentar/isi_area_semua_komentar.php",
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

    $('#area-semua-komentar').on('click', '.cmdBalasKomentar', function() {
        var idkomentar = $(this).data('idkomentar');
        $.ajax({
            type: "POST",
            url: "aksi/komentar/balas-komentar.php",
            data: {
                idkomentar: idkomentar
            },
            success: function(resp) {
                $("#isianmodBalasKomenBebas").html(resp);
                $("#isianmodBalasKomenBebas").fadeIn(1000);
                $("#modBalasKomenBebas").modal('show');
            },
            error: function() {
                alert('Koneksi bermasalah periksa internet');
            },
        });
    });

    $('#area-semua-komentar').on('click', '.cmdHapusKomentar', function() {
        var idkomentar = $(this).data('idkomentar');var nama = $(this).data('nama');
        var tglbalas = $(this).data('tglbalas');
        let text = "Yakin Anda menghapus data komentar\n"+nama+"\n"+tglbalas;
        if (confirm(text) == true) {
        $.ajax({
            type:"POST",		
            url :"aksi/komentar/aksi_hapus_komentar.php",	
            data:{idkomentar:idkomentar},
            success:function(resp){
                IsiSemuaKomentar();	
            },
            error: function() {alert('Koneksi bermasalah periksa internet');},
        });
        }  
    });

    $('#area-semua-komentar').on('click', '.cmdHapusBalasKomentar', function() {
        var idkomentar = $(this).data('idkomentar');var nama = $(this).data('nama');
        var tglbalas = $(this).data('tglbalas');
        let text = "Yakin Anda menghapus data komentar\n"+nama+"\n"+tglbalas;
        if (confirm(text) == true) {
        $.ajax({
            type:"POST",		
            url :"aksi/komentar/aksi_hapus_balas_komentar.php",	
            data:{idkomentar:idkomentar},
            success:function(resp){
                IsiSemuaKomentar();	
            },
            error: function() {alert('Koneksi bermasalah periksa internet');},
        });
        }  
    });

</script>