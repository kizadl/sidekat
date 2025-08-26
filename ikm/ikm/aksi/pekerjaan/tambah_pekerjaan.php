			
			<div class="modal-header">			  
			  <h4 class="modal-title">Tambah Data Pekerjaan</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">

                 <div class="callout callout-info">
                  <p>Lengkapi dan isi data <b>Pekerjaan</b> dibawah ini dengan benar</p>
                </div>

				<div class="form-group row">
					<label for="txtnmpekerjaan" class="col-sm-3 col-form-label">Pekerjaan</label>
					<div class="col-sm-9">
						<input type="text" class="form-control form-control-sm" id="txtnmpekerjaan" value="" maxlength="35" autocomplete="off" style="font-size:12px;">
					</div>
				</div>

            </div>
            <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-danger btn-sm" id="cmdbatalPekerjaan" data-dismiss="modal">&nbsp;Batalkan&nbsp;</button>
              <button type="button" class="btn btn-primary btn-sm" id="cmdsimpanPekerjaan">&nbsp;Simpan data&nbsp;</button>
            </div>

<script type="text/javascript" charset="utf-8">
$("#cmdsimpanPekerjaan").click(function(){
	var idinstansi = $('#lblidinstansi').val();
	var pekerjaan = $('#txtnmpekerjaan').val();
	
	if(idinstansi.length<=0){alert('Instansi tidak terdeteksi')}	
	else if(pekerjaan.length<=0){$('#txtnmpekerjaan').focus();alert('Pekerjaan masih kosong')}
	else{
	$.ajax({
		type:"POST",
		url:'aksi/pekerjaan/aksi_tambah.php',
		data:{idinstansi:idinstansi,pekerjaan:pekerjaan},
		dataType: "json",
		beforeSend: function(e) {
			$("#cmdsimpanPekerjaan").attr("disabled","disabled");
			$("#cmdbatalPekerjaan").attr("disabled","disabled");
		},		
		success:function(resp){
			if(resp.msg2 == 'ok'){
				setTimeout(function(){ $('#ModTambahPekerjaan').modal('hide');},1000);
				isiMasterPekerjaan();
			}else if(resp.msg2 == 'err_val'){
				alert(resp.msg1);
				$("#cmdsimpanPekerjaan").removeAttr("disabled");
				$("#cmdbatalPekerjaan").removeAttr("disabled");								
			}else {
				alert('Ada sedikit masalah, silakan coba lagi.');
				$("#cmdsimpanPekerjaan").removeAttr("disabled");
				$("#cmdbatalPekerjaan").removeAttr("disabled");	
			}
		},
		error: function() {
			alert('Koneksi bermasalah periksa internet');
			$("#cmdsimpanPekerjaan").removeAttr("disabled");
			$("#cmdbatalPekerjaan").removeAttr("disabled");
			$(".modal-body").css("opacity", "");},
	});	
	}; 	
});	
</script>	