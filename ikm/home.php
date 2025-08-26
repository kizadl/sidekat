<?php
error_reporting(0);
require_once 'services/config.php';
$dbconn = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname) or die('Could not connect: ');

include "services/tgl_indo.php";
date_default_timezone_set('Asia/Jakarta');
$tahun = date('Y-m-d');

$qrirec = ("SELECT SUM(TABLE_ROWS) AS jmlrecord FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA = 'db_mydispendik'");
$dbqrirec = mysqli_query($dbconn, $qrirec);
$rec = mysqli_fetch_assoc($dbqrirec);
$jmlrecord = number_format($rec['jmlrecord'], 0, ",", ".");
mysqli_free_result($dbqrirec);


// jumlah OPD //
$qri2 = ("SELECT COUNT(id_operator) AS jmlopd FROM m_operator");
$dbqri2 = mysqli_query($dbconn, $qri2);
$b = mysqli_fetch_assoc($dbqri2);
$jmlopd = number_format($b['jmlopd'], 0, ",", ".");
mysqli_free_result($dbqri2);

// pendidikan //
$qri3 = ("SELECT COUNT(id) AS jmlsekolah,SUM(siswa) AS jmlsiswa,SUM(guru) AS jmlguru FROM tbl_api_dispendik");
$dbqri3 = mysqli_query($dbconn, $qri3);
$c = mysqli_fetch_assoc($dbqri3);
$jmlsekolah = number_format($c['jmlsekolah'], 0, ",", ".");
$jmlsiswa = number_format($c['jmlsiswa'], 0, ",", ".");
$jmlguru = number_format($c['jmlguru'], 0, ",", ".");
mysqli_free_result($dbqri3);

mysqli_close($dbconn);
?>

<!DOCTYPE html>
<html lang="en-US" dir="ltr">

<head>
  <meta charset="utf-8" />
  <meta name="google" content="notranslate" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />

  <title>My Dispendik</title>
  <link href="favicon.png" rel="icon" />
  <meta name="theme-color" content="#ffffff" />
  <script src="./assets/js/config.js"></script>
  
  <script src="./vendors/overlayscrollbars/OverlayScrollbars.min.js"></script>

  <link href="./vendors/swiper/swiper-bundle.min.css" rel="stylesheet" />
  <link rel="preconnect" href="https://fonts.gstatic.com" />
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,500,600,700%7cPoppins:300,400,500,600,700,800,900&amp;display=swap" rel="stylesheet" />
  <link href="./vendors/overlayscrollbars/OverlayScrollbars.min.css" rel="stylesheet" />
  <link href="./assets/css/theme-rtl.min.css" rel="stylesheet" id="style-rtl" />
  <link href="./assets/css/theme.min.css" rel="stylesheet" id="style-default" />
  <link href="./assets/css/user-rtl.min.css" rel="stylesheet" id="user-style-rtl" />
  <link href="./assets/css/user.min.css" rel="stylesheet" id="user-style-default" />
  <script>
    var isRTL = JSON.parse(localStorage.getItem("isRTL"));
    if (isRTL) {
      var linkDefault = document.getElementById("style-default");
      var userLinkDefault = document.getElementById("user-style-default");
      linkDefault.setAttribute("disabled", true);
      userLinkDefault.setAttribute("disabled", true);
      document.querySelector("html").setAttribute("dir", "rtl");
    } else {
      var linkRTL = document.getElementById("style-rtl");
      var userLinkRTL = document.getElementById("user-style-rtl");
      linkRTL.setAttribute("disabled", true);
      userLinkRTL.setAttribute("disabled", true);
    }
  </script>
</head>

<body style="-webkit-user-select:none;-moz-user-select:none;">

  <main class="main" id="top">
    <nav class="navbar navbar-standard navbar-expand-lg fixed-top navbar-dark" data-navbar-darken-on-scroll="data-navbar-darken-on-scroll">
      <div class="container">
        <a class="navbar-brand" href="./home.html">
          <div class="d-flex align-items-center py-2">
            <img class="me-2" src="./assets/img/logos/logo_mydispendik.png" alt="Logo Jember Satu Data" width="200" />
          </div>
        </a>
        <button class="navbar-toggler collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#navbarStandard" aria-controls="navbarStandard" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse scrollbar" id="navbarStandard">
          <ul class="navbar-nav ms-auto">
            <li><a class="nav-link" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" id="dashboards">Home</a></li>
            <li><a class="nav-link" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" id="dashboards">Login</a></li>
          </ul>
        </div>
      </div>
    </nav>








    <div class="modal fade" id="loginModal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
          <div class="modal-header px-4 position-relative modal-shape-header bg-shape">
            <div class="position-relative z-index-1 light">
              <h5 class="mb-0 text-white">Login My Dispendik</h5>
              <p class="fs--1 mb-0 text-white">Silahkan masukkan username dan password Anda</p>
            </div>
            <button class="btn-close btn-close-white position-absolute top-0 end-0 mt-2 me-2" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body p-4">
            <div id="loginMsg" style="display:none"></div>
            <form id="loginFrm">
              <div class="mb-3">
                <input class="form-control" type="text" id="txtusername" autocomplete="off" placeholder="Username" />
              </div>
              <div class="mb-3">
                <input class="form-control" type="password" id="txtpassword" autocomplete="off" placeholder="Password" />
              </div>
              <div class="mb-1">
                <button class="btn btn-primary d-block w-100 mt-4" id="cmdLogin" type="button">
                  Login
                </button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>

    <section class="py-0 overflow-hidden light" id="banner">
      <div class="bg-holder overlay" style="background-color: #180d5b"></div>
      <div class="container">
        <div class="row flex-center pt-5 pt-lg-12 pb-6" style="height:60vh">
          <div class="col-sm-12 col-md-2 col-lg-12 col-xl-6 pb-2 pt-6 text-start">
            <h5 class="text-white fw-light">
              My Dispendik<br>
              <span class="typed-text fw-bold" data-typed-text='["Wis Wayahe Pendidikan Jember Satu Data","Dinas Pendidikan Kabupaten Jember"]'></span>
            </h5>
            <p class="lead text-white opacity-75">
              Peta My Dispendik memiliki fitur 2D yang dapat diakses menggunakan browser
              Google Chrome, Mozilla untuk kelancaran pengguna peta My-Dispendik.<br>
              Harap menggunakan browser yang direkomendasikan.
            </p>

            <div id="btn-pelayanan" class="btn btn-outline-light border-2 rounded-pill btn-lg mt-4 fs-0 py-2" style="display:none">
              Ekosistem Jember Satu Data<span class="fas fa-play ms-2" data-fa-transform="shrink-6 down-1"></span>
            </div>
          </div>
          <div class="d-none d-sm-block col-xl-5 offset-1 align-self-center">
            <img class="img-fluid" src="./assets/img/illustrations/pendidikan.svg" width="300px" alt="Illustration" />
          </div>
        </div>
      </div>
    </section>



    <section id="data-informasi" class="pt-6 pb-6">

      <div class="container">

        <div class="row mt-3">
          <div class="col-lg-4">
            <div class="card card-span h-100" role="button" id="cmdNakesDinkes">
              <div class="card-body pt-3 pb-2 bg-00">
                <div class="row flex-center">
                  <div class="col-md col-lg- col-xl-4 ps-lg-"><img class="img-fluid" width="300px" src="./assets/img/illustrations/pendidikan.svg" alt="" /></div>
                  <div class="col-md col-lg-8 col-xl-8 mt- mt-md-0">
                    <h5 class="fw-bold">KLINIK DAPO </h5>
                    <p style="font-size: 0.90em">Data Sarpras Lembaga</p>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-lg-4">
            <div class="card card-span h-100" role="button" id="cmdNakesDinkes">
              <div class="card-body pt-3 pb-2 bg-00">
                <div class="row flex-center">
                  <div class="col-md col-lg- col-xl-4 ps-lg-"><img class="img-fluid" width="300px" src="./assets/img/illustrations/pendidikan.svg" alt="" /></div>
                  <div class="col-md col-lg-8 col-xl-8 mt- mt-md-0">
                    <h5 class="fw-bold">SARPRAS</h5>
                    <p style="font-size: 0.90em">Sarana Prasarana Lembaga</p>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-lg-4">
            <div class="card card-span h-100" role="button" id="cmdNakesDinkes">
              <div class="card-body pt-3 pb-2 bg-00">
                <div class="row flex-center">
                  <div class="col-md col-lg- col-xl-4 ps-lg-"><img class="img-fluid" width="300px" src="./assets/img/illustrations/pendidikan.svg" alt="" /></div>
                  <div class="col-md col-lg-8 col-xl-8 mt- mt-md-0">
                    <h5 class="fw-bold">POJOK LITERASI</h5>
                    <p style="font-size: 0.90em">Literasi Digital Pendidikan</p>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="row mt-3">
          <div class="col-lg-4">
            <div class="card card-span h-100" role="button" id="cmdNakesDinkes">
              <div class="card-body pt-3 pb-2 bg-00">
                <div class="row flex-center">
                  <div class="col-md col-lg- col-xl-4 ps-lg-"><img class="img-fluid" width="300px" src="./assets/img/illustrations/pendidikan.svg" alt="" /></div>
                  <div class="col-md col-lg-8 col-xl-8 mt- mt-md-0">
                    <h5 class="fw-bold">K G P</h5>
                    <p style="font-size: 0.90em">Klompok Guru Penggerak</p>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-lg-4">
            <div class="card card-span h-100" role="button" id="cmdNakesDinkes">
              <div class="card-body pt-3 pb-2 bg-00">
                <div class="row flex-center">
                  <div class="col-md col-lg- col-xl-4 ps-lg-"><img class="img-fluid" width="300px" src="./assets/img/illustrations/pendidikan.svg" alt="" /></div>
                  <div class="col-md col-lg-8 col-xl-8 mt- mt-md-0">
                    <h5 class="fw-bold">J-SIP</h5>
                    <p style="font-size: 0.75em">Jember Sistem Informasi Prestasi</p>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-lg-4">
            <div class="card card-span h-100" role="button" id="cmdNakesDinkes">
              <div class="card-body pt-3 pb-2 bg-00">
                <div class="row flex-center">
                  <div class="col-md col-lg- col-xl-4 ps-lg-"><img class="img-fluid" width="300px" src="./assets/img/illustrations/pendidikan.svg" alt="" /></div>
                  <div class="col-md col-lg-8 col-xl-8 mt- mt-md-0">
                    <h5 class="fw-bold">MUTASI SISWA</h5>
                    <p style="font-size: 0.90em">Data Mutasi Siswa</p>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="row mt-3">
          <div class="col-lg-4">
            <div class="card card-span h-100" role="button" id="cmdNakesDinkes">
              <div class="card-body pt-3 pb-2 bg-00">
                <div class="row flex-center">
                  <div class="col-md col-lg- col-xl-4 ps-lg-"><img class="img-fluid" width="300px" src="./assets/img/illustrations/pendidikan.svg" alt="" /></div>
                  <div class="col-md col-lg-8 col-xl-8 mt- mt-md-0">
                    <h5 class="fw-bold">LEGALISIR IJAZAH</h5>
                    <p style="font-size: 0.90em">Informasi Legalisir Ijazah</p>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-lg-4">
            <div class="card card-span h-100" role="button" id="cmdNakesDinkes">
              <div class="card-body pt-3 pb-2 bg-00">
                <div class="row flex-center">
                  <div class="col-md col-lg- col-xl-4 ps-lg-"><img class="img-fluid" width="300px" src="./assets/img/illustrations/pendidikan.svg" alt="" /></div>
                  <div class="col-md col-lg-8 col-xl-8 mt- mt-md-0">
                    <h5 class="fw-bold">S P M</h5>
                    <p style="font-size: 0.90em">Standar Pelayanan Minimal</p>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-lg-4">
            <div class="card card-span h-100" role="button" id="cmdNakesDinkes">
              <div class="card-body pt-3 pb-2 bg-00">
                <div class="row flex-center">
                  <div class="col-md col-lg- col-xl-4 ps-lg-"><img class="img-fluid" width="300px" src="./assets/img/illustrations/pendidikan.svg" alt="" /></div>
                  <div class="col-md col-lg-8 col-xl-8 mt- mt-md-0">
                    <h5 class="fw-bold">INOVASI SEKOLAH</h5>
                    <p style="font-size: 0.90em">Informasi Inovasi Sekolah</p>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="row mt-3">
          <div class="col-lg-4">
            <div class="card card-span h-100" role="button" id="cmdNakesDinkes">
              <div class="card-body pt-3 pb-2 bg-00">
                <div class="row flex-center">
                  <div class="col-md col-lg- col-xl-4 ps-lg-"><img class="img-fluid" width="300px" src="./assets/img/illustrations/pendidikan.svg" alt="" /></div>
                  <div class="col-md col-lg-8 col-xl-8 mt- mt-md-0">
                    <h5 class="fw-bold">PENGADUAN</h5>
                    <p style="font-size: 0.90em">Sarana Pengaduan</p>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-lg-4">
            <div class="card card-span h-100" role="button" id="cmdNakesDinkes">
              <div class="card-body pt-3 pb-2 bg-00">
                <div class="row flex-center">
                  <div class="col-md col-lg- col-xl-4 ps-lg-"><img class="img-fluid" width="300px" src="./assets/img/illustrations/pendidikan.svg" alt="" /></div>
                  <div class="col-md col-lg-8 col-xl-8 mt- mt-md-0">
                    <h5 class="fw-bold">PODCAST</h5>
                    <p style="font-size: 0.90em">Media Podcast Dispendik</p>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-lg-4">
            <div class="card card-span h-100" role="button" id="cmdNakesDinkes">
              <div class="card-body pt-3 pb-2 bg-00">
                <div class="row flex-center">
                  <div class="col-md col-lg- col-xl-4 ps-lg-"><img class="img-fluid" width="300px" src="./assets/img/illustrations/pendidikan.svg" alt="" /></div>
                  <div class="col-md col-lg-8 col-xl-8 mt- mt-md-0">
                    <h5 class="fw-bold">INFO PENDIDIKAN</h5>
                    <p style="font-size: 0.90em">Informasi Bidang Pendidikan</p>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <section class="py-0 bg-dark light">
      <!--<div>
                <hr class="my-0 text-600 opacity-25" />
                <div class="container py-3">
                    <div class="row justify-content-center fs--1">
                        <div class="col-12 col-sm-auto text-center">
                            <p class="mb-0 text-600 opacity-85">
                                Copyright &copy; Pemerintah Kabupaten Jember
                                <span class="d-none d-sm-inline-block">| </span><br class="d-sm-none" />
                                2022
                            </p>
                        </div>
                    </div>
                </div>
            </div>-->
    </section>
  </main>

  <script src="./vendors/popper/popper.min.js"></script>
  <script src="./vendors/bootstrap/bootstrap.min.js"></script>
  <script src="https://code.jquery.com/jquery-3.4.1.min.js" crossorigin="anonymous"></script>
  <script src="./vendors/anchorjs/anchor.min.js"></script>
  <script src="./vendors/is/is.min.js"></script>
  <script src="./vendors/swiper/swiper-bundle.min.js"></script>
  <script src="./vendors/typed.js/typed.js"></script>
  <script src="./vendors/fontawesome/all.min.js"></script>
  <script src="./vendors/lodash/lodash.min.js"></script>
  <script src="https://polyfill.io/v3/polyfill.min.js?features=window.scroll"></script>
  <script src="./vendors/list.js/list.min.js"></script>
  <script src="./assets/js/theme.js"></script>

  <script type="text/javascript" charset="utf-8">
    $(document).ready(function() {
      document.body.style.cursor = "default";

      $("#cmdLogin").removeAttr("disabled");
      $("#txtusername").val("");
      $("#txtpassword").val("");
    });

    window.scrollTo({
      top: 0,
      behavior: 'smooth'
    });

    $("#btn-pelayanan").click(function() {
      $("html, body").animate({
          scrollTop: $("#data-informasi").offset().top,
        },
        1000
      );
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
  </script>
</body>

</html>