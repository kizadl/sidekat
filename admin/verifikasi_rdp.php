<?php
session_start();
if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit();
}

include '../config/database.php'; // Koneksi ke database
include 'mailer.php';

// Proses tindakan verifikasi
if (isset($_POST['action'])) {
    $id = $_POST['id'];

    if ($_POST['action'] == 'setujui') {
        // Setujui pengajuan
        $query = "UPDATE pengajuan_rdp SET status = 'disetujui', status_data = 'pending' WHERE id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param('i', $id);
        $stmt->execute();

        // Ambil data email dan nama penanggung jawab
        $query_email = "SELECT email, nama_penanggung_jawab, nama_organisasi FROM pengajuan_rdp WHERE id = ?";
        $stmt_email = $conn->prepare($query_email);
        $stmt_email->bind_param('i', $id);
        $stmt_email->execute();
        $result_email = $stmt_email->get_result();
        $row_email = $result_email->fetch_assoc();
        $email = $row_email['email'];
        $nama = $row_email['nama_penanggung_jawab'];
        $organisasi = $row_email['nama_organisasi'];

        $subject = 'Pengajuan Rapat Dengar Pendapat Disetujui';
        $body = 'Halo ' . htmlspecialchars($nama) . ' dari ' . htmlspecialchars($organisasi) . ',<br><br>Pengajuan Rapat Dengar Pendapat Anda telah <b>disetujui</b>.<br>Silakan cek dashboard untuk informasi selanjutnya.';
        $altBody = 'Halo ' . $nama . ',\nPengajuan Rapat Dengar Pendapat Anda telah disetujui.';
        sendMail($email, $nama, $subject, $body, $altBody);
    } elseif ($_POST['action'] == 'tolak') {
        // Tolak pengajuan dan simpan alasan
        $alasan_penolakan = $_POST['alasan_penolakan'];
        $query = "UPDATE pengajuan_rdp SET status = 'ditolak', status_data = 'pending', alasan_penolakan = ? WHERE id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param('si', $alasan_penolakan, $id);
        $stmt->execute();

        // Ambil data email dan nama penanggung jawab
        $query_email = "SELECT email, nama_penanggung_jawab, nama_organisasi FROM pengajuan_rdp WHERE id = ?";
        $stmt_email = $conn->prepare($query_email);
        $stmt_email->bind_param('i', $id);
        $stmt_email->execute();
        $result_email = $stmt_email->get_result();
        $row_email = $result_email->fetch_assoc();
        $email = $row_email['email'];
        $nama = $row_email['nama_penanggung_jawab'];
        $organisasi = $row_email['nama_organisasi'];

        $subject = 'Pengajuan Rapat Dengar Pendapat Ditolak';
        $body = 'Halo ' . htmlspecialchars($nama) . ' dari ' . htmlspecialchars($organisasi) . ',<br><br>Mohon maaf, pengajuan Rapat Dengar Pendapat Anda <b>ditolak</b>.<br>Alasan: ' . htmlspecialchars($alasan_penolakan);
        $altBody = 'Halo ' . $nama . ',\nMohon maaf, pengajuan Rapat Dengar Pendapat Anda ditolak. Alasan: ' . $alasan_penolakan;
        sendMail($email, $nama, $subject, $body, $altBody);
    } elseif ($_POST['action'] == 'resend') {
        // Resend email sesuai status terakhir
        $query_email = "SELECT email, nama_penanggung_jawab, nama_organisasi, status, alasan_penolakan FROM pengajuan_rdp WHERE id = ?";
        $stmt_email = $conn->prepare($query_email);
        $stmt_email->bind_param('i', $id);
        $stmt_email->execute();
        $result_email = $stmt_email->get_result();
        $row_email = $result_email->fetch_assoc();
        $email = $row_email['email'];
        $nama = $row_email['nama_penanggung_jawab'];
        $organisasi = $row_email['nama_organisasi'];

        if ($row_email['status'] == 'disetujui') {
            $subject = 'Pengajuan Rapat Dengar Pendapat Disetujui';
            $body = 'Halo ' . htmlspecialchars($nama) . ' dari ' . htmlspecialchars($organisasi) . ',<br><br>Pengajuan Rapat Dengar Pendapat Anda telah <b>disetujui</b>.<br>Silakan cek dashboard untuk informasi selanjutnya.';
            $altBody = 'Halo ' . $nama . ',\nPengajuan Rapat Dengar Pendapat Anda telah disetujui.';
        } elseif ($row_email['status'] == 'ditolak') {
            $subject = 'Pengajuan Rapat Dengar Pendapat Ditolak';
            $body = 'Halo ' . htmlspecialchars($nama) . ' dari ' . htmlspecialchars($organisasi) . ',<br><br>Mohon maaf, pengajuan Rapat Dengar Pendapat Anda <b>ditolak</b>.<br>Alasan: ' . htmlspecialchars($row_email['alasan_penolakan']);
            $altBody = 'Halo ' . $nama . ',\nMohon maaf, pengajuan Rapat Dengar Pendapat Anda ditolak. Alasan: ' . $row_email['alasan_penolakan'];
        }
        sendMail($email, $nama, $subject, $body, $altBody);
    } elseif ($_POST['action'] == 'arsipkan') {
        // Arsipkan pengajuan
        $query = "UPDATE pengajuan_rdp SET status_data = 'arsip' WHERE id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param('i', $id);
        $stmt->execute();
    }

    header('Location: verifikasi_rdp.php');
    exit();
}

// Ambil data pengajuan RDP dengan status pending
$query = "SELECT * FROM pengajuan_rdp WHERE status = 'pending' OR status_data = 'pending' ORDER BY tanggal_input DESC";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <?php
    $title = 'Pengajuan Rapat Dengar Pendapat';
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
                                    <h2>Data Pengajuan Rapat Dengar Pendapat</h2>
                                    <p class="text-muted fs-14">
                                        Berikut merupakan list data pengajuan Rapat Dengar Pendapat, berikut panduan button dan
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
                                                    <th>Nama Organisasi</th>
                                                    <th>Kategori</th>
                                                    <th>Email</th>
                                                    <th>No. HP</th>
                                                    <th>Alamat</th>
                                                    <th>Tanggal & Jam</th>
                                                    <th>Materi RDP</th>
                                                    <th>Penanggung Jawab</th>
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
                                                        <td><?php echo htmlspecialchars($row['nama_organisasi']); ?></td>
                                                        <td><?php echo htmlspecialchars($row['kategori_organisasi']); ?></td>
                                                        <td><?php echo htmlspecialchars($row['email']); ?></td>
                                                        <td><?php echo htmlspecialchars($row['no_hp']); ?></td>
                                                        <td><?php echo htmlspecialchars(substr($row['alamat'], 0, 30)) . '...'; ?></td>
                                                        <td>
                                                            <?php
                                                            if ($row['tanggal_pengajuan']) {
                                                                echo date('d-m-Y', strtotime($row['tanggal_pengajuan']));
                                                                if ($row['jam_rdp']) {
                                                                    echo '<br>' . date('H:i', strtotime($row['jam_rdp']));
                                                                }
                                                            } else {
                                                                echo 'Menyesuaikan DPRD';
                                                            }
                                                            ?>
                                                        </td>
                                                        <td><?php echo htmlspecialchars(substr($row['materi_rdp'], 0, 50)) . '...'; ?></td>
                                                        <td><?php echo htmlspecialchars($row['nama_penanggung_jawab']); ?></td>
                                                        <td>
                                                            <?php if ($row['file_pdf']): ?>
                                                                <a href="../storage/data-pdf/<?php echo $row['file_pdf']; ?>"
                                                                    target="_blank" class="btn btn-info">View</a>
                                                            <?php else: ?>
                                                                <span class="badge badge-secondary">Tidak Ada</span>
                                                            <?php endif; ?>
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
                                                        <td>
                                                            <?php if ($row['status'] == 'pending'): ?>
                                                                <form method="POST" style="display:inline;">
                                                                    <input type="hidden" name="id"
                                                                        value="<?php echo $row['id']; ?>">
                                                                    <button type="submit" name="action" value="setujui"
                                                                        class="btn btn-success"
                                                                        onclick="return confirm('Apakah Anda yakin ingin menyetujui pengajuan ini?')">Setujui</button>
                                                                </form>
                                                                <button class="btn btn-danger" data-toggle="modal"
                                                                    data-target="#modalTolak"
                                                                    data-id="<?php echo $row['id']; ?>">Tolak</button>
                                                            <?php elseif ($row['status'] == 'disetujui' || $row['status'] == 'ditolak'): ?>
                                                                <form method="POST" style="display:inline;">
                                                                    <input type="hidden" name="id"
                                                                        value="<?php echo $row['id']; ?>">
                                                                    <button type="submit" name="action" value="arsipkan"
                                                                        class="btn btn-primary"
                                                                        onclick="return confirm('Apakah Anda yakin ingin mengarsipkan pengajuan ini?')">Arsip</button>
                                                                </form>
                                                                <form method="POST" style="display:inline;">
                                                                    <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                                                                    <button type="submit" name="action" value="resend" class="btn btn-warning" onclick="return confirm('Kirim ulang email notifikasi ke pendaftar?')">Resend Email</button>
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

            <!-- ============================================================== -->
            <!-- End Page content -->
            <!-- ============================================================== -->

        </div>
        <!-- END wrapper -->

        <!-- Modal Tolak -->
        <div class="modal fade" id="modalTolak" tabindex="-1" role="dialog" aria-labelledby="modalTolakLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalTolakLabel">Alasan Penolakan</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form method="POST">
                        <div class="modal-body">
                            <input type="hidden" name="id" id="tolak_id">
                            <div class="form-group">
                                <label for="alasan_penolakan">Alasan Penolakan</label>
                                <textarea class="form-control" name="alasan_penolakan" rows="4" required></textarea>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                            <button type="submit" name="action" value="tolak" class="btn btn-danger">Tolak
                                Pengajuan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Modal Alasan -->
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
                        <p id="alasan_text"></p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                    </div>
                </div>
            </div>
        </div>

        <?php include 'layouts/script.php'; ?>

        <script>
            $('#modalTolak').on('show.bs.modal', function(event) {
                var button = $(event.relatedTarget);
                var id = button.data('id');
                var modal = $(this);
                modal.find('#tolak_id').val(id);
            });

            $('#modalAlasan').on('show.bs.modal', function(event) {
                var button = $(event.relatedTarget);
                var alasan = button.data('alasan');
                var modal = $(this);
                modal.find('#alasan_text').text(alasan);
            });
        </script>

</body>

</html>