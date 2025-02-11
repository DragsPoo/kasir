-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 11 Feb 2025 pada 09.24
-- Versi server: 10.4.28-MariaDB
-- Versi PHP: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `kasir`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `detail_penjualan`
--

CREATE TABLE `detail_penjualan` (
  `id_detail` int(11) NOT NULL,
  `tanggal_detail` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `id_penjualan` int(11) NOT NULL,
  `id_pelanggan` int(11) NOT NULL,
  `jumlah` varchar(255) NOT NULL,
  `total_harga` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `detail_penjualan`
--

INSERT INTO `detail_penjualan` (`id_detail`, `tanggal_detail`, `id_penjualan`, `id_pelanggan`, `jumlah`, `total_harga`) VALUES
(2, '2025-02-11 07:10:03', 11, 2, '', '15000000'),
(3, '2025-02-11 07:10:56', 12, 2, '', '15000000'),
(4, '2025-02-11 07:18:06', 13, 1, '', '15000000'),
(5, '2025-02-11 07:18:37', 14, 1, '', '800000'),
(6, '2025-02-11 07:22:06', 15, 2, '', '30000000'),
(7, '2025-02-11 07:26:30', 16, 1, '', '800000'),
(8, '2025-02-11 07:52:40', 17, 1, '', '15000000'),
(9, '2025-02-11 08:08:29', 18, 1, '', '800000');

-- --------------------------------------------------------

--
-- Struktur dari tabel `pelanggan`
--

CREATE TABLE `pelanggan` (
  `id_pelanggan` int(11) NOT NULL,
  `nama_pelanggan` varchar(255) NOT NULL,
  `alamat` varchar(255) NOT NULL,
  `kontak` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `pelanggan`
--

INSERT INTO `pelanggan` (`id_pelanggan`, `nama_pelanggan`, `alamat`, `kontak`) VALUES
(1, 'Rizky', 'Jl. Merpati Putih', '0853-1408-3059'),
(2, 'Kunto Aji', 'Jl. Semarang', '0823-9132-6150');

-- --------------------------------------------------------

--
-- Struktur dari tabel `penjualan`
--

CREATE TABLE `penjualan` (
  `id_penjualan` int(11) NOT NULL,
  `tanggal_penjualan` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `id_produk` int(11) NOT NULL,
  `id_pelanggan` int(11) NOT NULL,
  `jumlah` varchar(255) NOT NULL,
  `total_harga` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `penjualan`
--

INSERT INTO `penjualan` (`id_penjualan`, `tanggal_penjualan`, `id_produk`, `id_pelanggan`, `jumlah`, `total_harga`) VALUES
(1, '2025-02-11 06:43:39', 2, 2, '2', '15000000'),
(2, '2025-02-11 06:47:37', 2, 1, '0', '0'),
(3, '2025-02-11 06:47:40', 3, 1, '0', '0'),
(4, '2025-02-11 06:47:41', 2, 1, '0', '0'),
(5, '2025-02-11 06:47:47', 2, 1, '2', '15000000'),
(6, '2025-02-11 06:49:01', 3, 1, '2', '800000'),
(7, '2025-02-11 07:03:11', 2, 1, '2', '15000000'),
(8, '2025-02-11 07:04:12', 3, 1, '2', '800000'),
(9, '2025-02-11 07:04:34', 3, 1, '1', '400000'),
(10, '2025-02-11 07:05:09', 3, 2, '2', '800000'),
(11, '2025-02-11 07:10:03', 2, 2, '2', '15000000'),
(12, '2025-02-11 07:10:56', 2, 2, '2', '15000000'),
(13, '2025-02-11 07:18:06', 2, 1, '2', '15000000'),
(14, '2025-02-11 07:18:37', 3, 1, '2', '800000'),
(15, '2025-02-11 07:22:06', 2, 2, '4', '30000000'),
(16, '2025-02-11 07:26:30', 3, 1, '2', '800000'),
(17, '2025-02-11 07:52:40', 2, 1, '2', '15000000'),
(18, '2025-02-11 08:08:29', 3, 1, '2', '800000');

-- --------------------------------------------------------

--
-- Struktur dari tabel `produk`
--

CREATE TABLE `produk` (
  `id_produk` int(11) NOT NULL,
  `nama_produk` varchar(255) NOT NULL,
  `stok` int(255) NOT NULL,
  `harga` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `produk`
--

INSERT INTO `produk` (`id_produk`, `nama_produk`, `stok`, `harga`) VALUES
(2, 'Laptop', 25, '7500000'),
(3, 'Keyboard', 16, '400000');

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id_users` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `akses` enum('Adminisator','Petugas','','') NOT NULL,
  `create_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id_users`, `username`, `password`, `akses`, `create_at`) VALUES
(1, 'kayeye', '$2y$10$KP9wYONDT6sg9SysGNL6MO7rJTjlW07FYZ5KL56NsSFI2Bu.XgeNe', 'Adminisator', '2025-02-11 04:13:08'),
(2, 'petugas', '$2y$10$qz6aua622cyPxiVC5UsYC.KRUNyj9KdTrwWcOJkWum2huBLVtg1O.', 'Petugas', '2025-02-11 04:14:08'),
(4, 'coba1', '$2y$10$JJCUwD8Tm.50BEmP48iYWuDJAG1BWZ98PEdfF6bPlgVn2/m5kqD6S', 'Adminisator', '2025-02-11 07:37:10'),
(5, 'coba2', '$2y$10$XUrB0PEagPg2bGRjmce9.Oj90kr4fCeICSpkkN93Ol4if4kAvFrOi', 'Petugas', '2025-02-11 07:37:26');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `detail_penjualan`
--
ALTER TABLE `detail_penjualan`
  ADD PRIMARY KEY (`id_detail`),
  ADD KEY `id_pelanggan` (`id_pelanggan`),
  ADD KEY `id_penjualan` (`id_penjualan`);

--
-- Indeks untuk tabel `pelanggan`
--
ALTER TABLE `pelanggan`
  ADD PRIMARY KEY (`id_pelanggan`);

--
-- Indeks untuk tabel `penjualan`
--
ALTER TABLE `penjualan`
  ADD PRIMARY KEY (`id_penjualan`),
  ADD KEY `id_produk` (`id_produk`),
  ADD KEY `id_pelanggan` (`id_pelanggan`);

--
-- Indeks untuk tabel `produk`
--
ALTER TABLE `produk`
  ADD PRIMARY KEY (`id_produk`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id_users`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `detail_penjualan`
--
ALTER TABLE `detail_penjualan`
  MODIFY `id_detail` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT untuk tabel `pelanggan`
--
ALTER TABLE `pelanggan`
  MODIFY `id_pelanggan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `penjualan`
--
ALTER TABLE `penjualan`
  MODIFY `id_penjualan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT untuk tabel `produk`
--
ALTER TABLE `produk`
  MODIFY `id_produk` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id_users` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `detail_penjualan`
--
ALTER TABLE `detail_penjualan`
  ADD CONSTRAINT `detail_penjualan_ibfk_1` FOREIGN KEY (`id_pelanggan`) REFERENCES `pelanggan` (`id_pelanggan`) ON UPDATE CASCADE,
  ADD CONSTRAINT `detail_penjualan_ibfk_2` FOREIGN KEY (`id_penjualan`) REFERENCES `penjualan` (`id_penjualan`) ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `penjualan`
--
ALTER TABLE `penjualan`
  ADD CONSTRAINT `penjualan_ibfk_1` FOREIGN KEY (`id_produk`) REFERENCES `produk` (`id_produk`) ON UPDATE CASCADE,
  ADD CONSTRAINT `penjualan_ibfk_2` FOREIGN KEY (`id_pelanggan`) REFERENCES `pelanggan` (`id_pelanggan`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
