<?php
include('./config/database.php'); // Sesuaikan dengan file konfigurasi database Anda

// Cek apakah form sudah di-submit
if (isset($_POST['submit'])) {
    $nomor_hp = $_POST['nomor_hp'];
    $email = $_POST['email'];

    // Query untuk mendapatkan data permohonan sesuai nomor HP dan email
    $query = "SELECT * FROM permohonan_kunjungan_kerja WHERE nomor_hp = ? AND email = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('ss', $nomor_hp, $email);
    $stmt->execute();
    $result = $stmt->get_result();

    // Cek apakah data ditemukan
    if ($result->num_rows > 0) {
        $data_pengajuan = $result->fetch_all(MYSQLI_ASSOC);
    } else {
        $error_message = "Data tidak ditemukan. Pastikan Nomor HP dan Email sesuai dengan data pengajuan.";
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
    <?php include 'layouts/header.php';?>
    <!-- Header area end here -->



    <!-- Fullscreen search area start here -->

    <!-- Fullscreen search area end here -->

    <main>
        <!-- Contact area start here -->
        <section class="contact-area pt-150 pb-120">
            <div class="container">
                <div class="row g-4">
                    <div class="col-lg-12">
                        <div class="contact__right-item">
                            <div class="section-header mb-20">
                                <h5 class="wow fadeInUp pb-2" data-wow-delay="00ms" data-wow-duration="1500ms">
                                    <img class="me-1" src="assets/images/icon/section-title.png" alt="icon">
                                    DND SIDEKAT DPRD KAB. JEMBER
                                </h5>
                                <h2 class="wow fadeInUp" data-wow-delay="200ms" data-wow-duration="1500ms">Tracking Permohonan Kunjungan Kerja</h2>

                            </div>
                            <div class="contact__form">
                                <form action="tracking_kunjungan_kerja.php" method="POST">
                                    <div class="row">
                                        <div class="col-6">
                                            <label for="nomor_hp">Nomor HP</label>
                                            <input name="nomor_hp" class="bg-transparent bor" type="text" placeholder="08xxxxxxx">
                                        </div>
                                        <div class="col-6">
                                            <label for="email">Email*</label>
                                            <input class="bg-transparent bor" name="email" type="email" placeholder="Your Email">
                                        </div>
                                        <div class="btn-two">
                                            <input type="submit" name="submit" value="Lacak" class="btn-one"></input>
                                        </div>
                                    </div>
                                </form>
                                <?php if (isset($data_pengajuan)): ?>
                                    <!-- Alert info -->
                                    <div class="alert alert-info mt-4" role="alert">
                                        Data permohonan kunjungan kerja Anda berhasil ditemukan.
                                    </div>

                                    <div class="mt-3">
                                        <h4>Hasil Tracking Permohonan Kunjungan Kerja</h4>
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>Nomor HP</th>
                                                    <th>Email</th>
                                                    <th>Nama Instansi</th>
                                                    <th>Tanggal Pengajuan</th>
                                                    <th>Status</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach ($data_pengajuan as $pengajuan): ?>
                                                    <tr>
                                                        <td><?= htmlspecialchars($pengajuan['nomor_hp']); ?></td>
                                                        <td><?= htmlspecialchars($pengajuan['email']); ?></td>
                                                        <td><?= htmlspecialchars($pengajuan['nama_instansi']); ?></td>
                                                        <td><?php
                                                            // Mengubah format tanggal pengajuan
                                                            $tanggal_input = date('d-m-Y', strtotime($pengajuan['tanggal_input']));
                                                            echo htmlspecialchars($tanggal_input);
                                                            ?>
                                                        </td>
                                                        <td>
                                                            <?php
                                                            // Mengubah status pending menjadi "Dalam Proses"
                                                            echo $pengajuan['status'] === 'pending' ? 'Dalam Proses' : htmlspecialchars($pengajuan['status']);
                                                            ?>
                                                        </td>
                                                    </tr>
                                                <?php endforeach; ?>
                                            </tbody>
                                        </table>
                                    </div>
                                <?php elseif (isset($error_message)): ?>
                                    <div class="alert alert-danger mt-3"><?= $error_message; ?></div>
                                <?php endif; ?>
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
                    <a href="index.html" class="logo mb-30">
                        <img src="assets/images/logo/logo_dnd_dark.png" alt="image">
                    </a>
                    <p>DND Sidekat adalah aplikasi praktis untuk
                        mengajukan permohonan magang, penelitian,
                        studi edukasi, dan kunjungan kerja dengan mudah dan cepat.</p>
                    <div class="social-icon">
                        <a href="#0"><i class="fa-brands fa-whatsapp"></i></a>
                        <a href="#0"><i class="fa-brands fa-instagram"></i></a>
                        <a href="#0"><i class="fa-brands fa-tiktok"></i></a>
                        <a href="#0"><i class="fa-brands fa-youtube"></i></a>
                    </div>
                </div>
                <div class="footer__item item-mid wow fadeInUp" data-wow-delay="200ms" data-wow-duration="1500ms">
                    <h3 class="footer-title">Layanan</h3>
                    <ul>
                        <li><a href="service-details.html"><i class="fa-regular fa-angles-right me-1"></i>
                                Pengajuan Magang</a></li>
                        <li><a href="service-details.html"><i class="fa-regular fa-angles-right me-1"></i>
                                Pengajuan Penelitian</a>
                        </li>
                        <li><a href="service-details.html"><i class="fa-regular fa-angles-right me-1"></i>
                                Pengejauan Studi Edukasi</a>
                        </li>
                        <li><a href="service-details.html"><i class="fa-regular fa-angles-right me-1"></i>
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