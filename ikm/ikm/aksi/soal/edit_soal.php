<?php
error_reporting(0);
require_once '../../../services/config.php';
$dbconn = mysqli_connect($dbhost,$dbuser,$dbpass,$dbname)or die('Could not connect: '); 
$idsoal = trim($_POST['idsoal']);

$sqltps = ("SELECT id_unsur,soal,tidak_puas,kurang_puas,puas,sangat_puas FROM ikm_soal WHERE id_soal='".$idsoal."'");
$restps = mysqli_query($dbconn,$sqltps);$sm= mysqli_fetch_assoc($restps);
$idunsur = $sm['id_unsur'];$soal = $sm['soal'];
$tidakpuas = $sm['tidak_puas'];$kurangpuas = $sm['kurang_puas'];
$puas = $sm['puas'];$sangatpuas = $sm['sangat_puas'];
mysqli_free_result($restps);
?>         	
			
			<div class="modal-header">			  
			  <h4 class="modal-title">Edit Data Soal</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">

                 <div class="callout callout-info">
                  <p>Isi data dibawah ini dengan lengkap dan benar<br>
				  <b>1. Unsur Soal<br>2. Isi Soal<br>3. Skor</b> (Tidak Puas, Kurang Puas, Puas, Sangat Puas)</p>
                </div>
				
<input type="text" class="form-control form-control-sm" id="txtidsoalE" value="<?php echo $idsoal?>" disabled style="display:none">

                <div class="form-group row">
                  <label for="cbounsurE" class="col-sm-3 col-form-label">Unsur Penilaian</label>
				  <div class="col-sm-9">
					<select class="form-control select2" id="cbounsurE" disabled>
						<option value="" selected="selected"></option>
						<?php
							$qrikec = ("SELECT id_unsur,unsur FROM ikm_m_unsur");								
							$liskec = mysqli_query($dbconn,$qrikec);	
							$no=0;
							while($j=mysqli_fetch_array($liskec)){
								$no++;
								if($idunsur==$j['id_unsur']){$plhsal='selected';}else{$plhsal='';}
								echo "<option value=\"".$j['id_unsur']."\" $plhsal >".$no.". ".ucwords(strtolower($j['unsur']))."</option>";
							}mysqli_free_result($liskec);mysqli_close($dbconn);
						?>														
					</select>
				  </div>
                </div>
				
				<div class="form-group row">
					<label for="txtsoalE" class="col-sm-3 col-form-label">Soal</label>
					<div class="col-sm-9">
						<input type="text" class="form-control form-control-sm" id="txtsoalE" value="<?php echo $soal?>" autocomplete="off" style="font-size:12px;">
					</div>
				</div>

				<div class="form-group row">
					<label for="txtTPE" class="col-sm-3 col-form-label">Tidak Puas</label>
					<div class="col-sm-9">
						<input type="number" class="form-control form-control-sm" id="txtTPE" value="<?php echo $tidakpuas?>" maxlength="3" autocomplete="off" style="font-size:12px;">
					</div>
				</div>
				<div class="form-group row">
					<label for="txtKPE" class="col-sm-3 col-form-label">Kurang Puas</label>
					<div class="col-sm-9">
						<input type="number" class="form-control form-control-sm" id="txtKPE" value="<?php echo $kurangpuas?>" maxlength="3" autocomplete="off" style="font-size:12px;">
					</div>
				</div>
				<div class="form-group row">
					<label for="txtPE" class="col-sm-3 col-form-label">Puas</label>
					<div class="col-sm-9">
						<input type="number" class="form-control form-control-sm" id="txtPE" value="<?php echo $puas?>" maxlength="3" autocomplete="off" style="font-size:12px;">
					</div>
				</div>
				<div class="form-group row">
					<label for="txtSPE" class="col-sm-3 col-form-label">Sangat Puas</label>
					<div class="col-sm-9">
						<input type="number" class="form-control form-control-sm" id="txtSPE" value="<?php echo $sangatpuas?>" maxlength="3" autocomplete="off" style="font-size:12px;">
					</div>
				</div>
				
            </div>
            <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-danger btn-sm" id="cmdbatalSoalE" data-dismiss="modal">&nbsp;Batalkan&nbsp;</button>
              <button type="button" class="btn btn-primary btn-sm" id="cmdsimpanSoalE">&nbsp;Simpan data&nbsp;</button>
            </div>

<script type="text/javascript" charset="utf-8">
$(document).ready(function(){		
	$('.select2').select2()
});

$("#cmdsimpanSoalE").click(function(){
	var idinstansi = $('#lblidinstansi').val();
	var idsoal = $('#txtidsoalE').val();
	var idunsur = $('#cbounsurE').val();
	var soal = $('#txtsoalE').val();
	var TP = $('#txtTPE').val();var KP = $('#txtKPE').val();var P = $('#txtPE').val();var SP = $('#txtSPE').val();
	
	if(idsoal.length<=0){alert('Soal tidak terdeteksi')}
	else if(idunsur.length<=0){$('#cbounsurE').focus();alert('Unsur penilaian masih kosong')}
	else if(soal.length<=0){$('#txtsoalE').focus();alert('Soal masih kosong')}
	else if(TP.length<=0){$('#txtTPE').focus();alert('Skor tidak puas masih kosong')}
	else if(KP.length<=0){$('#txtKPE').focus();alert('Skor kurang puas masih kosong')}
	else if(P.length<=0){$('#txtPE').focus();alert('Skor puas masih kosong')}
	else if(SP.length<=0){$('#txtSPE').focus();alert('Skor sangat puas masih kosong')}
	else{
	$.ajax({
		type:"POST",
		url:'aksi/soal/aksi_edit.php',
		data:{idinstansi:idinstansi,idunsur:idunsur,idsoal:idsoal,soal:soal,TP:TP,KP:KP,P:P,SP:SP},
		dataType: "json",
		beforeSend: function(e) {
			$("#cmdsimpanSoalE").attr("disabled","disabled");
			$("#cmdbatalSoalE").attr("disabled","disabled");
		},		
		success:function(resp){
			if(resp.msg2 == 'ok'){
				setTimeout(function(){ $('#ModEditSoal').modal('hide');},1000);
				isiMasterSoal();
			}else if(resp.msg2 == 'err_val'){
				alert(resp.msg1);
				$("#cmdsimpanSoalE").removeAttr("disabled");
				$("#cmdbatalSoalE").removeAttr("disabled");								
			}else {
				alert('Ada sedikit masalah, silakan coba lagi.');
				$("#cmdsimpanSoalE").removeAttr("disabled");
				$("#cmdbatalSoalE").removeAttr("disabled");	
			}
		},
		error: function() {
			alert('Koneksi bermasalah periksa internet');
			$("#cmdsimpanSoalE").removeAttr("disabled");
			$("#cmdbatalSoalE").removeAttr("disabled");
			$(".modal-body").css("opacity", "");},
	});	
	}; 	
});	
</script>	