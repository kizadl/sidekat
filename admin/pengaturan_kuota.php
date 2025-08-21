<?php
session_start();
if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit();
}

include('../config/database.php');

// Ambil kuota magang dari tabel pengaturan
$query = "SELECT value FROM pengaturan WHERE key_name = 'kuota_magang'";
$result = $conn->query($query);
$row = $result->fetch_assoc();
$kuota_magang = $row['value'];

// Proses update kuota magang
if (isset($_POST['update_kuota'])) {
    $new_kuota = $_POST['new_kuota'];
    $update_query = "UPDATE pengaturan SET value = '$new_kuota' WHERE key_name = 'kuota_magang'";
    if ($conn->query($update_query) === TRUE) {
        // Update kuota magang di variabel
        $kuota_magang = $new_kuota;

        // Refresh halaman untuk memperbarui tampilan
        header("Location: " . $_SERVER['PHP_SELF']);
        exit();
    }
}
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
                                    <div class="text-right mb-3">
                                        <button type="button" class="btn btn-primary mb-3" data-toggle="modal" data-target="#editQuotaModal">
                                            Atur Jumlah Quota Magang
                                        </button>
                                    </div>
                                    <div class="wrapper">
                                        <div class="table-responsive"> <!-- Added div for responsiveness -->
                                            <table id="mytable" class="table table-striped w-100 nowrap" style="text-align: center;">
                                                <thead>
                                                    <tr>
                                                        <th>Kuota Magang</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td><?php echo $kuota_magang; ?> mahasiswa</td>
                                                    </tr>

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

                    <!-- Modal Tambah Kategori -->
                    <div class="modal fade" id="modalTambahKategori" tabindex="-1" role="dialog" aria-labelledby="modalTambahKategoriLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="modalTambahKategoriLabel">Tambah Kategori Instansi</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <form method="POST">
                                    <div class="modal-body">
                                        <div class="form-group">
                                            <label for="nama_kategori">Nama Kategori</label>
                                            <input type="text" class="form-control" id="nama_kategori" name="nama_kategori" required>
                                        </div>
                                        <input type="hidden" name="action" value="tambah">
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                                        <button type="submit" class="btn btn-primary">Simpan</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <div class="modal fade" id="editQuotaModal" tabindex="-1" role="dialog" aria-labelledby="editQuotaLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="editQuotaLabel">Edit Kuota Magang</h5>
                                    <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <form action="" method="POST">
                                    <div class="modal-body">
                                        <div class="form-group">
                                            <label for="new_kuota">Kuota Magang Baru:</label>
                                            <input type="number" class="form-control" id="new_kuota" name="new_kuota" value="<?php echo $kuota_magang; ?>" required>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                                        <button type="submit" name="update_kuota" class="btn btn-primary">Simpan Perubahan</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

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
                    <!-- Script Bootstrap dan jQuery -->
                    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
                    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
                    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>