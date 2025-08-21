<?php
include('./config/database.php');

if (isset($_POST['submit'])) {
    // Data dari form
    $nama = $_POST['nama'];
    $email = $_POST['email'];
    $nomor_hp = $_POST['nomor_hp'];
    $kampus = $_POST['kampus'];
    $fakultas = $_POST['fakultas'];
    $prodi = $_POST['prodi'];
    $nim = $_POST['nim'];

    // Pengecekan apakah semua kolom terisi
    if (!empty($nama) && !empty($email) && !empty($nomor_hp) && !empty($kampus) && !empty($fakultas) && !empty($prodi) && !empty($nim) && !empty($_FILES['file_pdf']['name']) && !empty($_FILES['file_jpg']['name'])) {

        // Mengatur direktori target upload
        $pdf_dir = "./assets/uploads/pdf/";
        $img_dir = "./assets/uploads/jpg/";

        // Mengambil nama file
        $file_pdf = $_FILES['file_pdf']['name'];
        $file_jpg = $_FILES['file_jpg']['name'];

        // Mengatur path file
        $target_file_pdf = $pdf_dir . basename($file_pdf);
        $target_file_jpg = $img_dir . basename($file_jpg);

        // Validasi ekstensi file
        $pdf_ext = strtolower(pathinfo($target_file_pdf, PATHINFO_EXTENSION));
        $foto_ext = strtolower(pathinfo($target_file_jpg, PATHINFO_EXTENSION));

        if ($pdf_ext == 'pdf' && ($foto_ext == 'jpg' || $foto_ext == 'jpeg')) {
            // Proses upload file
            if (move_uploaded_file($_FILES['file_pdf']['tmp_name'], $target_file_pdf) && move_uploaded_file($_FILES['file_jpg']['tmp_name'], $target_file_jpg)) {
                // Insert data ke database
                $sql = "INSERT INTO pengajuan_penelitian (nama, email, nomor_hp, kampus, fakultas, prodi, nim, file_pdf, file_jpg) 
                        VALUES ('$nama', '$email', '$nomor_hp', '$kampus', '$fakultas', '$prodi', '$nim', '$file_pdf', '$file_jpg')";
                if ($conn->query($sql) === TRUE) {
                    echo "<script>alert('Pengajuan berhasil!');</script>";
                } else {
                    echo "Error: " . $conn->error;
                }
            } else {
                echo "Terjadi kesalahan saat mengupload file.";
            }
        } else {
            echo "Ekstensi file tidak valid. Harap upload file PDF dan JPG.";
        }
    } else {
        echo "Harap isi semua kolom.";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Pengajuan Penelitian</title>
</head>
<body>
    <h3>Form Pengajuan Penelitian</h3>
    <form action="pengajuan_penelitian.php" method="POST" enctype="multipart/form-data">
        Nama: <input type="text" name="nama" required><br>
        Email: <input type="email" name="email" required><br>
        Nomor HP: <input type="text" name="nomor_hp" required><br>
        Kampus: <input type="text" name="kampus" required><br>
        Fakultas: <input type="text" name="fakultas" required><br>
        Prodi: <input type="text" name="prodi" required><br>
        NIM: <input type="text" name="nim" required><br>
        Upload Foto (JPG): <input type="file" name="file_jpg" accept=".jpg,.jpeg" required><br>
        Upload File PDF: <input type="file" name="file_pdf" accept=".pdf" required><br>
        <input type="submit" name="submit" value="Ajukan">
    </form>
</body>
</html>
