-- phpMyAdmin SQL Dump
-- version 4.8.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 15, 2019 at 05:39 PM
-- Server version: 10.1.37-MariaDB
-- PHP Version: 5.6.39

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
  `id_kategori` varchar(7) COLLATE latin1_general_ci NOT NULL,
  `nama_kategori` varchar(100) COLLATE latin1_general_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

--
-- Dumping data for table `kategori`
--

INSERT INTO `kategori` (`id_kategori`, `nama_kategori`) VALUES
('KAT.001', 'OLI MESIN'),
('KAT.002', 'KAMPAS REM'),
('KAT.003', 'FILTER OLI');

-- --------------------------------------------------------

--
-- Table structure for table `level`
--

CREATE TABLE `level` (
  `id_level` varchar(7) NOT NULL,
  `level` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `level`
--

INSERT INTO `level` (`id_level`, `level`) VALUES
('LVL.001', 'Admin'),
('LVL.002', 'Partman'),
('LVL.003', 'Kepala Bengkel');

-- --------------------------------------------------------

--
-- Table structure for table `penerimaan`
--

CREATE TABLE `penerimaan` (
  `id_penerimaan` varchar(10) NOT NULL,
  `tgl_penerimaan` date NOT NULL,
  `id_produk` varchar(7) NOT NULL,
  `id_suplier` varchar(7) NOT NULL,
  `no_faktur` varchar(7) NOT NULL,
  `jumlah` int(10) NOT NULL,
  `username` varchar(50) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

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
  `id_penjualan` varchar(7) NOT NULL,
  `tgl_penjualan` date NOT NULL,
  `id_produk` varchar(7) NOT NULL,
  `jml_penjualan` varchar(50) NOT NULL,
  `tot_jual` int(10) NOT NULL,
  `username` varchar(50) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `penjualan`
--

INSERT INTO `penjualan` (`id_penjualan`, `tgl_penjualan`, `id_produk`, `jml_penjualan`, `tot_jual`, `username`) VALUES
('PNJ.001', '2019-06-30', 'PRO.001', '206', 19570000, 'admin'),
('PNJ.002', '2019-07-31', 'PRO.001', '216', 20520000, 'admin'),
('PNJ.003', '2019-08-31', 'PRO.001', '216', 20520000, 'admin'),
('PNJ.004', '2019-09-30', 'PRO.001', '222', 21090000, 'admin'),
('PNJ.005', '2019-10-31', 'PRO.001', '221', 20995000, 'admin');

-- --------------------------------------------------------

--
-- Table structure for table `produk`
--

CREATE TABLE `produk` (
  `id_produk` varchar(7) COLLATE latin1_general_ci NOT NULL,
  `id_kategori` varchar(7) COLLATE latin1_general_ci NOT NULL,
  `nama_produk` varchar(100) COLLATE latin1_general_ci NOT NULL,
  `produk_seo` varchar(100) COLLATE latin1_general_ci NOT NULL,
  `deskripsi` text COLLATE latin1_general_ci NOT NULL,
  `harga` int(20) NOT NULL,
  `stok` int(5) NOT NULL,
  `tgl_masuk` date NOT NULL,
  `dibeli` int(5) NOT NULL DEFAULT '1'
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

--
-- Dumping data for table `produk`
--

INSERT INTO `produk` (`id_produk`, `id_kategori`, `nama_produk`, `produk_seo`, `deskripsi`, `harga`, `stok`, `tgl_masuk`, `dibeli`) VALUES
('PRO.001', 'KAT.001', 'TMO 15W-40 CI-4', 'oil,tmo', 'SYNTHETIC DIESEL', 95000, 2000, '2015-10-04', 1),
('PRO.002', 'KAT.001', 'TMO 10W-40SN', 'kulkas-lg', 'SYNTHETIC BENSIN', 99500, 200, '2015-10-04', 1),
('PRO.003', 'KAT.002', 'BRAKE PAD FORTUNER', 'brake-pad', 'FORTUNER', 693000, 200, '2019-11-07', 1),
('PRO.004', 'KAT.002', 'BRAKE PAD COROLLA ALTIS', 'brake-pad', 'COROLLA ALTIS', 829000, 200, '2019-11-07', 1),
('PRO.005', 'KAT.002', 'BRAKE PAD YARIS / VIOS', 'brake-pad-yaris--vios', 'YARIS / VIOS', 870000, 200, '2019-11-07', 1),
('PRO.006', 'KAT.003', 'FILTER OLI AGYA/CALYA/AVANZA/RUSH', 'filter-oli-agyacalyaavanzarush', 'AGYA/CALYA/AVANZA/RUSH', 24974, 200, '2019-11-07', 1),
('PRO.007', 'KAT.003', 'FILTER OLI SIENTA/YARIS/VIOS/LIMO', 'filter-oli-sientayarisvioslimo', 'SIENTA/YARIS/VIOS/LIMO', 76000, 200, '2019-11-07', 1),
('PRO.008', 'KAT.001', 'TMO FULL 0W-20 SN', 'tmo-full-0w20-sn', 'FULL SYNTHETIC BENSIN', 190000, 200, '2019-11-07', 1),
('PRO.009', 'KAT.001', 'TMO FULL 5W-20 SN', 'tmo-full-5w20-sn', 'FULL SYNTHETIC BENSIN', 163500, 200, '2019-11-07', 1),
('PRO.010', 'KAT.001', 'TMO DSL 5W30 A5B5', 'tmo-dsl-5w30-a5b5', 'FULL SYNTHETIC DIESEL', 165000, 200, '2019-11-07', 1),
('PRO.011', 'KAT.003', 'FILTER OLI FORTUNER/HILUX/HIACE', 'filter-oli-fortunerhiluxhiace', 'FORTUNER/HILUX/HIACE', 79000, 200, '2019-11-07', 1);

-- --------------------------------------------------------

--
-- Table structure for table `suplier`
--

CREATE TABLE `suplier` (
  `id_suplier` varchar(7) NOT NULL,
  `nm_suplier` varchar(35) NOT NULL,
  `alamat` varchar(35) NOT NULL,
  `no_telp` varchar(35) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `suplier`
--

INSERT INTO `suplier` (`id_suplier`, `nm_suplier`, `alamat`, `no_telp`) VALUES
('SPY.001', 'PT Toyota Astra Motor', 'Jalan Gaya Motor Selatan No. 5, Tan', '(021) 6512116'),
('SPY.002', 'KALYANAMITTA', 'Jl. Pelajar Pejuang 45, No.39 - 41 ', '022 7322588');

-- --------------------------------------------------------

--
-- Table structure for table `temp`
--

CREATE TABLE `temp` (
  `id_penjualan` varchar(15) NOT NULL,
  `jml_penjualan` int(15) NOT NULL,
  `skor` int(15) NOT NULL,
  `bobot` int(15) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `temp`
--

INSERT INTO `temp` (`id_penjualan`, `jml_penjualan`, `skor`, `bobot`) VALUES
('PNJ.001', 206, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `temp_produk`
--

CREATE TABLE `temp_produk` (
  `id_produk` varchar(7) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `temp_produk`
--

INSERT INTO `temp_produk` (`id_produk`) VALUES
('PRO.001'),
('PRO.001'),
('PRO.001'),
(''),
(''),
(''),
(''),
(''),
(''),
(''),
(''),
(''),
('');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `username` varchar(50) COLLATE latin1_general_ci NOT NULL,
  `password` varchar(32) COLLATE latin1_general_ci NOT NULL,
  `nama_lengkap` varchar(100) COLLATE latin1_general_ci NOT NULL,
  `email` varchar(100) COLLATE latin1_general_ci NOT NULL,
  `no_telp` varchar(20) COLLATE latin1_general_ci NOT NULL,
  `id_level` varchar(7) COLLATE latin1_general_ci NOT NULL DEFAULT 'user',
  `blokir` char(1) COLLATE latin1_general_ci DEFAULT NULL,
  `id_session` varchar(100) COLLATE latin1_general_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`username`, `password`, `nama_lengkap`, `email`, `no_telp`, `id_level`, `blokir`, `id_session`) VALUES
('admin', '21232f297a57a5a743894a0e4a801fc3', 'Irfan Saputra', 'irfansaput@gmail.com', '08238923848', 'LVL.001', 'N', 'rj23g9gi926u2icna5rujnv3v4'),
('ridwan123', '21232f297a57a5a743894a0e4a801fc3', 'Miftachur Ridwan', 'miftachur.ridwan@tso.astra.co.id', '089660640035', 'LVL.002', 'N', '21232f297a57a5a743894a0e4a801fc3'),
('joko123', '21232f297a57a5a743894a0e4a801fc3', 'Joko Purwanto', 'joko.purwanto@tso.astra.co.id', '08159914370', 'LVL.003', 'N', 'k98mg73p5t0p43dcrlbfbpcr46');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `kategori`
--
ALTER TABLE `kategori`
  ADD PRIMARY KEY (`id_kategori`);

--
-- Indexes for table `level`
--
ALTER TABLE `level`
  ADD PRIMARY KEY (`id_level`);

--
-- Indexes for table `penerimaan`
--
ALTER TABLE `penerimaan`
  ADD PRIMARY KEY (`id_penerimaan`);

--
-- Indexes for table `penjualan`
--
ALTER TABLE `penjualan`
  ADD PRIMARY KEY (`id_penjualan`);

--
-- Indexes for table `produk`
--
ALTER TABLE `produk`
  ADD PRIMARY KEY (`id_produk`);

--
-- Indexes for table `suplier`
--
ALTER TABLE `suplier`
  ADD PRIMARY KEY (`id_suplier`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`username`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
