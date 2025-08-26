<?php
error_reporting(0);
include '../../../services/config.php';
$dbconn = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname) or die('Could not connect: ');

$npsn = trim($_POST['npsn']);

$sqlx = ("SELECT id_sekolah,nama_sekolah,bentuk_pendidikan,status_sekolah,(ptk_l+ptk_p) AS jumPTK,(ptk_guru_l+ptk_guru_p) AS jumPTKGuru
  FROM spm_sekolah WHERE npsn='" . $npsn . "'");
$result = mysqli_query($dbconn, $sqlx);
$sm = mysqli_fetch_assoc($result);

$idsekolah = $sm['id_sekolah'];$mdidsekolah = md5($sm['id_sekolah']);
$nmsekolah = $sm['nama_sekolah'];
$bentukpendidikan = $sm['bentuk_pendidikan'];
$guru = $sm['jumPTKGuru'];
$ptt = $sm['jumPTK'] - $sm['jumPTKGuru'];
$statussekolah = $sm['status_sekolah'];

////////////////// status kepegawaian ////////////////////
$qrijmlpeg = ("SELECT COUNT(IF(status_kepegawaian='PNS',id,NULL)) AS jumPNS,
COUNT(IF(status_kepegawaian='CPNS',id,NULL)) AS jumCPNS,
COUNT(IF(status_kepegawaian='PNS Diperbantukan',id,NULL)) AS jumPNSBantu,
COUNT(IF(status_kepegawaian='PNS Depag',id,NULL)) AS jumPNSDepag,
COUNT(IF(status_kepegawaian='PPPK',id,NULL)) AS jumP3K,
COUNT(IF(status_kepegawaian='GTY/PTY',id,NULL)) AS jumGTY,
COUNT(IF(status_kepegawaian='Honor Daerah TK.II Kab/Kota',id,NULL)) AS jumHonor,
COUNT(IF(status_kepegawaian='Guru Honor Sekolah',id,NULL)) AS jumGuruHonor,
COUNT(IF(status_kepegawaian='Tenaga Honor Sekolah',id,NULL)) AS jumTenagaHonor,
COUNT(IF(status_kepegawaian='Honor Daerah TK.I Provinsi',id,NULL)) AS jumHonorDaerah,
COUNT(IF(status_kepegawaian='Lainnya',id,NULL)) AS jumLainnya,
COUNT(IF(status_kepegawaian='NON PNS',id,NULL)) AS jumNONPNS,
COUNT(IF(status_kepegawaian='Guru Pengganti',id,NULL)) AS jumPengganti
FROM spm_ptk WHERE id_sekolah='".$idsekolah."'");
$dbjumlahpeg = mysqli_query($dbconn, $qrijmlpeg);$d = mysqli_fetch_assoc($dbjumlahpeg);

$jumPNS = $d['jumPNS']+$d['jumCPNS']+$d['jumPNSBantu']+$d['jumPNSDepag'];
$jumPPPK = $d['jumP3K'];
$jumGTY = $d['jumGTY'];
$jumHonorer = $d['jumHonor']+$d['jumGuruHonor']+$d['jumTenagaHonor']+$d['jumHonorDaerah']+$d['jumLainnya']+$d['jumNONPNS']+$d['jumPengganti'];

mysqli_free_result($result);mysqli_free_result($dbjumlahpeg);
mysqli_close($dbconn);
?>
<div class="modal-header px-4 position-relative modal-shape-header bg-shape">
  <div class="position-relative z-index-1 light">
    <h5 class="mb-0 text-white">Data Kepegawaian</h5>
    <p class="fs--1 mb-0 text-white">Tabel Data Kepegawaian</p>
  </div>
  <button class="btn-close btn-close-white position-absolute top-0 end-0 mt-2 me-2" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<div class="modal-body py-3">

  <input class="form-control" type="text" id="txtidsekolahdetpegawai" value="<?php echo $idsekolah; ?>" style="display:none;" />
  <input class="form-control" type="text" id="txtmdidsekolahdetpegawai" value="<?php echo $mdidsekolah; ?>" style="display:none;" />

  <div class="col-xxl-12 col-lg-12">
    <div class="card h-100 mb-1">
      <div class="card-body py-0">
        <table class="table table-borderless fs--1 mt-3 mb-0">
          <tr class="border-bottom">
            <th class="ps-0 fw-normal pt-0"><strong><?php echo $nmsekolah ?></strong><br />NPSN : <?php echo $npsn ?>
              &nbsp;&nbsp;|&nbsp;&nbsp; Bentuk Pendidikan : <?php echo $bentukpendidikan ?> &nbsp;&nbsp;|&nbsp;&nbsp; Status Sekolah : <?php echo $statussekolah ?>
              <br />Jumlah Guru : <?php echo $guru ?> &nbsp;&nbsp;|&nbsp;&nbsp; Jumlah PTT : <?php echo $ptt ?>
            </th>
          </tr>
        </table>
      </div>
    </div>

    <div class="card mb-3">
      <div class="card-body py-5 py-sm-3">
        <div class="row g-5 g-sm-0">
          <div class="col-sm-3">
            <div class="border-sm-end border-300">
              <div class="text-center">
                <h6 class="text-700">PNS</h6>
                <h5 class="fw-normal text-primary"><?php echo $jumPNS ?></h5>
              </div>
            </div>
          </div>
          <div class="col-sm-3">
            <div class="border-sm-end border-300">
              <div class="text-center">
                <h6 class="text-700">PPPK</h6>
                <h5 class="fw-normal text-success"><?php echo $jumPPPK ?></h5>
              </div>
            </div>
          </div>
          <div class="col-sm-3">
            <div class="border-sm-end border-300">
              <div class="text-center">
                <h6 class="text-700">GTT</h6>
                <h5 class="fw-normal text-warning"><?php echo $jumGTY ?></h5>
              </div>
            </div>
          </div>
          <div class="col-sm-3">
            <div>
              <div class="text-center">
                <h6 class="text-700">Honorer</h6>
                <h5 class="fw-normal text-danger"><?php echo $jumHonorer ?></h5>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="card h-100">
      <div class="card-header">
        <div class="row flex-between-center g-0">
          <div class="col-6 col-sm-auto ms-auto text-end ps-0">
            <div id="table-purchases-replace-element">
              <button class="btn btn-falcon-default btn-sm me-1" type="button" id="cmdRefreshDetPegawai"><span class="d-none d-sm-inline-block ms-1">Refresh</span></button>
            </div>
          </div>
        </div>
      </div>

      <div class="card-body bg-light px-3 py-3">
        <div class="table-responsive scrollbar">
          <table id="tabelDetailPegawai" class="table table-sm table-striped mb-0 fs--1 w-100">
            <thead class="bg-200">
              <tr>
                <th class="sort text-center">No.</th>
                <th class="sort">Nama Pegawai</th>
                <th class="sort">Status Kepegawaian</th>
                <th class="sort">Mata Pelajaran</th>
                <th class="sort">Pendidikan</th>
              </tr>
            </thead>
            <tbody class="bg-white" id="isitabelDetailPegawai" />
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
      isiKepegawaian()
      $("#loading").fadeOut("slow");
    }, 1000);

  });

  $("#cmdRefreshDetPegawai").click(function() {
    isiKepegawaian();
  });

  function isiKepegawaian() {
    var mdidsekolah = $("#txtmdidsekolahdetpegawai").val();
    var idsekolah = $("#txtidsekolahdetpegawai").val();
    $.ajax({
      type: "POST",
      url: "aksi/ptk/isi_tabel_kepegawaian.php",
      data: {
        idsekolah: idsekolah
      },
      dataType: 'json',
      beforeSend: function(e) {
        $("#loading").fadeIn();
        document.body.style.cursor = "wait";
      },
      success: function(data) {
        document.body.style.cursor = "default";
        $('#tabelDetailPegawai').dataTable().fnDestroy();
        var html = '';
        var i;
        for (i = 0; i < data.length; i++) {

          html +=
            '<tr class="btn-reveal-trigger">' +
            '<td class="align-middle text-center" width="3%">' + data[i].no + '</td>' +
            '<td class="align-middle text-truncate" width="18%" style="max-width:120px;">' + data[i].namaptk + '</td>' +
            '<td class="align-middle" width="20%">' + data[i].jenisptk + ' - ' + data[i].statuskepegawaian + '</td>' +
            '<td class="align-middle" width="36%">' + data[i].mengajar + '</td>' +
            '<td class="align-middle" width="33%">' + data[i].pendidikanbidstudi + ' - ' + data[i].pendidikangelar + '</td>' +
            '</tr>';
        }
        $('#isitabelDetailPegawai').html(html);
        $("#tabelDetailPegawai").dataTable({
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