		
			<div class="modal-header px-4 position-relative modal-shape-header bg-shape">			  
				<div class="position-relative z-index-1 light">
                  <h5 class="mb-0 text-white">Tambah Mata Pelajaran</h5>
                  <p class="fs--1 mb-0 text-white">Silahkan menambahkan data mata pelajaran</p>
                </div>
                <button class="btn-close btn-close-white position-absolute top-0 end-0 mt-2 me-2" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body py-3 px-4">
				<div class="mb-3">
                    <label class="form-label" for="txtkodemapel">Kode Mata Pelajaran</label>
                    <input class="form-control" type="text" id="txtkodemapel" maxlength="25" autocomplete="off" style="font-size:13px;"/>
                </div>
				<div class="mb-3">
                    <label class="form-label" for="txtnmmapel">Mata Pelajaran</label>
                    <input class="form-control" type="text" id="txtnmmapel" maxlength="100" autocomplete="off" style="font-size:13px;"/>
                </div>
				<div class="mb-3">
                    <label class="form-label" for="txtjam">Jumlah Jam</label>
                    <input class="form-control" type="number" id="txtjam" autocomplete="off" style="font-size:13px;"/>
                </div>
				<div class="mb-3">
                    <label class="form-label" for="cbobentukpendidikan">Bentuk Pendidikan</label>
                    <select class="form-select js-choice" size="1" name="cbobentukpendidikan" id="cbobentukpendidikan" data-options='{"removeItemButton":true,"placeholder":true}' style="font-size:14px;">
						<option value="">-</option>
						<option value="SD">SD</option>
						<option value="SMP">SMP</option>
					</select>
				</div>
            </div>
			<div class="modal-footer">
				<button class="btn btn-sm btn-falcon-danger" type="button" data-bs-dismiss="modal">Batalkan</button>
				<button class="btn btn-sm btn-falcon-primary" type="button" id="cmdSimpanJamMapel">Simpan data</button>
			</div>

<script type="text/javascript" charset="utf-8">
$(document).ready(function(){		
	$("#txtkodemapel").val("");$("#txtnmmapel").val("");$("#txtjam").val("");
	$("#cbobentukpendidikan").val("");
});

$("#cmdSimpanJamMapel").click(function(){
	var kode = $('#txtkodemapel').val();
	var nmmapel = $('#txtnmmapel').val();
	var jam = $('#txtjam').val();
	var bentuk = $('#cbobentukpendidikan').val();
	
	if(kode.length<=0){$('#txtkodemapel').focus();alert('Kode mata pelajaran masih kosong')}
	else if(nmmapel.length<=0){$('#txtnmmapel').focus();alert('Nama mata pelajaran masih kosong')}
	else if(jam.length<=0){$('#txtjam').focus();alert('Jumlah Jam masih kosong')}
	else if(bentuk.length<=0){$('#cbobentukpendidikan').focus();alert('Bentuk pendidikan masih kosong')}
	else{
	$.ajax({
		type:"POST",
		url:'aksi/jam-mengajar/aksi_tambah.php',
		data:{kode:kode,nmmapel:nmmapel,jam:jam,bentuk:bentuk},
		dataType: "json",
		beforeSend: function(e) {
			$("#cmdSimpanJamMapel").attr("disabled","disabled");
		},		
		success:function(resp){
			if(resp.msg2 == 'ok'){
				setTimeout(function(){ $('#modTambahData').modal('hide');},1000);
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