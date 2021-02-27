-- phpMyAdmin SQL Dump
-- version 4.8.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 27, 2021 at 03:22 PM
-- Server version: 10.1.34-MariaDB
-- PHP Version: 7.0.31

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `wifionline`
--

-- --------------------------------------------------------

--
-- Table structure for table `notif_topup`
--

CREATE TABLE `notif_topup` (
  `id` int(11) NOT NULL,
  `token` varchar(20) NOT NULL,
  `id_user` int(11) NOT NULL,
  `tanggal` date NOT NULL,
  `metod` varchar(20) NOT NULL,
  `nominal` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `payment`
--

CREATE TABLE `payment` (
  `id` int(11) NOT NULL,
  `pay_name` varchar(25) NOT NULL,
  `pay_no` varchar(25) NOT NULL,
  `pay_ket` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `payment`
--

INSERT INTO `payment` (`id`, `pay_name`, `pay_no`, `pay_ket`) VALUES
(4, 'uang tunai', '087886628289', 'SILAHKAN DATANG KE TEMPAT PEMBAYARAN, perlihatkan tiket proses.'),
(5, 'OVO', '087886628289', 'silahkan lakukan pengiriman dana a/n MUNZI SETIAWAN, kirim bukti transaksi whatsapp 087886628289'),
(6, 'BANK BRI', '483501030593533', 'a/n MUNZI SETIAWAN. wajib mengirim bukti tranfer ke whatsapp 087886628289');

-- --------------------------------------------------------

--
-- Table structure for table `p_wifi`
--

CREATE TABLE `p_wifi` (
  `id` int(11) NOT NULL,
  `wifi_name` varchar(25) NOT NULL,
  `durasi` varchar(10) NOT NULL,
  `aktif` varchar(10) NOT NULL,
  `harga_jual` int(11) NOT NULL,
  `harga_beli` int(11) NOT NULL,
  `keterangan` varchar(30) NOT NULL,
  `profileApi` varchar(30) NOT NULL,
  `internetApi` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `p_wifi`
--

INSERT INTO `p_wifi` (`id`, `wifi_name`, `durasi`, `aktif`, `harga_jual`, `harga_beli`, `keterangan`, `profileApi`, `internetApi`) VALUES
(101002222, 'vcr_2k', '12 JAM', '3 JAM', 2000, 1700, '087886628289', '2000', '00:03:00'),
(101003333, 'vcr_3k', '12 JAM', '5 JAM', 3000, 2500, '087886628289', '3000', '00:05:00'),
(101005555, 'vcr_5k', '24 JAM', '12 JAM', 5000, 3500, '087886628289', '5000', '00:12:00');

-- --------------------------------------------------------

--
-- Table structure for table `send_saldo`
--

CREATE TABLE `send_saldo` (
  `tx_tiket` varchar(20) NOT NULL,
  `tanggal` date NOT NULL,
  `tx_from` varchar(20) NOT NULL,
  `tx_to` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `transaksi_wifi`
--

CREATE TABLE `transaksi_wifi` (
  `id` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `tanggal` date NOT NULL,
  `nama_wifi` varchar(25) NOT NULL,
  `kode` varchar(10) NOT NULL,
  `harga` int(11) NOT NULL,
  `harga_jual` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `trx_saldo_user`
--

CREATE TABLE `trx_saldo_user` (
  `id` int(11) NOT NULL,
  `tanggal` date NOT NULL,
  `username_send` varchar(50) NOT NULL,
  `username_received` varchar(50) NOT NULL,
  `rec_telepon` varchar(25) NOT NULL,
  `nominal` varchar(50) NOT NULL,
  `fee` int(11) NOT NULL,
  `total` int(11) NOT NULL,
  `status` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tx_record`
--

CREATE TABLE `tx_record` (
  `id` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `token` varchar(10) NOT NULL,
  `payment` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `user_saldo`
--

CREATE TABLE `user_saldo` (
  `id_user` int(11) NOT NULL,
  `nominal` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user_saldo`
--

INSERT INTO `user_saldo` (`id_user`, `nominal`) VALUES
(2021180000, 2008800),
(2021180001, 101300),
(2021180002, 44800),
(2021180004, 50000),
(2021180005, 45800);

-- --------------------------------------------------------

--
-- Table structure for table `user_wifi`
--

CREATE TABLE `user_wifi` (
  `id` int(11) NOT NULL,
  `level` varchar(25) NOT NULL,
  `username` varchar(25) NOT NULL,
  `password` text NOT NULL,
  `email` varchar(50) NOT NULL,
  `telepon` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user_wifi`
--

INSERT INTO `user_wifi` (`id`, `level`, `username`, `password`, `email`, `telepon`) VALUES
(2021180000, 'master', 'devmaker-id', '$2y$10$mROm22vfJ/QuupczpD8QEedOj7cKOlfAewU3Um7bGie51y3fgwUSy', 'admin@bc24.id', '087886628289'),
(2021180001, 'gold', 'dika', '$2y$10$ZPmhMAOuMFYAneU.ymCL0et2ZwydDwiviTfoBroNNuPSwCaD33QZK', 'dika@bc24.id', '087886628233'),
(2021180002, 'member', 'sadam husain', '$2y$10$ZPmhMAOuMFYAneU.ymCL0et2ZwydDwiviTfoBroNNuPSwCaD33QZK', 'sadam@bc24.id', '087886628211'),
(2021180004, 'member', 'pecang', '$2y$10$DpFf/3NIa.kxYKdv6SBVrezA4/WBNv5ler4mdwqzSRpZFzOh6Nt4O', 'pecang@admin.com', '087886628123'),
(2021180005, 'member', 'diki', '$2y$10$xLfFiWSfXik/Y.vU3KFDm.VxHJ4EEdoM2K9hkCBsOdPVXCX4DDhme', 'diki@bc24.id', '087886621234');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `notif_topup`
--
ALTER TABLE `notif_topup`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `payment`
--
ALTER TABLE `payment`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `p_wifi`
--
ALTER TABLE `p_wifi`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `transaksi_wifi`
--
ALTER TABLE `transaksi_wifi`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `trx_saldo_user`
--
ALTER TABLE `trx_saldo_user`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tx_record`
--
ALTER TABLE `tx_record`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_wifi`
--
ALTER TABLE `user_wifi`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `notif_topup`
--
ALTER TABLE `notif_topup`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `payment`
--
ALTER TABLE `payment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `p_wifi`
--
ALTER TABLE `p_wifi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=101005556;

--
-- AUTO_INCREMENT for table `transaksi_wifi`
--
ALTER TABLE `transaksi_wifi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `trx_saldo_user`
--
ALTER TABLE `trx_saldo_user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tx_record`
--
ALTER TABLE `tx_record`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user_wifi`
--
ALTER TABLE `user_wifi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2021180006;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
