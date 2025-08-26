<?php
error_reporting(0);
require_once 'services/config.php';
$dbconn = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname) or die('Could not connect: ');

include "services/tgl_indo.php";
date_default_timezone_set('Asia/Jakarta');
$tglserver = date('Y-m-d');

$qritgl = ("SELECT tanggal,total FROM kunjungan WHERE tanggal = '" . $tglserver . "'");
$dbtgl = mysqli_query($dbconn, $qritgl);
$jumtgl = mysqli_num_rows($dbtgl);
$jk = mysqli_fetch_assoc($dbtgl);
if ($jumtgl >= 1) {
  $sqlkunjungan  = "UPDATE kunjungan SET pengaduan=pengaduan+1,total=total+1 WHERE tanggal='" . $tglserver . "'";
  $res = mysqli_query($dbconn, $sqlkunjungan);
  $jumlahtotalkunjungan =  $jk['total'];
} else if ($jumtgl <= 0) {
  $sqlkunjungan  = "INSERT INTO kunjungan (tanggal,pengaduan,total) VALUES ('$tglserver',1,1)";
  $res = mysqli_query($dbconn, $sqlkunjungan);
  $jumlahtotalkunjungan = "1";
}

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

  <title>Informasi</title>

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

  <link rel="preconnect" href="https://fonts.gstatic.com">
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,500,600,700%7cPoppins:300,400,500,600,700,800,900&amp;display=swap" rel="stylesheet">

  <link href="vendors/overlayscrollbars/OverlayScrollbars.min.css" rel="stylesheet">

  <link href="vendors/datatables-bs4/dataTables.bootstrap4.min.css" rel="stylesheet">
  <link href="vendors/datatables.net-responsive-bs4/responsive.bootstrap4.css" rel="stylesheet">

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

  </div>

  <main class="main" id="top">
    <nav class="navbar navbar-standard navbar-expand-lg fixed-top navbar-dark bg-dark" data-navbar-darken-on-scroll="data-navbar-darken-on-scroll">
      <div class="container">
        <div class="navbar-brand" role="button" id="brand-logo">
          <div class="d-flex align-items-center py-2">
            <img class="me-2" src="./assets/img/logos/mydispendik_logo.png" alt="Logo Jember Satu Data" width="200" />
          </div>
        </div>
        <button class="navbar-toggler collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#navbarStandard" aria-controls="navbarStandard" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>

        <div class="search-box" data-list='{"valueNames":["title"]}'>
          <form class="position-relative" data-bs-toggle="search" data-bs-display="static">
            <input class="form-control search-input fuzzy-search" id="txtcaripengaduan" type="search" placeholder="tracking aduan (masukkan NIK)" aria-label="Search" />
            <span class="fas fa-search search-box-icon" data-bs-toggle="tooltip" title="Tekan Enter setelah input NIK"></span>
          </form>
          <div class="btn-close-falcon-container position-absolute end-0 top-50 translate-middle shadow-none" data-bs-dismiss="search">
            <button class="btn btn-link btn-close-falcon p-0" aria-label="Close"></button>
          </div>
        </div>

        <div class="collapse navbar-collapse scrollbar" id="navbarStandard">
          <ul class="navbar-nav ms-auto">
            <li><a class="nav-link" href="#" id="cmdPengaduan">Input Pengaduan</a></li>
            <li><a class="nav-link" href="#" id="cmdFaq">FAQ</a></li>
          </ul>

          <ul class="navbar-nav ms-auto">
            <li><a class="nav-link" href="beranda.html" target="_self">Beranda</a></li>
            <li><a role="button" class="nav-link cmdIKM" href="#">IKM</a></li>
            <li class="nav-item dropdown"><a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" id="menuutama">Menu Utama</a>
              <div class="dropdown-menu dropdown-caret dropdown-menu-card border-0 mt-0" aria-labelledby="menuutama">
                <div class="bg-white dark__bg-1000 rounded-3 py-2">
                  <a class="dropdown-item link-600 fw-medium" href="sarana-prasarana.html">Sarana & Prasarana</a>
                  <a class="dropdown-item link-600 fw-medium" href="standart-pelayanan-minimal.html">S P M</a>
                  <a class="dropdown-item link-600 fw-medium" href="anak-tidak-sekolah.html">A T S</a>
                  <a class="dropdown-item link-600 fw-medium" href="https://www.gurupenggerakjember.or.id" target="_blank">Guru Penggerak</a>
                  <a class="dropdown-item link-600 fw-medium" href="podcast.html">Podcast</a>
                  <a class="dropdown-item link-600 fw-medium" href="https://j-sip.netlify.app" target="_blank">J-SIP</a>
                </div>
              </div>
            </li>
            <li class="nav-item dropdown"><a class="nav-link dropdown-toggle" id="navbarDropdownLogin" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Login</a>
              <div class="dropdown-menu dropdown-caret dropdown-menu-end dropdown-menu-card" aria-labelledby="navbarDropdownLogin">
                <div class="card shadow-none navbar-card-login">
                  <div class="card-body fs--1 p-4 fw-normal">
                    <div class="row text-start justify-content-between align-items-center mb-2">
                      <div class="col-auto">
                        <h5 class="fs-0 mb-2">Login My-Dispendik</h5>
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

    <section class="bg-light pt-7 pb-2">
      <div class="container mt-4">
        <div class="card mb-3"><img class="card-img-top" src="assets/img/generic/pengaduan.jpg" alt="" />
          <div class="card-body">
            <div class="row justify-content-between align-items-center">
              <div class="col-xxl-6">
                <div class="row g-3">
                  <div class="col-12">
                    <div class="card font-sans-serif">

                      <div class="card-body d-flex gap-3 flex-column flex-sm-row align-items-center">
                        <img class="rounded-3" src="assets/img/elearning/avatar/call center.jpg" alt="" width="112" />

                        <table class="table table-borderless fs--1 fw-medium mb-0">
                          <tbody>
                            <tr>
                              <td class="p-1" style="font-size:200%; height:60px" colspan="3">Call Center Pengaduan Dinas Pendidikan Kabupaten Jember</td>
                            </tr>
                            <tr>
                              <td class="p-1" style="width: 3%;"><span class="fas fa-phone ms-1"></span></td>
                              <td class="p-1" style="width: 25%;">Nomor WhatsApp </td>
                              <td class="p-1 text-600"><a href="whatsapp://send?text=Hello&phone=+6281336916007">081336916007</a><span class="badge rounded-pill badge-soft-success d-none d-md-inline-block ms-2"><span>WhatsApp</span><span class="fas fa-phone ms-1" data-fa-transform="shrink-4"></span></span>
                              </td>
                            </tr>
                            <tr>
                              <td class="p-1" style="width: 3%;"><span class="fas fa-envelope ms-1"></span></td>
                              <td class="p-1" style="width: 25%;">Email</td>
                              <td class="p-1"><a class="text-600 text-decoration-none" href="malito:dinas.pendidikan@jemberkab.go.id">dinas.pendidikan@jemberkab.go.id </a><span class="badge rounded-pill badge-soft-warning d-none d-md-inline-block ms-2"><span>Business Email</span><span class="fas fa-envelope ms-1" data-fa-transform="shrink-4"></span></span>
                              </td>
                            </tr>
                            <tr>
                              <td class="p-1" style="width: 3%;"><span class="fas fa-globe ms-1"></span></td>
                              <td class="p-1" style="width: 25%;">Website</td>
                              <td class="p-1"><a class="text-600 text-decoration-none" href="https://dispendik.jemberkab.go.id/">dispendik.jemberkab.go.id </a><span class="badge rounded-pill badge-soft-primary d-none d-md-inline-block ms-2"><span>official website</span><span class="fas fa-link ms-1" data-fa-transform="shrink-4"></span></span>
                              </td>
                            </tr>
                          </tbody>
                        </table>
                        <div class="dropdown btn-reveal-trigger position-absolute top-0 end-0 m-3">
                          <button class="btn btn-link btn-reveal text-600 btn-sm dropdown-toggle dropdown-caret-none" type="button" id="studentInfoDropdown" data-bs-toggle="dropdown" data-boundary="viewport" aria-haspopup="true" aria-expanded="false"><span class="fas fa-ellipsis-h fs--2"></span></button>
                          <div class="dropdown-menu dropdown-menu-end border py-2" aria-labelledby="studentInfoDropdown"><a class="dropdown-item" href="#!">View Profile</a><a class="dropdown-item" href="#!">Enrolled Courses</a>
                            <div class="dropdown-divider"></div><a class="dropdown-item text-danger" href="#!">Logout</a>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>

                </div>
              </div>
            </div>

          </div>
        </div>
    </section>

    <section class="bg-dark pt-6 pb-4 light">
      <div class="container">
        <div class="row">
          <div class="col ps-lg-12 ps-xl-12">
            <div class="row mt-5 mt-lg-0">
              <div class="col-lg-3 col-md-3">
                <h6 class="text-uppercase text-white opacity-85 mb-3">
                  Tautan Eksternal
                </h6>
                <ul class="list-unstyled fs--1">
                  <li class="mb-1">
                    <a class="link-600" target="_blank" href="https://www.jemberkab.go.id/">Pemerintah Kabupaten Jember</a>
                  </li>
                  <li class="mb-1">
                    <a class="link-600" target="_blank" href="https://dispendik.jemberkab.go.id/">Dinas Pendidikan Kab. Jember</a>
                  </li>
                  <li class="mb-1">
                    <a class="link-600" target="_blank" href="https://ppid.jemberkab.go.id/">PPID
                      Kabupaten Jember</a>
                  </li>
                </ul>

                <div class="pb-3 mb-0 mt-4">
                  <div class="position-relative ps-3">
                    <div class="position-absolute h-100 start-0 rounded bg-info" style="width: 4px;"></div>
                    <h6 class="fs--1 text-600 mb-1">Kunjungan hari ini</h6>
                    <div class="d-flex align-items-center">
                      <h5 class="fs-2 text-700 mb-0 me-2" data-countup='{"endValue":79,"suffix":"%"}'><?php echo $jumlahtotalkunjungan; ?></h5>
                    </div>
                  </div>
                </div>

              </div>

              <div class="col-lg-3 mt-5 mt-md-0">
                <h6 class="text-uppercase text-white opacity-85 mb-3">
                  Dinas Pendidikan Kabupaten Jember
                  </h5>
                  <ul class="list-unstyled fs--1">
                    <li>
                      <h5 class="fs--1 mb-4">
                        <a class="link-600" href="https://www.google.co.id/maps/place/Kantor+Dinas+Pendidikan+Jember/@-8.1526136,113.6999673,17z/data=!3m1!4b1!4m6!3m5!1s0x2dd69445465a5925:0xae37d0721b5bd2ba!8m2!3d-8.1526136!4d113.7025422!16s%2Fg%2F1hm43q4gn?entry=ttu" target="_blank">
                          Jl. DR. Soebandi No.29, Kreongan Atas, Jemberlor, Kec. Patrang, Kabupaten Jember, Jawa Timur 68118
                        </a>
                      </h5>
                    </li>
                    <li>
                      <h6 class="fs--1 mb-0">
                        <a class="link-600" href="#!">
                          <b>Telepon</b> : (0331)487028</a>
                      </h6>
                      <h6 class="fs--1 mb-0">
                        <a class="link-600" href="#!"><b>Email</b> : dinas.pendidikan@jemberkab.go.id</a>
                      </h6>
                    </li>
                  </ul>
              </div>
              <div class="col-lg-3 mt-0 mt-md-0">
                <h6 class="text-uppercase text-white opacity-85 mb-3">
                  Sosial Media
                </h6>
                <div class="icon-group">
                  <a class="link col-3" target="_blank" href="https://www.instagram.com/disdikjember/"><img src="./assets/img/instagram.png" alt="" width="60" /></a>
                  <a class="link col-3" target="_blank" href="https://www.facebook.com/dispendik.jember/"><img src="./assets/img/facebook.png" alt="" width="60" /></a>
                  <a class="link col-3" target="_blank" href="https://www.twitter.com/diknasjember/"><img src="./assets/img/twitter.png" alt="" width="60" /></a>
                  <a class="link col-3" target="_blank" href="https://www.tiktok.com/@disdikjember/"><img src="./assets/img/tiktok.png" alt="" width="60" /></a>
                </div>
              </div>
              <div class="col-lg-3 mt-0 mt-md-0">
                <h6 class="text-uppercase text-white opacity-85 mb-3">
                  Kolaborasi
                </h6>
                <div class="icon-group">
                  <a class="link col-5" target="_blank" href="https://dapo.kemdikbud.go.id/"><img src="./assets/img/dapodik.png" alt="" width="100" /></a>
                  <a class="link col-4" target="_blank" href="https://portal-data.jemberkab.go.id/"><img src="./assets/img/illustrations/Jsatu_landing.png" alt="" width="120" /></a>
                </div>
              </div>

            </div>
          </div>
        </div>
      </div>
    </section>
    <?php
    include "modal.php";
    ?>

  </main>

  <div class="offcanvas offcanvas-end settings-panel border-0" id="settings-offcanvas" tabindex="-1" aria-labelledby="settings-offcanvas">
    <div class="offcanvas-header settings-panel-header bg-shape">
      <div class="z-index-1 py-1 light">
        <div class="d-flex justify-content-between align-items-center mb-1">
          <h5 class="text-white mb-0 me-2">Komentar Anda</h5>
          <button class="btn btn-primary btn-sm rounded-pill mt-0 mb-0" data-theme-control="reset" style="font-size:12px"> <span class="fas fa-redo-alt me-1" data-fa-transform="shrink-3"></span>Refresh</button>
        </div>
        <p class="mb-0 fs--1 text-white"> Silahkan tinggalkan komentar Anda</p>
      </div>
      <button class="btn-close btn-close-white z-index-1 mt-0" type="button" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body scrollbar-overlay px-card h-100 mb-2" id="themeController">
      <div class="d-flex align-items-center pt-2">
        <button class="btn btn-sm btn-falcon-default rounded-pill me-4 mb-1 cmdTulisKomentar" type="button">Tulis komentar</button>
        <h6 class="mb-0"><a class="py-2 cmdSemuaKomentar" href="#!">Semua Komentar <span class="fas fa-chevron-right ms-1 fs--2"></span></a></h6>
      </div>
      <div id="area-komentar"></div>
    </div>
  </div>

  <a class="card setting-toggle" href="#settings-offcanvas" data-bs-toggle="offcanvas">
    <div class="card-body d-flex align-items-center py-md-2 px-2 py-1">
      <div class="bg-soft-primary position-relative rounded-start" style="height:34px;width:28px">
        <div class="settings-popover"><span class="ripple"><span class="fa-spin position-absolute all-0 d-flex flex-center"><span class="icon-spin position-absolute all-0 d-flex flex-center">
                <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <path d="M19.7369 12.3941L19.1989 12.1065C18.4459 11.7041 18.0843 10.8487 18.0843 9.99495C18.0843 9.14118 18.4459 8.28582 19.1989 7.88336L19.7369 7.59581C19.9474 7.47484 20.0316 7.23291 19.9474 7.03131C19.4842 5.57973 18.6843 4.28943 17.6738 3.20075C17.5053 3.03946 17.2527 2.99914 17.0422 3.12011L16.393 3.46714C15.6883 3.84379 14.8377 3.74529 14.1476 3.3427C14.0988 3.31422 14.0496 3.28621 14.0002 3.25868C13.2568 2.84453 12.7055 2.10629 12.7055 1.25525V0.70081C12.7055 0.499202 12.5371 0.297594 12.2845 0.257272C10.7266 -0.105622 9.16879 -0.0653007 7.69516 0.257272C7.44254 0.297594 7.31623 0.499202 7.31623 0.70081V1.23474C7.31623 2.09575 6.74999 2.8362 5.99824 3.25599C5.95774 3.27861 5.91747 3.30159 5.87744 3.32493C5.15643 3.74527 4.26453 3.85902 3.53534 3.45302L2.93743 3.12011C2.72691 2.99914 2.47429 3.03946 2.30587 3.20075C1.29538 4.28943 0.495411 5.57973 0.0322686 7.03131C-0.051939 7.23291 0.0322686 7.47484 0.242788 7.59581L0.784376 7.8853C1.54166 8.29007 1.92694 9.13627 1.92694 9.99495C1.92694 10.8536 1.54166 11.6998 0.784375 12.1046L0.242788 12.3941C0.0322686 12.515 -0.051939 12.757 0.0322686 12.9586C0.495411 14.4102 1.29538 15.7005 2.30587 16.7891C2.47429 16.9504 2.72691 16.9907 2.93743 16.8698L3.58669 16.5227C4.29133 16.1461 5.14131 16.2457 5.8331 16.6455C5.88713 16.6767 5.94159 16.7074 5.99648 16.7375C6.75162 17.1511 7.31623 17.8941 7.31623 18.7552V19.2891C7.31623 19.4425 7.41373 19.5959 7.55309 19.696C7.64066 19.7589 7.74815 19.7843 7.85406 19.8046C9.35884 20.0925 10.8609 20.0456 12.2845 19.7729C12.5371 19.6923 12.7055 19.4907 12.7055 19.2891V18.7346C12.7055 17.8836 13.2568 17.1454 14.0002 16.7312C14.0496 16.7037 14.0988 16.6757 14.1476 16.6472C14.8377 16.2446 15.6883 16.1461 16.393 16.5227L17.0422 16.8698C17.2527 16.9907 17.5053 16.9504 17.6738 16.7891C18.7264 15.7005 19.4842 14.4102 19.9895 12.9586C20.0316 12.757 19.9474 12.515 19.7369 12.3941ZM10.0109 13.2005C8.1162 13.2005 6.64257 11.7893 6.64257 9.97478C6.64257 8.20063 8.1162 6.74905 10.0109 6.74905C11.8634 6.74905 13.3792 8.20063 13.3792 9.97478C13.3792 11.7893 11.8634 13.2005 10.0109 13.2005Z" fill="#2A7BE4"></path>
                </svg></span></span></span></div>
      </div><small class="text-uppercase text-primary fw-bold bg-soft-primary py-2 pe-2 ps-1 rounded-end">Komentar</small>
    </div>
  </a>

  <script src="vendors/bootstrap/bootstrap.min.js"></script>
  <script src="vendors/anchorjs/anchor.min.js"></script>

  <script src="vendors/fontawesome/all.min.js"></script>
  <script src="vendors/lodash/lodash.min.js"></script>

  <script src="vendors/jquery/jquery.min.js"></script>

  <script src="assets/lib/datatables/js/jquery.dataTables.min.js"></script>
  <script src="assets/lib/datatables-bs4/dataTables.bootstrap4.min.js"></script>
  <script src="assets/lib/datatables.net-responsive/dataTables.responsive.js"></script>
  <script src="assets/lib/datatables.net-responsive-bs4/responsive.bootstrap4.js"></script>

  <script src="assets/js/theme.js"></script>

  <script src="pengaduan.js"></script>
  <script src="komentar.js"></script>

  <script>
    $(document).ready(function() {
      document.body.style.cursor = "default";

      $("#cmdLogin").removeAttr("disabled");
      $("#txtusername").val("");
      $("#txtpassword").val("");

      IsiKomentar();

      $("#lblhalaman").val("dashboard");
      $("#loading").fadeOut("slow");
    });

    $('#cmdFaq').on('click', function() {
      $.ajax({
        type: "POST",
        url: "web/aksi/pengaduan/faq.php",
        data: {},
        success: function(resp) {
          $("#isianmodFaqExtraLarge").html(resp);
          $("#isianmodFaqExtraLarge").fadeIn(1000);
          $("#modFaqExtraLarge").modal({
            backdrop: 'static',
            keyboard: false
          })
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