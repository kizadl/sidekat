$('.cmdTulisKomentar').on('click', function () {
  $.ajax({
    type: "POST",
    url: "web/aksi/komentar/tambah-komentar.php",
    data: {},
    success: function (resp) {
      $("#isianmodBebasSmall").html(resp);
      $("#isianmodBebasSmall").fadeIn(1000);
      $("#modBebasSmall").modal('show');
    },
    error: function () { alert('Koneksi bermasalah periksa internet'); },
  });
});

$('.cmdSemuaKomentar').on('click', function () {
  $.ajax({
    type: "POST",
    url: "web/aksi/komentar/semua-komentar.php",
    data: {},
    success: function (resp) {
      $("#isianmodBebasLarge").html(resp);
      $("#isianmodBebasLarge").fadeIn(1000);
      $("#modBebasLarge").modal('show');
    },
    error: function () { alert('Koneksi bermasalah periksa internet'); },
  });
});

function IsiKomentar() {
  $('#area-komentar').html("");
  $.ajax({
    type: "POST",
    url: "web/aksi/isi_area_komentar.php",
    beforeSend: function (e) {
      document.body.style.cursor = "wait";
    },
    success: function (data) {
      document.body.style.cursor = "default";
      $('#area-komentar').html(data);
    },
    error: function () {
      document.body.style.cursor = "default";
    },
  });
}

$('#area-komentar').on('click','.cmdBalasKomentar',function(){
	var idkomentar = $(this).data('idkomentar');
	$.ajax({
	  type:"POST",		
	  url: "web/aksi/komentar/balas-komentar.php",
	  data:{idkomentar:idkomentar},
	  success:function(resp){
      $("#isianmodBebasSmall").html(resp);
      $("#isianmodBebasSmall").fadeIn(1000);
      $("#modBebasSmall").modal('show');
	  },
	  error: function() {alert('Koneksi bermasalah periksa internet');},
	});
});