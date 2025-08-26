<?php
error_reporting(0);
require_once '../../../services/config.php';
$dbconn = mysqli_connect($dbhost,$dbuser,$dbpass,$dbname)or die('Could not connect: '); 

$qri = ("SELECT id_mapel,mata_pelajaran,jumlah_siswa,minimal_siswa_rombel FROM m_jam_bk WHERE id_jam='1'");
$dbquery = mysqli_query($dbconn,$qri);$c= mysqli_fetch_assoc($dbquery);
$idmapel = strtoupper($c['id_mapel']);
$matapelajaran =$c['mata_pelajaran'];
$jumlahsiswa =$c['jumlah_siswa'];
$jmlsiswaperrombel =$c['minimal_siswa_rombel'];
mysqli_free_result($dbquery);mysqli_close($dbconn);
?>    				
			<div class="modal-header px-4 position-relative modal-shape-header bg-shape">			  
			<div class="position-relative z-index-1 light">
                  <h5 class="mb-0 text-white">Edit Rumusan Bimbingan Konseling</h5>
                  <p class="fs--1 mb-0 text-white">Silahkan edit data rumusan bimbingan dan konseling</p>
                </div>
                <button class="btn-close btn-close-white position-absolute top-0 end-0 mt-2 me-2" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body py-3 px-4">

				<div class="mb-3">
                    <label class="form-label" for="txtkodemapelBK">Kode Mata Pelajaran</label>
                    <input class="form-control bg-white" type="text" id="txtkodemapelBK" value="<?php echo $idmapel;?>" maxlength="25" autocomplete="off" disabled style="font-size:13px;"/>
                </div>
				<div class="mb-3">
                    <label class="form-label" for="txtnmmapelBK">Mata Pelajaran</label>
                    <input class="form-control bg-white" type="text" id="txtnmmapelBK" value="<?php echo $matapelajaran;?>" maxlength="100" autocomplete="off" disabled style="font-size:13px;"/>
                </div>
				<div class="mb-3">
                    <label class="form-label" for="txtjumlahsiswaBK">Jumlah Siswa Bimbingan Setara 24 Jam</label>
                    <input class="form-control" type="number" id="txtjumlahsiswaBK" value="<?php echo $jumlahsiswa;?>" autocomplete="off" style="font-size:13px;"/>
                </div>
				<div class="mb-3">
                    <label class="form-label" for="txtjumlahsiswaperRombelBK">Jumlah Maximum Siswa Per Rombel</label>
                    <input class="form-control" type="number" id="txtjumlahsiswaperRombelBK" value="<?php echo $jmlsiswaperrombel;?>" autocomplete="off" style="font-size:13px;"/>
                </div>

            </div>
			<div class="modal-footer">
				<button class="btn btn-sm btn-falcon-danger" type="button" data-bs-dismiss="modal">Batalkan</button>
				<button class="btn btn-sm btn-falcon-primary" type="button" id="cmdSimpanRumusBK">Simpan data</button>
			</div>

<script type="text/javascript" charset="utf-8">
$("#cmdSimpanRumusBK").on("click",function(){
	var kode = $('#txtkodemapelBK').val();
	var nmmapel = $('#txtnmmapelBK').val();
	var jumlahsiswa = $('#txtjumlahsiswaBK').val();
	var maxsiswaperrombel = $('#txtjumlahsiswaperRombelBK').val();

	if(kode.length<=0){$('#txtkodemapelBK').focus();alert('Kode mata pelajaran masih kosong')}
	else if(nmmapel.length<=0){$('#txtnmmapelBK').focus();alert('Nama mata pelajaran masih kosong')}
	else if(jumlahsiswa.length<=0){$('#txtjumlahsiswaBK').focus();alert('Jumlah siswa bimbingan masih kosong')}
	else if(maxsiswaperrombel.length<=0){$('#txtjumlahsiswaperRombelBK').focus();alert('Jumlah maximum siswa per rombel masih kosong')}
	else{
	$.ajax({
		type:"POST",
		url:'aksi/jam-mengajar/aksi_edit_bk.php',
		data:{kode:kode,nmmapel:nmmapel,jumlahsiswa:jumlahsiswa,maxsiswaperrombel:maxsiswaperrombel},
		dataType: "json",
		beforeSend: function(e) {
			$("#cmdSimpanRumusBK").attr("disabled","disabled");
		},		
		success:function(resp){
			if(resp.msg2 == 'ok'){
				setTimeout(function(){ $('#modTambahData').modal('hide');},1000);
				$("#ToastSukses").toast("show");
			}else if(resp.msg2 == 'err_val'){
				alert(resp.msg1);
				$("#cmdSimpanRumusBK").removeAttr("disabled");							
			}else {
				alert('Ada sedikit masalah, silakan coba lagi.');
				$("#cmdSimpanRumusBK").removeAttr("disabled");
			}
		},
		error: function() {
			alert('Koneksi bermasalah periksa internet');
			$("#cmdSimpanRumusBK").removeAttr("disabled");
			$(".modal-body").css("opacity", "");},
	});	
	}; 	
});	
</script>	