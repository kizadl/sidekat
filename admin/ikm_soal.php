<?php
session_start();
if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit();
}

include '../config/database.php';

// Proses tambah soal
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    $action = $_POST['action'];

    if ($action === 'tambah') {
        $id_unsur = $_POST['id_unsur'];
        $pertanyaan = $_POST['nama'];
        $tidak_puas = $_POST['tidak_puas'];
        $kurang_puas = $_POST['kurang_puas'];
        $puas = $_POST['puas'];
        $sangat_puas = $_POST['sangat_puas'];
        $query = 'INSERT INTO ikm_soal (id_unsur, pertanyaan, tidak_puas, kurang_puas, puas, sangat_puas) VALUES (?, ?, ?, ?, ?, ?)';
        $stmt = $conn->prepare($query);
        $stmt->bind_param('isssss', $id_unsur, $pertanyaan, $tidak_puas, $kurang_puas, $puas, $sangat_puas);
        $stmt->execute();
    } elseif ($action === 'edit') {
        $id = $_POST['id'];
        $id_unsur = $_POST['id_unsur'];
        $pertanyaan = $_POST['nama'];
        $tidak_puas = $_POST['tidak_puas'];
        $kurang_puas = $_POST['kurang_puas'];
        $puas = $_POST['puas'];
        $sangat_puas = $_POST['sangat_puas'];
        $query = 'UPDATE ikm_soal SET id_unsur = ?, pertanyaan = ?, tidak_puas = ?, kurang_puas = ?, puas = ?, sangat_puas = ? WHERE id = ?';
        $stmt = $conn->prepare($query);
        $stmt->bind_param('isssssi', $id_unsur, $pertanyaan, $tidak_puas, $kurang_puas, $puas, $sangat_puas, $id);
        $stmt->execute();
    } elseif ($action === 'hapus') {
        $id = $_POST['id'];
        $query = 'DELETE FROM ikm_soal WHERE id = ?';
        $stmt = $conn->prepare($query);
        $stmt->bind_param('i', $id);
        $stmt->execute();
    }

    header('Location: ikm_soal.php');
    exit();
}

// Mendapatkan semua soal dari database
// Query untuk data soal
$query = 'SELECT s.*, u.nama AS nama_unsur FROM ikm_soal s LEFT JOIN ikm_unsur u ON s.id_unsur = u.id';
$result = $conn->query($query);

// Query untuk data unsur (akan digunakan di form tambah dan edit)
$query_unsur = 'SELECT * FROM ikm_unsur ORDER BY id';
$unsur = $conn->query($query_unsur);
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <?php
    $title = 'Soal';
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
                                    <h2>Data Soal</h2>
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
                                            data-target="#modalTambahSoal">
                                            Tambah Soal
                                        </button>
                                    </div>
                                    <div class="wrapper">
                                        <div class="table-responsive"> <!-- Added div for responsiveness -->

                                            <table id="mytable" class="table table-striped w-100 nowrap"
                                                style="text-align: center;">
                                                <thead>
                                                    <tr>
                                                        <th>No</th>
                                                        <th>Unsur Penilaian</th>
                                                        <th>Pertanyaan</th>
                                                        <th>Tidak Puas</th>
                                                        <th>Kurang Puas</th>
                                                        <th>Puas</th>
                                                        <th>Sangat Puas</th>
                                                        <th>Aksi</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php if ($result->num_rows > 0): ?>
                                                    <?php $no = 1; ?>
                                                    <?php while ($row = $result->fetch_assoc()): ?>
                                                    <tr>
                                                        <td><?php echo $no++; ?></td>
                                                        <td><?php echo htmlspecialchars($row['nama_unsur'], ENT_QUOTES, 'UTF-8'); ?></td>
                                                        <td><?php echo htmlspecialchars($row['pertanyaan'], ENT_QUOTES, 'UTF-8'); ?></td>
                                                        <td><?php echo htmlspecialchars($row['tidak_puas'], ENT_QUOTES, 'UTF-8'); ?></td>
                                                        <td><?php echo htmlspecialchars($row['kurang_puas'], ENT_QUOTES, 'UTF-8'); ?></td>
                                                        <td><?php echo htmlspecialchars($row['puas'], ENT_QUOTES, 'UTF-8'); ?></td>
                                                        <td><?php echo htmlspecialchars($row['sangat_puas'], ENT_QUOTES, 'UTF-8'); ?></td>
                                                        <td>
                                                            <!-- Tombol Edit -->
                                                            <button type="button" class="btn btn-warning btn-sm"
                                                                data-toggle="modal"
                                                                data-target="#modalEditSoal<?php echo $row['id']; ?>">Edit</button>

                                                            <!-- Modal Edit -->
                                                            <div class="modal fade"
                                                                id="modalEditSoal<?php echo $row['id']; ?>" tabindex="-1"
                                                                role="dialog"
                                                                aria-labelledby="modalEditSoalLabel<?php echo $row['id']; ?>"
                                                                aria-hidden="true">
                                                                <div class="modal-dialog" role="document">
                                                                    <div class="modal-content">
                                                                        <div class="modal-header">
                                                                            <h5 class="modal-title"
                                                                                id="modalEditSoalLabel<?php echo $row['id']; ?>">
                                                                                Edit Soal</h5>
                                                                            <button type="button" class="close"
                                                                                data-dismiss="modal" aria-label="Close">
                                                                                <span aria-hidden="true">&times;</span>
                                                                            </button>
                                                                        </div>
                                                                        <form method="POST">
                                                                            <div class="modal-body">
                                                                                <div class="form-group">
                                                                                    <label for="id_unsur">Unsur
                                                                                        Penilaian</label>
                                                                                    <select class="form-select"
                                                                                        id="id_unsur" name="id_unsur"
                                                                                        required>
                                                                                        <option value="">
                                                                                            Pilih Unsur Penilaian
                                                                                        </option>
                                                                                        <?php
                                                                                        // Reset pointer hasil query unsur
                                                                                        $unsur->data_seek(0);
                                                                                        while ($row_unsur = $unsur->fetch_assoc()) {
                                                                                            $selected = ($row['id_unsur'] == $row_unsur['id']) ? 'selected' : '';
                                                                                            echo '<option value="' . htmlspecialchars($row_unsur['id'], ENT_QUOTES, 'UTF-8') . '" ' . $selected . '>' . 
                                                                                                htmlspecialchars($row_unsur['nama'], ENT_QUOTES, 'UTF-8') . '</option>';
                                                                                        }
                                                                                        ?>
                                                                                    </select>
                                                                                </div>
                                                                                <div class="form-group">
                                                                                    <label
                                                                                        for="pertanyaan">Pertanyaan</label>
                                                                                    <input type="text"
                                                                                        class="form-control"
                                                                                        id="pertanyaan" name="nama"
                                                                                        value="<?php echo htmlspecialchars($row['pertanyaan'], ENT_QUOTES, 'UTF-8'); ?>"
                                                                                        required>
                                                                                </div>
                                                                                <div class="form-group">
                                                                                    <label for="tidak_puas">Tidak
                                                                                        Puas</label>
                                                                                    <input type="text"
                                                                                        class="form-control"
                                                                                        id="tidak_puas"
                                                                                        name="tidak_puas"
                                                                                        value="<?php echo htmlspecialchars($row['tidak_puas'], ENT_QUOTES, 'UTF-8'); ?>"
                                                                                        required>
                                                                                </div>
                                                                                <div class="form-group">
                                                                                    <label for="kurang_puas">Kurang
                                                                                        Puas</label>
                                                                                    <input type="text"
                                                                                        class="form-control"
                                                                                        id="kurang_puas"
                                                                                        name="kurang_puas"
                                                                                        value="<?php echo htmlspecialchars($row['kurang_puas'], ENT_QUOTES, 'UTF-8'); ?>"
                                                                                        required>
                                                                                </div>
                                                                                <div class="form-group">
                                                                                    <label for="puas">Puas</label>
                                                                                    <input type="text"
                                                                                        class="form-control"
                                                                                        id="puas" name="puas"
                                                                                        value="<?php echo htmlspecialchars($row['puas'], ENT_QUOTES, 'UTF-8'); ?>"
                                                                                        required>
                                                                                </div>
                                                                                <div class="form-group">
                                                                                    <label for="sangat_puas">Sangat
                                                                                        Puas</label>
                                                                                    <input type="text"
                                                                                        class="form-control"
                                                                                        id="sangat_puas"
                                                                                        name="sangat_puas"
                                                                                        value="<?php echo htmlspecialchars($row['sangat_puas'], ENT_QUOTES, 'UTF-8'); ?>"
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
                                                                    onclick="return confirm('Apakah Anda yakin ingin menghapus soal ini?')">Hapus</button>
                                                            </form>
                                                        </td>
                                                    </tr>
                                                    <?php endwhile; ?>
                                                    <?php else: ?>
                                                    <tr>
                                                        <td colspan="8">Belum ada soal yang ditambahkan.</td>
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

                    <!-- Modal Tambah Soal -->
                    <div class="modal fade" id="modalTambahSoal" tabindex="-1" role="dialog"
                        aria-labelledby="modalTambahSoalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="modalTambahSoalLabel">Tambah Soal</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <form method="POST">
                                    <div class="modal-body">
                                        <div class="form-group">
                                            <label for="id_unsur">Unsur Penilaian</label>
                                            <select class="form-select" id="id_unsur" name="id_unsur" required>
                                                <option value="" selected>Pilih Unsur Penilaian</option>
                                                <?php
                                                // Reset pointer hasil query unsur
                                                $unsur->data_seek(0);
                                                while ($row_unsur = $unsur->fetch_assoc()) {
                                                    echo '<option value="' . htmlspecialchars($row_unsur['id'], ENT_QUOTES, 'UTF-8') . '">' . 
                                                        htmlspecialchars($row_unsur['nama'], ENT_QUOTES, 'UTF-8') . '</option>';
                                                }
                                                ?>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="pertanyaan">Pertanyaan</label>
                                            <input type="text" class="form-control" id="pertanyaan"
                                                name="nama" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="tidak_puas">Tidak Puas</label>
                                            <input type="text" class="form-control" id="tidak_puas"
                                                name="tidak_puas" value="1" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="kurang_puas">Kurang Puas</label>
                                            <input type="text" class="form-control" id="kurang_puas"
                                                name="kurang_puas" value="2" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="puas">Puas</label>
                                            <input type="text" class="form-control" id="puas" name="puas"
                                                value="3" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="sangat_puas">Sangat Puas</label>
                                            <input type="text" class="form-control" id="sangat_puas"
                                                name="sangat_puas" value="4" required>
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
