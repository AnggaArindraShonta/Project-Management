-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Waktu pembuatan: 07 Mar 2023 pada 02.20
-- Versi server: 10.4.21-MariaDB
-- Versi PHP: 7.4.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_gmp`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `pic`
--

CREATE TABLE `pic` (
  `pic_id` int(11) NOT NULL,
  `pic_name` varchar(50) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `pic`
--

INSERT INTO `pic` (`pic_id`, `pic_name`, `user_id`) VALUES
(2, 'Jennie', 7),
(3, 'Angga', 8),
(7, 'aaa', 8),
(8, 'vvv', 7);

-- --------------------------------------------------------

--
-- Struktur dari tabel `pma`
--

CREATE TABLE `pma` (
  `pma_id` int(11) NOT NULL,
  `pma_name` varchar(50) NOT NULL,
  `pic_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `pma`
--

INSERT INTO `pma` (`pma_id`, `pma_name`, `pic_id`, `user_id`) VALUES
(2, 'angga', 3, 8),
(5, 'laily nur', 3, 12);

-- --------------------------------------------------------

--
-- Struktur dari tabel `project`
--

CREATE TABLE `project` (
  `project_id` int(11) NOT NULL,
  `project_name` varchar(50) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `project_description` text NOT NULL,
  `project_picture` varchar(100) NOT NULL,
  `pic_id` int(11) NOT NULL,
  `member` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `project`
--

INSERT INTO `project` (`project_id`, `project_name`, `start_date`, `end_date`, `project_description`, `project_picture`, `pic_id`, `member`) VALUES
(53, 'd2313131231', '2023-02-10', '2023-02-19', 'adsasd', '15423029bf71c6fe5d7aa9a088d4f97d.png', 7, 15),
(54, 'nama project', '2023-02-08', '2023-02-28', 'deskripsi project', '3a28ee3950571ccc9c85a31e75597677.png', 3, 13),
(59, 'da', '2023-03-02', '2023-03-24', 'da', 'e702297cf3918f03a9c5e38da5d0c531.jpeg', 3, 15),
(60, 'lnn', '2023-03-02', '2023-03-02', 'hhkj', 'ff5f8c3d733f086e139564f8e76b2d2a.png', 7, 14);

-- --------------------------------------------------------

--
-- Struktur dari tabel `report`
--

CREATE TABLE `report` (
  `report_id` int(11) NOT NULL,
  `report_progress` varchar(100) DEFAULT NULL,
  `ket_progress` varchar(255) NOT NULL,
  `report_nota` varchar(100) NOT NULL,
  `ket_nota` varchar(255) NOT NULL,
  `report_date` date NOT NULL,
  `report_time` time NOT NULL,
  `project_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `report`
--

INSERT INTO `report` (`report_id`, `report_progress`, `ket_progress`, `report_nota`, `ket_nota`, `report_date`, `report_time`, `project_id`) VALUES
(29, 'f347a2994cb4ce3188f0f6d203a306d1.png', 'mengenal', '4b683cbd06550a90b5b5ea4a53fee6b3.jpeg', 'nota', '2023-03-06', '03:52:00', 54);

-- --------------------------------------------------------

--
-- Struktur dari tabel `role`
--

CREATE TABLE `role` (
  `role_id` int(11) NOT NULL,
  `role_name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `role`
--

INSERT INTO `role` (`role_id`, `role_name`) VALUES
(1, 'admin'),
(2, 'engineer'),
(3, 'logistic');

-- --------------------------------------------------------

--
-- Struktur dari tabel `user`
--

CREATE TABLE `user` (
  `user_id` int(11) NOT NULL,
  `user_name` varchar(50) NOT NULL,
  `user_email` varchar(50) NOT NULL,
  `password` varchar(100) NOT NULL,
  `role_id` int(11) NOT NULL,
  `status` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `user`
--

INSERT INTO `user` (`user_id`, `user_name`, `user_email`, `password`, `role_id`, `status`) VALUES
(1, 'admin', 'admin@gmail.com', '21232f297a57a5a743894a0e4a801fc3', 1, 'Aktif'),
(7, 'Arindra', 'arindra@gmail.com', '81dc9bdb52d04dc20036dbd8313ed055', 3, 'Aktif'),
(8, 'angga', 'angga@gmail.com', '81dc9bdb52d04dc20036dbd8313ed055', 2, 'Aktif'),
(12, 'laily', 'laily@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', 1, 'Aktif'),
(13, 'lailynur', 'laily1@gmail.com', '12345', 1, 'Aktif'),
(14, 'a', 'a', '0cc175b9c0f1b6a831c399e269772661', 1, 'Aktif'),
(15, 'b', 'b', '0cc175b9c0f1b6a831c399e269772661', 2, 'Aktif'),
(17, 'c', 'c', 'c', 1, 'Aktif');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `pic`
--
ALTER TABLE `pic`
  ADD PRIMARY KEY (`pic_id`),
  ADD KEY `FK_user` (`user_id`);

--
-- Indeks untuk tabel `pma`
--
ALTER TABLE `pma`
  ADD PRIMARY KEY (`pma_id`),
  ADD KEY `FK_pic` (`pic_id`),
  ADD KEY `FK_userpma` (`user_id`);

--
-- Indeks untuk tabel `project`
--
ALTER TABLE `project`
  ADD PRIMARY KEY (`project_id`),
  ADD KEY `picfk` (`pic_id`);

--
-- Indeks untuk tabel `report`
--
ALTER TABLE `report`
  ADD PRIMARY KEY (`report_id`),
  ADD KEY `FK_project` (`project_id`);

--
-- Indeks untuk tabel `role`
--
ALTER TABLE `role`
  ADD PRIMARY KEY (`role_id`);

--
-- Indeks untuk tabel `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`user_id`),
  ADD KEY `FK_role` (`role_id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `pic`
--
ALTER TABLE `pic`
  MODIFY `pic_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT untuk tabel `pma`
--
ALTER TABLE `pma`
  MODIFY `pma_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT untuk tabel `project`
--
ALTER TABLE `project`
  MODIFY `project_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=61;

--
-- AUTO_INCREMENT untuk tabel `report`
--
ALTER TABLE `report`
  MODIFY `report_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT untuk tabel `role`
--
ALTER TABLE `role`
  MODIFY `role_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `user`
--
ALTER TABLE `user`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `pic`
--
ALTER TABLE `pic`
  ADD CONSTRAINT `FK_user` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `pma`
--
ALTER TABLE `pma`
  ADD CONSTRAINT `FK_pic` FOREIGN KEY (`pic_id`) REFERENCES `pic` (`pic_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_userpma` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `project`
--
ALTER TABLE `project`
  ADD CONSTRAINT `FK_pma` FOREIGN KEY (`pic_id`) REFERENCES `pic` (`pic_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `report`
--
ALTER TABLE `report`
  ADD CONSTRAINT `FK_project` FOREIGN KEY (`project_id`) REFERENCES `project` (`project_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `FK_role` FOREIGN KEY (`role_id`) REFERENCES `role` (`role_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
