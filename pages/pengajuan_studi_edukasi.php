<?php
include('../config/database.php');

// Memeriksa apakah form telah disubmit
if (isset($_POST['submit'])) {
    // Mengambil data dari form
    $nama = $_POST['nama'];
    $email = $_POST['email'];
    $nomor_hp = $_POST['nomor_hp'];
    $kampus = $_POST['kampus'];
    $fakultas = $_POST['fakultas'];
    $prodi = $_POST['prodi'];
    $nim = $_POST['nim'];
    $permohonan_kedatangan = $_POST['permohonan_kedatangan'];

    // Menangani file upload
    $file_jpg = $_FILES['file_jpg']['name'];
    $file_pdf = $_FILES['file_pdf']['name'];
    $target_dir_jpg = "../assets/uploads/jpg/";
    $target_dir_pdf = "../assets/uploads/pdf/";

    $target_file_jpg = $target_dir_jpg . basename($file_jpg);
    $target_file_pdf = $target_dir_pdf . basename($file_pdf);

    // Memindahkan file ke folder tujuan
    $upload_ok = true;

    if (move_uploaded_file($_FILES['file_jpg']['tmp_name'], $target_file_jpg) && 
        move_uploaded_file($_FILES['file_pdf']['tmp_name'], $target_file_pdf)) {
        
        // Menyimpan data ke database
        $sql = "INSERT INTO pengajuan_studi_edukasi (nama, email, nomor_hp, kampus, fakultas, prodi, nim, permohonan_kedatangan, file_jpg, file_pdf) 
                VALUES ('$nama', '$email', '$nomor_hp', '$kampus', '$fakultas', '$prodi', '$nim', '$permohonan_kedatangan', '$file_jpg', '$file_pdf')";
        
        if ($conn->query($sql) === TRUE) {
            echo "<script>alert('Pengajuan berhasil!');</script>";
        } else {
            echo "<script>alert('Error: " . $conn->error . "');</script>";
        }
    } else {
        echo "<script>alert('Gagal mengupload file.');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Pengajuan Studi Edukasi</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
    <h1>Form Pengajuan Studi Edukasi</h1>
    <form action="pengajuan_studi_edukasi.php" method="POST" enctype="multipart/form-data">
        <label for="nama">Nama:</label>
        <input type="text" name="nama" required><br>

        <label for="email">Email:</label>
        <input type="email" name="email" required><br>

        <label for="nomor_hp">Nomor HP:</label>
        <input type="text" name="nomor_hp" required><br>

        <label for="kampus">Kampus:</label>
        <input type="text" name="kampus" required><br>

        <label for="fakultas">Fakultas:</label>
        <input type="text" name="fakultas" required><br>

        <label for="prodi">Program Studi:</label>
        <input type="text" name="prodi" required><br>

        <label for="nim">NIM:</label>
        <input type="text" name="nim" required><br>

        <label for="permohonan_kedatangan">Permohonan Kedatangan:</label>
        <textarea name="permohonan_kedatangan" required></textarea><br>

        <label for="file_jpg">Upload File JPG:</label>
        <input type="file" name="file_jpg" accept=".jpg,.jpeg" required><br>

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
