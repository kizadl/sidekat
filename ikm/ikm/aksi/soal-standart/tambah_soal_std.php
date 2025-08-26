<?php
error_reporting(0);
require_once '../../../services/config.php';
$dbconn = mysqli_connect($dbhost,$dbuser,$dbpass,$dbname)or die('Could not connect: '); 
?>    			
			<div class="modal-header">			  
			  <h4 class="modal-title">Tambah Data Soal</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">

                 <div class="callout callout-info">
                  <p>Isi data dibawah ini dengan lengkap dan benar<br>
				  <b>1. Unsur Soal<br>2. Isi Soal<br>3. Skor</b> (Tidak Puas, Kurang Puas, Puas, Sangat Puas)</p>
                </div>
				
                <div class="form-group row">
                  <label for="cbounsurStd" class="col-sm-3 col-form-label">Unsur Penilaian</label>
				  <div class="col-sm-9">
					<select class="form-control select2" id="cbounsurStd">
						<option value="" selected="selected"></option>
						<?php
							$qrikec = ("SELECT id_unsur,unsur FROM ikm_m_unsur");								
							$liskec = mysqli_query($dbconn,$qrikec);	
							$no=0;
							while($j=mysqli_fetch_array($liskec)){
								$no++;
								echo "<option value=\"".$j['id_unsur']."\">".$no.". ".ucwords(strtolower($j['unsur']))."</option>";
							}mysqli_free_result($liskec);mysqli_close($dbconn);
						?>														
					</select>
				  </div>
                </div>
				
				<div class="form-group row">
					<label for="txtsoalStd" class="col-sm-3 col-form-label">Soal</label>
					<div class="col-sm-9">
						<input type="text" class="form-control form-control-sm" id="txtsoalStd" value="" autocomplete="off" style="font-size:12px;">
					</div>
				</div>

				<div class="form-group row">
					<label for="txtTPstd" class="col-sm-3 col-form-label">Tidak Puas</label>
					<div class="col-sm-9">
						<input type="number" class="form-control form-control-sm" id="txtTPstd" value="" maxlength="3" autocomplete="off" style="font-size:12px;">
					</div>
				</div>
				<div class="form-group row">
					<label for="txtKPstd" class="col-sm-3 col-form-label">Kurang Puas</label>
					<div class="col-sm-9">
						<input type="number" class="form-control form-control-sm" id="txtKPstd" value="" maxlength="3" autocomplete="off" style="font-size:12px;">
					</div>
				</div>
				<div class="form-group row">
					<label for="txtPstd" class="col-sm-3 col-form-label">Puas</label>
					<div class="col-sm-9">
						<input type="number" class="form-control form-control-sm" id="txtPstd" value="" maxlength="3" autocomplete="off" style="font-size:12px;">
					</div>
				</div>
				<div class="form-group row">
					<label for="txtSPstd" class="col-sm-3 col-form-label">Sangat Puas</label>
					<div class="col-sm-9">
						<input type="number" class="form-control form-control-sm" id="txtSPstd" value="" maxlength="3" autocomplete="off" style="font-size:12px;">
					</div>
				</div>
				
            </div>
            <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-danger btn-sm" id="cmdbatalSoalstd" data-dismiss="modal">&nbsp;Batalkan&nbsp;</button>
              <button type="button" class="btn btn-primary btn-sm" id="cmdsimpanSoalstd">&nbsp;Simpan data&nbsp;</button>
            </div>

<script type="text/javascript" charset="utf-8">
$(document).ready(function(){		
	$('.select2').select2()
});

$("#cmdsimpanSoalstd").click(function(){
	var idunsur = $('#cbounsurStd').val();
	var soal = $('#txtsoalStd').val();
	var TP = $('#txtTPstd').val();var KP = $('#txtKPstd').val();var P = $('#txtPstd').val();var SP = $('#txtSPstd').val();
	
	if(idunsur.length<=0){$('#cbounsurStd').focus();alert('Unsur penilaian masih kosong')}
	else if(soal.length<=0){$('#txtsoalStd').focus();alert('Soal masih kosong')}
	else if(TP.length<=0){$('#txtTPstd').focus();alert('Skor tidak puas masih kosong')}
	else if(KP.length<=0){$('#txtKPstd').focus();alert('Skor kurang puas masih kosong')}
	else if(P.length<=0){$('#txtPstd').focus();alert('Skor puas masih kosong')}
	else if(SP.length<=0){$('#txtSPstd').focus();alert('Skor sangat puas masih kosong')}
	else{
	$.ajax({
		type:"POST",
		url:'aksi/soal-standart/aksi_tambah.php',
		data:{idunsur:idunsur,soal:soal,TP:TP,KP:KP,P:P,SP:SP},
		dataType: "json",
		beforeSend: function(e) {
			$("#cmdsimpanSoalstd").attr("disabled","disabled");
			$("#cmdbatalSoalstd").attr("disabled","disabled");
		},		
		success:function(resp){
			if(resp.msg2 == 'ok'){
				setTimeout(function(){ $('#ModTambahSoalStd').modal('hide');},1000);
				isiMasterSoalStandart();
			}else if(resp.msg2 == 'err_val'){
				alert(resp.msg1);
				$("#cmdsimpanSoalstd").removeAttr("disabled");
				$("#cmdbatalSoalstd").removeAttr("disabled");								
			}else {
				alert('Ada sedikit masalah, silakan coba lagi.');
				$("#cmdsimpanSoalstd").removeAttr("disabled");
				$("#cmdbatalSoalstd").removeAttr("disabled");	
			}
		},
		error: function() {
			alert('Koneksi bermasalah periksa internet');
			$("#cmdsimpanSoalstd").removeAttr("disabled");
			$("#cmdbatalSoalstd").removeAttr("disabled");
			$(".modal-body").css("opacity", "");},
	});	
	}; 	
});	
</script>	