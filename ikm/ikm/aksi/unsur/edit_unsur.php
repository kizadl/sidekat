<?php
error_reporting(0);
require_once '../../../services/config.php';
$dbconn = mysqli_connect($dbhost,$dbuser,$dbpass,$dbname)or die('Could not connect: '); 
$idunsur = trim($_POST['idunsur']);

$sqltps = ("SELECT unsur FROM ikm_m_unsur WHERE id_unsur='".$idunsur."'");
$restps = mysqli_query($dbconn,$sqltps);$sm= mysqli_fetch_assoc($restps);
$unsur = $sm['unsur'];
mysqli_free_result($restps);mysqli_close($dbconn);
?>         	
			
			<div class="modal-header">			  
			  <h4 class="modal-title">Edit Data Unsur Penilaian</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">

                <div class="callout callout-info">
                  <p>Lengkapi dan isi data <b>Unsur Penilaian</b> dibawah ini dengan benar</p>
                </div>
				
				<input type="text" class="form-control form-control-sm" id="txtidunsurE" value="<?php echo $idunsur?>" disabled style="display:none">
				
				<div class="form-group row">
					<label for="txtnmunsurE" class="col-sm-3 col-form-label">Unsur Penilaian</label>
					<div class="col-sm-9">
						<input type="text" class="form-control form-control-sm" id="txtnmunsurE" value="<?php echo $unsur?>" maxlength="35" autocomplete="off" style="font-size:12px;">
					</div>
				</div>	
				
            </div>
            <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-danger btn-sm" id="cmdbatalUnsurE" data-dismiss="modal">&nbsp;Batalkan&nbsp;</button>
              <button type="button" class="btn btn-primary btn-sm" id="cmdsimpanUnsurE">&nbsp;Simpan data&nbsp;</button>
            </div>

<script type="text/javascript" charset="utf-8">
$("#cmdsimpanUnsurE").click(function(){
	var idunsur = $('#txtidunsurE').val();
	var unsur = $('#txtnmunsurE').val();
				
	if(unsur.length<=0){$('#txtnmunsurE').focus();alert('Unsur penilaian masih kosong')}
	else{
	$.ajax({
		type:"POST",
		url:'aksi/unsur/aksi_edit.php',
		data:{idunsur:idunsur,unsur:unsur},
		dataType: "json",
		beforeSend: function(e) {
			$("#cmdsimpanUnsurE").attr("disabled","disabled");
			$("#cmdbatalUnsurE").attr("disabled","disabled");
		},		
		success:function(resp){
			if(resp.msg2 == 'ok'){
				setTimeout(function(){ $('#ModEditUnsur').modal('hide');},1000);
				isiMasterUnsur();
			}else if(resp.msg2 == 'err_val'){
				alert(resp.msg1);
				$("#cmdsimpanUnsurE").removeAttr("disabled");
				$("#cmdbatalUnsurE").removeAttr("disabled");								
			}else {
				alert('Ada sedikit masalah, silakan coba lagi.');
				$("#cmdsimpanUnsurE").removeAttr("disabled");
				$("#cmdbatalUnsurE").removeAttr("disabled");	
			}
		},
		error: function() {
			alert('Koneksi bermasalah periksa internet');
			$("#cmdsimpanUnsurE").removeAttr("disabled");
			$("#cmdbatalUnsurE").removeAttr("disabled");
			$(".modal-body").css("opacity", "");},
	});	
	}; 	
});	
</script>	