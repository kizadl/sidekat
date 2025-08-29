<?php
session_start();
if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit();
}

include '../config/database.php';

// Ambil data admin berdasarkan username
$username = $_SESSION['username'];
$query = 'SELECT * FROM admin WHERE username = ?';
$stmt = $conn->prepare($query);
$stmt->bind_param('s', $username);
$stmt->execute();
$result = $stmt->get_result();
$admin = $result->fetch_assoc();

// Proses pembaruan nama dan username
$update_success = false; // Menyimpan status pembaruan

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama_baru = $_POST['nama'];
    $username_baru = $_POST['username'];

    // Update nama dan username di database
    $update_query = 'UPDATE admin SET nama = ?, username = ? WHERE username = ?';
    $update_stmt = $conn->prepare($update_query);
    $update_stmt->bind_param('sss', $nama_baru, $username_baru, $username);

    if ($update_stmt->execute()) {
        // Update session username
        $_SESSION['username'] = $username_baru;
        $update_success = true; // Set status sukses
    } else {
        echo 'Gagal memperbarui data admin.';
    }
}

// Ambil data admin lagi untuk memastikan nilai terbaru
$query = 'SELECT * FROM admin WHERE username = ?';
$stmt = $conn->prepare($query);
$stmt->bind_param('s', $_SESSION['username']);
$stmt->execute();
$result = $stmt->get_result();
$admin = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <?php
    $title = 'Pengaturan Admin';
    include 'layouts/head.php';
    ?>
</head>

<body>
    <!-- Begin page -->
    <div class="wrapper">

        <!-- ========== Topbar Start ========== -->
        <?php include 'layouts/navbar.php'; ?>
        <!-- ========== Topbar End ========== -->

        <!-- ========== Left Sidebar Start ========== -->
        <?php include 'layouts/sidebar.php'; ?>
        <!-- ========== Left Sidebar End ========== -->

        <!-- ============================================================== -->
        <!-- Start Page Content here -->
        <!-- ============================================================== -->

        <br>
        <div class="content-page">
            <div class="content">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="header-title">Custom styles</h4>
                                <p class="text-muted fs-14">Custom feedback styles apply custom colors, borders,
                                    focus styles, and background
                                    icons to better communicate feedback. Background icons for
                                    <code>&lt;select&gt;</code>s are only available with
                                    <code>.form-select</code>, and not <code>.form-control</code>.
                                </p>

                                <form method="POST" class="needs-validation" novalidate>
                                    <div class="mb-3">
                                        <label class="form-label" for="username">Username</label>
                                        <input type="text" class="form-control" id="username" name="username"
                                            value="<?php echo htmlspecialchars($admin['username'], ENT_QUOTES, 'UTF-8'); ?>" required>
                                        <div class="valid-feedback">
                                            Looks good!
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label" for="nama">Nama</label>
                                        <input type="text" class="form-control" id="nama" name="nama"
                                            value="<?php echo htmlspecialchars($admin['nama'], ENT_QUOTES, 'UTF-8'); ?>" required>
                                        <div class="valid-feedback">
                                            Looks good!
                                        </div>
                                    </div>
                                    <button class="btn btn-primary" type="submit">Submit form</button>
                                </form>
                                <?php if ($update_success): ?>
                                <script>
                                    showAlert(); // Panggil fungsi untuk menampilkan alert
                                </script>
                                <?php endif; ?>
                            </div> <!-- end card-body-->
                        </div> <!-- end card-->
                    </div> <!-- end col-->
                </div>
                <!-- Footer Start -->
                <footer class="footer">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-md-6">
                                <script>
                                    document.write(new Date().getFullYear())
                                </script> © DPRD Kabupaten Jember
                            </div>
                            <div class="col-md-6">
                                <div class="text-md-end footer-links d-none d-md-block">
                                    <a>DND Sidekat</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </footer>
            </div>
        </div>
    </div>
</body>

</html>
