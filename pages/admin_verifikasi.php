<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header('Location: login.php');
    exit();
}
include('../config/database.php');

// Mengambil data dari tabel pengajuan
$magang_sql = "SELECT * FROM pengajuan_magang";
$penelitian_sql = "SELECT * FROM pengajuan_penelitian";
$studi_sql = "SELECT * FROM studi_edukasi";
$kunjungan_sql = "SELECT * FROM kunjungan_kerja";

$magang_result = $conn->query($magang_sql);
$penelitian_result = $conn->query($penelitian_sql);
$studi_result = $conn->query($studi_sql);
$kunjungan_result = $conn->query($kunjungan_sql);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verifikasi Pengajuan</title>
    <link rel="stylesheet" href="assets/styles.css"> <!-- Link ke file CSS -->
</head>
<body>
    <div class="sidebar">
        <h2>Dashboard Admin</h2>
        <ul>
            <li><a href="admin_verifikasi.php">Verifikasi Pengajuan Magang</a></li>
            <li><a href="admin_verifikasi.php#penelitian">Verifikasi Penelitian</a></li>
            <li><a href="admin_verifikasi.php#studi">Verifikasi Studi Edukasi</a></li>
            <li><a href="admin_verifikasi.php#kunjungan">Verifikasi Kunjungan Kerja</a></li>
            <li><a href="logout.php">Logout</a></li>
        </ul>
    </div>
    <div class="content">
        <h1>Verifikasi Pengajuan</h1>
        
        <h2 id="magang">Pengajuan Magang</h2>
        <table border="1">
            <tr>
                <th>ID</th>
                <th>Nama</th>
                <th>Email</th>
                <th>Tanggal Pengajuan</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
            <?php if ($magang_result->num_rows > 0): ?>
                <?php while ($row = $magang_result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $row['id']; ?></td>
                        <td><?php echo $row['nama']; ?></td>
                        <td><?php echo $row['email']; ?></td>
                        <td><?php echo $row['tanggal_pengajuan']; ?></td>
                        <td><?php echo $row['status']; ?></td>
                        <td>
                            <a href='verifikasi_magang.php?id=<?php echo $row['id']; ?>'>Verifikasi</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="6">Tidak ada pengajuan magang.</td>
                </tr>
            <?php endif; ?>
        </table>

        <h2 id="penelitian">Pengajuan Penelitian</h2>
        <table border="1">
            <tr>
                <th>ID</th>
                <th>Nama</th>
                <th>Email</th>
                <th>Tanggal Pengajuan</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
            <?php if ($penelitian_result->num_rows > 0): ?>
                <?php while ($row = $penelitian_result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $row['id']; ?></td>
                        <td><?php echo $row['nama']; ?></td>
                        <td><?php echo $row['email']; ?></td>
                        <td><?php echo $row['tanggal_pengajuan']; ?></td>
                        <td><?php echo $row['status']; ?></td>
                        <td>
                            <a href='verifikasi_penelitian.php?id=<?php echo $row['id']; ?>'>Verifikasi</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="6">Tidak ada pengajuan penelitian.</td>
                </tr>
            <?php endif; ?>
        </table>

        <h2 id="studi">Pengajuan Studi Edukasi</h2>
        <table border="1">
            <tr>
                <th>ID</th>
                <th>Nama</th>
                <th>Email</th>
                <th>Tanggal Pengajuan</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
            <?php if ($studi_result->num_rows > 0): ?>
                <?php while ($row = $studi_result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $row['id']; ?></td>
                        <td><?php echo $row['nama']; ?></td>
                        <td><?php echo $row['email']; ?></td>
                        <td><?php echo $row['tanggal_pengajuan']; ?></td>
                        <td><?php echo $row['status']; ?></td>
                        <td>
                            <a href='verifikasi_studi.php?id=<?php echo $row['id']; ?>'>Verifikasi</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="6">Tidak ada pengajuan studi edukasi.</td>
                </tr>
            <?php endif; ?>
        </table>

        <h2 id="kunjungan">Permohonan Kunjungan Kerja</h2>
        <table border="1">
            <tr>
                <th>ID</th>
                <th>Email</th>
                <th>Kategori Instansi</th>
                <th>Nama Instansi</th>
                <th>Tanggal Kunjungan</th>
                <th>Jam Kunjungan</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
            <?php if ($kunjungan_result->num_rows > 0): ?>
                <?php while ($row = $kunjungan_result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $row['id']; ?></td>
                        <td><?php echo $row['email']; ?></td>
                        <td><?php echo $row['kategori_instansi']; ?></td>
                        <td><?php echo $row['nama_instansi']; ?></td>
                        <td><?php echo $row['tanggal_kunjungan']; ?></td>
                        <td><?php echo $row['jam_kunjungan']; ?></td>
                        <td><?php echo $row['status']; ?></td>
                        <td>
                            <a href='verifikasi_kunjungan.php?id=<?php echo $row['id']; ?>'>Verifikasi</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="8">Tidak ada permohonan kunjungan kerja.</td>
                </tr>
            <?php endif; ?>
        </table>

    </div>
</body>
</html>
