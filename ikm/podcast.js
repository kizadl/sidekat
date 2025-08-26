window.scrollTo({
  top: 0,
  behavior: 'smooth'
});

$("#brand-logo").on("click", function() {
  $("html, body").animate({
      scrollTop: $("#top").offset().top,
    },
    500
  );
});

$("#navbarDropdownLogin").on("click", function() {
  $("#txtusername").val("");
  $("#txtpassword").val("");
  $("#txtusername").focus();
});

function isiPodcast() {
  $.ajax({
    type: "POST",
    url: "web/aksi/isi_tabel_podcast.php",
    data: {},
    dataType: 'json',
    beforeSend: function (e) {
      $("#loading").fadeIn();
      document.body.style.cursor = "wait";
    },
    success: function (data) {
      $('#tabelmetadata').dataTable().fnDestroy();
      document.body.style.cursor = "default";
      var html = '';
      var i;
      for (i = 0; i < data.length; i++) {
      html +=
        '<tr class="btn-reveal-trigger">' +
          '<td class="align-middle text-center" width="3%">'+data[i].no+'</td>' +
          '<td class="align-middle" width="16%">'+data[i].hari+'<br/>'+data[i].tanggal+'</td>' +
          '<td class="align-middle" width="28%">' + data[i].judul + '</td>' +
          '<td class="align-middle" width="50%">' + data[i].isipodcast + '</td>' +
          '<td class="align-middle" width="3%">'+
            '<button class="btn btn-light icon-item rounded-3 fs--2 icon-item-sm me-2 btnViewPodcast" data-idpodcast="'+data[i].idpodcast+'" data-judul="'+data[i].judul+'"><span class="fas fa-video"></span></button> '+
          '</td>' +
        '</tr>';
      }
      $('#isitabelmetadata').html(html);
      $("#tabelmetadata").dataTable({
        "paging": true, "lengthChange": false, "ordering": true, "info": false, "autoWidth": false, "responsive": false, "select": false, "scrollX": false,
        initComplete: function () { $(this.api().table().container()).find('input').parent().wrap('<form>').parent().attr('autocomplete', 'off'); }, "searching": true,
      });
      $("#loading").fadeOut("slow");
    },
    error: function () {
      $("#loading").fadeOut("slow");
      alert("Koneksi bermasalah periksa internet");
      document.body.style.cursor = "default";
    },
  });
}


$('#isitabelmetadata').on('click','.btnViewPodcast',function(){
	var idpodcast = $(this).data('idpodcast');
	$.ajax({
	  type:"POST",		
	  url :"web/aksi/podcast/tampilkan-detail-podcast.php",	
	  data:{idpodcast:idpodcast},
	  success:function(resp){
		$("#isianModTambahDataLarge").html(resp);
		$("#isianModTambahDataLarge").fadeIn(1000);
		$("#modTambahDataLarge").modal({backdrop: 'static', keyboard: false}) 
		$("#modTambahDataLarge").modal('show');
	  },
	  error: function() {alert('Koneksi bermasalah periksa internet');},
	});
});

$("#cmdLogin").click(function() {
  $("#loginFrm").submit(function(e) {
    return false;
  });
  var name = $("#txtusername").val();
  var nameLength = name.length;
  var pw = $("#txtpassword").val();
  var pwLength = pw.length;
  if (nameLength == 0) {
    $("#txtusername").focus();
    alert("Maaf, username masih kosong");
  } else if (pwLength == 0) {
    $("#txtpassword").focus();
    alert("Maaf, password masih kosong");
  } else if (nameLength && pwLength >= 1) {
    $.ajax({
      type: "POST",
      url: "services/login_user.php",
      data: {
        checkUser: '',
        uid: name,
        pwrd: pw
      },
      beforeSend: function(e) {
        $("#cmdLogin").attr("disabled", "disabled");
        document.body.style.cursor = "wait";
      },
      success: function(resp) {
        document.body.style.cursor = "default";
        $("#cmdLogin").removeAttr("disabled");
        $("#loginMsg").html(resp);
      },
      error: function() {
        alert('Koneksi bermasalah periksa internet');
        document.body.style.cursor = "default";
        $("#cmdLogin").removeAttr("disabled");
      },
    });
  }
});
