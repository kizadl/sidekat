<?php
//error_reporting(0);
session_start();

if(isset($_SESSION['HALAMAN'])){
	$iduser=$_SESSION['IDOPERATOR'];
	$username=$_SESSION['USERNAME'];
    $nmoperator=$_SESSION['NMOPERATOR'];
}else{
	header('location:home.html');
}

require_once 'services/config.php';
$dbconn = mysqli_connect($dbhost,$dbuser,$dbpass,$dbname)or die('Could not connect: '); 

include "services/tgl_indo.php";
date_default_timezone_set('Asia/Jakarta');
$tahun = date('Y-m-d');

$qrirec = ("SELECT SUM(TABLE_ROWS) AS jmlrecord FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA = 'dbmydispendik'");
$dbqrirec = mysqli_query($dbconn,$qrirec);$rec= mysqli_fetch_assoc($dbqrirec);
$jmlrecord = number_format($rec['jmlrecord'],0,",",".");
mysqli_free_result($dbqrirec);


// jumlah OPD //
$qri2 = ("SELECT COUNT(id_instansi) AS jmlopd FROM m_instansi");
$dbqri2 = mysqli_query($dbconn,$qri2);$b= mysqli_fetch_assoc($dbqri2);
$jmlopd = number_format($b['jmlopd']-1,0,",",".");
mysqli_free_result($dbqri2);

// pendidikan //
$qri3 = ("SELECT COUNT(id) AS jmlsekolah,SUM(siswa) AS jmlsiswa,SUM(guru) AS jmlguru FROM tbl_api_dispendik");
$dbqri3 = mysqli_query($dbconn,$qri3);$c= mysqli_fetch_assoc($dbqri3);
$jmlsekolah = number_format($c['jmlsekolah'],0,",",".");
$jmlsiswa = number_format($c['jmlsiswa'],0,",",".");
$jmlguru = number_format($c['jmlguru'],0,",",".");
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

    <link rel="apple-touch-icon" sizes="180x180" href="./assets/img/favicons/logo_jember.png" />
    <link rel="icon" type="image/png" sizes="32x32" href="./assets/img/favicons/logo_jember.png" />
    <link rel="icon" type="image/png" sizes="16x16" href="./assets/img/favicons/logo_jember.png" />
    <meta name="msapplication-TileImage" content="./assets/img/favicons/logo_jember.png" />
    <meta name="theme-color" content="#ffffff" />
    <script src="./assets/js/config.js"></script>
    <script src="./vendors/overlayscrollbars/OverlayScrollbars.min.js"></script>

    <link href="./vendors/swiper/swiper-bundle.min.css" rel="stylesheet" />
    <link rel="preconnect" href="https://fonts.gstatic.com" />
    <link
        href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,500,600,700%7cPoppins:300,400,500,600,700,800,900&amp;display=swap"
        rel="stylesheet" />
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
        <nav class="navbar navbar-standard navbar-expand-lg fixed-top navbar-dark"
            data-navbar-darken-on-scroll="data-navbar-darken-on-scroll">
            <div class="container">
                <a class="navbar-brand" href="./home.html">
                    <div class="d-flex align-items-center py-2">
                        <img class="me-2" src="./assets/img/logos/logo_jember_satu_data.png" alt="Logo Jember Satu Data"
                            width="200" />
                    </div>
                </a>
                <button class="navbar-toggler collapsed" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarStandard" aria-controls="navbarStandard" aria-expanded="false"
                    aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse scrollbar" id="navbarStandard">
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item">
                            <a class="nav-link btn btn-primary px-4" href="logout.html">Logout</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>

        <section class="py-0 overflow-hidden light" id="banner">
            <div class="bg-holder overlay" style="background-color: #180d5b"></div>
            <div class="container">
                <div class="row flex-center pt-8 pt-lg-10 pb-6" style="height:100vh">
                    <div class="col-sm-12 col-md-12 col-lg-6 col-xl-6 pb-6 text-start">
                        <h3 class="text-white fw-light">
                            My Dispendik<br>
                            <span class="typed-text fw-bold"
                                data-typed-text='["Satu Data, Satu Peta, Satu Kebijakan","Dinas Pendidikan Kabupaten Jember"]'></span>
                        </h3>
                        <p class="lead text-white opacity-75">
                            Peta My Dispendik memiliki fitur 2D yang dapat diakses menggunakan browser
                            Google Chrome, Mozilla untuk kelancaran pengguna peta My-Dispendik.<br>
                            Harap menggunakan browser yang direkomendasikan.
                        </p>

                        <div id="btn-pelayanan" class="btn btn-outline-light border-2 rounded-pill btn-lg mt-4 fs-0 py-2" style="display:none">
                            Ekosistem Jember Satu Data<span class="fas fa-play ms-2"
                                data-fa-transform="shrink-6 down-1"></span>
                        </div>
                    </div>
                    <div class="d-none d-sm-block col-xl-3 offset-1 align-self-center">
                        <img class="img-fluid" src="./assets/img/illustrations/illustration.png" alt="Illustration" />
                    </div>
                </div>
            </div>
        </section>
 
        <section id="data-informasi" class="pt-6 pb-6 text-center">
            <div class="container">
                <div class="row">
                    <div class="col">
                        <h2 class="fs-2 fs-sm-3 fs-md-3">Ekosistem My-Dispendik</h2>
                        <p class="lead fs-0">
                            Ekosistem ,Statistik Dan Penilaian Penentuan Kebijakan Dinas Pendidikan Pemerintah Kabupaten Jember
                        </p>
                    </div>
                </div>

                <div class="row flex-center mt-6">
                    <div class="col-lg-2">
                        <div class="card card-span h-100">
                            <div class="card-span-img">
                                <img class="fs-4 text-info" src="./assets/img/icons/database.png" alt="Icon"
                                    width="50" />
                            </div>
                            <div class="card-body pt-6 pb-4">
                                <h4 class="mb-2"><?php echo $jmlrecord ?></h4>
                                <h6 class="fs--1">Jumlah Data Record</h6>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-2 mt-6 mt-lg-0">
                        <div class="card card-span h-100">
                            <div class="card-span-img">
                                <img class="fs-4 text-info" src="./assets/img/icons/opd.png" alt="Icon"
                                    width="50" />
                            </div>
                            <div class="card-body pt-6 pb-4">
                                <h4 class="mb-2"><?php echo $jmlopd ?></h4>
                                <h6 class="fs--1">Jumlah Sekolah</h6>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row mt-3">
                    <div class="flex-1 position-relative ps-3">
                        <div class="border-dashed-bottom my-3"></div>
                        <h6 class="fs-0 mb-0">Statistik Data Dinas Pendidikan</h6>
                        <div class="border-dashed-bottom my-3"></div>
                    </div>
                </div>

                <div class="row flex-center mt-4">
                    <div class="col-lg-2 mt-6 mt-lg-0">
                        <div class="card card-span h-100">
                            <div class="card-span-img">
                                <img class="fs-4 text-info" src="./assets/img/icons/sekolah.png" alt="Icon" width="50" />
                            </div>
                            <div class="card-body pt-6 pb-4">
                                <h4 class="mb-2"><?php echo $jmlsekolah ?></h4>
                                <h6 class="fs--1">Jumlah Sekolah</h6>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-2 mt-6 mt-lg-0">
                        <div class="card card-span h-100">
                            <div class="card-span-img">
                                <img class="fs-4 text-info" src="./assets/img/icons/guru.png" alt="Icon"
                                    width="50" />
                            </div>
                            <div class="card-body pt-6 pb-4">
                                <h4 class="mb-2"><?php echo $jmlguru ?></h4>
                                <h6 class="fs--1">Jumlah Guru</h6>
                            </div>
                        </div>
                    </div>
 
                    <div class="col-lg-2">
                        <div class="card card-span h-100">
                            <div class="card-span-img">
                                <img class="fs-4 text-info" src="./assets/img/icons/murid.png" alt="Icon"
                                    width="50" />
                            </div>
                            <div class="card-body pt-6 pb-4">
                                <h4 class="mb-2"><?php echo $jmlsiswa ?></h4>
                                <h6 class="fs--1">Jumlah Siswa</h6>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </section>
 
        <section id="data-geospatial" class="pt-6 pb-4 text-center bg-light">
            <div class="container">
                <div class="row">
                    <div class="col">
                        <h2 class="fs-2 fs-sm-3 fs-md-3">Geospatial Dinas Pendidikan Kabupaten Jember</h2>
                        <p class="lead fs-0">
                            Peta Terintegrasi Dinas Pendidikan Pemerintah Kabupaten Jember
                        </p>
                    </div>
                </div>
                <div class="row flex-center mt-4">

                    <div class="col-6 col-md-4 col-lg-2 col-xxl-2 mb-3">
                        <div class="card card-span h-100">
                            <div class="card-body pt-4 pb-4">
                                <div class="p-0 h-100"><a href="dispendik/home.html" target="_blank"><img
                                            class="img-thumbnail img-fluid rounded-circle mb-3 shadow-sm"
                                            src="assets/img/favicons/dispendik.png" alt="" width="100" /></a>
                                    <h6 class="mb-1"><a href="dispendik/home.html" target="_blank">Dinas Pendidikan</a></h6>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </section>

        <section class="py-0 bg-dark light">
            <div>
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
            </div>
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
    $(document).ready(function(){
      document.body.style.cursor = "default";	
      //$("html, body").animate({
      //  scrollTop: $("#data-pelayanan").offset().top,
      //},1000);

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

    </script>
</body>

</html>