<?php
error_reporting(0);
require_once '../../../services/config.php';
$dbconn = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname) or die('Could not connect: ');
date_default_timezone_set('Asia/Jakarta');

$idkegiatan = trim($_POST['idkegiatan']);

$qri = ("SELECT judul,headline,aktif,isi_kegiatan,tanggal FROM kegiatan_sekolah WHERE id_kegiatan='" . $idkegiatan . "'");
$dblayanan = mysqli_query($dbconn, $qri);
$d = mysqli_fetch_assoc($dblayanan);

$judul = $d['judul'];
$tanggal = $d['tanggal'];
$tanggal = date('d-m-Y', strtotime($tanggal));
$headline = $d['headline'];
$isikegiatan = $d['isi_kegiatan'];

mysqli_free_result($dblayanan);
mysqli_close($dbconn);
?>

<div class="modal-header px-4 position-relative modal-shape-header bg-shape">
    <div class="position-relative z-index-1 light">
        <h5 class="mb-0 text-white">Edit Data Kegiatan Sekolah</h5>
        <p class="fs--1 mb-0 text-white">Silahkan merubah data kegiatan sekolah</p>
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
                        Tekan tombol <strong>Simpan Data</strong> untuk menyimpan data
                    </p>
                </div>
            </div>
        </div>
    </div>

    <input class="form-control form-control-sm datetimepicker fs--1" id="txtidkegiatanE" value="<?php echo $idkegiatan ?>" type="text" hidden />

    <div class="form-floating mb-3">
        <input class="form-control form-control-sm datetimepicker fs--1" id="txttglkegiatane" value="<?php echo $tanggal ?>" type="text" placeholder="Tanggal informasi" data-options='{"dateFormat":"d-m-Y","disableMobile":true}' />
        <label for="txttglkegiatane">Tanggal Kegiatan</label>
    </div>

    <div class="form-floating mb-3">
        <input type="text" class="form-control form-control-sm fs--1" id="txtjudulkegiatane" value="<?php echo $judul ?>" placeholder="Judul informasi" maxlength="100" autocomplete="off">
        <label for="txtjudulkegiatane">Nama Kegiatan</label>
    </div>

    <div class="form-floating mb-3">
        <select class="form-select form-select-sm js-choice px-3 fs--1" size="1" name="cboheadlinekegiatane" id="cboheadlinekegiatane" data-options='{"removeItemButton":true,"placeholder":true}'>
            <?php
            if ($headline == "Y") {
                $plhY = "selected";
            } else {
                $plhY = "";
            }
            if ($headline == "N") {
                $plhN = "selected";
            } else {
                $plhN = "";
            }
            echo "
            <option value='Y' $plhY>Headline</option>
            <option value='N' $plhN>Bukan Headline</option>";
            ?>
        </select>
        <label for="cboheadlinekegiatane">Headline</label>
    </div>

    <div class="form-floating mb-0">
        <textarea class="form-control fs--1" id="txtisikegiatane" placeholder="Isi keterangan kegiatan" style="height: 80px"><?php echo $isikegiatan ?></textarea>
        <label for="txtisikegiatane">Isi Kegiatan</label>
    </div>

</div>
<div class="modal-footer">
    <button class="btn btn-sm btn-falcon-danger" type="button" data-bs-dismiss="modal">Batalkan</button>
    <button class="btn btn-sm btn-falcon-primary" type="button" id="cmdSimpanKegiatanE">Simpan data</button>
</div>

<script src="../assets/js/flatpickr.js"></script>
<script type="text/javascript" charset="utf-8">
    $(document).ready(function() {
 
    });

    $("#cmdSimpanKegiatanE").click(function() {
 
        var idkegiatan = $("#txtidkegiatanE").val();
        var tglkegiatan = $("#txttglkegiatane").val();
        var judul = $("#txtjudulkegiatane").val();
        var headline = $("#cboheadlinekegiatane").val();
        var isikegiatan = $("#txtisikegiatane").val();

        var data = new FormData();
        data.append('idkegiatan', idkegiatan);
        data.append('tglkegiatan', tglkegiatan);
        data.append('judul', judul);
        data.append('headline', headline);
        data.append('isikegiatan', isikegiatan);

        if (idkegiatan.length <= 0) {
            alert("ID kegiatan tidak terdeteksi")
        } else if (tglkegiatan.length <= 0) {
            $("#txttglkegiatane").focus();
            alert("Tanggal masih kosong")
        } else if (judul.length <= 0) {
            $("#txtjudulkegiatane").focus();
            alert("Nama kegiatan masih kosong")
        } else if (headline.length <= 0) {
            $("#cboheadlinekegiatane").focus();
            alert("Headline masih kosong")
        } else if (isikegiatan.length <= 0) {
            $("#txtisikegiatane").focus();
            alert("Isi kegiatan masih kosong")
        } else {
            $.ajax({
                type: "POST",
                url: 'aksi/kegiatan/aksi_edit.php',
                data: data,
                dataType: "json",
                processData: false,
                contentType: false,
                beforeSend: function(e) {
                    $("#cmdSimpanKegiatanE").attr("disabled", "disabled");
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
                        $("#cmdSimpanKegiatanE").removeAttr("disabled");
                    } else {
                        alert('Ada sedikit masalah, silakan coba lagi.');
                        $("#cmdSimpanKegiatanE").removeAttr("disabled");
                    }
                },
                error: function() {
                    alert('Koneksi bermasalah periksa internet');
                    $("#cmdSimpanKegiatanE").removeAttr("disabled");
                    $(".modal-body").css("opacity", "");
                },
            });
        };
    });
</script>