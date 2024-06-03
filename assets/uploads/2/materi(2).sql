-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: May 26, 2024 at 05:33 PM
-- Server version: 11.3.2-MariaDB
-- PHP Version: 8.3.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ethol`
--

-- --------------------------------------------------------

--
-- Table structure for table `materi`
--

CREATE TABLE `materi` (
  `id_materi` int(11) NOT NULL,
  `nama_materi` varchar(50) NOT NULL,
  `deskripsi_materi` varchar(50) NOT NULL,
  `ukuran_materi` int(11) NOT NULL,
  `tipe_materi` varchar(50) NOT NULL,
  `path_materi` varchar(100) NOT NULL,
  `id_matkul_kelas` int(11) NOT NULL,
  `uploaded_at` date NOT NULL,
  `tenggat` date DEFAULT NULL,
  `is_tugas` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `materi`
--

INSERT INTO `materi` (`id_materi`, `nama_materi`, `deskripsi_materi`, `ukuran_materi`, `tipe_materi`, `path_materi`, `id_matkul_kelas`, `uploaded_at`, `tenggat`, `is_tugas`) VALUES
(6, 'foo', 'bar', 6351, 'application/sql', '/kuliah/uas/assets/uploads/2/ethol.sql', 2, '2024-05-26', NULL, 0),
(7, 'Materi PSQL', 'Lorem Ipsum Dolor Sit Amet Foo Bar Baz', 670668, 'application/sql', '/kuliah/uas/assets/uploads/2/trade (mysql version).sql', 2, '2024-05-26', NULL, 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `materi`
--
ALTER TABLE `materi`
  ADD PRIMARY KEY (`id_materi`),
  ADD KEY `id_matkul_kelas` (`id_matkul_kelas`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `materi`
--
ALTER TABLE `materi`
  MODIFY `id_materi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `materi`
--
ALTER TABLE `materi`
  ADD CONSTRAINT `materi_ibfk_1` FOREIGN KEY (`id_matkul_kelas`) REFERENCES `matkul_kelas` (`id_matkul_kelas`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
