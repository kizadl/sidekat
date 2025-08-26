<?php
error_reporting(0);
require_once '../../../services/config.php';
$dbconn = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname) or die('Could not connect: ');
date_default_timezone_set('Asia/Jakarta');	
$idptk = trim($_POST['idptk']);
$idsekolah = trim($_POST['idsekolah']);

$qri = ("SELECT p.nama_ptk,p.status_kepegawaian,p.jenis_ptk,p.status_guru,p.id_mapel_diampu,p.mapel_diampu,
		p.sk_mengajar,p.tgl_sk_mengajar
		FROM spm_ptk p WHERE p.id_ptk='" . $idptk . "'");
$dbquery = mysqli_query($dbconn, $qri);
$c = mysqli_fetch_assoc($dbquery);
$namaptk = $c['nama_ptk'];
$statuskepegawaian = $c['status_kepegawaian'];
$jenisptk = $c['jenis_ptk'];
$statusguru = $c['status_guru'];
$idmapel = $c['id_mapel_diampu'];
$nmmapel = $c['mapel_diampu'];
$noskmengajar = strtoupper($c['sk_mengajar']);
$tglsk = $c['tgl_sk_mengajar'];
if ($tglsk == "" OR $tglsk == NULL){
	$tglsk = date('d-m-Y');
} else {
	$tglsk = date('d-m-Y', strtotime($tglsk));
}
mysqli_free_result($dbquery);
?>
<div class="modal-header px-4 position-relative modal-shape-header bg-shape">
	<div class="position-relative z-index-1 light">
		<h5 class="mb-0 text-white">Edit Data Kepegawaian (PTK)</h6>
			<p class="fs--1 mb-0 text-white">Silahkan edit data kepegawaian (PTK)</p>
	</div>
	<button class="btn-close btn-close-white position-absolute top-0 end-0 mt-2 me-2" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<div class="modal-body py-3 px-4 bg-light">

	<div class="row mb-3 g-3">
		<div class="col-xxl-12">
			<div class="card bg-primary text-white h-lg-100">
				<div class="card-body d-flex align-items-center">
					<p class="fs--1 mt-0 mb-0">
						Lengkapi data kepegawaian <strong><?php echo $namaptk ?></strong><br />
						Status Kepegawaian : <strong><?php echo $statuskepegawaian ?></strong> | Jenis PTK : <strong><?php echo $jenisptk ?></strong><br />
						Tekan tombol <strong>Simpan Data</strong> untuk menyimpan data
					</p>
				</div>
			</div>
		</div>
	</div>

	<input class="form-control" type="text" id="txtidptkE" value="<?php echo $idptk ?>" style="font-size:13px;display:none;" />
	<input class="form-control" type="text" id="txtidsekolahptkE" value="<?php echo $idsekolah ?>" style="font-size:13px;display:none;" />

	<div class="card mb-3">
		<div class="card-body bg-light">

			<div class="mb-3">
				<label for="cbostatusguruE">Status Mengajar</label>
				<select class="form-select form-select-sm js-choice px-3" id="cbostatusguruE" size="1" required="required" data-options='{"removeItemButton":true,"placeholder":true}'>
					<?php
					if ($statusguru == "Y") {
						$plhY = "selected";
					} else if ($statusguru == "N") {
						$plhN = "selected";
					}
					echo "
					<option value=''>-</option>
					<option value='Y' $plhY >Guru / Pengajar</option>
					<option value='N' $plhN >Bukan Guru</option>";
					?>
				</select>
			</div>

			<div class="mb-3">
				<label for="cboMapelDetE">Mata Pelajaran Yang Diampu</label>
				<div class="fs--1" id="selectParentIBLE">
					<select class="form-select fs--1" id="cboMapelDetE" data-placeholder="">
						<option value="" selected>Pilih Mata Pelajaran</option>
								<?php
									$qrides = ("SELECT DISTINCT id_mapel,nama_mapel FROM spm_ptk_mapel");
									$lisdes = mysqli_query($dbconn, $qrides);
									while ($h = mysqli_fetch_array($lisdes)) {
										if ($idmapel == $h['id_mapel']) {
											$plhmpl = "selected";
										} else {
											$plhmpl = "";
										}
										echo "<option value=" . $h['id_mapel'] . "  $plhmpl >" . $h['nama_mapel'] . "</option>";
									}
									mysqli_free_result($lisdes);
									mysqli_close($dbconn);
								?>
					</select>
				</div>
			</div>

			<div class="mb-3">
				<label for="txtnoskE">Nomor SK</label>
				<input class="form-control" type="text" id="txtnoskE" value="<?php echo $noskmengajar ?>" maxlength="50" autocomplete="off" style="font-size:13px;" />
			</div>

			<div class="mb-3">
				<label for="txttglskE">Tanggal SK</label>
				<input class="form-control form-control-sm datetimepicker" id="txttglskE" value="<?php echo $tglsk ?>" type="text" placeholder="Tanggal SK" data-options='{"dateFormat":"d-m-Y","disableMobile":true}' />
			</div>

			<div class="mb-0">
				<label class="form-label">Upload File SK</label>
				<input class="form-control form-control-sm" id="btnUploadSKE" type="file" accept=".pdf" />
			</div> 

		</div>
	</div>

</div>
<div class="modal-footer bg-primary justify-content-between">
	<button class="btn btn-sm btn-danger" type="button" data-bs-dismiss="modal">Batalkan</button>
	<button class="btn btn-sm btn-info" type="button" id="cmdSimpanDetailPTKE">Simpan data</button>
</div>

<script src="../assets/js/flatpickr.js"></script>
<script type="text/javascript" charset="utf-8">

	function gantiFile() {
		$("#btnUploadSKE").val('');
	}

	$('#btnUploadSKE').bind('change', function() {
		var extensinya = $('#btnUploadSKE').val().toLowerCase();
		var regex = new RegExp("(.*?)\.(pdf)$");
		if (!(regex.test(extensinya))) {
			alert("File upload harus file documen pdf");
			$('#btnUploadSKE').val(null);
		}
	});

	$('#modEditPTK').on('shown.bs.modal', function(e) {
		$('#modDetailLargeXtra').modal('hide');

		$('#cboMapelDetE').select2({
			dropdownParent: $('#selectParentIBLE'),
			width: 'resolve',
			theme: 'bootstrap4'
		});
	});

	$('#modEditPTK').on('hide.bs.modal', function(e) {
		$('#modDetailLargeXtra').modal('show');
	});

	$("#cmdSimpanDetailPTKE").click(function() {
        var idsekolah = $("#txtidsekolahptkE").val();
        var idptk = $("#txtidptkE").val();
        var sttsmengajar = $("#cbostatusguruE").val();
        var idmapel = $("#cboMapelDetE").val();var nmmapel = $("#cboMapelDetE :selected").text();

        var tglsk = $("#txttglskE").val();
        var nosk = $("#txtnoskE").val();
        
		var filesk = $("#btnUploadSKE").val();

        var data = new FormData();
        data.append('upSKE', $("#btnUploadSKE")[0].files[0]);
        data.append('idsekolah', idsekolah);
        data.append('idptk', idptk);
        data.append('sttsmengajar', sttsmengajar);
        
        data.append('idmapel', idmapel);
        data.append('nmmapel', nmmapel);
        data.append('tglsk', tglsk);
        data.append('nosk', nosk);

        if (idsekolah.length <= 0 || idptk.length <= 0) {
            alert("Pegawai tidak terdeteksi")
        } else if (sttsmengajar.length <= 0) {
            $("#cbostatusguruE").focus();
            alert("Status mengajar masih kosong")
        } else if (idmapel.length <= 0 || nmmapel.length <= 0) {
            $("#cboMapelDetE").focus();
            alert("Mata pelajaran yang diampu masih kosong")
        } else if (tglsk.length <= 0) {
            $("#txttglskE").focus();
            alert("Tanggal SK masih kosong")
        } else if (nosk.length <= 0) {
            $("#txtnoskE").focus();
            alert("Nomor SK masih kosong")
        } else if (filesk.length <= 0) {
            alert("File upload SK masih kosong")
        } else {
            $.ajax({
                type: "POST",
                url: 'aksi/ptk/aksi_edit_ptk.php',
                data: data,
                dataType: "json",
                processData: false,
                contentType: false,
                beforeSend: function(e) {
                    $("#cmdSimpanDetailPTKE").attr("disabled", "disabled");
                },
                success: function(resp) {
                    if (resp.msg2 == 'ok') {
                        setTimeout(function() {
                            $('#modEditPTK').modal('hide');
                        }, 1000);
                        $("#ToastSukses").toast("show");
                    } else if (resp.msg2 == 'err_val') {
                        alert(resp.msg1);
                        $("#cmdSimpanDetailPTKE").removeAttr("disabled");
                    } else {
                        alert('Ada sedikit masalah, silakan coba lagi.');
                        $("#cmdSimpanDetailPTKE").removeAttr("disabled");
                    }
                },
                error: function() {
                    alert('Koneksi bermasalah periksa internet');
                    $("#cmdSimpanDetailPTKE").removeAttr("disabled");
                    $(".modal-body").css("opacity", "");
                },
            });
        };
	});
</script>