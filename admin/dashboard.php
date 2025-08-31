<?php
session_start();
if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit();
}
include '../config/database.php';

// Fungsi untuk menghitung total pengajuan dan status
function getStatistics($conn, $table)
{
    $totalQuery = "SELECT COUNT(*) AS total FROM $table";
    $pendingQuery = "SELECT COUNT(*) AS total FROM $table WHERE status = 'pending'";
    $acceptedQuery = "SELECT COUNT(*) AS total FROM $table WHERE status = 'disetujui'";
    $rejectedQuery = "SELECT COUNT(*) AS total FROM $table WHERE status = 'ditolak'";

    $total = $conn->query($totalQuery)->fetch_assoc()['total'];
    $pending = $conn->query($pendingQuery)->fetch_assoc()['total'];
    $accepted = $conn->query($acceptedQuery)->fetch_assoc()['total'];
    $rejected = $conn->query($rejectedQuery)->fetch_assoc()['total'];

    return [
        'total' => $total,
        'pending' => $pending,
        'accepted' => $accepted,
        'rejected' => $rejected,
    ];
}

// Mengambil statistik untuk semua jenis pengajuan
$statisticsMagang = getStatistics($conn, 'pengajuan_magang');
$statisticsPenelitian = getStatistics($conn, 'pengajuan_penelitian');
$statisticsStudi = getStatistics($conn, 'pengajuan_studi_edukasi');
$statisticsKunjungan = getStatistics($conn, 'permohonan_kunjungan_kerja');

// Query untuk mengambil data pengajuan berdasarkan bulan
function getMonthlyData($conn, $table)
{
    $queryDiterima = "
        SELECT DATE_FORMAT(tanggal_input, '%Y-%m') AS bulan, COUNT(*) AS total
        FROM $table WHERE status = 'disetujui'
        GROUP BY bulan
        ORDER BY bulan";

    $queryDitolak = "
        SELECT DATE_FORMAT(tanggal_input, '%Y-%m') AS bulan, COUNT(*) AS total
        FROM $table WHERE status = 'ditolak'
        GROUP BY bulan
        ORDER BY bulan";

    $resultDiterima = $conn->query($queryDiterima);
    $resultDitolak = $conn->query($queryDitolak);

    $dataDiterima = [];
    $dataDitolak = [];

    while ($row = $resultDiterima->fetch_assoc()) {
        $dataDiterima[] = $row;
    }
    while ($row = $resultDitolak->fetch_assoc()) {
        $dataDitolak[] = $row;
    }

    return [$dataDiterima, $dataDitolak];
}

// Mengambil data bulanan untuk semua jenis pengajuan
[$dataMagangDiterima, $dataMagangDitolak] = getMonthlyData($conn, 'pengajuan_magang');
[$dataPenelitianDiterima, $dataPenelitianDitolak] = getMonthlyData($conn, 'pengajuan_penelitian');
[$dataStudiDiterima, $dataStudiDitolak] = getMonthlyData($conn, 'pengajuan_studi_edukasi');
[$dataKunjunganDiterima, $dataKunjunganDitolak] = getMonthlyData($conn, 'permohonan_kunjungan_kerja');

// Total keseluruhan pengajuan
$totalKeseluruhan = $statisticsMagang['total'] + $statisticsPenelitian['total'] + $statisticsStudi['total'] + $statisticsKunjungan['total'];

// Menutup koneksi database
// Query statistik IKM 12 bulan terakhir untuk 4 kriteria

// Generate 12 bulan terakhir
$ikmLabels = [];
$ikmJwb1 = [];
$ikmJwb2 = [];
$ikmJwb3 = [];
$ikmJwb4 = [];
$bulanMap = [];
for ($i = 11; $i >= 0; $i--) {
    $dt = new DateTime();
    $dt->modify("-{$i} month");
    $key = $dt->format('Y-m');
    $ikmLabels[] = $dt->format('M Y');
    $bulanMap[$key] = count($bulanMap);
    $ikmJwb1[] = 0;
    $ikmJwb2[] = 0;
    $ikmJwb3[] = 0;
    $ikmJwb4[] = 0;
}

$queryIKM = "
    SELECT 
        DATE_FORMAT(s.tanggal, '%Y-%m') AS bulan,
        SUM(CASE WHEN d.jawaban = '1' THEN 1 ELSE 0 END) AS jwb1,
        SUM(CASE WHEN d.jawaban = '2' THEN 1 ELSE 0 END) AS jwb2,
        SUM(CASE WHEN d.jawaban = '3' THEN 1 ELSE 0 END) AS jwb3,
        SUM(CASE WHEN d.jawaban = '4' THEN 1 ELSE 0 END) AS jwb4
    FROM ikm_survei s
    JOIN ikm_detail_survei d ON s.id = d.id_survei
    WHERE s.tanggal >= DATE_FORMAT(DATE_SUB(NOW(), INTERVAL 11 MONTH), '%Y-%m-01')
    GROUP BY bulan
    ORDER BY bulan ASC
    ";
$resultIKM = $conn->query($queryIKM);
while ($row = $resultIKM->fetch_assoc()) {
    $idx = isset($bulanMap[$row['bulan']]) ? $bulanMap[$row['bulan']] : null;
    if ($idx !== null) {
        $ikmJwb1[$idx] = (int) $row['jwb1'];
        $ikmJwb2[$idx] = (int) $row['jwb2'];
        $ikmJwb3[$idx] = (int) $row['jwb3'];
        $ikmJwb4[$idx] = (int) $row['jwb4'];
    }
}

// Query untuk daftar pertanyaan IKM
$queryDaftarSoal = "SELECT id, pertanyaan FROM ikm_soal ORDER BY id";
$resultDaftarSoal = $conn->query($queryDaftarSoal);
$daftarSoal = [];
while ($row = $resultDaftarSoal->fetch_assoc()) {
    $daftarSoal[] = $row;
}

// Query untuk rekapitulasi persentase jawaban
$queryPerSoal = "
    SELECT 
        s.pertanyaan,
        COUNT(d.id) as total_jawaban,
        SUM(CASE WHEN d.jawaban = '1' THEN 1 ELSE 0 END) AS tidak_puas,
        SUM(CASE WHEN d.jawaban = '2' THEN 1 ELSE 0 END) AS kurang_puas,
        SUM(CASE WHEN d.jawaban = '3' THEN 1 ELSE 0 END) AS puas,
        SUM(CASE WHEN d.jawaban = '4' THEN 1 ELSE 0 END) AS sangat_puas,
        ROUND(SUM(CASE WHEN d.jawaban = '1' THEN 1 ELSE 0 END) / COUNT(d.id) * 100, 2) AS persen_tidak_puas,
        ROUND(SUM(CASE WHEN d.jawaban = '2' THEN 1 ELSE 0 END) / COUNT(d.id) * 100, 2) AS persen_kurang_puas,
        ROUND(SUM(CASE WHEN d.jawaban = '3' THEN 1 ELSE 0 END) / COUNT(d.id) * 100, 2) AS persen_puas,
        ROUND(SUM(CASE WHEN d.jawaban = '4' THEN 1 ELSE 0 END) / COUNT(d.id) * 100, 2) AS persen_sangat_puas
    FROM ikm_soal s
    LEFT JOIN ikm_detail_survei d ON s.id = d.id_soal
    LEFT JOIN ikm_survei surv ON d.id_survei = surv.id
    WHERE surv.tanggal >= DATE_SUB(CURDATE(), INTERVAL 12 MONTH)
    GROUP BY s.id, s.pertanyaan
    ORDER BY s.id";

$resultPerSoal = $conn->query($queryPerSoal);
$rekapitulasiData = [];
while ($row = $resultPerSoal->fetch_assoc()) {
    $rekapitulasiData[] = $row;
}

// Query untuk detail survei per responden
$queryDetailSurvei = "
    SELECT 
        s.nama AS nama_responden,
        s.umur,
        s.kelamin,
        p.nama AS nama_pendidikan,
        pk.nama AS nama_pekerjaan,
        GROUP_CONCAT(ds.jawaban ORDER BY ds.id_soal) as jawaban_soal
    FROM ikm_survei s
    LEFT JOIN ikm_pendidikan p ON s.id_pendidikan = p.id
    LEFT JOIN ikm_pekerjaan pk ON s.id_pekerjaan = pk.id
    LEFT JOIN ikm_detail_survei ds ON s.id = ds.id_survei
    WHERE s.tanggal >= DATE_SUB(CURDATE(), INTERVAL 12 MONTH)
    GROUP BY s.id, s.nama, s.umur, s.kelamin, p.nama, pk.nama
    ORDER BY s.tanggal DESC";

$resultDetailSurvei = $conn->query($queryDetailSurvei);
$detailSurveiData = [];
while ($row = $resultDetailSurvei->fetch_assoc()) {
    $detailSurveiData[] = $row;
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <?php
    $title = 'Dashboard';
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
                            <div class="card text-bg-primary">
                                <div class="card-body">
                                    <h2>Dashboard DND Sidekat</h2>
                                </div> <!-- end card body-->
                            </div> <!-- end card -->
                        </div>
                        
                        <div class="col-sm-4">
                            <div class="card widget-icon-box h-100">
                                <div class="card-body d-flex flex-column">
                                    <div class="d-flex justify-content-between h-100">
                                        <div
                                            class="flex-grow-1 overflow-hidden d-flex flex-column justify-content-between">
                                            <h3 class="text-muted text-uppercase fs-30 mt-2"
                                                title="Number of Customers">Total Pengajuan</h3>
                                            <h1 class="mb-4 mt-3 text-center display-4"><?= $totalKeseluruhan ?></h1>
                                            <p class="mb-2">
                                                <span class="badge bg-warning me-1"><i
                                                        class="ri-arrow-up-line"></i>Pending</span>
                                                <span
                                                    class="me-2"><?= $statisticsMagang['pending'] + $statisticsPenelitian['pending'] + $statisticsStudi['pending'] + $statisticsKunjungan['pending'] ?></span>
                                                <span class="badge bg-success me-1"><i
                                                        class="ri-arrow-up-line"></i>Disetujui</span>
                                                <span
                                                    class="me-2"><?= $statisticsMagang['accepted'] + $statisticsPenelitian['accepted'] + $statisticsStudi['accepted'] + $statisticsKunjungan['accepted'] ?></span>
                                                <span class="badge bg-danger me-1"><i
                                                        class="ri-arrow-up-line"></i>Ditolak</span>
                                                <span
                                                    class="me-2"><?= $statisticsMagang['rejected'] + $statisticsPenelitian['rejected'] + $statisticsStudi['rejected'] + $statisticsKunjungan['rejected'] ?></span>
                                            </p>
                                        </div>
                                        <div class="avatar-sm flex-shrink-0">
                                            <span
                                                class="avatar-title text-bg-success rounded rounded-3 fs-3 widget-icon-box-avatar shadow">
                                                <i class="ri-group-line"></i>
                                            </span>
                                        </div>
                                    </div>
                                </div> <!-- end card-body-->
                            </div> <!-- end card-->
                        </div> <!-- end col-->
                        <div class="col-sm-4">
                            <div class="card widget-icon-box">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between">
                                        <div class="flex-grow-1 overflow-hidden">
                                            <h5 class="text-muted text-uppercase fs-20 mt-0"
                                                title="Number of Customers">Magang</h5>
                                            <h3 class="my-3"><?= $statisticsMagang['total'] ?></h3>
                                            <p class="mb-2">
                                                <span class="badge bg-warning me-1"><i
                                                        class="ri-arrow-up-line"></i>Pending</span>
                                                <span class="me-2"><?= $statisticsMagang['pending'] ?></span>
                                                <span class="badge bg-success me-1"><i
                                                        class="ri-arrow-up-line"></i>Disetujui</span>
                                                <span class="me-2"><?= $statisticsMagang['accepted'] ?></span>
                                                <span class="badge bg-danger me-1"><i
                                                        class="ri-arrow-up-line"></i>Ditolak</span>
                                                <span class="me-2"><?= $statisticsMagang['rejected'] ?></span>
                                            </p>
                                        </div>
                                        <div class="avatar-sm flex-shrink-0">
                                            <span
                                                class="avatar-title text-bg-info rounded rounded-3 fs-3 widget-icon-box-avatar shadow">
                                                <i class="ri-survey-fill"></i>
                                            </span>
                                        </div>
                                    </div>
                                </div> <!-- end card-body-->
                            </div> <!-- end card-->
                            <div class="card widget-icon-box">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between">
                                        <div class="flex-grow-1 overflow-hidden">
                                            <h5 class="text-muted text-uppercase fs-20 mt-0"
                                                title="Number of Customers">Penelitian</h5>
                                            <h3 class="my-3"><?= $statisticsPenelitian['total'] ?></h3>
                                            <p class="mb-2">
                                                <span class="badge bg-warning me-1"><i
                                                        class="ri-arrow-up-line"></i>Pending</span>
                                                <span class="me-2"><?= $statisticsPenelitian['pending'] ?></span>
                                                <span class="badge bg-success me-1"><i
                                                        class="ri-arrow-up-line"></i>Disetujui</span>
                                                <span class="me-2"><?= $statisticsPenelitian['accepted'] ?></span>
                                                <span class="badge bg-danger me-1"><i
                                                        class="ri-arrow-up-line"></i>Ditolak</span>
                                                <span class="me-2"><?= $statisticsPenelitian['rejected'] ?></span>
                                            </p>
                                        </div>
                                        <div class="avatar-sm flex-shrink-0">
                                            <span
                                                class="avatar-title text-bg-danger rounded rounded-3 fs-3 widget-icon-box-avatar shadow">
                                                <i class=" ri-microscope-fill"></i>
                                            </span>
                                        </div>
                                    </div>
                                </div> <!-- end card-body-->
                            </div> <!-- end card-->
                        </div> <!-- end col-->
                        <div class="col-sm-4">
                            <div class="card widget-icon-box">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between">
                                        <div class="flex-grow-1 overflow-hidden">
                                            <h5 class="text-muted text-uppercase fs-20 mt-0"
                                                title="Number of Customers">Studi edukasi</h5>
                                            <h3 class="my-3"><?= $statisticsStudi['total'] ?></h3>
                                            <p class="mb-2">
                                                <span class="badge bg-warning me-1"><i
                                                        class="ri-arrow-up-line"></i>Pending</span>
                                                <span class="me-2"><?= $statisticsStudi['pending'] ?></span>
                                                <span class="badge bg-success me-1"><i
                                                        class="ri-arrow-up-line"></i>Disetujui</span>
                                                <span class="me-2"><?= $statisticsStudi['accepted'] ?></span>
                                                <span class="badge bg-danger me-1"><i
                                                        class="ri-arrow-up-line"></i>Ditolak</span>
                                                <span class="me-2"><?= $statisticsStudi['rejected'] ?></span>
                                            </p>
                                        </div>
                                        <div class="avatar-sm flex-shrink-0">
                                            <span
                                                class="avatar-title text-bg-primary rounded rounded-3 fs-3 widget-icon-box-avatar shadow">
                                                <i class=" ri-graduation-cap-fill"></i>
                                            </span>
                                        </div>
                                    </div>
                                </div> <!-- end card-body-->
                            </div> <!-- end card-->
                            <div class="card widget-icon-box">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between">
                                        <div class="flex-grow-1 overflow-hidden">
                                            <h5 class="text-muted text-uppercase fs-20 mt-0"
                                                title="Number of Customers">Kunjungan Kerja</h5>
                                            <h3 class="my-3"><?= $statisticsKunjungan['total'] ?></h3>
                                            <p class="mb-2">
                                                <span class="badge bg-warning me-1"><i
                                                        class="ri-arrow-up-line"></i>Pending</span>
                                                <span class="me-1"><?= $statisticsKunjungan['pending'] ?></span>
                                                <span class="badge bg-success me-1"><i
                                                        class="ri-arrow-up-line"></i>Disetujui</span>
                                                <span class="me-1"><?= $statisticsKunjungan['accepted'] ?></span>
                                                <span class="badge bg-danger me-1"><i
                                                        class="ri-arrow-up-line"></i>Ditolak</span>
                                                <span><?= $statisticsKunjungan['rejected'] ?></span>
                                            </p>
                                        </div>
                                        <div class="avatar-sm flex-shrink-0">
                                            <span
                                                class="avatar-title text-bg-warning rounded rounded-3 fs-3 widget-icon-box-avatar">
                                                <i class="ri-briefcase-5-fill"></i>
                                            </span>
                                        </div>
                                    </div>
                                </div> <!-- end card-body-->
                            </div> <!-- end card-->
                        </div> <!-- end col-->
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title">Statistik Survei IKM 12 Bulan Terakhir</h4>
                                    <div id="ikmApexChart"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Tabel Rekapitulasi Jawaban IKM -->
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title">Rekapitulasi Jawaban IKM 12 Bulan Terakhir</h4>
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-centered mb-0">
                                            <thead>
                                                <tr>
                                                    <th>Unsur Pelayanan</th>
                                                    <th class="text-center text-danger">Tidak Puas</th>
                                                    <th class="text-center text-warning">Kurang Puas</th>
                                                    <th class="text-center text-success">Puas</th>
                                                    <th class="text-center text-primary">Sangat Puas</th>
                                                    <th class="text-center">Total</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                foreach ($rekapitulasiData as $row) {
                                                    echo '<tr>';
                                                    echo "<td>{$row['pertanyaan']}</td>";
                                                    echo "<td class='text-center text-danger'>{$row['persen_tidak_puas']}% <small class='text-muted'>({$row['tidak_puas']})</small></td>";
                                                    echo "<td class='text-center text-warning'>{$row['persen_kurang_puas']}% <small class='text-muted'>({$row['kurang_puas']})</small></td>";
                                                    echo "<td class='text-center text-success'>{$row['persen_puas']}% <small class='text-muted'>({$row['puas']})</small></td>";
                                                    echo "<td class='text-center text-primary'>{$row['persen_sangat_puas']}% <small class='text-muted'>({$row['sangat_puas']})</small></td>";
                                                    echo "<td class='text-center'>{$row['total_jawaban']}</td>";
                                                    echo '</tr>';
                                                }
                                                ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Tabel Detail Survei IKM -->
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title">Detail Survei IKM</h4>
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-centered mb-0">
                                            <thead>
                                                <tr>
                                                    <th>Nama</th>
                                                    <th>Umur</th>
                                                    <th>Kelamin</th>
                                                    <th>Pendidikan</th>
                                                    <th>Pekerjaan</th>
                                                    <?php
                                                    $i = 1;
                                                    foreach ($daftarSoal as $soal) {
                                                        echo "<th title='{$soal['pertanyaan']}'>U{$i}</th>";
                                                        $i++;
                                                    }
                                                    ?>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                foreach ($detailSurveiData as $row) {
                                                    echo '<tr>';
                                                    echo "<td>{$row['nama_responden']}</td>";
                                                    echo "<td>{$row['umur']}</td>";
                                                    echo "<td>{$row['kelamin']}</td>";
                                                    echo "<td>{$row['nama_pendidikan']}</td>";
                                                    echo "<td>{$row['nama_pekerjaan']}</td>";
                                                    
                                                    // Pisahkan jawaban menjadi array
                                                    $jawaban = explode(',', $row['jawaban_soal']);
                                                    foreach ($jawaban as $j) {
                                                        echo "<td class='text-center'>{$j}</td>";
                                                    }
                                                    echo '</tr>';
                                                }
                                                ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
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
            <div class="modal fade" id="modalAlasan" tabindex="-1" role="dialog"
                aria-labelledby="modalAlasanLabel" aria-hidden="true">
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

    <!-- ApexCharts -->
    <script src="assets/vendor/apexcharts/apexcharts.min.js"></script>
    <script>
        // Data IKM untuk chart
        const ikmLabels = <?= json_encode($ikmLabels) ?>;
        const ikmJwb1 = <?= json_encode($ikmJwb1) ?>;
        const ikmJwb2 = <?= json_encode($ikmJwb2) ?>;
        const ikmJwb3 = <?= json_encode($ikmJwb3) ?>;
        const ikmJwb4 = <?= json_encode($ikmJwb4) ?>;

        var options = {
            chart: {
                type: 'line',
                height: 350,
                toolbar: {
                    show: false
                },
                zoom: {
                    enabled: false
                }
            },
            series: [{
                    name: 'Tidak Puas',
                    data: ikmJwb1,
                    color: '#dc3545',
                },
                {
                    name: 'Kurang Puas',
                    data: ikmJwb2,
                    color: '#fd7e14',
                },
                {
                    name: 'Puas',
                    data: ikmJwb3,
                    color: '#198754',
                },
                {
                    name: 'Sangat Puas',
                    data: ikmJwb4,
                    color: '#0d6efd',
                }
            ],
            xaxis: {
                categories: ikmLabels,
                title: {
                    text: 'Bulan'
                }
            },
            yaxis: {
                title: {
                    text: 'Jumlah Jawaban'
                },
                min: 0,
                tickAmount: undefined,
                forceNiceScale: true,
                labels: {
                    formatter: function(val) {
                        return Math.round(val);
                    }
                },
                stepSize: 1
            },
            dataLabels: {
                enabled: true
            },
            stroke: {
                curve: 'smooth'
            },
            legend: {
                position: 'top',
                horizontalAlign: 'right',
            }
        };
        var chart = new ApexCharts(document.querySelector("#ikmApexChart"), options);
        chart.render();
        const totalDiterima =
            <?= json_encode(array_column(array_merge($dataMagangDiterima, $dataPenelitianDiterima, $dataStudiDiterima, $dataKunjunganDiterima), 'total')) ?>;
        const totalDitolak =
            <?= json_encode(array_column(array_merge($dataMagangDitolak, $dataPenelitianDitolak, $dataStudiDitolak, $dataKunjunganDitolak), 'total')) ?>;
        const labelsTotal =
            <?= json_encode(array_unique(array_merge(array_column($dataMagangDiterima, 'bulan'), array_column($dataMagangDitolak, 'bulan')))) ?>;

        const magangDiterima = <?= json_encode(array_column($dataMagangDiterima, 'total')) ?>;
        const magangDitolak = <?= json_encode(array_column($dataMagangDitolak, 'total')) ?>;
        const labelsMagang =
            <?= json_encode(array_unique(array_merge(array_column($dataMagangDiterima, 'bulan'), array_column($dataMagangDitolak, 'bulan')))) ?>;

        const penelitianDiterima = <?= json_encode(array_column($dataPenelitianDiterima, 'total')) ?>;
        const penelitianDitolak = <?= json_encode(array_column($dataPenelitianDitolak, 'total')) ?>;
        const labelsPenelitian =
            <?= json_encode(array_unique(array_merge(array_column($dataPenelitianDiterima, 'bulan'), array_column($dataPenelitianDitolak, 'bulan')))) ?>;

        const studiDiterima = <?= json_encode(array_column($dataStudiDiterima, 'total')) ?>;
        const studiDitolak = <?= json_encode(array_column($dataStudiDitolak, 'total')) ?>;
        const labelsStudi =
            <?= json_encode(array_unique(array_merge(array_column($dataStudiDiterima, 'bulan'), array_column($dataStudiDitolak, 'bulan')))) ?>;

        const kunjunganDiterima = <?= json_encode(array_column($dataKunjunganDiterima, 'total')) ?>;
        const kunjunganDitolak = <?= json_encode(array_column($dataKunjunganDitolak, 'total')) ?>;
        const labelsKunjungan =
            <?= json_encode(array_unique(array_merge(array_column($dataKunjunganDiterima, 'bulan'), array_column($dataKunjunganDitolak, 'bulan')))) ?>;

        // Create bar chart for Total Pengajuan
        const totalChartCtx = document.getElementById('totalPengajuanChart').getContext('2d');
        const totalChart = new Chart(totalChartCtx, {
            type: 'bar',
            data: {
                labels: labelsTotal,
                datasets: [{
                        label: 'Diterima',
                        data: totalDiterima,
                        backgroundColor: 'rgba(75, 192, 192, 0.6)',
                    },
                    {
                        label: 'Ditolak',
                        data: totalDitolak,
                        backgroundColor: 'rgba(255, 99, 132, 0.6)',
                    }
                ]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        // Create bar chart for Pengajuan Magang
        const magangChartCtx = document.getElementById('magangChart').getContext('2d');
        const magangChart = new Chart(magangChartCtx, {
            type: 'bar',
            data: {
                labels: labelsMagang,
                datasets: [{
                        label: 'Diterima',
                        data: magangDiterima,
                        backgroundColor: 'rgba(75, 192, 192, 0.6)',
                    },
                    {
                        label: 'Ditolak',
                        data: magangDitolak,
                        backgroundColor: 'rgba(255, 99, 132, 0.6)',
                    }
                ]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        // Create bar chart for Pengajuan Penelitian
        const penelitianChartCtx = document.getElementById('penelitianChart').getContext('2d');
        const penelitianChart = new Chart(penelitianChartCtx, {
            type: 'bar',
            data: {
                labels: labelsPenelitian,
                datasets: [{
                        label: 'Diterima',
                        data: penelitianDiterima,
                        backgroundColor: 'rgba(75, 192, 192, 0.6)',
                    },
                    {
                        label: 'Ditolak',
                        data: penelitianDitolak,
                        backgroundColor: 'rgba(255, 99, 132, 0.6)',
                    }
                ]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        // Create bar chart for Pengajuan Studi Edukasi
        const studiChartCtx = document.getElementById('studiChart').getContext('2d');
        const studiChart = new Chart(studiChartCtx, {
            type: 'bar',
            data: {
                labels: labelsStudi,
                datasets: [{
                        label: 'Diterima',
                        data: studiDiterima,
                        backgroundColor: 'rgba(75, 192, 192, 0.6)',
                    },
                    {
                        label: 'Ditolak',
                        data: studiDitolak,
                        backgroundColor: 'rgba(255, 99, 132, 0.6)',
                    }
                ]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        // Create bar chart for Permohonan Kunjungan Kerja
        const kunjunganChartCtx = document.getElementById('kunjunganChart').getContext('2d');
        const kunjunganChart = new Chart(kunjunganChartCtx, {
            type: 'bar',
            data: {
                labels: labelsKunjungan,
                datasets: [{
                        label: 'Diterima',
                        data: kunjunganDiterima,
                        backgroundColor: 'rgba(75, 192, 192, 0.6)',
                    },
                    {
                        label: 'Ditolak',
                        data: kunjunganDitolak,
                        backgroundColor: 'rgba(255, 99, 132, 0.6)',
                    }
                ]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>
</body>

</html>
