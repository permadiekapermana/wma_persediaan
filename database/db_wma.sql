-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 08, 2019 at 08:46 AM
-- Server version: 10.1.36-MariaDB
-- PHP Version: 5.6.38

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_wma`
--

-- --------------------------------------------------------

--
-- Table structure for table `kategori`
--

CREATE TABLE `kategori` (
  `id_kategori` int(5) NOT NULL,
  `nama_kategori` varchar(100) COLLATE latin1_general_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

--
-- Dumping data for table `kategori`
--

INSERT INTO `kategori` (`id_kategori`, `nama_kategori`) VALUES
(4, 'KAMPAS REM'),
(3, 'OLI MESIN'),
(5, 'FILTER OLI');

-- --------------------------------------------------------

--
-- Table structure for table `penerimaan`
--

CREATE TABLE `penerimaan` (
  `no_penerimaan` varchar(10) NOT NULL,
  `tgl_penerimaan` date NOT NULL,
  `id_produk` int(10) NOT NULL,
  `no_suplier` varchar(15) NOT NULL,
  `no_faktur` varchar(15) NOT NULL,
  `jumlah` int(10) NOT NULL,
  `petugas` varchar(35) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `penerimaan`
--

INSERT INTO `penerimaan` (`no_penerimaan`, `tgl_penerimaan`, `id_produk`, `no_suplier`, `no_faktur`, `jumlah`, `petugas`) VALUES
('PY.001', '2015-10-07', 3, 'SY.001', 'gdhgd', 21, 'Administrator');

--
-- Triggers `penerimaan`
--
DELIMITER $$
CREATE TRIGGER `del_penerimaan` BEFORE DELETE ON `penerimaan` FOR EACH ROW BEGIN
     UPDATE produk SET stok= stok- OLD.jumlah
     WHERE id_produk= OLD.id_produk;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `in_penerimaan` AFTER INSERT ON `penerimaan` FOR EACH ROW BEGIN
UPDATE produk SET stok= stok+ NEW.jumlah WHERE id_produk= NEW.id_produk;

END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `up_penerimaan` AFTER UPDATE ON `penerimaan` FOR EACH ROW BEGIN
     UPDATE produk SET stok= stok + NEW.jumlah - OLD.jumlah
     WHERE id_produk= OLD.id_produk;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `penjualan`
--

CREATE TABLE `penjualan` (
  `no_penjualan` varchar(10) NOT NULL,
  `tgl_penjualan` date NOT NULL,
  `id_produk` int(10) NOT NULL,
  `jml_penjualan` varchar(50) NOT NULL,
  `tot_jual` int(10) NOT NULL,
  `petugas` varchar(35) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `penjualan`
--

INSERT INTO `penjualan` (`no_penjualan`, `tgl_penjualan`, `id_produk`, `jml_penjualan`, `tot_jual`, `petugas`) VALUES
('AY002', '2019-11-08', 1, '3', 285000, 'Irfan Saputra');

-- --------------------------------------------------------

--
-- Table structure for table `produk`
--

CREATE TABLE `produk` (
  `id_produk` int(5) NOT NULL,
  `id_kategori` int(5) NOT NULL,
  `nama_produk` varchar(100) COLLATE latin1_general_ci NOT NULL,
  `produk_seo` varchar(100) COLLATE latin1_general_ci NOT NULL,
  `deskripsi` text COLLATE latin1_general_ci NOT NULL,
  `harga` int(20) NOT NULL,
  `stok` int(5) NOT NULL,
  `tgl_masuk` date NOT NULL,
  `gambar` varchar(100) COLLATE latin1_general_ci NOT NULL,
  `dibeli` int(5) NOT NULL DEFAULT '1'
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

--
-- Dumping data for table `produk`
--

INSERT INTO `produk` (`id_produk`, `id_kategori`, `nama_produk`, `produk_seo`, `deskripsi`, `harga`, `stok`, `tgl_masuk`, `gambar`, `dibeli`) VALUES
(1, 3, 'TMO 15W-40 CI-4', 'oil,tmo', 'SYNTHETIC DIESEL', 95000, 0, '2015-10-04', '66Jellyfish.jpg', 1),
(2, 3, 'TMO 10W-40SN', 'kulkas-lg', 'SYNTHETIC BENSIN', 99500, 0, '2015-10-04', '30Desert.jpg', 1),
(4, 4, 'BRAKE PAD FORTUNER', 'brake-pad', 'FORTUNER', 693000, 0, '2019-11-07', '8', 1),
(5, 4, 'BRAKE PAD COROLLA ALTIS', 'brake-pad', 'COROLLA ALTIS', 829000, 0, '2019-11-07', '96', 1),
(6, 4, 'BRAKE PAD YARIS / VIOS', 'brake-pad-yaris--vios', 'YARIS / VIOS', 870000, 0, '2019-11-07', '3', 1),
(7, 5, 'FILTER OLI AGYA/CALYA/AVANZA/RUSH', 'filter-oli-agyacalyaavanzarush', 'AGYA/CALYA/AVANZA/RUSH', 24974, 0, '2019-11-07', '67', 1),
(8, 5, 'FILTER OLI SIENTA/YARIS/VIOS/LIMO', 'filter-oli-sientayarisvioslimo', 'SIENTA/YARIS/VIOS/LIMO', 76000, 0, '2019-11-07', '41', 1),
(9, 3, 'TMO FULL 0W-20 SN', 'tmo-full-0w20-sn', 'FULL SYNTHETIC BENSIN', 190000, 0, '2019-11-07', '18', 1),
(10, 3, 'TMO FULL 5W-20 SN', 'tmo-full-5w20-sn', 'FULL SYNTHETIC BENSIN', 163500, 0, '2019-11-07', '3', 1),
(11, 3, 'TMO DSL 5W30 A5B5', 'tmo-dsl-5w30-a5b5', 'FULL SYNTHETIC DIESEL', 165000, 0, '2019-11-07', '43', 1),
(12, 5, 'FILTER OLI FORTUNER/HILUX/HIACE', 'filter-oli-fortunerhiluxhiace', 'FORTUNER/HILUX/HIACE', 79000, 0, '2019-11-07', '47', 1);

-- --------------------------------------------------------

--
-- Table structure for table `suplier`
--

CREATE TABLE `suplier` (
  `no_suplier` varchar(15) NOT NULL,
  `nm_suplier` varchar(35) NOT NULL,
  `alamat` varchar(35) NOT NULL,
  `no_telp` varchar(35) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `suplier`
--

INSERT INTO `suplier` (`no_suplier`, `nm_suplier`, `alamat`, `no_telp`) VALUES
('SY.001', 'PT Toyota Astra Motor', 'Jalan Gaya Motor Selatan No. 5, Tan', '(021) 6512116'),
('', 'KALYANAMITTA', 'Jl. Pelajar Pejuang 45, No.39 - 41 ', '022 7322588');

-- --------------------------------------------------------

--
-- Table structure for table `temp`
--

CREATE TABLE `temp` (
  `no_penjualan` varchar(15) NOT NULL,
  `jml_penjualan` int(15) NOT NULL,
  `skor` int(15) NOT NULL,
  `bobot` int(15) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `temp_produk`
--

CREATE TABLE `temp_produk` (
  `id_produk` int(6) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `username` varchar(50) COLLATE latin1_general_ci NOT NULL,
  `password` varchar(50) COLLATE latin1_general_ci NOT NULL,
  `nama_lengkap` varchar(100) COLLATE latin1_general_ci NOT NULL,
  `email` varchar(100) COLLATE latin1_general_ci NOT NULL,
  `no_telp` varchar(20) COLLATE latin1_general_ci NOT NULL,
  `level` varchar(20) COLLATE latin1_general_ci NOT NULL DEFAULT 'user',
  `blokir` enum('Y','N') COLLATE latin1_general_ci NOT NULL DEFAULT 'N',
  `id_session` varchar(100) COLLATE latin1_general_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`username`, `password`, `nama_lengkap`, `email`, `no_telp`, `level`, `blokir`, `id_session`) VALUES
('admin', '21232f297a57a5a743894a0e4a801fc3', 'Irfan Saputra', 'irfansaput@gmail.com', '08238923848', 'admin', 'N', 'orji2mdbo8h10h2hev4u9gmqt1'),
('ridwan123', '21232f297a57a5a743894a0e4a801fc3', 'Miftachur Ridwan', 'miftachur.ridwan@tso.astra.co.id', '089660640035', 'partman', 'N', '21232f297a57a5a743894a0e4a801fc3'),
('joko123', '21232f297a57a5a743894a0e4a801fc3', 'Joko Purwanto', 'joko.purwanto@tso.astra.co.id', '08159914370', 'kabeng', 'N', 'k98mg73p5t0p43dcrlbfbpcr46');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `kategori`
--
ALTER TABLE `kategori`
  ADD PRIMARY KEY (`id_kategori`);

--
-- Indexes for table `penerimaan`
--
ALTER TABLE `penerimaan`
  ADD PRIMARY KEY (`no_penerimaan`);

--
-- Indexes for table `penjualan`
--
ALTER TABLE `penjualan`
  ADD PRIMARY KEY (`no_penjualan`);

--
-- Indexes for table `produk`
--
ALTER TABLE `produk`
  ADD PRIMARY KEY (`id_produk`);

--
-- Indexes for table `suplier`
--
ALTER TABLE `suplier`
  ADD PRIMARY KEY (`no_suplier`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `kategori`
--
ALTER TABLE `kategori`
  MODIFY `id_kategori` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `produk`
--
ALTER TABLE `produk`
  MODIFY `id_produk` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
