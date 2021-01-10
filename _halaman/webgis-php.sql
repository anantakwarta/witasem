-- phpMyAdmin SQL Dump
-- version 5.0.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 09, 2021 at 08:23 PM
-- Server version: 8.0.22
-- PHP Version: 7.2.34

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;


-- --------------------------------------------------------

--
-- Table structure for table `m_kecamatan`
--

CREATE TABLE `m_kecamatan` (
  `id_kecamatan` int NOT NULL,
  `kd_kecamatan` varchar(10) NOT NULL,
  `nm_kecamatan` varchar(30) NOT NULL,
  `geojson_kecamatan` varchar(30) NOT NULL,
  `warna_kecamatan` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `m_kecamatan`
--

INSERT INTO `m_kecamatan` (`id_kecamatan`, `kd_kecamatan`, `nm_kecamatan`, `geojson_kecamatan`, `warna_kecamatan`) VALUES
(1, '33.74.12', 'Gunungpati', '80090121040044.geojson', '#2c6ed8'),
(2, '33.74.11', 'Banyumanik', '27090121043148.geojson', '#c6de12'),
(3, '33.74.08', 'Candisari', '57090121043217.geojson', '#ca1212'),
(4, '33.74.09', 'Gajahmungkur', '35090121043252.geojson', '#0bdce0'),
(5, '33.74.04', 'Gayamsari', '97090121043323.geojson', '#e45b11'),
(6, '33.74.05', 'Genuk', '96090121043357.geojson', '#e00bbc'),
(7, '33.74.14', 'Mijen', '87090121043435.geojson', '#27dd4b'),
(8, '33.74.15', 'Ngaliyan', '32090121043515.geojson', '#acee11'),
(9, '33.74.06', 'Pedurungan', '36090121043555.geojson', '#42790c'),
(10, '33.74.13', 'Semarang Barat', '18090121043729.geojson', '#bd5d14'),
(11, '33.74.07', 'Semarang Selatan', '55090121043806.geojson', '#7b7818'),
(12, '33.74.01', 'Semarang Tengah', '23090121043842.geojson', '#d18585'),
(13, '33.74.03', 'Semarang Timur', '5090121043918.geojson', '#ee68ea'),
(14, '33.74.02', 'Semarang Utara', '50090121043957.geojson', '#0400ff'),
(15, '33.74.10', 'Tembalang', '14090121044051.geojson', '#0de77e'),
(16, '33.74.16', 'Tugu', '23090121044140.geojson', '#fd742b');

-- --------------------------------------------------------

--
-- Table structure for table `pengguna`
--

CREATE TABLE `pengguna` (
  `id_pengguna` int NOT NULL,
  `nm_pengguna` varchar(20) NOT NULL,
  `kt_sandi` varchar(150) NOT NULL,
  `level` enum('Admin','User') NOT NULL DEFAULT 'User'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `pengguna`
--

INSERT INTO `pengguna` (`id_pengguna`, `nm_pengguna`, `kt_sandi`, `level`) VALUES
(1, 'admin', '$2y$10$oNX.X8jgLhNclHBeI8ytT.1vODlml8.AN1Ieb.rSIChhCa1e7cS0S', 'Admin'),
(2, 'user', '$2y$10$oNX.X8jgLhNclHBeI8ytT.1vODlml8.AN1Ieb.rSIChhCa1e7cS0S', 'User');

-- --------------------------------------------------------

--
-- Table structure for table `t_wisata`
--

CREATE TABLE `t_wisata` (
  `id_wisata` int NOT NULL,
  `nama_wisata` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `id_kecamatan` int NOT NULL,
  `lokasi` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `lat` float(9,6) NOT NULL,
  `lng` float(9,6) NOT NULL,
  `deskripsi` text COLLATE utf8mb4_general_ci NOT NULL,
  `img` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `t_wisata`
--

INSERT INTO `t_wisata` (`id_wisata`, `nama_wisata`, `id_kecamatan`, `lokasi`, `lat`, `lng`, `deskripsi`, `img`) VALUES
(1, 'Desa Wisata Lembah Kalipancur', 8, 'Jl. Raya Kalipancur Manyaran, Kalipancur, Kec. Ngaliyan, Kota Semarang, Jawa Tengah 50183', -7.020152, 110.375397, 'Tempat Wisata di Semarang ini bisa dikatakan tempat wisata yang mulai tenar atau hits. Mengingat tempat ini merupakan tempat wisata yang memiliki konsep pedesaan. Dengan berbagai macam kelengkapan hiburan yang telah di sediakan untuk menambah kenyamanan Anda. Beberapa fasilitas tersebut seperti kolam renang, kandang rusa, sepeda air dan lain sebagainya.', '30090121053824.jpg'),
(2, 'Masjid Kapal Semarang', 8, 'Jl. Kyai Padak, Podorejo, Kec. Ngaliyan, Kota Semarang, Jawa Tengah 50214', -7.018544, 110.293777, 'Masjid Kapal Semarang berada di Kecamatan Ngaliyan, Semarang. Bentuknya menyerupai kapal yang memiliki warna coklat kekuningan.\r\nUntuk masuk ke dalamnya harga tiket hanya Rp 3.000 saja. Masjid ini mempunyai 4 lantai dengan fungsi yang berbeda-beda. Lantai pertama untuk acara pertemuan, lantai kedua dan ketiga untuk menjalankan kewajiban ibadah, dan lantai terakhir untuk melihat pemandangan sekitar dari atas.', '95090121065645.jpg');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `m_kecamatan`
--
ALTER TABLE `m_kecamatan`
  ADD PRIMARY KEY (`id_kecamatan`);

--
-- Indexes for table `pengguna`
--
ALTER TABLE `pengguna`
  ADD PRIMARY KEY (`id_pengguna`);

--
-- Indexes for table `t_wisata`
--
ALTER TABLE `t_wisata`
  ADD PRIMARY KEY (`id_wisata`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `m_kecamatan`
--
ALTER TABLE `m_kecamatan`
  MODIFY `id_kecamatan` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `pengguna`
--
ALTER TABLE `pengguna`
  MODIFY `id_pengguna` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `t_wisata`
--
ALTER TABLE `t_wisata`
  MODIFY `id_wisata` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
