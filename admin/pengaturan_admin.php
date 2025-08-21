<?php
session_start();
if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit();
}

include('../config/database.php');

// Ambil data admin berdasarkan username
$username = $_SESSION['username'];
$query = "SELECT * FROM admin WHERE username = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param('s', $username);
$stmt->execute();
$result = $stmt->get_result();
$admin = $result->fetch_assoc();

// Proses pembaruan nama dan username
$update_success = false; // Menyimpan status pembaruan

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama_baru = $_POST['nama'];
    $username_baru = $_POST['username'];

    // Update nama dan username di database
    $update_query = "UPDATE admin SET nama = ?, username = ? WHERE username = ?";
    $update_stmt = $conn->prepare($update_query);
    $update_stmt->bind_param("sss", $nama_baru, $username_baru, $username);

    if ($update_stmt->execute()) {
        // Update session username
        $_SESSION['username'] = $username_baru;
        $update_success = true; // Set status sukses
    } else {
        echo "Gagal memperbarui data admin.";
    }
}

// Ambil data admin lagi untuk memastikan nilai terbaru
$query = "SELECT * FROM admin WHERE username = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param('s', $_SESSION['username']);
$stmt->execute();
$result = $stmt->get_result();
$admin = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="id">

<head>    <meta charset="utf-8" />
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
    <script>
        function showAlert() {
            alert("Data admin berhasil diperbarui!");
        }
    </script>
</head>
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
                        <a class="dropdown-item" href="#">Profil</a>
                        <a class="dropdown-item" href="#">Pengaturan Akun</a>
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
            <div class="leftbar-user p-3 text-white">
                <a class="d-flex align-items-center text-reset">
                    <div class="flex-shrink-0">
                        <img src="assets/images/users/avatar-1.jpg" alt="user-image" height="42" class="rounded-circle shadow">
                    </div>
                    <div class="flex-grow-1 ms-2">
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
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="header-title">Custom styles</h4>
                            <p class="text-muted fs-14">Custom feedback styles apply custom colors, borders,
                                focus styles, and background
                                icons to better communicate feedback. Background icons for
                                <code>&lt;select&gt;</code>s are only available with
                                <code>.form-select</code>, and not <code>.form-control</code>.
                            </p>

                            <form method="POST" class="needs-validation" novalidate>
                                <div class="mb-3">
                                    <label class="form-label" for="username">Username</label>
                                    <input type="text" class="form-control" id="username" name="username" value="<?php echo htmlspecialchars($admin['username'], ENT_QUOTES, 'UTF-8'); ?>" required>
                                    <div class="valid-feedback">
                                        Looks good!
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label" for="nama">Nama</label>
                                    <input type="text" class="form-control" id="nama" name="nama" value="<?php echo htmlspecialchars($admin['nama'], ENT_QUOTES, 'UTF-8'); ?>" required>
                                    <div class="valid-feedback">
                                        Looks good!
                                    </div>
                                </div>
                                <button class="btn btn-primary" type="submit">Submit form</button>
                            </form>
                            <?php if ($update_success): ?>
                                    <script>
                                        showAlert(); // Panggil fungsi untuk menampilkan alert
                                    </script>
                                <?php endif; ?>
                        </div> <!-- end card-body-->
                    </div> <!-- end card-->
                </div> <!-- end col-->
            </div>
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
            </body>

</html>