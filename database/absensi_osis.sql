-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Oct 01, 2025 at 09:45 PM
-- Server version: 8.0.30
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `absensi_osis`
--

-- --------------------------------------------------------

--
-- Table structure for table `absensi`
--

CREATE TABLE `absensi` (
  `id` int NOT NULL,
  `user_id` int NOT NULL,
  `tanggal` date NOT NULL,
  `status` enum('Hadir','Izin','Sakit','Alpha') NOT NULL,
  `keterangan` text,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `nis` varchar(20) DEFAULT NULL,
  `nama_lengkap` varchar(100) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','member') DEFAULT 'member',
  `jurusan` enum('RPL','TBSM','ATPH') NOT NULL,
  `jabatan` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `foto` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `nis`, `nama_lengkap`, `email`, `password`, `role`, `jurusan`, `jabatan`, `foto`, `created_at`) VALUES
(4, '12313213', 'Ilham', 'admin@gmail.com', '$2y$10$QF/fRq78r1eA0qyrJBgNqODIadaMGx03WisbaWPZkmoNFtxVL/A5S', 'admin', 'RPL', 'admin', NULL, '2025-09-30 20:53:47'),
(5, '123', 'Ilham', 'admin123@gmail.com', '$2y$10$s9mtCm6oFlL0Z6dy8V0A2u0Y6UgA3U9csBOLM62ujeCXYMi22moEa', 'member', 'RPL', 'ketua', NULL, '2025-10-01 21:35:58'),
(6, '1234', 'Ham enak', 'youtyasuo@gmail.com', '$2y$10$6kmCe8ohJjl/jr5VqmSOx.E6lnejbd6kKRb7atSI/dt7oKMN5u0p6', 'member', 'TBSM', 'ketua', NULL, '2025-10-01 21:38:45'),
(7, '12356', 'wildssa', 'user@gmail.com', '$2y$10$D4grUAQ2ZfpwbMfDGEXqGOtZmwRu9.b57tIBPcz4bc/WvkrNg/an6', 'member', 'TBSM', 'ketua', NULL, '2025-10-01 21:40:33'),
(8, NULL, 'Ilham', 'admin321@gmail.com', '$2y$10$ar30xhY7PLofGeR1xaXTMeNracBdFFXWMy42CRPW5uoMdilkA4ZZu', 'admin', 'RPL', NULL, NULL, '2025-10-01 21:44:21');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `absensi`
--
ALTER TABLE `absensi`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nis` (`nis`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `absensi`
--
ALTER TABLE `absensi`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `absensi`
--
ALTER TABLE `absensi`
  ADD CONSTRAINT `absensi_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
