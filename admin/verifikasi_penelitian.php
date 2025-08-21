<?php
session_start();
if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit();
}

include '../config/database.php'; // Koneksi ke database

// Proses tindakan verifikasi
if (isset($_POST['action'])) {
    $id = $_POST['id'];

    if ($_POST['action'] == 'setujui') {
        // Setujui pengajuan
        $query = "UPDATE pengajuan_penelitian SET status = 'disetujui', status_data = 'pending' WHERE id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param('i', $id);
        $stmt->execute();
    } elseif ($_POST['action'] == 'tolak') {
        // Tolak pengajuan dan simpan alasan
        $alasan_penolakan = $_POST['alasan_penolakan'];
        $query = "UPDATE pengajuan_penelitian SET status = 'ditolak', status_data = 'pending', alasan_penolakan = ? WHERE id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param('si', $alasan_penolakan, $id);
        $stmt->execute();
    } elseif ($_POST['action'] == 'arsipkan') {
        // Arsipkan pengajuan
        $query = "UPDATE pengajuan_penelitian SET status_data = 'arsip' WHERE id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param('i', $id);
        $stmt->execute();
    }

    header('Location: verifikasi_penelitian.php');
    exit();
}

// Ambil data pengajuan magang dengan status pending
$query = "SELECT * FROM pengajuan_penelitian WHERE status = 'pending' OR status_data = 'pending' ORDER BY tanggal_input DESC";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8" />
    <title>Datatables | Jidox - Material Design Admin & Dashboard Template</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="A fully featured admin theme which can be used to build CRM, CMS, etc." name="description" />
    <meta content="Coderthemes" name="author" />

    <!-- App favicon -->
    <link rel="shortcut icon" href="assets/images/favicon.ico">

    <!-- Datatables css -->
    <link href="assets/vendor/datatables.net-bs5/css/dataTables.bootstrap5.min.css" rel="stylesheet" type="text/css" />
    <link href="assets/vendor/datatables.net-fixedcolumns-bs5/css/fixedColumns.bootstrap5.min.css" rel="stylesheet" type="text/css" />
    <link href="assets/vendor/datatables.net-fixedheader-bs5/css/fixedHeader.bootstrap5.min.css" rel="stylesheet" type="text/css" />
    <link href="assets/vendor/datatables.net-buttons-bs5/css/buttons.bootstrap5.min.css" rel="stylesheet" type="text/css" />
    <link href="assets/vendor/datatables.net-select-bs5/css/select.bootstrap5.min.css" rel="stylesheet" type="text/css" />

    <!-- Theme Config Js -->
    <script src="assets/js/config.js"></script>

    <!-- App css -->
    <link href="assets/css/app.min.css" rel="stylesheet" type="text/css" id="app-style" />

    <!-- Icons css -->
    <link href="assets/css/icons.min.css" rel="stylesheet" type="text/css" />
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
    <style>
        .dropdown-container {
            display: none;
        }
    </style>
</head>

<body>
    <!-- Begin page -->
    <div class="wrapper">


        <!-- ========== Topbar Start ========== -->
        <div class="navbar-custom">
            <div class="topbar container-fluid">
                <div class="d-flex align-items-center gap-lg-2 gap-1">

                    <!-- Topbar Brand Logo -->
                    <div class="logo-topbar">
                        <!-- Logo light -->
                        <a href="index.html" class="logo-light">
                            <span class="logo-lg">
                                <img src="assets/images/logo_dnd.png" alt="logo">
                            </span>
                            <span class="logo-sm">
                                <img src="assets/images/logo-sm.png" alt="small logo">
                            </span>
                        </a>

                        <!-- Logo Dark -->
                        <a href="index.html" class="logo-dark">
                            <span class="logo-lg">
                                <img src="assets/images/logo_dnd.png" alt="dark logo">
                            </span>
                            <span class="logo-sm">
                                <img src="assets/images/logo-sm.png" alt="small logo">
                            </span>
                        </a>
                    </div>

                    <!-- Sidebar Menu Toggle Button -->
                    <!-- Horizontal Menu Toggle Button -->
                    <button class="navbar-toggle" data-bs-toggle="collapse" data-bs-target="#topnav-menu-content">
                        <div class="lines">
                            <span></span>
                            <span></span>
                            <span></span>
                        </div>
                    </button>

                    <!-- Topbar Search Form -->

                </div>

                <ul class="topbar-menu d-flex align-items-center gap-3">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <span class="account-user-avatar">
                                <img src="assets/images/users/avatar-1.jpg" alt="user-image" width="32" class="rounded-circle">
                            </span>

                        </a>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="logout.php">Ganti Password</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="logout.php">Logout</a> <!-- Link ke halaman logout -->
                        </div>
                    </li>
                </ul>
            </div>
        </div>
        <!-- ========== Topbar End ========== -->

        <!-- ========== Left Sidebar Start ========== -->
        <div class="leftside-menu">

            <!-- Brand Logo Light -->
            <a href="index.html" class="logo logo-light">
                <span class="logo-lg">
                    <img src="assets/images/logo_dnd.png" width="120px" alt="logo">
                </span>
                <span class="logo-sm">
                    <img src="assets/images/logo-sm.png" alt="small logo">
                </span>
            </a>

            <!-- Brand Logo Dark -->
            <a href="index.html" class="logo logo-dark">
                <span class="logo-lg">
                    <img src="assets/images/logo_dnd.png" alt="dark logo">
                </span>
                <span class="logo-sm">
                    <img src="assets/images/logo-sm.png" alt="small logo">
                </span>
            </a>

            <!-- Sidebar Hover Menu Toggle Button -->
            <div class="button-sm-hover" data-bs-toggle="tooltip" data-bs-placement="right" title="Show Full Sidebar">
                <i class="ri-checkbox-blank-circle-line align-middle"></i>
            </div>

            <!-- Full Sidebar Menu Close Button -->
            <div class="button-close-fullsidebar">
                <i class="ri-close-fill align-middle"></i>
            </div>

            <!-- Sidebar -left -->
            <div class="h-100" id="leftside-menu-container" data-simplebar>
                <!-- Leftbar User -->
                <div class="leftbar-user p-1 text-white">
                    <a class="d-flex align-items-center text-reset">
                        <div class="flex-shrink-0 ms-2">
                            <img src="assets/images/users/avatar-1.jpg" alt="user-image" height="42" class="rounded-circle shadow">
                        </div>
                        <div class="flex-grow-4 ms-3">
                            <span class="fw-semibold fs-15 d-block"><?php echo $_SESSION['nama']; ?></span>
                            <span class="fs-13"><?php echo $_SESSION['role']; ?></span>
                        </div>
                    </a>
                </div>

                <!--- Sidemenu -->
                <ul class="side-nav">

                    <li class="side-nav-title mt-1"> Dashboard</li>

                    <li class="side-nav-item">
                        <a href="dashboard.html" class="side-nav-link">
                            <i class="ri-dashboard-2-fill"></i>
                            <span> Dashboard </span>
                        </a>
                    </li>
                    <li class="side-nav-title mt-2">Verifikasi Pengajuan</li>
                    <li class="side-nav-item">
                        <a href="verifikasi_magang.html" class="side-nav-link">
                            <i class="ri-survey-fill"></i>
                            <span>Pengajuan Magang </span>
                        </a>
                    </li>
                    <li class="side-nav-item">
                        <a href="verifikasi_penelitian.html" class="side-nav-link">
                            <i class=" ri-microscope-fill"></i>
                            <span>Pengajuan Penelitian </span>
                        </a>
                    </li>
                    <li class="side-nav-item">
                        <a href="verifikasi_studi_edukasi.html" class="side-nav-link">
                            <i class=" ri-graduation-cap-fill"></i>
                            <span>Pengajuan Studi Edukasi</span>
                        </a>
                    </li>
                    <li class="side-nav-item">
                        <a href="verifikasi_kunjungan_kerja.html" class="side-nav-link">
                            <i class="ri-briefcase-5-fill"></i>
                            <span>Kunjungan Kerja </span>
                        </a>
                    </li>
                    <li class="side-nav-title mt-1">Kelola Arsip</li>
                    <li class="side-nav-item">
                        <a href="#" onclick="toggleDropdown()" class="side-nav-link">
                            <i class="ri-mail-fill"></i>
                            <span>Arsip</span>
                            <span class="menu-arrow"></span>
                        </a>
                        <div class="dropdown-container" id="dropdownMenu">
                            <ul class="side-nav-second-level">
                                <li>
                                    <a href="arsip_magang.html">Magang</a>
                                </li>
                                <li>
                                    <a href="arsip_penelitian.html">Penelitian</a>
                                </li>
                                <li>
                                    <a href="arsip_studi_edukasi.html">Studi Edukasi</a>
                                </li>
                                <li>
                                    <a href="arsip_kunjungan_kerja.html">Kunjungan Kerja</a>
                                </li>
                            </ul>
                        </div>
                    </li>
                    <li class="side-nav-title mt-1"> Master Data</li>
                    <li class="side-nav-item">
                        <a href="kategori_instansi.html" class="side-nav-link">
                            <i class="ri-government-fill"></i>
                            <span> Kategori Instansi </span>
                        </a>
                    </li>
                    <li class="side-nav-item">
                        <a href="pengaturan_kuota.html" class="side-nav-link">
                            <i class="ri-team-fill"></i>
                            <span> Kuota Magang</span>
                        </a>
                    </li>


                </ul>
                <!--- End Sidemenu -->

                <div class="clearfix"></div>
            </div>
        </div>
        <!-- ========== Left Sidebar End ========== -->

        <!-- ============================================================== -->
        <!-- Start Page Content here -->
        <!-- ============================================================== -->

        <br>
        <div class="content-page">
            <div class="content">

                <!-- Start Content-->
                <div class="container-fluid">

                    <!-- start page title -->
                    <!-- end page title -->


                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">
                                    <h2>Data Pengajuan Magang</h2>
                                    <p class="text-muted fs-14">
                                        Berikut merupakan list data pengajuan magang, berikut panduan button dan fungsinya yang ada pada tabel data.
                                        Untuk <b><i>Melihat dokumen</i></b> silahkan klik icon <i class="ri-file-text-line"></i>.
                                        Untuk melakukan <b><i>Persetujuan</i></b> silahkan klik icon <i class="ri-chat-check-line"></i>.
                                        Untuk melakukan <b><i>Penolakan</i></b> silahkan klik icon <i class="ri-chat-delete-line"></i>.
                                        Untuk melakukan <b><i>Pengarsipan</i></b> silahkan klik icon <i class="ri-hard-drive-3-line"></i>.
                                    </p>
                                    <div class="table-responsive"> <!-- Added div for responsiveness -->
                                        <table id="mytable" class="table table-striped w-100 nowrap" style="text-align: center;">
                                            <thead>
                                                <tr>
                                                    <th>No</th>
                                                    <th>Nama</th>
                                                    <th>Email</th>
                                                    <th>Nomor HP</th>
                                                    <th>Kampus</th>
                                                    <th>Fakultas</th>
                                                    <th>Prodi</th>
                                                    <th>NIM</th>
                                                    <th>Tanggal Magang</th>
                                                    <th>Dokumen</th>
                                                    <th>Status</th>
                                                    <th>Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $no = 1;
                                                while ($row = $result->fetch_assoc()): ?>
                                                    <tr>
                                                        <td><?php echo $no++; ?></td>
                                                        <td><?php echo $row['nama']; ?></td>
                                                        <td><?php echo $row['email']; ?></td>
                                                        <td><?php echo $row['nomor_hp']; ?></td>
                                                        <td><?php echo $row['kampus']; ?></td>
                                                        <td><?php echo $row['fakultas']; ?></td>
                                                        <td><?php echo $row['prodi']; ?></td>
                                                        <td><?php echo $row['nim']; ?></td>
                                                        <td><?php echo date('d-m-Y', strtotime($row['tanggal_input'])); ?></td>
                                                        <td>
                                                            <a href="../storage/data-pdf/<?php echo $row['file_pdf']; ?>" target="_blank" class="btn btn-info">PDF</a>
                                                            <a href="../storage/data-foto/<?php echo $row['file_jpg']; ?>" target="_blank" class="btn btn-info">JPG</a>
                                                        </td>
                                                        <td>
                                                            <?php if ($row['status'] == 'disetujui'): ?>
                                                                <span class="badge badge-success">Disetujui</span>
                                                            <?php elseif ($row['status'] == 'ditolak'): ?>
                                                                <span class="badge badge-danger">Ditolak</span><br>
                                                                <a class="badge bg-info" data-toggle="modal" data-target="#modalAlasan" data-alasan="<?php echo htmlspecialchars($row['alasan_penolakan']); ?>">Alasan</a>
                                                            <?php else: ?>
                                                                <span class="badge badge-warning">Pending</span>
                                                            <?php endif; ?>
                                                        </td>
                                                        <td>
                                                            <?php if ($row['status'] == 'pending'): ?>
                                                                <form method="POST" style="display:inline;">
                                                                    <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                                                                    <button type="submit" name="action" value="setujui" class="btn btn-success" onclick="return confirm('Apakah Anda yakin ingin menyetujui pengajuan ini?')">Setujui</button>
                                                                </form>
                                                                <button class="btn btn-danger" data-toggle="modal" data-target="#modalTolak" data-id="<?php echo $row['id']; ?>">Tolak</button>
                                                            <?php elseif ($row['status'] == 'disetujui' || $row['status'] == 'ditolak'): ?>
                                                                <form method="POST" style="display:inline;">
                                                                    <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                                                                    <button type="submit" name="action" value="arsipkan" class="btn btn-primary" onclick="return confirm('Apakah Anda yakin ingin mengarsipkan pengajuan ini?')">Arsip</button>
                                                                </form>
                                                            <?php endif; ?>
                                                        </td>
                                                    </tr>
                                                <?php endwhile; ?>
                                            </tbody>
                                        </table>
                                    </div> <!-- End table-responsive -->
                                </div> <!-- end card body-->
                            </div> <!-- end card -->
                        </div><!-- end col-->
                    </div> <!-- end row-->





                </div> <!-- content -->

                <!-- Footer Start -->
                <footer class="footer">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-md-6">
                                <script>
                                    document.write(new Date().getFullYear())
                                </script> © DPRD Kabupaten Jember
                            </div>
                            <div class="col-md-6">
                                <div class="text-md-end footer-links d-none d-md-block">
                                    <a>DND Sidekat</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </footer>
                <!-- end Footer -->

            </div>
            <!-- Modal untuk Lihat Alasan Penolakan -->
            <div class="modal fade" id="modalAlasan" tabindex="-1" role="dialog" aria-labelledby="modalAlasanLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="modalAlasanLabel">Alasan Penolakan</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <p id="alasanText"></p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Modal untuk input alasan penolakan -->
            <div class="modal fade" id="modalTolak" tabindex="-1" role="dialog" aria-labelledby="modalTolakLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <form action="verifikasi_penelitian.php" method="POST">
                            <div class="modal-header">
                                <h5 class="modal-title" id="modalTolakLabel">Alasan Penolakan</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <input type="hidden" name="id" id="pengajuan-id">
                                <div class="form-group">
                                    <label for="alasan_penolakan">Masukkan Alasan Penolakan</label>
                                    <textarea name="alasan_penolakan" id="alasan_penolakan" class="form-control" required></textarea>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                                <button type="submit" class="btn btn-danger" name="action" value="tolak">Tolak Pengajuan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="offcanvas offcanvas-end" tabindex="-1" id="theme-settings-offcanvas">
                <div class="d-flex align-items-center bg-primary p-3 offcanvas-header">
                    <h5 class="text-white m-0">Theme Settings</h5>
                    <button type="button" class="btn-close btn-close-white ms-auto" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                </div>

                <div class="offcanvas-body p-0">
                    <div data-simplebar class="h-100">
                        <div class="card mb-0 p-3">
                            <div class="alert alert-warning" role="alert">
                                <strong>Customize </strong> the overall color scheme, sidebar menu, etc.
                            </div>

                            <h5 class="mt-0 fs-16 fw-bold mb-3">Choose Layout</h5>
                            <div class="d-flex flex-column gap-2">
                                <div class="form-check form-switch">
                                    <input id="customizer-layout01" name="data-layout" type="checkbox" value="vertical" class="form-check-input">
                                    <label class="form-check-label" for="customizer-layout01">Vertical</label>
                                </div>
                                <div class="form-check form-switch">
                                    <input id="customizer-layout02" name="data-layout" type="checkbox" value="horizontal" class="form-check-input">
                                    <label class="form-check-label" for="customizer-layout02">Horizontal</label>
                                </div>
                            </div>

                            <h5 class="my-3 fs-16 fw-bold">Color Scheme</h5>

                            <div class="d-flex flex-column gap-2">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" name="data-bs-theme" id="layout-color-light" value="light">
                                    <label class="form-check-label" for="layout-color-light">Light</label>
                                </div>

                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" name="data-bs-theme" id="layout-color-dark" value="dark">
                                    <label class="form-check-label" for="layout-color-dark">Dark</label>
                                </div>
                            </div>

                            <div id="layout-width">
                                <h5 class="my-3 fs-16 fw-bold">Layout Mode</h5>

                                <div class="d-flex flex-column gap-2">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" name="data-layout-mode" id="layout-mode-fluid" value="fluid">
                                        <label class="form-check-label" for="layout-mode-fluid">Fluid</label>
                                    </div>

                                    <div id="layout-boxed">
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox" name="data-layout-mode" id="layout-mode-boxed" value="boxed">
                                            <label class="form-check-label" for="layout-mode-boxed">Boxed</label>
                                        </div>
                                    </div>

                                    <div id="layout-detached">
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox" name="data-layout-mode" id="data-layout-detached" value="detached">
                                            <label class="form-check-label" for="data-layout-detached">Detached</label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <h5 class="my-3 fs-16 fw-bold">Topbar Color</h5>

                            <div class="d-flex flex-column gap-2">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" name="data-topbar-color" id="topbar-color-light" value="light">
                                    <label class="form-check-label" for="topbar-color-light">Light</label>
                                </div>

                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" name="data-topbar-color" id="topbar-color-dark" value="dark">
                                    <label class="form-check-label" for="topbar-color-dark">Dark</label>
                                </div>

                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" name="data-topbar-color" id="topbar-color-brand" value="brand">
                                    <label class="form-check-label" for="topbar-color-brand">Brand</label>
                                </div>
                            </div>

                            <div>
                                <h5 class="my-3 fs-16 fw-bold">Menu Color</h5>

                                <div class="d-flex flex-column gap-2">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" name="data-menu-color" id="leftbar-color-light" value="light">
                                        <label class="form-check-label" for="leftbar-color-light">Light</label>
                                    </div>

                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" name="data-menu-color" id="leftbar-color-dark" value="dark">
                                        <label class="form-check-label" for="leftbar-color-dark">Dark</label>
                                    </div>
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" name="data-menu-color" id="leftbar-color-brand" value="brand">
                                        <label class="form-check-label" for="leftbar-color-brand">Brand</label>
                                    </div>
                                </div>
                            </div>

                            <div id="sidebar-size">
                                <h5 class="my-3 fs-16 fw-bold">Sidebar Size</h5>

                                <div class="d-flex flex-column gap-2">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" name="data-sidenav-size" id="leftbar-size-default" value="default">
                                        <label class="form-check-label" for="leftbar-size-default">Default</label>
                                    </div>

                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" name="data-sidenav-size" id="leftbar-size-compact" value="compact">
                                        <label class="form-check-label" for="leftbar-size-compact">Compact</label>
                                    </div>

                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" name="data-sidenav-size" id="leftbar-size-small" value="condensed">
                                        <label class="form-check-label" for="leftbar-size-small">Condensed</label>
                                    </div>

                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" name="data-sidenav-size" id="leftbar-size-small-hover" value="sm-hover">
                                        <label class="form-check-label" for="leftbar-size-small-hover">Hover View</label>
                                    </div>

                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" name="data-sidenav-size" id="leftbar-size-full" value="full">
                                        <label class="form-check-label" for="leftbar-size-full">Full Layout</label>
                                    </div>

                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" name="data-sidenav-size" id="leftbar-size-fullscreen" value="fullscreen">
                                        <label class="form-check-label" for="leftbar-size-fullscreen">Fullscreen Layout</label>
                                    </div>
                                </div>
                            </div>

                            <div id="layout-position">
                                <h5 class="my-3 fs-16 fw-bold">Layout Position</h5>

                                <div class="btn-group checkbox" role="group">
                                    <input type="radio" class="btn-check" name="data-layout-position" id="layout-position-fixed" value="fixed">
                                    <label class="btn btn-soft-primary w-sm" for="layout-position-fixed">Fixed</label>

                                    <input type="radio" class="btn-check" name="data-layout-position" id="layout-position-scrollable" value="scrollable">
                                    <label class="btn btn-soft-primary w-sm ms-0" for="layout-position-scrollable">Scrollable</label>
                                </div>
                            </div>

                            <div id="sidebar-user">
                                <div class="d-flex justify-content-between align-items-center mt-3">
                                    <label class="fs-16 fw-bold m-0" for="sidebaruser-check">Sidebar User Info</label>
                                    <div class="form-check form-switch">
                                        <input type="checkbox" class="form-check-input" name="sidebar-user" id="sidebaruser-check">
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>

                </div>
                <div class="offcanvas-footer border-top p-3 text-center">
                    <div class="row">
                        <div class="col-6">
                            <button type="button" class="btn btn-light w-100" id="reset-layout">Reset</button>
                        </div>
                        <div class="col-6">
                            <a href="#" role="button" class="btn btn-primary w-100">Buy Now</a>
                        </div>
                    </div>
                </div>
            </div>




            <!-- Datatables js -->
            <script src="assets/vendor/datatables.net/js/jquery.dataTables.min.js"></script>
            <script src="assets/vendor/datatables.net-bs5/js/dataTables.bootstrap5.min.js"></script>
            <script src="assets/vendor/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
            <script src="assets/vendor/datatables.net-responsive-bs5/js/responsive.bootstrap5.min.js"></script>
            <script src="assets/vendor/datatables.net-fixedcolumns-bs5/js/fixedColumns.bootstrap5.min.js"></script>
            <script src="assets/vendor/datatables.net-fixedheader/js/dataTables.fixedHeader.min.js"></script>
            <script src="assets/vendor/datatables.net-buttons/js/dataTables.buttons.min.js"></script>
            <script src="assets/vendor/datatables.net-buttons-bs5/js/buttons.bootstrap5.min.js"></script>
            <script src="assets/vendor/datatables.net-buttons/js/buttons.html5.min.js"></script>
            <script src="assets/vendor/datatables.net-buttons/js/buttons.flash.min.js"></script>
            <script src="assets/vendor/datatables.net-buttons/js/buttons.print.min.js"></script>
            <script src="assets/vendor/datatables.net-keytable/js/dataTables.keyTable.min.js"></script>
            <script src="assets/vendor/datatables.net-select/js/dataTables.select.min.js"></script>

            <script>
                $(document).ready(function() {
                    $('#mytable').DataTable({
                        "scrollX": true, // Aktifkan scroll horizontal
                        "paging": true, // Aktifkan pagination
                        "searching": true, // Aktifkan fitur pencarian
                        "ordering": true, // Aktifkan pengurutan kolom
                        "language": {
                            "search": "Cari:",
                            "paginate": {
                                "next": "Berikutnya",
                                "previous": "Sebelumnya"
                            }
                        }
                    });
                });
            </script>
            <script>
                // Menyisipkan ID pengajuan yang akan ditolak ke dalam form modal
                $('#modalTolak').on('show.bs.modal', function(event) {
                    var button = $(event.relatedTarget); // Tombol yang diklik
                    var id = button.data('id'); // Mengambil data-id dari tombol

                    var modal = $(this);
                    modal.find('#pengajuan-id').val(id); // Mengisi input hidden dengan ID pengajuan
                });

                $('#modalAlasan').on('show.bs.modal', function(event) {
                    var button = $(event.relatedTarget);
                    var alasan = button.data('alasan');
                    var modal = $(this);
                    modal.find('#alasanText').text(alasan);
                });
            </script>
            <script>
                function setujui() {
                    var setujui = confirm("Apakah Anda yakin ingin MENYETUJUI pengajuan ini?");
                    if (setujui) {
                        alert("Pengajuan Berhasil Disetujui"); // Lakukan aksi penghapusan data di sini
                    } else {
                        alert("Persetujuan dibatalkan.");
                    }
                }

                function arsip() {
                    // Menampilkan konfirmasi dengan tombol OK dan Cancel
                    var arsip = confirm("Apakah Anda yakin ingin MENGARSIPKAN data ini?");
                    if (arsip) {
                        // Jika pengguna memilih OK
                        alert("Data Berhasil Diarsipkan");
                        // Di sini Anda bisa menambahkan kode untuk melanjutkan tindakan
                        // Misalnya, menghapus data atau mengarahkan ke halaman lain
                    } else {
                        // Jika pengguna memilih Cancel
                        alert("Pengarsipan data dibatalkan");
                    }
                }
            </script>
            <script>
                // JavaScript untuk toggle dropdown
                function toggleDropdown() {
                    var dropdown = document.getElementById("dropdownMenu");
                    if (dropdown.style.display === "block") {
                        dropdown.style.display = "none";
                    } else {
                        dropdown.style.display = "block";
                    }
                }
            </script>

</body>

</html>