<?php
error_reporting(0);
require_once '../../../services/config.php';
$dbconn = mysqli_connect($dbhost,$dbuser,$dbpass,$dbname)or die('Could not connect: '); 
$idjam= trim($_POST['idjam']);

$qri = ("SELECT id_mapel,mata_pelajaran,jumlah_jam,bentuk_pendidikan FROM m_jam_mapel WHERE id_jam='".$idjam."'");
$dbquery = mysqli_query($dbconn,$qri);$c= mysqli_fetch_assoc($dbquery);
$idmapel = strtoupper($c['id_mapel']);
$matapelajaran =$c['mata_pelajaran'];
$jumlahjam =$c['jumlah_jam'];
$bentukpendidikan = strtoupper($c['bentuk_pendidikan']);

mysqli_free_result($dbquery);mysqli_close($dbconn);
?>    				
			<div class="modal-header px-4 position-relative modal-shape-header bg-shape">			  
			<div class="position-relative z-index-1 light">
                  <h5 class="mb-0 text-white">Edit Mata Pelajaran</h5>
                  <p class="fs--1 mb-0 text-white">Silahkan edit data mata pelajaran</p>
                </div>
                <button class="btn-close btn-close-white position-absolute top-0 end-0 mt-2 me-2" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body py-3 px-4">
				
				<input class="form-control" type="text" id="txtidjammengajarE" value="<?php echo $idjam;?>" style="display:none;"/>

				<div class="mb-3">
                    <label class="form-label" for="txtkodemapelE">Kode Mata Pelajaran</label>
                    <input class="form-control" type="text" id="txtkodemapelE" value="<?php echo $idmapel;?>" maxlength="25" autocomplete="off" style="font-size:13px;"/>
                </div>
				<div class="mb-3">
                    <label class="form-label" for="txtnmmapelE">Mata Pelajaran</label>
                    <input class="form-control" type="text" id="txtnmmapelE" value="<?php echo $matapelajaran;?>" maxlength="100" autocomplete="off" style="font-size:13px;"/>
                </div>
				<div class="mb-3">
                    <label class="form-label" for="txtjamE">Jumlah Jam</label>
                    <input class="form-control" type="number" id="txtjamE" value="<?php echo $jumlahjam;?>" autocomplete="off" style="font-size:13px;"/>
                </div>
				<div class="mb-3">
                    <label class="form-label" for="cbobentukpendidikanE">Bentuk Pendidikan</label>
                    <select class="form-select js-choice" size="1" name="cbobentukpendidikanE" id="cbobentukpendidikanE" data-options='{"removeItemButton":true,"placeholder":true}' style="font-size:14px;" >
						<option value="">-</option>
						<?php
							if ($bentukpendidikan == "SD"){$plhSD = "selected";} else {$plhSD = "";}
							if ($bentukpendidikan == "SMP"){$plhSMP = "selected";} else {$plhSMP = "";}
							echo "<option value='SD' $plhSD >SD</option>";
							echo "<option value='SMP' $plhSMP >SMP</option>";
						?>	
					</select>
				</div>

            </div>
			<div class="modal-footer">
				<button class="btn btn-sm btn-falcon-danger" type="button" data-bs-dismiss="modal">Batalkan</button>
				<button class="btn btn-sm btn-falcon-primary" type="button" id="cmdSimpanMapelE">Simpan data</button>
			</div>

<script type="text/javascript" charset="utf-8">
$("#cmdSimpanMapelE").on("click",function(){
	var idjam = $('#txtidjammengajarE').val();
	var kode = $('#txtkodemapelE').val();
	var nmmapel = $('#txtnmmapelE').val();
	var jam = $('#txtjamE').val();
	var bentuk = $('#cbobentukpendidikanE').val();
	
	if(idjam.length<=0){alert('ID mata pelajaran masih kosong')}
	else if(kode.length<=0){$('#txtkodemapelE').focus();alert('Kode mata pelajaran masih kosong')}
	else if(nmmapel.length<=0){$('#txtnmmapelE').focus();alert('Nama mata pelajaran masih kosong')}
	else if(jam.length<=0){$('#txtjamE').focus();alert('Jumlah Jam masih kosong')}
	else if(bentuk.length<=0){$('#cbobentukpendidikanE').focus();alert('Bentuk pendidikan masih kosong')}
	else{
	$.ajax({
		type:"POST",
		url:'aksi/jam-mengajar/aksi_edit.php',
		data:{idjam:idjam,kode:kode,nmmapel:nmmapel,jam:jam,bentuk:bentuk},
		dataType: "json",
		beforeSend: function(e) {
			$("#cmdSimpanJamMapel").attr("disabled","disabled");
		},		
		success:function(resp){
			if(resp.msg2 == 'ok'){
				setTimeout(function(){ $('#modEditData').modal('hide');},1000);
				$("#ToastSukses").toast("show");
				isiMasterJamMapel();
			}else if(resp.msg2 == 'err_val'){
				alert(resp.msg1);
				$("#cmdSimpanJamMapel").removeAttr("disabled");							
			}else {
				alert('Ada sedikit masalah, silakan coba lagi.');
				$("#cmdSimpanJamMapel").removeAttr("disabled");
			}
		},
		error: function() {
			alert('Koneksi bermasalah periksa internet');
			$("#cmdSimpanJamMapel").removeAttr("disabled");
			$(".modal-body").css("opacity", "");},
	});	
	}; 	
});	
</script>	