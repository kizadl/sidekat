<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header('Location: login.php');
    exit();
}
include('../config/database.php');

// Mengambil semua data pengajuan magang
$query = "SELECT * FROM pengajuan_magang";
$result = $conn->query($query);

// Proses setujui atau tolak
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    $id = $_POST['id'];
    $status = $_POST['action'] === 'approve' ? 'disetujui' : 'ditolak';

    // Update status di database
    $update_query = "UPDATE pengajuan_magang SET status = ? WHERE id = ?";
    $update_stmt = $conn->prepare($update_query);
    $update_stmt->bind_param("si", $status, $id);
    if ($update_stmt->execute()) {
        header('Location: verifikasi_magang_list.php'); // Redirect ke halaman verifikasi setelah update
        exit();
    } else {
        echo "Gagal memperbarui status pengajuan.";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verifikasi Pengajuan Magang</title>
    <link rel="stylesheet" href="assets/styles.css"> <!-- Link ke file CSS -->
</head>
<body>
    <h1>Verifikasi Pengajuan Magang</h1>
    <table border="1">
        <tr>
            <th>ID</th>
            <th>Nama</th>
            <th>Email</th>
            <th>Tanggal Pengajuan</th>
            <th>Status</th>
            <th>Dokumen</th> <!-- Kolom untuk dokumen -->
            <th>Aksi</th>
        </tr>
        <?php if ($result->num_rows > 0): ?>
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $row['id']; ?></td>
                    <td><?php echo $row['nama']; ?></td>
                    <td><?php echo $row['email']; ?></td>
                    <td><?php echo $row['tanggal_input']; ?></td>
                    <td>
                        <a href="../assets/uploads/pdf/<?php echo $row['file_pdf']; ?>" target="_blank">Lihat Dokumen</a> <!-- Tautan untuk melihat dokumen -->
                    </td>
                    <td><?php echo $row['status']; ?></td>
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
                <td colspan="7">Tidak ada pengajuan magang.</td> <!-- Sesuaikan jumlah kolom di sini -->
            </tr>
        <?php endif; ?>
    </table>
</body>
</html>
