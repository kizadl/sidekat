<?php
error_reporting(0);
session_start();

if ($_SESSION['AKSES'] == "operator") {
    $iduser = $_SESSION['IDOPERATOR'];
    $username = $_SESSION['USERNAME'];
    $nmoperator = $_SESSION['NMOPERATOR'];
    $akses = $_SESSION['AKSES'];
    $idinstansi = $_SESSION['IDINSTANSI'];
} else {
    header('location:../home.html');
}

require_once '../services/config.php';
$dbconn = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname) or die('Could not connect: ');

include "../services/tgl_indo.php";
date_default_timezone_set('Asia/Jakarta');
$tglserver = date('Y-m-d');

$editor = $iduser;

$qricbg = ("SELECT p.npsn,p.nama,p.lintang,p.bujur,p.stts_upload,q.id_sekolah FROM tbl_api_dispendik p  
        LEFT JOIN spm_sekolah q ON p.npsn=q.npsn WHERE p.id='" . $idinstansi . "'");
$dbcabang = mysqli_query($dbconn, $qricbg);
$c = mysqli_fetch_assoc($dbcabang);

$idsekolah = $c['id_sekolah'];
$npsn = $c['npsn'];
$lintang = $c['lintang'];
$bujur = $c['bujur'];
$nmcabang = ucwords(strtolower($c['nama']));
$sttsupload = $c['stts_upload'];
if ($sttsupload == "on") {
    $warnaupload = "primary";
    $hiddenON = "display:none";
    $hiddenOFF = "";
    $disupload = "";
} else if ($sttsupload == "off") {
    $warnaupload = "warning";
    $hiddenON = "";
    $hiddenOFF = "display:none";
    $disupload = "disabled";
}

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

    <!-- ===============================================-->
    <!--    Document Title-->
    <!-- ===============================================-->
    <title>My Dispendik | Dinas Pendidikan</title>


    <!-- ===============================================-->
    <!--    Favicons-->
    <!-- ===============================================-->
    <link href="favicon.png" rel="icon" />
    <link href="favicon.png" rel="apple-touch-icon" />
    <link rel="manifest" href="../assets/img/favicons/manifest.json">
    <meta name="msapplication-TileImage" content="../assets/img/favicons/mstile-150x150.png">
    <meta name="theme-color" content="#ffffff">
    <script src="../assets/js/config.js"></script>
    <script src="../vendors/overlayscrollbars/OverlayScrollbars.min.js"></script>


    <!-- ===============================================-->
    <!--    Stylesheets-->
    <!-- ===============================================-->
    <link href="../vendors/flatpickr/flatpickr.min.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,500,600,700%7cPoppins:300,400,500,600,700,800,900&amp;display=swap" rel="stylesheet">

    <link href="../vendors/overlayscrollbars/OverlayScrollbars.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../vendors/select2/css/select2.min.css">

    <link href="../assets/lib/select2/select2.min.css" rel="stylesheet">
    <link href="../assets/lib/select2-theme/select2-bootstrap4.min.css" rel="stylesheet">
    <link href="../vendors/select2-bootstrap4-theme/select2-bootstrap4.min.css" rel="stylesheet">

    <link href="../vendors/datatables-bs4/dataTables.bootstrap4.min.css" rel="stylesheet">
    <link href="../vendors/datatables.net-responsive-bs4/responsive.bootstrap4.css" rel="stylesheet">

    <link href="../vendors/glightbox/glightbox.min.css" rel="stylesheet" />
    <link href="../vendors/plyr/plyr.css" rel="stylesheet" />
    <link href="../vendors/dropzone/dropzone.min.css" rel="stylesheet">

    <link href="../assets/css/theme.min.css" rel="stylesheet" id="style-default">

    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/leaflet/1.8.0/leaflet.css" />
    <script src="//cdnjs.cloudflare.com/ajax/libs/leaflet/1.8.0/leaflet.js"></script>

    <script src="https://unpkg.com/leaflet-routing-machine@latest/dist/leaflet-routing-machine.js" crossorigin="anonymous"></script>

    <style>
        .leaflet-control-container .leaflet-routing-container-hide {
            display: none;
        }
    </style>

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
        <input type="text" id="lblidsekolah" value="<?php echo $idsekolah; ?>" readonly="readonly" />
        <input type="text" id="llnpsnsekolah" value="<?php echo $npsn; ?>" readonly="readonly" />
        <input type="text" id="lblstatusupload" value="<?php echo $sttsupload; ?>" readonly="readonly" />

        <input type="text" id="lbllatitude" value="<?php echo $lintang; ?>" readonly="readonly" />
        <input type="text" id="lbllongitude" value="<?php echo $bujur; ?>" readonly="readonly" />

        <input type="text" id="txttransid" value="" readonly="readonly" />
        <input type="text" id="txttransketerangan" value="" readonly="readonly" />
        <input type="text" id="txttransnmwilayah" value="" readonly="readonly" />

        <input type="text" id="txttransiddetailsekolah" value="" readonly="readonly" />

    </div>

    <!-- ===============================================-->
    <!--    Main Content-->
    <!-- ===============================================-->
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
                                <a class="nav-link active" id="lv_kota" data-nama="Kabupaten Jember" data-keterangan="kota" data-koordinat="-8.264371593833262, 113.6321026467762" href="#" role="button" data-bs-toggle="collapse" aria-expanded="false">
                                    <div class="d-flex align-items-center"><span class="nav-link-icon"><span class="fas fa-chart-pie"></span></span><span class="nav-link-text ps-1">Dashboard</span>
                                    </div>
                                </a>
                            </li>

                            <li class="nav-item">
                                <!-- label-->
                                <div class="row navbar-vertical-label-wrapper mt-3 mb-2">
                                    <div class="col-auto navbar-vertical-label">Profil Media
                                    </div>
                                    <div class="col ps-0">
                                        <hr class="mb-0 navbar-vertical-divider" />
                                    </div>
                                </div>
                                <a class="nav-link" id="lv_profil" href="#" role="button" data-bs-toggle="" aria-expanded="false">
                                    <div class="d-flex align-items-center"><span class="nav-link-icon"><span class="fas fa-university"></span></span><span class="nav-link-text ps-1">Profil Media</span>
                                    </div>
                                </a>

                                <a class="nav-link" id="lv_kegiatan" href="#" role="button" data-bs-toggle="" aria-expanded="false">
                                    <div class="d-flex align-items-center"><span class="nav-link-icon"><span class="fas fa-chalkboard-teacher"></span></span><span class="nav-link-text ps-1">Kegiatan Sekolah</span>
                                    </div>
                                </a>
                            </li>

                            <li class="nav-item">
                                <!-- label-->
                                <div class="row navbar-vertical-label-wrapper mt-3 mb-2">
                                    <div class="col-auto navbar-vertical-label">Update Data
                                    </div>
                                    <div class="col ps-0">
                                        <hr class="mb-0 navbar-vertical-divider" />
                                    </div>
                                </div>
                                <a class="nav-link" id="lv_input_profil" href="#" role="button" data-bs-toggle="" aria-expanded="false">
                                    <div class="d-flex align-items-center"><span class="nav-link-icon"><span class="fas fa-user-graduate"></span></span><span class="nav-link-text ps-1">Update Profil</span>
                                    </div>
                                </a>
                                <a class="nav-link" id="lv_input_sarana" href="#" role="button" data-bs-toggle="" aria-expanded="false">
                                    <div class="d-flex align-items-center"><span class="nav-link-icon"><span class="fas fa-table"></span></span><span class="nav-link-text ps-1">Update Prasarana</span>
                                    </div>
                                </a>
                                <a class="nav-link" id="lv_upload_video" href="#" role="button" data-bs-toggle="" aria-expanded="false">
                                    <div class="d-flex align-items-center"><span class="nav-link-icon"><span class="fas fa-video"></span></span><span class="nav-link-text ps-1">Upload Video</span>
                                    </div>
                                </a>
                                <a class="nav-link" id="lv_upload_foto" href="#" role="button" data-bs-toggle="" aria-expanded="false">
                                    <div class="d-flex align-items-center"><span class="nav-link-icon"><span class="fas fa-camera"></span></span><span class="nav-link-text ps-1">Upload Foto Ruangan</span>
                                    </div>
                                </a>
                            </li>

                            <li class="nav-item">
                                <div class="row navbar-vertical-label-wrapper mt-3 mb-2">
                                    <div class="col-auto navbar-vertical-label">Data Kepegawaian
                                    </div>
                                    <div class="col ps-0">
                                        <hr class="mb-0 navbar-vertical-divider" />
                                    </div>
                                </div>
                                <a class="nav-link" id="lv_ptk" href="#" role="button" data-bs-toggle="" aria-expanded="false">
                                    <div class="d-flex align-items-center"><span class="nav-link-icon"><span class="fas fa-users"></span></span><span class="nav-link-text ps-1">Data PTK</span>
                                    </div>
                                </a>
                            </li>

                            <li class="nav-item">
                                <div class="row navbar-vertical-label-wrapper mt-3 mb-2">
                                    <div class="col-auto navbar-vertical-label">Master Data
                                    </div>
                                    <div class="col ps-0">
                                        <hr class="mb-0 navbar-vertical-divider" />
                                    </div>
                                </div>
                                <a class="nav-link" id="lv_operator" href="#" role="button" data-bs-toggle="" aria-expanded="false">
                                    <div class="d-flex align-items-center"><span class="nav-link-icon"><span class="fas fa-user"></span></span><span class="nav-link-text ps-1">Profil Operator</span>
                                    </div>
                                </a>
                                <a class="nav-link" id="lv_download_tutorial" href="#" role="button" data-bs-toggle="" aria-expanded="false">
                                    <div class="d-flex align-items-center"><span class="nav-link-icon"><span class="fas fa-file-archive"></span></span><span class="nav-link-text ps-1">Download Tutorial</span>
                                    </div>
                                </a>
                            </li>

                        </ul>
                    </div>
                </div>


            </nav>
            <div class="content">

                <nav class="navbar navbar-light navbar-glass navbar-top navbar-expand">

                    <button class="btn navbar-toggler-humburger-icon navbar-toggler me-1 me-sm-3" type="button" data-bs-toggle="collapse" data-bs-target="#navbarVerticalCollapse" aria-controls="navbarVerticalCollapse" aria-expanded="false" aria-label="Toggle Navigation"><span class="navbar-toggle-icon"><span class="toggle-line"></span></span></button>
                    <ul class="navbar-nav navbar-nav-icons ms-auto flex-row align-items-center">

                        <li class="nav-item dropdown">
                            <a class="nav-link notification-indicator notification-indicator-<?php echo $warnaupload ?> px-0 fa-icon-wait" id="nav-mode-upload" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" data-hide-on-body-scroll="data-hide-on-body-scroll"><span class="fas fa-camera" data-fa-transform="shrink-7" style="font-size: 33px;"></span></a>
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

                <div id="area-halaman-utama">

                    <div class="card mb-3">
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

                    <div id="hal-detail-sekolah"></div>

                </div>
                <!--halaman-->

                <!---------------- halaman kegiatan ------------------>
                <div class="col-xxl-12" id="area-halaman-kegiatan" style="display:none">

                    <div class="row mb-3 g-3">
                        <div class="col-xxl-12">
                            <div class="card bg-primary text-white h-lg-100">
                                <div class="card-body d-flex align-items-center">
                                    <p class="fs--1 mt-0 mb-0">
                                        Tentukan <strong>Filter Data Kegiatan</strong> terlebih dahulu,
                                        Tekan tombol <strong>Refresh</strong> untuk menampilkan data,<br>
                                        <strong>Kolom Head</strong> untuk identifikasi <strong>Headline Kegiatan (Ditampilkan di halaman utama MyDispendik)</strong>,<br>
                                        Tombol &nbsp;&nbsp;<span class="fas fa-upload"></span> &nbsp;&nbsp;<strong>(Ikon upload)</strong> untuk upload foto,
                                        Tombol &nbsp;&nbsp;<span class="fas fa-edit"></span> &nbsp;&nbsp;<strong>(Ikon edit)</strong> untuk edit data,
                                        Tombol &nbsp;&nbsp;<span class="fas fa-trash-alt"></span> &nbsp;&nbsp;<strong>(Ikon hapus)</strong> untuk menghapus data <strong>Kegiatan Sekolah</strong>,
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
                                            <h6 class="fs-0 mb-0">Media Kegiatan Sekolah</h6>
                                        </div>

                                        <div class="col-6 col-sm-auto ms-auto text-end ps-0">
                                            <div id="table-purchases-replace-element">
                                                <table>
                                                    <tr>
                                                        <td width="280px">
                                                            <select class="form-select js-choice px-3 fs--1" id="cbofilterkegiatan" size="1" required="required" data-options='{"removeItemButton":true,"placeholder":true}'>
                                                                <option value="semua">Semua Data Kegiatan</option>
                                                                <option value="bulan">April 2024</option>
                                                                <option value="tahun">Tahun 2024</option>
                                                            </select>
                                                        </td>
                                                        <td>&nbsp;</td>
                                                        <td>
                                                            <button class="btn btn-falcon-default btn-sm me-1" type="button" id="cmdRefreshKegiatan"><span class="d-none d-sm-inline-block ms-1">Refresh</span></button>
                                                            <button class="btn btn-falcon-default btn-sm" type="button" id="cmdTambahKegiatan"><span class="d-none d-sm-inline-block ms-1">Tambah Data</span></button>
                                                        </td>
                                                    </tr>
                                                </table>

                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="card-body bg-light px-3 py-3">
                                    <div class="table-responsive scrollbar">
                                        <table id="tabelKegiatan" class="table table-sm table-striped mb-0 fs--1 w-100">
                                            <thead class="bg-200">
                                                <tr>
                                                    <th class="sort text-center"></th>
                                                    <th class="sort">Nama Kegiatan</th>
                                                    <th class="sort">Keterangan Kegiatan</th>
                                                    <th class="sort">Head</th>
                                                    <th class="sort text-center"></th>
                                                    <th class="sort text-center"></th>
                                                    <th class="sort text-center"></th>
                                                </tr>
                                            </thead>
                                            <tbody class="bg-white" id="isitabelKegiatan" />
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

                <!--halaman sekolah-->
                <div id="area-halaman-sekolah" style="display:none;">

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

                </div>
                <!--halaman sekolah-->

                <div id="area-upload-video" style="display:none;">
                    <!-- MULTIPLE UPLOAD ---->
                    <div class="row mb-3 g-3">
                        <div class="col">
                            <div class="card mb-3">
                                <div class="card-header">
                                    <h6 class="mb-0">Upload Video Sekolah</h6>
                                </div>
                                <div class="card-body bg-light">
                                    <div id="dropzonevideo" class="dropzone"></div>
                                    <center>
                                        <button class="btn btn-falcon-default btn-sm me-2" id="cmdAksiVideo">Tampilkan File</button>
                                        <button class="btn btn-falcon-default btn-sm" id="cmdVideo" <?php echo $disupload ?>>Upload File Video</button>
                                    </center>
                                </div>
                            </div>
                        </div>
                    </div>
                </div><!--halaman upload video-->

                <div id="area-upload-foto" style="display:none;">
                    <!-- MULTIPLE UPLOAD ---->
                    <div class="row mb-3 g-3">
                        <div class="col">
                            <div class="card mb-3">
                                <div class="card-header">
                                    <h6 class="mb-0">Upload Foto Ruang Kelas</h6>
                                </div>
                                <div class="card-body bg-light">
                                    <div id="dropzonefotokelas" class="dropzone"></div>
                                    <center>
                                        <button class="btn btn-falcon-default btn-sm me-2 btnAksiFoto" data-ruang="kelas">Tampilkan File</button>
                                        <button class="btn btn-falcon-default btn-sm" id="cmdFotoKelas" <?php echo $disupload ?>>Upload Foto Ruang Kelas</button>
                                    </center>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-3 g-3">
                        <div class="col">
                            <div class="card mb-3">
                                <div class="card-header">
                                    <h6 class="mb-0">Upload Foto Ruang Perpustakaan</h6>
                                </div>
                                <div class="card-body bg-light">
                                    <div id="dropzonefotoperpustakaan" class="dropzone"></div>
                                    <center>
                                        <button class="btn btn-falcon-default btn-sm me-2 btnAksiFoto" data-ruang="perpustakaan">Tampilkan File</button>
                                        <button class="btn btn-falcon-default btn-sm" id="cmdFotoPerpustakaan" <?php echo $disupload ?>>Upload Foto Ruang Perpustakaan</button>
                                    </center>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-3 g-3">
                        <div class="col">
                            <div class="card mb-3">
                                <div class="card-header">
                                    <h6 class="mb-0">Upload Foto Ruang Kepala Sekolah</h6>
                                </div>
                                <div class="card-body bg-light">
                                    <div id="dropzonefotokepsek" class="dropzone"></div>
                                    <center>
                                        <button class="btn btn-falcon-default btn-sm me-2 btnAksiFoto" data-ruang="kepsek">Tampilkan File</button>
                                        <button class="btn btn-falcon-default btn-sm" id="cmdFotoKepsek" <?php echo $disupload ?>>Upload Foto Ruang Kepala Sekolah</button>
                                    </center>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-3 g-3">
                        <div class="col">
                            <div class="card mb-3">
                                <div class="card-header">
                                    <h6 class="mb-0">Upload Foto Ruang Guru</h6>
                                </div>
                                <div class="card-body bg-light">
                                    <div id="dropzonefotoguru" class="dropzone"></div>
                                    <center>
                                        <button class="btn btn-falcon-default btn-sm me-2 btnAksiFoto" data-ruang="guru">Tampilkan File</button>
                                        <button class="btn btn-falcon-default btn-sm" id="cmdFotoGuru" <?php echo $disupload ?>>Upload Foto Ruang Guru</button>
                                    </center>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-3 g-3">
                        <div class="col">
                            <div class="card mb-3">
                                <div class="card-header">
                                    <h6 class="mb-0">Upload Foto Ruang Pembinaan</h6>
                                </div>
                                <div class="card-body bg-light">
                                    <div id="dropzonefotopembinaan" class="dropzone"></div>
                                    <center>
                                        <button class="btn btn-falcon-default btn-sm me-2 btnAksiFoto" data-ruang="pembinaan">Tampilkan File</button>
                                        <button class="btn btn-falcon-default btn-sm" id="cmdFotoPembinaan" <?php echo $disupload ?>>Upload Foto Ruang Pembinaan</button>
                                    </center>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-3 g-3">
                        <div class="col">
                            <div class="card mb-3">
                                <div class="card-header">
                                    <h6 class="mb-0">Upload Foto Ruang Lab. Multimedia</h6>
                                </div>
                                <div class="card-body bg-light">
                                    <div id="dropzonefotomultimedia" class="dropzone"></div>
                                    <center>
                                        <button class="btn btn-falcon-default btn-sm me-2 btnAksiFoto" data-ruang="multimedia">Tampilkan File</button>
                                        <button class="btn btn-falcon-default btn-sm" id="cmdFotoMultimedia" <?php echo $disupload ?>>Upload Foto Ruang Lab. Multimedia</button>
                                    </center>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-3 g-3">
                        <div class="col">
                            <div class="card mb-3">
                                <div class="card-header">
                                    <h6 class="mb-0">Upload Foto Ruang Lab. Komputer</h6>
                                </div>
                                <div class="card-body bg-light">
                                    <div id="dropzonefotokomputer" class="dropzone"></div>
                                    <center>
                                        <button class="btn btn-falcon-default btn-sm me-2 btnAksiFoto" data-ruang="komputer">Tampilkan File</button>
                                        <button class="btn btn-falcon-default btn-sm" id="cmdFotoKomputer" <?php echo $disupload ?>>Upload Foto Ruang Lab. Komputer</button>
                                    </center>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-3 g-3">
                        <div class="col">
                            <div class="card mb-3">
                                <div class="card-header">
                                    <h6 class="mb-0">Upload Foto Ruang Lab. IPS</h6>
                                </div>
                                <div class="card-body bg-light">
                                    <div id="dropzonefotoips" class="dropzone"></div>
                                    <center>
                                        <button class="btn btn-falcon-default btn-sm me-2 btnAksiFoto" data-ruang="ips">Tampilkan File</button>
                                        <button class="btn btn-falcon-default btn-sm" id="cmdFotoIPS" <?php echo $disupload ?>>Upload Foto Ruang Lab. IPS</button>
                                    </center>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-3 g-3">
                        <div class="col">
                            <div class="card mb-3">
                                <div class="card-header">
                                    <h6 class="mb-0">Upload Foto Ruang Lab. IPA</h6>
                                </div>
                                <div class="card-body bg-light">
                                    <div id="dropzonefotoipa" class="dropzone"></div>
                                    <center>
                                        <button class="btn btn-falcon-default btn-sm me-2 btnAksiFoto" data-ruang="ipa">Tampilkan File</button>
                                        <button class="btn btn-falcon-default btn-sm" id="cmdFotoIPA" <?php echo $disupload ?>>Upload Foto Ruang Lab. IPA</button>
                                    </center>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-3 g-3">
                        <div class="col">
                            <div class="card mb-3">
                                <div class="card-header">
                                    <h6 class="mb-0">Upload Foto Ruang Lab. Bahasa</h6>
                                </div>
                                <div class="card-body bg-light">
                                    <div id="dropzonefotobahasa" class="dropzone"></div>
                                    <center>
                                        <button class="btn btn-falcon-default btn-sm me-2 btnAksiFoto" data-ruang="bahasa">Tampilkan File</button>
                                        <button class="btn btn-falcon-default btn-sm" id="cmdFotoBahasa" <?php echo $disupload ?>>Upload Foto Ruang Lab. Bahasa</button>
                                    </center>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-3 g-3">
                        <div class="col">
                            <div class="card mb-3">
                                <div class="card-header">
                                    <h6 class="mb-0">Upload Foto Ruang WC Umum</h6>
                                </div>
                                <div class="card-body bg-light">
                                    <div id="dropzonefotowcumum" class="dropzone"></div>
                                    <center>
                                        <button class="btn btn-falcon-default btn-sm me-2 btnAksiFoto" data-ruang="wcumum">Tampilkan File</button>
                                        <button class="btn btn-falcon-default btn-sm" id="cmdFotoWcumum" <?php echo $disupload ?>>Upload Foto Ruang WC Umum</button>
                                    </center>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-3 g-3">
                        <div class="col">
                            <div class="card mb-3">
                                <div class="card-header">
                                    <h6 class="mb-0">Upload Foto Ruang WC Siswa</h6>
                                </div>
                                <div class="card-body bg-light">
                                    <div id="dropzonefotowcsiswa" class="dropzone"></div>
                                    <center>
                                        <button class="btn btn-falcon-default btn-sm me-2 btnAksiFoto" data-ruang="wcsiswa">Tampilkan File</button>
                                        <button class="btn btn-falcon-default btn-sm" id="cmdFotoWCSiswa" <?php echo $disupload ?>>Upload Foto Ruang WC Siswa</button>
                                    </center>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-3 g-3">
                        <div class="col">
                            <div class="card mb-3">
                                <div class="card-header">
                                    <h6 class="mb-0">Upload Foto Ruang WC Guru</h6>
                                </div>
                                <div class="card-body bg-light">
                                    <div id="dropzonefotowcguru" class="dropzone"></div>
                                    <center>
                                        <button class="btn btn-falcon-default btn-sm me-2 btnAksiFoto" data-ruang="wcguru">Tampilkan File</button>
                                        <button class="btn btn-falcon-default btn-sm" id="cmdFotoWCGuru" <?php echo $disupload ?>>Upload Foto Ruang WC Guru</button>
                                    </center>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-3 g-3">
                        <div class="col">
                            <div class="card mb-3">
                                <div class="card-header">
                                    <h6 class="mb-0">Upload Foto Ruang Ibadah</h6>
                                </div>
                                <div class="card-body bg-light">
                                    <div id="dropzonefotoibadah" class="dropzone"></div>
                                    <center>
                                        <button class="btn btn-falcon-default btn-sm me-2 btnAksiFoto" data-ruang="ibadah">Tampilkan File</button>
                                        <button class="btn btn-falcon-default btn-sm" id="cmdFotoIbadah" <?php echo $disupload ?>>Upload Foto Ruang Ibadah</button>
                                    </center>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-3 g-3">
                        <div class="col">
                            <div class="card mb-3">
                                <div class="card-header">
                                    <h6 class="mb-0">Upload Foto Asrama</h6>
                                </div>
                                <div class="card-body bg-light">
                                    <div id="dropzonefotoasrama" class="dropzone"></div>
                                    <center>
                                        <button class="btn btn-falcon-default btn-sm me-2 btnAksiFoto" data-ruang="asrama">Tampilkan File</button>
                                        <button class="btn btn-falcon-default btn-sm" id="cmdFotoAsrama" <?php echo $disupload ?>>Upload Foto Asrama</button>
                                    </center>
                                </div>
                            </div>
                        </div>
                    </div>

                </div><!--halaman upload video-->

            </div>
            <!--content-->

            <?php
            include "modal.php";
            ?>

        </div>
        <!--container-->
    </main>
    <!-- ===============================================-->
    <!--    End of Main Content-->
    <!-- ===============================================-->

    <!-- ===============================================-->
    <!-- JavaScripts-->
    <!-- ===============================================-->

    <script src="../vendors/bootstrap/bootstrap.min.js"></script>
    <script src="../vendors/anchorjs/anchor.min.js"></script>

    <script src="../vendors/fontawesome/all.min.js"></script>
    <script src="../vendors/lodash/lodash.min.js"></script>

    <script src="../vendors/jquery/jquery.min.js"></script>
    <script src="../vendors/select2/js/select2.full.min.js"></script>

    <script src="../assets/lib/datatables/js/jquery.dataTables.min.js"></script>
    <script src="../assets/lib/datatables-bs4/dataTables.bootstrap4.min.js"></script>
    <script src="../assets/lib/datatables.net-responsive/dataTables.responsive.js"></script>
    <script src="../assets/lib/datatables.net-responsive-bs4/responsive.bootstrap4.js"></script>

    <script src="../vendors/glightbox/glightbox.min.js"></script>
    <script src="../vendors/plyr/plyr.polyfilled.min.js"></script>
    <script src="../vendors/dropzone/dropzone.min.js"></script>

    <script src="../assets/js/theme.js"></script>

    <script type="text/javascript" src="https://cdn.jsdelivr.net/gh/hosuaby/Leaflet.SmoothMarkerBouncing@v2.0.0/dist/bundle.js" crossorigin="anonymous"></script>

    <script src="dashboard.js"></script>
    <script src="upload-video.js"></script>
    <script src="kegiatan-sekolah.js"></script>

    <script type="text/javascript" charset="utf-8">
        $(document).ready(function() {
            setTimeout(function() {
                document.body.style.cursor = "default";
                bersihkan();
                $("#area-halaman-sekolah").fadeOut("slow");
                $("#area-upload-video").fadeOut("slow");
                $("#area-upload-foto").fadeOut("slow");
                $("#area-halaman-kegiatan").fadeOut("slow");
                $("#area-halaman-utama").fadeIn();

                $("#txttransketerangan").val("kota");
                var nmwilayah = "Kabupaten Jember";
                $("#lblkoppeta").text(nmwilayah);

                isiHalamanDetail()

                $("#lblhalaman").val("dashboard");
                $("#loading").fadeOut("slow");
            }, 1000);
        });

        function bersihkan() {
            $("#lblhalaman").val("");
            $("#txttransid").val("");
            $("#txttransketerangan").val("");
            $("#txttransnmwilayah").val("");

            $("#txttransiddetailsekolah").val(""); //// detail sekolah ////

            $("#lblkoppeta").text("");

            $("#area-halaman-sekolah").css("display", "none");
            $("#area-upload-video").css("display", "none");
            $("#area-upload-foto").css("display", "none");
            $("#area-halaman-kegiatan").css("display", "none");
            $("#area-halaman-utama").css("display", "none");
        }

        $('#cmdGantiPassword').on('click', function() {
            var idoperator = $('#lbleditor').val();
            $.ajax({
                type: "POST",
                url: "../services/reset_password.php",
                data: {
                    idoperator: idoperator
                },
                success: function(resp) {
                    $("#isianModTambahData").html(resp);
                    $("#isianModTambahData").fadeIn(1000);
                    $("#modTambahData").modal({
                        backdrop: 'static',
                        keyboard: false
                    })
                    $("#modTambahData").modal('show');
                },
                error: function() {
                    alert('Koneksi bermasalah periksa internet');
                },
            });
        });

        $('#lv_download_tutorial').on('click', function () {
            window.open("tutorial.pdf","_blank")
        });
    </script>

</body>

</html>