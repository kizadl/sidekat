<?php
// Koneksi ke database
include './config/database.php';

// Ambil kuota magang dari tabel pengaturan
$query = "SELECT value FROM pengaturan WHERE key_name = 'kuota_magang'";
$result = $conn->query($query);
$row = $result->fetch_assoc();
$kuota_magang = $row['value'];

// Hitung jumlah mahasiswa magang yang disetujui tetapi bukan diarsip
$query = "
    SELECT SUM(jumlah_mahasiswa) AS total_mahasiswa 
    FROM pengajuan_magang 
    WHERE status = 'disetujui' AND status_data != 'arsip'
";
$result = $conn->query($query);
$row = $result->fetch_assoc();
$total_mahasiswa = $row['total_mahasiswa'] ?? 0;

// Hitung sisa kuota
$sisa_kuota = $kuota_magang - $total_mahasiswa;

// Tentukan pesan berdasarkan sisa kuota
if ($sisa_kuota < 0) {
    $status_kuota = 'Slot Overload';
} elseif ($sisa_kuota === 0) {
    $status_kuota = 'Sudah Penuh';
} elseif ($sisa_kuota <= 10) {
    $status_kuota = 'Hampir Penuh';
} else {
    $status_kuota = 'Tersedia';
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DND SIDEKAT DPRD KABUPATEN JEMBER</title>
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

    <!-- Header area start here -->
    <?php include 'layouts/header.php'; ?>
    <!-- Header area end here -->

    <!-- Sidebar area start here -->
    <div id="targetElement" class="sidebar-area sidebar__hide">
        <div class="sidebar__overlay"></div>
        <a href="home.html" class="logo mb-40">
            <img src="assets/images/logo/logo_dnd_dark.png" alt="logo">
        </a>
        <!-- <div class="sidebar__search mb-30">
            <input type="text" placeholder="Search...">
            <i class="fa-regular fa-magnifying-glass"></i>
            </div> -->
        <div class="mobile-menu overflow-hidden"></div>
        <!-- <ul class="info pt-40">
            <li><i class="fa-solid primary-color fa-location-dot"></i> <a href="#0">example@example.com</a>
            </li>
            <li class="py-2"><i class="fa-solid primary-color fa-phone-volume"></i>
                <a href="tel:+208-6666-0112">+208-6666-0112</a>
            </li>
            <li><i class="fa-solid primary-color fa-paper-plane"></i> <a href="#0">info@example.com</a></li>
        </ul> -->
        <div class="social-icon mt-20">
            <a href="https://api.whatsapp.com/send/?phone=%2B62895370111060&text&type=phone_number&app_absent=0"
                target="blank"><i class="fa-brands fa-whatsapp"></i></a>
            <a href="https://www.instagram.com/dprdjember/" target="blank"><i class="fa-brands fa-instagram"></i></a>
            <a href="https://www.tiktok.com/@dprdjember" target="blank"><i class="fa-brands fa-tiktok"></i></a>
            <a href="https://www.youtube.com/@dprdjember" target="blank"><i class="fa-brands fa-youtube"></i></a>
        </div>
        <button id="closeButton" class="text-white"><i class="fa-solid fa-xmark"></i></button>
    </div>
    <!-- Sidebar area end here -->

    <!-- Fullscreen search area start here -->
    <div class="search-wrap">
        <div class="search-inner">
            <i class="fas fa-times search-close" id="search-close"></i>
            <div class="search-cell">
                <form method="get">
                    <div class="search-field-holder">
                        <input type="search" class="main-search-input" placeholder="Search...">
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Fullscreen search area end here -->

    <main>
        <!-- Banner area start here -->
        <div class="banner-three-area">
            <div class="banner-three__bg">
                <img class="sway_Y__animation" src="assets/images/bg/banner-three-bg.png" alt="bg-image">
            </div>
            <div class="banner-three__shape-left wow slideInLeft" data-wow-delay="00ms" data-wow-duration="1500ms">
                <img class="sway_Y__animationY" src="assets/images/banner/banner-three-left-shape.png" alt="image">
            </div>
            <div class="banner-three__shape-right wow slideInRight" data-wow-delay="200ms" data-wow-duration="1500ms">
                <img class="sway__animationX" src="assets/images/banner/banner-three-right-shape.png" alt="image">
            </div>
            <div class="banner-three__container">
                <div class="row align-items-center">
                    <div class="col-lg-7 order-2 order-lg-1">
                        <div class="banner-three__content pt-0 pb-0">
                            <h4 class="wow fadeInUp text-white mb-20" data-wow-delay="00ms" data-wow-duration="1500ms">
                                DPRD KABUPATEN JEMBER
                            </h4>
                            <h2 class="wow fadeInUp text-white" data-wow-delay="200ms" data-wow-duration="1500ms">
                                Permohonan Mudah, Akses Cepat, Peluang Terbuka
                            </h2>
                            <p class="wow fadeInUp mt-20" data-wow-delay="400ms" data-wow-duration="1500ms">
                                DND Sidekat adalah aplikasi praktis untuk mengajukan permohonan magang, penelitian,
                                studi edukasi, dan kunjungan kerja dengan mudah dan cepat.
                            </p>
                            <div class="banner-three__info wow fadeInUp mt-50" data-wow-delay="600ms"
                                data-wow-duration="1500ms">
                                <a class="wow fadeInUp btn-one mt-0" data-delay="1s" href="#layanan">Layanan Kami <i
                                        class="fa-regular fa-arrow-right-long"></i></a>
                                <a class="wow fadeInUp btn-one mt-0" data-delay="1s" href="#kuota-section">Cek Kuota
                                    Magang <i class="fa-regular fa-arrow-right-long"></i></a>
                            </div>

                        </div>
                    </div>
                    <div class="col-lg-5 order-1 order-lg-2 wow fadeInLeft" data-wow-delay="200ms"
                        data-wow-duration="1500ms">
                        <div class="image">
                            <img src="assets/images/banner/banner1.png" alt="image">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Banner area end here -->

        <section id="about-section" class="about-area about-three-area sub-bg pt-120">
            <div class="about__shape wow slideInLeft" data-wow-delay="400ms" data-wow-duration="1500ms">
                <img src="assets/images/shape/about-three-line.png" alt="shape">
            </div>
            <div class="about-three__box-up wow slideInRight" data-wow-delay="00ms" data-wow-duration="1500ms">
                <img class="sway_Y__animationY" src="assets/images/shape/about-three-box-up.png" alt="shape">
            </div>
            <div class="about-three__box-down wow slideInRight" data-wow-delay="200ms" data-wow-duration="1500ms">
                <img class="sway_Y__animation" src="assets/images/shape/about-three-box-down.png" alt="shape">
            </div>
            <div class="container">
                <div class="row g-4 align-items-center">
                    <div class="col-lg-5 order-2 order-lg-1">
                        <div class="about-three__left-item">
                            <div class="section-header mb-40">
                                <h5 class="wow fadeInUp" data-wow-delay="00ms" data-wow-duration="1500ms">
                                    <img class="me-1" src="assets/images/icon/section-title.png" alt="icon">
                                    Tentang D&D Sidekat
                                </h5>
                                <h2 class="wow fadeInUp" data-wow-delay="200ms" data-wow-duration="1500ms">Sekilas
                                    Tentang <br> D&D Sidekat</h2>
                                <p class="wow fadeInUp" data-wow-delay="400ms" data-wow-duration="1500ms"
                                    style="text-align: justify;">DND Sidekat Kabupaten Jember adalah aplikasi inovasi yang memudahkan proses pengajuan Rapat Dengar Pendapat, Kunjungan Kerja, Studi Edukasi, Penelitian dan Magang baik dari berbagai instansi pemerintah dan lembaga pendidikan. Dengan DND Sidekat, pengguna dapat mengajukan permohonan secara digital, memantau status pengajuan, serta mendapatkan notifikasi langsung mengenai persetujuan atau penolakan permohonan mereka. Aplikasi ini hadir untuk mempercepat proses administrasi, mengurangi penggunaan kertas, dan menjadikan layanan publik lebih transparan serta efisien. Kini, warga Jember yang ingin mendapatkan pengalaman profesional maupun akademis dapat mengakses kesempatan tersebut dengan lebih mudah melalui DND Sidekat. </p>
                            </div>

                        </div>
                    </div>
                    <div class="col-lg-7 order-1 order-lg-2">
                        <div class="faq__image about-three__image image wow fadeInRight" data-wow-delay="200ms"
                            data-wow-duration="1500ms">
                            <div class="about-three-dot">
                                <img class="sway__animationX" src="assets/images/shape/about-three-dot.png"
                                    alt="shape">
                            </div>
                            <div class="faq__line sway__animation">
                                <img src="assets/images/shape/faq-line.png" alt="image">
                            </div>
                            <img src="assets/images/about/about.jpg" alt="image">
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="counter-area" id="kuota-section">
            <div class="container">
                <div class="counter__wrp gradient-bg">
                    <div class="counter__shape wow slideInRight" data-wow-delay="200ms" data-wow-duration="1500ms">

                    </div>
                    <div class="counter__item wow bounceInUp" data-wow-delay="00ms" data-wow-duration="1000ms">
                        <img src="assets/images/icon/infokuota1.png" alt="icon">
                        <div class="content">
                            <h3><span class="count"><?php echo $kuota_magang; ?></span></h3>
                            <p class="text-white">Quota Magang</p>
                        </div>
                    </div>
                    <div class="counter__item wow bounceInUp" data-wow-delay="200ms" data-wow-duration="1000ms">
                        <img src="assets/images/icon/infokuota2.png" alt="icon">
                        <div class="content">
                            <h3><span class="count"><?php echo $total_mahasiswa; ?></span></h3>
                            <p class="text-white">Mahasiswa Diterima</p>
                        </div>
                    </div>
                    <div class="counter__item wow bounceInUp" data-wow-delay="400ms" data-wow-duration="1000ms">
                        <img src="assets/images/icon/infokuota3.png" alt="icon">
                        <div class="content">
                            <h3><span class="count"><?php echo max($sisa_kuota, 0); ?></span></h3>
                            <p class="text-white">Ketersediaan</p>
                        </div>
                    </div>
                    <div class="counter__item wow bounceInUp" data-wow-delay="400ms" data-wow-duration="1000ms">
                        <img src="assets/images/icon/infokuota4.png" alt="icon">
                        <div class="content">
                            <h3><span><?php echo $status_kuota; ?></span></h3>
                            <p class="text-white">Status Ketersediaan</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Service area start here -->
        <section class="service-three-area pt-120 pb-120" id="layanan">
            <div class="service-three__shape">
                <img class="sway__animationX" src="assets/images/shape/service-three-shape.png" alt="shape">
            </div>
            <div class="container">
                <div class="section-header text-center mb-60">
                    <h5 class="wow fadeInUp" data-wow-delay="00ms" data-wow-duration="1500ms">
                        <img class="me-1" src="assets/images/icon/section-title.png" alt="icon">
                        D&D Sidekat DPRD Kabupaten Jember
                    </h5>
                    <h2 class="wow fadeInUp" data-wow-delay="200ms" data-wow-duration="1500ms">Layanan Kami</h2>
                </div>
                <div class="row g-4">
                    <!-- Layanan Pengajuan Rapat Dengar Pendapat -->
                    <div class="col-xl-3 col-md-6 wow fadeInUp" data-wow-delay="00ms" data-wow-duration="1500ms">
                        <div class="service-three__item">
                            <div class="service-three__image image">
                                <img src="assets/images/service/kunjungan_kerja.jpg" alt="image">
                            </div>
                            <div class="service-three__content">
                                <div class="icon">
                                    <img src="assets/images/icon/kunjungan_kerja.png" alt="icon" width="40px">
                                </div>
                                <h5>Rapat Dengar Pendapat</h5>
                            </div>
                            <div class="service-three__up-content text-center">
                                <h4><a href="pengajuan_rdp.php" class="text-white mb-15">Pengajuan Rapat Dengar Pendapat</a>
                                </h4>
                                <p class="text-white">Pengajuan Rapat Dengar Pendapat pada DPRD Kabupaten Jember</p>
                                <a class="mt-10 read-more-btn text-white" href="pengajuan_rdp.php">Selengkapnya<i
                                        class="fa-regular fa-arrow-right-long text-white"></i></a>
                            </div>
                        </div>
                    </div>

                    <!-- Layanan Pengajuan Kunjungan Kerja -->
                    <div class="col-xl-3 col-md-6 wow fadeInUp" data-wow-delay="200ms" data-wow-duration="1500ms">
                        <div class="service-three__item">
                            <div class="service-three__image image">
                                <img src="assets/images/service/kunjungan_kerja.jpg" alt="image">
                            </div>
                            <div class="service-three__content">
                                <div class="icon">
                                    <img src="assets/images/icon/kunjungan_kerja.png" alt="icon" width="40px">
                                </div>
                                <h5>Kunjungan Kerja</h5>
                            </div>
                            <div class="service-three__up-content text-center">
                                <h4><a href="kunjungan_kerja.html" class="text-white mb-15">Permohonan Kunjungan
                                        Kerja</a>
                                </h4>
                                <p class="text-white">Permohonan Kunjungan Kerja pada DPRD Kabupaten Jember</p>
                                <a class="mt-10 read-more-btn text-white" href="kunjungan_kerja.html">Selengkapnya<i
                                        class="fa-regular fa-arrow-right-long text-white"></i></a>
                            </div>
                        </div>
                    </div>

                    <!-- Layanan Pengajuan Studi Edukasi -->
                    <div class="col-xl-3 col-md-6 wow fadeInUp" data-wow-delay="300ms" data-wow-duration="1500ms">
                        <div class="service-three__item">
                            <div class="service-three__image image">
                                <img src="assets/images/service/studi.jpg" alt="image">
                            </div>
                            <div class="service-three__content">
                                <div class="icon">
                                    <img src="assets/images/icon/studi_edukasi.png" alt="icon" width="40px">
                                </div>
                                <h5>Pengajuan Studi Edukasi</h5>
                            </div>
                            <div class="service-three__up-content text-center">
                                <h4><a href="studi_edukasi.html" class="text-white mb-15">Pengajuan Studi Edukasi</a>
                                </h4>
                                <p class="text-white">Pengajuan studi edukasi pada DPRD Kabupaten Jember</p>
                                <a class="mt-10 read-more-btn text-white" href="studi_edukasi.html">Selengkapnya<i
                                        class="fa-regular fa-arrow-right-long text-white"></i></a>
                            </div>
                        </div>
                    </div>

                    <!-- Layanan Pengajuan Penelitian -->
                    <div class="col-xl-3 col-md-6 wow fadeInUp" data-wow-delay="400ms" data-wow-duration="1500ms">
                        <div class="service-three__item">
                            <div class="service-three__image image">
                                <img src="assets/images/service/penelitian.jpg" alt="image">
                            </div>
                            <div class="service-three__content">
                                <div class="icon">
                                    <img src="assets/images/icon/penelitian.png" alt="icon" width="40px">
                                </div>
                                <h5>Pengajuan Penelitian</h5>
                            </div>
                            <div class="service-three__up-content text-center">
                                <h4><a href="penelitian.html" class="text-white mb-15">Pengajuan Penelitian</a>
                                </h4>
                                <p class="text-white">Pengajuan penelitian yang dilakukan pada DPRD Kabupaten Jember
                                </p>
                                <a class="mt-10 read-more-btn text-white" href="penelitian.html">Selengkapnya<i
                                        class="fa-regular fa-arrow-right-long text-white"></i></a>
                            </div>
                        </div>
                    </div>
                    <!-- Layanan Pengajuan Magang -->
                    <div class="col-xl-3 col-md-6 wow fadeInUp" data-wow-delay="400ms" data-wow-duration="1500ms">
                        <div class="service-three__item">
                            <div class="service-three__image image">
                                <img src="assets/images/service/magang.jpg" alt="image">
                            </div>
                            <div class="service-three__content">
                                <div class="icon">
                                    <img src="assets/images/icon/magang.png" alt="icon" width="40px">
                                </div>
                                <h5>Pengajuan Magang</h5>
                            </div>
                            <div class="service-three__up-content text-center">
                                <h4><a href="magang.html" class="text-white mb-15">Pengajuan Magang</a>
                                </h4>
                                <p class="text-white">Pengajuan magang siswa/mahasiswa pada DPRD Kabupaten Jember</p>
                                <a class="mt-10 read-more-btn text-white" href="magang.html">Selengkapnya<i
                                        class="fa-regular fa-arrow-right-long text-white"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- Service area end here -->

        <!-- Brand area start here -->
        <!-- Brand area end here -->

        <!-- About area start here -->

        <!-- About area end here -->

        <!-- Counter area start here -->

        <!-- Counter area end here -->

        <!-- Project area start here -->

        <!-- Project area end here -->

        <!-- Banner video area start here -->

        <!-- Banner video area end here -->

        <!-- Pricing area start here -->

        <!-- Pricing area end here -->

        <!-- Testimonial area start here -->

        <!-- Testimonial area end here -->

        <!-- Blog area start here -->

        <!-- Blog area end here -->
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
                        <a href="https://api.whatsapp.com/send/?phone=%2B62895370111060&text&type=phone_number&app_absent=0"
                            target="blank"><i class="fa-brands fa-whatsapp"></i></a>
                        <a href="https://www.instagram.com/dprdjember/" target="blank"><i
                                class="fa-brands fa-instagram"></i></a>
                        <a href="https://www.tiktok.com/@dprdjember" target="blank"><i
                                class="fa-brands fa-tiktok"></i></a>
                        <a href="https://www.youtube.com/@dprdjember" target="blank"><i
                                class="fa-brands fa-youtube"></i></a>
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
                    <p class="wow fadeInDown" data-wow-delay="00ms" data-wow-duration="1500ms">&copy; All Copyright
                        2024
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