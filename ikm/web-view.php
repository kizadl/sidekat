<?php
error_reporting(0);

require_once 'services/config.php';
$dbconn = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname) or die('Could not connect: ');

include "services/tgl_indo.php";
date_default_timezone_set('Asia/Jakarta');
$tglserver = date('Y-m-d');

/*
$qritgl = ("SELECT tanggal,total FROM kunjungan WHERE tanggal = '" . $tglserver . "'");
$dbtgl = mysqli_query($dbconn, $qritgl);
$jumtgl = mysqli_num_rows($dbtgl);
$jk = mysqli_fetch_assoc($dbtgl);
if ($jumtgl >= 1) {
  $sqlkunjungan  = "UPDATE kunjungan SET beranda=beranda+1,total=total+1 WHERE tanggal='" . $tglserver . "'";
  $res = mysqli_query($dbconn, $sqlkunjungan);
  $jumlahtotalkunjungan =  $jk['total'];
} else if ($jumtgl <= 0) {
  $sqlkunjungan  = "INSERT INTO kunjungan (tanggal,beranda,total) VALUES ('$tglserver',1,1)";
  $res = mysqli_query($dbconn, $sqlkunjungan);
  $jumlahtotalkunjungan = "1";
}

$sqlsam = ("SELECT id_sambutan,judul,isi_sambutan,hari,tanggal,jam FROM sambutan WHERE id_sambutan='1'");
$resultsam = mysqli_query($dbconn, $sqlsam);
$a = mysqli_fetch_assoc($resultsam);
$harisambutan = $a['hari'];
$tanggalsambutan = tgl_indo($a['tanggal']);
$judulsambutan = ucwords(strtolower($a['judul']));
$isisambutan = $a['isi_sambutan'];

$sqlx = ("SELECT id_pengumuman,judul,isi_pengumuman,hari,tanggal,jam,dibaca FROM pengumuman WHERE aktif='Y' AND headline='Y' ORDER BY id_pengumuman DESC");
$result = mysqli_query($dbconn, $sqlx);
$b = mysqli_fetch_assoc($result);
$hari = $b['hari'];
$tanggal = tgl_indo($b['tanggal']);
$judul = ucwords(strtolower($b['judul']));
$idpengumuman = $b['id_pengumuman'];
$isipengumuman = $b['isi_pengumuman'];

$sqlpod = ("SELECT id_podcast,judul,isi_podcast,link_youtube,hari,tanggal,jam,dibaca FROM podcast WHERE aktif='Y' AND headline='Y' ORDER BY id_podcast DESC");
$resultpod = mysqli_query($dbconn, $sqlpod);
$c = mysqli_fetch_assoc($resultpod);

$haripod = $c['hari'];
$tanggalpod = tgl_indo($c['tanggal']);
$judulpod = ucwords(strtolower($c['judul']));

$isipodvideo = strip_tags($c['isi_podcast']);
$isivideo = substr($isipodvideo, 0, 300);
$isivideo = substr($isipodvideo, 0, strrpos($isivideo, " "));
$linkyoutube = $c['link_youtube'];
*/
?>

<!DOCTYPE html>
<html lang="en-US" dir="ltr">

<head>
  <meta charset="utf-8">
  <meta name="google" content="notranslate" />
  <meta name="google-site-verification" content="PRBTvS9zydGttLgDyEs4uLpqduLM02G7MC8BQWhO45A" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="Pragma" content="no-cache">
  <meta http-equiv="Expires" content="-1">

  <title>IKM JDIH DPRD Kabupaten Jember</title>

  <link href="favicon.png" rel="icon" />
  <link href="favicon.png" rel="apple-touch-icon" />
  <link rel="manifest" href="assets/img/favicons/manifest.json">
  <meta name="msapplication-TileImage" content="assets/img/favicons/mstile-150x150.png">
  <meta name="theme-color" content="#ffffff">

  <!-- Google Tag Manager -->
  <script>
    (function(w, d, s, l, i) {
      w[l] = w[l] || [];
      w[l].push({
        'gtm.start': new Date().getTime(),
        event: 'gtm.js'
      });
      var f = d.getElementsByTagName(s)[0],
        j = d.createElement(s),
        dl = l != 'dataLayer' ? '&l=' + l : '';
      j.async = true;
      j.src =
        'https://www.googletagmanager.com/gtm.js?id=' + i + dl;
      f.parentNode.insertBefore(j, f);
    })(window, document, 'script', 'dataLayer', 'GTM-KXR9C8J5');
  </script>
  <!-- End Google Tag Manager -->

  <script src="assets/js/config.js"></script>
  <script src="vendors/overlayscrollbars/OverlayScrollbars.min.js"></script>

  <link href="vendors/swiper/swiper-bundle.min.css" rel="stylesheet" />

  <link href="vendors/glightbox/glightbox.min.css" rel="stylesheet">
  <link href="vendors/plyr/plyr.css" rel="stylesheet">

  <link rel="stylesheet" href="vendors/select2/css/select2.min.css">

  <link href="vendors/flatpickr/flatpickr.min.css" rel="stylesheet" />

  <link rel="preconnect" href="https://fonts.gstatic.com">
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,500,600,700%7cPoppins:300,400,500,600,700,800,900&amp;display=swap" rel="stylesheet">

  <link href="vendors/overlayscrollbars/OverlayScrollbars.min.css" rel="stylesheet">

  <link href="assets/css/theme.min.css" rel="stylesheet" id="style-default">

  <style type="text/css">
    #loading {
      position: fixed;
      left: 0px;
      top: 0px;
      width: 100%;
      height: 100%;
      z-index: 9999;
      background: url(assets/css/loading.gif) 50% 50% no-repeat #ede9df;
      background-color: #252525;
      opacity: 0.7;
      filter: alpha(opacity=70);
    }

    .pagination {
      padding-right: 10px;
    }

    .page-link {
      border: none;
      margin-top: 5px;
      padding-top: 5px;
      height: 32px;
      text-align: center;
      vertical-align: middle;
      font-size: 12px;
    }

    .paginate_button.active .page-link {
      background-color: black !important;
    }

    #grad1 {
      height: 60px;
      background-color: red; /* For browsers that do not support gradients */
      background-image: linear-gradient(#fd0000, #fd762d);
    }
  </style>

</head>


<body style="-webkit-user-select:none;-moz-user-select:none;">

  <!-- Google Tag Manager (noscript) -->
  <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-KXR9C8J5" height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
  <!-- End Google Tag Manager (noscript) -->

  <div id="loading"></div>

  <div style="display:none">

    <input type="text" id="lbltglserver" value="<?php echo $tglserver; ?>" readonly="readonly" />
    <input type="text" id="lblhalaman" value="" readonly="readonly" />

    <input type="text" id="lbllatitude" value="" readonly="readonly" />
    <input type="text" id="lbllongitude" value="" readonly="readonly" />

    <input type="text" id="lbllatitudeuser" value="" readonly="readonly" />
    <input type="text" id="lbllongitudeuser" value="" readonly="readonly" />

    <input type="text" id="txttransid" value="" readonly="readonly" />
    <input type="text" id="txttransketerangan" value="" readonly="readonly" />
    <input type="text" id="txttransnmwilayah" value="" readonly="readonly" />

    <input type="text" id="txttransiddinkes" value="" readonly="readonly" />
    <input type="text" id="txttransketerangandinkes" value="" readonly="readonly" />
    <input type="text" id="txttranstahundinkes" value="<?php echo $thnakhir; ?>" readonly="readonly" />
    <input type="text" id="txtketbuttondinkes" value="" readonly="readonly" />

    <input type="text" id="txtketbuttonrsud" value="" readonly="readonly" />

  </div>

  <main class="main" id="top">
    <nav class="navbar navbar-standard navbar-expand-lg fixed-top"  id="grad1">
      <div class="container">
        <div class="navbar-brand" role="button" id="brand-logo">
          <div class="d-flex align-items-center py-2">
            <a href="https://jdih-dprd.jemberkab.go.id/"><img class="me-2" src="./assets/img/logo_jdih_dprd.png" alt="Logo Jember Satu Data" width="200" /></a>
          </div>
        </div>
        <button class="navbar-toggler collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#navbarStandard" aria-controls="navbarStandard" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse scrollbar" id="navbarStandard">
          <ul class="navbar-nav ms-auto">
            <li class="nav-item dropdown"><a class="nav-link dropdown-toggle" id="navbarDropdownLogin" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"style="color:black;">Login</a>
              <div class="dropdown-menu dropdown-caret dropdown-menu-end dropdown-menu-card" aria-labelledby="navbarDropdownLogin">
                <div class="card shadow-none navbar-card-login">
                  <div class="card-body fs--1 p-4 fw-normal">
                    <div class="row text-start justify-content-between align-items-center mb-2">
                      <div class="col-auto">
                        <h5 class="fs-0 mb-2">Login Admin</h5>
                        <div id="loginMsg" style="display:none"></div>
                      </div>
                    </div>
                    <form>
                      <div class="mb-3">
                        <input class="form-control" type="text" id="txtusername" autocomplete="off" placeholder="Username" />
                      </div>
                      <div class="mb-3">
                        <input class="form-control" type="password" id="txtpassword" autocomplete="off" placeholder="Password" />
                      </div>

                      <div class="mb-1">
                        <button class="btn btn-primary d-block w-100 mt-3" id="cmdLogin" type="button">Log in</button>
                      </div>
                    </form>
                  </div>
                </div>
              </div>
            </li>

          </ul>
        </div>
      </div>
    </nav>

    <section class="py-0 overflow-hidden light" id="banner">

        <div class="bg-holder overlay" style="background-color:#01204E;">
        </div>
        <!--/.bg-holder-->

        <div class="container">
          <div class="row flex-center pt-8 pt-lg-8 pb-lg-0 pb-xl-0">
            <div class="col-md-11 col-lg-8 col-xl-4 pb-9 pb-xl-9 text-center text-xl-start">
              <h1 class="text-white fw-light"><span class="typed-text fw-bold">Indeks Kepuasan Masyarakat</span></h1>
              <p class="lead text-white opacity-75">With the power of Us, you can now focus only on functionaries for your digital products, while leaving the UI design on us!</p><a class="btn btn-outline-light border-2 rounded-pill btn-lg mt-4 fs-0 py-2 cmdIKM" href="#">Mulai Isi Surfey<span class="fas fa-play ms-2" data-fa-transform="shrink-6 down-1"></span></a>
            </div>
            <div class="d-none d-sm-block col-xl-5 offset-1 align-self-center mb-8">
                        <img class="img-fluid" src="./assets/img/ikm-landing.png" alt="Illustration" />
            </div>
          </div>
        </div>
        <!-- end of .container-->

      </section>


    <?php
    include "modal.php";
    ?>

  </main>




  <script src="vendors/bootstrap/bootstrap.min.js"></script>
  <script src="vendors/anchorjs/anchor.min.js"></script>

  <script src="vendors/swiper/swiper-bundle.min.js"></script>

  <script src="vendors/glightbox/glightbox.min.js"> </script>
  <script src="vendors/plyr/plyr.polyfilled.min.js"></script>
  <script src="https://polyfill.io/v3/polyfill.min.js?features=window.scroll"></script>

  <script src="vendors/fontawesome/all.min.js"></script>
  <script src="vendors/lodash/lodash.min.js"></script>
  <script src="vendors/jquery/jquery.min.js"></script>

  <script src="assets/js/flatpickr.js"></script>
  <script src="assets/js/theme.js"></script>

  <script src="web-view.js"></script>


  <script>
    $('.btnTampilkanGalleri').on('click', function() {
      var idkegiatan = $(this).data('idkegiatan');
      var nmsekolah = $(this).data('nmsekolah');
      $.ajax({
        type: "POST",
        url: "web/aksi/kegiatan-sekolah/tampilkan-foto-kegiatan.php",
        data: {
          idkegiatan: idkegiatan,
          nmsekolah: nmsekolah
        },
        success: function(resp) {
          $("#isianmodFaqExtraLarge").html(resp);
          $("#isianmodFaqExtraLarge").fadeIn(1000);
          $("#modFaqExtraLarge").modal('show');
        },
        error: function() {
          alert('Koneksi bermasalah periksa internet');
        },
      });
    });

    $('.cmdIKM').on('click', function() {
      $.ajax({
        type: "POST",
        url: "web/aksi/ikm/ikm.php",
        data: {},
        success: function(resp) {
          $("#isianmodBebasLarge").html(resp);
          $("#isianmodBebasLarge").fadeIn(1000);
          $("#modBebasLarge").modal('show');
        },
        error: function() {
          alert('Koneksi bermasalah periksa internet');
        },
      });
    });
  </script>

</body>

</html>