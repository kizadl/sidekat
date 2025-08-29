<div class="leftside-menu">

    <!-- Brand Logo Light -->
    <a href="dashboard.html" class="logo logo-light">
        <span class="logo-lg">
            <img src="assets/images/logo_dnd.png" width="120px" alt="logo">
        </span>
        <span class="logo-sm">
            <img src="assets/images/logo-sm.png" alt="small logo">
        </span>
    </a>

    <!-- Brand Logo Dark -->
    <a href="dashboard.html" class="logo logo-dark">
        <span class="logo-lg">
            <img src="assets/images/logo_dnd.png" alt="dark logo">
        </span>
        <span class="logo-sm">
            <img src="assets/images/logo-sm.png" alt="small logo">
        </span>
    </a>

    <!-- Sidebar Hover Menu Toggle Button -->
    <div class="button-sm-hover" data-bs-toggle="tooltip" data-bs-placement="right" title="Show Full Sidebar">
        <i class="ri-checkbox-blank-circle-line align-middle"></i>
    </div>

    <!-- Full Sidebar Menu Close Button -->
    <div class="button-close-fullsidebar">
        <i class="ri-close-fill align-middle"></i>
    </div>

    <!-- Sidebar -left -->
    <div class="h-100" id="leftside-menu-container" data-simplebar>
        <!-- Leftbar User -->
        <div class="leftbar-user p-3 text-white">
            <a class="d-flex align-items-center text-reset">
                <div class="flex-shrink-0 ms-2">
                    <img src="assets/images/users/avatar-1.jpg" alt="user-image" height="42"
                        class="rounded-circle shadow">
                </div>
                <div class="flex-grow-4 ms-3">
                    <span class="fw-semibold fs-15 d-block"><?php echo $_SESSION['nama']; ?></span>
                    <span class="fs-13"><?php echo $_SESSION['role']; ?></span>
                </div>
            </a>
        </div>



        <!--- Sidemenu -->
        <ul class="side-nav">

            <li class="side-nav-title mt-1"> Dashboard</li>

            <li class="side-nav-item">
                <a href="dashboard.html" class="side-nav-link">
                    <i class="ri-dashboard-2-fill"></i>
                    <span> Dashboard </span>
                </a>
            </li>
            <li class="side-nav-title mt-2">Verifikasi Pengajuan</li>
            <li class="side-nav-item">
                <a href="verifikasi_magang.html" class="side-nav-link">
                    <i class="ri-survey-fill"></i>
                    <span>Pengajuan Magang </span>
                </a>
            </li>
            <li class="side-nav-item">
                <a href="verifikasi_penelitian.html" class="side-nav-link">
                    <i class=" ri-microscope-fill"></i>
                    <span>Pengajuan Penelitian </span>
                </a>
            </li>
            <li class="side-nav-item">
                <a href="verifikasi_studi_edukasi.html" class="side-nav-link">
                    <i class=" ri-graduation-cap-fill"></i>
                    <span>Pengajuan Studi Edukasi</span>
                </a>
            </li>
            <li class="side-nav-item">
                <a href="verifikasi_kunjungan_kerja.html" class="side-nav-link">
                    <i class="ri-briefcase-5-fill"></i>
                    <span>Kunjungan Kerja </span>
                </a>
            </li>
            <li class="side-nav-title mt-1">Kelola Arsip</li>
            <li class="side-nav-item">
                <a href="#" onclick="toggleDropdownArsip()" class="side-nav-link">
                    <i class="ri-mail-fill"></i>
                    <span>Arsip</span>
                    <span class="menu-arrow"></span>
                </a>
                <div class="dropdown-container" id="dropdownMenuArsip" style="display:none;">
                    <ul class="side-nav-second-level">
                        <li>
                            <a href="arsip_magang.html">Magang</a>
                        </li>
                        <li>
                            <a href="arsip_penelitian.html">Penelitian</a>
                        </li>
                        <li>
                            <a href="arsip_studi_edukasi.html">Studi Edukasi</a>
                        </li>
                        <li>
                            <a href="arsip_kunjungan_kerja.html">Kunjungan Kerja</a>
                        </li>
                    </ul>
                </div>
            </li>
            <li class="side-nav-title mt-1"> Master Data</li>
            <li class="side-nav-item">
                <a href="kategori_instansi.html" class="side-nav-link">
                    <i class="ri-government-fill"></i>
                    <span> Kategori Instansi </span>
                </a>
            </li>
            <li class="side-nav-item">
                <a href="pengaturan_kuota.html" class="side-nav-link">
                    <i class="ri-team-fill"></i>
                    <span> Kuota Magang</span>
                </a>
            </li>
            <li class="side-nav-title mt-1">Indeks Kepuasan Masyarakat</li>
            <li class="side-nav-item">
                <a href="ikm_pendidikan.html" class="side-nav-link">
                    <i class="ri-graduation-cap-fill"></i>
                    <span>Pendidikan</span>
                </a>
            </li>
            <li class="side-nav-item">
                <a href="ikm_pekerjaan.html" class="side-nav-link">
                    <i class="ri-briefcase-4-fill"></i>
                    <span>Pekerjaan</span>
                </a>
            </li>
            <li class="side-nav-item">
                <a href="ikm_unsur.html" class="side-nav-link">
                    <i class="ri-list-check-2"></i>
                    <span>Unsur Penilaian</span>
                </a>
            </li>
            <li class="side-nav-item">
                <a href="ikm_soal.html" class="side-nav-link">
                    <i class="ri-questionnaire-fill"></i>
                    <span>Pengaturan Soal</span>
                </a>
            </li>
        </ul>
        <!--- End Sidemenu -->

        <div class="clearfix"></div>
    </div>
</div>
