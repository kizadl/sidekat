<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header('Location: login.php');
    exit();
}
include('../config/database.php');

// Mengambil semua data permohonan kunjungan kerja dengan nama kategori instansi
$query = "
    SELECT pk.*, kc.nama_kategori 
    FROM permohonan_kunjungan_kerja pk 
    LEFT JOIN kategori_instansi kc ON pk.kategori_id = kc.id
";
$result = $conn->query($query);

// Proses setujui atau tolak
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    $id = $_POST['id'];
    $status_verifikasi = $_POST['action'] === 'approve' ? 'disetujui' : 'ditolak';

    // Update status verifikasi di database
    $update_query = "UPDATE permohonan_kunjungan_kerja SET status_verifikasi = ? WHERE id = ?";
    $update_stmt = $conn->prepare($update_query);
    $update_stmt->bind_param("si", $status_verifikasi, $id);
    if ($update_stmt->execute()) {
        header('Location: verifikasi_kunjungan_kerja.php'); // Redirect ke halaman verifikasi setelah update
        exit();
    } else {
        echo "Gagal memperbarui status permohonan.";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verifikasi Permohonan Kunjungan Kerja</title>
    <link rel="stylesheet" href="assets/styles.css"> <!-- Link ke file CSS -->
</head>
<body>
    <h1>Verifikasi Permohonan Kunjungan Kerja</h1>
    <table border="1">
        <tr>
            <th>ID</th>
            <th>Email</th>
            <th>Kategori Instansi</th> <!-- Menampilkan nama kategori instansi -->
            <th>Nama Instansi</th>
            <th>Alamat</th>
            <th>Tanggal Kunjungan</th>
            <th>Jam Kunjungan</th>
            <th>Materi Kunjungan</th>
            <th>Pimpinan Rombongan</th>
            <th>Nomor HP</th>
            <th>Status Verifikasi</th>
            <th>Dokumen</th>
            <th>Aksi</th>
        </tr>
        <?php if ($result->num_rows > 0): ?>
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $row['id']; ?></td>
                    <td><?php echo $row['email']; ?></td>
                    <td><?php echo $row['nama_kategori']; ?></td> <!-- Menampilkan nama kategori instansi -->
                    <td><?php echo $row['nama_instansi']; ?></td>
                    <td><?php echo $row['alamat']; ?></td>
                    <td><?php echo $row['tanggal_kunjungan']; ?></td>
                    <td><?php echo $row['jam_kunjungan']; ?></td>
                    <td><?php echo $row['materi_kunjungan']; ?></td>
                    <td><?php echo $row['pimpinan_rombongan']; ?></td>
                    <td><?php echo $row['nomor_hp']; ?></td>
                    <td><?php echo $row['status_verifikasi']; ?></td>
                    <td>
                        <?php if (!empty($row['file_pdf'])): ?>
                            <a href="../assets/uploads/pdf/<?php echo $row['file_pdf']; ?>" target="_blank">Lihat Dokumen</a>
                        <?php else: ?>
                            Tidak Ada Dokumen
                        <?php endif; ?>
                    </td>
                    <td>
                        <form method="POST" style="display: inline;">
                            <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                            <button type="submit" name="action" value="approve">Setujui</button>
                        </form>
                        <form method="POST" style="display: inline;">
                            <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                            <button type="submit" name="action" value="reject">Tolak</button>
                        </form>
                    </td>
                </tr>
            <?php endwhile; ?>
        <?php else: ?>
            <tr>
                <td colspan="13">Tidak ada permohonan kunjungan kerja.</td>
            </tr>
        <?php endif; ?>
    </table>
</body>
</html>
