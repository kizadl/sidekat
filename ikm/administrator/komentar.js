$('#lv_komentar').on('click', function () {
  $.ajax({
    type: "POST",
    url: "aksi/komentar/semua-komentar.php",
    data: {},
    success: function (resp) {
      $("#isianmodKomentarXLargeBebas").html(resp);
      $("#isianmodKomentarXLargeBebas").fadeIn(1000);
      $("#modKomentarXLargeBebas").modal('show');
    },
    error: function () { alert('Koneksi bermasalah periksa internet'); },
  });
});
