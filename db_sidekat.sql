/*
 Navicat Premium Data Transfer

 Source Server         : DPRD - Sidekat
 Source Server Type    : MySQL
 Source Server Version : 50740 (5.7.40)
 Source Host           : localhost:3303
 Source Schema         : db_sidekat

 Target Server Type    : MySQL
 Target Server Version : 50740 (5.7.40)
 File Encoding         : 65001

 Date: 20/08/2025 22:26:26
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for admin
-- ----------------------------
DROP TABLE IF EXISTS `admin`;
CREATE TABLE `admin`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `nama` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `role` enum('admin','user') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'admin',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 3 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of admin
-- ----------------------------
INSERT INTO `admin` VALUES (1, 'admin', '7c6a180b36896a0a8c02787eeafb0e4c', 'Admin DPR', 'admin');
INSERT INTO `admin` VALUES (2, 'admin', '6cb75f652a9b52798eb6cf2201057c73', 'Admin DPR', '');

-- ----------------------------
-- Table structure for kategori_instansi
-- ----------------------------
DROP TABLE IF EXISTS `kategori_instansi`;
CREATE TABLE `kategori_instansi`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nama_kategori` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 6 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of kategori_instansi
-- ----------------------------
INSERT INTO `kategori_instansi` VALUES (1, 'DPR RI');
INSERT INTO `kategori_instansi` VALUES (2, 'DPRD PROVINSI');
INSERT INTO `kategori_instansi` VALUES (3, 'DPRD KABUPATEN/KOTA');
INSERT INTO `kategori_instansi` VALUES (4, 'SEKRETARIAT DPRD');
INSERT INTO `kategori_instansi` VALUES (5, 'INSTANSI LAINNYA');

-- ----------------------------
-- Table structure for pengajuan_magang
-- ----------------------------
DROP TABLE IF EXISTS `pengajuan_magang`;
CREATE TABLE `pengajuan_magang`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nama` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `email` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `nomor_hp` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `kampus` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `fakultas` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `prodi` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `nim` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `tanggal_mulai` date NULL DEFAULT NULL,
  `tanggal_selesai` date NULL DEFAULT NULL,
  `jumlah_mahasiswa` int(11) NULL DEFAULT NULL,
  `tanggal_input` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `file_pdf` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `status` enum('pending','disetujui','ditolak') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT 'pending',
  `status_data` enum('pending','arsip') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT 'pending',
  `alasan_penolakan` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL,
  `id_external` varchar(18) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 56 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of pengajuan_magang
-- ----------------------------
INSERT INTO `pengajuan_magang` VALUES (1, 'tes', 'tes@tes.com', '123', 'tes', 'tes', 'tes', '12345', '2024-09-25', '2024-09-26', 10, '2024-09-25 05:17:02', 'SPEKTEKNIS.pdf', 'ditolak', 'arsip', 'test', NULL);
INSERT INTO `pengajuan_magang` VALUES (2, 'tes', 'tes@tes.com', '123', 'tes', 'tes', 'tes', '12345', '2024-09-25', '2024-09-26', 10, '2024-09-25 05:17:49', 'SPEKTEKNIS.pdf', 'disetujui', 'arsip', NULL, NULL);
INSERT INTO `pengajuan_magang` VALUES (3, 'tes', 'tes@tes.com', '123', 'tes', 'tes', 'tes', '12345', '2024-09-25', '2024-09-26', 10, '2024-09-25 05:17:52', 'SPEKTEKNIS.pdf', 'ditolak', 'arsip', 'coba', NULL);
INSERT INTO `pengajuan_magang` VALUES (4, 'tes', 'tes@tes.com', '123', 'tes', 'tes', 'tes', '12345', '2024-09-25', '2024-09-26', 10, '2024-09-25 05:17:57', 'SPEKTEKNIS.pdf', 'ditolak', 'arsip', 'test', NULL);
INSERT INTO `pengajuan_magang` VALUES (5, 'tes', 'tes@tes.com', '123', 'tes', 'tes', 'tes', '12345', '2024-09-25', '2024-09-26', 10, '2024-09-25 05:18:20', 'SPEKTEKNIS.pdf', 'disetujui', 'arsip', NULL, NULL);
INSERT INTO `pengajuan_magang` VALUES (6, 'testing', 'test@test.com', '12345678', 'unej', 'tes', 'tes', '12345', '2024-09-25', '2024-09-26', 23, '2024-09-25 05:19:19', 'SPEKTEKNIS.pdf', 'ditolak', 'arsip', NULL, NULL);
INSERT INTO `pengajuan_magang` VALUES (7, 'WEMPY ANANTA MAHARDIKA', 'tes@tes.com', '123456789012345', 'tes', 'tets', 'tetts', '123456789', '2024-09-25', '2024-09-25', 2, '2024-09-25 09:11:20', 'SPEKTEKNIS.pdf', 'disetujui', 'arsip', NULL, NULL);
INSERT INTO `pengajuan_magang` VALUES (8, 'test', 'fytfyt@jgkjgk', 'yfuyfuafy', 'khjgi', 'igiygi', 'iygiygi', 'igiyg', '2024-09-25', '2024-09-25', 123, '2024-09-25 09:12:32', 'SPEKTEKNIS  METODE PELAKSANAAN  PUSKESMAS ...pdf', 'disetujui', 'arsip', NULL, NULL);
INSERT INTO `pengajuan_magang` VALUES (9, 'jfgfhgfh', 'kjkj@jhkj', 'ghgfhgfh', 'kljhk', 'jkhkjhk', 'hkjhkjh', 'kjhkjhk', '2024-09-25', '2024-09-25', 1, '2024-09-25 09:13:15', 'SPEKTEKNIS.pdf', 'ditolak', 'arsip', NULL, NULL);
INSERT INTO `pengajuan_magang` VALUES (10, 'jkjhkjhk', '1@2', 'khkjhkjh', 'kjlkjl', 'lkjlkjl', 'jlkjlkj', 'ljlkjlkjl', '2024-01-01', '2222-02-01', 2323, '2024-09-25 09:14:01', 'SPEKTEKNIS.pdf', 'disetujui', 'arsip', NULL, NULL);
INSERT INTO `pengajuan_magang` VALUES (11, 'hgjhgjhg', '1@2', 'jhgjhgj', 'njkjhk', 'kjhkjhk', 'kjhkjh', 'kjhkjhkj', '2024-09-25', '2024-09-25', 12, '2024-09-25 09:14:39', 'SPEKTEKNIS.pdf', 'ditolak', 'arsip', 'testing', NULL);
INSERT INTO `pengajuan_magang` VALUES (13, 'NARJI', 'narji@gmail.com', '098123456789', 'UI', 'HUKUM', 'HUKUM Monopoli', '12345678', '2024-10-14', '2024-10-22', 3, '2024-10-14 06:12:45', 'DokumenContoh.pdf', 'ditolak', 'arsip', 'testing', NULL);
INSERT INTO `pengajuan_magang` VALUES (14, 'NARJI', 'narji@gmail.com', '08123456789', 'UI', 'HUKUM', 'HUKUM Monopoli', '12345678', '2024-10-30', '2024-10-31', 7, '2024-10-14 06:22:53', 'DokumenContoh.pdf', 'ditolak', 'arsip', 'testing', NULL);
INSERT INTO `pengajuan_magang` VALUES (15, 'JAKI', 'jaki@gmail.com', '08123456789', 'HARVARD', 'HUKUM', 'HUKUM Monopoli', '12345678', '2024-10-29', '2024-10-29', 10, '2024-10-29 05:14:52', 'DokumenContoh.pdf', 'disetujui', 'arsip', NULL, NULL);
INSERT INTO `pengajuan_magang` VALUES (16, 'Abdu', 'abdu@gmail.com', '08123456789', 'HARVARD', 'HUKUM', 'HUKUM', '12345678', '2024-11-06', '2024-11-28', 5, '2024-11-06 03:11:20', 'DokumenContoh.pdf', 'ditolak', 'arsip', 'testing', NULL);
INSERT INTO `pengajuan_magang` VALUES (17, 'Nadia', 'nadia@gmail.com', '08123456789', 'UB', 'HUKUM', 'HUKUM', '12345678', '2024-11-01', '2024-11-30', 10, '2024-11-29 07:23:07', 'DokumenContoh.pdf', 'disetujui', 'arsip', NULL, NULL);
INSERT INTO `pengajuan_magang` VALUES (18, 'Heker ', 'sempakfiraun404@gmail.com', '088888', 'Univ', 'Kelas', 'Eedeee', '373737373', '2024-12-11', '2024-12-11', 122, '2024-12-11 04:47:51', '1701838000.jpg', 'ditolak', 'arsip', 'Dokumen kurang lengkap', NULL);
INSERT INTO `pengajuan_magang` VALUES (19, 'Kocak', 'sempakfiraun404@gmail.com', '088888', 'Dududur', 'Dd', 'ddddd', '3737373', '2024-12-11', '2024-12-11', 555, '2024-12-11 04:48:55', '1701838000.jpg', 'ditolak', 'arsip', 'Dokumen kurang lengkap', NULL);
INSERT INTO `pengajuan_magang` VALUES (20, 'Muhammad Fahrial Firdaus ', 'fahrial457@gmail.com', '082140913352', 'Universitas Jember', 'Fakultas Ilmu Sosial dan Ilmu Politik ', 'Ilmu Hubungan Internasional ', '220910101051', '2025-02-03', '2025-02-21', 11, '2025-01-10 07:38:35', 'Proposal Magang Mandiri DPRD .pdf', 'ditolak', 'arsip', 'lampau', NULL);
INSERT INTO `pengajuan_magang` VALUES (21, 'gdfgfdg', 'dacie192@freesourcecodes.com', '08354534435', 'dfsfds', 'dffds', 'fdsfds', '54453453', '2025-01-09', '2025-01-23', 44, '2025-01-25 03:04:29', 'contoh.pdf', 'ditolak', 'arsip', 'testing', NULL);
INSERT INTO `pengajuan_magang` VALUES (22, 'gdfgfdg', 'dacie192@freesourcecodes.com', '08354534435', 'dfsfds', 'dffds', 'fdsfds', '54453453', '2025-01-09', '2025-01-23', 44, '2025-01-25 03:07:22', 'contoh.pdf', 'ditolak', 'arsip', 'testing', NULL);
INSERT INTO `pengajuan_magang` VALUES (23, 'janda', 'dacie192@freesourcecodes.com', '0832123232', 'bvcvbc', 'bvcbvc', 'bvcvbc', '534543543543', '2025-01-27', '2025-01-28', 4, '2025-01-28 00:07:41', 'contoh.pdf', 'ditolak', 'arsip', 'testing', NULL);
INSERT INTO `pengajuan_magang` VALUES (24, 'janda', 'dacie192@freesourcecodes.com', '0832123232', 'bvcvbc', 'bvcbvc', 'bvcvbc', '534543543543', '2025-01-27', '2025-01-28', 4, '2025-01-28 00:08:51', 'contoh.pdf', 'ditolak', 'arsip', 'testing', NULL);
INSERT INTO `pengajuan_magang` VALUES (25, 'admin1', 'seogaplek@gmail.com', '90821212', 'admin', 'admin', 'admin', '1121', '2025-03-21', '2025-03-31', 12, '2025-03-21 00:47:07', '1677547698.pdf', 'ditolak', 'arsip', 'testing', NULL);
INSERT INTO `pengajuan_magang` VALUES (26, 'admin123', 'seogaplek@gmail.com', '901212', 'admin', 'admin', 'admin', '1111', '2025-03-21', '2025-03-28', 1213, '2025-03-21 00:48:48', 'sejarah.pdf', 'ditolak', 'arsip', 'testing', NULL);
INSERT INTO `pengajuan_magang` VALUES (27, 'Zahwa Mahesa Haniyah Diloveni', 'zahwamahesa04@gmail.com', '085335177283', 'Universitas Jember', 'Ilmu Sosial dan Ilmu Politik', 'Sosiologi', '230910302024', '2025-07-01', '2025-08-01', 5, '2025-05-28 03:50:16', 'FILE PROPSAL MAGANG & SURAT REKOMENDASI BAKESBANGPOL SOSIOLOGI FISIP UNEJ.pdf', 'disetujui', 'arsip', NULL, NULL);
INSERT INTO `pengajuan_magang` VALUES (28, 'JAKI', 'jaki@gmail.com', '08123456789', 'UI', 'HUKUM', 'HUKUM', '12345678', '2025-05-28', '2025-05-31', 2, '2025-05-28 08:46:07', 'proposal.pdf', 'ditolak', 'arsip', 'testing', NULL);
INSERT INTO `pengajuan_magang` VALUES (29, 'JAKI', 'jaki@gmail.com', '08123456789', 'UI', 'tes', 'tes', '12345678', '2025-05-28', '2025-05-31', 2, '2025-05-28 08:56:05', 'proposal.pdf', 'ditolak', 'arsip', 'testing', NULL);
INSERT INTO `pengajuan_magang` VALUES (30, 'JAKI', 'jaki@gmail.com', '08123456789', 'UI', 'tes', 'tetts', '1234567', '2025-05-28', '2025-05-28', 1, '2025-05-28 09:00:42', 'proposal.pdf', 'ditolak', 'arsip', 'testing', NULL);
INSERT INTO `pengajuan_magang` VALUES (31, 'Racke Wida Purnama ', 'rackewida30@gmail.com', '081393074805', 'Universitas Jember', 'Fakultas Ilmu Sosial dan Ilmu Politik', 'Ilmu Administrasi Negara', '230910201085', '2025-07-01', '2025-07-31', 4, '2025-06-04 04:09:49', 'Surat Permohonan dan Rekomendasi.pdf', 'disetujui', 'pending', NULL, NULL);
INSERT INTO `pengajuan_magang` VALUES (32, 'Erythrina Crista Rachmat Tamira', 'erythrinaa.c@gmail.com', '082331494823', 'Universitas Jember', 'Fakultas Ilmu Sosial dan Ilmu Politik', 'Ilmu Kesejahteraan Sosial', '230910301056', '2025-07-01', '2025-07-31', 4, '2025-06-05 03:12:30', 'PROPOSAL_MAGANG_DPRD_FIKS-1.pdf', 'disetujui', 'arsip', NULL, NULL);
INSERT INTO `pengajuan_magang` VALUES (33, 'Erythrina Crista Rachmat Tamira', 'erythrinaa.c@gmail.com', '082331494823', 'Universitas Jember', 'Fakultas Ilmu Sosial dan Ilmu Politik', 'Ilmu Kesejahteraan Sosial', '230910301056', '2025-07-01', '2025-07-31', 4, '2025-06-05 04:55:01', 'PROPOSAL_MAGANG_DPRD_FIKS-2.pdf', 'disetujui', 'pending', NULL, NULL);
INSERT INTO `pengajuan_magang` VALUES (34, 'testing', 'testing@gmail.com', '0829183912', 'test', 'tes', 'ok', '323232', '2025-06-13', '2025-06-14', 10, '2025-06-11 00:13:58', '1749600838_file_pdf.pdf', 'ditolak', 'arsip', 'dummy', '');
INSERT INTO `pengajuan_magang` VALUES (35, 'Nazzarah Puteri Miapradita', 'nazzarahputeri@gmail.com', '082336957135', 'Universitas Jember', 'Fakultas Ilmu Sosial dan Ilmu Politik', 'Ilmu Hubungan Internasional', '230910101019', '2025-07-01', '2025-07-30', 3, '2025-06-11 04:14:09', 'FILE PERMOHONAN MAGANG DPRD.pdf', 'disetujui', 'pending', NULL, NULL);
INSERT INTO `pengajuan_magang` VALUES (36, 'Dhea Suci Lestari', 'deasuci81@gmail.com', '085859088291', 'Universitas Jember', 'Fakultas Ekonomi dan Bisnis', 'S1 Ekonomi Syariah', '230810102072', '2025-07-01', '2025-08-09', 1, '2025-06-12 07:16:49', 'SURAT REKOMENDASI BAKESBANGPOL, PROPOSAL MAGANG, SURAT PENGANTAR MAGANG.pdf', 'disetujui', 'pending', NULL, NULL);
INSERT INTO `pengajuan_magang` VALUES (37, 'tesss', 'tesss@gmail.com', '08123123123123', 'kampus', 'fakultas', 'prodi', 'heheheh', '2025-06-13', '2025-06-14', 10, '2025-06-13 07:31:27', '1749799887_file_pdf.pdf', 'ditolak', 'arsip', 'dummy', '3511112211990002');
INSERT INTO `pengajuan_magang` VALUES (38, 'tes 2', 'testing@dev.com', '0281391289', 'ujjj', 'tess', '032321', '124321312', '2025-06-13', '2025-06-20', 10, '2025-06-13 07:35:07', 'dummy-pdf_2.pdf', 'ditolak', 'arsip', 'ss', NULL);
INSERT INTO `pengajuan_magang` VALUES (39, 'tesss', 'tessss@gmail.com', '08912893218', 'uuuJ', 'JJJ', 'JJJ', '3234', '2025-06-14', '2025-06-26', 11, '2025-06-14 10:39:50', 'dummy-pdf_2.pdf', 'ditolak', 'arsip', 'test\r\n', NULL);
INSERT INTO `pengajuan_magang` VALUES (40, 'M. SHENDI PRATAMA JAUHAR ', 'shendipratama19@gmail.com', '085745309143', 'Universitas Jember', 'Fakultas Ilmu Sosial dan Ilmu Politik', 'Hubungan Internasional', '240910101040', '2025-07-01', '2025-07-30', 3, '2025-06-18 03:14:18', 'Proposal Magang dan Surat Rekomendasi .pdf', 'disetujui', 'arsip', NULL, NULL);
INSERT INTO `pengajuan_magang` VALUES (41, 'Yoka Maulana ', 'yokamaulana8@gmail.com', '082338086748', 'Universitas Jember ', 'Ekonomi dan Bisnis ', 'Administrasi Keuangan ', '240803102006', '2025-07-01', '2025-08-01', 1, '2025-06-18 16:33:38', 'PROPOSAL DPRD SCAN.pdf', 'disetujui', 'pending', NULL, NULL);
INSERT INTO `pengajuan_magang` VALUES (42, 'Diah Ayu Pratiwi', 'pratiwiayu167@gmail.com', '082257086015', 'Universitas Jember ', 'Ilmu Sosial dan Ilmu Politik', 'Ilmu Administrasi Negara', '24091021048', '2025-07-01', '2025-07-31', 6, '2025-06-19 03:22:00', 'Proposal Magang & Surat Rekomendasi Kesbangpol.pdf', 'disetujui', 'pending', NULL, NULL);
INSERT INTO `pengajuan_magang` VALUES (43, 'Isnaini Fauzi Saputri', 'isnainifauzis@gmail.com', '082229079612', 'Universitas Jember', 'Fakultas Keguruan dan Ilmu Pendidikan', 'Pendidikan Geografi', '230210303047', '2025-07-01', '2025-07-31', 3, '2025-06-23 02:15:25', 'PROPOSAL UNIVERSITAS JEMBER DAN SURAT REKOMENDASI.pdf', 'disetujui', 'arsip', NULL, NULL);
INSERT INTO `pengajuan_magang` VALUES (44, 'Isnaini Fauzi Saputri', 'isnainifauzis@gmail.com', '082229079612', 'Universitas Jember', 'Fakultas Keguruan dan Ilmu Pendidikan', 'Pendidikan Geografi', '230210303047', '2025-07-01', '2025-07-31', 3, '2025-06-25 09:21:53', 'PENGAJUAN MAGANG MANDIRI UNIVERSITAS JEMBER 2025.pdf', 'disetujui', 'pending', NULL, NULL);
INSERT INTO `pengajuan_magang` VALUES (45, 'Racke Wida Purnama', 'rackewida30@gmail.com', '081393074805', 'Universitas Jember', 'Fakultas Ilmu Sosial dan Ilmu Politik', 'Ilmu Administrasi Negara', '230910201085', '2025-07-01', '2025-07-31', 4, '2025-06-27 11:19:54', 'Surat Permohonan dan Rekomendasi.pdf', 'disetujui', 'pending', NULL, NULL);
INSERT INTO `pengajuan_magang` VALUES (46, 'akhmad zainudin', 'zaidzid@gmail.com', '089675478877', 'Politeknik Negeri Jember', 'Teknik Mesin', 'Mesin otomotif', '241431245312', '2025-08-04', '2025-09-30', 1, '2025-07-05 11:47:10', 'snapedit_1748329893959(3).jpg', 'ditolak', 'arsip', 'Dokumen tidak memenuhi persyaratan', NULL);
INSERT INTO `pengajuan_magang` VALUES (47, 'dsfsdf', 'admin@gmail.com', '123131321321321', 'dfsdfsdfsd', 'sdfds', 'dsfsdf', '12345678', '2025-07-11', '2025-07-26', 4, '2025-07-11 03:54:34', 'Testing.pdf', 'ditolak', 'arsip', 'data tidak valid', NULL);
INSERT INTO `pengajuan_magang` VALUES (48, 'PUTRI OKTAVIANA RAMADHANI ', 'putrioktaviana533@gmail.com', '082228194559', 'UNIVERSITAS MUHAMMADIYAH JEMBER ', 'ILMU SOSIAL DAN ILMU POLITIK ', 'ILMU PEMERINTAHAN ', '2310511011', '2025-08-04', '2025-09-04', 1, '2025-07-21 08:01:34', 'SURAT PERMOHONAN DAN SURAT REKOMENDASI KESBANGPOL  (OKTA).pdf', 'disetujui', 'arsip', NULL, NULL);
INSERT INTO `pengajuan_magang` VALUES (49, 'PUTRI OKTAVIANA RAMADHANI ', 'putrioktaviana533@gmail.com', '082228194559', 'UNIVERSITAS MUHAMMADIYAH JEMBER ', 'ILMU SOSIAL DAN ILMU POLITIK ', 'ILMU PEMERINTAHAN ', '2310511011', '2025-08-04', '2025-09-04', 1, '2025-07-21 08:02:14', 'SURAT PERMOHONAN DAN SURAT REKOMENDASI KESBANGPOL  (OKTA).pdf', 'disetujui', 'pending', NULL, NULL);
INSERT INTO `pengajuan_magang` VALUES (50, 'AYIN TRIPUAN MAHARANI', 'ayin.tripuan.maharani-2022@fib.unair.ac.id', '089666550607', 'UNIVERSITAS AIRLANGGA', 'FAKULTAS ILMU BUDAYA', 'BAHASA DAN SASTRA INDONESIA', '122221097', '2025-08-11', '2025-12-11', 1, '2025-07-22 04:08:00', 'LAMPIRAN MAGANG DPRD.pdf', 'disetujui', 'pending', NULL, NULL);
INSERT INTO `pengajuan_magang` VALUES (51, 'Muhammad Imron', 'muhimron267@gmail.com', '08816991721', 'Universitas Islam Jember', 'Hukum ', 'Ilmu hukum', '2403403031026', '2025-08-04', '2025-08-31', 6, '2025-07-25 00:26:06', 'inbound6758635869640003088.pdf', 'disetujui', 'arsip', NULL, NULL);
INSERT INTO `pengajuan_magang` VALUES (52, 'Muhammad Imron', 'muhimron267@gmail.com', '08816991721', 'Universitas Islam Jember', 'Hukum', 'Ilmu hukum', '2403403031026', '2025-08-04', '2025-08-31', 6, '2025-07-25 00:28:23', 'inbound9042558663294951943.pdf', 'disetujui', 'arsip', NULL, NULL);
INSERT INTO `pengajuan_magang` VALUES (53, 'Hanim Nurma Hestin', 'hanimnrma@gmail.com', '081249219012', 'Universitas Islam Negeri Sunan Ampel Surabaya', 'Fakultas Ekonomi dan Bisnis Islam', 'Manajemen', '08030323143', '2025-08-01', '2025-08-15', 1, '2025-07-28 03:36:23', 'SURAT PENGAJUAN MAGANG MANDIRI DPRD JEMBER.pdf', 'disetujui', 'pending', NULL, NULL);
INSERT INTO `pengajuan_magang` VALUES (54, 'Widyawati Adiratna', 'wdyadrtn@gmail.com', '081994006405', 'UIN KHAS JEMBER', 'Dakwah', 'Psikologi Islam', '221103050023', '2025-08-04', '2025-10-06', 3, '2025-07-29 06:17:49', 'inbound9050576374885035370.pdf', 'disetujui', 'arsip', NULL, NULL);
INSERT INTO `pengajuan_magang` VALUES (55, 'Muhammad Imron', 'muhimron267@gmail.com', '082337915564', 'Universitas Islam Jember', 'Hukum', 'Ilmu Hukum', '2403403031026', '2025-08-04', '2025-08-31', 6, '2025-07-30 01:00:20', 'proposal magang dprd jember dan surat bangkesbangpol.pdf', 'disetujui', 'pending', NULL, NULL);

-- ----------------------------
-- Table structure for pengajuan_penelitian
-- ----------------------------
DROP TABLE IF EXISTS `pengajuan_penelitian`;
CREATE TABLE `pengajuan_penelitian`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nama` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `email` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `nomor_hp` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `kampus` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `fakultas` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `prodi` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `nim` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `tanggal_input` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `file_jpg` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `file_pdf` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `status` enum('pending','disetujui','ditolak') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT 'pending',
  `status_data` enum('pending','arsip') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT 'pending',
  `alasan_penolakan` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL,
  `id_external` varchar(18) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 6 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of pengajuan_penelitian
-- ----------------------------
INSERT INTO `pengajuan_penelitian` VALUES (1, 'test', 'test@test.com', '1234512345678', 'unmuh', 'tes', 'tes', '1234561234567890', '2024-09-25 05:20:57', 'WhatsApp Image 2024-09-24 at 11.04.43 AM (1).jpeg', 'SPEKTEKNIS.pdf', 'disetujui', 'arsip', 'test', NULL);
INSERT INTO `pengajuan_penelitian` VALUES (2, 'WEMPY ANANTA MAHARDIKA', 'administrator@gmail.com', '08123456789', 'HARVARD', 'HUKUM', 'HUKUM', '12345678', '2024-10-01 06:52:29', '22.jpeg', 'DokumenContoh.pdf', 'ditolak', 'pending', 'test', NULL);
INSERT INTO `pengajuan_penelitian` VALUES (3, 'JAKI', 'administrator@gmail.com', '08123456789', 'HARVARD', 'HUKUM', 'HUKUM', '12345678', '2024-10-29 06:29:45', '2.jpg', 'DokumenContoh.pdf', 'ditolak', 'pending', 'testing', NULL);
INSERT INTO `pengajuan_penelitian` VALUES (4, 'JAKI', 'jaki@gmail.com', '08123456789', 'HARVARD', 'HUKUM', 'HUKUM Monopoli', '12345678', '2024-10-29 06:30:15', '2.jpg', 'DokumenContoh.pdf', 'ditolak', 'pending', 'testing', NULL);
INSERT INTO `pengajuan_penelitian` VALUES (5, 'Joko', 'joko@gmail.com', '08123456789', 'HARVARD', 'HUKUM', 'HUKUM', '12345678', '2024-10-29 06:38:14', '2.jpg', 'DokumenContoh.pdf', 'ditolak', 'pending', 'testing', NULL);

-- ----------------------------
-- Table structure for pengajuan_studi_edukasi
-- ----------------------------
DROP TABLE IF EXISTS `pengajuan_studi_edukasi`;
CREATE TABLE `pengajuan_studi_edukasi`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nama` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `email` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `nomor_hp` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `kampus` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `fakultas` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `prodi` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `nim` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `permohonan_kedatangan` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL,
  `tanggal_input` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `file_jpg` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `file_pdf` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `status` enum('pending','disetujui','ditolak') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT 'pending',
  `status_data` enum('pending','arsip') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT 'pending',
  `alasan_penolakan` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL,
  `id_external` varchar(18) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 5 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of pengajuan_studi_edukasi
-- ----------------------------
INSERT INTO `pengajuan_studi_edukasi` VALUES (1, 'test', 'test@test.com', '123456789012345', 'tes', 'htes', 'tes', '1234567', 'afjhgafjhaj', '2024-09-25 05:21:59', 'WhatsApp Image 2024-09-24 at 9.31.04 AM.jpeg', 'SPEKTEKNIS.pdf', 'ditolak', 'arsip', 'cobabab', NULL);
INSERT INTO `pengajuan_studi_edukasi` VALUES (2, 'WEMPY ANANTA MAHARDIKA', 'administrator@gmail.com', '08123456789', 'HARVARD', 'HUKUM', 'HUKUM', '12345678', 'kedatangan studi edukasi', '2024-10-01 07:51:08', '1.jpeg', 'DokumenContoh.pdf', 'disetujui', 'pending', NULL, NULL);
INSERT INTO `pengajuan_studi_edukasi` VALUES (3, 'JAKI', 'jaki@gmail.com', '08123456789', 'HARVARD', 'HUKUM', 'HUKUM', '12345678', 'testing', '2024-10-29 06:49:44', '2.jpg', 'DokumenContoh.pdf', 'ditolak', 'pending', 'testing', NULL);
INSERT INTO `pengajuan_studi_edukasi` VALUES (4, 'Joko', 'jaki@gmail.com', '08123456789', 'HARVARD', 'HUKUM', 'HUKUM', '12345678', 'Testing', '2024-10-29 07:05:44', '2.jpg', 'DokumenContoh.pdf', 'ditolak', 'pending', 'testing', NULL);

-- ----------------------------
-- Table structure for pengaturan
-- ----------------------------
DROP TABLE IF EXISTS `pengaturan`;
CREATE TABLE `pengaturan`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `key_name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `value` int(11) NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of pengaturan
-- ----------------------------
INSERT INTO `pengaturan` VALUES (1, 'kuota_magang', 50);

-- ----------------------------
-- Table structure for permohonan_kunjungan_kerja
-- ----------------------------
DROP TABLE IF EXISTS `permohonan_kunjungan_kerja`;
CREATE TABLE `permohonan_kunjungan_kerja`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `kategori_id` int(11) NOT NULL,
  `nama_instansi` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `alamat` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `tanggal_kunjungan` date NOT NULL,
  `jam_kunjungan` time NOT NULL,
  `materi_kunjungan` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `pimpinan_rombongan` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `nomor_hp` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `file_pdf` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `tanggal_input` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `status` enum('pending','disetujui','ditolak') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT 'pending',
  `status_data` enum('pending','arsip') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT 'pending',
  `alasan_penolakan` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL,
  `id_external` varchar(18) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `kategori_id`(`kategori_id`) USING BTREE,
  CONSTRAINT `permohonan_kunjungan_kerja_ibfk_1` FOREIGN KEY (`kategori_id`) REFERENCES `kategori_instansi` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 9 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of permohonan_kunjungan_kerja
-- ----------------------------
INSERT INTO `permohonan_kunjungan_kerja` VALUES (1, 'administrator@gmail.com', 1, 'tes', 'ttes', '2024-09-25', '20:01:00', 'tes', 'test', '123456789012345', 'SPEKTEKNIS.pdf', '2024-09-25 05:48:41', 'disetujui', 'arsip', NULL, NULL);
INSERT INTO `permohonan_kunjungan_kerja` VALUES (2, 'admin@admin.com', 1, 'tes', 'tetstst', '2024-09-26', '12:12:00', 'rerer', 'yuyfu', '123456789012345', 'CamScanner 03-17-2023 11.22.pdf', '2024-09-25 07:36:47', 'disetujui', 'arsip', NULL, NULL);
INSERT INTO `permohonan_kunjungan_kerja` VALUES (3, 'administrator@gmail.com', 2, 'tes', 'test', '2024-10-01', '16:13:00', 'test', 'yanto', '08123456789', 'DokumenContoh.pdf', '2024-10-01 09:13:46', 'ditolak', 'arsip', 'test', NULL);
INSERT INTO `permohonan_kunjungan_kerja` VALUES (4, 'jaki@gmail.com', 1, 'Tes Instansi', 'Jl. Mentok Blok O', '2024-10-30', '12:00:00', 'Testing', 'JAKI', '08123456789', 'DokumenContoh.pdf', '2024-10-29 07:20:36', 'ditolak', 'arsip', 'testing', NULL);
INSERT INTO `permohonan_kunjungan_kerja` VALUES (5, 'jaki@gmail.com', 1, 'Bima Tech', 'Alamat Tes', '2024-10-29', '14:57:00', 'Testing', 'Jaki', '08123456789', 'DokumenContoh.pdf', '2024-10-29 07:57:47', 'ditolak', 'arsip', 'testing', NULL);
INSERT INTO `permohonan_kunjungan_kerja` VALUES (6, 'wempyananta@gmail.com', 1, 'DPR Pusat', 'Jl. Kalimantan No. 86 Jember (68121)', '2024-11-05', '09:30:00', 'Kunjungan Kerja', 'Puan', '08123456789', 'DokumenContoh.pdf', '2024-11-05 02:32:08', 'ditolak', 'arsip', 'testing', NULL);
INSERT INTO `permohonan_kunjungan_kerja` VALUES (7, 'rianhidayatullah12@gmail.com', 3, 'DPRD Kota Pekanbaru', 'Jalan Jendral sudirman no 424 Pekanbaru, Riau', '2025-06-17', '10:00:00', 'Kunker terkait pengelolaan bumd / bpr', 'Rianhidayatullah12@gmail.com', '081374872387', 'DPRD Jember.pdf', '2025-06-12 05:21:06', 'ditolak', 'arsip', 'doble', NULL);
INSERT INTO `permohonan_kunjungan_kerja` VALUES (8, 'rianhidayatullah12@gmail.com', 3, 'DPRD Kota Pekanbaru', 'Jalan Jendral sudirman no 424 Pekanbaru, Riau', '2025-06-17', '10:00:00', 'Kunker terkait pengelolaan bumd / bpr', 'Rianhidayatullah12@gmail.com', '081374872387', 'DPRD Jember.pdf', '2025-06-12 07:21:39', 'disetujui', 'pending', NULL, NULL);

SET FOREIGN_KEY_CHECKS = 1;
