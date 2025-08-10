-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Aug 10, 2025 at 08:15 AM
-- Server version: 8.0.30
-- PHP Version: 8.3.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ruangrobot`
--

-- --------------------------------------------------------

--
-- Table structure for table `akun`
--

CREATE TABLE `akun` (
  `id` int NOT NULL,
  `username` varchar(30) NOT NULL,
  `password` varchar(100) NOT NULL,
  `role` enum('Admin','Pengajar','Siswa') NOT NULL,
  `remember_token` varchar(100) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `akun`
--

INSERT INTO `akun` (`id`, `username`, `password`, `role`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'julian', '$2y$12$RMOcL.vRNaJXjZ2CzzDVt.KweB7SHyHocLFB6KjsxmlhHBY.cpkqS', 'Admin', NULL, '2025-08-10 01:06:59', '2025-08-10 01:06:59');

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `uuid` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `gajis`
--

CREATE TABLE `gajis` (
  `id` int NOT NULL,
  `pengajar` int NOT NULL,
  `nominal` int NOT NULL,
  `status` enum('dibayar','pending','ditolak','diverifikasi') CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `status_pengajar` enum('Pengajar Utama','Pengajar Bantu') CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `pembelajaran_id` int NOT NULL,
  `history_gaji_id` int DEFAULT NULL,
  `created_at` timestamp NOT NULL,
  `updated_at` timestamp NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `gaji_custom`
--

CREATE TABLE `gaji_custom` (
  `id` int NOT NULL,
  `pengajar` int NOT NULL,
  `tanggal` date NOT NULL,
  `keterangan` varchar(100) NOT NULL,
  `nominal` int NOT NULL,
  `status` enum('dibayar','pending','ditolak','diverifikasi') CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `history_gaji_id` int DEFAULT NULL,
  `created_at` timestamp NOT NULL,
  `updated_at` timestamp NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `history_gaji`
--

CREATE TABLE `history_gaji` (
  `id` int NOT NULL,
  `tanggal_terbayar` date NOT NULL,
  `created_at` timestamp NOT NULL,
  `updated_at` timestamp NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `indexkeuangans`
--

CREATE TABLE `indexkeuangans` (
  `id` bigint UNSIGNED NOT NULL,
  `kesimpulan` enum('Pemasukan','Pengeluaran') COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('aktif','selesai') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'aktif',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `index_pendaftarans`
--

CREATE TABLE `index_pendaftarans` (
  `id` bigint UNSIGNED NOT NULL,
  `title` varchar(250) COLLATE utf8mb4_unicode_ci NOT NULL,
  `kategori_id` bigint UNSIGNED NOT NULL,
  `code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `link_form` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `link_group` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tanggal_p_awal` date DEFAULT NULL,
  `tanggal_p_akhir` date DEFAULT NULL,
  `status_pendaftaran` enum('open','closed') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'open',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `invoice`
--

CREATE TABLE `invoice` (
  `id` int NOT NULL,
  `profile_id` int NOT NULL,
  `kelas_id` int NOT NULL,
  `created_at` timestamp NOT NULL,
  `updated_at` timestamp NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `queue` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint UNSIGNED NOT NULL,
  `reserved_at` int UNSIGNED DEFAULT NULL,
  `available_at` int UNSIGNED NOT NULL,
  `created_at` int UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `kategori_kelas`
--

CREATE TABLE `kategori_kelas` (
  `id` int NOT NULL,
  `kategori_kelas` varchar(45) NOT NULL,
  `color_bg` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `kategori_pekerjaans`
--

CREATE TABLE `kategori_pekerjaans` (
  `id` bigint UNSIGNED NOT NULL,
  `nama_pekerjaan` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `keterangan` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `gaji` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `kelas`
--

CREATE TABLE `kelas` (
  `id` int NOT NULL,
  `nama_kelas` varchar(100) NOT NULL,
  `kode_kelas` varchar(50) NOT NULL,
  `harga` int NOT NULL,
  `durasi_belajar` varchar(20) NOT NULL,
  `program_belajar_id` int NOT NULL,
  `kategori_kelas_id` int NOT NULL,
  `penanggung_jawab` int NOT NULL,
  `gaji_pengajar` int NOT NULL,
  `gaji_transport` int NOT NULL,
  `status_kelas` enum('aktif','selesai') NOT NULL,
  `jatuh_tempo` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `keuangan`
--

CREATE TABLE `keuangan` (
  `id` int NOT NULL,
  `indexkeuangan_id` int UNSIGNED DEFAULT NULL,
  `tipe` enum('Pemasukan','Pengeluaran') NOT NULL,
  `keterangan` varchar(255) NOT NULL,
  `tanggal` date NOT NULL,
  `nominal` int NOT NULL,
  `saldo_akhir` int NOT NULL,
  `metode_pembayaran` enum('Transfer','Cash') NOT NULL,
  `status` enum('aktif','selesai') NOT NULL DEFAULT 'aktif'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `message`
--

CREATE TABLE `message` (
  `id` int NOT NULL,
  `title` varchar(45) NOT NULL,
  `pesan` varchar(100) NOT NULL,
  `created_at` timestamp NOT NULL,
  `updated_at` timestamp NOT NULL,
  `profile_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(4, '0001_01_01_000000_create_users_table', 1),
(5, '0001_01_01_000001_create_cache_table', 1),
(6, '0001_01_01_000002_create_jobs_table', 1),
(7, '2025_06_29_152919_add_verified_column_to_profile_table', 2),
(8, '2025_06_30_125435_add_link_end_colorbg_column_to_kategori_kelas_table', 2),
(9, '2025_06_30_143019_create_pendaftaran_table', 2),
(10, '2025_06_30_152426_delete_status_verifikasi_column_from_profile_table', 2),
(11, '2025_07_01_012831_create_index_pendaftarans_table', 2),
(12, '2025_07_01_084731_add_code_column_to_index_pendaftarans_table', 2),
(13, '2025_07_02_010145_add_code_id_column_to_pendaftaran_table', 2),
(14, '2025_07_03_071629_change_sekolah_id_column_on_pendaftaran', 2),
(15, '2025_07_05_072934_change_code_id_type_on_pendaftaran_table', 2),
(16, '2025_07_06_033133_remove_link_from_kategori_kelas_table', 2),
(17, '2025_07_06_235401_add_kode_kelas_to_kelas_table', 2),
(18, '2025_07_07_015158_change_penanggung_jawab_column_type_on_kelas_table', 2),
(19, '2025_07_08_234316_add_kelas_to_profiles_table', 2),
(20, '2025_07_11_024447_change_pertemuan_to_kode_pertemuan_in_pertemuan_table', 2),
(21, '2025_07_11_030758_change_pengajar_to_unsigned_int_in_pembelajaran_table', 2),
(22, '2025_07_14_075029_remove_kelas_id_from_index_pendaftarans_table', 3),
(23, '2025_07_14_083251_add_tgl_lahir_column_to_profile_table', 4),
(24, '2025_07_14_083543_add_tgl_lahir_column_to_pendaftaran_table', 5),
(25, '2025_07_15_024524_create_kategori_pekerjaans_table', 5),
(27, '2025_07_15_234816_create_riwayat_pembayarans_table', 6),
(32, '2025_07_17_011852_create_indexkeuangans_table', 7),
(33, '2025_07_17_012837_add_fields_to_keuangan_table', 7),
(34, '2025_07_17_013916_drop_fields_from_keuangan_table', 8),
(35, '2025_07_17_014210_add_keteragan_column_to_keuangan_table', 9),
(36, '2025_07_17_062723_add_status_column_to_indexkeuangans_table', 10),
(37, '2025_08_10_051019_create_reset_table', 11);

-- --------------------------------------------------------

--
-- Table structure for table `murid_kelas`
--

CREATE TABLE `murid_kelas` (
  `id` int NOT NULL,
  `murid` json NOT NULL,
  `kelas_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pembelajaran`
--

CREATE TABLE `pembelajaran` (
  `id` int NOT NULL,
  `kode_pertemuan` varchar(255) NOT NULL,
  `pengajar` bigint UNSIGNED DEFAULT NULL,
  `tanggal` date DEFAULT NULL,
  `materi` text CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci,
  `catatan_pengajar` text CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci,
  `absensi` json DEFAULT NULL,
  `status_tersimpan` enum('sementara','permanen') DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `kelas_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `pendaftaran`
--

CREATE TABLE `pendaftaran` (
  `id` bigint UNSIGNED NOT NULL,
  `code_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tgl_lahir` date DEFAULT NULL,
  `email` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `no_telp` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sekolah_id` int UNSIGNED NOT NULL,
  `kelas` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `alamat` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `kategori` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `profile`
--

CREATE TABLE `profile` (
  `id` int NOT NULL,
  `nama` varchar(50) NOT NULL,
  `tgl_lahir` date DEFAULT NULL,
  `email` varchar(45) NOT NULL,
  `alamat` varchar(100) NOT NULL,
  `no_telp` varchar(15) NOT NULL,
  `mekanik` int DEFAULT NULL,
  `elektronik` int DEFAULT NULL,
  `pemrograman` int DEFAULT NULL,
  `sekolah_id` int DEFAULT NULL,
  `kelas` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `profile`
--

INSERT INTO `profile` (`id`, `nama`, `tgl_lahir`, `email`, `alamat`, `no_telp`, `mekanik`, `elektronik`, `pemrograman`, `sekolah_id`, `kelas`) VALUES
(1, 'Julian', NULL, 'ruangrobotkdr@gmail.com', 'Perum Mojoroto Indah', '+6285655770506', 0, 0, 0, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `program_belajar`
--

CREATE TABLE `program_belajar` (
  `id` int NOT NULL,
  `nama_program` varchar(100) NOT NULL,
  `deskripsi` varchar(500) NOT NULL,
  `level` enum('mudah','sedang','sulit') NOT NULL,
  `tipe_kelas_id` int NOT NULL,
  `mekanik` int NOT NULL,
  `elektronik` int NOT NULL,
  `pemrograman` int NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `reset`
--

CREATE TABLE `reset` (
  `kode` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `riwayat_pembayarans`
--

CREATE TABLE `riwayat_pembayarans` (
  `id` bigint UNSIGNED NOT NULL,
  `nama` int UNSIGNED NOT NULL,
  `kelas_id` int UNSIGNED NOT NULL,
  `nominal` int NOT NULL,
  `tanggal` date NOT NULL,
  `jenis_pembayaran` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `metode_pembayaran` enum('Cash','Transfer') COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sekolah`
--

CREATE TABLE `sekolah` (
  `id` int NOT NULL,
  `nama_sekolah` varchar(45) NOT NULL,
  `guru` varchar(45) NOT NULL,
  `no_hp` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `sertiv`
--

CREATE TABLE `sertiv` (
  `id` int NOT NULL,
  `nomor_sertiv` varchar(45) NOT NULL,
  `nama_siswa` varchar(45) NOT NULL,
  `keterangan` varchar(100) NOT NULL,
  `tanggal_pelaksanaan` varchar(45) NOT NULL,
  `nilai` enum('A','B','Gagal') NOT NULL,
  `status` enum('Terbit','Tidak Terbit') NOT NULL,
  `created_at` timestamp NOT NULL,
  `updated_at` timestamp NOT NULL,
  `profile_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('FjIpzLKDP0JQVfU99OqWzoiHhnzZER16FrPsz19E', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:141.0) Gecko/20100101 Firefox/141.0', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiTnBTbE9oRU1IemxkaGhsSGZFbFRlMEVGZFFJazRpSVV1VGc2aUpjMCI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzI6Imh0dHA6Ly9ydWFuZ3JvYm90LnRlc3QvZGFzaGJvYXJkIjt9czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MTt9', 1754813699),
('O9USYjStXkxXOzJa9LnQ5b1fJ5UiKzXkEmmspxHU', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:141.0) Gecko/20100101 Firefox/141.0', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiQ1doa0JRbE13ZXNjbmRpU1doTmd5QXN6cWI1ZFZITkxEdGdJbXpQcyI7czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czoyODoiaHR0cDovL3J1YW5ncm9ib3QudGVzdC9yZXNldCI7fXM6OToiX3ByZXZpb3VzIjthOjE6e3M6MzoidXJsIjtzOjI4OiJodHRwOi8vcnVhbmdyb2JvdC50ZXN0L3Jlc2V0Ijt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1754811716);

-- --------------------------------------------------------

--
-- Table structure for table `tipe_kelas`
--

CREATE TABLE `tipe_kelas` (
  `id` int NOT NULL,
  `tipe_kelas` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `transport`
--

CREATE TABLE `transport` (
  `id` int NOT NULL,
  `pengajar` int NOT NULL,
  `nominal` int NOT NULL,
  `status` enum('dibayar','pending','ditolak','diverifikasi') CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `status_pengajar` enum('Pengajar Utama','Pengajar Bantu') CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `pembelajaran_id` int NOT NULL,
  `history_gaji_id` int DEFAULT NULL,
  `created_at` timestamp NOT NULL,
  `updated_at` timestamp NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `akun`
--
ALTER TABLE `akun`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id_UNIQUE` (`id`),
  ADD UNIQUE KEY `username_UNIQUE` (`username`);

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `gajis`
--
ALTER TABLE `gajis`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id_UNIQUE` (`id`),
  ADD KEY `fk_gajis_pembelajaran1_idx` (`pembelajaran_id`),
  ADD KEY `fk_gajis_history_gaji1_idx` (`history_gaji_id`);

--
-- Indexes for table `gaji_custom`
--
ALTER TABLE `gaji_custom`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id_UNIQUE` (`id`),
  ADD KEY `fk_gaji_custom_history_gaji1_idx` (`history_gaji_id`);

--
-- Indexes for table `history_gaji`
--
ALTER TABLE `history_gaji`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `taggal_terbayar_UNIQUE` (`tanggal_terbayar`);

--
-- Indexes for table `indexkeuangans`
--
ALTER TABLE `indexkeuangans`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `index_pendaftarans`
--
ALTER TABLE `index_pendaftarans`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `invoice`
--
ALTER TABLE `invoice`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id_UNIQUE` (`id`),
  ADD KEY `fk_invoice_profile1_idx` (`profile_id`),
  ADD KEY `fk_invoice_kelas1_idx` (`kelas_id`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kategori_kelas`
--
ALTER TABLE `kategori_kelas`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id_UNIQUE` (`id`),
  ADD UNIQUE KEY `kategori_kelas_UNIQUE` (`kategori_kelas`);

--
-- Indexes for table `kategori_pekerjaans`
--
ALTER TABLE `kategori_pekerjaans`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kelas`
--
ALTER TABLE `kelas`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id_UNIQUE` (`id`),
  ADD UNIQUE KEY `nama_kegiatan_UNIQUE` (`nama_kelas`),
  ADD UNIQUE KEY `kelas_kode_kelas_unique` (`kode_kelas`),
  ADD KEY `fk_kelas_program_belajar1_idx` (`program_belajar_id`),
  ADD KEY `fk_kelas_kategori_kelas1_idx` (`kategori_kelas_id`);

--
-- Indexes for table `keuangan`
--
ALTER TABLE `keuangan`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id_UNIQUE` (`id`);

--
-- Indexes for table `message`
--
ALTER TABLE `message`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id_UNIQUE` (`id`),
  ADD KEY `fk_message_profile1_idx` (`profile_id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `murid_kelas`
--
ALTER TABLE `murid_kelas`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id_UNIQUE` (`id`),
  ADD KEY `fk_murid_kelas_kelas1_idx` (`kelas_id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `pembelajaran`
--
ALTER TABLE `pembelajaran`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id_UNIQUE` (`id`),
  ADD KEY `fk_pembelajaran_kelas1_idx` (`kelas_id`);

--
-- Indexes for table `pendaftaran`
--
ALTER TABLE `pendaftaran`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `profile`
--
ALTER TABLE `profile`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_id_UNIQUE` (`id`),
  ADD KEY `fk_profiles_users1_idx` (`id`),
  ADD KEY `fk_profile_sekolah1_idx` (`sekolah_id`);

--
-- Indexes for table `program_belajar`
--
ALTER TABLE `program_belajar`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id_UNIQUE` (`id`),
  ADD UNIQUE KEY `nama_program_UNIQUE` (`nama_program`),
  ADD KEY `fk_program_belajar_tipe_kelas1_idx` (`tipe_kelas_id`);

--
-- Indexes for table `riwayat_pembayarans`
--
ALTER TABLE `riwayat_pembayarans`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sekolah`
--
ALTER TABLE `sekolah`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id_UNIQUE` (`id`),
  ADD UNIQUE KEY `nama_sekolah_UNIQUE` (`nama_sekolah`);

--
-- Indexes for table `sertiv`
--
ALTER TABLE `sertiv`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id_UNIQUE` (`id`),
  ADD UNIQUE KEY `nomor_sertiv_UNIQUE` (`nomor_sertiv`),
  ADD KEY `fk_sertiv_profile1_idx` (`profile_id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `tipe_kelas`
--
ALTER TABLE `tipe_kelas`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nama_kategori_UNIQUE` (`tipe_kelas`),
  ADD UNIQUE KEY `id_UNIQUE` (`id`);

--
-- Indexes for table `transport`
--
ALTER TABLE `transport`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id_UNIQUE` (`id`),
  ADD KEY `fk_transport_pembelajaran1_idx` (`pembelajaran_id`),
  ADD KEY `fk_transport_history_gaji1_idx` (`history_gaji_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `akun`
--
ALTER TABLE `akun`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `gajis`
--
ALTER TABLE `gajis`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `gaji_custom`
--
ALTER TABLE `gaji_custom`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `history_gaji`
--
ALTER TABLE `history_gaji`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `indexkeuangans`
--
ALTER TABLE `indexkeuangans`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `index_pendaftarans`
--
ALTER TABLE `index_pendaftarans`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `invoice`
--
ALTER TABLE `invoice`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `kategori_kelas`
--
ALTER TABLE `kategori_kelas`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `kategori_pekerjaans`
--
ALTER TABLE `kategori_pekerjaans`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `kelas`
--
ALTER TABLE `kelas`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `keuangan`
--
ALTER TABLE `keuangan`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `message`
--
ALTER TABLE `message`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT for table `murid_kelas`
--
ALTER TABLE `murid_kelas`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pembelajaran`
--
ALTER TABLE `pembelajaran`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pendaftaran`
--
ALTER TABLE `pendaftaran`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `profile`
--
ALTER TABLE `profile`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `program_belajar`
--
ALTER TABLE `program_belajar`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `riwayat_pembayarans`
--
ALTER TABLE `riwayat_pembayarans`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sekolah`
--
ALTER TABLE `sekolah`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sertiv`
--
ALTER TABLE `sertiv`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tipe_kelas`
--
ALTER TABLE `tipe_kelas`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `transport`
--
ALTER TABLE `transport`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `gajis`
--
ALTER TABLE `gajis`
  ADD CONSTRAINT `fk_gajis_history_gaji1` FOREIGN KEY (`history_gaji_id`) REFERENCES `history_gaji` (`id`),
  ADD CONSTRAINT `fk_gajis_pembelajaran1` FOREIGN KEY (`pembelajaran_id`) REFERENCES `pembelajaran` (`id`);

--
-- Constraints for table `gaji_custom`
--
ALTER TABLE `gaji_custom`
  ADD CONSTRAINT `fk_gaji_custom_history_gaji1` FOREIGN KEY (`history_gaji_id`) REFERENCES `history_gaji` (`id`);

--
-- Constraints for table `invoice`
--
ALTER TABLE `invoice`
  ADD CONSTRAINT `fk_invoice_kelas1` FOREIGN KEY (`kelas_id`) REFERENCES `kelas` (`id`),
  ADD CONSTRAINT `fk_invoice_profile1` FOREIGN KEY (`profile_id`) REFERENCES `profile` (`id`);

--
-- Constraints for table `kelas`
--
ALTER TABLE `kelas`
  ADD CONSTRAINT `fk_kelas_kategori_kelas1` FOREIGN KEY (`kategori_kelas_id`) REFERENCES `kategori_kelas` (`id`),
  ADD CONSTRAINT `fk_kelas_program_belajar1` FOREIGN KEY (`program_belajar_id`) REFERENCES `program_belajar` (`id`);

--
-- Constraints for table `message`
--
ALTER TABLE `message`
  ADD CONSTRAINT `fk_message_profile1` FOREIGN KEY (`profile_id`) REFERENCES `profile` (`id`);

--
-- Constraints for table `murid_kelas`
--
ALTER TABLE `murid_kelas`
  ADD CONSTRAINT `fk_murid_kelas_kelas1` FOREIGN KEY (`kelas_id`) REFERENCES `kelas` (`id`);

--
-- Constraints for table `pembelajaran`
--
ALTER TABLE `pembelajaran`
  ADD CONSTRAINT `fk_pembelajaran_kelas1` FOREIGN KEY (`kelas_id`) REFERENCES `kelas` (`id`);

--
-- Constraints for table `profile`
--
ALTER TABLE `profile`
  ADD CONSTRAINT `fk_profile_sekolah1` FOREIGN KEY (`sekolah_id`) REFERENCES `sekolah` (`id`),
  ADD CONSTRAINT `fk_profiles_users1` FOREIGN KEY (`id`) REFERENCES `akun` (`id`);

--
-- Constraints for table `program_belajar`
--
ALTER TABLE `program_belajar`
  ADD CONSTRAINT `fk_program_belajar_tipe_kelas1` FOREIGN KEY (`tipe_kelas_id`) REFERENCES `tipe_kelas` (`id`);

--
-- Constraints for table `sertiv`
--
ALTER TABLE `sertiv`
  ADD CONSTRAINT `fk_sertiv_profile1` FOREIGN KEY (`profile_id`) REFERENCES `profile` (`id`);

--
-- Constraints for table `transport`
--
ALTER TABLE `transport`
  ADD CONSTRAINT `fk_transport_history_gaji1` FOREIGN KEY (`history_gaji_id`) REFERENCES `history_gaji` (`id`),
  ADD CONSTRAINT `fk_transport_pembelajaran1` FOREIGN KEY (`pembelajaran_id`) REFERENCES `pembelajaran` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
