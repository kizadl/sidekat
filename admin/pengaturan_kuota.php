<?php
session_start();
if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit();
}

include '../config/database.php';

// Ambil kuota magang dari tabel pengaturan
$query = "SELECT value FROM pengaturan WHERE key_name = 'kuota_magang'";
$result = $conn->query($query);
$row = $result->fetch_assoc();
$kuota_magang = $row['value'];

// Proses update kuota magang
if (isset($_POST['update_kuota'])) {
    $new_kuota = $_POST['new_kuota'];
    $update_query = "UPDATE pengaturan SET value = '$new_kuota' WHERE key_name = 'kuota_magang'";
    if ($conn->query($update_query) === true) {
        // Update kuota magang di variabel
        $kuota_magang = $new_kuota;

        // Refresh halaman untuk memperbarui tampilan
        header('Location: ' . $_SERVER['PHP_SELF']);
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <?php
    $title = 'Kuota Magang';
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
                                    <div class="text-right mb-3">
                                        <button type="button" class="btn btn-primary mb-3" data-toggle="modal"
                                            data-target="#editQuotaModal">
                                            Atur Jumlah Quota Magang
                                        </button>
                                    </div>
                                    <div class="wrapper">
                                        <div class="table-responsive"> <!-- Added div for responsiveness -->
                                            <table id="mytable" class="table table-striped w-100 nowrap"
                                                style="text-align: center;">
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
                    <div class="modal fade" id="modalTambahKategori" tabindex="-1" role="dialog"
                        aria-labelledby="modalTambahKategoriLabel" aria-hidden="true">
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
                                            <input type="text" class="form-control" id="nama_kategori"
                                                name="nama_kategori" required>
                                        </div>
                                        <input type="hidden" name="action" value="tambah">
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary"
                                            data-dismiss="modal">Tutup</button>
                                        <button type="submit" class="btn btn-primary">Simpan</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <div class="modal fade" id="editQuotaModal" tabindex="-1" role="dialog"
                        aria-labelledby="editQuotaLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="editQuotaLabel">Edit Kuota Magang</h5>
                                    <button type="button" class="btn-close" data-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <form action="" method="POST">
                                    <div class="modal-body">
                                        <div class="form-group">
                                            <label for="new_kuota">Kuota Magang Baru:</label>
                                            <input type="number" class="form-control" id="new_kuota"
                                                name="new_kuota" value="<?php echo $kuota_magang; ?>" required>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary"
                                            data-dismiss="modal">Batal</button>
                                        <button type="submit" name="update_kuota" class="btn btn-primary">Simpan
                                            Perubahan</button>
                                    </div>
                                </form>
                            </div>
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
    <!-- Script Bootstrap dan jQuery -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>
