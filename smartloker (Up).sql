-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 03 Bulan Mei 2024 pada 17.33
-- Versi server: 10.4.32-MariaDB
-- Versi PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `smartloker`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `loker`
--

CREATE TABLE `loker` (
  `IDLoker` int(11) NOT NULL,
  `NomorLoker` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `loker`
--

INSERT INTO `loker` (`IDLoker`, `NomorLoker`) VALUES
(1, 1),
(2, 2),
(3, 3);

-- --------------------------------------------------------

--
-- Struktur dari tabel `pengguna`
--

CREATE TABLE `pengguna` (
  `IDPengguna` int(11) NOT NULL,
  `Nama` varchar(255) NOT NULL,
  `NIM` varchar(20) NOT NULL,
  `IDSidikJari` varchar(50) NOT NULL,
  `IDWajah` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `pengguna`
--

INSERT INTO `pengguna` (`IDPengguna`, `Nama`, `NIM`, `IDSidikJari`, `IDWajah`) VALUES
(1, 'Ridho', '4242101037', 'sidikjari1', 'wajah1'),
(2, 'Ammar', '4242201025', 'sidikjari2', 'wajah2'),
(3, 'Tio', '4242201063', 'sidikjari3', 'wajah3');

-- --------------------------------------------------------

--
-- Struktur dari tabel `transaksi`
--

CREATE TABLE `transaksi` (
  `IDTransaksi` int(11) NOT NULL,
  `IDPengguna` int(11) DEFAULT NULL,
  `IDLoker` int(11) DEFAULT NULL,
  `WaktuPinjam` datetime NOT NULL,
  `WaktuKembali` datetime DEFAULT NULL,
  `BarangPinjam` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `transaksi`
--

INSERT INTO `transaksi` (`IDTransaksi`, `IDPengguna`, `IDLoker`, `WaktuPinjam`, `WaktuKembali`, `BarangPinjam`) VALUES
(1, 1, 1, '2024-05-03 22:31:09', NULL, 'Arduino dan ESP32'),
(2, 2, 2, '2024-05-03 22:31:09', NULL, 'Laptop'),
(3, 3, 3, '2024-05-03 22:31:09', NULL, 'Obeng dan Multimeter');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `loker`
--
ALTER TABLE `loker`
  ADD PRIMARY KEY (`IDLoker`),
  ADD UNIQUE KEY `NomorLoker` (`NomorLoker`);

--
-- Indeks untuk tabel `pengguna`
--
ALTER TABLE `pengguna`
  ADD PRIMARY KEY (`IDPengguna`),
  ADD UNIQUE KEY `NIM` (`NIM`),
  ADD UNIQUE KEY `IDSidikJari` (`IDSidikJari`),
  ADD UNIQUE KEY `IDWajah` (`IDWajah`);

--
-- Indeks untuk tabel `transaksi`
--
ALTER TABLE `transaksi`
  ADD PRIMARY KEY (`IDTransaksi`),
  ADD KEY `IDPengguna` (`IDPengguna`),
  ADD KEY `IDLoker` (`IDLoker`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `loker`
--
ALTER TABLE `loker`
  MODIFY `IDLoker` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `pengguna`
--
ALTER TABLE `pengguna`
  MODIFY `IDPengguna` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT untuk tabel `transaksi`
--
ALTER TABLE `transaksi`
  MODIFY `IDTransaksi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `transaksi`
--
ALTER TABLE `transaksi`
  ADD CONSTRAINT `transaksi_ibfk_1` FOREIGN KEY (`IDPengguna`) REFERENCES `pengguna` (`IDPengguna`),
  ADD CONSTRAINT `transaksi_ibfk_2` FOREIGN KEY (`IDLoker`) REFERENCES `loker` (`IDLoker`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
