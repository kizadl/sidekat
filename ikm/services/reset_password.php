		
			<div class="modal-header px-4 position-relative modal-shape-header bg-shape">			  
				<div class="position-relative z-index-1 light">
                  <h5 class="mb-0 text-white">Reset Password</h5>
                  <p class="fs--1 mb-0 text-white">Silahkan mengubah password Anda</p>
                </div>
                <button class="btn-close btn-close-white position-absolute top-0 end-0 mt-2 me-2" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body py-3 px-4">
				<div class="mb-3">
                    <label class="form-label" for="txtpasslamaReset">Password Lama</label>
                    <input class="form-control" type="password" id="txtpasslamaReset" maxlength="50" autocomplete="off" style="font-size:13px;"/>
                </div>
				<hr/>
				<div class="mb-3">
                    <label class="form-label" for="txtPassBaruReset">Password Baru</label>
                    <input class="form-control" type="password" id="txtPassBaruReset" maxlength="50" autocomplete="off" style="font-size:13px;"/>
                </div>
				<div class="mb-3">
                    <label class="form-label" for="txtConfirPassReset">Konfirmasi Password Baru</label>
                    <input class="form-control" type="password" id="txtConfirPassReset" maxlength="50" autocomplete="off" style="font-size:13px;"/>
                </div>
            </div>
			<div class="modal-footer">
				<button class="btn btn-sm btn-falcon-danger" type="button" data-bs-dismiss="modal">Batalkan</button>
				<button class="btn btn-sm btn-falcon-primary" type="button" id="cmdSimpanResetPassword">Reset password</button>
			</div>

<script type="text/javascript" charset="utf-8">
$(document).ready(function(){		
	$("#txtnmoperator").val("");
});

$("#cmdSimpanResetPassword").click(function(){
	var idoperator = $('#lbleditor').val();
	var passlama = $('#txtpasslamaReset').val();
	var passbaru = $('#txtPassBaruReset').val();
	var konfirmasi = $('#txtConfirPassReset').val();

	if(passlama.length<=0){$('#txtpasslamaReset').focus();alert('Password lama masih kosong')}
	else if(passbaru.length<=6){$('#txtPassBaruReset').focus();alert('Password baru kurang dari 7 digit angka / huruf')}
	else if(konfirmasi.length<=6){$('#txtConfirPassReset').focus();alert('Konfirmasi password baru kurang dari 7 digit angka / huruf')}
	else if(passbaru != konfirmasi){$('#txtConfirPassReset').focus();alert('Konfirmasi password tidak sama')}
	else{
	$.ajax({
		type:"POST",
		url:'../services/aksi_reset_password.php',
		data:{idoperator:idoperator,passlama:passlama,passbaru:passbaru},
		dataType: "json",
		beforeSend: function(e) {
			$("#cmdSimpanResetPassword").attr("disabled","disabled");
		},		
		success:function(data){
			$("#loading").fadeOut("slow");
              document.body.style.cursor = "default";	
              $("#cmdSimpanResetPassword").removeAttr("disabled");		             
              var i;
              for(i=0; i<data.length; i++){

                if (data[i].jumlah >= 1 && data[i].ketpassword == 'Y'){
                  alert("selamat, reset password baru sukses")
                  setTimeout(function(){ $('#modTambahData').modal('hide'); },1000);
                } else if (data[i].jumlah >= 1 && data[i].ketpassword == 'N'){
                  alert("Maaf, password lama Anda salah!")
                } else if (data[i].jumlah <= 0){
                  alert("Maaf, username tidak diketemukan!")
                }               
              }             
		},
		error: function() {
			alert('Koneksi bermasalah periksa internet');
			$("#cmdSimpanResetPassword").removeAttr("disabled");
			$(".modal-body").css("opacity", "");},
	});	
	}; 	
});	
</script>	