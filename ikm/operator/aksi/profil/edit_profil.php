<?php
error_reporting(0);
require_once '../../../services/config.php';
$dbconn = mysqli_connect($dbhost,$dbuser,$dbpass,$dbname)or die('Could not connect: '); 
$idsekolah= trim($_POST['idsekolah']);

$qri = ("SELECT p.npsn,p.nama,p.siswa,p.guru,p.bentuk_pendidikan,p.alamat_jalan,p.rt,p.rw,p.nama_dusun,
		p.lintang,p.bujur,p.status_sekolah,p.akreditasi,p.id_kecamatan,p.id_desa
		FROM tbl_api_dispendik p WHERE p.id='".$idsekolah."'");
$dbquery = mysqli_query($dbconn,$qri);$c= mysqli_fetch_assoc($dbquery);
$npsn = $c['npsn'];
$nama = $c['nama'];
$siswa = $c['siswa'];$guru = $c['guru'];
$bentukpendidikan = $c['bentuk_pendidikan'];
$alamat = $c['alamat_jalan'];
$rt = $c['rt'];$rw = $c['rw'];$dusun = $c['nama_dusun'];
$lintang = $c['lintang'];$bujur = $c['bujur'];$koordinat = $c['lintang'].", ".$c['bujur'];
$statussekolah = $c['status_sekolah'];
$akreditasi = $c['akreditasi'];
$idkecamatan = $c['id_kecamatan'];$iddesa = $c['id_desa'];
mysqli_free_result($dbquery);
?>    				
<div class="modal-header px-4 position-relative modal-shape-header bg-shape">
	<div class="position-relative z-index-1 light">
		<h5 class="mb-0 text-white">Edit Data Profil Sekolah</h6>
		<p class="fs--1 mb-0 text-white">Silahkan edit data profil sekolah</p>
	</div>
	<button class="btn-close btn-close-white position-absolute top-0 end-0 mt-2 me-2" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<div class="modal-body py-3 px-4 bg-light">
	
	<div class="row mb-3 g-3">
		<div class="col-xxl-12">
			<div class="card bg-primary text-white h-lg-100">
				<div class="card-body d-flex align-items-center">
					<p class="fs--1 mt-0 mb-0">
						Lengkapi data <strong>Profil Sekolah</strong> dibawah ini<br />
						Tekan tombol <strong>Simpan Data</strong> untuk menyimpan data
					</p>
				</div>
			</div>
		</div>
	</div>

	<div class="mb-3">
		<label for="txtnmsekolah">Nama Sekolah</label>
		<input class="form-control" type="text" id="txtnmsekolah" value="<?php echo $nama ?>" maxlength="100" autocomplete="off" style="font-size:13px;" />	
	</div>

	<div class="mb-3">
		<a class="fs--1" href="https://www.google.co.id/maps/@-8.175616,113.688576,13z" target="_blank"><strong>Koordinat Lokasi</strong></a>
		<input class="form-control" type="text" id="txtkoordinat" value="<?php echo $koordinat ?>" maxlength="100" autocomplete="off" style="font-size:13px;" />	
	</div>

	<div class="mb-3">
		<label for="txtnpsn">NPSN</label>
		<input class="form-control" type="text" id="txtnpsn" value="<?php echo $npsn ?>" maxlength="15" autocomplete="off" style="font-size:13px;" />	
	</div>

	<div class="row mb-3">
		<div class="col">
			<label for="txtjmlsiswa">Jumlah Siswa</label>
			<input class="form-control" type="number" id="txtjmlsiswa" value="<?php echo $siswa ?>" autocomplete="off" style="font-size:13px;" />	
		</div>
		<div class="col">
			<label for="txtjmlguru">Jumlah Guru</label>
			<input class="form-control" type="number" id="txtjmlguru" value="<?php echo $guru ?>" autocomplete="off" style="font-size:13px;" />	
		</div>
	</div>
	
	<div class="mb-3">
		<label for="cbotingkatpendidikan">Tingkat Pendidikan</label>
		<select class="form-select form-select-sm js-choice px-3" id="cbotingkatpendidikan" size="1" required="required" data-options='{"removeItemButton":true,"placeholder":true}'>		
			<?php
				if ($bentukpendidikan == "SD"){$plhbbm1 = "selected";
				} else if ($bentukpendidikan == "KB"){$plhbbm2 = "selected";
				} else if ($bentukpendidikan == "TK"){$plhbbm3 = "selected";
				} else if ($bentukpendidikan == "SPS"){$plhbbm4 = "selected";
				} else if ($bentukpendidikan == "SMP"){$plhbbm5 = "selected";
				} else if ($bentukpendidikan == "SMK"){$plhbbm6 = "selected";
				} else if ($bentukpendidikan == "Kursus"){$plhbbm7 = "selected";
				} else if ($bentukpendidikan == "SMA"){$plhbbm8 = "selected";
				} else if ($bentukpendidikan == "TPA"){$plhbbm9 = "selected";
				} else if ($bentukpendidikan == "PKBM"){$plhbbm10 = "selected";
				} else if ($bentukpendidikan == "SLB"){$plhbbm11 = "selected";
				} else if ($bentukpendidikan == "SDLB"){$plhbbm12 = "selected";
				} else if ($bentukpendidikan == "SMLB"){$plhbbm13 = "selected";
				} else if ($bentukpendidikan == "SMPLB"){$plhbbm14 = "selected";
				} else if ($bentukpendidikan == "SPK SD"){$plhbbm15 = "selected";}
			echo "
			<option value=''>-</option>
			<option value='SD' $plhbbm1 >SD</option>
			<option value='KB' $plhbbm2 >KB</option>
			<option value='TK' $plhbbm3 >TK</option>
			<option value='SPS' $plhbbm4 >SPS</option>
			<option value='SMP' $plhbbm5 >SMP</option>
			<option value='SMK' $plhbbm6 >SMK</option>
			<option value='Kursus' $plhbbm7 >Kursus</option>
			<option value='SMA' $plhbbm8 >SMA</option>
			<option value='TPA' $plhbbm9 >TPA</option>
			<option value='PKBM' $plhbbm10 >PKBM</option>
			<option value='SLB' $plhbbm11 >SLB</option>
			<option value='SDLB' $plhbbm12 >SDLB</option>
			<option value='SMLB' $plhbbm13 >SMLB</option>
			<option value='SMPLB' $plhbbm14 >SMPLB</option>
			<option value='SPK SD' $plhbbm15 >SPK SD</option>";
			?>
		</select>
	</div>

	<div class="mb-3">
		<label for="cbostatus">Status Sekolah</label>
		<select class="form-select form-select-sm js-choice px-3" id="cbostatus" size="1" required="required" data-options='{"removeItemButton":true,"placeholder":true}'>		
			<?php
				if ($statussekolah == "NEGERI"){$plhneg = "selected";
				} else if ($statussekolah == "SWASTA"){$plhsws = "selected";}
			echo "
			<option value=''>-</option>
			<option value='NEGERI' $plhneg >NEGERI</option>
			<option value='SWASTA' $plhsws >SWASTA</option>";
			?>
		</select>
	</div>

	<div class="mb-3">
		<label for="cboakreditasi">Akreditasi</label>
		<select class="form-select form-select-sm js-choice px-3" id="cboakreditasi" size="1" required="required" data-options='{"removeItemButton":true,"placeholder":true}'>		
			<?php
				if ($akreditasi == "A"){$plhbbm1 = "selected";
				} else if ($akreditasi == "B"){$plhbbm2 = "selected";
				} else if ($akreditasi == "C"){$plhbbm3 = "selected";
				} else if ($akreditasi == "Tidak Terakreditasi"){$plhbbm4 = "selected";
				} else if ($akreditasi == "Belum Terakreditasi"){$plhbbm5 = "selected";
				} else if ($akreditasi == "Terakreditasi"){$plhbbm6 = "selected";}
			echo "
			<option value=''>-</option>
			<option value='A' $plhbbm1 >A</option>
			<option value='B' $plhbbm2 >B</option>
			<option value='C' $plhbbm3 >C</option>
			<option value='Tidak Terakreditasi' $plhbbm4 >Tidak Terakreditasi</option>
			<option value='Belum Terakreditasi' $plhbbm5 >Belum Terakreditasi</option>
			<option value='Terakreditasi' $plhbbm6 >Terakreditasi</option>";
			?>
		</select>
	</div>

	<div class="mb-3">
		<label for="txtalamat">Alamat</label>
		<input class="form-control" type="text" id="txtalamat" value="<?php echo $alamat ?>" maxlength="200" autocomplete="off" style="font-size:13px;" />	
	</div>

	<div class="row mb-3">
		<div class="col">
			<label for="txtrt">RT</label>
			<input class="form-control" type="text" id="txtrt" value="<?php echo $rt ?>" maxlength="25" autocomplete="off" style="font-size:13px;" />
		</div>
		<div class="col">
			<label for="txtrw">RW</label>
			<input class="form-control" type="text" id="txtrw" value="<?php echo $rw ?>" maxlength="25" autocomplete="off" style="font-size:13px;" />
		</div>
	</div>

	<div class="mb-3">
		<label for="txtdusun">Nama Dusun</label>
		<input class="form-control" type="text" id="txtdusun" value="<?php echo $dusun ?>" maxlength="100" autocomplete="off" style="font-size:13px;" />	
	</div>
	
	<div class="mb-3">
		<label for="cbokecamatan">Kecamatan</label>
		<select class="form-select form-select-sm js-choice px-3" id="cbokecamatan" size="1" required="required" data-options='{"removeItemButton":true,"placeholder":true}'>		
			<option value="">-</option>
			<?php
				$qrikec = ("SELECT DISTINCT id_kecamatan,kecamatan FROM tbl_api_dispendik");
				$liskec = mysqli_query($dbconn, $qrikec);
				while ($j = mysqli_fetch_array($liskec)) {
					if ($idkecamatan == $j['id_kecamatan']){$plhugd = "selected";} else {$plhugd = "";}
					echo "<option value=".$j['id_kecamatan']."  $plhugd >".$j['kecamatan']."</option>";
				}
				mysqli_free_result($liskec);
				?>	
		</select>
	</div>

	<div class="mb-3">
		<label for="cbodesa">Kelurahan / Desa</label>
		<select class="form-select form-select-sm js-choice px-3" id="cbodesa" size="1" required="required" data-options='{"removeItemButton":true,"placeholder":true}'>		
			<option value="">-</option>
			<?php
				$qrides = ("SELECT DISTINCT id_desa,desa_kelurahan FROM tbl_api_dispendik WHERE id_kecamatan='".$idkecamatan."'");
				$lisdes = mysqli_query($dbconn, $qrides);
				while ($h = mysqli_fetch_array($lisdes)) {
					if ($iddesa == $h['id_desa']){$plhugds = "selected";} else {$plhugds = "";}
					echo "<option value=".$h['id_desa']."  $plhugds >".$h['desa_kelurahan']."</option>";
				}
				mysqli_free_result($lisdes);
				mysqli_close($dbconn);
				?>	
		</select>
	</div>


</div>
<div class="modal-footer bg-primary justify-content-between">
    <button class="btn btn-sm btn-danger" type="button" data-bs-dismiss="modal">Batalkan</button>
    <button class="btn btn-sm btn-info" type="button" id="cmdSimpanProfil">Simpan data</button>
</div>

<script type="text/javascript" charset="utf-8">
	$("#cmdSimpanProfil").click(function() {

		var idsekolah = $("#lblidinstansi").val();
		var nmsekolah = $('#txtnmsekolah').val();

		const koordinat = $('#txtkoordinat').val();
		const pusat = koordinat.split(',');
        var lintang = pusat[0];
        var bujur = pusat[1];

		var npsn = $('#txtnpsn').val();
		var jmlsiswa = $('#txtjmlsiswa').val();

		var jmlguru = $('#txtjmlguru').val();
		var tingkat = $('#cbotingkatpendidikan').val();

		var statussekolah = $('#cbostatus').val();
		var akreditasi = $('#cboakreditasi').val();
		var alamat = $('#txtalamat').val();
		var rt = $('#txtrt').val();
		var rw = $('#txtrw').val();
		var dusun = $('#txtdusun').val();
		var idkecamatan = $('#cbokecamatan').val();var nmkecamatan = $('#cbokecamatan :selected').text();
		var iddesa = $('#cbodesa').val();var nmdesa = $('#cbodesa :selected').text();

		if (idsekolah.length <= 0) {alert('Identitas sekolah tidak terdeteksi')
		} else if (nmsekolah.length <= 0) {$('#txtnmsekolah').focus();alert('Nama sekolah masih kosong')
		} else if (koordinat.length <= 0 || lintang.length <= 0 || bujur.length <= 0) {$('#txtkoordinat').focus();alert('Koordinat lokasi masih kosong')
		} else if (npsn.length <= 0) {$('#txtnpsn').focus();alert('NPSN masih kosong')
		} else if (jmlsiswa.length <= 0) {$('#txtjmlsiswa').focus();alert('Jumlah siswa masih kosong')
		} else if (jmlguru.length <= 0) {$('#txtjmlguru').focus();alert('Jumlah Guru masih kosong')
		} else if (tingkat.length <= 0) {$('#cbotingkatpendidikan').focus();alert('Tingkat pendidikan masih kosong')
		} else if (statussekolah.length <= 0) {$('#cbostatus').focus();alert('Status sekolah masih kosong')
		} else if (akreditasi.length <= 0) {$('#cboakreditasi').focus();alert('Akreditasi masih kosong')
		} else if (alamat.length <= 0) {$('#txtalamat').focus();alert('Alamat sekolah masih kosong')
		} else if (rt.length <= 0) {$('#txtrt').focus();alert('RT masih kosong')
		} else if (rw.length <= 0) {$('#txtrw').focus();alert('RW masih kosong')
		} else if (dusun.length <= 0) {$('#txtdusun').focus();alert('Nama dusun masih kosong')
		} else if (idkecamatan.length <= 0) {$('#cbokecamatan').focus();alert('Kecamatan masih kosong')
		} else if (iddesa.length <= 0) {$('#cbodesa').focus();alert('Desa / kelurahan masih kosong')
		} else {
			$.ajax({
				type: "POST",
				url: 'aksi/profil/aksi_edit.php',
				data: {idsekolah: idsekolah,nmsekolah: nmsekolah,lintang: lintang,bujur: bujur,npsn: npsn,jmlsiswa: jmlsiswa,jmlguru: jmlguru,
					tingkat: tingkat,statussekolah: statussekolah,akreditasi: akreditasi,alamat: alamat,rt: rt,rw: rw,dusun: dusun,
					idkecamatan: idkecamatan,iddesa: iddesa,nmkecamatan: nmkecamatan,nmdesa: nmdesa},
				dataType: "json",
				beforeSend: function(e) {
					$("#cmdSimpanProfil").attr("disabled", "disabled");
				},
				success: function(resp) {
					if (resp.msg2 == 'ok') {
						setTimeout(function() {
							$('#modEditDataLarge').modal('hide');
						}, 1000);
						$("#ToastSukses").toast("show");
						isiHalamanDetail();
					} else if (resp.msg2 == 'err_val') {
						alert(resp.msg1);
						$("#cmdSimpanProfil").removeAttr("disabled");
					} else {
						alert('Ada sedikit masalah, silakan coba lagi.');
						$("#cmdSimpanProfil").removeAttr("disabled");
					}
				},
				error: function() {
					alert('Koneksi bermasalah periksa internet');
					$("#cmdSimpanProfil").removeAttr("disabled");
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
        data:{idkecamatan:idkecamatan},
        dataType : 'json',
        beforeSend: function(e) {
          $("#loading").fadeIn();
          document.body.style.cursor = "wait";
        },
        success(data) {

          $('#cbodesa').find('option').remove().end().append('<option value="">-</option>')

          for(var i=0; i<data.length; i++){
            $("#cbodesa").append('<option value='+data[i].kddesa+'>'+data[i].nmdesa+'</option>')
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