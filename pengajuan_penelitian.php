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
        $pdf_dir = "./storage/data-pdf/";
        $img_dir = "./storage/data-foto/";

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
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DND Sidekat | Setwan DPRD Kabupaten Jember</title>
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
    <header class="header-area header-three-area">
        <div class="container header__container">
            <div class="header__main">
                <a href="home.html" class="logo">
                    <img src="assets/images/logo/logo_dnd_dark.png" alt="logo">
                </a>
                <div class="main-menu">
                    <nav>
                        <ul>
                            <li><a href="home.html#about-section">Tentang Kami</a></li>
                            <li>
                                <a href="#0">Layanan Pengajuan</a>
                                <ul class="sub-menu">
                                    <li>
                                        <a href="magang.html">- Pengajuan Magang</a>
                                    </li>
                                    <li>
                                        <a href="penelitian.html">- Pengajuan Penelitian</a>
                                    </li>
                                    <li>
                                        <a href="studi_edukasi.html">- Pengajuan Studi Edukasi</a>
                                    </li>
                                    <li>
                                        <a href="kunjungan_kerja.html">- Kunjungan Kerja</a>
                                    </li>
                                </ul>
                            </li>
                            <li>
                                <a href="#0">Tracking Pengajuan</a>
                                <ul class="sub-menu">
                                    <li>
                                        <a href="tracking_magang.html">- Pengajuan Magang</a>
                                    </li>
                                    <li>
                                        <a href="tracking_penelitian.html">- Pengajuan Penelitian</a>
                                    </li>
                                    <li>
                                        <a href="tracking_studi_edukasi.html">- Pengajuan Studi Edukasi</a>
                                    </li>
                                    <li>
                                        <a href="tracking_kunjungan_kerja.html">- Kunjungan Kerja</a>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </nav>
                </div>
                <div class="d-none d-lg-inline-block">
                    <a href="admin/login.php" class="btn-one">Login <i
                            class="fa-regular fa-arrow-right-long"></i></a>
                </div>
                <div class="bars d-block d-lg-none">
                    <i id="openButton" class="fa-solid fa-bars"></i>
                </div>
            </div>
        </div>
    </header>
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
                                        <h4 class="text-white">Nomor HP</h4>
                                        <p class="text-white" style="text-align: justify;">
                                            Harap isikan nomor HP yang aktif atau terhubung dengan WhatsApp agar admin dapat menghubungi anda terkait pengajuan yang sudah dikirimkan.
                                        </p>
                                    </div>
                                    <div>
                                        <h4 class="text-white">Upload Foto KTP/Kartu Tanda Pelajar</h4>
                                        <p class="text-white" style="text-align: justify;">
                                            Upload foto/scan Kartu Tanda Penduduk/Pelajar asli dengan format file (.jpg)
                                        </p>
                                    </div>
                                    <div>
                                        <h4 class="text-white">Upload Surat Permohonan Penelitian</h4>
                                        <p class="text-white" style="text-align: justify;">
                                            Untuk dokumen pengajuan yang diupload adalah dokumen scan surat pengajuan / permohonan
                                            penelitian dari kampus atau universitas yang sudah ditandatangani oleh pihak kampus terkait dengan format file (.pdf).
                                        </p>
                                    </div>
                                </li>
                            </ul>
                            <h4 class="text-white mb-20">
                                Follow Social:
                            </h4>
                            <div class="social">
                                <a href="#0"><i class="fa-brands fa-whatsapp"></i></a>
                                <a href="#0"><i class="fa-brands fa-instagram"></i></a>
                                <a href="#0"><i class="fa-brands fa-tiktok"></i></a>
                                <a href="#0"><i class="fa-brands fa-youtube"></i></a>
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
                                <h2 class="wow fadeInUp" data-wow-delay="200ms" data-wow-duration="1500ms">Form Pengajuan Penelitian</h2>

                            </div>
                            <div class="contact__form">
                                <form action="penelitian.html" method="POST" enctype="multipart/form-data">
                                    <div class="row">
                                        <div class="col-6">
                                            <label for="name">Nama *</label>
                                            <input name="nama" class="bg-transparent bor" type="text" placeholder="Nama">
                                        </div>
                                        <div class="col-6">
                                            <label for="email">Email *</label>
                                            <input class="bg-transparent bor" name="email" type="email" placeholder="Your Email">
                                        </div>
                                        <div class="col-6">
                                            <label for="nomor_hp">Nomor HP*</label>
                                            <input class="bg-transparent bor" name="nomor_hp" type="number" placeholder="08xxxxxxx">
                                        </div>
                                        <div class="col-6">
                                            <label for="kampus">Perguruan Tinggi*</label>
                                            <input class="bg-transparent bor" name="kampus" type="text" placeholder="Nama Perguruan Tinggi">
                                        </div>
                                        <div class="col-6">
                                            <label for="fakultas">Fakultas *</label>
                                            <input class="bg-transparent bor" name="fakultas" type="text" placeholder="Nama Fakultas">
                                        </div>
                                        <div class="col-6">
                                            <label for="prodi">Prodi*</label>
                                            <input class="bg-transparent bor" name="prodi" type="text" placeholder="Nam Program Studi">
                                        </div>
                                        <div class="col-6">
                                            <label for="nim">NIM *</label>
                                            <input class="bg-transparent bor" name="nim" type="text" placeholder="NIM">
                                        </div>
                                        <div class="col-12">
                                            <label for="file_jpg">Upload KTP/Kartu Pelajar *</label>
                                            <input class="bg-transparent bor" name="file_jpg" accept=".jpg,.jpeg" type="file">
                                            
                                        </div>
                                        <div class="col-12">
                                            <label for="file_pdf">Upload Surat Permohonan Penelitian *</label>
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
                    <a href="home.html" class="logo mb-30">
                        <img src="assets/images/logo/logo_dnd_dark.png" alt="image">
                    </a>
                    <p>DND Sidekat adalah aplikasi praktis untuk 
                        mengajukan permohonan magang, penelitian, 
                        studi edukasi, dan kunjungan kerja dengan mudah dan cepat.</p>
                    <div class="social-icon">
                        <a href="https://api.whatsapp.com/send/?phone=%2B62895370111060&text&type=phone_number&app_absent=0" target="blank"><i class="fa-brands fa-whatsapp"></i></a>
                        <a href="https://www.instagram.com/dprdjember/" target="blank"><i class="fa-brands fa-instagram"></i></a>
                        <a href="https://www.tiktok.com/@dprdjember"  target="blank"><i class="fa-brands fa-tiktok"></i></a>
                        <a href="https://www.youtube.com/@dprdjember" target="blank"><i class="fa-brands fa-youtube"></i></a>
                    </div>
                </div>
                <div class="footer__item item-mid wow fadeInUp" data-wow-delay="200ms" data-wow-duration="1500ms">
                    <h3 class="footer-title">Layanan</h3>
                    <ul>
                        <li><a href="magang.html"><i class="fa-regular fa-angles-right me-1"></i>
                                Pengajuan Magang</a></li>
                        <li><a href="penelitian.html"><i class="fa-regular fa-angles-right me-1"></i> 
                                Pengajuan Penelitian</a>
                        </li>
                        <li><a href="studi_edukasi.html"><i class="fa-regular fa-angles-right me-1"></i> 
                                Pengejauan Studi Edukasi</a>
                        </li>
                        <li><a href="kunjungan_kerja.html"><i class="fa-regular fa-angles-right me-1"></i>
                                Permohonan Kunjungan Kerja</a></li>
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