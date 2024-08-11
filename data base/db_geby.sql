-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 16 Jul 2024 pada 14.59
-- Versi server: 10.4.25-MariaDB
-- Versi PHP: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_geby`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `barang`
--

CREATE TABLE `barang` (
  `id` int(11) NOT NULL,
  `nama_barang` varchar(300) NOT NULL,
  `jenis` varchar(50) NOT NULL,
  `ukuran` varchar(50) NOT NULL,
  `deskripsi` text NOT NULL,
  `stok` int(11) NOT NULL,
  `harga` int(11) NOT NULL,
  `modif` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `barang`
--

INSERT INTO `barang` (`id`, `nama_barang`, `jenis`, `ukuran`, `deskripsi`, `stok`, `harga`, `modif`) VALUES
(3, 'GULA PASIR', 'BAHAN PANGAN', 'KILOGRAM', 'BAHAN PANGAN', 29, 12000, '2024-07-11'),
(4, 'GARAM DAPUR DOLPIN', 'BAHAN PANGAN', 'PICIS', 'BAHAN PANGAN', 22, 5000, '2024-07-01'),
(5, 'KECAP MANIS BANGAU', 'BAHAN PANGAN', 'BOTOL', 'BAHAN PANGAN', 30, 10000, '0000-00-00'),
(6, 'DETERGEN DAIA', 'PEMBERSIH', 'PICIS', 'PEMBERSIH PAKAIAN', 55, 10000, '0000-00-00'),
(7, 'SHAMPOO MAKARIZO', 'PERALATAN MANDI', 'SACHET ', 'UNTUK MANDI', 30, 10000, '2024-07-11'),
(8, 'TEPUNG TERIGU SEGITIGA BIRU', 'BAHAN PANGAN', 'KILOGRAM', 'BAHAN PANGAN', 29, 15000, '2024-07-11'),
(9, 'TISSUE NICE', 'TISSUE WAJAH', 'PICIS', 'TISSUE', 30, 15000, '0000-00-00'),
(10, 'SUNLIGHT', 'PEMBERSIH ALAT MAKAN', 'PICIS', 'UNTUK PEMBERSIH', 100, 5000, '0000-00-00'),
(11, 'CLOSE UP', 'PASTA GIGI', 'PICIS', 'PASTA GIGI', 98, 10000, '0000-00-00'),
(13, 'POTA BEE', 'JAJANAN', 'PICIS', 'MAKANAN', 100, 3000, '0000-00-00'),
(14, 'CITATO', 'JAJANAN', 'PICIS', 'MAKANAN', 91, 5000, '0000-00-00'),
(15, 'MAKARONI BALADO', 'JAJANAN', 'PICIS', 'MAKANAN', 80, 10000, '0000-00-00'),
(16, 'MAKARONI BON CABE', 'JAJANAN', 'PICIS', 'MAKANAN', 80, 8000, '0000-00-00'),
(17, 'YAKULT', 'MINUMAN', 'PICIS', 'MINUMAN', 50, 2500, '0000-00-00'),
(18, 'POCARI SWEET', 'MINUMAN', 'PICIS', 'MINUMAN', 50, 8000, '0000-00-00'),
(19, 'MINUTE MAID PULLPY ORANGE', 'MINUMAN', 'PICIS', 'MINUMAN ', 120, 6000, '0000-00-00'),
(20, 'TEH PUCUK', 'MINUMAN', 'PICIS', 'MINUMAN TEH', 120, 4000, '0000-00-00'),
(21, 'MINYAK GORENG BIMOLI', 'MINYAK MAKAN', 'LITER', 'MINYAK', 80, 20000, '0000-00-00'),
(22, 'PEPSODENT', 'PASTA GIGI', 'PICIS', 'PASTA GIGI', 50, 8000, '0000-00-00'),
(23, 'BERAS', 'BAHAN PANGAN', 'KILOGRAM', 'BAHAN PANGAN', 30, 15000, '0000-00-00'),
(24, 'PUPUK NPK PHONSKA', 'PUPUK TANAMAN', 'KILOGRAM', 'BAHAN TANI', 300, 250000, '0000-00-00'),
(25, 'PUPUK NPK MUTIARA', 'PUPUK TANAMAN', 'KILOGRAM', 'BAHAN TANI', 100, 73000, '0000-00-00'),
(26, 'SAPURATA', 'RACUN HAMA TANAMAN', 'BOTOL', 'BAHAN TANI', 30, 33000, '0000-00-00'),
(27, 'ROUNDUP', 'RACUN HAMA TANAMAN', 'BOTOL', 'BAHAN TANI', 30, 35000, '0000-00-00'),
(28, 'GRAMOXONE', 'RACUN HAMA TANAMAN', 'BOTOL', 'BAHAN TANI', 30, 30000, '0000-00-00');

-- --------------------------------------------------------

--
-- Struktur dari tabel `pegawai`
--

CREATE TABLE `pegawai` (
  `id` int(11) NOT NULL,
  `username` varchar(20) NOT NULL,
  `password` varchar(100) NOT NULL,
  `nama_pegawai` varchar(200) NOT NULL,
  `alamat` varchar(360) NOT NULL,
  `jabatan` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `pegawai`
--

INSERT INTO `pegawai` (`id`, `username`, `password`, `nama_pegawai`, `alamat`, `jabatan`) VALUES
(1, 'kasir', '12345', 'Surti', 'Jl. Medan No.78', 2),
(2, 'gudang', '12345', 'Gudang', 'Jl. Medan No.57', 3),
(3, 'pemilik', '12345', 'Alimin', 'Medan', 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `pembelian_detail`
--

CREATE TABLE `pembelian_detail` (
  `id` int(11) NOT NULL,
  `nota_pembelian` int(11) NOT NULL,
  `idbarang` int(11) NOT NULL,
  `harga` int(11) NOT NULL,
  `qty` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `pembelian_detail`
--

INSERT INTO `pembelian_detail` (`id`, `nota_pembelian`, `idbarang`, `harga`, `qty`) VALUES
(2, 100000002, 20, 4000, 10),
(3, 100000003, 6, 10000, 50),
(4, 100000004, 8, 15000, 10),
(5, 100000005, 6, 10000, 10),
(6, 100000005, 15, 10000, 20),
(7, 100000006, 18, 8000, 10),
(8, 100000006, 19, 6000, 0),
(9, 100000007, 15, 10000, 10),
(10, 100000007, 21, 20000, 10),
(11, 100000008, 8, 15000, 20);

-- --------------------------------------------------------

--
-- Struktur dari tabel `pembelian_header`
--

CREATE TABLE `pembelian_header` (
  `nota_pembelian` int(11) NOT NULL,
  `id` int(11) NOT NULL,
  `tanggal` date NOT NULL,
  `status` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `pembelian_header`
--

INSERT INTO `pembelian_header` (`nota_pembelian`, `id`, `tanggal`, `status`) VALUES
(100000002, 8, '2024-06-26', 'Confirmed'),
(100000003, 8, '2024-07-04', 'Confirmed'),
(100000004, 8, '2024-07-11', 'Confirmed'),
(100000005, 8, '2024-07-11', 'Confirmed'),
(100000006, 9, '2024-07-11', 'Confirmed'),
(100000007, 8, '2024-07-11', 'Confirmed'),
(100000008, 6, '2024-07-16', 'Confirmed'),
(100000009, 0, '2024-07-16', 'Unconfirm');

-- --------------------------------------------------------

--
-- Struktur dari tabel `penjualan_detail`
--

CREATE TABLE `penjualan_detail` (
  `id` int(11) NOT NULL,
  `nota_penjualan` int(11) NOT NULL,
  `idbarang` int(11) NOT NULL,
  `harga` int(11) NOT NULL,
  `qty` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `penjualan_detail`
--

INSERT INTO `penjualan_detail` (`id`, `nota_penjualan`, `idbarang`, `harga`, `qty`) VALUES
(1, 100000001, 4, 5000, 3),
(2, 100000001, 11, 10000, 2),
(5, 100000003, 3, 12000, 1),
(6, 100000004, 14, 5000, 3),
(7, 100000005, 23, 15000, 10),
(8, 100000005, 8, 15000, 2),
(9, 100000006, 14, 5000, 3),
(12, 100000007, 23, 15000, 50),
(13, 100000008, 6, 10000, 5),
(14, 100000009, 23, 15000, 10),
(15, 100000010, 6, 10000, 10),
(16, 100000011, 8, 15000, 81);

-- --------------------------------------------------------

--
-- Struktur dari tabel `penjualan_header`
--

CREATE TABLE `penjualan_header` (
  `nota_penjualan` int(11) NOT NULL,
  `tanggal` date NOT NULL,
  `status` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `penjualan_header`
--

INSERT INTO `penjualan_header` (`nota_penjualan`, `tanggal`, `status`) VALUES
(100000001, '2024-06-19', 'Confirmed'),
(100000003, '2024-06-25', 'Confirmed'),
(100000004, '2024-06-26', 'Confirmed'),
(100000005, '2024-06-26', 'Confirmed'),
(100000006, '2024-06-26', 'Confirmed'),
(100000007, '2024-07-01', 'Confirmed'),
(100000008, '2024-07-04', 'Confirmed'),
(100000009, '2024-07-08', 'Confirmed'),
(100000010, '2024-07-11', 'Confirmed'),
(100000011, '2024-07-11', 'Confirmed');

-- --------------------------------------------------------

--
-- Struktur dari tabel `retur_pembelian_detail`
--

CREATE TABLE `retur_pembelian_detail` (
  `id` int(11) NOT NULL,
  `nota_retur_pembelian` int(11) NOT NULL,
  `idbarang` int(11) NOT NULL,
  `harga` int(11) NOT NULL,
  `qty` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `retur_pembelian_detail`
--

INSERT INTO `retur_pembelian_detail` (`id`, `nota_retur_pembelian`, `idbarang`, `harga`, `qty`) VALUES
(29, 100000001, 20, 4000, 10);

-- --------------------------------------------------------

--
-- Struktur dari tabel `retur_pembelian_header`
--

CREATE TABLE `retur_pembelian_header` (
  `nota_retur_pembelian` int(11) NOT NULL,
  `nota_pembelian` int(11) NOT NULL,
  `tanggal` date NOT NULL,
  `status` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `retur_pembelian_header`
--

INSERT INTO `retur_pembelian_header` (`nota_retur_pembelian`, `nota_pembelian`, `tanggal`, `status`) VALUES
(100000001, 100000002, '2024-07-16', 'Confirmed'),
(100000002, 0, '2024-07-16', 'Unconfirm');

-- --------------------------------------------------------

--
-- Struktur dari tabel `supplier`
--

CREATE TABLE `supplier` (
  `id` int(11) NOT NULL,
  `nama_supplier` varchar(200) NOT NULL,
  `alamat` varchar(360) NOT NULL,
  `telepon` int(13) NOT NULL,
  `contac_person` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `supplier`
--

INSERT INTO `supplier` (`id`, `nama_supplier`, `alamat`, `telepon`, `contac_person`) VALUES
(6, 'PT. Beras Tebing Tinggi', 'Jln. Thamrin Kota Tebing Tinggi', 2147483647, 'Ibu Dania'),
(7, 'TEPUNG SEGITIGA BIRU', 'Jln. Setia Budi Medan', 662547, 'Pak Ahmad'),
(8, 'MM.DAGANG', 'Jln. Kartini kota Tebing Tinggi', 2147483647, 'IBU AYU'),
(9, 'PT. Abadi', 'Medan', 2147483647, 'Ibu Anita');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `barang`
--
ALTER TABLE `barang`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `pegawai`
--
ALTER TABLE `pegawai`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `pembelian_detail`
--
ALTER TABLE `pembelian_detail`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `pembelian_header`
--
ALTER TABLE `pembelian_header`
  ADD PRIMARY KEY (`nota_pembelian`);

--
-- Indeks untuk tabel `penjualan_detail`
--
ALTER TABLE `penjualan_detail`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `penjualan_header`
--
ALTER TABLE `penjualan_header`
  ADD PRIMARY KEY (`nota_penjualan`);

--
-- Indeks untuk tabel `retur_pembelian_detail`
--
ALTER TABLE `retur_pembelian_detail`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `retur_pembelian_header`
--
ALTER TABLE `retur_pembelian_header`
  ADD PRIMARY KEY (`nota_retur_pembelian`);

--
-- Indeks untuk tabel `supplier`
--
ALTER TABLE `supplier`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `barang`
--
ALTER TABLE `barang`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT untuk tabel `pegawai`
--
ALTER TABLE `pegawai`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `pembelian_detail`
--
ALTER TABLE `pembelian_detail`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT untuk tabel `pembelian_header`
--
ALTER TABLE `pembelian_header`
  MODIFY `nota_pembelian` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=100000010;

--
-- AUTO_INCREMENT untuk tabel `penjualan_detail`
--
ALTER TABLE `penjualan_detail`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT untuk tabel `penjualan_header`
--
ALTER TABLE `penjualan_header`
  MODIFY `nota_penjualan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=100000012;

--
-- AUTO_INCREMENT untuk tabel `retur_pembelian_detail`
--
ALTER TABLE `retur_pembelian_detail`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT untuk tabel `retur_pembelian_header`
--
ALTER TABLE `retur_pembelian_header`
  MODIFY `nota_retur_pembelian` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=100000010;

--
-- AUTO_INCREMENT untuk tabel `supplier`
--
ALTER TABLE `supplier`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
