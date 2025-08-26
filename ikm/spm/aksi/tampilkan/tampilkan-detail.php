<?php
error_reporting(0);
include '../../../services/config.php';
$dbconn = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname) or die('Could not connect: ');
$idsekolah = trim($_POST['idsekolah']);
$keterangan = trim($_POST['keterangan']);

$sqlx = ("SELECT npsn,nama_sekolah,bentuk_pendidikan,status_sekolah,(ptk_l+ptk_p) AS jumPTK,(ptk_guru_l+ptk_guru_p) AS jumPTKGuru,
  rombel_1,rombel_2,rombel_3,rombel_4,rombel_5,rombel_6,rombel_7,rombel_8,rombel_9
  FROM spm_sekolah WHERE id_sekolah='" . $idsekolah . "'");
$result = mysqli_query($dbconn, $sqlx);
$sm = mysqli_fetch_assoc($result);

$nmsekolah = $sm['nama_sekolah'];
$npsn = $sm['npsn'];
$bentukpendidikan = $sm['bentuk_pendidikan'];
$guru = $sm['jumPTKGuru'];
$ptk = $sm['jumPTK'];
$statussekolah = $sm['status_sekolah'];

$rombel1 = $sm['rombel_1'];
$rombel2 = $sm['rombel_2'];
$rombel3 = $sm['rombel_3'];
$rombel4 = $sm['rombel_4'];
$rombel5 = $sm['rombel_5'];
$rombel6 = $sm['rombel_6'];
$rombel7 = $sm['rombel_7'];
$rombel8 = $sm['rombel_8'];
$rombel9 = $sm['rombel_9'];

$jmlrombel = $rombel1 + $rombel2 + $rombel3 + $rombel4 + $rombel5 + $rombel6 + $rombel7 + $rombel8 + $rombel9;

mysqli_free_result($result);
mysqli_close($dbconn);
?>
<!------------------MODAL PENCARIAN ------------------>
<div class="modal-header px-4 position-relative modal-shape-header bg-shape">
  <div class="position-relative z-index-1 light">
    <h5 class="mb-0 text-white">Data Pembelajaran</h5>
    <p class="fs--1 mb-0 text-white">Tabel detail data pembelajaran</p>
  </div>
  <button class="btn-close btn-close-white position-absolute top-0 end-0 mt-2 me-2" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<div class="modal-body py-3">

  <input class="form-control" type="text" id="txtidsekolahdetpembelajaran" value="<?php echo $idsekolah; ?>" style="display:none;" />
  <input class="form-control" type="text" id="txtketeranganpembelajaran" value="<?php echo $keterangan; ?>" style="display:none;" />

  <div class="col-xxl-12 col-lg-12">
    <div class="card h-100 mb-3">
      <div class="card-body py-0">
        <table class="table table-borderless fs--1 mt-3 mb-0">
          <tr class="border-bottom">
            <th class="ps-0 pt-0"><?php echo $nmsekolah ?><br />NPSN : <?php echo $npsn ?>
            </th>
            <th class="pe-0 text-end pt-0"></th>
          </tr>
          <tr class="border-bottom">
            <th class="ps-0">Bentuk Pendidikan / Status Sekolah</th>
            <th class="pe-0 text-end"><?php echo $bentukpendidikan ?> / <?php echo $statussekolah ?></th>
          </tr>
          <tr class="border-bottom">
            <th class="ps-0">Jumlah Guru / PTK</th>
            <th class="pe-0 text-end"><?php echo $guru ?> / <?php echo $ptk ?></th>
          </tr>
          <tr>
            <th class="ps-0">Jumlah Rombel</th>
            <th class="pe-0 text-end"><?php echo $jmlrombel ?></th>
          </tr>
        </table>
      </div>
    </div>

    <div class="card h-100">
      <div class="card-header">
        <div class="row flex-between-center g-0">
          <div class="col-auto">
            <h6 class="fs--1 mb-0">Data Pembelajaran</h6>
          </div>

          <div class="col-6 col-sm-auto ms-auto text-end ps-0">
            <div id="table-purchases-replace-element">
              <button class="btn btn-falcon-default btn-sm me-1" type="button" id="cmdRefreshDetPembelajaran"><span class="d-none d-sm-inline-block ms-1">Refresh</span></button>
              <button class="btn btn-falcon-default btn-sm" type="button" id="cmdExcelDetPembelajaran"><span class="d-none d-sm-inline-block ms-1">Eksport</span></button>
            </div>
          </div>
        </div>
      </div>

      <div class="card-body bg-light px-3 py-3">
        <div class="table-responsive scrollbar">
          <table id="tabelDetailPembelajaran" class="table table-sm table-striped mb-0 fs--1 w-100">
            <thead class="bg-200">
              <tr>
                <th class="sort text-center">No.</th>
                <th class="sort text-center">Rombel</th>
                <th class="sort text-center">Nama Guru</th>
                <th class="sort text-center">Mata Pelajaran</th>
                <th class="sort text-center">Jam</th>
                <th class="sort text-center">Status Kurikulum</th>
              </tr>
            </thead>
            <tbody class="bg-white" id="isitabelDetailPembelajaran" />
          </table>
        </div>
      </div>

    </div>

  </div>
</div>

<script type="text/javascript" charset="utf-8">
  $(document).ready(function() {
    setTimeout(function() {
      document.body.style.cursor = "default";
      isiPembelajaran()
      $("#loading").fadeOut("slow");
    }, 1000);

  });

  $("#cmdRefreshDetPembelajaran").click(function () {
	  isiPembelajaran();
  });

  $("#cmdExcelDetPembelajaran").on("click", function () {
    var idsekolah = $("#txtidsekolahdetpembelajaran").val();
    var keterangan = $("#txtketeranganpembelajaran").val();
    window.open("pembelajaran-" + idsekolah + ".html", '_self')
  });

  function isiPembelajaran() {
    var idsekolah = $("#txtidsekolahdetpembelajaran").val();
    var ketsekolah = $("#txtketeranganpembelajaran").val();
    $.ajax({
      type: "POST",
      url: "aksi/tampilkan/isi_tabel_pembelajaran.php",
      data: {
        ketsekolah: ketsekolah,
        idsekolah: idsekolah
      },
      dataType: 'json',
      beforeSend: function(e) {
        $("#loading").fadeIn();
        document.body.style.cursor = "wait";
      },
      success: function(data) {
        document.body.style.cursor = "default";
        $('#tabelDetailPembelajaran').dataTable().fnDestroy();
        var html = '';
        var i;
        for (i = 0; i < data.length; i++) {

          html +=
            '<tr class="btn-reveal-trigger">' +
            '<td class="align-middle text-center" width="4%">' + data[i].no + '</td>' +
            '<td class="align-middle" width="10%">' + data[i].tingkatpendidikan + '</td>' +
            '<td class="align-middle" width="26%">' + data[i].namaptk + '</td>' +
            '<td class="align-middle" width="30%">' + data[i].namamapel + '</td>' +
            '<td class="align-middle text-center" width="6%">' + data[i].jammengajar + '</td>' +
            '<td class="align-middle" width="34%">' + data[i].ketstatuskurikulum + '</td>' +
            '</tr>';
        }
        $('#isitabelDetailPembelajaran').html(html);
        $("#tabelDetailPembelajaran").dataTable({
          "paging": false,
          "lengthChange": false,
          "ordering": true,
          "info": false,
          "autoWidth": true,
          "responsive": false,
          "select": false,
          "scrollX": true,
          initComplete: function() {
            $(this.api().table().container()).find('input').parent().wrap('<form>').parent().attr('autocomplete', 'off');
          },
          "searching": true,
        });
        $("#loading").fadeOut("slow");

      },
      error: function() {
        $("#loading").fadeOut("slow");
        alert("Koneksi bermasalah periksa internet");
        document.body.style.cursor = "default";
      },
    });
  }

</script>