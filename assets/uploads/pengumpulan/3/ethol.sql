-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: May 26, 2024 at 07:32 PM
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
-- Table structure for table `departemen`
--

CREATE TABLE `departemen` (
  `id_departemen` int(11) NOT NULL,
  `nama_departemen` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `departemen`
--

INSERT INTO `departemen` (`id_departemen`, `nama_departemen`) VALUES
(1, 'Departemen Teknik Informatika dan Komputer'),
(2, 'Departemen Teknik Elektro'),
(3, 'Departemen Teknik Mekanika dan Energi');

-- --------------------------------------------------------

--
-- Table structure for table `dosen`
--

CREATE TABLE `dosen` (
  `nip` varchar(10) NOT NULL,
  `nama` varchar(50) NOT NULL,
  `id_departemen` int(11) NOT NULL,
  `id_user` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `dosen`
--

INSERT INTO `dosen` (`nip`, `nama`, `id_departemen`, `id_user`) VALUES
('3510162001', 'Yesta Medya', 1, 7),
('3510162002', 'Renovita', 1, 8);

-- --------------------------------------------------------

--
-- Table structure for table `hak_akses`
--

CREATE TABLE `hak_akses` (
  `id_hak` int(11) NOT NULL,
  `nama_hak` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `hak_akses`
--

INSERT INTO `hak_akses` (`id_hak`, `nama_hak`) VALUES
(1, 'root'),
(2, 'dosen'),
(3, 'mahasiswa');

-- --------------------------------------------------------

--
-- Table structure for table `jurusan`
--

CREATE TABLE `jurusan` (
  `id_jurusan` int(11) NOT NULL,
  `nama_jurusan` varchar(50) NOT NULL,
  `id_departemen` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `jurusan`
--

INSERT INTO `jurusan` (`id_jurusan`, `nama_jurusan`, `id_departemen`) VALUES
(1, 'D4 Teknik Informatika', 1),
(2, 'D4 Teknik Elektro', 2),
(3, 'D4 Sistem Pembangkit Energi', 3);

-- --------------------------------------------------------

--
-- Table structure for table `kelas`
--

CREATE TABLE `kelas` (
  `id_kelas` int(11) NOT NULL,
  `nama_kelas` varchar(50) NOT NULL,
  `angkatan` varchar(4) NOT NULL,
  `id_jurusan` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `kelas`
--

INSERT INTO `kelas` (`id_kelas`, `nama_kelas`, `angkatan`, `id_jurusan`) VALUES
(1, 'D4 Teknik Informatika A', '2023', 1),
(2, 'D4 Teknik Informatika B', '2023', 1),
(5, 'D4 Teknik Informatika A', '2022', 1),
(6, 'D4 Teknik Elektro A', '2023', 2),
(7, 'D4 SPE A', '2023', 3);

-- --------------------------------------------------------

--
-- Table structure for table `mahasiswa`
--

CREATE TABLE `mahasiswa` (
  `nrp` varchar(10) NOT NULL,
  `nama` varchar(50) NOT NULL,
  `id_user` int(10) NOT NULL,
  `id_kelas` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `mahasiswa`
--

INSERT INTO `mahasiswa` (`nrp`, `nama`, `id_user`, `id_kelas`) VALUES
('3123600011', 'Mohammad Rizaldy Ramadhan', 3, 1),
('3123600012', 'Zaidan', 4, 5),
('3123600028', 'Aril', 5, 6);

-- --------------------------------------------------------

--
-- Table structure for table `mata_kuliah`
--

CREATE TABLE `mata_kuliah` (
  `id_matkul` int(11) NOT NULL,
  `nama_matkul` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `mata_kuliah`
--

INSERT INTO `mata_kuliah` (`id_matkul`, `nama_matkul`) VALUES
(1, 'Workshop Desain Web'),
(2, 'Algoritma dan Struktur Data');

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
(7, 'Materi PSQL', 'Lorem Ipsum Dolor Sit Amet Foo Bar Baz', 670668, 'application/sql', '/kuliah/uas/assets/uploads/2/trade (mysql version).sql', 2, '2024-05-26', NULL, 0),
(8, 'abc', 'def', 6351, 'application/sql', '/kuliah/uas/assets/uploads/2/ethol.sql', 2, '2024-05-27', '2024-05-26', 1),
(10, 'Rangkuman Matematika', 'Dikumpulkan dalam format PDF lorem ipsum', 17894, 'text/markdown', '/kuliah/uas/assets/uploads/2/LICENSE.md', 2, '2024-05-27', '2024-05-26', 1);

-- --------------------------------------------------------

--
-- Table structure for table `matkul_dosen`
--

CREATE TABLE `matkul_dosen` (
  `id_matkul` int(11) NOT NULL,
  `nip` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `matkul_dosen`
--

INSERT INTO `matkul_dosen` (`id_matkul`, `nip`) VALUES
(1, '3510162001'),
(2, '3510162002');

-- --------------------------------------------------------

--
-- Table structure for table `matkul_kelas`
--

CREATE TABLE `matkul_kelas` (
  `id_matkul_kelas` int(11) NOT NULL,
  `id_kelas` int(11) NOT NULL,
  `id_matkul` int(11) NOT NULL,
  `hari` varchar(10) NOT NULL,
  `ruang` varchar(10) NOT NULL,
  `jam` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `matkul_kelas`
--

INSERT INTO `matkul_kelas` (`id_matkul_kelas`, `id_kelas`, `id_matkul`, `hari`, `ruang`, `jam`) VALUES
(1, 1, 2, 'Senin', 'C203', '08:00:00'),
(2, 1, 1, 'Senin', 'C103', '12:30:00');

-- --------------------------------------------------------

--
-- Table structure for table `pengumpulan_penugasan`
--

CREATE TABLE `pengumpulan_penugasan` (
  `id_user` int(11) NOT NULL,
  `path_tugas` varchar(50) NOT NULL,
  `nilai_tugas` int(11) NOT NULL,
  `id_materi` int(11) NOT NULL,
  `tanggal_pengumpulan` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id_user` int(11) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `id_hak` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id_user`, `email`, `password`, `id_hak`) VALUES
(1, 'root@gmail.com', 'root', 1),
(3, 'moxaldy@gmail.com', '201004', 3),
(4, 'moxaldy@proton.me', '201004', 3),
(5, 'aril@gmail.com', '201004', 3),
(6, 'aldi@gmail.com', '201004', 3),
(7, 'yesta@gmail.com', '201004', 2),
(8, 'reno@gmail.com', '201004', 2);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `departemen`
--
ALTER TABLE `departemen`
  ADD PRIMARY KEY (`id_departemen`);

--
-- Indexes for table `dosen`
--
ALTER TABLE `dosen`
  ADD PRIMARY KEY (`nip`),
  ADD KEY `id_departemen` (`id_departemen`,`id_user`),
  ADD KEY `id_user` (`id_user`);

--
-- Indexes for table `hak_akses`
--
ALTER TABLE `hak_akses`
  ADD PRIMARY KEY (`id_hak`);

--
-- Indexes for table `jurusan`
--
ALTER TABLE `jurusan`
  ADD PRIMARY KEY (`id_jurusan`),
  ADD UNIQUE KEY `id_departemen` (`id_departemen`);

--
-- Indexes for table `kelas`
--
ALTER TABLE `kelas`
  ADD PRIMARY KEY (`id_kelas`),
  ADD KEY `id_jurusan` (`id_jurusan`);

--
-- Indexes for table `mahasiswa`
--
ALTER TABLE `mahasiswa`
  ADD PRIMARY KEY (`nrp`),
  ADD KEY `id_user` (`id_user`,`id_kelas`),
  ADD KEY `id_kelas` (`id_kelas`);

--
-- Indexes for table `mata_kuliah`
--
ALTER TABLE `mata_kuliah`
  ADD PRIMARY KEY (`id_matkul`);

--
-- Indexes for table `materi`
--
ALTER TABLE `materi`
  ADD PRIMARY KEY (`id_materi`),
  ADD KEY `id_matkul_kelas` (`id_matkul_kelas`);

--
-- Indexes for table `matkul_dosen`
--
ALTER TABLE `matkul_dosen`
  ADD KEY `id_matkul` (`id_matkul`,`nip`),
  ADD KEY `nip` (`nip`);

--
-- Indexes for table `matkul_kelas`
--
ALTER TABLE `matkul_kelas`
  ADD PRIMARY KEY (`id_matkul_kelas`),
  ADD KEY `id_kelas` (`id_kelas`,`id_matkul`),
  ADD KEY `id_matkul` (`id_matkul`);

--
-- Indexes for table `pengumpulan_penugasan`
--
ALTER TABLE `pengumpulan_penugasan`
  ADD KEY `id_user` (`id_user`,`id_materi`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id_user`),
  ADD KEY `fk_hak_akses` (`id_hak`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `departemen`
--
ALTER TABLE `departemen`
  MODIFY `id_departemen` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `hak_akses`
--
ALTER TABLE `hak_akses`
  MODIFY `id_hak` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `jurusan`
--
ALTER TABLE `jurusan`
  MODIFY `id_jurusan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `kelas`
--
ALTER TABLE `kelas`
  MODIFY `id_kelas` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `mata_kuliah`
--
ALTER TABLE `mata_kuliah`
  MODIFY `id_matkul` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `materi`
--
ALTER TABLE `materi`
  MODIFY `id_materi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `matkul_kelas`
--
ALTER TABLE `matkul_kelas`
  MODIFY `id_matkul_kelas` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `dosen`
--
ALTER TABLE `dosen`
  ADD CONSTRAINT `dosen_ibfk_1` FOREIGN KEY (`id_departemen`) REFERENCES `departemen` (`id_departemen`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `dosen_ibfk_2` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `jurusan`
--
ALTER TABLE `jurusan`
  ADD CONSTRAINT `jurusan_ibfk_1` FOREIGN KEY (`id_departemen`) REFERENCES `departemen` (`id_departemen`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `kelas`
--
ALTER TABLE `kelas`
  ADD CONSTRAINT `kelas_ibfk_1` FOREIGN KEY (`id_jurusan`) REFERENCES `jurusan` (`id_jurusan`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `mahasiswa`
--
ALTER TABLE `mahasiswa`
  ADD CONSTRAINT `mahasiswa_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `mahasiswa_ibfk_2` FOREIGN KEY (`id_kelas`) REFERENCES `kelas` (`id_kelas`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `materi`
--
ALTER TABLE `materi`
  ADD CONSTRAINT `materi_ibfk_1` FOREIGN KEY (`id_matkul_kelas`) REFERENCES `matkul_kelas` (`id_matkul_kelas`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `matkul_dosen`
--
ALTER TABLE `matkul_dosen`
  ADD CONSTRAINT `matkul_dosen_ibfk_1` FOREIGN KEY (`id_matkul`) REFERENCES `mata_kuliah` (`id_matkul`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `matkul_dosen_ibfk_2` FOREIGN KEY (`nip`) REFERENCES `dosen` (`nip`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `matkul_kelas`
--
ALTER TABLE `matkul_kelas`
  ADD CONSTRAINT `matkul_kelas_ibfk_1` FOREIGN KEY (`id_matkul`) REFERENCES `mata_kuliah` (`id_matkul`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `matkul_kelas_ibfk_2` FOREIGN KEY (`id_kelas`) REFERENCES `kelas` (`id_kelas`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`id_hak`) REFERENCES `hak_akses` (`id_hak`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
