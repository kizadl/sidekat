<?php
error_reporting(0);
require_once '../../../services/config.php';
$dbconn = mysqli_connect($dbhost,$dbuser,$dbpass,$dbname)or die('Could not connect: '); 
$idpendidikan = trim($_POST['idpendidikan']);

$sqltps = ("SELECT pendidikan FROM ikm_m_pendidikan WHERE id_pendidikan='".$idpendidikan."'");
$restps = mysqli_query($dbconn,$sqltps);$sm= mysqli_fetch_assoc($restps);
$pendidikan = $sm['pendidikan'];
mysqli_free_result($restps);mysqli_close($dbconn);
?>         	
			
			<div class="modal-header">			  
			  <h4 class="modal-title">Edit Data Pendidikan</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">

                <div class="callout callout-info">
                  <p>Lengkapi dan isi data <b>Pendidikan</b> dibawah ini dengan benar</p>
                </div>
				
				<input type="text" class="form-control form-control-sm" id="txtidpendidikanE" value="<?php echo $idpendidikan?>" disabled style="display:none">
				
				<div class="form-group row">
					<label for="txtnmpendidikanE" class="col-sm-3 col-form-label">Pendidikan</label>
					<div class="col-sm-9">
						<input type="text" class="form-control form-control-sm" id="txtnmpendidikanE" value="<?php echo $pendidikan?>" maxlength="35" autocomplete="off" style="font-size:12px;">
					</div>
				</div>	
				
            </div>
            <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-danger btn-sm" id="cmdbatalPendidikanE" data-dismiss="modal">&nbsp;Batalkan&nbsp;</button>
              <button type="button" class="btn btn-primary btn-sm" id="cmdsimpanPendidikaniE">&nbsp;Simpan data&nbsp;</button>
            </div>

<script type="text/javascript" charset="utf-8">
$("#cmdsimpanPendidikaniE").click(function(){
	var idpendidikan = $('#txtidpendidikanE').val();
	var pendidikan = $('#txtnmpendidikanE').val();
				
	if(pendidikan.length<=0){$('#txtnmpendidikanE').focus();alert('Jenjang pendidikan masih kosong')}
	else{
	$.ajax({
		type:"POST",
		url:'aksi/pendidikan/aksi_edit.php',
		data:{idpendidikan:idpendidikan,pendidikan:pendidikan},
		dataType: "json",
		beforeSend: function(e) {
			$("#cmdsimpanPendidikaniE").attr("disabled","disabled");
			$("#cmdbatalPendidikanE").attr("disabled","disabled");
		},		
		success:function(resp){
			if(resp.msg2 == 'ok'){
				setTimeout(function(){ $('#ModEditPendidikan').modal('hide');},1000);
				isiMasterPendidikan();
			}else if(resp.msg2 == 'err_val'){
				alert(resp.msg1);
				$("#cmdsimpanPendidikaniE").removeAttr("disabled");
				$("#cmdbatalPendidikanE").removeAttr("disabled");								
			}else {
				alert('Ada sedikit masalah, silakan coba lagi.');
				$("#cmdsimpanPendidikaniE").removeAttr("disabled");
				$("#cmdbatalPendidikanE").removeAttr("disabled");	
			}
		},
		error: function() {
			alert('Koneksi bermasalah periksa internet');
			$("#cmdsimpanPendidikaniE").removeAttr("disabled");
			$("#cmdbatalPendidikanE").removeAttr("disabled");
			$(".modal-body").css("opacity", "");},
	});	
	}; 	
});	
</script>	