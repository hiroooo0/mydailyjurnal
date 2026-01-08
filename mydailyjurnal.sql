-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 18, 2025 at 03:01 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `mydailyjurnal`
--

-- --------------------------------------------------------

--
-- Table structure for table `article`
--

CREATE TABLE `article` (
  `id` int(11) NOT NULL,
  `judul` text NOT NULL,
  `isi` text NOT NULL,
  `gambar` text NOT NULL,
  `tanggal` datetime NOT NULL,
  `username` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `article`
--

INSERT INTO `article` (`id`, `judul`, `isi`, `gambar`, `tanggal`, `username`) VALUES
(1, 'rektor', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Sed, temporibus quaerat doloremque, porro ut, possimus voluptates minus earum debitis quia ea explicabo. Veritatis, commodi qui laborum nesciunt dolor est non ipsa impedit beatae rerum provident at ipsum a nisi harum quos natus deleniti vitae earum iusto autem! Similique, necessitatibus, quasi impedit itaque at porro placeat consequatur, unde hic soluta quos dignissimos obcaecati culpa reiciendis aspernatur! Quibusdam ipsa ad culpa rerum perspiciatis illo aut, et quae maiores iste, nam commodi fugiat vitae quam aperiam? Autem quam quasi expedita delectus obcaecati eos. Blanditiis fugiat qui vero, inventore culpa aspernatur deleniti illo minima.', 'pict2.jpeg', '2025-12-09 09:08:29', 'admin'),
(2, 'gambar 2', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Eaque quisquam, consectetur dolorem, sint numquam unde quos ducimus modi magni vitae necessitatibus fuga soluta eligendi exercitationem velit hic qui maxime atque, voluptas aliquam aperiam illo! Alias expedita consequuntur officiis quod tenetur, quisquam beatae dolor quidem provident maiores adipisci! Corporis, sunt temporibus. Atque magnam laboriosam deserunt ipsa quia est nostrum similique sint nemo excepturi.', 'pict1.jpeg', '2025-12-09 15:50:29', 'admin'),
(3, 'gambar 2', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Vitae obcaecati, rerum voluptates odio quidem ipsum qui pariatur error doloremque excepturi velit voluptas exercitationem dolorem nobis at quasi saepe tempore laudantium fugiat aliquam ratione dignissimos? Animi illum nesciunt reiciendis porro voluptatem alias numquam maiores saepe?', 'pict3.jpeg', '2025-12-09 16:07:16', 'admin'),
(6, 'Slave knight gael', 'Gael dulunya adalah seorang ksatria budak, sebuah ordo ksatria Mayat Hidup yang digunakan sebagai umpan dalam pertempuran paling suram. Bahkan ketika mereka menjadi renta, kulit mereka hangus hitam, tulang mereka bengkok dan pikiran mereka hilang, mereka tidak pernah dibebaskan dari tugas, status terkutuk mereka ditandai oleh tudung merah mereka yang mencolok.', '20251218210113.jpeg', '2025-12-18 21:01:13', 'admin');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` text NOT NULL,
  `foto` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `username`, `password`, `foto`) VALUES
(1, 'admin', 'e10adc3949ba59abbe56e057f20f883e', '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `article`
--
ALTER TABLE `article`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `article`
--
ALTER TABLE `article`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
