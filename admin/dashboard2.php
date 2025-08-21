<?php
session_start();
if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit();
}
include('../config/database.php');

// Fungsi untuk menghitung total pengajuan dan status
function getStatistics($conn, $table) {
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
        'rejected' => $rejected
    ];
}

// Mengambil statistik untuk semua jenis pengajuan
$statisticsMagang = getStatistics($conn, 'pengajuan_magang');
$statisticsPenelitian = getStatistics($conn, 'pengajuan_penelitian');
$statisticsStudi = getStatistics($conn, 'pengajuan_studi_edukasi');
$statisticsKunjungan = getStatistics($conn, 'permohonan_kunjungan_kerja');

// Query untuk mengambil data pengajuan berdasarkan bulan
function getMonthlyData($conn, $table) {
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
$conn->close();
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        h1, h2, h3 {
            margin-bottom: 10px;
        }
        canvas {
            margin-bottom: 40px;
        }
        .statistic {
            margin-bottom: 20px;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            background-color: #f9f9f9;
        }
    </style>
</head>
<body>

    <h1>Dashboard Pengajuan</h1>

    <div class="statistic">
        <h2>Total Keseluruhan Pengajuan: <?= $totalKeseluruhan ?></h2>
        <h3>Status:</h3>
        <p>Pending: <?= $statisticsMagang['pending'] + $statisticsPenelitian['pending'] + $statisticsStudi['pending'] + $statisticsKunjungan['pending'] ?></p>
        <p>Diterima: <?= $statisticsMagang['accepted'] + $statisticsPenelitian['accepted'] + $statisticsStudi['accepted'] + $statisticsKunjungan['accepted'] ?></p>
        <p>Ditolak: <?= $statisticsMagang['rejected'] + $statisticsPenelitian['rejected'] + $statisticsStudi['rejected'] + $statisticsKunjungan['rejected'] ?></p>
    </div>

    <div class="statistic">
        <h2>Total Pengajuan Magang: <?= $statisticsMagang['total'] ?></h2>
        <h3>Status:</h3>
        <p>Pending: <?= $statisticsMagang['pending'] ?></p>
        <p>Diterima: <?= $statisticsMagang['accepted'] ?></p>
        <p>Ditolak: <?= $statisticsMagang['rejected'] ?></p>
    </div>

    <div class="statistic">
        <h2>Total Pengajuan Penelitian: <?= $statisticsPenelitian['total'] ?></h2>
        <h3>Status:</h3>
        <p>Pending: <?= $statisticsPenelitian['pending'] ?></p>
        <p>Diterima: <?= $statisticsPenelitian['accepted'] ?></p>
        <p>Ditolak: <?= $statisticsPenelitian['rejected'] ?></p>
    </div>

    <div class="statistic">
        <h2>Total Pengajuan Studi Edukasi: <?= $statisticsStudi['total'] ?></h2>
        <h3>Status:</h3>
        <p>Pending: <?= $statisticsStudi['pending'] ?></p>
        <p>Diterima: <?= $statisticsStudi['accepted'] ?></p>
        <p>Ditolak: <?= $statisticsStudi['rejected'] ?></p>
    </div>

    <div class="statistic">
        <h2>Total Permohonan Kunjungan Kerja: <?= $statisticsKunjungan['total'] ?></h2>
        <h3>Status:</h3>
        <p>Pending: <?= $statisticsKunjungan['pending'] ?></p>
        <p>Diterima: <?= $statisticsKunjungan['accepted'] ?></p>
        <p>Ditolak: <?= $statisticsKunjungan['rejected'] ?></p>
    </div>

    <h2>Grafik Total Keseluruhan Pengajuan Per Bulan (Diterima vs Ditolak)</h2>
    <canvas id="totalPengajuanChart"></canvas>

    <h2>Grafik Pengajuan Magang Per Bulan (Diterima vs Ditolak)</h2>
    <canvas id="magangChart"></canvas>

    <h2>Grafik Pengajuan Penelitian Per Bulan (Diterima vs Ditolak)</h2>
    <canvas id="penelitianChart"></canvas>

    <h2>Grafik Pengajuan Studi Edukasi Per Bulan (Diterima vs Ditolak)</h2>
    <canvas id="studiChart"></canvas>

    <h2>Grafik Permohonan Kunjungan Kerja Per Bulan (Diterima vs Ditolak)</h2>
    <canvas id="kunjunganChart"></canvas>

    <script>
        const totalDiterima = <?= json_encode(array_column(array_merge($dataMagangDiterima, $dataPenelitianDiterima, $dataStudiDiterima, $dataKunjunganDiterima), 'total')) ?>;
        const totalDitolak = <?= json_encode(array_column(array_merge($dataMagangDitolak, $dataPenelitianDitolak, $dataStudiDitolak, $dataKunjunganDitolak), 'total')) ?>;
        const labelsTotal = <?= json_encode(array_unique(array_merge(array_column($dataMagangDiterima, 'bulan'), array_column($dataMagangDitolak, 'bulan')))) ?>;

        const magangDiterima = <?= json_encode(array_column($dataMagangDiterima, 'total')) ?>;
        const magangDitolak = <?= json_encode(array_column($dataMagangDitolak, 'total')) ?>;
        const labelsMagang = <?= json_encode(array_unique(array_merge(array_column($dataMagangDiterima, 'bulan'), array_column($dataMagangDitolak, 'bulan')))) ?>;

        const penelitianDiterima = <?= json_encode(array_column($dataPenelitianDiterima, 'total')) ?>;
        const penelitianDitolak = <?= json_encode(array_column($dataPenelitianDitolak, 'total')) ?>;
        const labelsPenelitian = <?= json_encode(array_unique(array_merge(array_column($dataPenelitianDiterima, 'bulan'), array_column($dataPenelitianDitolak, 'bulan')))) ?>;

        const studiDiterima = <?= json_encode(array_column($dataStudiDiterima, 'total')) ?>;
        const studiDitolak = <?= json_encode(array_column($dataStudiDitolak, 'total')) ?>;
        const labelsStudi = <?= json_encode(array_unique(array_merge(array_column($dataStudiDiterima, 'bulan'), array_column($dataStudiDitolak, 'bulan')))) ?>;

        const kunjunganDiterima = <?= json_encode(array_column($dataKunjunganDiterima, 'total')) ?>;
        const kunjunganDitolak = <?= json_encode(array_column($dataKunjunganDitolak, 'total')) ?>;
        const labelsKunjungan = <?= json_encode(array_unique(array_merge(array_column($dataKunjunganDiterima, 'bulan'), array_column($dataKunjunganDitolak, 'bulan')))) ?>;

        // Create bar chart for Total Pengajuan
        const totalChartCtx = document.getElementById('totalPengajuanChart').getContext('2d');
        const totalChart = new Chart(totalChartCtx, {
            type: 'bar',
            data: {
                labels: labelsTotal,
                datasets: [
                    {
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
                datasets: [
                    {
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
                datasets: [
                    {
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
                datasets: [
                    {
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
                datasets: [
                    {
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
