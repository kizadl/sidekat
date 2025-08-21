<?php include('../config/database.php'); ?>
<!DOCTYPE html>
<html>
<head>
    <title>Pengajuan Magang</title>
    <link rel="stylesheet" type="text/css" href="../assets/css/style.css">
</head>
<body>
    <h1>Form Pengajuan Magang</h1>
    <form action="pengajuan_magang.php" method="POST" enctype="multipart/form-data">
        Nama: <input type="text" name="nama" required><br>
        Email: <input type="email" name="email" required><br>
        Nomor HP: <input type="text" name="nomor_hp" required><br>
        Kampus: <input type="text" name="kampus" required><br>
        Fakultas: <input type="text" name="fakultas" required><br>
        Prodi: <input type="text" name="prodi" required><br>
        NIM: <input type="text" name="nim" required><br>
        Tanggal Mulai: <input type="date" name="tanggal_mulai" required><br>
        Tanggal Selesai: <input type="date" name="tanggal_selesai" required><br>
        Jumlah Mahasiswa: <input type="number" name="jumlah_mahasiswa" required><br>
        Upload File PDF: <input type="file" name="file_pdf" accept=".pdf" required><br>
        <input type="submit" name="submit" value="Ajukan">
    </form>

    <?php
    if (isset($_POST['submit'])) {
        $nama = $_POST['nama'];
        $email = $_POST['email'];
        $nomor_hp = $_POST['nomor_hp'];
        $kampus = $_POST['kampus'];
        $fakultas = $_POST['fakultas'];
        $prodi = $_POST['prodi'];
        $nim = $_POST['nim'];
        $tanggal_mulai = $_POST['tanggal_mulai'];
        $tanggal_selesai = $_POST['tanggal_selesai'];
        $jumlah_mahasiswa = $_POST['jumlah_mahasiswa'];

        // Handle file upload
        $file_pdf = $_FILES['file_pdf']['name'];
        $target_dir = "../assets/uploads/pdf/";
        $target_file = $target_dir . basename($file_pdf);
        move_uploaded_file($_FILES['file_pdf']['tmp_name'], $target_file);

        $sql = "INSERT INTO pengajuan_magang (nama, email, nomor_hp, kampus, fakultas, prodi, nim, tanggal_mulai, tanggal_selesai, jumlah_mahasiswa, file_pdf) 
                VALUES ('$nama', '$email', '$nomor_hp', '$kampus', '$fakultas', '$prodi', '$nim', '$tanggal_mulai', '$tanggal_selesai', '$jumlah_mahasiswa', '$file_pdf')";
        
        if ($conn->query($sql) === TRUE) {
            echo "Pengajuan berhasil!";
        } else {
            echo "Error: " . $conn->error;
        }
    }
    ?>
</body>
</html>
