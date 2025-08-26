<?php
error_reporting(0);
require_once '../../../services/config.php';
$dbconn = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname) or die('Could not connect: ');
?>

<div class="modal-header px-4 position-relative modal-shape-header bg-shape">
    <div class="position-relative z-index-1 light">
        <h5 class="mb-0 fs-1 text-white">Input Pengaduan</h5>
        <p class="fs--1 mb-0 text-white">Silahkan melengkapi data pengaduan Anda</p>
    </div>
    <button class="btn-close btn-close-white position-absolute top-0 end-0 mt-2 me-2" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<div class="modal-body py-3 px-4">

    <div class="row mb-3 g-3">
        <div class="col-xxl-12">
            <div class="card bg-primary text-white h-lg-100">
                <div class="card-body d-flex align-items-center">
                    <p class="fs--1 mt-0 mb-0">
                        Lengkapi data <strong>NIK</strong> dibawah ini. Dipergunakan untuk melihat <strong>Tindak Lanjut Pengaduan</strong> Anda.<br/>
                        Masukkan data <strong>NIK</strong> di form isian <strong>Search (Cari pengaduan)</strong> untuk menelusuri <strong>Tindak Lanjut Pengaduan</strong> Anda.
                    </p>
                </div>
            </div>
        </div>
    </div>

    <div class="form-floating mb-3">
        <input type="number" class="form-control form-control-sm" id="txtnikpengadu" value="" placeholder="NIK" maxlength="16" autocomplete="off">
        <label for="txtnikpengadu">NIK</label>
    </div>

    <div class="row mb-3 g-3">
        <div class="col-xxl-12">
            <div class="card bg-primary text-white h-lg-100">
                <div class="card-body d-flex align-items-center">
                    <p class="fs--1 mt-0 mb-0">
                        Isi dan lengkapi form isian data <strong>Pengaduan</strong> dibawah ini.<br />
                        1. Isi data <strong>Nama, Alamat, No. Telepon / WA, Uraian Permasalahan</strong> dengan benar.
                        <br />2. <strong>Upload Foto (Tidak Wajib)</strong>.<br />
                        3. Tekan tombol <strong>Lanjutkan pengaduan</strong> untuk menyimpan data pengaduan
                    </p>
                </div>
            </div>
        </div>
    </div>

    <div class="form-floating mb-3">
        <input type="text" class="form-control form-control-sm" id="txtnamapengadu" value="" placeholder="Nama lengkap" maxlength="50" autocomplete="off">
        <label for="txtnamapengadu">Nama Lengkap</label>
    </div>

    <div class="form-floating mb-3">
        <input type="text" class="form-control form-control-sm" id="txtalamatpengadu" value="" placeholder="Alamat lengkap" maxlength="200" autocomplete="off">
        <label for="txtalamatpengadu">Alamat Lengkap</label>
    </div>

    <div class="form-floating mb-3">
        <input type="number" class="form-control form-control-sm" id="txtteleponpengadu" value="" placeholder="No. Telepon / WA" maxlength="25" autocomplete="off">
        <label for="txtteleponpengadu">No. Telepon / WA</label>
    </div>

    <div class="form-floating mb-3">
        <textarea class="form-control form-control-sm" id="txturaianpengaduan" placeholder="Uraian permasalahan" style="height: 100px"></textarea>
        <label for="txturaianpengaduan">Uraian Permasalahan</label>
    </div>

    <div class="card bg-light mb-2">
        <div class="card-body px-3 py-2 mb-2">
            <p class="fs--1 mb-2"><b>Upload Foto (Tidak Wajib)</b><br>File foto harus file
                gambar berextensi .jpg</p>
            <input class="form-control form-control-sm" id="btnUploadFoto" type="file" accept=".jpg" />
        </div>
    </div>

</div>

<div class="modal-footer justify-content-between">
    <button class="btn btn-sm btn-danger" type="button" data-bs-dismiss="modal">Batalkan</button>
    <button class="btn btn-sm btn-primary" type="button" id="cmdSimpanPengaduan">Lanjutkan pengaduan</button>
</div>

<script type="text/javascript" charset="utf-8">
    $(document).ready(function() {
        $("#txtnikpengadu").val("");
        $("#txtnamapengadu").val("");
        $("#txtalamatpengadu").val("");
        $("#txtteleponpengadu").val("");
        $("#txturaianpengaduan").val("");
        $("#txtnikopd").val("");
    });

    $('#btnUploadFoto').bind('change', function() {
        var extensinya = $('#btnUploadFoto').val().toLowerCase();
        var regex = new RegExp("(.*?)\.(jpg)$");
        if (!(regex.test(extensinya))) {
            alert("File upload harus file berextensi .jpg");
            $('#btnUploadFoto').val(null);
        }
    });

    $("#cmdSimpanPengaduan").click(function() {
        var nik = $('#txtnikpengadu').val();
        var nama = $('#txtnamapengadu').val();
        var alamat = $('#txtalamatpengadu').val();
        var telepon = $('#txtteleponpengadu').val();
        var uraian = $('#txturaianpengaduan').val();

        var data = new FormData();
        data.append('upFoto', $("#btnUploadFoto")[0].files[0]);
        data.append('nik', nik);
        data.append('nama', nama);
        data.append('alamat', alamat);
        data.append('telepon', telepon);
        data.append('uraian', uraian);

        if (nik.length <= 15) {
            $('#txtnikpengadu').focus();
            alert('NIK masih kosong (tidak valid 16 digit angka)')
        } else if (nama.length <= 0) {
            $('#txtnamapengadu').focus();
            alert('Nama lengkap masih kosong')
        } else if (alamat.length <= 0) {
            $('#txtalamatpengadu').focus();
            alert('Alamat lengkap masih kosong')
        } else if (telepon.length <= 9) {
            $('#txtteleponpengadu').focus();
            alert('No. tlepon / WA masih kosong (tidak valid jumlah digit angka)')
        } else if (uraian.length <= 0) {
            $('#txturaianpengaduan').focus();
            alert('Uraian permasalahan masih kosong')
        } else {
            $.ajax({
                type: "POST",
                url: 'web/aksi/pengaduan/aksi_tambah_pengaduan.php',
                data: data,
                dataType: "json",
                processData: false,
                contentType: false,
                beforeSend: function(e) {
                    $("#cmdSimpanPengaduan").attr("disabled", "disabled");
                },
                success: function(resp) {
                    if (resp.msg2 == 'ok') {
                        setTimeout(function() {
                            $('#modTambahDataLarge').modal('hide');
                        }, 1000);
                        $("#ToastSukses").toast("show");
                    } else if (resp.msg2 == 'err_val') {
                        alert(resp.msg1);
                        $("#cmdSimpanPengaduan").removeAttr("disabled");
                    } else {
                        alert('Ada sedikit masalah, silakan coba lagi.');
                        $("#cmdSimpanPengaduan").removeAttr("disabled");
                    }
                },
                error: function() {
                    alert('Koneksi bermasalah periksa internet');
                    $("#cmdSimpanPengaduan").removeAttr("disabled");
                    $(".modal-body").css("opacity", "");
                },
            });
        };
    });
</script>