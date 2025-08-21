<?php
include('./config/database.php');
$type_action = $_POST['type_action'];
$type_subaction = $_POST['type_subaction'];
$id_external = $_POST['id_external'];
$response = [];
$responseCode = 0;
$timestamp = time();
$target_dir_img = "./storage/data-foto/";
$target_dir_pdf = "./storage/data-pdf/";

if ($type_action == "pengajuan") {
    if ($type_subaction == "magang") {
        // Validasi semua input harus diisi
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

        // Validasi file upload
        $file_pdf = $_FILES['file_pdf']['name'];
        $newFileName = $timestamp . '_' . basename($file_pdf);
        $target_file = $target_dir_pdf . $newFileName;

        // Cek jika form diisi
        if ($nama && $email && $nomor_hp && $kampus && $fakultas && $prodi && $nim && $tanggal_mulai && $tanggal_selesai && $jumlah_mahasiswa && $file_pdf) {
            // Pindahkan file PDF yang diupload
            move_uploaded_file($_FILES['file_pdf']['tmp_name'], $target_file);

            // Query untuk menyimpan data ke database
            $sql = "INSERT INTO pengajuan_magang (nama, email, nomor_hp, kampus, fakultas, prodi, nim, tanggal_mulai, tanggal_selesai, jumlah_mahasiswa, file_pdf, id_external) 
                VALUES ('$nama', '$email', '$nomor_hp', '$kampus', '$fakultas', '$prodi', '$nim', '$tanggal_mulai', '$tanggal_selesai', '$jumlah_mahasiswa', '$newFileName', '$id_external')";

            // Eksekusi query
            if ($conn->query($sql) === TRUE) {
                $responseCode = 200;
            } else {
                $responseCode = 500;
            }
        } else {
            $responseCode = 400;
        }
    } else if ($type_subaction == "penelitian") {
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

            // Mengambil nama file
            $file_pdf = $_FILES['file_pdf']['name'];
            $file_jpg = $_FILES['file_jpg']['name'];

            // Mengatur path file
            $newFileNamePDF = $timestamp . '_' . basename($file_pdf);
            $target_file_pdf = $target_dir_pdf . $newFileNamePDF;
            $newFileNameJPG = $timestamp . '_photo_' . basename($file_jpg);
            $target_file_jpg = $target_dir_img . $newFileNameJPG;

            // Validasi ekstensi file
            $pdf_ext = strtolower(pathinfo($target_file_pdf, PATHINFO_EXTENSION));
            $foto_ext = strtolower(pathinfo($target_file_jpg, PATHINFO_EXTENSION));

            if ($pdf_ext == 'pdf' && ($foto_ext == 'jpg' || $foto_ext == 'jpeg' || $foto_ext == 'png')) {
                // Proses upload file
                if (move_uploaded_file($_FILES['file_pdf']['tmp_name'], $target_file_pdf) && move_uploaded_file($_FILES['file_jpg']['tmp_name'], $target_file_jpg)) {
                    // Insert data ke database
                    $sql = "INSERT INTO pengajuan_penelitian (nama, email, nomor_hp, kampus, fakultas, prodi, nim, file_pdf, file_jpg, id_external) 
                        VALUES ('$nama', '$email', '$nomor_hp', '$kampus', '$fakultas', '$prodi', '$nim', '$newFileNamePDF', '$newFileNameJPG', '$id_external')";
                    if ($conn->query($sql) === TRUE) {
                        $responseCode = 200;
                    } else {
                        $responseCode = 500;
                    }
                } else {
                    $responseCode = 500;
                }
            } else {
                $responseCode = 400;
            }
        } else {
            $responseCode = 400;
        }
    } else if ($type_subaction == "edukasi") {
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

        $newFileNamePDF = $timestamp . '_' . basename($file_pdf);
        $target_file_pdf = $target_dir_pdf . $newFileNamePDF;
        $newFileNameJPG = $timestamp . '_photo_' . basename($file_jpg);
        $target_file_jpg = $target_dir_img . $newFileNameJPG;

        // Memindahkan file ke folder tujuan
        $upload_ok = true;

        if (
            move_uploaded_file($_FILES['file_jpg']['tmp_name'], $target_file_jpg) &&
            move_uploaded_file($_FILES['file_pdf']['tmp_name'], $target_file_pdf)
        ) {

            // Menyimpan data ke database
            $sql = "INSERT INTO pengajuan_studi_edukasi (nama, email, nomor_hp, kampus, fakultas, prodi, nim, permohonan_kedatangan, file_jpg, file_pdf, id_external) 
                VALUES ('$nama', '$email', '$nomor_hp', '$kampus', '$fakultas', '$prodi', '$nim', '$permohonan_kedatangan', '$newFileNameJPG', '$newFileNamePDF', '$id_external')";

            if ($conn->query($sql) === TRUE) {
                $responseCode = 200;
            } else {
                $responseCode = 500;
            }
        } else {
            $responseCode = 500;
        }
    } else if ($type_subaction == "kunjungan_kerja") {
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
        $newFileNamePDF = $timestamp . '_' . basename($file_pdf);
        $target_file_pdf = $target_dir_pdf . $newFileNamePDF;

        // Memindahkan file ke folder tujuan
        if (move_uploaded_file($_FILES['file_pdf']['tmp_name'], $target_file_pdf)) {
            // Menyimpan data ke database
            $sql = "INSERT INTO permohonan_kunjungan_kerja (email, kategori_id, nama_instansi, alamat, tanggal_kunjungan, jam_kunjungan, materi_kunjungan, pimpinan_rombongan, nomor_hp, file_pdf, id_external) 
                VALUES ('$email', '$kategori_id', '$nama_instansi', '$alamat', '$tanggal_kunjungan', '$jam_kunjungan', '$materi_kunjungan', '$pimpinan_rombongan', '$nomor_hp', '$newFileNamePDF', '$id_external')";

            if ($conn->query($sql) === TRUE) {
                $responseCode = 200;
            } else {
                $responseCode = 500;
                $response['message'] = $conn->error;
            }
        } else {
            $responseCode = 500;
        }
    }
    $response['code'] = $responseCode;
} else if ($type_action == "history-pengajuan") {
    $allData = [];

    // permohonan_kunjungan_kerja
    $query = "SELECT * FROM permohonan_kunjungan_kerja WHERE id_external = '$id_external'";
    $stmt = $conn->prepare($query);
    $stmt->execute();
    $result = $stmt->get_result();

    // Cek apakah data ditemukan
    if ($result->num_rows > 0) {
        $data_pengajuan = $result->fetch_all(MYSQLI_ASSOC);
        foreach ($data_pengajuan as $vl) {
            $vl['type'] = "kunjungan_kerja";
            $vl['title'] = $vl['nama_instansi'];
            $vl['date_start'] = $vl['tanggal_kunjungan'];
            $vl['date_end'] = NULL;
            $vl['created_at'] = $vl['tanggal_input'];
            $vl['status'] = $vl['status'];
            $allData[] = $vl;
        }
    }
    // end permohonan_kunjungan_kerja

    // pengajuan_magang
    $queryMagang = "SELECT * FROM pengajuan_magang WHERE id_external = '$id_external'";
    $stmtMagang = $conn->prepare($queryMagang);
    $stmtMagang->execute();
    $resultMagang = $stmtMagang->get_result();

    // Cek apakah data ditemukan
    if ($resultMagang->num_rows > 0) {
        $data_pengajuan = $resultMagang->fetch_all(MYSQLI_ASSOC);
        foreach ($data_pengajuan as $vl) {
            $vl['type'] = "magang";
            $vl['title'] = $vl['kampus'];
            $vl['date_start'] = $vl['tanggal_mulai'];
            $vl['date_end'] = $vl['tanggal_selesai'];
            $vl['created_at'] = $vl['tanggal_input'];
            $vl['status'] = $vl['status'];
            $allData[] = $vl;
        }
    }
    // end pengajuan_magang

    
    // pengajuan_penelitian
    $queryPenelitian = "SELECT * FROM pengajuan_penelitian WHERE id_external = '$id_external'";
    $stmtPenelitian = $conn->prepare($queryPenelitian);
    $stmtPenelitian->execute();
    $resultPenelitian = $stmtPenelitian->get_result();

    // Cek apakah data ditemukan
    if ($resultPenelitian->num_rows > 0) {
        $data_pengajuan = $resultPenelitian->fetch_all(MYSQLI_ASSOC);
        foreach ($data_pengajuan as $vl) {
            $vl['type'] = "penelitian";
            $vl['title'] = $vl['kampus'];
            $vl['date_start'] = NULL;
            $vl['date_end'] = NULL;
            $vl['created_at'] = $vl['tanggal_input'];
            $vl['status'] = $vl['status'];
            $allData[] = $vl;
        }
    }
    // end pengajuan_penelitian

    // pengajuan_studi_edukasi
    $queryEducation = "SELECT * FROM pengajuan_studi_edukasi WHERE id_external = '$id_external'";
    $stmtEducation = $conn->prepare($queryEducation);
    $stmtEducation->execute();
    $resultEducation = $stmtEducation->get_result();

    // Cek apakah data ditemukan
    if ($resultEducation->num_rows > 0) {
        $data_pengajuan = $resultEducation->fetch_all(MYSQLI_ASSOC);
        foreach ($data_pengajuan as $vl) {
            $vl['type'] = "edukasi";
            $vl['title'] = $vl['kampus'];
            $vl['date_start'] = NULL;
            $vl['date_end'] = NULL;
            $vl['created_at'] = $vl['tanggal_input'];
            $vl['status'] = $vl['status'];
            $allData[] = $vl;
        }
    }
    // end pengajuan_studi_edukasi
    usort($allData, function ($a, $b) {
        return strtotime($b['created_at']) - strtotime($a['created_at']);
    });
    $response['data'] = $allData;
    $response['code'] = 200;
} else if($type_action == "list-category") { 
    $sql_kategori = "SELECT id, nama_kategori as `value` FROM kategori_instansi";
    $result_kategori = $conn->query($sql_kategori);
    $response['data'] = $result_kategori->fetch_all(MYSQLI_ASSOC);
}

echo json_encode(
    $response, JSON_PRETTY_PRINT
);
