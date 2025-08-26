<?php
error_reporting(0);
include '../../../services/config.php';
$dbconn = mysqli_connect($dbhost,$dbuser,$dbpass,$dbname)or die('Could not connect: '); 
$idsekolah= trim($_POST['idsekolah']);

$sqlx = ("SELECT * FROM tbl_api_dispendik WHERE id='".$idsekolah."'");
$result = mysqli_query($dbconn,$sqlx);$sm= mysqli_fetch_assoc($result);

$jml_ruang_kelas = $sm['jml_ruang_kelas'];$ruang_kelas_baik = $sm['ruang_kelas_baik'];$ruang_kelas_rusak_ringan = $sm['ruang_kelas_rusak_ringan'];
$ruang_kelas_rusak_sedang = $sm['ruang_kelas_rusak_sedang'];$ruang_kelas_rusak_berat = $sm['ruang_kelas_rusak_berat'];

$jml_ruang_perpustakaan = $sm['jml_ruang_perpustakaan'];$ruang_perpustakaan_baik = $sm['ruang_perpustakaan_baik'];$ruang_perpustakaan_rusak_ringan = $sm['ruang_perpustakaan_rusak_ringan'];
$ruang_perpustakaan_rusak_sedang = $sm['ruang_perpustakaan_rusak_sedang'];$ruang_perpustakaan_rusak_berat = $sm['ruang_perpustakaan_rusak_berat'];

$jml_ruang_kepala_sekolah = $sm['jml_ruang_kepala_sekolah'];$ruang_kepala_sekolah_baik = $sm['ruang_kepala_sekolah_baik'];$ruang_kepala_sekolah_rusak_ringan = $sm['ruang_kepala_sekolah_rusak_ringan'];
$ruang_kepala_sekolah_rusak_sedang = $sm['ruang_kepala_sekolah_rusak_sedang'];$ruang_kepala_sekolah_rusak_berat = $sm['ruang_kepala_sekolah_rusak_berat'];

$jml_ruang_guru = $sm['jml_ruang_guru'];$ruang_guru_baik = $sm['ruang_guru_baik'];$ruang_guru_rusak_ringan = $sm['ruang_guru_rusak_ringan'];
$ruang_guru_rusak_sedang = $sm['ruang_guru_rusak_sedang'];$ruang_guru_rusak_berat = $sm['ruang_guru_rusak_berat'];

$jml_ruang_bina = $sm['jml_ruang_bina'];$ruang_bina_baik = $sm['ruang_bina_baik'];$ruang_bina_rusak_ringan = $sm['ruang_bina_rusak_ringan'];
$ruang_bina_rusak_sedang = $sm['ruang_bina_rusak_sedang'];$ruang_bina_rusak_berat = $sm['ruang_bina_rusak_berat'];

$jml_lab_multimedia = $sm['jml_lab_multimedia'];$laboratorium_multimedia_baik = $sm['laboratorium_multimedia_baik'];$laboratorium_multimedia_rusak_ringan = $sm['laboratorium_multimedia_rusak_ringan'];
$laboratorium_multimedia_rusak_sedang = $sm['laboratorium_multimedia_rusak_sedang'];$laboratorium_multimedia_rusak_berat = $sm['laboratorium_multimedia_rusak_berat'];

$jml_lab_komputer = $sm['jml_lab_komputer'];$laboratorium_komputer_baik = $sm['laboratorium_komputer_baik'];$laboratorium_komputer_rusak_ringan = $sm['laboratorium_komputer_rusak_ringan'];
$laboratorium_komputer_rusak_sedang = $sm['laboratorium_komputer_rusak_sedang'];$laboratorium_komputer_rusak_berat = $sm['laboratorium_komputer_rusak_berat'];

$jml_lab_ips = $sm['jml_lab_ips'];$laboratorium_ips_baik = $sm['laboratorium_ips_baik'];$laboratorium_ips_rusak_ringan = $sm['laboratorium_ips_rusak_ringan'];
$laboratorium_ips_rusak_sedang = $sm['laboratorium_ips_rusak_sedang'];$laboratorium_ips_rusak_berat = $sm['laboratorium_ips_rusak_berat'];

$jml_lab_ipa = $sm['jml_lab_ipa'];$laboratorium_ipa_baik = $sm['laboratorium_ipa_baik'];$laboratorium_ipa_rusak_ringan = $sm['laboratorium_ipa_rusak_ringan'];
$laboratorium_ipa_rusak_sedang = $sm['laboratorium_ipa_rusak_sedang'];$laboratorium_ipa_rusak_berat = $sm['laboratorium_ipa_rusak_berat'];

$jml_lab_bahasa = $sm['jml_lab_bahasa'];$laboratorium_bahasa_baik = $sm['laboratorium_bahasa_baik'];$laboratorium_bahasa_rusak_ringan = $sm['laboratorium_bahasa_rusak_ringan'];
$laboratorium_bahasa_rusak_sedang = $sm['laboratorium_bahasa_rusak_sedang'];$laboratorium_bahasa_rusak_berat = $sm['laboratorium_bahasa_rusak_berat'];

$jml_wc_umum = $sm['jml_wc_umum'];$wc_umum_baik = $sm['wc_umum_baik'];$wc_umum_rusak_ringan = $sm['wc_umum_rusak_ringan'];
$wc_umum_rusak_sedang = $sm['wc_umum_rusak_sedang'];$wc_umum_rusak_berat = $sm['wc_umum_rusak_berat'];

$jml_wc_siswa = $sm['jml_wc_siswa'];$wc_siswa_baik = $sm['wc_siswa_baik'];$wc_siswa_rusak_ringan = $sm['wc_siswa_rusak_ringan'];
$wc_siswa_rusak_sedang = $sm['wc_siswa_rusak_sedang'];$wc_siswa_rusak_berat = $sm['wc_siswa_rusak_berat'];

$jml_wc_guru = $sm['jml_wc_guru'];$wc_guru_baik = $sm['wc_guru_baik'];$wc_guru_rusak_ringan = $sm['wc_guru_rusak_ringan'];
$wc_guru_rusak_sedang = $sm['wc_guru_rusak_sedang'];$wc_guru_rusak_berat = $sm['wc_guru_rusak_berat'];

$jml_tempat_ibadah = $sm['jml_tempat_ibadah'];$tempat_ibadah_baik = $sm['tempat_ibadah_baik'];$tempat_ibadah_rusak_ringan = $sm['tempat_ibadah_rusak_ringan'];
$tempat_ibadah_rusak_sedang = $sm['tempat_ibadah_rusak_sedang'];$tempat_ibadah_rusak_berat = $sm['tempat_ibadah_rusak_berat'];

$jml_asrama = $sm['jml_asrama'];$asrama_siswa_baik = $sm['asrama_siswa_baik'];$asrama_siswa_rusak_ringan = $sm['asrama_siswa_rusak_ringan'];
$asrama_siswa_rusak_sedang = $sm['asrama_siswa_rusak_sedang'];$asrama_siswa_rusak_berat = $sm['asrama_siswa_rusak_berat'];

mysqli_free_result($result);
mysqli_close($dbconn);
?>    				
<div class="modal-header px-4 position-relative modal-shape-header bg-shape">
	<div class="position-relative z-index-1 light">
		<h5 class="mb-0 text-white">Edit Data Prasarana Sekolah</h6>
		<p class="fs--1 mb-0 text-white">Silahkan edit data prasarana sekolah</p>
	</div>
	<button class="btn-close btn-close-white position-absolute top-0 end-0 mt-2 me-2" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<div class="modal-body py-3 px-4 bg-light">
	
	<div class="row mb-3 g-3">
		<div class="col-xxl-12">
			<div class="card bg-primary text-white h-lg-100">
				<div class="card-body d-flex align-items-center">
					<p class="fs--1 mt-0 mb-0">
						Lengkapi data <strong>Prasarana Sekolah (Kondisi Prasarana Sekolah)</strong> masing-masing ruangan dengan jumlah kondisi ruangan <strong>Baik, Rusak Ringan, Rusak Sedang dan Rusak Berat</strong><br />
						Tekan tombol <strong>Simpan Data</strong> untuk menyimpan data
					</p>
				</div>
			</div>
		</div>
	</div>

	<div class="row mb-3">
		<div class="col-md-3">
			<label for="txtkelasB">Ruang Kelas</label>
			<input class="form-control text-center" type="number" id="txtkelasB" value="<?php echo $ruang_kelas_baik ?>" autocomplete="off" style="font-size:13px;" />	
			<span class="text-primary fs--2 fw-semi-bold">Kondisi Baik</span>
		</div>
		<div class="col-md-3">
			<label for="txtkelasRR">&nbsp;</label>
			<input class="form-control text-center" type="number" id="txtkelasRR" value="<?php echo $ruang_kelas_rusak_ringan ?>" autocomplete="off" style="font-size:13px;" />	
			<span class="text-info fs--2 fw-semi-bold">Kondisi Rusak Ringan</span>
		</div>
		<div class="col-md-3">
			<label for="txtkelasRS">&nbsp;</label>
			<input class="form-control text-center" type="number" id="txtkelasRS" value="<?php echo $ruang_kelas_rusak_sedang ?>" autocomplete="off" style="font-size:13px;" />	
			<span class="text-warning fs--2 fw-semi-bold">Kondisi Rusak Sedang</span>
		</div>
		<div class="col-md-3">
			<label for="txtkelasRB">&nbsp;</label>
			<input class="form-control text-center" type="number" id="txtkelasRB" value="<?php echo $ruang_kelas_rusak_berat ?>" autocomplete="off" style="font-size:13px;" />	
			<span class="text-danger fs--2 fw-semi-bold">Kondisi Rusak Berat</span>
		</div>
	</div>
	<hr/>
	<div class="row mb-3">
		<div class="col-md-3">
			<label for="txtperpustakaanB">Ruang Perpustakaan</label>
			<input class="form-control text-center" type="number" id="txtperpustakaanB" value="<?php echo $ruang_perpustakaan_baik ?>" autocomplete="off" style="font-size:13px;" />	
			<span class="text-primary fs--2 fw-semi-bold">Kondisi Baik</span>
		</div>
		<div class="col-md-3">
			<label for="txtperpustakaanRR">&nbsp;</label>
			<input class="form-control text-center" type="number" id="txtperpustakaanRR" value="<?php echo $ruang_perpustakaan_rusak_ringan ?>" autocomplete="off" style="font-size:13px;" />	
			<span class="text-info fs--2 fw-semi-bold">Kondisi Rusak Ringan</span>
		</div>
		<div class="col-md-3">
			<label for="txtperpustakaanRS">&nbsp;</label>
			<input class="form-control text-center" type="number" id="txtperpustakaanRS" value="<?php echo $ruang_perpustakaan_rusak_sedang ?>" autocomplete="off" style="font-size:13px;" />	
			<span class="text-warning fs--2 fw-semi-bold">Kondisi Rusak Sedang</span>
		</div>
		<div class="col-md-3">
			<label for="txtperpustakaanRB">&nbsp;</label>
			<input class="form-control text-center" type="number" id="txtperpustakaanRB" value="<?php echo $ruang_perpustakaan_rusak_berat ?>" autocomplete="off" style="font-size:13px;" />	
			<span class="text-danger fs--2 fw-semi-bold">Kondisi Rusak Berat</span>
		</div>
	</div>
	<hr/>
	<div class="row mb-3">
		<div class="col-md-3">
			<label for="txtkepsekB">Ruang Kepala Sekolah</label>
			<input class="form-control text-center" type="number" id="txtkepsekB" value="<?php echo $ruang_kepala_sekolah_baik ?>" autocomplete="off" style="font-size:13px;" />	
			<span class="text-primary fs--2 fw-semi-bold">Kondisi Baik</span>
		</div>
		<div class="col-md-3">
			<label for="txtkepsekRR">&nbsp;</label>
			<input class="form-control text-center" type="number" id="txtkepsekRR" value="<?php echo $ruang_kepala_sekolah_rusak_ringan ?>" autocomplete="off" style="font-size:13px;" />	
			<span class="text-info fs--2 fw-semi-bold">Kondisi Rusak Ringan</span>
		</div>
		<div class="col-md-3">
			<label for="txtkepsekRS">&nbsp;</label>
			<input class="form-control text-center" type="number" id="txtkepsekRS" value="<?php echo $ruang_kepala_sekolah_rusak_sedang ?>" autocomplete="off" style="font-size:13px;" />	
			<span class="text-warning fs--2 fw-semi-bold">Kondisi Rusak Sedang</span>
		</div>
		<div class="col-md-3">
			<label for="txtkepsekRB">&nbsp;</label>
			<input class="form-control text-center" type="number" id="txtkepsekRB" value="<?php echo $ruang_kepala_sekolah_rusak_berat ?>" autocomplete="off" style="font-size:13px;" />	
			<span class="text-danger fs--2 fw-semi-bold">Kondisi Rusak Berat</span>
		</div>
	</div>
	<hr/>
	<div class="row mb-3">
		<div class="col-md-3">
			<label for="txtguruB">Ruang Guru</label>
			<input class="form-control text-center" type="number" id="txtguruB" value="<?php echo $ruang_guru_baik ?>" autocomplete="off" style="font-size:13px;" />	
			<span class="text-primary fs--2 fw-semi-bold">Kondisi Baik</span>
		</div>
		<div class="col-md-3">
			<label for="txtguruRR">&nbsp;</label>
			<input class="form-control text-center" type="number" id="txtguruRR" value="<?php echo $ruang_guru_rusak_ringan ?>" autocomplete="off" style="font-size:13px;" />	
			<span class="text-info fs--2 fw-semi-bold">Kondisi Rusak Ringan</span>
		</div>
		<div class="col-md-3">
			<label for="txtguruRS">&nbsp;</label>
			<input class="form-control text-center" type="number" id="txtguruRS" value="<?php echo $ruang_guru_rusak_sedang ?>" autocomplete="off" style="font-size:13px;" />	
			<span class="text-warning fs--2 fw-semi-bold">Kondisi Rusak Sedang</span>
		</div>
		<div class="col-md-3">
			<label for="txtguruRB">&nbsp;</label>
			<input class="form-control text-center" type="number" id="txtguruRB" value="<?php echo $ruang_guru_rusak_berat ?>" autocomplete="off" style="font-size:13px;" />	
			<span class="text-danger fs--2 fw-semi-bold">Kondisi Rusak Berat</span>
		</div>
	</div>
	<hr/>
	<div class="row mb-3">
		<div class="col-md-3">
			<label for="txtbinaB">Ruang Pembinaan</label>
			<input class="form-control text-center" type="number" id="txtbinaB" value="<?php echo $ruang_bina_baik ?>" autocomplete="off" style="font-size:13px;" />	
			<span class="text-primary fs--2 fw-semi-bold">Kondisi Baik</span>
		</div>
		<div class="col-md-3">
			<label for="txtbinaRR">&nbsp;</label>
			<input class="form-control text-center" type="number" id="txtbinaRR" value="<?php echo $ruang_bina_rusak_ringan ?>" autocomplete="off" style="font-size:13px;" />	
			<span class="text-info fs--2 fw-semi-bold">Kondisi Rusak Ringan</span>
		</div>
		<div class="col-md-3">
			<label for="txtbinaRS">&nbsp;</label>
			<input class="form-control text-center" type="number" id="txtbinaRS" value="<?php echo $ruang_bina_rusak_sedang ?>" autocomplete="off" style="font-size:13px;" />	
			<span class="text-warning fs--2 fw-semi-bold">Kondisi Rusak Sedang</span>
		</div>
		<div class="col-md-3">
			<label for="txtbinaRB">&nbsp;</label>
			<input class="form-control text-center" type="number" id="txtbinaRB" value="<?php echo $ruang_bina_rusak_berat ?>" autocomplete="off" style="font-size:13px;" />	
			<span class="text-danger fs--2 fw-semi-bold">Kondisi Rusak Berat</span>
		</div>
	</div>
	<hr/>
	<div class="row mb-3">
		<div class="col-md-3">
			<label for="txtmultimediaB">Ruang Lab. Multimedia</label>
			<input class="form-control text-center" type="number" id="txtmultimediaB" value="<?php echo $laboratorium_multimedia_baik ?>" autocomplete="off" style="font-size:13px;" />	
			<span class="text-primary fs--2 fw-semi-bold">Kondisi Baik</span>
		</div>
		<div class="col-md-3">
			<label for="txtmultimediaRR">&nbsp;</label>
			<input class="form-control text-center" type="number" id="txtmultimediaRR" value="<?php echo $laboratorium_multimedia_rusak_ringan ?>" autocomplete="off" style="font-size:13px;" />	
			<span class="text-info fs--2 fw-semi-bold">Kondisi Rusak Ringan</span>
		</div>
		<div class="col-md-3">
			<label for="txtmultimediaRS">&nbsp;</label>
			<input class="form-control text-center" type="number" id="txtmultimediaRS" value="<?php echo $laboratorium_multimedia_rusak_sedang ?>" autocomplete="off" style="font-size:13px;" />	
			<span class="text-warning fs--2 fw-semi-bold">Kondisi Rusak Sedang</span>
		</div>
		<div class="col-md-3">
			<label for="txtmultimediaRB">&nbsp;</label>
			<input class="form-control text-center" type="number" id="txtmultimediaRB" value="<?php echo $laboratorium_multimedia_rusak_berat ?>" autocomplete="off" style="font-size:13px;" />	
			<span class="text-danger fs--2 fw-semi-bold">Kondisi Rusak Berat</span>
		</div>
	</div>
	<hr/>
	<div class="row mb-3">
		<div class="col-md-3">
			<label for="txtkomputerB">Ruang Lab. Komputer</label>
			<input class="form-control text-center" type="number" id="txtkomputerB" value="<?php echo $laboratorium_komputer_baik ?>" autocomplete="off" style="font-size:13px;" />	
			<span class="text-primary fs--2 fw-semi-bold">Kondisi Baik</span>
		</div>
		<div class="col-md-3">
			<label for="txtkomputerRR">&nbsp;</label>
			<input class="form-control text-center" type="number" id="txtkomputerRR" value="<?php echo $laboratorium_komputer_rusak_ringan ?>" autocomplete="off" style="font-size:13px;" />	
			<span class="text-info fs--2 fw-semi-bold">Kondisi Rusak Ringan</span>
		</div>
		<div class="col-md-3">
			<label for="txtkomputerRS">&nbsp;</label>
			<input class="form-control text-center" type="number" id="txtkomputerRS" value="<?php echo $laboratorium_komputer_rusak_sedang ?>" autocomplete="off" style="font-size:13px;" />	
			<span class="text-warning fs--2 fw-semi-bold">Kondisi Rusak Sedang</span>
		</div>
		<div class="col-md-3">
			<label for="txtkomputerRB">&nbsp;</label>
			<input class="form-control text-center" type="number" id="txtkomputerRB" value="<?php echo $laboratorium_komputer_rusak_berat ?>" autocomplete="off" style="font-size:13px;" />	
			<span class="text-danger fs--2 fw-semi-bold">Kondisi Rusak Berat</span>
		</div>
	</div>
	<hr/>
	<div class="row mb-3">
		<div class="col-md-3">
			<label for="txtIPSB">Ruang Lab. IPS</label>
			<input class="form-control text-center" type="number" id="txtIPSB" value="<?php echo $laboratorium_ips_baik ?>" autocomplete="off" style="font-size:13px;" />	
			<span class="text-primary fs--2 fw-semi-bold">Kondisi Baik</span>
		</div>
		<div class="col-md-3">
			<label for="txtIPSRR">&nbsp;</label>
			<input class="form-control text-center" type="number" id="txtIPSRR" value="<?php echo $laboratorium_ips_rusak_ringan ?>" autocomplete="off" style="font-size:13px;" />	
			<span class="text-info fs--2 fw-semi-bold">Kondisi Rusak Ringan</span>
		</div>
		<div class="col-md-3">
			<label for="txtIPSRS">&nbsp;</label>
			<input class="form-control text-center" type="number" id="txtIPSRS" value="<?php echo $laboratorium_ips_rusak_sedang ?>" autocomplete="off" style="font-size:13px;" />	
			<span class="text-warning fs--2 fw-semi-bold">Kondisi Rusak Sedang</span>
		</div>
		<div class="col-md-3">
			<label for="txtIPSRB">&nbsp;</label>
			<input class="form-control text-center" type="number" id="txtIPSRB" value="<?php echo $laboratorium_ips_rusak_berat ?>" autocomplete="off" style="font-size:13px;" />	
			<span class="text-danger fs--2 fw-semi-bold">Kondisi Rusak Berat</span>
		</div>
	</div>
	<hr/>
	<div class="row mb-3">
		<div class="col-md-3">
			<label for="txtIPAB">Ruang Lab. IPA</label>
			<input class="form-control text-center" type="number" id="txtIPAB" value="<?php echo $laboratorium_ipa_baik ?>" autocomplete="off" style="font-size:13px;" />	
			<span class="text-primary fs--2 fw-semi-bold">Kondisi Baik</span>
		</div>
		<div class="col-md-3">
			<label for="txtIPARR">&nbsp;</label>
			<input class="form-control text-center" type="number" id="txtIPARR" value="<?php echo $laboratorium_ipa_rusak_ringan ?>" autocomplete="off" style="font-size:13px;" />	
			<span class="text-info fs--2 fw-semi-bold">Kondisi Rusak Ringan</span>
		</div>
		<div class="col-md-3">
			<label for="txtIPARS">&nbsp;</label>
			<input class="form-control text-center" type="number" id="txtIPARS" value="<?php echo $laboratorium_ipa_rusak_sedang ?>" autocomplete="off" style="font-size:13px;" />	
			<span class="text-warning fs--2 fw-semi-bold">Kondisi Rusak Sedang</span>
		</div>
		<div class="col-md-3">
			<label for="txtIPARB">&nbsp;</label>
			<input class="form-control text-center" type="number" id="txtIPARB" value="<?php echo $laboratorium_ipa_rusak_berat ?>" autocomplete="off" style="font-size:13px;" />	
			<span class="text-danger fs--2 fw-semi-bold">Kondisi Rusak Berat</span>
		</div>
	</div>
	<hr/>
	<div class="row mb-3">
		<div class="col-md-3">
			<label for="txtbahasaB">Ruang Lab. Bahasa</label>
			<input class="form-control text-center" type="number" id="txtbahasaB" value="<?php echo $laboratorium_bahasa_baik ?>" autocomplete="off" style="font-size:13px;" />	
			<span class="text-primary fs--2 fw-semi-bold">Kondisi Baik</span>
		</div>
		<div class="col-md-3">
			<label for="txtbahasaRR">&nbsp;</label>
			<input class="form-control text-center" type="number" id="txtbahasaRR" value="<?php echo $laboratorium_bahasa_rusak_ringan ?>" autocomplete="off" style="font-size:13px;" />	
			<span class="text-info fs--2 fw-semi-bold">Kondisi Rusak Ringan</span>
		</div>
		<div class="col-md-3">
			<label for="txtbahasaRS">&nbsp;</label>
			<input class="form-control text-center" type="number" id="txtbahasaRS" value="<?php echo $laboratorium_bahasa_rusak_sedang ?>" autocomplete="off" style="font-size:13px;" />	
			<span class="text-warning fs--2 fw-semi-bold">Kondisi Rusak Sedang</span>
		</div>
		<div class="col-md-3">
			<label for="txtbahasaRB">&nbsp;</label>
			<input class="form-control text-center" type="number" id="txtbahasaRB" value="<?php echo $laboratorium_bahasa_rusak_berat ?>" autocomplete="off" style="font-size:13px;" />	
			<span class="text-danger fs--2 fw-semi-bold">Kondisi Rusak Berat</span>
		</div>
	</div>
	<hr/>
	<div class="row mb-3">
		<div class="col-md-3">
			<label for="txtwcumumsB">Ruang WC Umum</label>
			<input class="form-control text-center" type="number" id="txtwcumumsB" value="<?php echo $wc_umum_baik ?>" autocomplete="off" style="font-size:13px;" />	
			<span class="text-primary fs--2 fw-semi-bold">Kondisi Baik</span>
		</div>
		<div class="col-md-3">
			<label for="txtwcumumsRR">&nbsp;</label>
			<input class="form-control text-center" type="number" id="txtwcumumsRR" value="<?php echo $wc_umum_rusak_ringan ?>" autocomplete="off" style="font-size:13px;" />	
			<span class="text-info fs--2 fw-semi-bold">Kondisi Rusak Ringan</span>
		</div>
		<div class="col-md-3">
			<label for="txtwcumumsRS">&nbsp;</label>
			<input class="form-control text-center" type="number" id="txtwcumumsRS" value="<?php echo $wc_umum_rusak_sedang ?>" autocomplete="off" style="font-size:13px;" />	
			<span class="text-warning fs--2 fw-semi-bold">Kondisi Rusak Sedang</span>
		</div>
		<div class="col-md-3">
			<label for="txtwcumumsRB">&nbsp;</label>
			<input class="form-control text-center" type="number" id="txtwcumumsRB" value="<?php echo $wc_umum_rusak_berat ?>" autocomplete="off" style="font-size:13px;" />	
			<span class="text-danger fs--2 fw-semi-bold">Kondisi Rusak Berat</span>
		</div>
	</div>
	<hr/>
	<div class="row mb-3">
		<div class="col-md-3">
			<label for="txtwcsiswaB">Ruang WC Siswa</label>
			<input class="form-control text-center" type="number" id="txtwcsiswaB" value="<?php echo $wc_siswa_baik ?>" autocomplete="off" style="font-size:13px;" />	
			<span class="text-primary fs--2 fw-semi-bold">Kondisi Baik</span>
		</div>
		<div class="col-md-3">
			<label for="txtwcsiswaRR">&nbsp;</label>
			<input class="form-control text-center" type="number" id="txtwcsiswaRR" value="<?php echo $wc_siswa_rusak_ringan ?>" autocomplete="off" style="font-size:13px;" />	
			<span class="text-info fs--2 fw-semi-bold">Kondisi Rusak Ringan</span>
		</div>
		<div class="col-md-3">
			<label for="txtwcsiswaRS">&nbsp;</label>
			<input class="form-control text-center" type="number" id="txtwcsiswaRS" value="<?php echo $wc_siswa_rusak_sedang ?>" autocomplete="off" style="font-size:13px;" />	
			<span class="text-warning fs--2 fw-semi-bold">Kondisi Rusak Sedang</span>
		</div>
		<div class="col-md-3">
			<label for="txtwcsiswaRB">&nbsp;</label>
			<input class="form-control text-center" type="number" id="txtwcsiswaRB" value="<?php echo $wc_siswa_rusak_berat ?>" autocomplete="off" style="font-size:13px;" />	
			<span class="text-danger fs--2 fw-semi-bold">Kondisi Rusak Berat</span>
		</div>
	</div>
	<hr/>
	<div class="row mb-3">
		<div class="col-md-3">
			<label for="txtwcguruB">Ruang WC Guru</label>
			<input class="form-control text-center" type="number" id="txtwcguruB" value="<?php echo $wc_guru_baik ?>" autocomplete="off" style="font-size:13px;" />	
			<span class="text-primary fs--2 fw-semi-bold">Kondisi Baik</span>
		</div>
		<div class="col-md-3">
			<label for="txtwcguruRR">&nbsp;</label>
			<input class="form-control text-center" type="number" id="txtwcguruRR" value="<?php echo $wc_guru_rusak_ringan ?>" autocomplete="off" style="font-size:13px;" />	
			<span class="text-info fs--2 fw-semi-bold">Kondisi Rusak Ringan</span>
		</div>
		<div class="col-md-3">
			<label for="txtwcguruRS">&nbsp;</label>
			<input class="form-control text-center" type="number" id="txtwcguruRS" value="<?php echo $wc_guru_rusak_sedang ?>" autocomplete="off" style="font-size:13px;" />	
			<span class="text-warning fs--2 fw-semi-bold">Kondisi Rusak Sedang</span>
		</div>
		<div class="col-md-3">
			<label for="txtwcguruRB">&nbsp;</label>
			<input class="form-control text-center" type="number" id="txtwcguruRB" value="<?php echo $wc_guru_rusak_berat ?>" autocomplete="off" style="font-size:13px;" />	
			<span class="text-danger fs--2 fw-semi-bold">Kondisi Rusak Berat</span>
		</div>
	</div>
	<hr/>
	<div class="row mb-3">
		<div class="col-md-3">
			<label for="txtibadahB">Ruang Tempat Ibadah</label>
			<input class="form-control text-center" type="number" id="txtibadahB" value="<?php echo $tempat_ibadah_baik ?>" autocomplete="off" style="font-size:13px;" />	
			<span class="text-primary fs--2 fw-semi-bold">Kondisi Baik</span>
		</div>
		<div class="col-md-3">
			<label for="txtibadahRR">&nbsp;</label>
			<input class="form-control text-center" type="number" id="txtibadahRR" value="<?php echo $tempat_ibadah_rusak_ringan ?>" autocomplete="off" style="font-size:13px;" />	
			<span class="text-info fs--2 fw-semi-bold">Kondisi Rusak Ringan</span>
		</div>
		<div class="col-md-3">
			<label for="txtibadahRS">&nbsp;</label>
			<input class="form-control text-center" type="number" id="txtibadahRS" value="<?php echo $tempat_ibadah_rusak_sedang ?>" autocomplete="off" style="font-size:13px;" />	
			<span class="text-warning fs--2 fw-semi-bold">Kondisi Rusak Sedang</span>
		</div>
		<div class="col-md-3">
			<label for="txtibadahRB">&nbsp;</label>
			<input class="form-control text-center" type="number" id="txtibadahRB" value="<?php echo $tempat_ibadah_rusak_berat ?>" autocomplete="off" style="font-size:13px;" />	
			<span class="text-danger fs--2 fw-semi-bold">Kondisi Rusak Berat</span>
		</div>
	</div>
	<hr/>
	<div class="row mb-3">
		<div class="col-md-3">
			<label for="txtasramaB">Asrama</label>
			<input class="form-control text-center" type="number" id="txtasramaB" value="<?php echo $asrama_siswa_baik ?>" autocomplete="off" style="font-size:13px;" />	
			<span class="text-primary fs--2 fw-semi-bold">Kondisi Baik</span>
		</div>
		<div class="col-md-3">
			<label for="txtasramaRR">&nbsp;</label>
			<input class="form-control text-center" type="number" id="txtasramaRR" value="<?php echo $asrama_siswa_rusak_ringan ?>" autocomplete="off" style="font-size:13px;" />	
			<span class="text-info fs--2 fw-semi-bold">Kondisi Rusak Ringan</span>
		</div>
		<div class="col-md-3">
			<label for="txtasramaRS">&nbsp;</label>
			<input class="form-control text-center" type="number" id="txtasramaRS" value="<?php echo $asrama_siswa_rusak_sedang ?>" autocomplete="off" style="font-size:13px;" />	
			<span class="text-warning fs--2 fw-semi-bold">Kondisi Rusak Sedang</span>
		</div>
		<div class="col-md-3">
			<label for="txtasramaRB">&nbsp;</label>
			<input class="form-control text-center" type="number" id="txtasramaRB" value="<?php echo $asrama_siswa_rusak_berat ?>" autocomplete="off" style="font-size:13px;" />	
			<span class="text-danger fs--2 fw-semi-bold">Kondisi Rusak Berat</span>
		</div>
	</div>

</div>
<div class="modal-footer bg-primary justify-content-between">
    <button class="btn btn-sm btn-danger" type="button" data-bs-dismiss="modal">Batalkan</button>
    <button class="btn btn-sm btn-info" type="button" id="cmdSimpanJmlSarana">Simpan data</button>
</div>

<script type="text/javascript" charset="utf-8">
	$("#cmdSimpanJmlSarana").click(function() {

		var idsekolah = $("#lblidinstansi").val();
		kelasB = $('#txtkelasB').val();kelasRR = $('#txtkelasRR').val();kelasRS = $('#txtkelasRS').val();kelasRB = $('#txtkelasRB').val();
		perpustakaanB = $('#txtperpustakaanB').val();perpustakaanRR = $('#txtperpustakaanRR').val();perpustakaanRS = $('#txtperpustakaanRS').val();perpustakaanRB = $('#txtperpustakaanRB').val();
		kepsekB = $('#txtkepsekB').val();kepsekRR = $('#txtkepsekRR').val();kepsekRS = $('#txtkepsekRS').val();kepsekRB = $('#txtkepsekRB').val();
		guruB = $('#txtguruB').val();guruRR = $('#txtguruRR').val();guruRS = $('#txtguruRS').val();guruRB = $('#txtguruRB').val();
		binaB = $('#txtbinaB').val();binaRR = $('#txtbinaRR').val();binaRS = $('#txtbinaRS').val();binaRB = $('#txtbinaRB').val();

		multimediaB = $('#txtmultimediaB').val();multimediaRR = $('#txtmultimediaRR').val();multimediaRS = $('#txtmultimediaRS').val();multimediaRB = $('#txtmultimediaRB').val();
		komputerB = $('#txtkomputerB').val();komputerRR = $('#txtkomputerRR').val();komputerRS = $('#txtkomputerRS').val();komputerRB = $('#txtkomputerRB').val();
		IPSB = $('#txtIPSB').val();IPSRR = $('#txtIPSRR').val();IPSRS = $('#txtIPSRS').val();IPSRB = $('#txtIPSRB').val();
		IPAB = $('#txtIPAB').val();IPARR = $('#txtIPARR').val();IPARS = $('#txtIPARS').val();IPARB = $('#txtIPARB').val();
		bahasaB = $('#txtbahasaB').val();bahasaRR = $('#txtbahasaRR').val();bahasaRS = $('#txtbahasaRS').val();bahasaRB = $('#txtbahasaRB').val();

		wcumumsB = $('#txtwcumumsB').val();wcumumsRR = $('#txtwcumumsRR').val();wcumumsRS = $('#txtwcumumsRS').val();wcumumsRB = $('#txtwcumumsRB').val();
		wcsiswaB = $('#txtwcsiswaB').val();wcsiswaRR = $('#txtwcsiswaRR').val();wcsiswaRS = $('#txtwcsiswaRS').val();wcsiswaRB = $('#txtwcsiswaRB').val();
		wcguruB = $('#txtwcguruB').val();wcguruRR = $('#txtwcguruRR').val();wcguruRS = $('#txtwcguruRS').val();wcguruRB = $('#txtwcguruRB').val();
		ibadahB = $('#txtibadahB').val();ibadahRR = $('#txtibadahRR').val();ibadahRS = $('#txtibadahRS').val();ibadahRB = $('#txtibadahRB').val();
		asramaB = $('#txtasramaB').val();asramaRR = $('#txtasramaRR').val();asramaRS = $('#txtasramaRS').val();asramaRB = $('#txtasramaRB').val();

		if (idsekolah.length <= 0) {alert('Identitas sekolah tidak terdeteksi')
		} else if (kelasB.length <= 0 || kelasRR.length <= 0 || kelasRS.length <= 0 || kelasRB.length <= 0) {$('#txtkelasB').focus();alert('Kondisi kelas masih ada yang kosong')
		} else if (perpustakaanB.length <= 0 || perpustakaanRR.length <= 0 || perpustakaanRS.length <= 0 || perpustakaanRB.length <= 0) {$('#txtperpustakaanB').focus();alert('Kondisi perpustakaan masih ada yang kosong')
		} else if (kepsekB.length <= 0 || kepsekRR.length <= 0 || kepsekRS.length <= 0 || kepsekRB.length <= 0) {$('#txtkepsekB').focus();alert('Kondisi ruang kepala sekolah masih ada yang kosong')
		} else if (guruB.length <= 0 || guruRR.length <= 0 || guruRS.length <= 0 || guruRB.length <= 0) {$('#txtguruB').focus();alert('Kondisi ruang guru masih ada yang kosong')
		} else if (binaB.length <= 0 || binaRR.length <= 0 || binaRS.length <= 0 || binaRB.length <= 0) {$('#txtbinaB').focus();alert('Kondisi ruang bina masih ada yang kosong')

		} else if (multimediaB.length <= 0 || multimediaRR.length <= 0 || multimediaRS.length <= 0 || multimediaRB.length <= 0) {$('#txtmultimediaB').focus();alert('Kondisi lab. multimedia masih ada yang kosong')
		} else if (komputerB.length <= 0 || komputerRR.length <= 0 || komputerRS.length <= 0 || komputerRB.length <= 0) {$('#txtkomputerB').focus();alert('Kondisi lab. komputer masih ada yang kosong')
		} else if (IPSB.length <= 0 || IPSRR.length <= 0 || IPSRS.length <= 0 || IPSRB.length <= 0) {$('#txtIPSB').focus();alert('Kondisi lab. IPS masih ada yang kosong')
		} else if (IPAB.length <= 0 || IPARR.length <= 0 || IPARS.length <= 0 || IPARB.length <= 0) {$('#txtIPAB').focus();alert('Kondisi lab. IPA masih ada yang kosong')
		} else if (bahasaB.length <= 0 || bahasaRR.length <= 0 || bahasaRS.length <= 0 || bahasaRB.length <= 0) {$('#txtbahasaB').focus();alert('Kondisi lab. bahasa masih ada yang kosong')

		} else if (wcumumsB.length <= 0 || wcumumsRR.length <= 0 || wcumumsRS.length <= 0 || wcumumsRB.length <= 0) {$('#txtwcumumsB').focus();alert('Kondisi wc umum masih ada yang kosong')
		} else if (wcsiswaB.length <= 0 || wcsiswaRR.length <= 0 || wcsiswaRS.length <= 0 || wcsiswaRB.length <= 0) {$('#txtwcsiswaB').focus();alert('Kondisi wc siswa masih ada yang kosong')
		} else if (wcguruB.length <= 0 || wcguruRR.length <= 0 || wcguruRS.length <= 0 || wcguruRB.length <= 0) {$('#txtwcguruB').focus();alert('Kondisi wc guru masih ada yang kosong')
		} else if (ibadahB.length <= 0 || ibadahRR.length <= 0 || ibadahRS.length <= 0 || ibadahRB.length <= 0) {$('#txtibadahB').focus();alert('Kondisi ruang ibadah masih ada yang kosong')
		} else if (asramaB.length <= 0 || asramaRR.length <= 0 || asramaRS.length <= 0 || asramaRB.length <= 0) {$('#txtasramaB').focus();alert('Kondisi asrama masih ada yang kosong')

		} else {
		
			$.ajax({
				type: "POST",
				url: 'aksi/profil/aksi_edit_data_sarana.php',
				data: {idsekolah: idsekolah,kelasB:kelasB,kelasRR:kelasRR,kelasRS:kelasRS,kelasRB:kelasRB,
						perpustakaanB:perpustakaanB,perpustakaanRR:perpustakaanRR,perpustakaanRS:perpustakaanRS,perpustakaanRB:perpustakaanRB,
						kepsekB:kepsekB,kepsekRR:kepsekRR,kepsekRS:kepsekRS,kepsekRB:kepsekRB,
						guruB:guruB,guruRR:guruRR,guruRS:guruRS,guruRB:guruRB,
						binaB:binaB,binaRR:binaRR,binaRS:binaRS,binaRB:binaRB,

						multimediaB:multimediaB,multimediaRR:multimediaRR,multimediaRS:multimediaRS,multimediaRB:multimediaRB,
						komputerB:komputerB,komputerRR:komputerRR,komputerRS:komputerRS,komputerRB:komputerRB,
						IPSB:IPSB,IPSRR:IPSRR,IPSRS:IPSRS,IPSRB:IPSRB,
						IPAB:IPAB,IPARR:IPARR,IPARS:IPARS,IPARB:IPARB,
						bahasaB:bahasaB,bahasaRR:bahasaRR,bahasaRS:bahasaRS,bahasaRB:bahasaRB,

						wcumumsB:wcumumsB,wcumumsRR:wcumumsRR,wcumumsRS:wcumumsRS,wcumumsRB:wcumumsRB,
						wcsiswaB:wcsiswaB,wcsiswaRR:wcsiswaRR,wcsiswaRS:wcsiswaRS,wcsiswaRB:wcsiswaRB,
						wcguruB:wcguruB,wcguruRR:wcguruRR,wcguruRS:wcguruRS,wcguruRB:wcguruRB,
						ibadahB:ibadahB,ibadahRR:ibadahRR,ibadahRS:ibadahRS,ibadahRB:ibadahRB,
						asramaB:asramaB,asramaRR:asramaRR,asramaRS:asramaRS,asramaRB:asramaRB},
				dataType: "json",
				beforeSend: function(e) {
					$("#cmdSimpanJmlSarana").attr("disabled", "disabled");
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
						$("#cmdSimpanJmlSarana").removeAttr("disabled");
					} else {
						alert('Ada sedikit masalah, silakan coba lagi.');
						$("#cmdSimpanJmlSarana").removeAttr("disabled");
					}
				},
				error: function() {
					alert('Koneksi bermasalah periksa internet');
					$("#cmdSimpanJmlSarana").removeAttr("disabled");
					$(".modal-body").css("opacity", "");
				},
			});
		};
	});

</script>