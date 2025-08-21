<?php
include('./config/database.php');

$status_message = ''; // Variabel untuk pesan status

// Cek jika form di-submit
if (isset($_POST['submit'])) {
    $nim = $_POST['nim'];
    $email = $_POST['email'];

    // Query untuk mencari data pengajuan berdasarkan NIM dan email
    $query = "SELECT * FROM pengajuan_magang WHERE nim = ? AND email = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ss", $nim, $email);
    $stmt->execute();
    $result = $stmt->get_result();

    // Cek apakah ada hasil
    if ($result->num_rows > 0) {
        $status_message = 'Hasil Pengajuan Ditemukan!';
    } else {
        $status_message = 'Data pengajuan tidak ditemukan. Periksa NIM dan Email yang Anda masukkan.';
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tracking Pengajuan</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <style>
        body {
            margin: 20px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .status-message {
            margin-top: 20px;
        }

        .table {
            margin-top: 20px;
        }
    </style>
</head>

<body>
    <div class="container">
        <h3>Tracking Status Pengajuan</h3>
        <form action="tracking.php" method="POST">
            <div class="form-group">
                <label for="nim">NIM:</label>
                <input type="text" class="form-control" id="nim" name="nim" required>
            </div>
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>
            <button type="submit" name="submit" class="btn btn-primary">Cek Status</button>
        </form>

        <!-- Pesan Status -->
        <?php if (!empty($status_message)) : ?>
            <div class="status-message alert alert-info">
                <?php echo $status_message; ?>
            </div>
        <?php endif; ?>

        <!-- Tabel untuk menampilkan hasil jika ditemukan -->
        <?php if (isset($result) && $result->num_rows > 0) : ?>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Kampus</th>
                        <th>Prodi</th>
                        <th>Tanggal Mulai</th>
                        <th>Tanggal Selesai</th>
                        <th>Jumlah Mahasiswa</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no = 1;
                    while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo $no++; ?></td>
                            <td><?php echo $row['nama']; ?></td>
                            <td><?php echo $row['kampus']; ?></td>
                            <td><?php echo $row['prodi']; ?></td>
                            <td><?php echo $row['tanggal_mulai']; ?></td>
                            <td><?php echo $row['tanggal_selesai']; ?></td>
                            <td><?php echo $row['jumlah_mahasiswa']; ?></td>
                            <td>
                                <?php
                                // Logika untuk menampilkan "Dalam Proses" jika status pending
                                echo $row['status'] === 'pending' ? 'Dalam Proses' : ucfirst($row['status']);
                                ?>
                            </td>

                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>
</body>

</html>