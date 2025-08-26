<?php
error_reporting(0);
require_once '../../../services/config.php';
$dbconn = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname) or die('Could not connect: ');
date_default_timezone_set('Asia/Jakarta');
$tglserver = date('d-m-Y');
?>

<style>
        #grad1 {
      height: 60px;
      background-color: red; /* For browsers that do not support gradients */
      background-image: linear-gradient(#fd0000, #fd762d);
    }
</style>

<div class="modal-header px-4 position-relative modal-shape-header" id="grad1">
    <div class="position-relative z-index-1 light">
        <h5 class="mb-0 fs-1 text-white">Indeks Kepuasan Masyarakat</h5>
        <p class="fs--1 mb-0 text-white">Silahkan memberikan penilaian terhadap pelayanan Kami</p>
    </div>
    <button class="btn-close btn-close-white position-absolute top-0 end-0 mt-2 me-2" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<div class="modal-body py-2 px-3">
    <div style="display:none">
        <input type="text" id="lblStatusPengisian" readonly>

        <input type="text" id="lbltranstanggal" readonly>
        <input type="text" id="lbltransnama" readonly>
        <input type="text" id="lbltranskelamin" readonly>
        <input type="text" id="lbltransumur" readonly>
        <input type="text" id="lbltransidpendidikan" readonly>
        <input type="text" id="lbltransidpekerjaan" readonly>

        <!-- halaman ikm-frame -->
        <input type="text" id="txtstatusjawab" value="belum" readonly>
        <input type="text" id="txtjumlahsoal" readonly>

        <input type="text" id="txttransnosoal" readonly>
        <input type="text" id="txttransjawab" readonly>
        <input type="text" id="txtjawab1" readonly>
        <input type="text" id="txtjawab2" readonly>
        <input type="text" id="txtjawab3" readonly>
        <input type="text" id="txtjawab4" readonly>
        <input type="text" id="txtjawab5" readonly>
        <input type="text" id="txtjawab6" readonly>
        <input type="text" id="txtjawab7" readonly>
        <input type="text" id="txtjawab8" readonly>
        <input type="text" id="txtjawab9" readonly>

        <input type="text" id="txttransnilaiTP" readonly>
        <input type="text" id="txttransnilaiKP" readonly>
        <input type="text" id="txttransnilaiP" readonly>
        <input type="text" id="txttransnilaiSP" readonly>
        <input type="text" id="txtnilai1" readonly>
        <input type="text" id="txtnilai2" readonly>
        <input type="text" id="txtnilai3" readonly>
        <input type="text" id="txtnilai4" readonly>
        <input type="text" id="txtnilai5" readonly>
        <input type="text" id="txtnilai6" readonly>
        <input type="text" id="txtnilai7" readonly>
        <input type="text" id="txtnilai8" readonly>
        <input type="text" id="txtnilai9" readonly>
    </div>

    <div id="area-data-diri" style="display:none">
        <div class="row mb-3 g-3">
            <div class="col-xxl-12">
                <div class="card bg-primary text-white h-lg-100" id="grad1">
                    <div class="card-body d-flex align-items-center">
                        <p class="fs--1 mt-0 mb-0">
                            Lengkapi data diri Anda dibawah ini.<br>
                            Tekan tombol <strong>Simpan Data</strong> untuk melanjutkan pengisian survei
                            <strong>Indeks Kepuasan Masyarakat</strong>
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <div class="form-floating mb-3" hidden >
            <input class="form-control form-control-sm datetimepicker" id="txttglikm" value="<?php echo $tglserver ?>" type="text" placeholder="Tanggal" data-options='{"dateFormat":"d-m-Y","disableMobile":true}' />
            <label for="txttglikm">Tanggal</label>
        </div>

        <div class="form-floating mb-3">
            <input type="text" class="form-control form-control-sm" id="txtnamaikm" value="" placeholder="Nama" maxlength="35" autocomplete="off">
            <label for="txtnamaikm">Nama</label>
        </div>

        <div class="form-floating mb-3">
            <input type="number" class="form-control form-control-sm" id="txtumurikm" value="" placeholder="Umur" maxlength="3" autocomplete="off">
            <label for="txtumurikm">Umur</label>
        </div>

        <div class="form-floating mb-3">
            <select class="form-select js-choice" size="1" name="cbokelaminikm" id="cbokelaminikm" data-options='{"removeItemButton":true,"placeholder":true}' style="font-size:14px;">
                <option value="">Pilih jenis kelamin</option>
                <option value="L">Laki-laki</option>
                <option value="P">Perempuan</option>
            </select>
            <label for="cbokelaminikm">Pilih Jenis Kelamin</label>
        </div>

        <div class="form-floating mb-3">
            <select class="form-select js-choice" size="1" name="cbopendidikanikm" id="cbopendidikanikm" data-options='{"removeItemButton":true,"placeholder":true}' style="font-size:14px;">
                <option value="">Pilih pendidikan terakhir</option>
                <?php
                $sqlx = ("SELECT * FROM ikm_m_pendidikan ORDER BY id_pendidikan ASC");
                $result = mysqli_query($dbconn, $sqlx);
                while ($t = mysqli_fetch_array($result)) {
                    $idpendidikan = $t['id_pendidikan'];
                    $pendidikan = $t['pendidikan'];
                    echo "<option value='$idpendidikan'>$pendidikan</option>";
                }
                $result->close();
                ?>
            </select>
            <label for="cbopendidikanikm">Pilih Pendidikan Terakhir</label>
        </div>

        <div class="form-floating mb-0">
            <select class="form-select js-choice" size="1" name="cbopekerjaanikm" id="cbopekerjaanikm" data-options='{"removeItemButton":true,"placeholder":true}' style="font-size:14px;">
                <option value="">Pilih pekerjaan</option>
                <?php
                $sqlx2 = ("SELECT * FROM ikm_m_pekerjaan ORDER BY id_pekerjaan ASC");
                $result2 = mysqli_query($dbconn, $sqlx2);
                while ($p = mysqli_fetch_array($result2)) {
                    $idpekerjaan = $p['id_pekerjaan'];
                    $pekerjaan = ucwords(strtolower($p['pekerjaan']));
                    echo "<option value='$idpekerjaan'>$pekerjaan</option>";
                }
                $result2->close();
                ?>
            </select>
            <label for="cbopekerjaanikm">Pilih Pekerjaan</label>
        </div>
    </div>

    <div id="area-soal-ikm" style="display:none">
        <div class="row g-3 mb-3">

            <div class="card text-center h-100">
                <div class="card-body p-4 p-sm-5">
                    <div class="text-center">
                        <div class="btn-toolbar ms-8" role="toolbar" aria-label="Toolbar with button groups">
                            <div class="btn-group me-2 mb-2" role="group" aria-label="Third group">
                                <button class="btn btn-success" type="button" id="btn1">1</button>
                            </div>
                            <div class="btn-group me-2 mb-2" role="group" aria-label="Third group">
                                <button class="btn btn-falcon-default" type="button" id="btn2">2</button>
                            </div>
                            <div class="btn-group me-2 mb-2" role="group" aria-label="Third group">
                                <button class="btn btn-falcon-default" type="button" id="btn3">3</button>
                            </div>
                            <div class="btn-group me-2 mb-2" role="group" aria-label="Third group">
                                <button class="btn btn-falcon-default" type="button" id="btn4">4</button>
                            </div>
                            <div class="btn-group me-2 mb-2" role="group" aria-label="Third group">
                                <button class="btn btn-falcon-default" type="button" id="btn5">5</button>
                            </div>
                            <div class="btn-group me-2 mb-2" role="group" aria-label="Third group">
                                <button class="btn btn-falcon-default" type="button" id="btn6">6</button>
                            </div>
                            <div class="btn-group me-2 mb-2" role="group" aria-label="Third group">
                                <button class="btn btn-falcon-default" type="button" id="btn7">7</button>
                            </div>
                            <div class="btn-group me-2 mb-2" role="group" aria-label="Third group">
                                <button class="btn btn-falcon-default" type="button" id="btn8">8</button>
                            </div>
                            <div class="btn-group mb-2" role="group" aria-label="Third group">
                                <button class="btn btn-falcon-default" type="button" id="btn9">9</button>
                            </div>
                        </div>

                        <div class="avatar avatar-4xl mt-6">
                            <div class="avatar-name rounded-circle" id="avatarnosoal"><span id="labelnosoal"></span></div>
                        </div>

                        <h5 class="mt-3" id="labeljawaban"></h5>

                        <p class="mt-4 text-800 fw-semi-bold" id="labelsoal"></p>

                        <button class="btn btn-danger btn-sm mt-4" id="cmdTP">Tidak Puas</button>
                        <button class="btn btn-warning btn-sm mt-4" id="cmdKP">Kurang Puas</button>
                        <button class="btn btn-success btn-sm mt-4 ps-4 pe-4" id="cmdP">Puas</button>
                        <button class="btn btn-primary btn-sm mt-4" id="cmdSP">Sangat Puas</button>

                    </div>
                </div>
            </div>

        </div>

    </div>

    <div id="area-kritik-saran" style="display:none">
        <div class="row mb-3 g-3">
            <div class="col-xxl-12">
                <div class="card bg-primary text-white h-lg-100">
                    <div class="card-body d-flex align-items-center">
                        <p class="fs--1 mt-0 mb-0">
                            Lengkapi isian data <strong>Kritik atau Saran</strong> dibawah ini.<br>
                            Tekan tombol <strong>Simpan Data</strong> untuk melanjutkan pengisian survei
                            <strong>Indeks Kepuasan Masyarakat</strong>
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <div class="form-floating mb-0">
            <textarea class="form-control form-control-sm" id="txtsaran" placeholder="Tulis kritik atau saran.." maxlength="250" style="height: 100px"></textarea>
            <label for="txtsaran">Isi Kritik Atau Saran Anda</label>
        </div>

    </div>


</div>
<div class="modal-footer justify-content-between">
    <button class="btn btn-sm btn-danger" type="button" data-bs-dismiss="modal">Batalkan</button>
    <button class="btn btn-sm btn-primary" type="button" id="cmdSimpanIKM">Simpan Data</button>
</div>

<script src="assets/js/flatpickr.js"></script>
<script type="text/javascript" charset="utf-8">
    $(document).ready(function() {
        $("#area-data-diri").fadeIn();
        $("#area-soal-ikm").fadeOut("slow");
        $("#area-kritik-saran").fadeOut("slow");
        $("#lblStatusPengisian").val("data-diri");
        AmbilSoal()
        ubahTombol()
    });

    function AmbilSoal() {
        localStorage.clear();
        $.ajax({
            type: "POST",
            url: "web/aksi/ikm/ambil-soal.php",
            data: {},
            dataType: 'json',
            beforeSend: function(e) {
                document.body.style.cursor = "wait";
            },
            success: function(data) {
                document.body.style.cursor = "default";
                var i;
                for (i = 0; i < data.length; i++) {

                    $("#txtjumlahsoal").val(data[i].no);

                    if (data[i].idsoal == "1") {
                        const SoalArray1 = [data[i].idsoal, data[i].soal, data[i].TP, data[i].KP, data[i].P, data[i].SP]
                        localStorage.setItem('soal1', JSON.stringify(SoalArray1));
                    } else if (data[i].idsoal == "2") {
                        const SoalArray2 = [data[i].idsoal, data[i].soal, data[i].TP, data[i].KP, data[i].P, data[i].SP]
                        localStorage.setItem('soal2', JSON.stringify(SoalArray2));
                    } else if (data[i].idsoal == "3") {
                        const SoalArray3 = [data[i].idsoal, data[i].soal, data[i].TP, data[i].KP, data[i].P, data[i].SP]
                        localStorage.setItem('soal3', JSON.stringify(SoalArray3));
                    } else if (data[i].idsoal == "4") {
                        const SoalArray4 = [data[i].idsoal, data[i].soal, data[i].TP, data[i].KP, data[i].P, data[i].SP]
                        localStorage.setItem('soal4', JSON.stringify(SoalArray4));
                    } else if (data[i].idsoal == "5") {
                        const SoalArray5 = [data[i].idsoal, data[i].soal, data[i].TP, data[i].KP, data[i].P, data[i].SP]
                        localStorage.setItem('soal5', JSON.stringify(SoalArray5));
                    } else if (data[i].idsoal == "6") {
                        const SoalArray6 = [data[i].idsoal, data[i].soal, data[i].TP, data[i].KP, data[i].P, data[i].SP]
                        localStorage.setItem('soal6', JSON.stringify(SoalArray6));
                    } else if (data[i].idsoal == "7") {
                        const SoalArray7 = [data[i].idsoal, data[i].soal, data[i].TP, data[i].KP, data[i].P, data[i].SP]
                        localStorage.setItem('soal7', JSON.stringify(SoalArray7));
                    } else if (data[i].idsoal == "8") {
                        const SoalArray8 = [data[i].idsoal, data[i].soal, data[i].TP, data[i].KP, data[i].P, data[i].SP]
                        localStorage.setItem('soal8', JSON.stringify(SoalArray8));
                    } else if (data[i].idsoal == "9") {
                        const SoalArray9 = [data[i].idsoal, data[i].soal, data[i].TP, data[i].KP, data[i].P, data[i].SP]
                        localStorage.setItem('soal9', JSON.stringify(SoalArray9));
                    }
                }
            },
            error: function() {
                document.body.style.cursor = "default";
            },
        });
    }

    $("#cmdSimpanIKM").click(function() {
        var tanggal = $('#txttglikm').val();
        var nama = $('#txtnamaikm').val();
        var umur = $('#txtumurikm').val();
        var kelamin = $('#cbokelaminikm').val();
        var idpendidikan = $('#cbopendidikanikm').val();
        var idpekerjaan = $('#cbopekerjaanikm').val();
        if (nama.length <= 0) {
            $('#txtnamaikm').focus();
            alert('Nama masih kosong')
        } else if (umur.length <= 0) {
            $('#txtumurikm').focus();
            alert('Umur masih kosong')
        } else if (kelamin.length <= 0) {
            $('#cbokelaminikm').focus();
            alert('Jenis kelamin masih kosong')
        } else if (idpendidikan.length <= 0) {
            $('#cbopendidikanikm').focus();
            alert('Pendidikan terakhir masih kosong')
        } else if (idpekerjaan.length <= 0) {
            $('#cbopekerjaanikm').focus();
            alert('Pekerjaan masih kosong')
        } else {
            
            $("#lbltranstanggal").val(tanggal);
            $("#lbltransnama").val(nama);
            $("#lbltranskelamin").val(kelamin);
            $("#lbltransumur").val(umur);
            $("#lbltransidpendidikan").val(idpendidikan);
            $("#lbltransidpekerjaan").val(idpekerjaan);

            var statuspengisian = $("#lblStatusPengisian").val();
            if (statuspengisian == "data-diri") {
                $("#lblStatusPengisian").val("isi-soal");
                $("#area-data-diri").fadeOut("slow");
                $("#area-soal-ikm").fadeIn();

                $("#txttransnosoal").val("1");
                ubahTombol();
                fixTombol();
                isiJawaban();
            } else if (statuspengisian == "isi-soal") {
                var jwb1 = $("#txtjawab1").val();
                var jwb2 = $("#txtjawab2").val();
                var jwb3 = $("#txtjawab3").val();
                var jwb4 = $("#txtjawab4").val();
                var jwb5 = $("#txtjawab5").val();
                var jwb6 = $("#txtjawab6").val();
                var jwb7 = $("#txtjawab7").val();
                var jwb8 = $("#txtjawab8").val();
                var jwb9 = $("#txtjawab9").val();

                var n1 = $("#txtnilai1").val();
                var n2 = $("#txtnilai2").val();
                var n3 = $("#txtnilai3").val();
                var n4 = $("#txtnilai4").val();
                var n5 = $("#txtnilai5").val();
                var n6 = $("#txtnilai6").val();
                var n7 = $("#txtnilai7").val();
                var n8 = $("#txtnilai8").val();
                var n9 = $("#txtnilai9").val();

                if (jwb1.length <= 0) {
                    alert('Jawaban 1 masih kosong')
                } else if (jwb2.length <= 0) {
                    alert('Jawaban 2 masih kosong')
                } else if (jwb3.length <= 0) {
                    alert('Jawaban 3 masih kosong')
                } else if (jwb4.length <= 0) {
                    alert('Jawaban 4 masih kosong')
                } else if (jwb5.length <= 0) {
                    alert('Jawaban 5 masih kosong')
                } else if (jwb6.length <= 0) {
                    alert('Jawaban 6 masih kosong')
                } else if (jwb7.length <= 0) {
                    alert('Jawaban 7 masih kosong')
                } else if (jwb8.length <= 0) {
                    alert('Jawaban 8 masih kosong')
                } else if (jwb9.length <= 0) {
                    alert('Jawaban 9 masih kosong')
                } else {
                    $("#area-data-diri").fadeOut("slow");
                    //$("#area-soal-ikm").fadeOut("slow");
                    $("#area-kritik-saran").fadeOut("slow");
                    $("#lblStatusPengisian").val("lengkap");

                    kirimSimpanJawaban()
                    ////// ajax ///////////

                }

            }

        };
    });

    function kirimSimpanJawaban() {
        var jumsoal = $('#txtjumlahsoal').val();

        var tanggal = $("#lbltranstanggal").val();
        var nama = $("#lbltransnama").val();
        var kelamin = $("#lbltranskelamin").val();
        var umur = $("#lbltransumur").val();
        var idpendidikan = $("#lbltransidpendidikan").val();
        var idpekerjaan = $("#lbltransidpekerjaan").val();

        var jwb1 = $("#txtjawab1").val();
        var jwb2 = $("#txtjawab2").val();
        var jwb3 = $("#txtjawab3").val();
        var jwb4 = $("#txtjawab4").val();
        var jwb5 = $("#txtjawab5").val();
        var jwb6 = $("#txtjawab6").val();
        var jwb7 = $("#txtjawab7").val();
        var jwb8 = $("#txtjawab8").val();
        var jwb9 = $("#txtjawab9").val();

        var nilai1 = $('#txtnilai1').val();
        var nilai2 = $('#txtnilai2').val();
        var nilai3 = $('#txtnilai3').val();
        var nilai4 = $('#txtnilai4').val();
        var nilai5 = $('#txtnilai5').val();
        var nilai6 = $('#txtnilai6').val();
        var nilai7 = $('#txtnilai7').val();
        var nilai8 = $('#txtnilai8').val();
        var nilai9 = $('#txtnilai9').val();
        var totnilai = parseInt(nilai1) + parseInt(nilai2) + parseInt(nilai3) + parseInt(nilai4) + parseInt(nilai5) + parseInt(nilai6) + parseInt(nilai7) + parseInt(nilai8) + parseInt(nilai9);

        var saran = $("#txtsaran").val();

        // if (saran.length <= 0) {
        //    $("#txtsaran").focus();
        //    alert('Saran atau kritik Anda masih kosong')
        //} else {
        $.ajax({
            type: "POST",
            url: 'web/aksi/ikm/aksi_tambah_ikm.php',
            data: {
                tanggal: tanggal,
                nama: nama,
                kelamin: kelamin,
                umur: umur,
                idpendidikan: idpendidikan,
                idpekerjaan: idpekerjaan,
                jwb1: jwb1,
                jwb2: jwb2,
                jwb3: jwb3,
                jwb4: jwb4,
                jwb5: jwb5,
                jwb6: jwb6,
                jwb7: jwb7,
                jwb8: jwb8,
                jwb9: jwb9,
                jumsoal: jumsoal,
                nilai1: nilai1,
                nilai2: nilai2,
                nilai3: nilai3,
                nilai4: nilai4,
                nilai5: nilai5,
                nilai6: nilai6,
                nilai7: nilai7,
                nilai8: nilai8,
                nilai9: nilai9,
                totnilai: totnilai,
                saran: saran
            },
            dataType: "json",
            beforeSend: function(e) {
                $("#cmdSimpanIKM").attr("disabled", "disabled");
            },
            success: function(resp) {
                if (resp.msg2 == 'ok') {
                    setTimeout(function() {
                        $('#modBebasLarge').modal('hide');
                        alert("Selamat, survei kepuasan masyarakat berhasil tersimpan !")
                    }, 1000);
                } else if (resp.msg2 == 'err_val') {
                    alert(resp.msg1);
                    $("#cmdSimpanIKM").removeAttr("disabled");
                } else if (resp.msg2 == 'err') {
                    alert(resp.msg1);
		    alert('Ada sedikit masalah, silakan coba lagi.');
                    $("#cmdSimpanIKM").removeAttr("disabled");
                }
            },
            error: function() {
                alert('Koneksi bermasalah periksa internet');
                $("#cmdSimpanIKM").removeAttr("disabled");
                $(".modal-body").css("opacity", "");
            },
        });
        // }
    }

    function isiJawaban() {
        document.getElementById('avatarnosoal').className = 'avatar-name rounded-circle';
        $('#labeljawaban').html('');
        var nosoal = $("#txttransnosoal").val();
        var jwb1 = $("#txtjawab1").val();
        var jwb2 = $("#txtjawab2").val();
        var jwb3 = $("#txtjawab3").val();
        var jwb4 = $("#txtjawab4").val();
        var jwb5 = $("#txtjawab5").val();
        var jwb6 = $("#txtjawab6").val();
        var jwb7 = $("#txtjawab7").val();
        var jwb8 = $("#txtjawab8").val();
        var jwb9 = $("#txtjawab9").val();

        if (jwb1 == "TIDAK PUAS" && nosoal == "1") {
            $('#labeljawaban').html('Tidak Puas');
            document.getElementById('avatarnosoal').className = 'avatar-name rounded-circle bg-danger';
        } else if (jwb1 == "KURANG PUAS" && nosoal == "1") {
            $('#labeljawaban').html('Kurang Puas');
            document.getElementById('avatarnosoal').className = 'avatar-name rounded-circle bg-warning';
        } else if (jwb1 == "PUAS" && nosoal == "1") {
            $('#labeljawaban').html('Puas');
            document.getElementById('avatarnosoal').className = 'avatar-name rounded-circle bg-success';
        } else if (jwb1 == "SANGAT PUAS" && nosoal == "1") {
            $('#labeljawaban').html('Sangat Puas');
            document.getElementById('avatarnosoal').className = 'avatar-name rounded-circle bg-primary';
        }

        if (jwb2 == "TIDAK PUAS" && nosoal == "2") {
            $('#labeljawaban').html('Tidak Puas');
            document.getElementById('avatarnosoal').className = 'avatar-name rounded-circle bg-danger';
        } else if (jwb2 == "KURANG PUAS" && nosoal == "2") {
            $('#labeljawaban').html('Kurang Puas');
            document.getElementById('avatarnosoal').className = 'avatar-name rounded-circle bg-warning';
        } else if (jwb2 == "PUAS" && nosoal == "2") {
            $('#labeljawaban').html('Puas');
            document.getElementById('avatarnosoal').className = 'avatar-name rounded-circle bg-success';
        } else if (jwb2 == "SANGAT PUAS" && nosoal == "2") {
            $('#labeljawaban').html('Sangat Puas');
            document.getElementById('avatarnosoal').className = 'avatar-name rounded-circle bg-primary';
        }

        if (jwb3 == "TIDAK PUAS" && nosoal == "3") {
            $('#labeljawaban').html('Tidak Puas');
            document.getElementById('avatarnosoal').className = 'avatar-name rounded-circle bg-danger';
        } else if (jwb3 == "KURANG PUAS" && nosoal == "3") {
            $('#labeljawaban').html('Kurang Puas');
            document.getElementById('avatarnosoal').className = 'avatar-name rounded-circle bg-warning';
        } else if (jwb3 == "PUAS" && nosoal == "3") {
            $('#labeljawaban').html('Puas');
            document.getElementById('avatarnosoal').className = 'avatar-name rounded-circle bg-success';
        } else if (jwb3 == "SANGAT PUAS" && nosoal == "3") {
            $('#labeljawaban').html('Sangat Puas');
            document.getElementById('avatarnosoal').className = 'avatar-name rounded-circle bg-primary';
        }

        if (jwb4 == "TIDAK PUAS" && nosoal == "4") {
            $('#labeljawaban').html('Tidak Puas');
            document.getElementById('avatarnosoal').className = 'avatar-name rounded-circle bg-danger';
        } else if (jwb4 == "KURANG PUAS" && nosoal == "4") {
            $('#labeljawaban').html('Kurang Puas');
            document.getElementById('avatarnosoal').className = 'avatar-name rounded-circle bg-warning';
        } else if (jwb4 == "PUAS" && nosoal == "4") {
            $('#labeljawaban').html('Puas');
            document.getElementById('avatarnosoal').className = 'avatar-name rounded-circle bg-success';
        } else if (jwb4 == "SANGAT PUAS" && nosoal == "4") {
            $('#labeljawaban').html('Sangat Puas');
            document.getElementById('avatarnosoal').className = 'avatar-name rounded-circle bg-primary';
        }

        if (jwb5 == "TIDAK PUAS" && nosoal == "5") {
            $('#labeljawaban').html('Tidak Puas');
            document.getElementById('avatarnosoal').className = 'avatar-name rounded-circle bg-danger';
        } else if (jwb5 == "KURANG PUAS" && nosoal == "5") {
            $('#labeljawaban').html('Kurang Puas');
            document.getElementById('avatarnosoal').className = 'avatar-name rounded-circle bg-warning';
        } else if (jwb5 == "PUAS" && nosoal == "5") {
            $('#labeljawaban').html('Puas');
            document.getElementById('avatarnosoal').className = 'avatar-name rounded-circle bg-success';
        } else if (jwb5 == "SANGAT PUAS" && nosoal == "5") {
            $('#labeljawaban').html('Sangat Puas');
            document.getElementById('avatarnosoal').className = 'avatar-name rounded-circle bg-primary';
        }

        if (jwb6 == "TIDAK PUAS" && nosoal == "6") {
            $('#labeljawaban').html('Tidak Puas');
            document.getElementById('avatarnosoal').className = 'avatar-name rounded-circle bg-danger';
        } else if (jwb6 == "KURANG PUAS" && nosoal == "6") {
            $('#labeljawaban').html('Kurang Puas');
            document.getElementById('avatarnosoal').className = 'avatar-name rounded-circle bg-warning';
        } else if (jwb6 == "PUAS" && nosoal == "6") {
            $('#labeljawaban').html('Puas');
            document.getElementById('avatarnosoal').className = 'avatar-name rounded-circle bg-success';
        } else if (jwb6 == "SANGAT PUAS" && nosoal == "6") {
            $('#labeljawaban').html('Sangat Puas');
            document.getElementById('avatarnosoal').className = 'avatar-name rounded-circle bg-primary';
        }

        if (jwb7 == "TIDAK PUAS" && nosoal == "7") {
            $('#labeljawaban').html('Tidak Puas');
            document.getElementById('avatarnosoal').className = 'avatar-name rounded-circle bg-danger';
        } else if (jwb7 == "KURANG PUAS" && nosoal == "7") {
            $('#labeljawaban').html('Kurang Puas');
            document.getElementById('avatarnosoal').className = 'avatar-name rounded-circle bg-warning';
        } else if (jwb7 == "PUAS" && nosoal == "7") {
            $('#labeljawaban').html('Puas');
            document.getElementById('avatarnosoal').className = 'avatar-name rounded-circle bg-success';
        } else if (jwb7 == "SANGAT PUAS" && nosoal == "7") {
            $('#labeljawaban').html('Sangat Puas');
            document.getElementById('avatarnosoal').className = 'avatar-name rounded-circle bg-primary';
        }

        if (jwb8 == "TIDAK PUAS" && nosoal == "8") {
            $('#labeljawaban').html('Tidak Puas');
            document.getElementById('avatarnosoal').className = 'avatar-name rounded-circle bg-danger';
        } else if (jwb8 == "KURANG PUAS" && nosoal == "8") {
            $('#labeljawaban').html('Kurang Puas');
            document.getElementById('avatarnosoal').className = 'avatar-name rounded-circle bg-warning';
        } else if (jwb8 == "PUAS" && nosoal == "8") {
            $('#labeljawaban').html('Puas');
            document.getElementById('avatarnosoal').className = 'avatar-name rounded-circle bg-success';
        } else if (jwb8 == "SANGAT PUAS" && nosoal == "8") {
            $('#labeljawaban').html('Sangat Puas');
            document.getElementById('avatarnosoal').className = 'avatar-name rounded-circle bg-primary';
        }

        if (jwb9 == "TIDAK PUAS" && nosoal == "9") {
            $('#labeljawaban').html('Tidak Puas');
            document.getElementById('avatarnosoal').className = 'avatar-name rounded-circle bg-danger';
        } else if (jwb9 == "KURANG PUAS" && nosoal == "9") {
            $('#labeljawaban').html('Kurang Puas');
            document.getElementById('avatarnosoal').className = 'avatar-name rounded-circle bg-warning';
        } else if (jwb9 == "PUAS" && nosoal == "9") {
            $('#labeljawaban').html('Puas');
            document.getElementById('avatarnosoal').className = 'avatar-name rounded-circle bg-success';
        } else if (jwb9 == "SANGAT PUAS" && nosoal == "9") {
            $('#labeljawaban').html('Sangat Puas');
            document.getElementById('avatarnosoal').className = 'avatar-name rounded-circle bg-primary';
        }

    }

    function fixTombol() {
        var nosoal = $("#txttransnosoal").val();
        var jwb1 = $("#txtjawab1").val();
        var jwb2 = $("#txtjawab2").val();
        var jwb3 = $("#txtjawab3").val();
        var jwb4 = $("#txtjawab4").val();
        var jwb5 = $("#txtjawab5").val();
        var jwb6 = $("#txtjawab6").val();
        var jwb7 = $("#txtjawab7").val();
        var jwb8 = $("#txtjawab8").val();
        var jwb9 = $("#txtjawab9").val();

        if (jwb1 != "" && nosoal != "1") {
            document.getElementById('btn1').className = 'btn btn-primary';
        } else if (jwb1 == "" && nosoal != "1") {
            document.getElementById('btn1').className = 'btn btn-falcon-default';
        }

        if (jwb2 != "" && nosoal != "2") {
            document.getElementById('btn2').className = 'btn btn-primary';
        } else if (jwb2 == "" && nosoal != "2") {
            document.getElementById('btn2').className = 'btn btn-falcon-default';
        }

        if (jwb3 != "" && nosoal != "3") {
            document.getElementById('btn3').className = 'btn btn-primary';
        } else if (jwb3 == "" && nosoal != "3") {
            document.getElementById('btn3').className = 'btn btn-falcon-default';
        }

        if (jwb4 != "" && nosoal != "4") {
            document.getElementById('btn4').className = 'btn btn-primary';
        } else if (jwb4 == "" && nosoal != "4") {
            document.getElementById('btn4').className = 'btn btn-falcon-default';
        }

        if (jwb5 != "" && nosoal != "5") {
            document.getElementById('btn5').className = 'btn btn-primary';
        } else if (jwb5 == "" && nosoal != "5") {
            document.getElementById('btn5').className = 'btn btn-falcon-default';
        }

        if (jwb6 != "" && nosoal != "6") {
            document.getElementById('btn6').className = 'btn btn-primary';
        } else if (jwb6 == "" && nosoal != "6") {
            document.getElementById('btn6').className = 'btn btn-falcon-default';
        }

        if (jwb7 != "" && nosoal != "7") {
            document.getElementById('btn7').className = 'btn btn-primary';
        } else if (jwb7 == "" && nosoal != "7") {
            document.getElementById('btn7').className = 'btn btn-falcon-default';
        }

        if (jwb8 != "" && nosoal != "8") {
            document.getElementById('btn8').className = 'btn btn-primary';
        } else if (jwb8 == "" && nosoal != "8") {
            document.getElementById('btn8').className = 'btn btn-falcon-default';
        }

        if (jwb9 != "" && nosoal != "9") {
            document.getElementById('btn9').className = 'btn btn-primary';
        } else if (jwb9 == "" && nosoal != "9") {
            document.getElementById('btn9').className = 'btn btn-falcon-default';
        }

    }

    function ubahTombol() {
        var nosoal = $("#txttransnosoal").val();
        if (nosoal == "1") {
            document.getElementById('btn1').className = 'btn btn-success';
            $("#labelnosoal").html("1");
            let cariItem = JSON.parse(localStorage.getItem("soal1"));
            $("#labelsoal").html(cariItem[1]);
            $("#txttransnilaiTP").val(cariItem[2]);
            $("#txttransnilaiKP").val(cariItem[3]);
            $("#txttransnilaiP").val(cariItem[4]);
            $("#txttransnilaiSP").val(cariItem[5]);
        } else if (nosoal == "2") {
            document.getElementById('btn2').className = 'btn btn-success';
            $("#labelnosoal").html("2");
            let cariItem = JSON.parse(localStorage.getItem("soal2"));
            $("#labelsoal").html(cariItem[1]);
            $("#txttransnilaiTP").val(cariItem[2]);
            $("#txttransnilaiKP").val(cariItem[3]);
            $("#txttransnilaiP").val(cariItem[4]);
            $("#txttransnilaiSP").val(cariItem[5]);
        } else if (nosoal == "3") {
            document.getElementById('btn3').className = 'btn btn-success';
            $("#labelnosoal").html("3");
            let cariItem = JSON.parse(localStorage.getItem("soal3"));
            $("#labelsoal").html(cariItem[1]);
            $("#txttransnilaiTP").val(cariItem[2]);
            $("#txttransnilaiKP").val(cariItem[3]);
            $("#txttransnilaiP").val(cariItem[4]);
            $("#txttransnilaiSP").val(cariItem[5]);
        } else if (nosoal == "4") {
            document.getElementById('btn4').className = 'btn btn-success';
            $("#labelnosoal").html("4");
            let cariItem = JSON.parse(localStorage.getItem("soal4"));
            $("#labelsoal").html(cariItem[1]);
            $("#txttransnilaiTP").val(cariItem[2]);
            $("#txttransnilaiKP").val(cariItem[3]);
            $("#txttransnilaiP").val(cariItem[4]);
            $("#txttransnilaiSP").val(cariItem[5]);
        } else if (nosoal == "5") {
            document.getElementById('btn5').className = 'btn btn-success';
            $("#labelnosoal").html("5");
            let cariItem = JSON.parse(localStorage.getItem("soal5"));
            $("#labelsoal").html(cariItem[1]);
            $("#txttransnilaiTP").val(cariItem[2]);
            $("#txttransnilaiKP").val(cariItem[3]);
            $("#txttransnilaiP").val(cariItem[4]);
            $("#txttransnilaiSP").val(cariItem[5]);
        } else if (nosoal == "6") {
            document.getElementById('btn6').className = 'btn btn-success';
            $("#labelnosoal").html("6");
            let cariItem = JSON.parse(localStorage.getItem("soal6"));
            $("#labelsoal").html(cariItem[1]);
            $("#txttransnilaiTP").val(cariItem[2]);
            $("#txttransnilaiKP").val(cariItem[3]);
            $("#txttransnilaiP").val(cariItem[4]);
            $("#txttransnilaiSP").val(cariItem[5]);
        } else if (nosoal == "7") {
            document.getElementById('btn7').className = 'btn btn-success';
            $("#labelnosoal").html("7");
            let cariItem = JSON.parse(localStorage.getItem("soal7"));
            $("#labelsoal").html(cariItem[1]);
            $("#txttransnilaiTP").val(cariItem[2]);
            $("#txttransnilaiKP").val(cariItem[3]);
            $("#txttransnilaiP").val(cariItem[4]);
            $("#txttransnilaiSP").val(cariItem[5]);
        } else if (nosoal == "8") {
            document.getElementById('btn8').className = 'btn btn-success';
            $("#labelnosoal").html("8");
            let cariItem = JSON.parse(localStorage.getItem("soal8"));
            $("#labelsoal").html(cariItem[1]);
            $("#txttransnilaiTP").val(cariItem[2]);
            $("#txttransnilaiKP").val(cariItem[3]);
            $("#txttransnilaiP").val(cariItem[4]);
            $("#txttransnilaiSP").val(cariItem[5]);
        } else if (nosoal == "9") {
            document.getElementById('btn9').className = 'btn btn-success';
            $("#labelnosoal").html("9");
            let cariItem = JSON.parse(localStorage.getItem("soal9"));
            $("#labelsoal").html(cariItem[1]);
            $("#txttransnilaiTP").val(cariItem[2]);
            $("#txttransnilaiKP").val(cariItem[3]);
            $("#txttransnilaiP").val(cariItem[4]);
            $("#txttransnilaiSP").val(cariItem[5]);
        }
    }

    $("#btn1").click(function() {
        $("#txttransnosoal").val("1");
        ubahTombol()
        fixTombol()
        isiJawaban()
    });

    $("#btn2").click(function() {
        $("#txttransnosoal").val("2");
        ubahTombol()
        fixTombol()
        isiJawaban()
    });

    $("#btn3").click(function() {
        $("#txttransnosoal").val("3");
        ubahTombol()
        fixTombol()
        isiJawaban()
    });

    $("#btn4").click(function() {
        $("#txttransnosoal").val("4");
        ubahTombol()
        fixTombol()
        isiJawaban()
    });

    $("#btn5").click(function() {
        $("#txttransnosoal").val("5");
        ubahTombol()
        fixTombol()
        isiJawaban()
    });

    $("#btn6").click(function() {
        $("#txttransnosoal").val("6");
        ubahTombol()
        fixTombol()
        isiJawaban()
    });

    $("#btn7").click(function() {
        $("#txttransnosoal").val("7");
        ubahTombol()
        fixTombol()
        isiJawaban()
    });

    $("#btn8").click(function() {
        $("#txttransnosoal").val("8");
        ubahTombol()
        fixTombol()
        isiJawaban()
    });

    $("#btn9").click(function() {
        $("#txttransnosoal").val("9");
        ubahTombol()
        fixTombol()
        isiJawaban()
    });

    $("#cmdTP").click(function() {
        var nosoal = $("#txttransnosoal").val();
        var nilaiTP = $("#txttransnilaiTP").val();
        if (nosoal == "1") {
            $("#txtjawab1").val("TIDAK PUAS");
            $("#txtnilai1").val(nilaiTP);
        } else if (nosoal == "2") {
            $("#txtjawab2").val("TIDAK PUAS");
            $("#txtnilai2").val(nilaiTP);
        } else if (nosoal == "3") {
            $("#txtjawab3").val("TIDAK PUAS");
            $("#txtnilai3").val(nilaiTP);
        } else if (nosoal == "4") {
            $("#txtjawab4").val("TIDAK PUAS");
            $("#txtnilai4").val(nilaiTP);
        } else if (nosoal == "5") {
            $("#txtjawab5").val("TIDAK PUAS");
            $("#txtnilai5").val(nilaiTP);
        } else if (nosoal == "6") {
            $("#txtjawab6").val("TIDAK PUAS");
            $("#txtnilai6").val(nilaiTP);
        } else if (nosoal == "7") {
            $("#txtjawab7").val("TIDAK PUAS");
            $("#txtnilai7").val(nilaiTP);
        } else if (nosoal == "8") {
            $("#txtjawab8").val("TIDAK PUAS");
            $("#txtnilai8").val(nilaiTP);
        } else if (nosoal == "9") {
            $("#txtjawab9").val("TIDAK PUAS");
            $("#txtnilai9").val(nilaiTP);
        }
        isiJawaban()
    });

    $("#cmdKP").click(function() {
        var nosoal = $("#txttransnosoal").val();
        var nilaiTP = $("#txttransnilaiKP").val();
        if (nosoal == "1") {
            $("#txtjawab1").val("KURANG PUAS");
            $("#txtnilai1").val(nilaiTP);
        } else if (nosoal == "2") {
            $("#txtjawab2").val("KURANG PUAS");
            $("#txtnilai2").val(nilaiTP);
        } else if (nosoal == "3") {
            $("#txtjawab3").val("KURANG PUAS");
            $("#txtnilai3").val(nilaiTP);
        } else if (nosoal == "4") {
            $("#txtjawab4").val("KURANG PUAS");
            $("#txtnilai4").val(nilaiTP);
        } else if (nosoal == "5") {
            $("#txtjawab5").val("KURANG PUAS");
            $("#txtnilai5").val(nilaiTP);
        } else if (nosoal == "6") {
            $("#txtjawab6").val("KURANG PUAS");
            $("#txtnilai6").val(nilaiTP);
        } else if (nosoal == "7") {
            $("#txtjawab7").val("KURANG PUAS");
            $("#txtnilai7").val(nilaiTP);
        } else if (nosoal == "8") {
            $("#txtjawab8").val("KURANG PUAS");
            $("#txtnilai8").val(nilaiTP);
        } else if (nosoal == "9") {
            $("#txtjawab9").val("KURANG PUAS");
            $("#txtnilai9").val(nilaiTP);
        }
        isiJawaban()
    });

    $("#cmdP").click(function() {
        var nosoal = $("#txttransnosoal").val();
        var nilaiTP = $("#txttransnilaiP").val();
        if (nosoal == "1") {
            $("#txtjawab1").val("PUAS");
            $("#txtnilai1").val(nilaiTP);
        } else if (nosoal == "2") {
            $("#txtjawab2").val("PUAS");
            $("#txtnilai2").val(nilaiTP);
        } else if (nosoal == "3") {
            $("#txtjawab3").val("PUAS");
            $("#txtnilai3").val(nilaiTP);
        } else if (nosoal == "4") {
            $("#txtjawab4").val("PUAS");
            $("#txtnilai4").val(nilaiTP);
        } else if (nosoal == "5") {
            $("#txtjawab5").val("PUAS");
            $("#txtnilai5").val(nilaiTP);
        } else if (nosoal == "6") {
            $("#txtjawab6").val("PUAS");
            $("#txtnilai6").val(nilaiTP);
        } else if (nosoal == "7") {
            $("#txtjawab7").val("PUAS");
            $("#txtnilai7").val(nilaiTP);
        } else if (nosoal == "8") {
            $("#txtjawab8").val("PUAS");
            $("#txtnilai8").val(nilaiTP);
        } else if (nosoal == "9") {
            $("#txtjawab9").val("PUAS");
            $("#txtnilai9").val(nilaiTP);
        }
        isiJawaban()
    });

    $("#cmdSP").click(function() {
        var nosoal = $("#txttransnosoal").val();
        var nilaiTP = $("#txttransnilaiSP").val();
        if (nosoal == "1") {
            $("#txtjawab1").val("PUAS");
            $("#txtnilai1").val(nilaiTP);
        } else if (nosoal == "2") {
            $("#txtjawab2").val("SANGAT PUAS");
            $("#txtnilai2").val(nilaiTP);
        } else if (nosoal == "3") {
            $("#txtjawab3").val("SANGAT PUAS");
            $("#txtnilai3").val(nilaiTP);
        } else if (nosoal == "4") {
            $("#txtjawab4").val("SANGAT PUAS");
            $("#txtnilai4").val(nilaiTP);
        } else if (nosoal == "5") {
            $("#txtjawab5").val("SANGAT PUAS");
            $("#txtnilai5").val(nilaiTP);
        } else if (nosoal == "6") {
            $("#txtjawab6").val("SANGAT PUAS");
            $("#txtnilai6").val(nilaiTP);
        } else if (nosoal == "7") {
            $("#txtjawab7").val("SANGAT PUAS");
            $("#txtnilai7").val(nilaiTP);
        } else if (nosoal == "8") {
            $("#txtjawab8").val("SANGAT PUAS");
            $("#txtnilai8").val(nilaiTP);
        } else if (nosoal == "9") {
            $("#txtjawab9").val("SANGAT PUAS");
            $("#txtnilai9").val(nilaiTP);
        }
        isiJawaban()
    });
</script>