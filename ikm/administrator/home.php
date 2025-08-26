<?php
error_reporting(0);
session_start();

if ($_SESSION['AKSES'] == "administrator") {
    $iduser = $_SESSION['IDOPERATOR'];
    $username = $_SESSION['USERNAME'];
    $nmoperator = $_SESSION['NMOPERATOR'];
    $akses = $_SESSION['AKSES'];
    $idinstansi = "1";
} else {
    header('location:../home.html');
}

require_once '../services/config.php';
$dbconn = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname) or die('Could not connect: ');

include "../services/tgl_indo.php";
date_default_timezone_set('Asia/Jakarta');
$tglserver = date('Y-m-d');

$editor = $iduser;

$qriup = ("SELECT server_url,stts_upload FROM set_server WHERE id_server='1'");
$dbupload = mysqli_query($dbconn, $qriup);
$b = mysqli_fetch_assoc($dbupload);
$serverurl = $b['server_url'];
$sttsupload = $b['stts_upload'];
if ($sttsupload == "on") {
    $warnaupload = "primary";
    $hiddenON = "display:none";
    $hiddenOFF = "";
} else if ($sttsupload == "off") {
    $warnaupload = "warning";
    $hiddenON = "";
    $hiddenOFF = "display:none";
}
mysqli_free_result($dbupload);

$qricbg = ("SELECT nm_instansi,kota FROM m_instansi WHERE id_instansi='" . $idinstansi . "'");
$dbcabang = mysqli_query($dbconn, $qricbg);
$c = mysqli_fetch_assoc($dbcabang);
$nmcabang = ucwords(strtolower($c['nm_instansi']));
$nmkotains = ucwords(strtolower($c['kota']));
mysqli_free_result($dbcabang);
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

    <title>My Dispendik | Dinas Pendidikan</title>

    <link href="favicon.png" rel="icon" />
    <link href="favicon.png" rel="apple-touch-icon" />
    <link rel="manifest" href="../assets/img/favicons/manifest.json">
    <meta name="msapplication-TileImage" content="../assets/img/favicons/mstile-150x150.png">
    <meta name="theme-color" content="#ffffff">
    <script src="../assets/js/config.js"></script>
    <script src="../vendors/overlayscrollbars/OverlayScrollbars.min.js"></script>

    <link href="../vendors/flatpickr/flatpickr.min.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,500,600,700%7cPoppins:300,400,500,600,700,800,900&amp;display=swap" rel="stylesheet">

    <link href="../vendors/overlayscrollbars/OverlayScrollbars.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../vendors/select2/css/select2.min.css">

    <link href="../vendors/datatables-bs4/dataTables.bootstrap4.min.css" rel="stylesheet">
    <link href="../vendors/datatables.net-responsive-bs4/responsive.bootstrap4.css" rel="stylesheet">

    <link href="../vendors/glightbox/glightbox.min.css" rel="stylesheet" />
    <link href="../vendors/plyr/plyr.css" rel="stylesheet" />
    <link href="../vendors/dropzone/dropzone.min.css" rel="stylesheet">

    <link href="../assets/css/theme.min.css" rel="stylesheet" id="style-default">

    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/leaflet/1.8.0/leaflet.css" />
    <script src="//cdnjs.cloudflare.com/ajax/libs/leaflet/1.8.0/leaflet.js"></script>

    <script src="https://unpkg.com/leaflet-routing-machine@latest/dist/leaflet-routing-machine.js" crossorigin="anonymous"></script>

    <!-- STYLING UNTUK LEAFLET -->
    <style>
        .leaflet-control-container .leaflet-routing-container-hide {
            display: none;
        }
    </style>
    <!-- STYLING UNTUK LEAFLET -->

    <style type="text/css">
        #loading {
            position: fixed;
            left: 0px;
            top: 0px;
            width: 100%;
            height: 100%;
            z-index: 9999;
            background: url(../assets/css/loading.gif) 50% 50% no-repeat #ede9df;
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

        @media screen and (min-width: 676px) {
            .modal-detail-dialog {
                max-width: 1100px;
            }
        }
    </style>

</head>


<body style="-webkit-user-select:none;-moz-user-select:none;">

    <div id="loading"></div>

    <div style="display:none">

        <input type="text" id="lbltglserver" value="<?php echo $tglserver; ?>" readonly="readonly" />
        <input type="text" id="lblhalaman" value="" readonly="readonly" />
        <input type="text" id="lblnminstansi" value="<?php echo $nmcabang; ?>" readonly="readonly" />

        <input type="text" id="lbleditor" value="<?php echo $editor; ?>" readonly="readonly" />
        <input type="text" id="lblakses" value="<?php echo $akses; ?>" readonly="readonly" />
        <input type="text" id="lblidinstansi" value="<?php echo $idinstansi; ?>" readonly="readonly" />

        <input type="text" id="lbllatitude" value="" readonly="readonly" />
        <input type="text" id="lbllongitude" value="" readonly="readonly" />

        <input type="text" id="txttransid" value="" readonly="readonly" />
        <input type="text" id="txttransketerangan" value="" readonly="readonly" />
        <input type="text" id="txttransnmwilayah" value="" readonly="readonly" />

        <input type="text" id="txttransiddetailsekolah" value="" readonly="readonly" />
    </div>

    <main class="main" id="top">
        <div class="container-fluid" data-layout="container">
            <nav class="navbar navbar-light navbar-vertical navbar-expand-xl navbar-vibrant">

                <script>
                    var navbarStyle = localStorage.getItem("navbarStyle");
                    if (navbarStyle && navbarStyle !== 'transparent') {
                        document.querySelector('.navbar-vertical').classList.add(`navbar-${navbarStyle}`);
                    }
                </script>
                <div class="d-flex align-items-center">
                    <div class="toggle-icon-wrapper">

                        <button class="btn navbar-toggler-humburger-icon navbar-vertical-toggle"><span class="navbar-toggle-icon"><span class="toggle-line"></span></span></button>

                    </div>
                    <a class="navbar-brand" href="#">
                        <div class="d-flex align-items-center py-3"><span class="text-primary fs-2 fw-bold mb-0">MyDispendik</span></div>
                    </a>
                </div>

                <div class="collapse navbar-collapse" id="navbarVerticalCollapse">
                    <div class="navbar-vertical-content scrollbar">
                        <ul class="navbar-nav flex-column mb-3" id="navbarVerticalNav">

                            <li class="nav-item">
                                <a class="nav-link" id="lv_sinkron_dapodik" href="#" role="button" data-bs-toggle="collapse" aria-expanded="false">
                                    <div class="d-flex align-items-center"><span class="nav-link-icon"><span class="fas fa-database text-info"></span></span><span class="nav-link-text ps-1">Sinkron Dapodik</span>
                                    </div>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="lv_sinkron_media" href="#" role="button" data-bs-toggle="collapse" aria-expanded="false">
                                    <div class="d-flex align-items-center"><span class="nav-link-icon"><span class="fas fa-camera text-warning"></span></span><span class="nav-link-text ps-1">Sinkron Data Media</span>
                                    </div>
                                </a>
                            </li>

                            <li class="nav-item">
                                <div class="row navbar-vertical-label-wrapper mt-2 mb-1">
                                    <div class="col-auto navbar-vertical-label">Aplikasi
                                    </div>
                                    <div class="col ps-0">
                                        <hr class="mb-0 navbar-vertical-divider" />
                                    </div>
                                </div>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link" id="lv_klinik_dapodik" href="#" role="button" data-bs-toggle="collapse" aria-expanded="false">
                                    <div class="d-flex align-items-center"><span class="nav-link-icon"><span class="fas fa-envelope"></span></span><span class="nav-link-text ps-1">Klinik Dapodik</span>
                                    </div>
                                </a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link" id="lv_survei_ats" href="#" role="button" data-bs-toggle="collapse" aria-expanded="false">
                                    <div class="d-flex align-items-center"><span class="nav-link-icon"><span class="fas fa-map-signs"></span></span><span class="nav-link-text ps-1">Survei ATS</span>
                                    </div>
                                </a>
                            </li>

                            <li class="nav-item">
                                <div class="row navbar-vertical-label-wrapper mt-2 mb-1">
                                    <div class="col-auto navbar-vertical-label">PUPR
                                    </div>
                                    <div class="col ps-0">
                                        <hr class="mb-0 navbar-vertical-divider" />
                                    </div>
                                </div>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link" id="lv_lap_pupr" href="#" role="button" data-bs-toggle="collapse" aria-expanded="false">
                                    <div class="d-flex align-items-center"><span class="nav-link-icon"><span class="fas fa-file-signature text-info"></span></span><span class="nav-link-text ps-1">Laporan Persetujuan</span>
                                    </div>
                                </a>
                            </li>

                            <li class="nav-item">
                                <div class="row navbar-vertical-label-wrapper mt-2 mb-1">
                                    <div class="col-auto navbar-vertical-label">Pengaturan Web Profil
                                    </div>
                                    <div class="col ps-0">
                                        <hr class="mb-0 navbar-vertical-divider" />
                                    </div>
                                </div>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link" id="lv_pengaduan" href="#" role="button" data-bs-toggle="collapse" aria-expanded="false">
                                    <div class="d-flex align-items-center"><span class="nav-link-icon"><span class="fas fa-headphones"></span></span><span class="nav-link-text ps-1">Pengaduan<span class="badge rounded-pill bg-danger ms-4" id="lblnavjmlpengaduan"></span></span>
                                    </div>
                                </a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link" id="lv_ikm" href="#" role="button" data-bs-toggle="collapse" aria-expanded="false">
                                    <div class="d-flex align-items-center"><span class="nav-link-icon"><span class="fas fa-coins"></span></span><span class="nav-link-text ps-1">IKM</span>
                                    </div>
                                </a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link" id="lv_komentar" href="#" role="button" data-bs-toggle="collapse" aria-expanded="false">
                                    <div class="d-flex align-items-center"><span class="nav-link-icon"><span class="fas fa-comment-alt"></span></span><span class="nav-link-text ps-1">Komentar</span>
                                    </div>
                                </a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link" id="lv_web_profil" href="#" role="button" data-bs-toggle="collapse" aria-expanded="false">
                                    <div class="d-flex align-items-center"><span class="nav-link-icon"><span class="fas fa-clipboard-list"></span></span><span class="nav-link-text ps-1">Pengaturan Web</span>
                                    </div>
                                </a>
                            </li>

                            <li class="nav-item">
                                <div class="row navbar-vertical-label-wrapper mt-2 mb-1">
                                    <div class="col-auto navbar-vertical-label">SPM & LPPD
                                    </div>
                                    <div class="col ps-0">
                                        <hr class="mb-0 navbar-vertical-divider" />
                                    </div>
                                </div>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link" id="lv_menu_spm" href="#" role="button" data-bs-toggle="collapse" aria-expanded="false">
                                    <div class="d-flex align-items-center"><span class="nav-link-icon"><span class="fas fa-layer-group"></span></span><span class="nav-link-text ps-1">Menu SPM</span>
                                    </div>
                                </a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link" id="lv_menu_lppd" href="#" role="button" data-bs-toggle="collapse" aria-expanded="false">
                                    <div class="d-flex align-items-center"><span class="nav-link-icon"><span class="fas fa-layer-group"></span></span><span class="nav-link-text ps-1">Menu LPPD</span>
                                    </div>
                                </a>
                            </li>

                            <div class="col ps-0 mb-2 mt-1">
                                <hr class="mb-0 navbar-vertical-divider" />
                            </div>

                            <li class="nav-item">
                                <a class="nav-link" id="lv_data_media" href="#" role="button" data-bs-toggle="collapse" aria-expanded="false">
                                    <div class="d-flex align-items-center"><span class="nav-link-icon"><span class="fas fa-camera"></span></span><span class="nav-link-text ps-1">Data Media</span>
                                    </div>
                                </a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link" id="lv_operator" href="#" role="button" data-bs-toggle="collapse" aria-expanded="false">
                                    <div class="d-flex align-items-center"><span class="nav-link-icon"><span class="fas fa-users"></span></span><span class="nav-link-text ps-1">Operator<span class="badge rounded-pill bg-danger ms-4" id="lblnavjmloperator"></span></span>
                                    </div>
                                </a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link active" id="lv_kota" data-nama="Kabupaten Jember" data-keterangan="kota" data-koordinat="-8.264371593833262, 113.6321026467762" href="#" role="button" data-bs-toggle="collapse" aria-expanded="false">
                                    <div class="d-flex align-items-center"><span class="nav-link-icon"><span class="fas fa-map-marked-alt"></span></span><span class="nav-link-text ps-1">Sebaran Sekolah</span>
                                    </div>
                                </a>
                            </li>
                            <li class="nav-item">
                                <div class="row navbar-vertical-label-wrapper mt-2 mb-2">
                                    <div class="col-auto navbar-vertical-label">Pemetaan Wilayah
                                    </div>
                                    <div class="col ps-0">
                                        <hr class="mb-0 navbar-vertical-divider" />
                                    </div>
                                </div>

                                <?php
                                $menuutama = mysqli_query($dbconn, "SELECT * FROM tbl_api_dispendik GROUP BY id_kecamatan ASC");
                                while ($dm = mysqli_fetch_array($menuutama)) {
                                    $idkec = $dm['id_kecamatan'];
                                    $idkec2 = "ID" . str_replace(".", "", $idkec);
                                    $nmkecamatan = ucwords(strtolower(substr($dm['kecamatan'], 5)));
                                    $koordinatkec = $dm['lintang'] . "," . $dm['bujur'];
                                    $submenu = mysqli_query($dbconn, "SELECT * FROM tbl_api_dispendik WHERE id_kecamatan = '" . $idkec . "' GROUP BY desa_kelurahan ASC");

                                    echo "<a class='nav-link dropdown-indicator lv_kecamatan' href='#$idkec2' data-id='$idkec' data-keterangan='kecamatan' data-nama='$nmkecamatan' data-koordinat='$koordinatkec' role='button' data-bs-toggle='collapse' aria-expanded='false' aria-controls='$idkec2'>
                <div class='d-flex align-items-center'><span class='nav-link-icon'><span class='fas fa-map-marker-alt'></span></span><span class='nav-link-text ps-1'>$nmkecamatan</span>
                </div>
              </a>";

                                    echo "<ul class='nav collapse' id='$idkec2' data-parent='#navbarVerticalCollapse'>";

                                    while ($sub = mysqli_fetch_array($submenu)) {
                                        $idsub = $sub['id_desa'];
                                        $nmdesa = ucwords(strtolower($sub['desa_kelurahan']));
                                        $koordinatdesa = $sub['lintang'] . "," . $sub['bujur'];

                                        echo " <li class='nav-item'>
                                        <a class='nav-link lv_desa' href='#' data-idkec='$idkec' data-id='$idsub' data-keterangan='desa' data-nama='$nmdesa' data-koordinat='$koordinatdesa' data-bs-toggle='' aria-expanded='false'>
                                            <div class='d-flex align-items-center'><span class='nav-link-text ps-1'>$nmdesa</span>
                                            </div>
                                        </a>
                                    </li>";
                                    }
                                    echo "</ul>";
                                }
                                mysqli_free_result($menuutama);
                                mysqli_free_result($submenu);
                                mysqli_close($dbconn);
                                ?>

                            </li>
                        </ul>
                    </div>
                </div>


            </nav>
            <div class="content">

                <nav class="navbar navbar-light navbar-glass navbar-top navbar-expand">

                    <button class="btn navbar-toggler-humburger-icon navbar-toggler me-1 me-sm-3" type="button" data-bs-toggle="collapse" data-bs-target="#navbarVerticalCollapse" aria-controls="navbarVerticalCollapse" aria-expanded="false" aria-label="Toggle Navigation"><span class="navbar-toggle-icon"><span class="toggle-line"></span></span></button>
                    <ul class="navbar-nav align-items-center d-none d-lg-block">

                        <li class="nav-item">
                            <div class="search-box" data-list='{"valueNames":["title"]}'>
                                <input class="form-control search-input fuzzy-search" id="txtcarilokasi" type="text" placeholder="Search..." aria-label="Search" autocomplete="off" />
                                <span class="fas fa-search search-box-icon"></span>
                                <div class="btn-close-falcon-container position-absolute end-0 top-50 translate-middle shadow-none" data-bs-dismiss="search">
                                    <div class="btn-close-falcon" aria-label="Close"></div>
                                </div>
                            </div>
                        </li>
                    </ul>

                    <ul class="navbar-nav navbar-nav-icons ms-auto flex-row align-items-center">

                        <li class="nav-item dropdown">
                            <a class="nav-link notification-indicator notification-indicator-<?php echo $warnaupload ?> px-0 fa-icon-wait" id="nav-mode-upload" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" data-hide-on-body-scroll="data-hide-on-body-scroll"><span class="fas fa-camera" data-fa-transform="shrink-7" style="font-size: 33px;"></span></a>
                            <div class="dropdown-menu dropdown-caret dropdown-caret dropdown-menu-end py-0" aria-labelledby="nav-mode-upload">
                                <div class="bg-white dark__bg-1000 rounded-2 py-2">
                                    <a class="dropdown-item fw-semi-bold text-warning" href="#!"><span class="fas fa-cog me-2"></span><span>Mode upload</span></a>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item" role="button" data-mode="ON" href="#" id="btnModeUploadON" style="<?php echo $hiddenON ?>"><span>Hidupkan</span></a>
                                    <a class="dropdown-item" role="button" data-mode="OFF" href="#" id="btnModeUploadOFF" style="<?php echo $hiddenOFF ?>"><span>Matikan</span></a>
                                </div>
                            </div>
                        </li>

                        <li class="nav-item dropdown"><a class="nav-link pe-0 ps-2" id="navbarDropdownUser" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <div class="avatar avatar-xl">
                                    <img class="rounded-circle" src="../assets/img/team/avatar.png" alt="" />
                                </div>
                            </a>
                            <div class="dropdown-menu dropdown-caret dropdown-caret dropdown-menu-end py-0" aria-labelledby="navbarDropdownUser">
                                <div class="bg-white dark__bg-1000 rounded-2 py-2">
                                    <a class="dropdown-item" href="#" id="cmdGantiPassword">Ganti password</a>
                                    <a class="dropdown-item" href="logout.html">Logout</a>
                                </div>
                            </div>
                        </li>
                    </ul>
                </nav>

                <div class="card mb-3" id="area-peta">
                    <div class="card-header">
                        <div class="row flex-between-center">
                            <div class="col-auto">
                                <h6 class="mb-0">Peta Sebaran Sekolah <span id="lblkoppeta"></span></h6>
                            </div>
                        </div>
                    </div>
                    <div class="card-body bg-light">
                        <div class="tab-content">
                            <div class="tab-pane preview-tab-pane active" role="tabpanel" aria-labelledby="tab-dom-f7aa201b-9e09-4fdd-8fc3-b97550edbb34" id="dom-f7aa201b-9e09-4fdd-8fc3-b97550edbb34">
                                <div id="map" style="height:68vh"></div>
                            </div>
                            <div class="tab-pane code-tab-pane" role="tabpanel" aria-labelledby="tab-dom-86ce401a-9300-4880-8a1e-b4a081710f6c" id="dom-86ce401a-9300-4880-8a1e-b4a081710f6c">
                                <pre class="scrollbar rounded-1" style="max-height:420px"><code class="language-html">&lt;div id=&quot;map&quot; style=&quot;height:300px&quot;&gt;&lt;/div&gt;</code></pre>
                            </div>
                        </div>
                    </div>
                </div>

                <div id="area-halaman-utama">

                    <div class="row mb-3 g-3">
                        <div class="col-lg-6 ps-lg-2">
                            <div class="card bg-line-chart-gradient h-lg-100">
                                <div class="card-body text-white d-flex flex-column justify-content-between h-100 pe-3">
                                    <div class="col light">
                                        <p class="fs--1 fw-semi-bold">Grafik Jumlah Sekolah <span id="lblkopgrafik1"></span></p>
                                    </div>
                                    <div class="chart h-100" id="hitungUmurChart" data-echart-responsive="true">
                                        <canvas id="umurChart"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-6 ps-lg-2">
                            <div class="card bg-line-chart-gradient h-lg-100">
                                <div class="card-body text-white d-flex flex-column justify-content-between h-100 pe-3">
                                    <div class="col light">
                                        <p class="fs--1 fw-semi-bold">Grafik Status Sekolah <span id="lblkopgrafik2"></span></p>
                                    </div>
                                    <div class="chart h-100" id="hitungChartContentADMIN" data-echart-responsive="true">
                                        <canvas id="hitungChartADMIN"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-3 g-3">
                        <div class="col-xxl-6 px-xxl-2">
                            <div class="card bg-line-chart-gradient h-lg-100">
                                <div class="card-body text-white d-flex flex-column justify-content-between h-100 pe-3">
                                    <div class="col light">
                                        <p class="fs--1 fw-semi-bold">Grafik Status Akreditasi Sekolah <span id="lblkopgrafik4"></span></p>
                                    </div>
                                    <div class="chart h-100" id="hitungChartContentAkreditasi" data-echart-responsive="true">
                                        <canvas id="hitungChartAkreditasi" height="300px"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-3 g-3">
                        <div class="col-xxl-6 px-xxl-2">
                            <div class="card bg-line-chart-gradient h-lg-100">
                                <div class="card-body text-white d-flex flex-column justify-content-between h-100 pe-3">
                                    <div class="col light">
                                        <p class="fs--1 fw-semi-bold">Grafik Perbandingan Jumlah Guru Dengan Jumlah
                                            Siswa <span id="lblkopgrafik3"></span></p>
                                    </div>
                                    <div class="chart h-100" id="hitungChartContentGuru" data-echart-responsive="true">
                                        <canvas id="hitungChartGuru" height="300px"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-3 g-3">
                        <div class="col">
                            <div class="card h-100">
                                <div class="card-header d-flex flex-between-center">
                                    <h6 class="mb-0">Statistik Kondisi Ruang Sekolah</h6>
                                </div>
                                <div class="card-body bg-light pt-0">
                                    <div class="row mt-3 mb-2">
                                        <div class="col-6 border-end border-200">
                                            <h4 class="mb-0" id="lbljumsekolahSarana"></h4>
                                            <p class="fs--1 text-600 mb-0">Jumlah Sekolah</p>
                                        </div>
                                        <div class="col-6 border-end border-200">
                                            <h4 class="mb-0" id="lbljumruangSarana"></h4>
                                            <p class="fs--1 text-600 mb-0">Jumlah Ruang</p>
                                        </div>
                                    </div>
                                    <h6 class="fs--1 mb-3 mt-3">Prosentase</h6>
                                    <div class="overflow-visible progress mt-4 mb-2 rounded-3" id="areastatistikSarana" style="height: 6px;">
                                    </div>

                                    <div class="row g-4">
                                        <div class="col-sm-3 col-md-3">
                                            <div class="d-flex position-relative">
                                                <div class="icon-item icon-item-sm border rounded-3 shadow-none me-2">
                                                    <span class="fas fa-check text-primary"></span>
                                                </div>
                                                <div class="flex-1">
                                                    <a class="stretched-link" id="cmdTampilBaik" href="#!">
                                                        <h6 class="text-800 mb-0">Baik</h6>
                                                    </a>
                                                    <p class="mb-0 fs--2 text-500">Sekolah kondisi baik</p>
                                                </div>
                                            </div>
                                            <div class="col-auto mt-2 mb-0">
                                                <button class="btn btn-sm btn-primary w-100 fs--1" type="button" id="cmdExcelBaik"><span class="fas fa-file-excel me-2"></span>Download Data</button>
                                            </div>
                                        </div>
                                        <div class="col-sm-3 col-md-3">
                                            <div class="d-flex position-relative">
                                                <div class="icon-item icon-item-sm border rounded-3 shadow-none me-2">
                                                    <span class="fas fa-bell text-success"></span>
                                                </div>
                                                <div class="flex-1"><a class="stretched-link" id="cmdTampilRingan" href="#!">
                                                        <h6 class="text-800 mb-0">Rusak Ringan</h6>
                                                    </a>
                                                    <p class="mb-0 fs--2 text-500">Sekolah kondisi rusak ringan</p>
                                                </div>
                                            </div>
                                            <div class="col-auto mt-2 mb-0">
                                                <button class="btn btn-sm btn-success w-100 fs--1" type="button" id="cmdExcelRingan"><span class="fas fa-file-excel me-2"></span>Download Data</button>
                                            </div>
                                        </div>
                                        <div class="col-sm-3 col-md-3">
                                            <div class="d-flex position-relative">
                                                <div class="icon-item icon-item-sm border rounded-3 shadow-none me-2">
                                                    <span class="fas fa-ban text-warning"></span>
                                                </div>
                                                <div class="flex-1"><a class="stretched-link" id="cmdTampilSedang" href="#!">
                                                        <h6 class="text-800 mb-0">Rusak Sedang</h6>
                                                    </a>
                                                    <p class="mb-0 fs--2 text-500">Sekolah kondisi rusak sedang</p>
                                                </div>
                                            </div>
                                            <div class="col-auto mt-2 mb-0">
                                                <button class="btn btn-sm btn-warning w-100 fs--1" type="button" id="cmdExcelSedang"><span class="fas fa-file-excel me-2"></span>Download Data</button>
                                            </div>
                                        </div>
                                        <div class="col-sm-3 col-md-3">
                                            <div class="d-flex position-relative">
                                                <div class="icon-item icon-item-sm border rounded-3 shadow-none me-2">
                                                    <span class="fas fa-power-off text-danger"></span>
                                                </div>
                                                <div class="flex-1"><a class="stretched-link" id="cmdTampilBerat" href="#!">
                                                        <h6 class="text-800 mb-0">Rusak Berat</h6>
                                                    </a>
                                                    <p class="mb-0 fs--2 text-500">Sekolah kondisi rusak berat</p>
                                                </div>
                                            </div>
                                            <div class="col-auto mt-2 mb-0">
                                                <button class="btn btn-sm btn-danger w-100 fs--1" type="button" id="cmdExcelBerat"><span class="fas fa-file-excel me-2"></span>Download Data</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-3 g-3">
                        <div class="col">
                            <div class="card h-lg-100 overflow-hidden mb-3">
                                <div class="card-header">
                                    <h6 class="mb-0">Detail Kondisi Ruang Sekolah</h6>
                                </div>
                                <div class="card-body p-0">
                                    <div class="table-responsive scrollbar">
                                        <table class="table table-dashboard mb-0 table-borderless fs--1 border-200">
                                            <thead class="bg-light">
                                                <tr class="text-900">
                                                    <th>Nama Ruang</th>
                                                    <th class="text-center">Jumlah</th>
                                                    <th>Kondisi Baik</th>
                                                    <th>Rusak Ringan</th>
                                                    <th>Rusak Sedang</th>
                                                    <th>Rusak Berat</th>
                                                </tr>
                                            </thead>
                                            <tbody id="list-data-sarana">
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>



                </div><!--halaman-->

                <!--halaman sekolah-->
                <div id="area-halaman-sekolah" style="display:none;">

                    <!----------------- DETAIL SEKOLAH ---------------->
                    <div id="hal-detail-sekolah"></div>

                    <!----------------- VIDEO ---------------->
                    <div class="row mb-3 g-3">
                        <div class="col">
                            <div class="card h-100">
                                <div class="card-header">
                                    <h6 class="mb-0">Video Sarana Sekolah</h6>
                                </div>
                                <div class="card-body bg-light overflow-hidden">
                                    <!--video class="player rounded-3" controls crossorigin playsinline poster="" id="div-video"-->
                                    <video class="player rounded-3" controls crossorigin playsinline poster="" id="div-video"></video>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!----------------- KELAS ---------------->
                    <div class="row mb-3 g-3">
                        <div class="col">
                            <div class="card h-100">
                                <div class="card-header">
                                    <h6 class="mb-0">Foto Ruang Kelas</h6>
                                </div>
                                <div class="card-body bg-light overflow-hidden">
                                    <div class="row mx-n1" id="div-kelas"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!----------------- PERPUSTAKAN ---------------->
                    <div class="row mb-3 g-3">
                        <div class="col">
                            <div class="card h-100">
                                <div class="card-header">
                                    <h6 class="mb-0">Foto Ruang Perpustakaan</h6>
                                </div>
                                <div class="card-body bg-light overflow-hidden">
                                    <div class="row mx-n1" id="div-perpustakaan"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!----------------- kepsek ---------------->
                    <div class="row mb-3 g-3">
                        <div class="col">
                            <div class="card h-100">
                                <div class="card-header">
                                    <h6 class="mb-0">Foto Ruang Kepala Sekolah</h6>
                                </div>
                                <div class="card-body bg-light overflow-hidden">
                                    <div class="row mx-n1" id="div-kepsek"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!----------------- guru ---------------->
                    <div class="row mb-3 g-3">
                        <div class="col">
                            <div class="card h-100">
                                <div class="card-header">
                                    <h6 class="mb-0">Foto Ruang Guru</h6>
                                </div>
                                <div class="card-body bg-light overflow-hidden">
                                    <div class="row mx-n1" id="div-guru"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!----------------- pembinaan ---------------->
                    <div class="row mb-3 g-3">
                        <div class="col">
                            <div class="card h-100">
                                <div class="card-header">
                                    <h6 class="mb-0">Foto Ruang Pembinaan</h6>
                                </div>
                                <div class="card-body bg-light overflow-hidden">
                                    <div class="row mx-n1" id="div-pembinaan"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!----------------- multimedia ---------------->
                    <div class="row mb-3 g-3">
                        <div class="col">
                            <div class="card h-100">
                                <div class="card-header">
                                    <h6 class="mb-0">Foto Ruang Lab. Multimedia</h6>
                                </div>
                                <div class="card-body bg-light overflow-hidden">
                                    <div class="row mx-n1" id="div-multimedia"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!----------------- komputer ---------------->
                    <div class="row mb-3 g-3">
                        <div class="col">
                            <div class="card h-100">
                                <div class="card-header">
                                    <h6 class="mb-0">Foto Ruang Lab. Komputer</h6>
                                </div>
                                <div class="card-body bg-light overflow-hidden">
                                    <div class="row mx-n1" id="div-komputer"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!----------------- ips ---------------->
                    <div class="row mb-3 g-3">
                        <div class="col">
                            <div class="card h-100">
                                <div class="card-header">
                                    <h6 class="mb-0">Foto Ruang Lab. IPS</h6>
                                </div>
                                <div class="card-body bg-light overflow-hidden">
                                    <div class="row mx-n1" id="div-ips"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!----------------- ipa ---------------->
                    <div class="row mb-3 g-3">
                        <div class="col">
                            <div class="card h-100">
                                <div class="card-header">
                                    <h6 class="mb-0">Foto Ruang Lab.IPA</h6>
                                </div>
                                <div class="card-body bg-light overflow-hidden">
                                    <div class="row mx-n1" id="div-ipa"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!----------------- bahasa ---------------->
                    <div class="row mb-3 g-3">
                        <div class="col">
                            <div class="card h-100">
                                <div class="card-header">
                                    <h6 class="mb-0">Foto Ruang Lab. Bahasa</h6>
                                </div>
                                <div class="card-body bg-light overflow-hidden">
                                    <div class="row mx-n1" id="div-bahasa"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!----------------- wc umum ---------------->
                    <div class="row mb-3 g-3">
                        <div class="col">
                            <div class="card h-100">
                                <div class="card-header">
                                    <h6 class="mb-0">Foto Ruang WC Umum</h6>
                                </div>
                                <div class="card-body bg-light overflow-hidden">
                                    <div class="row mx-n1" id="div-wcumum"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!----------------- wc siswa ---------------->
                    <div class="row mb-3 g-3">
                        <div class="col">
                            <div class="card h-100">
                                <div class="card-header">
                                    <h6 class="mb-0">Foto Ruang WC Siswa</h6>
                                </div>
                                <div class="card-body bg-light overflow-hidden">
                                    <div class="row mx-n1" id="div-wcsiswa"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!----------------- wc guru ---------------->
                    <div class="row mb-3 g-3">
                        <div class="col">
                            <div class="card h-100">
                                <div class="card-header">
                                    <h6 class="mb-0">Foto Ruang WC Guru</h6>
                                </div>
                                <div class="card-body bg-light overflow-hidden">
                                    <div class="row mx-n1" id="div-wcguru"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!----------------- ibadah ---------------->
                    <div class="row mb-3 g-3">
                        <div class="col">
                            <div class="card h-100">
                                <div class="card-header">
                                    <h6 class="mb-0">Foto Ruang Ibadah</h6>
                                </div>
                                <div class="card-body bg-light overflow-hidden">
                                    <div class="row mx-n1" id="div-ibadah"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!----------------- asrama ---------------->
                    <div class="row mb-3 g-3">
                        <div class="col">
                            <div class="card h-100">
                                <div class="card-header">
                                    <h6 class="mb-0">Foto Asrama</h6>
                                </div>
                                <div class="card-body bg-light overflow-hidden">
                                    <div class="row mx-n1" id="div-asrama"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div><!--halaman sekolah-->

                <!---------------- tabel operator ------------------>
                <div class="col-xxl-12" id="area-halaman-operator" style="display:none">
                    <div class="row mb-3 g-3">
                        <div class="col-xxl-12">
                            <div class="card bg-light h-lg-100">
                                <div class="card-body d-flex align-items-center">
                                    <p class="fs--1 mt-0 mb-0">
                                        Tombol <strong>Tambah Administrator</strong> hanya untuk menambahkan administrator saja. Hak akses <strong>Administrator</strong><br />
                                        Penambahan data operator <strong>Sekolah</strong> otomatis bertambah ketika menambahkan data <strong>Sekolah</strong><br />
                                        Tombol <strong>Ikon Blokir, Ikon Edit, Ikon Hapus</strong> untuk memblokir, edit data dan hapus data <strong>Operator</strong>
                                    </p>

                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-3 g-3">
                        <div class="col-xxl-12">
                            <div class="card z-index-1 mb-3">
                                <div class="card-header">
                                    <div class="row flex-between-center g-0">
                                        <div class="col-auto">
                                            <h6 class="fs-0 mb-0">Data Operator</h6>
                                        </div>

                                        <div class="col-6 col-sm-auto ms-auto text-end ps-0">
                                            <div id="table-purchases-replace-element">
                                                <button class="btn btn-falcon-default btn-sm mx-2" type="button" id="cmdTambahOperator"><span class="d-none d-sm-inline-block ms-1">Tambah
                                                        Data</span></button>
                                                <button class="btn btn-falcon-default btn-sm" type="button" id="cmdRefreshOperator"><span class="d-none d-sm-inline-block ms-1">Refresh</span></button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body bg-light px-3 py-3">
                                    <div class="table-responsive scrollbar">
                                        <table id="tabelOperatorAdm" class="table table-sm table-striped mb-0 fs--1 w-100">
                                            <thead class="bg-200">
                                                <tr>
                                                    <th class="sort text-center">No.</th>
                                                    <th class="sort text-center">Username</th>
                                                    <th class="sort text-center">Instansi</th>
                                                    <th class="sort text-center">Hak Akses</th>
                                                    <th class="sort text-center">Status</th>
                                                    <th class="sort text-center">Url</th>
                                                    <th class="sort text-center"></th>
                                                    <th class="sort text-center"></th>
                                                    <th class="sort text-center"></th>
                                                </tr>
                                            </thead>
                                            <tbody class="bg-white" id="isitabelOperatorAdm" />
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div><!---------------- akhir operator ------------------>

                <!---------------- tabel media ------------------>
                <div class="col-xxl-12" id="area-halaman-media" style="display:none">
                    <div class="row mb-3 g-3">
                        <div class="col-xxl-12">
                            <div class="card bg-light h-lg-100">
                                <div class="card-body d-flex align-items-center">
                                    <p class="fs--1 mt-0 mb-0">
                                        Tombol Ikon &nbsp;<i class="fa fa-camera"></i> &nbsp;untuk menampilkan detail data sekolah
                                    </p>

                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-3 g-3">
                        <div class="col-xxl-12">
                            <div class="card z-index-1 mb-3">
                                <div class="card-header">
                                    <div class="row flex-between-center g-0">
                                        <div class="col-auto">
                                            <h6 class="fs-0 mb-0">Data Media</h6>
                                        </div>

                                        <div class="col-6 col-sm-auto ms-auto text-end ps-0">
                                            <div id="table-purchases-replace-element">
                                                <table>
                                                    <tr>
                                                        <td width="160px">
                                                            <select class="form-select js-choice px-3 fs--1" id="cbofiltermedia" size="1" required="required" data-options='{"removeItemButton":true,"placeholder":true}'>
                                                                <option value="semua">Semua Data</option>
                                                                <option value="Y">Sudah Upload</option>
                                                                <option value="N">Belum Upload</option>
                                                            </select>
                                                        </td>
                                                        <td>&nbsp;</td>
                                                        <td>
                                                            <button class="btn btn-falcon-default btn-sm me-1" type="button" id="cmdRefreshMedia"><span class="d-none d-sm-inline-block ms-1">Refresh</span></button>

                                                            <button class="btn btn-falcon-default btn-sm" type="button" id="cmdExcelMedia"><span class="d-none d-sm-inline-block ms-1">Export</span></button>
                                                        </td>
                                                    </tr>
                                                </table>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body bg-light px-3 py-3">
                                    <div class="table-responsive scrollbar">
                                        <table id="tabelMediaAdm" class="table table-sm table-striped display nowrap mb-0 fs--1" style="width:100%">
                                            <thead class="bg-200">
                                                <tr>
                                                    <th class="sort text-center">NPSN</th>
                                                    <th class="sort text-center">Instansi</th>
                                                    <th class="sort text-center"></th>
                                                    <th class="sort text-center">Video</th>
                                                    <th class="sort text-center">Kelas</th>
                                                    <th class="sort text-center">Perpus</th>
                                                    <th class="sort text-center">Kepsek</th>
                                                    <th class="sort text-center">Guru</th>
                                                    <th class="sort text-center">Bina</th>
                                                    <th class="sort text-center">MM</th>
                                                    <th class="sort text-center">Komp</th>
                                                    <th class="sort text-center">IPS</th>
                                                    <th class="sort text-center">IPA</th>
                                                    <th class="sort text-center">Bhs</th>
                                                    <th class="sort text-center">WC Umum</th>
                                                    <th class="sort text-center">Wc Siswa</th>
                                                    <th class="sort text-center">Wc Guru</th>
                                                    <th class="sort text-center">Ibadah</th>
                                                    <th class="sort text-center">Asrama</th>
                                                    <th class="sort text-center">Jumlah</th>
                                                </tr>
                                            </thead>
                                            <tbody class="bg-white" id="isitabelMediaAdm" />
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div><!---------------- akhir sinkron media ------------------>

                <!---------------- tabel pupr ------------------>
                <div class="col-xxl-12" id="area-halaman-pupr" style="display:none">
                    <div class="row mb-3 g-3">
                        <div class="col-xxl-12">
                            <div class="card bg-light h-lg-100">
                                <div class="card-body d-flex align-items-center">
                                    <p class="fs--1 mt-0 mb-0">
                                        Tombol Ikon &nbsp;<i class="fa fa-camera"></i> &nbsp;untuk menampilkan detail media data sekolah (video dan foto ruangan), Tombol Status (Disetujui) &nbsp;untuk menampilkan data <strong>Form Persetujuan</strong>
                                    </p>

                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-3 g-3">
                        <div class="col-xxl-12">
                            <div class="card z-index-1 mb-3">
                                <div class="card-header">
                                    <div class="row flex-between-center g-0">
                                        <div class="col-auto">
                                            <h6 class="fs-0 mb-0">Laporan Persetujuan PUPR</h6>
                                        </div>

                                        <div class="col-6 col-sm-auto ms-auto text-end ps-0">
                                            <div id="table-purchases-replace-element">
                                                <table>
                                                    <tr>
                                                        <td width="210px">
                                                            <select class="form-select js-choice px-3 fs--1" id="cbofilterpupr" size="1" required="required" data-options='{"removeItemButton":true,"placeholder":true}'>
                                                                <option value="semua">Semua Data</option>
                                                                <option value="baik">Kondisi Baik</option>
                                                                <option value="ringan">Kondisi Rusak Ringan</option>
                                                                <option value="sedang">Kondisi Rusak Sedang</option>
                                                                <option value="berat">Kondisi Rusak Berat</option>
                                                            </select>
                                                        </td>
                                                        <td>&nbsp;</td>
                                                        <td>
                                                            <button class="btn btn-falcon-default btn-sm me-1" type="button" id="cmdRefreshPUPR"><span class="d-none d-sm-inline-block ms-1">Refresh</span></button>
                                                        </td>
                                                    </tr>
                                                </table>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body bg-light px-3 py-3">
                                    <div class="table-responsive scrollbar">
                                        <table id="tabelPUPRAdm" class="table table-sm table-striped display nowrap mb-0 fs--1" style="width:100%">
                                            <thead class="bg-200">
                                                <tr>
                                                    <th class="sort text-center">NPSN</th>
                                                    <th class="sort text-center">Instansi</th>
                                                    <th class="sort text-center"></th>
                                                    <th class="sort text-center">Status</th>
                                                    <th class="sort text-center">Jumlah</th>
                                                    <th class="sort text-center">Kelas</th>
                                                    <th class="sort text-center">Perpus</th>
                                                    <th class="sort text-center">Kepsek</th>
                                                    <th class="sort text-center">Guru</th>
                                                    <th class="sort text-center">Bina</th>
                                                    <th class="sort text-center">MM</th>
                                                    <th class="sort text-center">Komp</th>
                                                    <th class="sort text-center">IPS</th>
                                                    <th class="sort text-center">IPA</th>
                                                    <th class="sort text-center">Bhs</th>
                                                    <th class="sort text-center">WC Umum</th>
                                                    <th class="sort text-center">Wc Siswa</th>
                                                    <th class="sort text-center">Wc Guru</th>
                                                    <th class="sort text-center">Ibadah</th>
                                                    <th class="sort text-center">Asrama</th>
                                                </tr>
                                            </thead>
                                            <tbody class="bg-white" id="isitabelPUPRAdm" />
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div><!---------------- akhir PUPR ------------------>


            </div><!--content-->

            <?php
            include "modal.php";
            ?>

        </div><!--container-->
    </main>

    <script src="../vendors/bootstrap/bootstrap.min.js"></script>
    <script src="../vendors/anchorjs/anchor.min.js"></script>

    <script src="../vendors/fontawesome/all.min.js"></script>
    <script src="../vendors/lodash/lodash.min.js"></script>

    <script src="../vendors/jquery/jquery.min.js"></script>

    <script src="../assets/lib/datatables/js/jquery.dataTables.min.js"></script>
    <script src="../assets/lib/datatables-bs4/dataTables.bootstrap4.min.js"></script>
    <script src="../assets/lib/datatables.net-responsive/dataTables.responsive.js"></script>
    <script src="../assets/lib/datatables.net-responsive-bs4/responsive.bootstrap4.js"></script>

    <script src="../vendors/glightbox/glightbox.min.js"></script>
    <script src="../vendors/plyr/plyr.polyfilled.min.js"></script>
    <script src="../vendors/dropzone/dropzone.min.js"></script>

    <script src="../assets/js/theme.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@0.7.0"></script>

    <script type="text/javascript" src="https://cdn.jsdelivr.net/gh/hosuaby/Leaflet.SmoothMarkerBouncing@v2.0.0/dist/bundle.js" crossorigin="anonymous"></script>

    <script src="dashboard.js"></script>
    <script src="master.js"></script>
    <script src="komentar.js"></script>

    <script type="text/javascript" charset="utf-8">
        $(document).ready(function() {
            setTimeout(function() {
                document.body.style.cursor = "default";
                bersihkan();

                $("#lblnavjmloperator").html("0"); // nav jumlah operator
                ambilJumlahOperator()

                $("#lblnavjmlpengaduan").html("0"); // nav jumlah operator
                ambilJumlahPengaduan()

                $("#area-halaman-operator").fadeOut("slow");
                $("#area-halaman-pupr").fadeOut("slow");
                $("#area-halaman-sekolah").fadeOut("slow");
                $("#area-halaman-utama").fadeIn();
                $("#area-peta").fadeIn();

                $("#txttransketerangan").val("kota");
                var nmwilayah = "Kabupaten Jember";
                $("#lblkoppeta").text(nmwilayah);
                $("#lblkopgrafik1").text(nmwilayah);
                $("#lblkopgrafik2").text(nmwilayah);
                $("#lblkopgrafik3").text(nmwilayah);
                $("#lblkopgrafik4").text(nmwilayah);

                hitungGrafikTotalSekolah();
                isiGrafikStatus();
                isiGrafikAkreditasi();
                isiDataSarana();
                isiGrafikBandingGuruSiswa();

                $("#lblhalaman").val("dashboard");
                $("#loading").fadeOut("slow");
            }, 1000);

        });

        $("#lv_survei_ats").on("click", function() {
            window.open("../ats/dashboard.html", "_self")
        });
    </script>

</body>

</html>