<?php
error_reporting(0);
require_once '../../../services/config.php';
$dbconn = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname) or die('Could not connect: ');
$idoperator = trim($_POST['idoperator']);
$idinstansi = trim($_POST['idinstansi']);

$qri = ("SELECT p.nm_cp,p.alamat_cp,p.telepon_cp,p.telepon_kepsek,p.email_cp
		FROM m_operator p WHERE p.id_instansi='" . $idinstansi . "'");
$dbquery = mysqli_query($dbconn, $qri);
$c = mysqli_fetch_assoc($dbquery);
$nmoperator = $c['nm_cp'];
$alamat = $c['alamat_cp'];
$telepon = $c['telepon_cp'];$telpkepsek = $c['telepon_kepsek'];
$email = $c['email_cp'];
mysqli_free_result($dbquery);
?>
<div class="modal-header px-4 position-relative modal-shape-header bg-shape">
	<div class="position-relative z-index-1 light">
		<h5 class="mb-0 text-white">Edit Data Operator</h6>
			<p class="fs--1 mb-0 text-white">Silahkan edit data profil operator sekolah</p>
	</div>
	<button class="btn-close btn-close-white position-absolute top-0 end-0 mt-2 me-2" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<div class="modal-body py-3 px-4 bg-light">

	<div class="row mb-3 g-3">
		<div class="col-xxl-12">
			<div class="card bg-primary text-white h-lg-100">
				<div class="card-body d-flex align-items-center">
					<p class="fs--1 mt-0 mb-0">
						Lengkapi data <strong>Operator Sekolah</strong> dibawah ini<br />
						Tekan tombol <strong>Simpan Data</strong> untuk menyimpan
					</p>

				</div>
			</div>
		</div>
	</div>

	<div class="mb-3">
		<label for="txtnmoperatorOPT">Nama Operator</label>
		<input class="form-control" type="text" id="txtnmoperatorOPT" value="<?php echo $nmoperator ?>" maxlength="50" autocomplete="off" style="font-size:13px;" />
	</div>

	<div class="mb-3">
		<label for="txtalamatOPT">Alamat</label>
		<input class="form-control" type="text" id="txtalamatOPT" value="<?php echo $alamat ?>" maxlength="200" autocomplete="off" style="font-size:13px;" />
	</div>

	<div class="mb-3">
		<label for="txtteleponOPT">No. Telepon</label>
		<input class="form-control" type="number" id="txtteleponOPT" value="<?php echo $telepon ?>" maxlength="30" autocomplete="off" style="font-size:13px;" />
	</div>

	<div class="mb-3">
		<label for="txtteleponKepsekOPT">No. Telepon Kepala Sekolah</label>
		<input class="form-control" type="number" id="txtteleponKepsekOPT" value="<?php echo $telpkepsek ?>" maxlength="30" autocomplete="off" style="font-size:13px;" />
	</div>

	<div class="mb-3">
		<label for="txtemailOPT">Email</label>
		<input class="form-control" type="text" id="txtemailOPT" value="<?php echo $email ?>" maxlength="100" autocomplete="off" style="font-size:13px;" />
	</div>


</div>
<div class="modal-footer bg-primary justify-content-between">
	<button class="btn btn-sm btn-danger" type="button" data-bs-dismiss="modal">Batalkan</button>
	<button class="btn btn-sm btn-info" type="button" id="cmdSimpanProfilOPT">Simpan data</button>
</div>

<script type="text/javascript" charset="utf-8">
	$("#cmdSimpanProfilOPT").click(function() {

		var idsekolah = $("#lblidinstansi").val();
		var nmoperator = $('#txtnmoperatorOPT').val();

		var alamat = $('#txtalamatOPT').val();
		var telepon = $('#txtteleponOPT').val();
		var telpkepsek = $('#txtteleponKepsekOPT').val();
		var email = $('#txtemailOPT').val();

		if (idsekolah.length <= 0) {
			alert('Identitas sekolah tidak terdeteksi')
		} else if (nmoperator.length <= 0) {
			$('#txtnmoperatorOPT').focus();
			alert('Nama operator sekolah masih kosong')
		} else if (alamat.length <= 0) {
			$('#txtalamatOPT').focus();
			alert('Alamat operator masih kosong')
		} else if (telepon.length <= 0) {
			$('#txtteleponOPT').focus();
			alert('No. Telepon operator masih kosong')
		} else if (telpkepsek.length <= 0) {
			$('#txtteleponKepsekOPT').focus();
			alert('No. Telepon kepala sekolah masih kosong')
		} else if (email.length <= 0) {
			$('#txtemailOPT').focus();
			alert('Email operator masih kosong')
		} else {
			$.ajax({
				type: "POST",
				url: 'aksi/profil/aksi_edit_operator.php',
				data: {
					idsekolah: idsekolah,
					nmoperator: nmoperator,
					alamat: alamat,
					telepon: telepon,telpkepsek: telpkepsek,
					email: email
				},
				dataType: "json",
				beforeSend: function(e) {
					$("#cmdSimpanProfilOPT").attr("disabled", "disabled");
				},
				success: function(resp) {
					if (resp.msg2 == 'ok') {
						setTimeout(function() {
							$('#modEditData').modal('hide');
						}, 1000);
						$("#ToastSukses").toast("show");
					} else if (resp.msg2 == 'err_val') {
						alert(resp.msg1);
						$("#cmdSimpanProfilOPT").removeAttr("disabled");
					} else {
						alert('Ada sedikit masalah, silakan coba lagi.');
						$("#cmdSimpanProfilOPT").removeAttr("disabled");
					}
				},
				error: function() {
					alert('Koneksi bermasalah periksa internet');
					$("#cmdSimpanProfilOPT").removeAttr("disabled");
					$(".modal-body").css("opacity", "");
				},
			});
		};
	});

	$("#cbokecamatan").on("change", function() {
		var idkecamatan = $('#cbokecamatan').val();
		$.ajax({
			type: "POST",
			url: "aksi/isi-desa.php",
			data: {
				idkecamatan: idkecamatan
			},
			dataType: 'json',
			beforeSend: function(e) {
				$("#loading").fadeIn();
				document.body.style.cursor = "wait";
			},
			success(data) {

				$('#cbodesa').find('option').remove().end().append('<option value="">-</option>')

				for (var i = 0; i < data.length; i++) {
					$("#cbodesa").append('<option value=' + data[i].kddesa + '>' + data[i].nmdesa + '</option>')
				}

				setTimeout(function() {
					document.body.style.cursor = "default";
					$("#loading").fadeOut("slow");
				}, 1000);
			},
			error: function() {
				setTimeout(function() {
					document.body.style.cursor = "default";
					$("#loading").fadeOut("slow");
				}, 1000);
			},
		});
	});
</script>