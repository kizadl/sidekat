		
			<div class="modal-header px-4 position-relative modal-shape-header bg-shape">			  
				<div class="position-relative z-index-1 light">
                  <h5 class="mb-0 text-white">Sinkron Data Dapodik SPM PTK</h5>
                  <p class="fs--1 mb-0 text-white">Update database SPM PTK dengan sinkronisasi data dapodik PTK </p>
                </div>
                <button class="btn-close btn-close-white position-absolute top-0 end-0 mt-2 me-2" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body py-3 px-4">
				<div class="mb-3">
					
					<p class="fs--1 text-600" id="lblketsinkronptk"></p>
                  <div class="progress mb-1 rounded-pill" style="height: 6px;">
                    <div class="progress-bar bg-progress-gradient progress-bar-striped rounded-pill" id="lblprogressbarptk" role="progressbar" style="width: 0%" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                  </div>
                  <p class="mb-0">
				  <button class="btn btn-success btn-sm mt-2" type="button" id="cmdSinkronPTK">Sinkron database </button>
				  </p>
                 
            	</div>

<script type="text/javascript" charset="utf-8">
$(document).ready(function(){		
	$("#lblketsinkronptk").html("Silahkan tekan tombol <strong>Sinkron Database</strong><br/>Untuk sinkronisasi database spm dengan data dapodik");
});

$("#cmdSinkronPTK").click(function(){
	$("#lblketsinkronptk").html("");
	$.ajax({
		type:'POST',
		url:'aksi/sinkron/aksi_sinkron_spm_ptk.php',
		dataType : 'json',
		beforeSend: function(e) {
			$("#lblketsinkronptk").html("<strong>Proses Tahap I</strong><br />Sinkronisasi data PTK");
			document.body.style.cursor = "wait";
			$("#cmdSinkronPTK").attr("disabled","disabled");
		},		
		success:function(data){
			document.body.style.cursor = "default";
			if(data.msg2 == 'OK'){
				$("#lblketsinkronptk").html("<strong>Proses Tahap II</strong><br/>Jumlah penambahan data "+data.msg1+" record<br />Sinkronisasi data detail rombongan belajar");
				move()
				sinkronDetailPTK();
			}else if(data.msg2 == 'ERR'){
				alert("Gagal! Server tidak merespon");
				$("#cmdSinkronPTK").removeAttr("disabled");							
			}else {
				alert('Ada sedikit masalah, silakan coba lagi.');
				$("#cmdSinkronPTK").removeAttr("disabled");
			}
		},
		error: function() {
			document.body.style.cursor = "default";
			alert('Koneksi bermasalah periksa internet (SPM PTK)');
			$("#cmdSinkronPTK").removeAttr("disabled");
			$(".modal-body").css("opacity", "");},
	});	
});

var i = 0;
function move() {
  if (i == 0) {
    i = 1;
    var elem = document.getElementById("lblprogressbarptk");
    var width = 1;
    var id = setInterval(frame, 20);
    function frame() {
      if (width >= 40) {
        clearInterval(id);
        i = 40;
		//setTimeout(function(){ $('#modTambahData').modal('hide');$("#ToastSukses").toast("show");},1000);
      } else {
        width++;
        elem.style.width = width + "%";
      }
    }
  }
}

var a = 60;
function move70() {
  if (a == 60) {
    a = 61;
    var elem = document.getElementById("lblprogressbarptk");
    var width = 1;
    var id = setInterval(frame, 30);
    function frame() {
      if (width >= 100) {
        clearInterval(id);
        a = 60;
		//setTimeout(function(){ $('#modTambahData').modal('hide');$("#ToastSukses").toast("show");},1000);
		
      } else {
        width++;
        elem.style.width = width + "%";
      }
    }
  }
}

function sinkronDetailPTK() {
	$.ajax({
		type:'POST',
		url:'aksi/sinkron/aksi_sinkron_spm_detail_ptk.php',
		dataType : 'json',
		beforeSend: function(e) {
			document.body.style.cursor = "wait";
			$("#cmdSinkronPTK").attr("disabled","disabled");
		},		
		success:function(data){
			document.body.style.cursor = "default";
			//alert("Jumlah record ditambahkan "+data.msg1+" record")
			move70();
			setTimeout(function(){ 
				$('#modTambahData').modal('hide');
				$("#ToastSukses").toast("show");
				window.location.reload();
			},1000);
		},
		error: function() {
			document.body.style.cursor = "default";
			alert('Koneksi bermasalah periksa internet (SPM Detail PTK)');
			$("#cmdSinkronPTK").removeAttr("disabled");
			$(".modal-body").css("opacity", "");},
	});	
}


</script>	