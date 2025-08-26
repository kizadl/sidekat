<?php
error_reporting(0);
require_once '../../../services/config.php';
include '../../../services/tgl_indo.php';
$dbconn = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname) or die('Could not connect: ');
date_default_timezone_set('Asia/Jakarta');

$idkomentar = trim($_POST['idkomentar']);
$qri = ("SELECT * FROM komentar WHERE id_komentar='" . $idkomentar . "'");
$dblayanan = mysqli_query($dbconn, $qri);
$d = mysqli_fetch_assoc($dblayanan);

$tglkomentar = tgl_indo($d['tgl_komentar']);$jamkomentar = $d['jam_komentar'];
$nama = ucwords(strtolower($d['nama']));
$isikomentar = $d['isi_komentar'];

mysqli_free_result($dblayanan);
mysqli_close($dbconn);
?>

<div class="modal-header px-4 position-relative modal-shape-header bg-shape">
    <div class="position-relative z-index-1 light">
        <h5 class="mb-0 fs-1 text-white">Balas Komentar</h5>
        <p class="fs--1 mb-0 text-white">Silahkan melengkapi data untuk melanjutkan membalas komentar</p>
    </div>
    <button class="btn-close btn-close-white position-absolute top-0 end-0 mt-2 me-2" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<div class="modal-body py-3 px-4">

    <div class="row mb-3 g-3">
        <div class="col-xxl-12">
            <div class="card bg-primary text-white h-lg-100">
                <div class="card-body d-flex align-items-center">
                    <p class="fs--1 mt-0 mb-0">
                        <?php echo $tglkomentar ?> - <?php echo $jamkomentar ?><br/>
                        <strong><?php echo $nama ?></strong><br />
                        <?php echo $isikomentar ?>
                    </p>
                </div>
            </div>
        </div>
    </div>

    <input type="text" class="form-control form-control-sm" id="txtidkomentarbls" value="<?php echo $idkomentar ?>" hidden >

    <div class="form-floating mb-3">
        <input type="text" class="form-control form-control-sm" id="txtnamakomenbls" value="" placeholder="Nama lengkap" maxlength="35" autocomplete="off">
        <label for="txtnamakomenbls">Nama Lengkap</label>
    </div>

    <div class="form-floating mb-3">
        <input type="text" class="form-control form-control-sm" id="txtemailkomenbls" value="" placeholder="Email" maxlength="50" autocomplete="off">
        <label for="txtemailkomenbls">Email</label>
    </div>

    <div class="form-floating mb-0">
        <textarea class="form-control form-control-sm" id="txtkomentarbalas" placeholder="Tulis komentar.." maxlength="250" style="height: 100px"></textarea>
        <label for="txtkomentarbalas">Isi Komentar</label>
    </div>

</div>

<div class="modal-footer justify-content-between">
    <button class="btn btn-sm btn-danger" type="button" data-bs-dismiss="modal">Batalkan</button>
    <button class="btn btn-sm btn-primary" type="button" id="cmdSimpanKomentarBalas">Balas Komentar</button>
</div>

<script type="text/javascript" charset="utf-8">
    $(document).ready(function() {
        $("#txtnamakomenbls").val("");
        $("#txtemailkomenbls").val("");
        $("#txtkomentarbalas").val("");
    });
    
    $("#cmdSimpanKomentarBalas").click(function() {
        var idkomentar = $('#txtidkomentarbls').val();
        var nama = $('#txtnamakomenbls').val();
        var email = $('#txtemailkomenbls').val();
        var validRegex = /^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/;
        var komentar = $('#txtkomentarbalas').val();

        var data = new FormData();
        data.append('idkomentar', idkomentar);
        data.append('nama', nama);
        data.append('email', email);
        data.append('komentar', komentar);

        if (nama.length <= 0) {
            $('#txtnamakomenbls').focus();
            alert('Nama lengkap masih kosong')
        } else if (email.length <= 0) {
            $('#txtemailkomenbls').focus();
            alert('Alamat email masih kosong')
        } else if (!email.match(validRegex)) {
            alert("Email tidak valid");
            $('#txtemailkomenbls').focus();
        } else if (komentar.length <= 8) {
            $('#txtkomentarbalas').focus();
            alert('Isi komentar masih kosong')
        } else {
            $.ajax({
                type: "POST",
                url: 'web/aksi/komentar/aksi_balas_komentar.php',
                data: data,
                dataType: "json",
                processData: false,
                contentType: false,
                beforeSend: function(e) {
                    $("#cmdSimpanKomentarBalas").attr("disabled", "disabled");
                },
                success: function(resp) {
                    if (resp.msg2 == 'ok') {
                        setTimeout(function() {
                            $('#modBebasSmall').modal('hide');
                            IsiKomentar();
                        }, 1000);
                    } else if (resp.msg2 == 'err_val') {
                        alert(resp.msg1);
                        $("#cmdSimpanKomentarBalas").removeAttr("disabled");
                    } else {
                        alert('Ada sedikit masalah, silakan coba lagi.');
                        $("#cmdSimpanKomentarBalas").removeAttr("disabled");
                    }
                },
                error: function() {
                    alert('Koneksi bermasalah periksa internet');
                    $("#cmdSimpanKomentarBalas").removeAttr("disabled");
                    $(".modal-body").css("opacity", "");
                },
            });
        };
    });
</script>