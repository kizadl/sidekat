<?php
include('./config/database.php');

if (isset($_POST['submit'])) {
    // Validasi semua input harus diisi
    $email = $_POST['email'];
    $nama_organisasi = $_POST['nama_organisasi'];
    $kategori_organisasi = $_POST['kategori_organisasi'];
    $alamat = $_POST['alamat'];
    $tanggal_pengajuan = !empty($_POST['tanggal_pengajuan']) ? $_POST['tanggal_pengajuan'] : NULL;
    $jam_rdp = !empty($_POST['jam_rdp']) ? $_POST['jam_rdp'] : NULL;
    $materi_rdp = $_POST['materi_rdp'];
    $nama_penanggung_jawab = $_POST['nama_penanggung_jawab'];
    $no_hp = $_POST['no_hp'];

    // Validasi file upload (opsional)
    $file_pdf = '';
    if (isset($_FILES['file_pdf']) && $_FILES['file_pdf']['name'] != '') {
        $file_pdf = $_FILES['file_pdf']['name'];
        $target_dir = "./storage/data-pdf/";
        $target_file = $target_dir . basename($file_pdf);
        move_uploaded_file($_FILES['file_pdf']['tmp_name'], $target_file);
    }

    // Cek jika form diisi (field wajib)
    if ($email && $nama_organisasi && $kategori_organisasi && $alamat && $materi_rdp && $nama_penanggung_jawab && $no_hp) {
        // Query untuk menyimpan data ke database
        if ($tanggal_pengajuan && $jam_rdp) {
            $sql = "INSERT INTO pengajuan_rdp (email, nama_organisasi, kategori_organisasi, alamat, tanggal_pengajuan, jam_rdp, materi_rdp, nama_penanggung_jawab, no_hp, file_pdf) 
                    VALUES ('$email', '$nama_organisasi', '$kategori_organisasi', '$alamat', '$tanggal_pengajuan', '$jam_rdp', '$materi_rdp', '$nama_penanggung_jawab', '$no_hp', '$file_pdf')";
        } else {
            $sql = "INSERT INTO pengajuan_rdp (email, nama_organisasi, kategori_organisasi, alamat, materi_rdp, nama_penanggung_jawab, no_hp, file_pdf) 
                    VALUES ('$email', '$nama_organisasi', '$kategori_organisasi', '$alamat', '$materi_rdp', '$nama_penanggung_jawab', '$no_hp', '$file_pdf')";
        }

        // Eksekusi query
        if ($conn->query($sql) === TRUE) {
            echo "<script>alert('Pengajuan Rapat Dengar Pendapat berhasil!'); window.location.href='pengajuan_rdp.php';</script>";
        } else {
            echo "Error: " . $conn->error;
        }
    } else {
        echo "<script>alert('Harap isi semua kolom yang wajib diisi!'); window.location.href='pengajuan_rdp.php';</script>";
    }
}
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DND Sidekat | Pengajuan Rapat Dengar Pendapat</title>
    <!-- Favicon img -->
    <link rel="shortcut icon" href="assets/images/favicon.png">
    <!-- Bootstarp min css -->
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <!-- Mean menu css -->
    <link rel="stylesheet" href="assets/css/meanmenu.css">
    <!-- All min css -->
    <link rel="stylesheet" href="assets/css/all.min.css">
    <!-- Swiper bundle min css -->
    <link rel="stylesheet" href="assets/css/swiper-bundle.min.css">
    <!-- Magnigic popup css -->
    <link rel="stylesheet" href="assets/css/magnific-popup.css">
    <!-- Animate css -->
    <link rel="stylesheet" href="assets/css/animate.css">
    <!-- Nice select css -->
    <link rel="stylesheet" href="assets/css/nice-select.css">
    <!-- Style css -->
    <link rel="stylesheet" href="assets/css/style.css">
</head>

<body>

    <!-- Preloader area start -->

    <!-- Preloader area end -->

    <!-- Mouse cursor area start here -->
    <!-- Mouse cursor area end here -->

    <!-- Top header area start here -->
    <!-- Top header area end here -->

    <!-- Header area start here -->
    <?php include 'layouts/header.php'; ?>
    <!-- Header area end here -->



    <!-- Fullscreen search area start here -->

    <!-- Fullscreen search area end here -->

    <main>
        <!-- Contact area start here -->
        <section class="contact-area pt-150 pb-120">
            <div class="container">
                <div class="row g-4">
                    <div class="col-lg-4">
                        <div class="contact__left-item primary-bg">
                            <h3 class="text-white mb-30">Perlu di Perhatikan</h3>
                            <p class="text-white">Harap mengisi data sesuai yang ada pada form disamping.</p>
                            <ul class="mt-40 mb-100">
                                <li>
                                    <div>
                                        <h4 class="text-white">Email</h4>
                                        <p class="text-white" style="text-align: justify;">
                                            Harap isikan alamat email yang aktif agar admin dapat mengirimkan pemberitahuan terkait approval pengajuan melalui email tersebut.
                                        </p>
                                    </div>
                                    <div>
                                        <h4 class="text-white">No. HP</h4>
                                        <p class="text-white" style="text-align: justify;">
                                            Harap isikan nomor HP yang aktif atau terhubung dengan WhatsApp agar admin dapat menghubungi anda terkait pengajuan yang sudah dikirimkan.
                                        </p>
                                    </div>
                                    <div>
                                        <h4 class="text-white">Tanggal Pengajuan</h4>
                                        <p class="text-white" style="text-align: justify;">
                                            Tanggal pengajuan bersifat opsional. Jika tidak diisi, maka jadwal RDP akan disesuaikan dengan jadwal DPRD Kabupaten Jember.
                                        </p>
                                    </div>
                                    <div>
                                        <h4 class="text-white">Upload Dokumen</h4>
                                        <p class="text-white" style="text-align: justify;">
                                            Dokumen pengajuan yang diupload adalah surat permohonan resmi dari organisasi yang sudah ditandatangani.
                                            <br><br>
                                            Dokumen yang diupload berjenis (file.pdf)
                                        </p>
                                    </div>
                                </li>
                            </ul>
                            <h4 class="text-white mb-20">
                                Follow Social:
                            </h4>
                            <div class="social">
                                <a href="https://api.whatsapp.com/send/?phone=%2B62895370111060&text&type=phone_number&app_absent=0" target="blank"><i class="fa-brands fa-whatsapp"></i></a>
                                <a href="https://www.instagram.com/dprdjember/" target="blank"><i class="fa-brands fa-instagram"></i></a>
                                <a href="https://www.tiktok.com/@dprdjember" target="blank"><i class="fa-brands fa-tiktok"></i></a>
                                <a href="https://www.youtube.com/@dprdjember" target="blank"><i class="fa-brands fa-youtube"></i></a>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-8">
                        <div class="contact__right-item">
                            <div class="section-header mb-20">
                                <h5 class="wow fadeInUp pb-2" data-wow-delay="00ms" data-wow-duration="1500ms">
                                    <img class="me-1" src="assets/images/icon/section-title.png" alt="icon">
                                    DND SIDEKAT DPRD KAB. JEMBER
                                </h5>
                                <h2 class="wow fadeInUp" data-wow-delay="200ms" data-wow-duration="1500ms">Form Pengajuan Rapat Dengar Pendapat</h2>

                            </div>
                            <div class="contact__form">
                                <form action="pengajuan_rdp.php" method="POST" enctype="multipart/form-data">
                                    <div class="row">
                                        <div class="col-6">
                                            <label for="email">Email *</label>
                                            <input class="bg-transparent bor" name="email" type="email" placeholder="Email Organisasi" required>
                                        </div>
                                        <div class="col-6">
                                            <label for="nama_organisasi">Nama Organisasi *</label>
                                            <input name="nama_organisasi" class="bg-transparent bor" type="text" placeholder="Nama Organisasi" required>
                                        </div>
                                        <div class="col-12">
                                            <label for="kategori_organisasi">Kategori Organisasi *</label>
                                            <select name="kategori_organisasi" class="bg-transparent bor" required>
                                                <option value="">-- Pilih Kategori Organisasi --</option>
                                                <option value="Lembaga Swadaya Masyarakat">Lembaga Swadaya Masyarakat</option>
                                                <option value="NGO">NGO</option>
                                                <option value="Lembaga Bantuan Hukum">Lembaga Bantuan Hukum</option>
                                                <option value="Jurnalistik">Jurnalistik</option>
                                                <option value="Organisasi Kemahasiswaan">Organisasi Kemahasiswaan</option>
                                            </select>
                                        </div>
                                        <div class="col-12">
                                            <label for="alamat">Alamat Organisasi *</label>
                                            <textarea class="bg-transparent bor" name="alamat" rows="3" placeholder="Alamat Lengkap Organisasi" required></textarea>
                                        </div>
                                        <div class="col-6">
                                            <label for="tanggal_pengajuan">Tanggal Pengajuan (Opsional)</label>
                                            <input class="bg-transparent bor" name="tanggal_pengajuan" type="date" placeholder="Tanggal Pengajuan RDP">
                                            <small class="text-muted">*Kosongkan jika menyesuaikan jadwal DPRD</small>
                                        </div>
                                        <div class="col-6">
                                            <label for="jam_rdp">Jam RDP (Opsional)</label>
                                            <input class="bg-transparent bor" name="jam_rdp" type="time" placeholder="Jam Pelaksanaan RDP">
                                            <small class="text-muted">*Kosongkan jika menyesuaikan jadwal DPRD</small>
                                        </div>
                                        <div class="col-12">
                                            <label for="materi_rdp">Materi RDP *</label>
                                            <textarea class="bg-transparent bor" name="materi_rdp" rows="4" placeholder="Jelaskan materi yang akan dibahas dalam Rapat Dengar Pendapat" required></textarea>
                                        </div>
                                        <div class="col-6">
                                            <label for="nama_penanggung_jawab">Nama Penanggung Jawab Usulan *</label>
                                            <input class="bg-transparent bor" name="nama_penanggung_jawab" type="text" placeholder="Nama Penanggung Jawab" required>
                                        </div>
                                        <div class="col-6">
                                            <label for="no_hp">No. HP *</label>
                                            <input class="bg-transparent bor" name="no_hp" type="text" placeholder="08xxxxxxxx" required>
                                        </div>
                                        <div class="col-12">
                                            <label for="file_pdf">Upload Surat Permohonan RDP (.pdf)*</label>
                                            <p>Dokumen yang diperlukan:</p>
                                            <ul class="list-group mb-3">
                                                <li class="list">1. Surat Permohonan Rapat Dengar Pendapat dari Organisasi</li>
                                                <li class="list">2. Profil Organisasi (jika ada)</li>
                                            </ul>
                                            <input class="bg-transparent bor" name="file_pdf" accept=".pdf" type="file">
                                        </div>
                                        <div class="btn-two">
                                            <span class="btn-circle">
                                            </span>
                                            <input type="submit" name="submit" value="Ajukan" class="btn-one"></input>
                                        </div>
                                    </div>

                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- Contact area end here -->

        <!-- Contact map area start here -->
        <!-- Contact map area end here -->
    </main>

    <!-- Footer area start here -->
    <footer class="footer-area secondary-bg">
        <div class="footer__shape-regular-left wow slideInLeft" data-wow-delay="00ms" data-wow-duration="1500ms">
            <img src="assets/images/shape/footer-regular-left.png" alt="shape">
        </div>
        <div class="footer__shape-solid-left wow slideInLeft" data-wow-delay="200ms" data-wow-duration="1500ms">
            <img class="sway_Y__animation" src="assets/images/shape/footer-solid-left.png" alt="shape">
        </div>
        <div class="footer__shape-solid-right wow slideInRight" data-wow-delay="00ms" data-wow-duration="1500ms">
            <img class="sway_Y__animation" src="assets/images/shape/footer-regular-right.png" alt="shape">
        </div>
        <div class="footer__shape-regular-right wow slideInRight" data-wow-delay="200ms" data-wow-duration="1500ms">
            <img src="assets/images/shape/footer-solid-right.png" alt="shape">
        </div>
        <div class="footer__shadow-shape">
            <img src="assets/images/shape/footer-shadow-shape.png" alt="shodow">
        </div>
        <div class="container">
            <div class="footer__wrp pt-100 pb-100">
                <div class="footer__item item-sm wow fadeInUp" data-wow-delay="00ms" data-wow-duration="1500ms">
                    <a href="index.php" class="logo mb-30">
                        <img src="assets/images/logo/logo_dnd_dark.png" alt="image">
                    </a>
                    <p>DND Sidekat adalah aplikasi praktis untuk
                        mengajukan permohonan magang, penelitian,
                        studi edukasi, kunjungan kerja, dan rapat dengar pendapat dengan mudah dan cepat.</p>
                    <div class="social-icon">
                        <a href="https://api.whatsapp.com/send/?phone=%2B62895370111060&text&type=phone_number&app_absent=0" target="blank"><i class="fa-brands fa-whatsapp"></i></a>
                        <a href="https://www.instagram.com/dprdjember/" target="blank"><i class="fa-brands fa-instagram"></i></a>
                        <a href="https://www.tiktok.com/@dprdjember" target="blank"><i class="fa-brands fa-tiktok"></i></a>
                        <a href="https://www.youtube.com/@dprdjember" target="blank"><i class="fa-brands fa-youtube"></i></a>
                    </div>
                </div>
                <div class="footer__item item-mid wow fadeInUp" data-wow-delay="200ms" data-wow-duration="1500ms">
                    <h3 class="footer-title">Layanan</h3>
                    <ul>
                        <li><a href="pengajuan_rdp.php"><i class="fa-regular fa-angles-right me-1"></i>
                                Pengajuan RDP</a></li>
                        <li><a href="permohonan_kunjungan_kerja.php"><i class="fa-regular fa-angles-right me-1"></i>
                                Kunjungan Kerja</a></li>
                        <li><a href="pengajuan_studi_edukasi.php"><i class="fa-regular fa-angles-right me-1"></i>
                                Studi Edukasi</a></li>
                        <li><a href="pengajuan_penelitian.php"><i class="fa-regular fa-angles-right me-1"></i>
                                Pengajuan Penelitian</a></li>
                        <li><a href="pengajuan_magang.php"><i class="fa-regular fa-angles-right me-1"></i>
                                Pengajuan Magang</a></li>
                    </ul><br>
                </div>

                <div class="footer__item item-big wow fadeInUp" data-wow-delay="600ms" data-wow-duration="1500ms">
                    <h3 class="footer-title">Contact Us</h3>
                    <p class="mb-10">Jl. Kalimantan No. 86 Jember (68121)</p>
                    <ul class="footer-contact">
                        <li>
                            <i class="fa-regular fa-clock"></i>
                            <div class="info">
                                <h5>
                                    Jam Kerja :
                                </h5>
                                <p>Senin - Kamis : 08.00 - 16.00 WIB</p>
                                <p>Jum'at : 08.00 - 15.30 WIB</p>
                            </div>
                        </li>
                        <li>
                            <i class="fa-duotone fa-phone"></i>
                            <div class="info">
                                <h5>
                                    No. Telp :
                                </h5>
                                <p>(0331) 335444 – 335567</p>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="footer__copyright">
            <div class="container">
                <div
                    class="d-flex gap-1 flex-wrap align-items-center justify-content-md-between justify-content-center">
                    <p class="wow fadeInDown" data-wow-delay="00ms" data-wow-duration="1500ms">&copy; All Copyright 2024
                        by <a href="#0">DPRD Kabupaten Jember</a></p>
                </div>
            </div>
        </div>
    </footer>
    <!-- Footer area end here -->

    <!-- Back to top area start here -->
    <div class="scroll-up">
        <svg class="scroll-circle svg-content" width="100%" height="100%" viewBox="-1 -1 102 102">
            <path d="M50,1 a49,49 0 0,1 0,98 a49,49 0 0,1 0,-98" />
        </svg>
    </div>
    <!-- Back to top area end here -->

    <!-- Jquery 3.7.0 Min Js -->
    <script src="assets/js/jquery-3.7.1.min.js"></script>
    <!-- Bootstrap min Js -->
    <script src="assets/js/bootstrap.min.js"></script>
    <!-- Mean menu Js -->
    <script src="assets/js/meanmenu.js"></script>
    <!-- Swiper bundle min Js -->
    <script src="assets/js/swiper-bundle.min.js"></script>
    <!-- Counterup min Js -->
    <script src="assets/js/jquery.counterup.min.js"></script>
    <!-- Wow min Js -->
    <script src="assets/js/wow.min.js"></script>
    <!-- Pace min Js -->
    <script src="assets/js/pace.min.js"></script>
    <!-- Magnific popup min Js -->
    <script src="assets/js/magnific-popup.min.js"></script>
    <!-- Nice select min Js -->
    <script src="assets/js/nice-select.min.js"></script>
    <!-- Isotope pkgd min Js -->
    <script src="assets/js/isotope.pkgd.min.js"></script>
    <!-- Waypoints Js -->
    <script src="assets/js/jquery.waypoints.js"></script>
    <!-- Script Js -->
    <script src="assets/js/script.js"></script>
</body>

</html>