<?php
session_start();
if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit();
}

include '../config/database.php'; // Koneksi ke database

// Ambil data pengajuan RDP dengan status arsip
$query = "SELECT * FROM pengajuan_rdp WHERE (status = 'disetujui' OR status = 'ditolak') AND status_data = 'arsip' ORDER BY tanggal_input DESC";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <?php
    $title = 'Arsip Rapat Dengar Pendapat';
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
                                    <h2>Arsip Data Pengajuan Rapat Dengar Pendapat</h2>
                                    <p class="text-muted fs-14">
                                        Berikut merupakan list arsip data pengajuan Rapat Dengar Pendapat yang telah diproses.
                                        Untuk <b><i>Melihat dokumen</i></b> silahkan klik icon <i
                                            class="ri-file-text-line"></i>.
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
            $('#modalAlasan').on('show.bs.modal', function(event) {
                var button = $(event.relatedTarget);
                var alasan = button.data('alasan');
                var modal = $(this);
                modal.find('#alasan_text').text(alasan);
            });
        </script>

</body>

</html>