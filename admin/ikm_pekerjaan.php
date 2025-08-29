<?php
session_start();
if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit();
}

include '../config/database.php';

// Proses tambah pekerjaan
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    $action = $_POST['action'];

    if ($action === 'tambah') {
        $nama = $_POST['nama'];
        // Insert ke database
        $query = 'INSERT INTO ikm_pekerjaan (nama) VALUES (?)';
        $stmt = $conn->prepare($query);
        $stmt->bind_param('s', $nama);
        $stmt->execute();
    } elseif ($action === 'edit') {
        // Proses edit pekerjaan
        $id = $_POST['id'];
        $nama = $_POST['nama'];
        $query = 'UPDATE ikm_pekerjaan SET nama = ? WHERE id = ?';
        $stmt = $conn->prepare($query);
        $stmt->bind_param('si', $nama, $id);
        $stmt->execute();
    } elseif ($action === 'hapus') {
        // Proses hapus pekerjaan
        $id = $_POST['id'];
        $query = 'DELETE FROM ikm_pekerjaan WHERE id = ?';
        $stmt = $conn->prepare($query);
        $stmt->bind_param('i', $id);
        $stmt->execute();
    }

    header('Location: ikm_pekerjaan.php');
    exit();
}

// Mendapatkan semua pekerjaan dari database
$query = 'SELECT * FROM ikm_pekerjaan';
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <?php
    $title = 'Pekerjaan';
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

                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">
                                    <h2>Data Pekerjaan</h2>
                                    <!-- <p class="text-muted fs-14">
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
                                    </p> -->
                                    <div class="text-right mb-3">
                                        <button type="button" class="btn btn-primary mb-3" data-toggle="modal"
                                            data-target="#modalTambahPekerjaan">
                                            Tambah Pekerjaan
                                        </button>
                                    </div>
                                    <div class="wrapper">
                                        <div class="table-responsive"> <!-- Added div for responsiveness -->
                                            <table id="mytable" class="table table-striped w-100 nowrap"
                                                style="text-align: center;">
                                                <thead>
                                                    <tr>
                                                        <th>No</th>
                                                        <th>Nama Pekerjaan</th>
                                                        <th>Aksi</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php if ($result->num_rows > 0): ?>
                                                    <?php $no = 1; ?>
                                                    <?php while ($row = $result->fetch_assoc()): ?>
                                                    <tr>
                                                        <td><?php echo $no++; ?></td>
                                                        <td><?php echo htmlspecialchars($row['nama'], ENT_QUOTES, 'UTF-8'); ?></td>
                                                        <td>
                                                            <!-- Tombol Edit -->
                                                            <button type="button" class="btn btn-warning btn-sm"
                                                                data-toggle="modal"
                                                                data-target="#modalEditPekerjaan<?php echo $row['id']; ?>">
                                                                Edit
                                                            </button>

                                                            <!-- Modal Edit -->
                                                            <div class="modal fade"
                                                                id="modalEditPekerjaan<?php echo $row['id']; ?>"
                                                                tabindex="-1" role="dialog"
                                                                aria-labelledby="modalEditPekerjaanLabel<?php echo $row['id']; ?>"
                                                                aria-hidden="true">
                                                                <div class="modal-dialog" role="document">
                                                                    <div class="modal-content">
                                                                        <div class="modal-header">
                                                                            <h5 class="modal-title"
                                                                                id="modalEditPekerjaanLabel<?php echo $row['id']; ?>">
                                                                                Edit Pekerjaan</h5>
                                                                            <button type="button" class="close"
                                                                                data-dismiss="modal" aria-label="Close">
                                                                                <span aria-hidden="true">&times;</span>
                                                                            </button>
                                                                        </div>
                                                                        <form method="POST">
                                                                            <div class="modal-body">
                                                                                <div class="form-group">
                                                                                    <label for="nama">Nama
                                                                                        Pekerjaan</label>
                                                                                    <input type="text"
                                                                                        class="form-control"
                                                                                        id="nama" name="nama"
                                                                                        value="<?php echo htmlspecialchars($row['nama'], ENT_QUOTES, 'UTF-8'); ?>"
                                                                                        required>
                                                                                </div>
                                                                                <input type="hidden" name="id"
                                                                                    value="<?php echo $row['id']; ?>">
                                                                                <input type="hidden" name="action"
                                                                                    value="edit">
                                                                            </div>
                                                                            <div class="modal-footer">
                                                                                <button type="button"
                                                                                    class="btn btn-secondary"
                                                                                    data-dismiss="modal">Tutup</button>
                                                                                <button type="submit"
                                                                                    class="btn btn-primary">Simpan
                                                                                    Perubahan</button>
                                                                            </div>
                                                                        </form>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <!-- Tombol Hapus -->
                                                            <form method="POST" style="display: inline;">
                                                                <input type="hidden" name="id"
                                                                    value="<?php echo $row['id']; ?>">
                                                                <input type="hidden" name="action" value="hapus">
                                                                <button type="submit" class="btn btn-danger btn-sm"
                                                                    onclick="return confirm('Apakah Anda yakin ingin menghapus pekerjaan ini?')">Hapus</button>
                                                            </form>
                                                        </td>
                                                    </tr>
                                                    <?php endwhile; ?>
                                                    <?php else: ?>
                                                    <tr>
                                                        <td colspan="3">Belum ada pekerjaan yang
                                                            ditambahkan.</td>
                                                    </tr>
                                                    <?php endif; ?>
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

                    <!-- Modal Tambah Pekerjaan -->
                    <div class="modal fade" id="modalTambahPekerjaan" tabindex="-1" role="dialog"
                        aria-labelledby="modalTambahPekerjaanLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="modalTambahPekerjaanLabel">Tambah Pekerjaan
                                    </h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <form method="POST">
                                    <div class="modal-body">
                                        <div class="form-group">
                                            <label for="nama">Nama Pekerjaan</label>
                                            <input type="text" class="form-control" id="nama" name="nama"
                                                required>
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
