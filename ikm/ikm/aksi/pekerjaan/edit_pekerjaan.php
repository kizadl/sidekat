<?php
error_reporting(0);
require_once '../../../services/config.php';
$dbconn = mysqli_connect($dbhost,$dbuser,$dbpass,$dbname)or die('Could not connect: '); 
$idpekerjaan = trim($_POST['idpekerjaan']);

$sqltps = ("SELECT pekerjaan FROM ikm_m_pekerjaan WHERE id_pekerjaan='".$idpekerjaan."'");
$restps = mysqli_query($dbconn,$sqltps);$sm= mysqli_fetch_assoc($restps);
$pekerjaan = $sm['pekerjaan'];
mysqli_free_result($restps);mysqli_close($dbconn);
?>         	
			
			<div class="modal-header">			  
			  <h4 class="modal-title">Edit Data Pekerjaan</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">

                <div class="callout callout-info">
                  <p>Lengkapi dan isi data <b>Pekerjaan</b> dibawah ini dengan benar</p>
                </div>
				
				<input type="text" class="form-control form-control-sm" id="txtidpekerjaanE" value="<?php echo $idpekerjaan?>" disabled style="display:none">
				
				<div class="form-group row">
					<label for="txtnmpekerjaanE" class="col-sm-3 col-form-label">Pekerjaan</label>
					<div class="col-sm-9">
						<input type="text" class="form-control form-control-sm" id="txtnmpekerjaanE" value="<?php echo $pekerjaan?>" maxlength="35" autocomplete="off" style="font-size:12px;">
					</div>
				</div>	
				
            </div>
            <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-danger btn-sm" id="cmdbatalPekerjaanE" data-dismiss="modal">&nbsp;Batalkan&nbsp;</button>
              <button type="button" class="btn btn-primary btn-sm" id="cmdsimpanPekerjaanE">&nbsp;Simpan data&nbsp;</button>
            </div>

<script type="text/javascript" charset="utf-8">
$("#cmdsimpanPekerjaanE").click(function(){
	var idpekerjaan = $('#txtidpekerjaanE').val();
	var pekerjaan = $('#txtnmpekerjaanE').val();
				
	if(pekerjaan.length<=0){$('#txtnmpekerjaanE').focus();alert('Pekerjaan masih kosong')}
	else{
	$.ajax({
		type:"POST",
		url:'aksi/pekerjaan/aksi_edit.php',
		data:{idpekerjaan:idpekerjaan,pekerjaan:pekerjaan},
		dataType: "json",
		beforeSend: function(e) {
			$("#cmdsimpanPekerjaanE").attr("disabled","disabled");
			$("#cmdbatalPekerjaanE").attr("disabled","disabled");
		},		
		success:function(resp){
			if(resp.msg2 == 'ok'){
				setTimeout(function(){ $('#ModEditPekerjaan').modal('hide');},1000);
				isiMasterPekerjaan();
			}else if(resp.msg2 == 'err_val'){
				alert(resp.msg1);
				$("#cmdsimpanPekerjaanE").removeAttr("disabled");
				$("#cmdbatalPekerjaanE").removeAttr("disabled");								
			}else {
				alert('Ada sedikit masalah, silakan coba lagi.');
				$("#cmdsimpanPekerjaanE").removeAttr("disabled");
				$("#cmdbatalPekerjaanE").removeAttr("disabled");	
			}
		},
		error: function() {
			alert('Koneksi bermasalah periksa internet');
			$("#cmdsimpanPekerjaanE").removeAttr("disabled");
			$("#cmdbatalPekerjaanE").removeAttr("disabled");
			$(".modal-body").css("opacity", "");},
	});	
	}; 	
});	
</script>	