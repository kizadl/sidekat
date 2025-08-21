<?php
include('../config/database.php');

// Memeriksa apakah form telah disubmit
if (isset($_POST['submit'])) {
    // Mengambil data dari form
    $email = $_POST['email'];
    $kategori_id = $_POST['kategori_instansi'];
    $nama_instansi = $_POST['nama_instansi'];
    $alamat = $_POST['alamat'];
    $tanggal_kunjungan = $_POST['tanggal_kunjungan'];
    $jam_kunjungan = $_POST['jam_kunjungan'];
    $materi_kunjungan = $_POST['materi_kunjungan'];
    $pimpinan_rombongan = $_POST['pimpinan_rombongan'];
    $nomor_hp = $_POST['nomor_hp'];

    // Menangani file upload
    $file_pdf = $_FILES['file_pdf']['name'];
    $target_dir_pdf = "../assets/uploads/pdf/";
    $target_file_pdf = $target_dir_pdf . basename($file_pdf);

    // Memindahkan file ke folder tujuan
    if (move_uploaded_file($_FILES['file_pdf']['tmp_name'], $target_file_pdf)) {
        // Menyimpan data ke database
        $sql = "INSERT INTO permohonan_kunjungan_kerja (email, kategori_id, nama_instansi, alamat, tanggal_kunjungan, jam_kunjungan, materi_kunjungan, pimpinan_rombongan, nomor_hp, file_pdf) 
                VALUES ('$email', '$kategori_id', '$nama_instansi', '$alamat', '$tanggal_kunjungan', '$jam_kunjungan', '$materi_kunjungan', '$pimpinan_rombongan', '$nomor_hp', '$file_pdf')";
        
        if ($conn->query($sql) === TRUE) {
            echo "<script>alert('Pengajuan berhasil!');</script>";
        } else {
            echo "<script>alert('Error: " . $conn->error . "');</script>";
        }
    } else {
        echo "<script>alert('Gagal mengupload file.');</script>";
    }
}

// Mengambil data kategori instansi untuk dropdown
$sql_kategori = "SELECT * FROM kategori_instansi";
$result_kategori = $conn->query($sql_kategori);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Permohonan Kunjungan Kerja</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
    <h1>Form Permohonan Kunjungan Kerja</h1>
    <form action="permohonan_kunjungan_kerja.php" method="POST" enctype="multipart/form-data">
        <label for="email">Email:</label>
        <input type="email" name="email" required><br>

        <label for="kategori_instansi">Kategori Instansi:</label>
        <select name="kategori_instansi" required>
            <option value="">Pilih Kategori Instansi</option>
            <?php while ($row = $result_kategori->fetch_assoc()): ?>
                <option value="<?php echo $row['id']; ?>"><?php echo $row['nama_kategori']; ?></option>
            <?php endwhile; ?>
        </select><br>

        <label for="nama_instansi">Nama Instansi:</label>
        <input type="text" name="nama_instansi" required><br>

        <label for="alamat">Alamat:</label>
        <textarea name="alamat" required></textarea><br>

        <label for="tanggal_kunjungan">Tanggal Kunjungan:</label>
        <input type="date" name="tanggal_kunjungan" required><br>

        <label for="jam_kunjungan">Jam Kunjungan:</label>
        <input type="time" name="jam_kunjungan" required><br>

        <label for="materi_kunjungan">Materi Kunjungan:</label>
        <textarea name="materi_kunjungan" required></textarea><br>

        <label for="pimpinan_rombongan">Pimpinan Rombongan:</label>
        <input type="text" name="pimpinan_rombongan" required><br>

        <label for="nomor_hp">Nomor HP:</label>
        <input type="text" name="nomor_hp" required><br>

        <label for="file_pdf">Upload File PDF:</label>
        <input type="file" name="file_pdf" accept=".pdf" required><br>

        <input type="submit" name="submit" value="Ajukan">
    </form>

    <script>
    document.querySelector("form").onsubmit = function(event) {
        var nomor_hp = document.querySelector("input[name='nomor_hp']").value;

        // Validasi nomor HP (harus angka dan 10-15 digit)
        if (!/^\d{10,15}$/.test(nomor_hp)) {
            alert("Nomor HP harus berupa angka antara 10 sampai 15 digit.");
            event.preventDefault(); // Mencegah pengiriman form
        }
    };
    </script>
</body>
</html>
