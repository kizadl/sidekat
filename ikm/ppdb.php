<?php
error_reporting(0);
require_once 'services/config.php';
$dbconn = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname) or die('Could not connect: ');

include "services/tgl_indo.php";
date_default_timezone_set('Asia/Jakarta');
$tglserver = date('Y-m-d');
?>

<!DOCTYPE html>
<html lang="en-US" dir="ltr">

<head>
  <meta charset="utf-8">
  <meta name="google" content="notranslate" />
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
            <li class="nav-item dropdown"><a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" id="menuutama">Menu Utama</a>
              <div class="dropdown-menu dropdown-caret dropdown-menu-card border-0 mt-0" aria-labelledby="menuutama">
                <div class="bg-white dark__bg-1000 rounded-3 py-2">
                  <a class="dropdown-item link-600 fw-medium" href="sarana-prasarana.html">Sarana & Prasarana</a>
                  <a class="dropdown-item link-600 fw-medium" href="standart-pelayanan-minimal.html">S P M</a>
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
                              <td class="p-1" style="width: 25%;">No. Telpon </td>
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
                        <a class="link-600" href="#!"><b>Email</b> : diskpendik@jemberkab.go.id</a>
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

  <script src="ppdb.js"></script>

  <script>
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
  </script>

</body>

</html>