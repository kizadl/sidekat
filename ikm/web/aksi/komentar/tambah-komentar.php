<?php
error_reporting(0);
require_once '../../../services/config.php';
$dbconn = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname) or die('Could not connect: ');
?>

<div class="modal-header px-4 position-relative modal-shape-header bg-shape">
    <div class="position-relative z-index-1 light">
        <h5 class="mb-0 fs-1 text-white">Komentar Anda</h5>
        <p class="fs--1 mb-0 text-white">Silahkan melengkapi data untuk melanjutkan komentar</p>
    </div>
    <button class="btn-close btn-close-white position-absolute top-0 end-0 mt-2 me-2" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<div class="modal-body py-3 px-4">

    <div class="row mb-3 g-3">
        <div class="col-xxl-12">
            <div class="card bg-primary text-white h-lg-100">
                <div class="card-body d-flex align-items-center">
                    <p class="fs--1 mt-0 mb-0">
                        Isi dan lengkapi form isian data <strong>Komentar</strong> dibawah ini.<br />
                        Tekan tombol <strong>Simpan komentar</strong> untuk menyimpan komentar
                    </p>
                </div>
            </div>
        </div>
    </div>

    <div class="form-floating mb-3">
        <input type="text" class="form-control form-control-sm" id="txtnamakomen" value="" placeholder="Nama lengkap" maxlength="35" autocomplete="off">
        <label for="txtnamakomen">Nama Lengkap</label>
    </div>

    <div class="form-floating mb-3">
        <input type="text" class="form-control form-control-sm" id="txtemailkomen" value="" placeholder="Email" maxlength="50" autocomplete="off">
        <label for="txtemailkomen">Email</label>
    </div>

    <div class="form-floating mb-0">
        <textarea class="form-control form-control-sm" id="txtkomentar" placeholder="Tulis komentar.." maxlength="250" style="height: 100px"></textarea>
        <label for="txtkomentar">Isi Komentar</label>
    </div>

</div>

<div class="modal-footer justify-content-between">
    <button class="btn btn-sm btn-danger" type="button" data-bs-dismiss="modal">Batalkan</button>
    <button class="btn btn-sm btn-primary" type="button" id="cmdSimpanKomentar">Simpan Komentar</button>
</div>

<script type="text/javascript" charset="utf-8">
    $(document).ready(function() {
        $("#txtnamakomen").val("");
        $("#txtemailkomen").val("");
        $("#txtkomentar").val("");
    });
    
    $("#cmdSimpanKomentar").click(function() {
        var nama = $('#txtnamakomen').val();
        var email = $('#txtemailkomen').val();
        var validRegex = /^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/;
        var komentar = $('#txtkomentar').val();

        var data = new FormData();
        data.append('nama', nama);
        data.append('email', email);
        data.append('komentar', komentar);

        if (nama.length <= 0) {
            $('#txtnamakomen').focus();
            alert('Nama lengkap masih kosong')
        } else if (email.length <= 0) {
            $('#txtemailkomen').focus();
            alert('Alamat email masih kosong')
        } else if (!email.match(validRegex)) {
            alert("Email tidak valid");
            $('#txtemailkomen').focus();
        } else if (komentar.length <= 8) {
            $('#txtkomentar').focus();
            alert('Isi komentar masih kosong')
        } else {
            $.ajax({
                type: "POST",
                url: 'web/aksi/komentar/aksi_tambah_komentar.php',
                data: data,
                dataType: "json",
                processData: false,
                contentType: false,
                beforeSend: function(e) {
                    $("#cmdSimpanKomentar").attr("disabled", "disabled");
                },
                success: function(resp) {
                    if (resp.msg2 == 'ok') {
                        setTimeout(function() {
                            $('#modBebasSmall').modal('hide');
                            IsiKomentar();
                        }, 1000);
                    } else if (resp.msg2 == 'err_val') {
                        alert(resp.msg1);
                        $("#cmdSimpanKomentar").removeAttr("disabled");
                    } else {
                        alert('Ada sedikit masalah, silakan coba lagi.');
                        $("#cmdSimpanKomentar").removeAttr("disabled");
                    }
                },
                error: function() {
                    alert('Koneksi bermasalah periksa internet');
                    $("#cmdSimpanKomentar").removeAttr("disabled");
                    $(".modal-body").css("opacity", "");
                },
            });
        };
    });
</script>