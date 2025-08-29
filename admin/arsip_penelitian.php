<?php
session_start();
if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit();
}

include '../config/database.php'; // Koneksi ke database

// Ambil data pengajuan magang dengan status pending
$query = "SELECT * FROM pengajuan_penelitian WHERE (status = 'disetujui' OR status = 'ditolak') AND status_data = 'arsip' ORDER BY tanggal_input DESC";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <?php
    $title = 'Arsip Penelitian';
    include 'layouts/head.php';
    ?>
</head>

<body>
    <!-- Begin page -->
    <div class="wrapper">


        <!-- ========== Topbar Start ========== -->
        <?php include 'layouts/navbar.php'; ?>
        <!-- ========== Topbar End ========== -->

        <!-- ========== Left Sidebar Start ========== -->
        <?php include 'layouts/sidebar.php'; ?>
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
                                        Berikut merupakan list data pengajuan magang, berikut panduan button dan
                                        fungsinya yang ada pada tabel data.
                                        Untuk <b><i>Melihat dokumen</i></b> silahkan klik icon <i
                                            class="ri-file-text-line"></i>.
                                        Untuk melakukan <b><i>Persetujuan</i></b> silahkan klik icon <i
                                            class="ri-chat-check-line"></i>.
                                        Untuk melakukan <b><i>Penolakan</i></b> silahkan klik icon <i
                                            class="ri-chat-delete-line"></i>.
                                        Untuk melakukan <b><i>Pengarsipan</i></b> silahkan klik icon <i
                                            class="ri-hard-drive-3-line"></i>.
                                    </p>
                                    <div class="table-responsive"> <!-- Added div for responsiveness -->
                                        <table id="mytable" class="table table-striped w-100 nowrap"
                                            style="text-align: center;">
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
                                                        <a href="../assets/uploads/pdf/<?php echo $row['file_pdf']; ?>"
                                                            target="_blank" class="btn btn-info">PDF</a>
                                                        <a href="../assets/uploads/jpg/<?php echo $row['file_jpg']; ?>"
                                                            target="_blank" class="btn btn-info">JPG</a>
                                                    </td>
                                                    <td>
                                                        <?php if ($row['status'] == 'disetujui'): ?>
                                                        <span class="badge badge-success">Disetujui</span>
                                                        <?php elseif ($row['status'] == 'ditolak'): ?>
                                                        <span class="badge badge-danger">Ditolak</span><br>
                                                        <a class="badge bg-info" data-toggle="modal"
                                                            data-target="#modalAlasan"
                                                            data-alasan="<?php echo htmlspecialchars($row['alasan_penolakan']); ?>">Alasan</a>
                                                        <?php else: ?>
                                                        <span class="badge badge-warning">Pending</span>
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
            <div class="modal fade" id="modalAlasan" tabindex="-1" role="dialog" aria-labelledby="modalAlasanLabel"
                aria-hidden="true">
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
            <div class="modal fade" id="modalTolak" tabindex="-1" role="dialog" aria-labelledby="modalTolakLabel"
                aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <form action="verifikasi_magang.php" method="POST">
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
                                <button type="submit" class="btn btn-danger" name="action" value="tolak">Tolak
                                    Pengajuan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="offcanvas offcanvas-end" tabindex="-1" id="theme-settings-offcanvas">
                <div class="d-flex align-items-center bg-primary p-3 offcanvas-header">
                    <h5 class="text-white m-0">Theme Settings</h5>
                    <button type="button" class="btn-close btn-close-white ms-auto" data-bs-dismiss="offcanvas"
                        aria-label="Close"></button>
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
                                    <input id="customizer-layout01" name="data-layout" type="checkbox"
                                        value="vertical" class="form-check-input">
                                    <label class="form-check-label" for="customizer-layout01">Vertical</label>
                                </div>
                                <div class="form-check form-switch">
                                    <input id="customizer-layout02" name="data-layout" type="checkbox"
                                        value="horizontal" class="form-check-input">
                                    <label class="form-check-label" for="customizer-layout02">Horizontal</label>
                                </div>
                            </div>

                            <h5 class="my-3 fs-16 fw-bold">Color Scheme</h5>

                            <div class="d-flex flex-column gap-2">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" name="data-bs-theme"
                                        id="layout-color-light" value="light">
                                    <label class="form-check-label" for="layout-color-light">Light</label>
                                </div>

                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" name="data-bs-theme"
                                        id="layout-color-dark" value="dark">
                                    <label class="form-check-label" for="layout-color-dark">Dark</label>
                                </div>
                            </div>

                            <div id="layout-width">
                                <h5 class="my-3 fs-16 fw-bold">Layout Mode</h5>

                                <div class="d-flex flex-column gap-2">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" name="data-layout-mode"
                                            id="layout-mode-fluid" value="fluid">
                                        <label class="form-check-label" for="layout-mode-fluid">Fluid</label>
                                    </div>

                                    <div id="layout-boxed">
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox" name="data-layout-mode"
                                                id="layout-mode-boxed" value="boxed">
                                            <label class="form-check-label" for="layout-mode-boxed">Boxed</label>
                                        </div>
                                    </div>

                                    <div id="layout-detached">
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox" name="data-layout-mode"
                                                id="data-layout-detached" value="detached">
                                            <label class="form-check-label"
                                                for="data-layout-detached">Detached</label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <h5 class="my-3 fs-16 fw-bold">Topbar Color</h5>

                            <div class="d-flex flex-column gap-2">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" name="data-topbar-color"
                                        id="topbar-color-light" value="light">
                                    <label class="form-check-label" for="topbar-color-light">Light</label>
                                </div>

                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" name="data-topbar-color"
                                        id="topbar-color-dark" value="dark">
                                    <label class="form-check-label" for="topbar-color-dark">Dark</label>
                                </div>

                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" name="data-topbar-color"
                                        id="topbar-color-brand" value="brand">
                                    <label class="form-check-label" for="topbar-color-brand">Brand</label>
                                </div>
                            </div>

                            <div>
                                <h5 class="my-3 fs-16 fw-bold">Menu Color</h5>

                                <div class="d-flex flex-column gap-2">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" name="data-menu-color"
                                            id="leftbar-color-light" value="light">
                                        <label class="form-check-label" for="leftbar-color-light">Light</label>
                                    </div>

                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" name="data-menu-color"
                                            id="leftbar-color-dark" value="dark">
                                        <label class="form-check-label" for="leftbar-color-dark">Dark</label>
                                    </div>
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" name="data-menu-color"
                                            id="leftbar-color-brand" value="brand">
                                        <label class="form-check-label" for="leftbar-color-brand">Brand</label>
                                    </div>
                                </div>
                            </div>

                            <div id="sidebar-size">
                                <h5 class="my-3 fs-16 fw-bold">Sidebar Size</h5>

                                <div class="d-flex flex-column gap-2">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" name="data-sidenav-size"
                                            id="leftbar-size-default" value="default">
                                        <label class="form-check-label" for="leftbar-size-default">Default</label>
                                    </div>

                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" name="data-sidenav-size"
                                            id="leftbar-size-compact" value="compact">
                                        <label class="form-check-label" for="leftbar-size-compact">Compact</label>
                                    </div>

                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" name="data-sidenav-size"
                                            id="leftbar-size-small" value="condensed">
                                        <label class="form-check-label" for="leftbar-size-small">Condensed</label>
                                    </div>

                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" name="data-sidenav-size"
                                            id="leftbar-size-small-hover" value="sm-hover">
                                        <label class="form-check-label" for="leftbar-size-small-hover">Hover
                                            View</label>
                                    </div>

                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" name="data-sidenav-size"
                                            id="leftbar-size-full" value="full">
                                        <label class="form-check-label" for="leftbar-size-full">Full Layout</label>
                                    </div>

                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" name="data-sidenav-size"
                                            id="leftbar-size-fullscreen" value="fullscreen">
                                        <label class="form-check-label" for="leftbar-size-fullscreen">Fullscreen
                                            Layout</label>
                                    </div>
                                </div>
                            </div>

                            <div id="layout-position">
                                <h5 class="my-3 fs-16 fw-bold">Layout Position</h5>

                                <div class="btn-group checkbox" role="group">
                                    <input type="radio" class="btn-check" name="data-layout-position"
                                        id="layout-position-fixed" value="fixed">
                                    <label class="btn btn-soft-primary w-sm" for="layout-position-fixed">Fixed</label>

                                    <input type="radio" class="btn-check" name="data-layout-position"
                                        id="layout-position-scrollable" value="scrollable">
                                    <label class="btn btn-soft-primary w-sm ms-0"
                                        for="layout-position-scrollable">Scrollable</label>
                                </div>
                            </div>

                            <div id="sidebar-user">
                                <div class="d-flex justify-content-between align-items-center mt-3">
                                    <label class="fs-16 fw-bold m-0" for="sidebaruser-check">Sidebar User Info</label>
                                    <div class="form-check form-switch">
                                        <input type="checkbox" class="form-check-input" name="sidebar-user"
                                            id="sidebaruser-check">
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
        </div>
    </div>

    <?php include 'layouts/script.php'; ?>

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
</body>

</html>
