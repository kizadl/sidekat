<?php
error_reporting(0);
require_once '../../../services/config.php';
$dbconn = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname) or die('Could not connect: ');
date_default_timezone_set('Asia/Jakarta');
?>

<div class="modal-header px-4 position-relative modal-shape-header bg-shape">
    <div class="position-relative z-index-1 light">
        <h5 class="mb-0 text-white">Input Data Kegiatan Sekolah</h5>
        <p class="fs--1 mb-0 text-white">Silahkan menambahkan data kegiatan sekolah</p>
    </div>
    <button class="btn-close btn-close-white position-absolute top-0 end-0 mt-2 me-2" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<div class="modal-body py-3 px-4">

    <div class="row mb-3 g-3">
        <div class="col-xxl-12">
            <div class="card bg-primary text-white h-lg-100">
                <div class="card-body d-flex align-items-center">
                    <p class="fs--1 mt-0 mb-0">
                        Isi dan lengkapi form isian data <strong>Kegiatan Sekolah</strong> dibawah ini.<br>
                        Tekan tombol <strong>Simpan Data</strong> untuk menyimpan data<br>
                        Catatan :<br>Setiap penambahan input data <strong>Kegiatan Sekolah Baru</strong>, "Otomatis menjadi <strong>Headline</strong>"
                    </p>
                </div>
            </div>
        </div>
    </div>

    <div class="form-floating mb-3">
        <input class="form-control form-control-sm datetimepicker fs--1" id="txttglkegiatan" value="" type="text" placeholder="Tanggal informasi" data-options='{"dateFormat":"d-m-Y","disableMobile":true}' />
        <label for="txttglkegiatan">Tanggal Kegiatan</label>
    </div>

    <div class="form-floating mb-3">
        <input type="text" class="form-control form-control-sm fs--1" id="txtjudulkegiatan" value="" placeholder="Judul informasi" maxlength="100" autocomplete="off">
        <label for="txtjudulkegiatan">Nama Kegiatan</label>
    </div>

    <div class="form-floating mb-3">
        <select class="form-select form-select-sm js-choice px-3 fs--1" size="1" name="cboheadlinekegiatan" id="cboheadlinekegiatan" data-options='{"removeItemButton":true,"placeholder":true}' disabled >
            <option value="Y" selected >Headline</option>
            <option value="N">Bukan Headline</option>
        </select>
        <label for="cboheadlinekegiatan">Headline</label>
    </div>

    <div class="form-floating mb-0">
        <textarea class="form-control fs--1" id="txtisikegiatan" placeholder="Isi keterangan kegiatan" style="height: 80px"></textarea>
        <label for="txtisikegiatan">Isi Kegiatan</label>
    </div>

</div>
<div class="modal-footer">
    <button class="btn btn-sm btn-falcon-danger" type="button" data-bs-dismiss="modal">Batalkan</button>
    <button class="btn btn-sm btn-falcon-primary" type="button" id="cmdSimpanKegiatan">Simpan data</button>
</div>

<script src="../assets/js/flatpickr.js"></script>

<script type="text/javascript" charset="utf-8">
    $(document).ready(function() {

        $("#txtjudulkegiatan").val("");
  
        var tglserver = $("#lbltglserver").val();
        arrbulan = ["01", "02", "03", "04", "05", "06", "07", "08", "09", "10", "11", "12"];
        arrtanggal = ["00", "01", "02", "03", "04", "05", "06", "07", "08", "09", "10", "11", "12", "13", "14",
            "15", "16", "17", "18", "19", "20", "21", "22", "23", "24", "25", "26", "27", "28", "29", "30", "31"
        ];
        mydate = new Date(tglserver);

        tanggal = mydate.getDate();
        bulan = mydate.getMonth();
        tahun = mydate.getFullYear();

        $("#txttglkegiatan").val(arrtanggal[tanggal] + '-' + arrbulan[bulan] + '-' + tahun);
    });

    $("#cmdSimpanKegiatan").click(function() {

        var idsekolah = $("#lblidsekolah").val();
        var npsn = $("#llnpsnsekolah").val();
        var tglkegiatan = $("#txttglkegiatan").val();
        var judul = $("#txtjudulkegiatan").val();
        var headline = $("#cboheadlinekegiatan").val();
        var isikegiatan = $("#txtisikegiatan").val();

        var data = new FormData();
        data.append('idsekolah', idsekolah);
        data.append('npsn', npsn);
        data.append('tglkegiatan', tglkegiatan);
        data.append('judul', judul);
        data.append('headline', headline);
        data.append('isikegiatan', isikegiatan);

        if (tglkegiatan.length <= 0) {
            $("#txttglkegiatan").focus();
            alert("Tanggal masih kosong")
        } else if (judul.length <= 0) {
            $("#txtjudulkegiatan").focus();
            alert("Nama kegiatan masih kosong")
        } else if (headline.length <= 0) {
            $("#cboheadlinekegiatan").focus();
            alert("Headline masih kosong")
        } else if (isikegiatan.length <= 0) {
            $("#txtisikegiatan").focus();
            alert("Isi kegiatan masih kosong")
        } else {
            $.ajax({
                type: "POST",
                url: 'aksi/kegiatan/aksi_tambah.php',
                data: data,
                dataType: "json",
                processData: false,
                contentType: false,
                beforeSend: function(e) {
                    $("#cmdSimpanKegiatan").attr("disabled", "disabled");
                },
                success: function(resp) {
                    if (resp.msg2 == 'ok') {
                        setTimeout(function() {
                            $('#modTambahDataLarge').modal('hide');
                        }, 1000);
                        $("#ToastSukses").toast("show");
                        isiListKegiatan();
                    } else if (resp.msg2 == 'err_val') {
                        alert(resp.msg1);
                        $("#cmdSimpanKegiatan").removeAttr("disabled");
                    } else {
                        alert('Ada sedikit masalah, silakan coba lagi.');
                        $("#cmdSimpanKegiatan").removeAttr("disabled");
                    }
                },
                error: function() {
                    alert('Koneksi bermasalah periksa internet');
                    $("#cmdSimpanKegiatan").removeAttr("disabled");
                    $(".modal-body").css("opacity", "");
                },
            });
        };
    });
</script>