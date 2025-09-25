<?php
include('./config/database.php');

// Ambil data pendidikan untuk dropdown
$sql_pendidikan = "SELECT * FROM ikm_pendidikan ORDER BY id";
$result_pendidikan = $conn->query($sql_pendidikan);

// Ambil data pekerjaan untuk dropdown
$sql_pekerjaan = "SELECT * FROM ikm_pekerjaan ORDER BY id";
$result_pekerjaan = $conn->query($sql_pekerjaan);

// Ambil data soal survei
$sql_soal = "SELECT * FROM ikm_soal ORDER BY id";
$result_soal = $conn->query($sql_soal);

if (isset($_POST['submit'])) {
    // Validasi input data diri
    $nama = mysqli_real_escape_string($conn, $_POST['nama']);
    $umur = mysqli_real_escape_string($conn, $_POST['umur']);
    $kelamin = mysqli_real_escape_string($conn, $_POST['kelamin']);
    $id_pendidikan = mysqli_real_escape_string($conn, $_POST['id_pendidikan']);
    $id_pekerjaan = mysqli_real_escape_string($conn, $_POST['id_pekerjaan']);
    $tanggal = date('Y-m-d H:i:s');

    // Cek jika form data diri diisi
    if ($nama && $umur && $kelamin && $id_pendidikan && $id_pekerjaan) {
        // Mulai transaction
        $conn->begin_transaction();
        try {
            // Insert ke tabel ikm_survei dengan prepared statement
            $sql_survei = "INSERT INTO ikm_survei (nama, umur, kelamin, id_pendidikan, id_pekerjaan, tanggal) VALUES (?, ?, ?, ?, ?, ?)";
            $stmt_survei = $conn->prepare($sql_survei);
            $stmt_survei->bind_param('sissis', $nama, $umur, $kelamin, $id_pendidikan, $id_pekerjaan, $tanggal);
            if ($stmt_survei->execute()) {
                $id_survei = $conn->insert_id;
                // Insert jawaban survei ke ikm_detail_survei dengan prepared statement
                $sql_detail = "INSERT INTO ikm_detail_survei (id_survei, id_soal, jawaban) VALUES (?, ?, ?)";
                $stmt_detail = $conn->prepare($sql_detail);
                $success = true;
                foreach ($_POST['jawaban'] as $id_soal => $jawaban) {
                    $stmt_detail->bind_param('iis', $id_survei, $id_soal, $jawaban);
                    if (!$stmt_detail->execute()) {
                        $success = false;
                        break;
                    }
                }
                if ($success) {
                    $conn->commit();
                    echo "<script>alert('Survei berhasil disimpan! Terima kasih atas partisipasi Anda.'); window.location.href='ikm_survei.html';</script>";
                } else {
                    throw new Exception("Gagal menyimpan detail survei");
                }
            } else {
                throw new Exception("Gagal menyimpan data survei");
            }
        } catch (Exception $e) {
            $conn->rollback();
            echo "<script>alert('Error: " . $e->getMessage() . "'); window.location.href='ikm_survei.html';</script>";
        }
    } else {
        echo "<script>alert('Harap isi semua kolom data diri!'); window.location.href='ikm_survei.html';</script>";
    }
}
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Survei IKM - DPRD Kabupaten Jember</title>
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

    <style>
        .nav-tabs .nav-link {
            background-color: #f8f9fa;
            color: #333;
            border: 1px solid #dee2e6;
            margin-right: 5px;
        }

        .nav-tabs .nav-link.active {
            background-color: #007bff;
            color: white;
            border-color: #007bff;
        }

        .nav-tabs .nav-link.disabled {
            background-color: #e9ecef;
            color: #6c757d;
        }

        .tab-content {
            padding: 30px;
            border: 1px solid #dee2e6;
            border-top: none;
            background-color: #fff;
        }

        .survei-question {
            background-color: #f8f9fa;
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 5px;
        }

        .btn-nav {
            margin-top: 20px;
        }

        .btn-group {
            gap: 10px;
        }

        .btn-group .btn {
            flex: 1;
            padding: 15px 10px;
            text-align: center;
            border-radius: 10px !important;
            transition: all 0.3s ease;
        }

        .btn-group .btn i {
            font-size: 24px;
            margin-bottom: 5px;
        }

        .btn-check:checked+.btn-outline-danger {
            background-color: #dc3545;
            border-color: #dc3545;
            color: white;
        }

        .btn-check:checked+.btn-outline-warning {
            background-color: #ffc107;
            border-color: #ffc107;
            color: white;
        }

        .btn-check:checked+.btn-outline-success {
            background-color: #198754;
            border-color: #198754;
            color: white;
        }

        .btn-check:checked+.btn-outline-primary {
            background-color: #0d6efd;
            border-color: #0d6efd;
            color: white;
        }

        .btn-group .btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>

<body>
    <!-- Header area start here -->
    <?php include 'layouts/header.php'; ?>
    <!-- Header area end here -->

    <main>
        <!-- Survei IKM area start here -->
        <section class="contact-area pt-150 pb-120">
            <div class="container">
                <div class="row g-4">
                    <div class="col-lg-4">
                        <div class="contact__left-item primary-bg">
                            <h3 class="text-white mb-30">Survei IKM</h3>
                            <p class="text-white">Indeks Kepuasan Masyarakat (IKM) adalah data dan informasi tentang tingkat kepuasan masyarakat yang diperoleh dari hasil pengukuran secara kuantitatif dan kualitatif atas pendapat masyarakat dalam memperoleh pelayanan.</p>

                            <ul class="mt-40 mb-100">
                                <li>
                                    <div>
                                        <h4 class="text-white">Petunjuk Pengisian</h4>
                                        <p class="text-white" style="text-align: justify;">
                                            1. Isi data diri Anda dengan lengkap dan benar<br>
                                            2. Jawab semua pertanyaan survei dengan jujur<br>
                                            3. Pilih salah satu jawaban yang paling sesuai<br>
                                            4. Klik tombol "Kirim Survei" setelah semua pertanyaan dijawab
                                        </p>
                                    </div>
                                    <div class="mt-4">
                                        <h4 class="text-white">Skala Penilaian</h4>
                                        <p class="text-white" style="text-align: justify;">
                                            1 = Tidak Baik<br>
                                            2 = Kurang Baik<br>
                                            3 = Baik<br>
                                            4 = Sangat Baik
                                        </p>
                                    </div>
                                </li>
                            </ul>

                            <h4 class="text-white mb-20">Follow Social:</h4>
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
                                    DPRD KAB. JEMBER
                                </h5>
                                <h2 class="wow fadeInUp" data-wow-delay="200ms" data-wow-duration="1500ms">
                                    Form Survei Kepuasan Masyarakat
                                </h2>
                            </div>

                            <div class="contact__form">
                                <form action="" method="POST" id="surveiForm">
                                    <!-- Tab Navigation -->
                                    <ul class="nav nav-tabs" id="surveiTab" role="tablist">
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link active" id="datadiri-tab" data-bs-toggle="tab" data-bs-target="#datadiri" type="button" role="tab">
                                                Data Diri
                                            </button>
                                        </li>
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link" id="survei-tab" data-bs-toggle="tab" data-bs-target="#survei" type="button" role="tab" disabled>
                                                Survei IKM
                                            </button>
                                        </li>
                                    </ul>

                                    <!-- Tab Content -->
                                    <div class="tab-content" id="surveiTabContent">
                                        <!-- Tab Data Diri -->
                                        <div class="tab-pane fade show active" id="datadiri" role="tabpanel">
                                            <h4 class="mb-4">Silakan isi data diri Anda</h4>
                                            <div class="row">
                                                <div class="col-12 mb-3">
                                                    <label for="nama">Nama Lengkap *</label>
                                                    <input name="nama" id="nama" oninput="this.value = this.value.replace(/[^a-zA-Z ]/g, '')" class="form-control bg-transparent bor" type="text" placeholder="Masukkan nama lengkap" required>
                                                </div>

                                                <div class="col-6 mb-3">
                                                    <label for="umur">Umur *</label>
                                                    <input name="umur" id="umur" class="form-control bg-transparent bor" type="number" placeholder="Masukkan umur" min="17" max="100" required>
                                                </div>

                                                <div class="col-6 mb-3">
                                                    <label for="kelamin">Jenis Kelamin *</label>
                                                    <select name="kelamin" id="kelamin" class="form-control bg-transparent bor" required>
                                                        <option value="">-- Pilih Jenis Kelamin --</option>
                                                        <option value="L">Laki-laki</option>
                                                        <option value="P">Perempuan</option>
                                                    </select>
                                                </div>

                                                <div class="col-6 mb-3">
                                                    <label for="id_pendidikan">Pendidikan Terakhir*</label>
                                                    <select name="id_pendidikan" id="id_pendidikan" class="form-control bg-transparent bor" required>
                                                        <option value="">-- Pilih Pendidikan --</option>
                                                        <?php while ($row = $result_pendidikan->fetch_assoc()): ?>
                                                            <option value="<?php echo $row['id']; ?>"><?php echo $row['nama']; ?></option>
                                                        <?php endwhile; ?>
                                                    </select>
                                                </div>

                                                <div class="col-6 mb-3">
                                                    <label for="id_pekerjaan">Pekerjaan *</label>
                                                    <select name="id_pekerjaan" id="id_pekerjaan" class="form-control bg-transparent bor" required>
                                                        <option value="">-- Pilih Pekerjaan --</option>
                                                        <?php while ($row = $result_pekerjaan->fetch_assoc()): ?>
                                                            <option value="<?php echo $row['id']; ?>"><?php echo $row['nama']; ?></option>
                                                        <?php endwhile; ?>
                                                    </select>
                                                </div>

                                                <div class="col-12">
                                                    <button type="button" class="btn btn-primary btn-nav" onclick="nextTab()">
                                                        Lanjut ke Survei <i class="fa fa-arrow-right ms-2"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Tab Survei -->
                                        <div class="tab-pane fade" id="survei" role="tabpanel">
                                            <h4 class="mb-4">Survei Kepuasan Masyarakat</h4>
                                            <p class="mb-4">Berikan penilaian Anda terhadap pelayanan kami:</p>

                                            <?php
                                            // Reset pointer hasil query
                                            $result_soal->data_seek(0);
                                            $no = 1;
                                            while ($soal = $result_soal->fetch_assoc()):
                                            ?>
                                                <div class="survei-question">
                                                    <h6><?php echo $no . ". " . $soal['pertanyaan']; ?></h6>
                                                    <div class="btn-group w-100 mt-3" role="group">
                                                        <input type="radio" class="btn-check" name="jawaban[<?php echo $soal['id']; ?>]" id="btnradio1_<?php echo $soal['id']; ?>" value="1" required>
                                                        <label class="btn btn-outline-danger" for="btnradio1_<?php echo $soal['id']; ?>">
                                                            <i class="fas fa-frown"></i><br>
                                                            Tidak Baik
                                                        </label>

                                                        <input type="radio" class="btn-check" name="jawaban[<?php echo $soal['id']; ?>]" id="btnradio2_<?php echo $soal['id']; ?>" value="2" required>
                                                        <label class="btn btn-outline-warning" for="btnradio2_<?php echo $soal['id']; ?>">
                                                            <i class="fas fa-meh"></i><br>
                                                            Kurang Baik
                                                        </label>

                                                        <input type="radio" class="btn-check" name="jawaban[<?php echo $soal['id']; ?>]" id="btnradio3_<?php echo $soal['id']; ?>" value="3" required>
                                                        <label class="btn btn-outline-success" for="btnradio3_<?php echo $soal['id']; ?>">
                                                            <i class="fas fa-smile"></i><br>
                                                            Baik
                                                        </label>

                                                        <input type="radio" class="btn-check" name="jawaban[<?php echo $soal['id']; ?>]" id="btnradio4_<?php echo $soal['id']; ?>" value="4" required>
                                                        <label class="btn btn-outline-primary" for="btnradio4_<?php echo $soal['id']; ?>">
                                                            <i class="fas fa-grin-stars"></i><br>
                                                            Sangat Baik
                                                        </label>
                                                    </div>
                                                </div>
                                            <?php
                                                $no++;
                                            endwhile;
                                            ?>

                                            <div class="row mt-4">
                                                <div class="col-6">
                                                    <button type="button" class="btn btn-secondary btn-nav" onclick="prevTab()">
                                                        <i class="fa fa-arrow-left me-2"></i> Kembali
                                                    </button>
                                                </div>
                                                <div class="col-6 text-end">
                                                    <button type="submit" name="submit" class="btn btn-success btn-nav">
                                                        <i class="fa fa-paper-plane me-2"></i> Kirim Survei
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- Survei IKM area end here -->
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
                    <p>Sistem Survei IKM untuk mengukur kepuasan masyarakat terhadap pelayanan DPRD Kabupaten Jember.</p>
                    <div class="social-icon">
                        <a href="https://api.whatsapp.com/send/?phone=%2B62895370111060&text&type=phone_number&app_absent=0" target="blank"><i class="fa-brands fa-whatsapp"></i></a>
                        <a href="https://www.instagram.com/dprdjember/" target="blank"><i class="fa-brands fa-instagram"></i></a>
                        <a href="https://www.tiktok.com/@dprdjember" target="blank"><i class="fa-brands fa-tiktok"></i></a>
                        <a href="https://www.youtube.com/@dprdjember" target="blank"><i class="fa-brands fa-youtube"></i></a>
                    </div>
                </div>

                <div class="footer__item item-big wow fadeInUp" data-wow-delay="600ms" data-wow-duration="1500ms">
                    <h3 class="footer-title">Contact Us</h3>
                    <p class="mb-10">Jl. Kalimantan No. 86 Jember (68121)</p>
                    <ul class="footer-contact">
                        <li>
                            <i class="fa-regular fa-clock"></i>
                            <div class="info">
                                <h5>Jam Kerja :</h5>
                                <p>Senin - Kamis : 08.00 - 16.00 WIB</p>
                                <p>Jum'at : 08.00 - 15.30 WIB</p>
                            </div>
                        </li>
                        <li>
                            <i class="fa-duotone fa-phone"></i>
                            <div class="info">
                                <h5>No. Telp :</h5>
                                <p>(0331) 335444 – 335567</p>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="footer__copyright">
            <div class="container">
                <div class="d-flex gap-1 flex-wrap align-items-center justify-content-md-between justify-content-center">
                    <p class="wow fadeInDown" data-wow-delay="00ms" data-wow-duration="1500ms">
                        &copy; All Copyright 2024 by <a href="#0">DPRD Kabupaten Jember</a>
                    </p>
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

    <script>
        function validateDataDiri() {
            var nama = document.getElementById('nama').value;
            var umur = document.getElementById('umur').value;
            var kelamin = document.getElementById('kelamin').value;
            var pendidikan = document.getElementById('id_pendidikan').value;
            var pekerjaan = document.getElementById('id_pekerjaan').value;

            if (!nama || !umur || !kelamin || !pendidikan || !pekerjaan) {
                alert('Harap lengkapi semua data diri sebelum melanjutkan!');
                return false;
            }
            return true;
        }

        function nextTab() {
            if (validateDataDiri()) {
                // Enable survei tab
                document.getElementById('survei-tab').disabled = false;

                // Switch to survei tab
                var surveiTab = new bootstrap.Tab(document.getElementById('survei-tab'));
                surveiTab.show();
            }
        }

        function prevTab() {
            // Switch back to data diri tab
            var dataDiriTab = new bootstrap.Tab(document.getElementById('datadiri-tab'));
            dataDiriTab.show();
        }

        // Prevent form submission if validation fails
        document.getElementById('surveiForm').addEventListener('submit', function(e) {
            if (!validateDataDiri()) {
                e.preventDefault();
                alert('Harap lengkapi data diri terlebih dahulu!');
                return false;
            }

            // Check if all survey questions are answered
            var surveyQuestions = document.querySelectorAll('input[type="radio"][required]');
            var groupedQuestions = {};

            surveyQuestions.forEach(function(question) {
                var name = question.getAttribute('name');
                if (!groupedQuestions[name]) {
                    groupedQuestions[name] = false;
                }
                if (question.checked) {
                    groupedQuestions[name] = true;
                }
            });

            for (var key in groupedQuestions) {
                if (!groupedQuestions[key]) {
                    e.preventDefault();
                    alert('Harap jawab semua pertanyaan survei!');
                    return false;
                }
            }
        });
    </script>
</body>

</html>