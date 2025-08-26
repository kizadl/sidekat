$(document).ready(function() {
  document.body.style.cursor = "default";

  $("#cmdLogin").removeAttr("disabled");
  $("#txtusername").val("");
  $("#txtpassword").val("");

  var nmwilayah = "Kabupaten Jember";
  $(".labelkopmeta").html(nmwilayah);
  
  IsiKomentar();

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

$('.btnTampilkanGalleri').on('click', function () {
	var idkegiatan = $(this).data('idkegiatan');var nmsekolah = $(this).data('nmsekolah');
	$.ajax({
		type: "POST",
		url: "web/aksi/kegiatan-sekolah/tampilkan-foto-kegiatan.php",
		data: { idkegiatan: idkegiatan, nmsekolah:nmsekolah},
		success: function (resp) {
			$("#isianmodFaqExtraLarge").html(resp);
			$("#isianmodFaqExtraLarge").fadeIn(1000);
			//$("#modTambahDataLarge").modal({ backdrop: 'static', keyboard: false })
			$("#modFaqExtraLarge").modal('show');
		},
		error: function () { alert('Koneksi bermasalah periksa internet'); },
	});
});
