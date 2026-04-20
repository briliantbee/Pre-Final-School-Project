/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

DROP TABLE IF EXISTS `aktivitas`;
CREATE TABLE `aktivitas` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned NOT NULL,
  `aktivitas` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `deskripsi` text COLLATE utf8mb4_unicode_ci,
  `ip_address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `aktivitas_user_id_foreign` (`user_id`),
  CONSTRAINT `aktivitas_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=45 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `alats`;
CREATE TABLE `alats` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `nama_alat` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `kode_alat` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `deskripsi` text COLLATE utf8mb4_unicode_ci,
  `stok` int NOT NULL DEFAULT '0',
  `stok_tersedia` int NOT NULL DEFAULT '0',
  `kategori_id` bigint unsigned NOT NULL,
  `status` enum('tersedia','tidak_tersedia') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'tersedia',
  `foto` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `alats_kode_alat_unique` (`kode_alat`),
  KEY `alats_kategori_id_foreign` (`kategori_id`),
  CONSTRAINT `alats_kategori_id_foreign` FOREIGN KEY (`kategori_id`) REFERENCES `kategoris` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `cache`;
CREATE TABLE `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`),
  KEY `cache_expiration_index` (`expiration`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `cache_locks`;
CREATE TABLE `cache_locks` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`),
  KEY `cache_locks_expiration_index` (`expiration`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `dendas`;
CREATE TABLE `dendas` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `pengembalian_id` bigint unsigned NOT NULL,
  `denda_keterlambatan` int NOT NULL DEFAULT '0',
  `denda_kerusakan` int NOT NULL DEFAULT '0',
  `total_denda` int NOT NULL DEFAULT '0',
  `status` enum('belum_dibayar','sudah_dibayar') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'belum_dibayar',
  `bukti_pembayaran` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tanggal_pembayaran` timestamp NULL DEFAULT NULL,
  `dikonfirmasi_oleh` bigint unsigned DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `dendas_pengembalian_id_foreign` (`pengembalian_id`),
  KEY `dendas_dikonfirmasi_oleh_foreign` (`dikonfirmasi_oleh`),
  CONSTRAINT `dendas_dikonfirmasi_oleh_foreign` FOREIGN KEY (`dikonfirmasi_oleh`) REFERENCES `users` (`id`),
  CONSTRAINT `dendas_pengembalian_id_foreign` FOREIGN KEY (`pengembalian_id`) REFERENCES `pengembalians` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `failed_jobs`;
CREATE TABLE `failed_jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `job_batches`;
CREATE TABLE `job_batches` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `jobs`;
CREATE TABLE `jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint unsigned NOT NULL,
  `reserved_at` int unsigned DEFAULT NULL,
  `available_at` int unsigned NOT NULL,
  `created_at` int unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `kategoris`;
CREATE TABLE `kategoris` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `nama_kategori` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `deskripsi` text COLLATE utf8mb4_unicode_ci,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `migrations`;
CREATE TABLE `migrations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `password_reset_tokens`;
CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `peminjamans`;
CREATE TABLE `peminjamans` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `kode_peminjaman` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint unsigned NOT NULL,
  `alat_id` bigint unsigned NOT NULL,
  `jumlah` int NOT NULL DEFAULT '1',
  `tanggal_peminjaman` date NOT NULL,
  `tanggal_berakhir_peminjaman` date NOT NULL,
  `status` enum('menunggu_konfirmasi','disetujui','ditolak','dipinjam','dikembalikan','melewati_jadwal') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'menunggu_konfirmasi',
  `keperluan` text COLLATE utf8mb4_unicode_ci,
  `catatan_admin` text COLLATE utf8mb4_unicode_ci,
  `disetujui_oleh` bigint unsigned DEFAULT NULL,
  `tanggal_disetujui` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `peminjamans_kode_peminjaman_unique` (`kode_peminjaman`),
  KEY `peminjamans_user_id_foreign` (`user_id`),
  KEY `peminjamans_alat_id_foreign` (`alat_id`),
  KEY `peminjamans_disetujui_oleh_foreign` (`disetujui_oleh`),
  CONSTRAINT `peminjamans_alat_id_foreign` FOREIGN KEY (`alat_id`) REFERENCES `alats` (`id`) ON DELETE CASCADE,
  CONSTRAINT `peminjamans_disetujui_oleh_foreign` FOREIGN KEY (`disetujui_oleh`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  CONSTRAINT `peminjamans_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `pengembalians`;
CREATE TABLE `pengembalians` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `peminjaman_id` bigint unsigned NOT NULL,
  `tanggal_pengembalian` date NOT NULL,
  `jumlah_dikembalikan` int NOT NULL DEFAULT '1',
  `kondisi_alat` enum('baik','rusak','hilang','tidak_lengkap') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'baik',
  `diterima_oleh` bigint unsigned NOT NULL,
  `terlambat` tinyint(1) NOT NULL DEFAULT '0',
  `hari_terlambat` int NOT NULL DEFAULT '0',
  `catatan` text COLLATE utf8mb4_unicode_ci,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `pengembalians_peminjaman_id_foreign` (`peminjaman_id`),
  KEY `pengembalians_diterima_oleh_foreign` (`diterima_oleh`),
  CONSTRAINT `pengembalians_diterima_oleh_foreign` FOREIGN KEY (`diterima_oleh`) REFERENCES `users` (`id`),
  CONSTRAINT `pengembalians_peminjaman_id_foreign` FOREIGN KEY (`peminjaman_id`) REFERENCES `peminjamans` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `roles`;
CREATE TABLE `roles` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `nama_role` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `sessions`;
CREATE TABLE `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint unsigned DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `nama_lengkap` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nomor_identitas` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `role_id` bigint unsigned NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_name_unique` (`name`),
  UNIQUE KEY `users_email_unique` (`email`),
  KEY `users_role_id_foreign` (`role_id`),
  CONSTRAINT `users_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `aktivitas` (`id`, `user_id`, `aktivitas`, `deskripsi`, `ip_address`, `user_agent`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 3, 'Mengajukan Peminjaman', 'Peminjaman PMJ00006 telah diajukan', NULL, NULL, NULL, '2026-02-09 16:41:55', '2026-02-09 16:41:55'),
(2, 3, 'Mengajukan Peminjaman', 'Peminjaman PMJ00007 telah diajukan', NULL, NULL, NULL, '2026-02-10 01:28:22', '2026-02-10 01:28:22'),
(3, 2, 'Menyerahkan Alat', 'Alat untuk peminjaman PMJ00006 telah diserahkan kepada ', NULL, NULL, NULL, '2026-02-10 02:57:50', '2026-02-10 02:57:50'),
(4, 2, 'Memproses Pengembalian', 'Pengembalian untuk peminjaman PMJ00002 telah diproses', NULL, NULL, NULL, '2026-02-10 04:22:11', '2026-02-10 04:22:11'),
(5, 2, 'Menyetujui Peminjaman', 'Peminjaman PMJ00007 disetujui oleh petugas', NULL, NULL, NULL, '2026-02-10 15:44:54', '2026-02-10 15:44:54'),
(6, 2, 'Menyerahkan Alat', 'Alat untuk peminjaman PMJ00007 telah diserahkan kepada ', NULL, NULL, NULL, '2026-02-10 15:45:02', '2026-02-10 15:45:02'),
(7, 2, 'Menolak Peminjaman', 'Peminjaman PMJ00001 ditolak oleh petugas', NULL, NULL, NULL, '2026-02-10 15:45:13', '2026-02-10 15:45:13'),
(8, 3, 'Mengajukan Peminjaman', 'Peminjaman PMJ00008 telah diajukan', NULL, NULL, NULL, '2026-02-10 15:49:22', '2026-02-10 15:49:22'),
(9, 2, 'Menyetujui Peminjaman', 'Peminjaman PMJ00008 disetujui oleh petugas', NULL, NULL, NULL, '2026-02-10 15:49:57', '2026-02-10 15:49:57'),
(10, 2, 'Menyerahkan Alat', 'Alat untuk peminjaman PMJ00008 telah diserahkan kepada ', NULL, NULL, NULL, '2026-02-10 15:56:03', '2026-02-10 15:56:03'),
(11, 3, 'Mengajukan Peminjaman', 'Peminjaman PMJ00009 telah diajukan', NULL, NULL, NULL, '2026-02-11 16:00:39', '2026-02-11 16:00:39'),
(12, 2, 'Menyetujui Peminjaman', 'Peminjaman PMJ00009 disetujui oleh petugas', NULL, NULL, NULL, '2026-02-11 16:01:21', '2026-02-11 16:01:21'),
(13, 2, 'Menyerahkan Alat', 'Alat untuk peminjaman PMJ00009 telah diserahkan kepada ', NULL, NULL, NULL, '2026-02-11 16:01:26', '2026-02-11 16:01:26'),
(14, 2, 'Memproses Pengembalian', 'Pengembalian untuk peminjaman PMJ00009 telah diproses', NULL, NULL, NULL, '2026-02-11 16:02:11', '2026-02-11 16:02:11'),
(15, 2, 'Memproses Pengembalian', 'Pengembalian untuk peminjaman PMJ00008 telah diproses', NULL, NULL, NULL, '2026-02-11 16:05:49', '2026-02-11 16:05:49'),
(16, 2, 'Memproses Pengembalian', 'Pengembalian untuk peminjaman PMJ00006 telah diproses', NULL, NULL, NULL, '2026-02-11 16:29:58', '2026-02-11 16:29:58'),
(17, 2, 'Memproses Pengembalian', 'Pengembalian untuk peminjaman PMJ00003 telah diproses', NULL, NULL, NULL, '2026-02-11 16:30:33', '2026-02-11 16:30:33'),
(18, 2, 'Memproses Pengembalian', 'Pengembalian untuk peminjaman PMJ00007 telah diproses', NULL, NULL, NULL, '2026-02-11 16:30:47', '2026-02-11 16:30:47'),
(19, 3, 'Mengajukan Peminjaman', 'Peminjaman PMJ00010 telah diajukan', NULL, NULL, NULL, '2026-02-11 16:33:58', '2026-02-11 16:33:58'),
(20, 2, 'Menyetujui Peminjaman', 'Peminjaman PMJ00010 disetujui oleh petugas', NULL, NULL, NULL, '2026-02-11 16:34:45', '2026-02-11 16:34:45'),
(21, 2, 'Memproses Pengembalian', 'Pengembalian untuk peminjaman PMJ00010 telah diproses', NULL, NULL, NULL, '2026-02-11 16:35:07', '2026-02-11 16:35:07'),
(22, 3, 'Mengajukan Peminjaman', 'Peminjaman PMJ00011 telah diajukan', NULL, NULL, NULL, '2026-02-11 16:37:29', '2026-02-11 16:37:29'),
(23, 2, 'Menyetujui Peminjaman', 'Peminjaman PMJ00011 disetujui oleh petugas', NULL, NULL, NULL, '2026-02-11 16:37:59', '2026-02-11 16:37:59'),
(24, 2, 'Menyerahkan Alat', 'Alat untuk peminjaman PMJ00011 telah diserahkan kepada ', NULL, NULL, NULL, '2026-02-11 16:38:09', '2026-02-11 16:38:09'),
(25, 2, 'Memproses Pengembalian', 'Pengembalian untuk peminjaman PMJ00011 telah diproses', NULL, NULL, NULL, '2026-02-11 16:38:21', '2026-02-11 16:38:21'),
(26, 3, 'Mengajukan Peminjaman', 'Peminjaman PMJ00012 telah diajukan', NULL, NULL, NULL, '2026-02-11 16:39:23', '2026-02-11 16:39:23'),
(27, 2, 'Menyetujui Peminjaman', 'Peminjaman PMJ00012 disetujui oleh petugas', NULL, NULL, NULL, '2026-02-11 16:39:54', '2026-02-11 16:39:54'),
(28, 2, 'Menyerahkan Alat', 'Alat untuk peminjaman PMJ00012 telah diserahkan kepada ', NULL, NULL, NULL, '2026-02-11 16:40:04', '2026-02-11 16:40:04'),
(29, 2, 'Memproses Pengembalian', 'Pengembalian untuk peminjaman PMJ00012 telah diproses', NULL, NULL, NULL, '2026-02-11 16:40:32', '2026-02-11 16:40:32'),
(30, 3, 'Mengajukan Peminjaman', 'Peminjaman PMJ00013 telah diajukan', NULL, NULL, NULL, '2026-02-11 16:42:03', '2026-02-11 16:42:03'),
(31, 2, 'Menyetujui Peminjaman', 'Peminjaman PMJ00013 disetujui oleh petugas', NULL, NULL, NULL, '2026-02-11 16:42:57', '2026-02-11 16:42:57'),
(32, 2, 'Menyerahkan Alat', 'Alat untuk peminjaman PMJ00013 telah diserahkan kepada ', NULL, NULL, NULL, '2026-02-11 16:43:07', '2026-02-11 16:43:07'),
(33, 2, 'Memproses Pengembalian', 'Pengembalian untuk peminjaman PMJ00013 telah diproses', NULL, NULL, NULL, '2026-02-11 16:43:43', '2026-02-11 16:43:43'),
(34, 3, 'Mengajukan Peminjaman', 'Peminjaman PMJ00014 telah diajukan', NULL, NULL, NULL, '2026-02-11 17:31:20', '2026-02-11 17:31:20'),
(35, 2, 'Menyetujui Peminjaman', 'Peminjaman PMJ00014 disetujui oleh petugas', NULL, NULL, NULL, '2026-02-11 17:37:21', '2026-02-11 17:37:21'),
(36, 2, 'Menyerahkan Alat', 'Alat untuk peminjaman PMJ00014 telah diserahkan kepada ', NULL, NULL, NULL, '2026-02-11 17:37:36', '2026-02-11 17:37:36'),
(37, 3, 'Mengajukan Peminjaman', 'Peminjaman PMJ00015 telah diajukan', NULL, NULL, NULL, '2026-02-11 17:40:08', '2026-02-11 17:40:08'),
(38, 2, 'Menyetujui Peminjaman', 'Peminjaman PMJ00015 disetujui oleh petugas', NULL, NULL, NULL, '2026-02-11 17:40:54', '2026-02-11 17:40:54'),
(39, 2, 'Menyerahkan Alat', 'Alat untuk peminjaman PMJ00015 telah diserahkan kepada ', NULL, NULL, NULL, '2026-02-11 17:41:13', '2026-02-11 17:41:13'),
(40, 2, 'Memproses Pengembalian', 'Pengembalian untuk peminjaman PMJ00014 telah diproses', NULL, NULL, NULL, '2026-02-11 17:41:40', '2026-02-11 17:41:40'),
(41, 2, 'Memproses Pengembalian', 'Pengembalian untuk peminjaman PMJ00015 telah diproses', NULL, NULL, NULL, '2026-02-11 17:42:07', '2026-02-11 17:42:07'),
(42, 5, 'Mengajukan Peminjaman', 'Peminjaman PMJ00016 telah diajukan', NULL, NULL, NULL, '2026-04-06 04:00:53', '2026-04-06 04:00:53'),
(43, 2, 'Menyetujui Peminjaman', 'Peminjaman PMJ00016 disetujui oleh petugas', NULL, NULL, NULL, '2026-04-06 04:03:51', '2026-04-06 04:03:51'),
(44, 2, 'Menyerahkan Alat', 'Alat untuk peminjaman PMJ00016 telah diserahkan kepada ', NULL, NULL, NULL, '2026-04-06 04:03:59', '2026-04-06 04:03:59');
INSERT INTO `alats` (`id`, `nama_alat`, `kode_alat`, `deskripsi`, `stok`, `stok_tersedia`, `kategori_id`, `status`, `foto`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 'Laptop ASUS', 'LPT-001', 'Laptop ASUS ROG untuk pembelajaran programming', 10, 12, 1, 'tersedia', NULL, NULL, '2026-02-09 03:13:14', '2026-02-11 17:41:40'),
(2, 'PC Rakitan', 'PC-001', 'PC Rakitan Intel Core i5', 5, 1, 1, 'tersedia', NULL, NULL, '2026-02-09 03:13:14', '2026-02-11 17:42:07'),
(3, 'Router MikroTik', 'RTR-001', 'Router MikroTik RB750', 3, 3, 2, 'tersedia', NULL, NULL, '2026-02-09 03:13:14', '2026-02-09 03:13:14'),
(4, 'Switch 24 Port', 'SWT-001', 'Switch Gigabit 24 Port', 4, 4, 2, 'tersedia', NULL, NULL, '2026-02-09 03:13:14', '2026-02-10 04:22:11'),
(5, 'Tang Crimping', 'TLS-001', 'Tang Crimping RJ45', 15, 14, 3, 'tersedia', NULL, NULL, '2026-02-09 03:13:14', '2026-04-06 04:03:51'),
(6, 'LAN Tester', 'TLS-002', 'LAN Cable Tester', 10, 2, 3, 'tersedia', NULL, NULL, '2026-02-09 03:13:14', '2026-02-11 16:05:49'),
(7, 'Arduino Uno', 'ARD-001', 'Arduino Uno R3 Original', 20, 20, 4, 'tersedia', NULL, NULL, '2026-02-09 03:13:14', '2026-02-09 03:13:14'),
(8, 'Kamera DSLR', 'CAM-001', 'Kamera DSLR Canon EOS', 2, 2, 5, 'tersedia', NULL, NULL, '2026-02-09 03:13:14', '2026-02-09 03:13:14'),
(9, 'asus  mega big', 'sdasdadasd', 'sdsadas', 20, 20, 1, 'tersedia', 'alat/MMqOkhGlSTiDIxBocChmrbR2pv1LJWtXP5wJM4F4.jpg', NULL, '2026-02-10 16:06:45', '2026-02-10 16:06:45');


INSERT INTO `dendas` (`id`, `pengembalian_id`, `denda_keterlambatan`, `denda_kerusakan`, `total_denda`, `status`, `bukti_pembayaran`, `tanggal_pembayaran`, `dikonfirmasi_oleh`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 1, -5000, 50000, 45000, 'sudah_dibayar', 'bukti-pembayaran/vcfxuoME3vFXEIS9TtpPmvQ8Xn404PwgPLxVb49q.jpg', NULL, NULL, NULL, '2026-02-09 03:13:14', '2026-02-09 03:14:10'),
(2, 5, 0, 0, 0, 'sudah_dibayar', NULL, NULL, NULL, NULL, '2026-02-11 16:29:58', '2026-02-11 16:29:58'),
(3, 7, 0, 0, 0, 'sudah_dibayar', NULL, NULL, NULL, NULL, '2026-02-11 16:30:47', '2026-02-11 16:30:47'),
(4, 8, 5000, 0, 5000, 'belum_dibayar', 'bukti-pembayaran/xU0aKvP0dquyFmD9sc9YhBttu5CpXuUvp5zKfav8.png', NULL, NULL, NULL, '2026-02-11 16:35:07', '2026-02-11 17:36:31'),
(5, 11, 30000, 0, 30000, 'belum_dibayar', 'bukti-pembayaran/2hhKPeuJsupKDpw0pQ0aDj4p6lVAWtzcQTnC1fkx.png', NULL, NULL, NULL, '2026-02-11 16:43:43', '2026-02-11 17:35:15'),
(6, 13, 20000, 0, 20000, 'belum_dibayar', NULL, NULL, NULL, NULL, '2026-02-11 17:42:07', '2026-02-11 17:42:07');



INSERT INTO `kategoris` (`id`, `nama_kategori`, `deskripsi`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 'Perangkat Komputer', 'Laptop, PC, dan perangkat komputer lainnya', NULL, '2026-02-09 03:13:14', '2026-02-09 03:13:14'),
(2, 'Perangkat Jaringan', 'Router, Switch, Kabel UTP, dan perangkat jaringan', NULL, '2026-02-09 03:13:14', '2026-02-09 03:13:14'),
(3, 'Tools & Peralatan', 'Obeng, Tang Crimping, LAN Tester, dan tools lainnya', NULL, '2026-02-09 03:13:14', '2026-02-09 03:13:14'),
(4, 'Komponen Elektronik', 'Arduino, Sensor, Resistor, dan komponen elektronik', NULL, '2026-02-09 03:13:14', '2026-02-09 03:13:14'),
(5, 'Multimedia', 'Kamera, Microphone, Speaker, dan peralatan multimedia', NULL, '2026-02-09 03:13:14', '2026-02-09 03:13:14'),
(6, 'casan laptop', NULL, NULL, '2026-02-11 17:24:45', '2026-02-11 17:24:45'),
(7, 'elektronikan', NULL, NULL, '2026-02-11 17:24:57', '2026-02-11 17:24:57');
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2026_02_08_115248_create_roles_table', 1),
(5, '2026_02_08_115452_add_user_credential', 1),
(6, '2026_02_08_115907_create_kategoris_table', 1),
(7, '2026_02_08_120202_create_alats_table', 1),
(8, '2026_02_08_120326_create_peminjamen_table', 1),
(9, '2026_02_08_120427_create_pengembalians_table', 1),
(10, '2026_02_08_120457_create_dendas_table', 1),
(11, '2026_02_08_120541_create_aktivitas_table', 1);

INSERT INTO `peminjamans` (`id`, `kode_peminjaman`, `user_id`, `alat_id`, `jumlah`, `tanggal_peminjaman`, `tanggal_berakhir_peminjaman`, `status`, `keperluan`, `catatan_admin`, `disetujui_oleh`, `tanggal_disetujui`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 'PMJ00001', 1, 7, 1, '2026-02-08', '2026-02-09', 'ditolak', 'Testing seeder', 'ga valid', 2, '2026-02-10 15:45:13', NULL, '2026-02-09 03:13:14', '2026-02-10 15:45:13'),
(2, 'PMJ00002', 2, 4, 1, '2026-02-01', '2026-02-03', 'dikembalikan', 'Testing seeder', NULL, 1, '2026-02-09 03:13:14', NULL, '2026-02-09 03:13:14', '2026-02-10 04:22:11'),
(3, 'PMJ00003', 2, 2, 1, '2026-02-05', '2026-02-11', 'dikembalikan', 'Testing seeder', NULL, 1, '2026-02-09 03:13:14', NULL, '2026-02-09 03:13:14', '2026-02-11 16:30:33'),
(4, 'PMJ00004', 1, 6, 1, '2026-02-03', '2026-02-05', 'dikembalikan', 'Testing seeder', NULL, 1, '2026-02-09 03:13:14', NULL, '2026-02-09 03:13:14', '2026-02-09 03:13:14'),
(5, 'PMJ00005', 2, 1, 1, '2026-02-01', '2026-02-07', 'ditolak', 'Testing seeder', 'Ditolak oleh admin (contoh)', NULL, NULL, NULL, '2026-02-09 03:13:14', '2026-02-09 03:13:14'),
(6, 'PMJ00006', 3, 1, 2, '2026-02-09', '2026-02-11', 'dikembalikan', 'yuu', NULL, NULL, NULL, NULL, '2026-02-09 16:41:55', '2026-02-11 16:29:58'),
(7, 'PMJ00007', 3, 2, 1, '2026-02-10', '2026-02-25', 'dikembalikan', 'u', NULL, 2, '2026-02-10 15:44:53', NULL, '2026-02-10 01:28:22', '2026-02-11 16:30:47'),
(8, 'PMJ00008', 3, 6, 10, '2026-02-10', '2026-02-19', 'dikembalikan', 'gapapa', NULL, 2, '2026-02-10 15:49:57', NULL, '2026-02-10 15:49:22', '2026-02-11 16:05:49'),
(9, 'PMJ00009', 3, 1, 8, '2026-02-11', '2026-02-12', 'dikembalikan', 'untuk ngoding', NULL, 2, '2026-02-11 16:01:21', NULL, '2026-02-11 16:00:39', '2026-02-11 16:02:11'),
(10, 'PMJ00010', 3, 2, 1, '2026-02-11', '2026-02-12', 'dikembalikan', 'test', NULL, 2, '2026-02-11 16:34:45', NULL, '2026-02-11 16:33:58', '2026-02-11 16:35:07'),
(11, 'PMJ00011', 3, 1, 10, '2026-02-12', '2026-03-03', 'dikembalikan', 'testing', NULL, 2, '2026-02-11 16:37:59', NULL, '2026-02-11 16:37:29', '2026-02-11 16:38:21'),
(12, 'PMJ00012', 3, 2, 1, '2026-02-11', '2026-02-12', 'dikembalikan', 'testing', NULL, 2, '2026-02-11 16:39:54', NULL, '2026-02-11 16:39:23', '2026-02-11 16:40:32'),
(13, 'PMJ00013', 3, 2, 5, '2026-02-11', '2026-02-12', 'dikembalikan', 'tes', NULL, 2, '2026-02-11 16:42:57', NULL, '2026-02-11 16:42:03', '2026-02-11 16:43:43'),
(14, 'PMJ00014', 3, 1, 2, '2026-02-12', '2026-02-13', 'dikembalikan', 'untuk ngoding', NULL, 2, '2026-02-11 17:37:21', NULL, '2026-02-11 17:31:20', '2026-02-11 17:41:40'),
(15, 'PMJ00015', 3, 2, 1, '2026-02-12', '2026-02-13', 'dikembalikan', 'untuk ngoding', NULL, 2, '2026-02-11 17:40:54', NULL, '2026-02-11 17:40:08', '2026-02-11 17:42:07'),
(16, 'PMJ00016', 5, 5, 1, '2026-04-06', '2026-04-16', 'dipinjam', 'buat presentasi', NULL, 2, '2026-04-06 04:03:51', NULL, '2026-04-06 04:00:53', '2026-04-06 04:03:59');
INSERT INTO `pengembalians` (`id`, `peminjaman_id`, `tanggal_pengembalian`, `jumlah_dikembalikan`, `kondisi_alat`, `diterima_oleh`, `terlambat`, `hari_terlambat`, `catatan`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 4, '2026-02-06', 1, 'rusak', 1, 1, -1, NULL, NULL, '2026-02-09 03:13:14', '2026-02-09 03:13:14'),
(2, 2, '2026-02-10', 1, 'baik', 2, 1, -7, 'wdsdsa', NULL, '2026-02-10 04:22:11', '2026-02-10 04:22:11'),
(3, 9, '2026-02-13', 8, 'baik', 2, 1, -1, NULL, NULL, '2026-02-11 16:02:11', '2026-02-11 16:02:11'),
(4, 8, '2026-03-07', 1, 'baik', 2, 1, -16, NULL, NULL, '2026-02-11 16:05:49', '2026-02-11 16:05:49'),
(5, 6, '2026-03-14', 2, 'baik', 2, 1, -31, NULL, NULL, '2026-02-11 16:29:58', '2026-02-11 16:29:58'),
(6, 3, '2026-02-11', 1, 'baik', 2, 0, 0, NULL, NULL, '2026-02-11 16:30:33', '2026-02-11 16:30:33'),
(7, 7, '2026-03-06', 1, 'baik', 2, 1, -9, NULL, NULL, '2026-02-11 16:30:47', '2026-02-11 16:30:47'),
(8, 10, '2026-02-27', 1, 'baik', 2, 1, -15, 'test', NULL, '2026-02-11 16:35:07', '2026-02-11 16:35:07'),
(9, 11, '2026-02-11', 10, 'baik', 2, 0, 0, NULL, NULL, '2026-02-11 16:38:21', '2026-02-11 16:38:21'),
(10, 12, '2026-02-11', 1, 'baik', 2, 0, 0, 'test', NULL, '2026-02-11 16:40:32', '2026-02-11 16:40:32'),
(11, 13, '2026-02-18', 1, 'baik', 2, 1, 6, NULL, NULL, '2026-02-11 16:43:43', '2026-02-11 16:43:43'),
(12, 14, '2026-02-11', 2, 'baik', 2, 0, 0, NULL, NULL, '2026-02-11 17:41:40', '2026-02-11 17:41:40'),
(13, 15, '2026-02-17', 1, 'baik', 2, 1, 4, NULL, NULL, '2026-02-11 17:42:06', '2026-02-11 17:42:06');
INSERT INTO `roles` (`id`, `nama_role`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 'Admin', NULL, '2026-02-09 03:13:12', '2026-02-09 03:13:12'),
(2, 'Petugas', NULL, '2026-02-09 03:13:13', '2026-02-09 03:13:13'),
(3, 'Siswa', NULL, '2026-02-09 03:13:13', '2026-02-09 03:13:13');
INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('2bFowVoLVMyMwYxu4tXHm1J8OndOYWDc9SonPKy6', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoibklQalhoc1J6QjY1c1R0YW15WldrWnJ6NVhxMkg4YkNPS3BiYW9rbiI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMCI7czo1OiJyb3V0ZSI7Tjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1775458871),
('TKqAQfYsw5k2TnqzWGQq3ru8tYWWYHwPTJo4h34j', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiYW9RZFhFbTQ2aktvZGk0MVJiOW04bHNqZXUwZzNuSFNqSU9USGc3USI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMCI7czo1OiJyb3V0ZSI7Tjt9fQ==', 1775448894);
INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`, `nama_lengkap`, `nomor_identitas`, `role_id`) VALUES
(1, 'admin', 'admin@pplg.sch.id', NULL, '$2y$12$sH0bcoyS3S/CpMm.TSvbKOB0tBPnvFW4AsX7XoEH8ZsRZMmmcfwu6', NULL, '2026-02-09 03:13:14', '2026-02-09 03:13:14', 'Administrator', 'ADM001', 1),
(2, 'petugas1', 'petugas1@pplg.sch.id', NULL, '$2y$12$JjEs3M6Zlw06t1QgTTP6veTZZJhdL668TL0jAg1v5h6ZkJEkcJS3i', 'JUP0YYOOUyKKr8gioWlRRT3GYV1zzSfHXUratSJTFygt9GPavVc0lCDGiigF', '2026-02-09 03:13:14', '2026-02-09 03:13:14', 'Petugas Satu', 'PTG001', 2),
(3, 'siswa1', 'siswa1@pplg.sch.id', NULL, '$2y$12$qH0BGI1RyokfPhcMn86OeeeId9DLVD3N2Ifs8wGnHVDsimPh/ATsu', NULL, '2026-02-09 03:13:14', '2026-02-09 03:13:14', 'Siswa Contoh', '2024001', 3),
(4, 'ahmad', 'abisam@gmail.com', NULL, '$2y$12$fm3TaQObG7YLDL6abYZ8euZibwM4O8.behoyhK2Shh340mLCfOkke', NULL, '2026-02-11 17:24:01', '2026-02-11 17:24:01', 'ahmad gaming', '32012126313', 3),
(5, 'ican', 'ican@gmail.com', NULL, '$2y$12$reRu.1MY1rVtdPKR2fW23.qrWF9/QAQHChRfpW8aUHh4joEkTTr6S', '0mZPVvH6DZ5Tr3PMRpRKwVPlFcyfCMexDDhI3Su5aBfxPaRWyuzscTTNRJAZ', '2026-04-06 03:56:29', '2026-04-06 03:56:29', 'ican', '32012126313', 3);


/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;