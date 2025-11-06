<?php
include('./config/database.php');

$status_message = ''; // Variabel untuk pesan status

// Cek jika form di-submit
if (isset($_POST['submit'])) {
    $email = $_POST['email'];
    $no_hp = $_POST['no_hp'];

    // Query untuk mencari data pengajuan berdasarkan email dan nomor HP
    $query = "SELECT * FROM pengajuan_rdp WHERE email = ? AND no_hp = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ss", $email, $no_hp);
    $stmt->execute();
    $result = $stmt->get_result();

    // Cek apakah ada hasil
    if ($result->num_rows > 0) {
        $status_message = 'Hasil Pengajuan Ditemukan!';
    } else {
        $status_message = 'Data pengajuan tidak ditemukan. Periksa Email dan No. HP yang Anda masukkan.';
    }
}
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DND Sidekat | Tracking Pengajuan RDP</title>
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
                    <div class="col-lg-12">
                        <div class="contact__right-item">
                            <div class="section-header mb-20">
                                <h5 class="wow fadeInUp pb-2" data-wow-delay="00ms" data-wow-duration="1500ms">
                                    <img class="me-1" src="assets/images/icon/section-title.png" alt="icon">
                                    DND SIDEKAT DPRD KAB. JEMBER
                                </h5>
                                <h2 class="wow fadeInUp" data-wow-delay="200ms" data-wow-duration="1500ms">Tracking Pengajuan Rapat Dengar Pendapat</h2>

                            </div>
                            <div class="contact__form">
                                <form action="tracking_rdp.php" method="POST">
                                    <div class="row">
                                        <div class="col-6">
                                            <label for="email">Email</label>
                                            <input name="email" class="bg-transparent bor" type="email" placeholder="Email" required>
                                        </div>
                                        <div class="col-6">
                                            <label for="no_hp">No. HP</label>
                                            <input class="bg-transparent bor" name="no_hp" type="text" placeholder="Nomor HP" required>
                                        </div>

                                    </div>
                                    <div class="btn-two mt-20">
                                        <span class="btn-circle">
                                        </span>
                                        <input type="submit" name="submit" value="Cari" class="btn-one"></input>
                                    </div>
                                </form>
                            </div>

                            <?php if ($status_message): ?>
                                <div class="mt-40">
                                    <h4 class="mb-20"><?php echo $status_message; ?></h4>

                                    <?php if ($result && $result->num_rows > 0): ?>
                                        <!-- Tabel hasil -->
                                        <div class="table-responsive">
                                            <table class="table table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th>No</th>
                                                        <th>Nama Organisasi</th>
                                                        <th>Email</th>
                                                        <th>Kategori</th>
                                                        <th>Tanggal Pengajuan</th>
                                                        <th>Jam RDP</th>
                                                        <th>Materi RDP</th>
                                                        <th>Status</th>
                                                        <th>Alasan Penolakan</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php $no = 1;
                                                    while ($row = $result->fetch_assoc()): ?>
                                                        <tr>
                                                            <td><?php echo $no++; ?></td>
                                                            <td><?php echo htmlspecialchars($row['nama_organisasi']); ?></td>
                                                            <td><?php echo htmlspecialchars($row['email']); ?></td>
                                                            <td><?php echo htmlspecialchars($row['kategori_organisasi']); ?></td>
                                                            <td><?php echo $row['tanggal_pengajuan'] ? date('d-m-Y', strtotime($row['tanggal_pengajuan'])) : 'Menyesuaikan'; ?></td>
                                                            <td><?php echo $row['jam_rdp'] ? $row['jam_rdp'] : 'Menyesuaikan'; ?></td>
                                                            <td><?php echo htmlspecialchars(substr($row['materi_rdp'], 0, 50)) . '...'; ?></td>
                                                            <td>
                                                                <?php
                                                                if ($row['status'] == 'pending') {
                                                                    echo '<span class="badge bg-warning">Pending</span>';
                                                                } elseif ($row['status'] == 'disetujui') {
                                                                    echo '<span class="badge bg-success">Disetujui</span>';
                                                                } else {
                                                                    echo '<span class="badge bg-danger">Ditolak</span>';
                                                                }
                                                                ?>
                                                            </td>
                                                            <td><?php echo $row['alasan_penolakan'] ? htmlspecialchars($row['alasan_penolakan']) : '-'; ?></td>
                                                        </tr>
                                                    <?php endwhile; ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            <?php endif; ?>

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