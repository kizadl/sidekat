$(document).ready(function () {
  document.body.style.cursor = "default";

  $("#cmdLogin").removeAttr("disabled");
  $("#txtusername").val("");
  $("#txtpassword").val("");

  ambilInovasiSekolah();
  IsiKomentar();

  $("#lblhalaman").val("dashboard");
  $("#loading").fadeOut("slow");
});

window.scrollTo({
  top: 0,
  behavior: 'smooth'
});

$("#brand-logo").on("click", function () {
  $("html, body").animate({
    scrollTop: $("#top").offset().top,
  },
    500
  );
});

$("#navbarDropdownLogin").on("click", function () {
  $("#txtusername").val("");
  $("#txtpassword").val("");
  $("#txtusername").focus();
});

$("#cmdLogin").click(function () {
  $("#loginFrm").submit(function (e) {
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
      beforeSend: function (e) {
        $("#cmdLogin").attr("disabled", "disabled");
        document.body.style.cursor = "wait";
      },
      success: function (resp) {
        document.body.style.cursor = "default";
        $("#cmdLogin").removeAttr("disabled");
        $("#loginMsg").html(resp);
      },
      error: function () {
        alert('Koneksi bermasalah periksa internet');
        document.body.style.cursor = "default";
        $("#cmdLogin").removeAttr("disabled");
      },
    });
  }
});

function ambilInovasiSekolah() {
  $.ajax({
    type: "POST",
    url: "web/aksi/isi_area_inovasi_sekolah.php",
    data: {},
    dataType: 'json',
    beforeSend: function (e) {
      $("#loading").fadeIn();
      document.body.style.cursor = "wait";
      $("#area-inovasi-sekolah").html("")
    },
    success: function (data) {
      document.body.style.cursor = "default";
      $("#loading").fadeOut("slow");
      //$('#area-inovasi-sekolah').remove();
      var html = "";
      var i;
      for (i = 0; i < data.length; i++) {
        // html +=
        $('#area-inovasi-sekolah').append(
          '<article class="col-md-6 col-xxl-4">' +
          '<div class="card h-100 overflow-hidden">' +
          '<div class="card-body p-0 d-flex flex-column justify-content-between">' +
          '<div>' +
          '<div class="hoverbox text-center"><a class="text-decoration-none" href="./assets/video/beach.mp4" data-gallery="attachment-bg"><img class="w-100 h-100 fit-cover" src="./assets/img/elearning/courses/course2.png" alt="" /></a>' +
          '<div class="hoverbox-content flex-center pe-none bg-holder overlay overlay-2"><img class="z-index-1" src="./assets/img/icons/play.svg" width="60" alt="" /></div>' +
          '</div>' +
          '<div class="p-3">' +
          '<h5 class="fs-0 mb-0"><a class="text-dark fs--1" href="#">' + data[i].nmsekolah + '</a></h5>' +
          '<p class="mt-1 mb-0 fs--1 text-800">' + data[i].judul + '</p>' +
          '</div>' +
          '</div>' +
          '</div>' +
          '</div>' +
          '</article>');
      }//$('#area-inovasi-sekolah').refresh();
    },
    error: function () {
      $("#loading").fadeOut("slow");
      document.body.style.cursor = "default";
    },
  });
}

$("#cmdKlinikDapo").on("click", function () {
	$.ajax({
		type: "POST",
		url: "web/aksi/klinik-dapo/tampilkan-detail-klinik.php",
		data: { },
		success: function (resp) {
			$("#isianModTambahDataLarge").html(resp);
			$("#isianModTambahDataLarge").fadeIn(1000);
			$("#modTambahDataLarge").modal({ backdrop: 'static', keyboard: false })
			$("#modTambahDataLarge").modal('show');
		},
		error: function () { alert('Koneksi bermasalah periksa internet'); },
	});
});
