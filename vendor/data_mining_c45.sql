-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 23 Jul 2023 pada 05.01
-- Versi server: 10.4.25-MariaDB
-- Versi PHP: 7.4.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `data_mining_c45`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `atribut`
--

CREATE TABLE `atribut` (
  `id_atribut` int(11) NOT NULL,
  `atribut` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `atribut`
--

INSERT INTO `atribut` (`id_atribut`, `atribut`) VALUES
(1, 'Jenis_Kelamin'),
(2, 'Predikat_IPK'),
(3, 'Predikat_SPA'),
(4, 'Prediksi');

-- --------------------------------------------------------

--
-- Struktur dari tabel `atribut_latih`
--

CREATE TABLE `atribut_latih` (
  `id_atribut_latih` int(11) NOT NULL,
  `id_latih` int(11) NOT NULL,
  `id_atribut_sub` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `atribut_latih`
--

INSERT INTO `atribut_latih` (`id_atribut_latih`, `id_latih`, `id_atribut_sub`) VALUES
(27, 2, 1),
(28, 2, 5),
(29, 2, 10),
(30, 2, 12),
(31, 3, 1),
(32, 3, 6),
(33, 3, 11),
(34, 3, 13),
(35, 4, 1),
(36, 4, 5),
(37, 4, 9),
(38, 4, 12),
(39, 5, 1),
(40, 5, 5),
(41, 5, 11),
(42, 5, 13),
(43, 6, 2),
(44, 6, 4),
(45, 6, 11),
(46, 6, 13),
(47, 7, 1),
(48, 7, 4),
(49, 7, 11),
(50, 7, 13),
(51, 8, 1),
(52, 8, 6),
(53, 8, 11),
(54, 8, 12),
(55, 9, 1),
(56, 9, 6),
(57, 9, 11),
(58, 9, 12),
(59, 10, 2),
(60, 10, 6),
(61, 10, 10),
(62, 10, 12),
(65, 1, 2),
(66, 1, 5),
(67, 1, 9),
(68, 1, 12),
(69, 11, 2),
(70, 11, 6),
(71, 11, 11),
(72, 11, 13),
(73, 12, 1),
(74, 12, 6),
(75, 12, 9),
(76, 12, 12),
(77, 13, 2),
(78, 13, 6),
(79, 13, 8),
(80, 13, 12),
(81, 14, 2),
(82, 14, 7),
(83, 14, 9),
(84, 14, 12),
(85, 15, 1),
(86, 15, 6),
(87, 15, 9),
(88, 15, 12),
(89, 16, 1),
(90, 16, 5),
(91, 16, 10),
(92, 16, 12),
(93, 17, 2),
(94, 17, 6),
(95, 17, 9),
(96, 17, 12),
(97, 18, 2),
(98, 18, 6),
(99, 18, 10),
(100, 18, 12),
(101, 19, 2),
(102, 19, 5),
(103, 19, 10),
(104, 19, 12);

-- --------------------------------------------------------

--
-- Struktur dari tabel `atribut_sub`
--

CREATE TABLE `atribut_sub` (
  `id_atribut_sub` int(11) NOT NULL,
  `id_atribut` int(11) NOT NULL,
  `atribut_sub` varchar(75) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `atribut_sub`
--

INSERT INTO `atribut_sub` (`id_atribut_sub`, `id_atribut`, `atribut_sub`) VALUES
(1, 1, 'Laki-Laki'),
(2, 1, 'Perempuan'),
(4, 2, 'Cukup'),
(5, 2, 'Memuaskan'),
(6, 2, 'Sangat Memuaskan'),
(7, 2, 'Dengan Pujian'),
(8, 3, 'D'),
(9, 3, 'C'),
(10, 3, 'B'),
(11, 3, 'A'),
(12, 4, 'Lulus Tepat'),
(13, 4, 'Tidak Tepat');

-- --------------------------------------------------------

--
-- Struktur dari tabel `atribut_testing`
--

CREATE TABLE `atribut_testing` (
  `id_atribut_testing` int(11) NOT NULL,
  `id_testing` int(11) NOT NULL,
  `id_atribut_sub` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `atribut_testing`
--

INSERT INTO `atribut_testing` (`id_atribut_testing`, `id_testing`, `id_atribut_sub`) VALUES
(19, 2, 1),
(20, 2, 5),
(21, 2, 11),
(23, 3, 1),
(24, 3, 5),
(25, 3, 10),
(27, 4, 1),
(28, 4, 6),
(29, 4, 9),
(31, 5, 2),
(32, 5, 6),
(33, 5, 10),
(35, 1, 1),
(36, 1, 5),
(37, 1, 8);

-- --------------------------------------------------------

--
-- Struktur dari tabel `data_latih`
--

CREATE TABLE `data_latih` (
  `id_latih` int(11) NOT NULL,
  `nim` varchar(20) NOT NULL,
  `nama` varchar(75) NOT NULL,
  `nilai_rata_rata_ipk` char(10) NOT NULL,
  `nilai_rata_rata_spa` char(10) NOT NULL,
  `nilai_rata_rata` char(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `data_latih`
--

INSERT INTO `data_latih` (`id_latih`, `nim`, `nama`, `nilai_rata_rata_ipk`, `nilai_rata_rata_spa`, `nilai_rata_rata`) VALUES
(1, '22117055', 'Wemci S.P.H Kaynara', '1.98', '2.5', '2.292'),
(2, '22117114', 'Anicetus Robertus Mangu Lewerang', '1.965', '2.41666666', '2.236'),
(3, '22119001', 'APRIANUS S. OBA DEDE', '3.395', '0', '1.358'),
(4, '22117111', 'Oktavianus Gili Dhou', '1.9925', '3.25', '2.747'),
(5, '22117104', 'Maternus Dovanus Wake', '1.875', '0.66666666', '1.15'),
(6, '22120047', 'Rani Mersianus Lalang', '0.785', '0', '0.314'),
(7, '22120055', 'Yohanes Putradius Naibina', '0.3', '0', '0.12'),
(8, '22120053', 'Godelfridus Avelino Bere', '2.7175', '1', '1.687'),
(9, '22120044', 'Anselmus Farianus Jensen', '2.87', '1.41666666', '1.998'),
(10, '22120030', 'Chatarine Elisa Pedan', '2.8775', '1.75', '2.201'),
(11, '22120036', 'Melania Charlydino Paga', '2.655', '0.58333333', '1.412'),
(12, '22119068', 'ADRIANUS GAE BONGE', '2.7375', '3.41666666', '3.145'),
(13, '22119070', 'STELLA MALELAK', '3.22', '3.75', '3.538'),
(14, '22117002', 'Maria Jemiana Kewa Mudaj', '3.6675', '3.04166666', '3.292'),
(15, '22119060', 'CHRISTAL FREDERIK ESAMI HANAS ELIMANAFE', '3.475', '2.875', '3.115'),
(16, '22116003', 'Derrysto Rayfaldo Niab', '1.7325', '2.16666666', '1.993'),
(17, '22116009', 'Vanya Elisabeth Muskanan', '2.99', '2.5', '2.696'),
(18, '22116027', 'CHRISTINE AQUILINA LAKE', '2.985', '2.16666666', '2.494'),
(19, '22116057', 'Sabino Jose Caet', '2.2975', '1.95833333', '2.094');

-- --------------------------------------------------------

--
-- Struktur dari tabel `data_testing`
--

CREATE TABLE `data_testing` (
  `id_testing` int(11) NOT NULL,
  `nim` varchar(20) NOT NULL,
  `nama` varchar(75) NOT NULL,
  `nilai_rata_rata_ipk` char(10) NOT NULL,
  `nilai_rata_rata_spa` char(10) NOT NULL,
  `nilai_rata_rata` char(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `data_testing`
--

INSERT INTO `data_testing` (`id_testing`, `nim`, `nama`, `nilai_rata_rata_ipk`, `nilai_rata_rata_spa`, `nilai_rata_rata`) VALUES
(1, '22116001', 'SIMON SENA SOKA', '1.95', '0.75', '1.23'),
(2, '22116002', 'Suryanda Mahesa Taka', '1.6775', '0.33333333', '0.871'),
(3, '22116003', 'Derrysto Rayfaldo Niab', '1.7325', '2.16666666', '1.993'),
(4, '22116004', 'EFRAT JOICE RATA', '2.6875', '2.625', '2.65'),
(5, '22116005', 'Gianti Maria Angela Paridy Man', '3.005', '2.41666666', '2.652');

-- --------------------------------------------------------

--
-- Struktur dari tabel `ipk_latih`
--

CREATE TABLE `ipk_latih` (
  `id_ipk_latih` int(11) NOT NULL,
  `id_latih` int(11) NOT NULL,
  `id_status_ipk` int(11) NOT NULL,
  `nilai_ipk` char(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `ipk_latih`
--

INSERT INTO `ipk_latih` (`id_ipk_latih`, `id_latih`, `id_status_ipk`, `nilai_ipk`) VALUES
(9, 1, 1, '2.35'),
(10, 1, 2, '1.65'),
(11, 1, 3, '1.87'),
(12, 1, 4, '2.05'),
(13, 2, 1, '2.05'),
(14, 2, 2, '1.75'),
(15, 2, 3, '1.94'),
(16, 2, 4, '2.12'),
(17, 3, 1, '3.45'),
(18, 3, 2, '3.46'),
(19, 3, 3, '3.43'),
(20, 3, 4, '3.24'),
(21, 4, 1, '2.84'),
(22, 4, 2, '1.49'),
(23, 4, 3, '1.6'),
(24, 4, 4, '2.04'),
(25, 5, 1, '2.14'),
(26, 5, 2, '1.7'),
(27, 5, 3, '1.86'),
(28, 5, 4, '1.8'),
(29, 6, 1, '0.64'),
(30, 6, 2, '0.75'),
(31, 6, 3, '0.85'),
(32, 6, 4, '0.9'),
(33, 7, 1, '0.32'),
(34, 7, 2, '0.32'),
(35, 7, 3, '0.21'),
(36, 7, 4, '0.35'),
(37, 8, 1, '3.14'),
(38, 8, 2, '2.85'),
(39, 8, 3, '2.47'),
(40, 8, 4, '2.41'),
(41, 9, 1, '3.05'),
(42, 9, 2, '2.85'),
(43, 9, 3, '2.8'),
(44, 9, 4, '2.78'),
(45, 10, 1, '3.02'),
(46, 10, 2, '2.46'),
(47, 10, 3, '2.98'),
(48, 10, 4, '3.05'),
(49, 11, 1, '2.64'),
(50, 11, 2, '2'),
(51, 11, 3, '2.98'),
(52, 11, 4, '3'),
(53, 12, 1, '3.16'),
(54, 12, 2, '1.55'),
(55, 12, 3, '3.09'),
(56, 12, 4, '3.15'),
(57, 13, 1, '3.73'),
(58, 13, 2, '1.73'),
(59, 13, 3, '3.7'),
(60, 13, 4, '3.72'),
(61, 14, 1, '3.66'),
(62, 14, 2, '3.68'),
(63, 14, 3, '3.66'),
(64, 14, 4, '3.67'),
(65, 15, 1, '3.36'),
(66, 15, 2, '3.66'),
(67, 15, 3, '3.43'),
(68, 15, 4, '3.45'),
(69, 16, 1, '1.84'),
(70, 16, 2, '1.47'),
(71, 16, 3, '1.71'),
(72, 16, 4, '1.91'),
(73, 17, 1, '3.06'),
(74, 17, 2, '3.01'),
(75, 17, 3, '2.94'),
(76, 17, 4, '2.95'),
(77, 18, 1, '3.11'),
(78, 18, 2, '3.15'),
(79, 18, 3, '3.05'),
(80, 18, 4, '2.63'),
(81, 19, 1, '2.56'),
(82, 19, 2, '2.29'),
(83, 19, 3, '2.2'),
(84, 19, 4, '2.14');

-- --------------------------------------------------------

--
-- Struktur dari tabel `ipk_testing`
--

CREATE TABLE `ipk_testing` (
  `id_ipk_testing` int(11) NOT NULL,
  `id_testing` int(11) NOT NULL,
  `id_status_ipk` int(11) NOT NULL,
  `nilai_ipk` char(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `ipk_testing`
--

INSERT INTO `ipk_testing` (`id_ipk_testing`, `id_testing`, `id_status_ipk`, `nilai_ipk`) VALUES
(5, 1, 1, '2.44'),
(6, 1, 2, '1.94'),
(7, 1, 3, '1.93'),
(8, 1, 4, '1.49'),
(9, 2, 1, '2.47'),
(10, 2, 2, '1.31'),
(11, 2, 3, '1.65'),
(12, 2, 4, '1.28'),
(13, 3, 1, '1.84'),
(14, 3, 2, '1.47'),
(15, 3, 3, '1.71'),
(16, 3, 4, '1.91'),
(17, 4, 1, '2.67'),
(18, 4, 2, '2.71'),
(19, 4, 3, '2.69'),
(20, 4, 4, '2.68'),
(21, 5, 1, '3.08'),
(22, 5, 2, '2.98'),
(23, 5, 3, '2.99'),
(24, 5, 4, '2.97');

-- --------------------------------------------------------

--
-- Struktur dari tabel `overview`
--

CREATE TABLE `overview` (
  `id` int(11) NOT NULL,
  `judul` varchar(225) NOT NULL,
  `konten` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `overview`
--

INSERT INTO `overview` (`id`, `judul`, `konten`) VALUES
(1, 'SYSTEM PREDIKSI LAMA STUDI MAHASISWA PROGRAM STUDI ARSITEKTUR UNWIRA', '<p><strong>Lorem ipsum</strong>, dolor sit amet consectetur adipisicing elit. Voluptatibus atque ea vero, tempore ducimus maiores rem saepe amet vitae facere dignissimos iure similique reprehenderit quo enim rerum repudiandae, impedit cumque? Error perspiciatis nesciunt explicabo consectetur fugiat minima nisi, molestias suscipit beatae ullam. Sed dolorum fugiat ipsam ex vitae quos, adipisci blanditiis accusantium corrupti sint quas nam ullam ab. Facilis nisi a dolores iure dicta maxime quam repellat? Cum fuga facilis vero optio? Itaque porro hic laudantium cumque minima mollitia quo libero deserunt maiores beatae, obcaecati ut veritatis, quod ratione, eaque temporibus. Voluptatem minus voluptatum reprehenderit possimus soluta? Tenetur, quas. Necessitatibus?</p>\r\n');

-- --------------------------------------------------------

--
-- Struktur dari tabel `spa_latih`
--

CREATE TABLE `spa_latih` (
  `id_spa_latih` int(11) NOT NULL,
  `id_latih` int(11) NOT NULL,
  `id_status_spa` int(11) NOT NULL,
  `nilai_spa` char(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `spa_latih`
--

INSERT INTO `spa_latih` (`id_spa_latih`, `id_latih`, `id_status_spa`, `nilai_spa`) VALUES
(13, 1, 1, '3.5'),
(14, 1, 2, '3'),
(15, 1, 3, '2'),
(16, 1, 4, '2'),
(17, 1, 5, '2'),
(18, 1, 6, '2.5'),
(19, 2, 1, '2.5'),
(20, 2, 2, '2'),
(21, 2, 3, '2.5'),
(22, 2, 4, '2'),
(23, 2, 5, '2.5'),
(24, 2, 6, '3'),
(25, 3, 1, '0'),
(26, 3, 2, '0'),
(27, 3, 3, '0'),
(28, 3, 4, '0'),
(29, 3, 5, '0'),
(30, 3, 6, '0'),
(31, 4, 1, '3.75'),
(32, 4, 2, '2.5'),
(33, 4, 3, '3.75'),
(34, 4, 4, '3'),
(35, 4, 5, '3.5'),
(36, 4, 6, '3'),
(37, 5, 1, '1'),
(38, 5, 2, '1'),
(39, 5, 3, '2'),
(40, 5, 4, '0'),
(41, 5, 5, '0'),
(42, 5, 6, '0'),
(43, 6, 1, '0'),
(44, 6, 2, '0'),
(45, 6, 3, '0'),
(46, 6, 4, '0'),
(47, 6, 5, '0'),
(48, 6, 6, '0'),
(49, 7, 1, '0'),
(50, 7, 2, '0'),
(51, 7, 3, '0'),
(52, 7, 4, '0'),
(53, 7, 5, '0'),
(54, 7, 6, '0'),
(55, 8, 1, '3'),
(56, 8, 2, '2'),
(57, 8, 3, '1'),
(58, 8, 4, '0'),
(59, 8, 5, '0'),
(60, 8, 6, '0'),
(61, 9, 1, '2.5'),
(62, 9, 2, '3.5'),
(63, 9, 3, '0'),
(64, 9, 4, '2.5'),
(65, 9, 5, '0'),
(66, 9, 6, '0'),
(67, 10, 1, '3'),
(68, 10, 2, '0'),
(69, 10, 3, '3.75'),
(70, 10, 4, '3.75'),
(71, 10, 5, '0'),
(72, 10, 6, '0'),
(73, 11, 1, '0'),
(74, 11, 2, '3.5'),
(75, 11, 3, '0'),
(76, 11, 4, '0'),
(77, 11, 5, '0'),
(78, 11, 6, '0'),
(79, 12, 1, '3.5'),
(80, 12, 2, '3.75'),
(81, 12, 3, '3.75'),
(82, 12, 4, '2.5'),
(83, 12, 5, '3.5'),
(84, 12, 6, '3.5'),
(85, 13, 1, '3.75'),
(86, 13, 2, '3.75'),
(87, 13, 3, '3.75'),
(88, 13, 4, '3.75'),
(89, 13, 5, '3.75'),
(90, 13, 6, '3.75'),
(91, 14, 1, '3.75'),
(92, 14, 2, '3.5'),
(93, 14, 3, '3.5'),
(94, 14, 4, '3'),
(95, 14, 5, '2'),
(96, 14, 6, '2.5'),
(97, 15, 1, '3.75'),
(98, 15, 2, '3.75'),
(99, 15, 3, '3.75'),
(100, 15, 4, '3'),
(101, 15, 5, '3'),
(102, 15, 6, '0'),
(103, 16, 1, '2'),
(104, 16, 2, '2'),
(105, 16, 3, '2.5'),
(106, 16, 4, '2'),
(107, 16, 5, '2.5'),
(108, 16, 6, '2'),
(109, 17, 1, '2'),
(110, 17, 2, '2.5'),
(111, 17, 3, '2'),
(112, 17, 4, '2'),
(113, 17, 5, '3'),
(114, 17, 6, '3.5'),
(115, 18, 1, '2'),
(116, 18, 2, '2'),
(117, 18, 3, '2'),
(118, 18, 4, '2'),
(119, 18, 5, '2.5'),
(120, 18, 6, '2.5'),
(121, 19, 1, '2.25'),
(122, 19, 2, '3'),
(123, 19, 3, '0'),
(124, 19, 4, '2'),
(125, 19, 5, '2.5'),
(126, 19, 6, '2');

-- --------------------------------------------------------

--
-- Struktur dari tabel `spa_testing`
--

CREATE TABLE `spa_testing` (
  `id_spa_testing` int(11) NOT NULL,
  `id_testing` int(11) NOT NULL,
  `id_status_spa` int(11) NOT NULL,
  `nilai_spa` char(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `spa_testing`
--

INSERT INTO `spa_testing` (`id_spa_testing`, `id_testing`, `id_status_spa`, `nilai_spa`) VALUES
(7, 1, 1, '2.5'),
(8, 1, 2, '2'),
(9, 1, 3, '0'),
(10, 1, 4, '0'),
(11, 1, 5, '0'),
(12, 1, 6, '0'),
(13, 2, 1, '2'),
(14, 2, 2, '0'),
(15, 2, 3, '0'),
(16, 2, 4, '0'),
(17, 2, 5, '0'),
(18, 2, 6, '0'),
(19, 3, 1, '2'),
(20, 3, 2, '2'),
(21, 3, 3, '2.5'),
(22, 3, 4, '2'),
(23, 3, 5, '2.5'),
(24, 3, 6, '2'),
(25, 4, 1, '3.75'),
(26, 4, 2, '2.5'),
(27, 4, 3, '2'),
(28, 4, 4, '2'),
(29, 4, 5, '2.5'),
(30, 4, 6, '3'),
(31, 5, 1, '2'),
(32, 5, 2, '2'),
(33, 5, 3, '2'),
(34, 5, 4, '3'),
(35, 5, 5, '3'),
(36, 5, 6, '2.5');

-- --------------------------------------------------------

--
-- Struktur dari tabel `status_ipk`
--

CREATE TABLE `status_ipk` (
  `id_status_ipk` int(11) NOT NULL,
  `status_ipk` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `status_ipk`
--

INSERT INTO `status_ipk` (`id_status_ipk`, `status_ipk`) VALUES
(1, 1),
(2, 2),
(3, 3),
(4, 4);

-- --------------------------------------------------------

--
-- Struktur dari tabel `status_spa`
--

CREATE TABLE `status_spa` (
  `id_status_spa` int(11) NOT NULL,
  `status_spa` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `status_spa`
--

INSERT INTO `status_spa` (`id_status_spa`, `status_spa`) VALUES
(1, 1),
(2, 2),
(3, 3),
(4, 4),
(5, 5),
(6, 6);

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id_user` int(11) NOT NULL,
  `id_role` int(11) DEFAULT 2,
  `username` varchar(100) DEFAULT NULL,
  `email` varchar(75) DEFAULT NULL,
  `password` varchar(75) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id_user`, `id_role`, `username`, `email`, `password`, `created_at`, `updated_at`) VALUES
(1, 1, 'Tata Usaha', 'tu@gmail.com', '$2y$10$//KMATh3ibPoI3nHFp7x/u7vnAbo2WyUgmI4x0CVVrH8ajFhMvbjG', '2023-06-15 22:45:19', '2023-06-15 22:45:19'),
(2, 2, 'Ketua Program Studi', 'kepro@gmail.com', '$2y$10$RCsxeKFpZIVKyGD7KQPiWOHBWBWvOneZN/iSJDELGBTOt2/CQv/s2', '2023-07-17 16:34:15', '2023-07-17 16:34:15');

-- --------------------------------------------------------

--
-- Struktur dari tabel `users_role`
--

CREATE TABLE `users_role` (
  `id_role` int(11) NOT NULL,
  `role` varchar(35) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `users_role`
--

INSERT INTO `users_role` (`id_role`, `role`) VALUES
(1, 'Tata Usaha'),
(2, 'Ketua Program Studi');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `atribut`
--
ALTER TABLE `atribut`
  ADD PRIMARY KEY (`id_atribut`);

--
-- Indeks untuk tabel `atribut_latih`
--
ALTER TABLE `atribut_latih`
  ADD PRIMARY KEY (`id_atribut_latih`),
  ADD KEY `id_latih` (`id_latih`),
  ADD KEY `id_atribut_sub` (`id_atribut_sub`);

--
-- Indeks untuk tabel `atribut_sub`
--
ALTER TABLE `atribut_sub`
  ADD PRIMARY KEY (`id_atribut_sub`),
  ADD KEY `id_atribut` (`id_atribut`);

--
-- Indeks untuk tabel `atribut_testing`
--
ALTER TABLE `atribut_testing`
  ADD PRIMARY KEY (`id_atribut_testing`),
  ADD KEY `id_latih` (`id_testing`),
  ADD KEY `id_atribut_sub` (`id_atribut_sub`);

--
-- Indeks untuk tabel `data_latih`
--
ALTER TABLE `data_latih`
  ADD PRIMARY KEY (`id_latih`);

--
-- Indeks untuk tabel `data_testing`
--
ALTER TABLE `data_testing`
  ADD PRIMARY KEY (`id_testing`);

--
-- Indeks untuk tabel `ipk_latih`
--
ALTER TABLE `ipk_latih`
  ADD PRIMARY KEY (`id_ipk_latih`),
  ADD KEY `id_status_ipk` (`id_status_ipk`),
  ADD KEY `ipk_testing_ibfk_1` (`id_latih`);

--
-- Indeks untuk tabel `ipk_testing`
--
ALTER TABLE `ipk_testing`
  ADD PRIMARY KEY (`id_ipk_testing`),
  ADD KEY `id_latih` (`id_testing`),
  ADD KEY `id_status_ipk` (`id_status_ipk`);

--
-- Indeks untuk tabel `overview`
--
ALTER TABLE `overview`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `spa_latih`
--
ALTER TABLE `spa_latih`
  ADD PRIMARY KEY (`id_spa_latih`),
  ADD KEY `id_status_spa` (`id_status_spa`),
  ADD KEY `spa_testing_ibfk_1` (`id_latih`);

--
-- Indeks untuk tabel `spa_testing`
--
ALTER TABLE `spa_testing`
  ADD PRIMARY KEY (`id_spa_testing`),
  ADD KEY `id_latih` (`id_testing`),
  ADD KEY `id_status_spa` (`id_status_spa`);

--
-- Indeks untuk tabel `status_ipk`
--
ALTER TABLE `status_ipk`
  ADD PRIMARY KEY (`id_status_ipk`);

--
-- Indeks untuk tabel `status_spa`
--
ALTER TABLE `status_spa`
  ADD PRIMARY KEY (`id_status_spa`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id_user`),
  ADD KEY `id_role` (`id_role`);

--
-- Indeks untuk tabel `users_role`
--
ALTER TABLE `users_role`
  ADD PRIMARY KEY (`id_role`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `atribut`
--
ALTER TABLE `atribut`
  MODIFY `id_atribut` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT untuk tabel `atribut_latih`
--
ALTER TABLE `atribut_latih`
  MODIFY `id_atribut_latih` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=105;

--
-- AUTO_INCREMENT untuk tabel `atribut_sub`
--
ALTER TABLE `atribut_sub`
  MODIFY `id_atribut_sub` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT untuk tabel `atribut_testing`
--
ALTER TABLE `atribut_testing`
  MODIFY `id_atribut_testing` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT untuk tabel `data_latih`
--
ALTER TABLE `data_latih`
  MODIFY `id_latih` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT untuk tabel `data_testing`
--
ALTER TABLE `data_testing`
  MODIFY `id_testing` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT untuk tabel `ipk_latih`
--
ALTER TABLE `ipk_latih`
  MODIFY `id_ipk_latih` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=85;

--
-- AUTO_INCREMENT untuk tabel `ipk_testing`
--
ALTER TABLE `ipk_testing`
  MODIFY `id_ipk_testing` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT untuk tabel `overview`
--
ALTER TABLE `overview`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `spa_latih`
--
ALTER TABLE `spa_latih`
  MODIFY `id_spa_latih` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=127;

--
-- AUTO_INCREMENT untuk tabel `spa_testing`
--
ALTER TABLE `spa_testing`
  MODIFY `id_spa_testing` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT untuk tabel `status_ipk`
--
ALTER TABLE `status_ipk`
  MODIFY `id_status_ipk` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `status_spa`
--
ALTER TABLE `status_spa`
  MODIFY `id_status_spa` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `users_role`
--
ALTER TABLE `users_role`
  MODIFY `id_role` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `atribut_latih`
--
ALTER TABLE `atribut_latih`
  ADD CONSTRAINT `atribut_latih_ibfk_1` FOREIGN KEY (`id_latih`) REFERENCES `data_latih` (`id_latih`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `atribut_latih_ibfk_2` FOREIGN KEY (`id_atribut_sub`) REFERENCES `atribut_sub` (`id_atribut_sub`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `atribut_sub`
--
ALTER TABLE `atribut_sub`
  ADD CONSTRAINT `atribut_sub_ibfk_1` FOREIGN KEY (`id_atribut`) REFERENCES `atribut` (`id_atribut`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `atribut_testing`
--
ALTER TABLE `atribut_testing`
  ADD CONSTRAINT `atribut_testing_ibfk_1` FOREIGN KEY (`id_testing`) REFERENCES `data_testing` (`id_testing`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `atribut_testing_ibfk_2` FOREIGN KEY (`id_atribut_sub`) REFERENCES `atribut_sub` (`id_atribut_sub`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `ipk_latih`
--
ALTER TABLE `ipk_latih`
  ADD CONSTRAINT `ipk_latih_ibfk_1` FOREIGN KEY (`id_latih`) REFERENCES `data_latih` (`id_latih`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `ipk_latih_ibfk_2` FOREIGN KEY (`id_status_ipk`) REFERENCES `status_ipk` (`id_status_ipk`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Ketidakleluasaan untuk tabel `ipk_testing`
--
ALTER TABLE `ipk_testing`
  ADD CONSTRAINT `ipk_testing_ibfk_1` FOREIGN KEY (`id_testing`) REFERENCES `data_testing` (`id_testing`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `ipk_testing_ibfk_2` FOREIGN KEY (`id_status_ipk`) REFERENCES `status_ipk` (`id_status_ipk`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Ketidakleluasaan untuk tabel `spa_latih`
--
ALTER TABLE `spa_latih`
  ADD CONSTRAINT `spa_latih_ibfk_1` FOREIGN KEY (`id_latih`) REFERENCES `data_latih` (`id_latih`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `spa_latih_ibfk_2` FOREIGN KEY (`id_status_spa`) REFERENCES `status_spa` (`id_status_spa`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Ketidakleluasaan untuk tabel `spa_testing`
--
ALTER TABLE `spa_testing`
  ADD CONSTRAINT `spa_testing_ibfk_1` FOREIGN KEY (`id_testing`) REFERENCES `data_testing` (`id_testing`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `spa_testing_ibfk_2` FOREIGN KEY (`id_status_spa`) REFERENCES `status_spa` (`id_status_spa`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Ketidakleluasaan untuk tabel `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`id_role`) REFERENCES `users_role` (`id_role`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
