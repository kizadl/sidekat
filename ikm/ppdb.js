$(document).ready(function() {
  document.body.style.cursor = "default";

  $("#cmdLogin").removeAttr("disabled");
  $("#txtusername").val("");
  $("#txtpassword").val("");

  $("#lblhalaman").val("dashboard");
  $("#loading").fadeOut("slow");
});

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

$('#cmdPengaduan').on('click',function(){
	$.ajax({
	  type:"POST",		
	  url :"web/aksi/pengaduan/tambah-pengaduan.php",	
	  data:{},
	  success:function(resp){
		$("#isianModTambahDataLarge").html(resp);
		$("#isianModTambahDataLarge").fadeIn(1000);
		$("#modTambahDataLarge").modal({backdrop: 'static', keyboard: false}) 
		$("#modTambahDataLarge").modal('show');
	  },
	  error: function() {alert('Koneksi bermasalah periksa internet');},
	});
});

$('#txtcaripengaduan').on('keydown',function (e) {
  if (e.keyCode == 13) {
    var kata = $("#txtcaripengaduan").val();
    if (kata.length >= 2) {
      $.ajax({
        type: 'POST',
        url: 'web/aksi/pengaduan/cari_pengaduan.php',
        data: {
          kata: kata
        },
        dataType: 'json',
        beforeSend: function (e) {
          $("#loading").fadeIn();
          document.body.style.cursor = "wait";
        },
        success: function (resp) {
          $("#loading").fadeOut("slow");
          document.body.style.cursor = "default";
          if (resp.length >= 1) {
            pencarianLokasi();
          } else if (resp.length <= 0) {
            alert("Data tidak diketemukan");
            $("#txtcaripengaduan").val("");
            $("#txtcaripengaduan").focus();
          } else {
            alert("Data tidak diketemukan");
            $("#txtcaripengaduan").val("");
            $("#txtcaripengaduan").focus();
          }
        },
        error: function () {
          $("#loading").fadeOut("slow");
          document.body.style.cursor = "default";
          $("#txtcaripengaduan").val("");
          $("#txtcaripengaduan").focus();
          alert("Koneksi ke server terputus");
        },
      });

    } else {
      alert("Kata kunci pencarian kosong")
    }
  }
  
});

function pencarianLokasi() {
  var kata = $("#txtcaripengaduan").val();
  $.ajax({
    type: 'POST',
    url: 'web/aksi/pengaduan/pencarian-pengaduan.php',
    data: {
      kata: kata
    },
    success: function (resp) {
      $("#loading").fadeOut("slow");
      $("#isianModTambahDataLarge").html(resp);
      $("#isianModTambahDataLarge").fadeIn(1000);
      $("#modTambahDataLarge").modal('show');
      //$("#txtcaripengaduan").val("");
    },
  });
}
