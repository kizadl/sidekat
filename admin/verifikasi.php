<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header('Location: login.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Halaman Admin</title>
    <link rel="stylesheet" href="assets/styles.css"> <!-- Link ke file CSS -->
</head>
<body>
    <div class="sidebar">
        <h2>Admin Dashboard</h2>
        <ul>
            <li><a href="dashboard.php">Dashboard</a></li>
            <li><a href="manage_kategori_instansi.php">Manage Kategori Instansi</a></li>
            <li><a href="verifikasi_magang.php">Verifikasi Magang</a></li>
            <li><a href="verifikasi_penelitian.php">Verifikasi Penelitian</a></li>
            <li><a href="verifikasi_studi_edukasi.php">Verifikasi Studi Edukasi</a></li>
            <li><a href="verifikasi_kunjungan_kerja.php">Verifikasi Kunjungan Kerja</a></li>
            <li><a href="logout.php">Logout</a></li>
        </ul>
    </div>

    <div class="content">
        <h1>Selamat Datang di Halaman Admin</h1>
        <p>Anda dapat mengelola kategori instansi dan memverifikasi pengajuan di sini.</p>
    </div>
</body>
</html>
