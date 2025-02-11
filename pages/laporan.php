<?php
require_once '../config/koneksi.php';

// Inisialisasi variabel filter tanggal
$tanggal_mulai = isset($_GET['tanggal_mulai']) ? $_GET['tanggal_mulai'] : date('Y-m-01');
$tanggal_selesai = isset($_GET['tanggal_selesai']) ? $_GET['tanggal_selesai'] : date('Y-m-t');

// Query untuk mengambil data laporan penjualan dengan filter tanggal
$query = "SELECT p.id_penjualan, p.tanggal_penjualan, pl.nama_pelanggan, pr.nama_produk, p.jumlah, p.total_harga 
          FROM penjualan p
          JOIN pelanggan pl ON p.id_pelanggan = pl.id_pelanggan
          JOIN produk pr ON p.id_produk = pr.id_produk
          WHERE DATE(p.tanggal_penjualan) BETWEEN '$tanggal_mulai' AND '$tanggal_selesai'
          ORDER BY p.tanggal_penjualan DESC";

$result = mysqli_query($conn, $query);
$laporan = mysqli_fetch_all($result, MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Penjualan</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-900 text-white">
    <div class="container mx-auto p-6">
        <h1 class="text-2xl font-bold mb-4">Laporan Penjualan</h1>
        
        <!-- Form Filter Tanggal -->
        <form method="GET" class="mb-4">
            <label for="tanggal_mulai">Dari: </label>
            <input type="date" name="tanggal_mulai" value="<?= $tanggal_mulai ?>" class="text-black p-2 rounded">
            
            <label for="tanggal_selesai">Sampai: </label>
            <input type="date" name="tanggal_selesai" value="<?= $tanggal_selesai ?>" class="text-black p-2 rounded">
            
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Filter</button>
        </form>

        <!-- Tabel Laporan -->
        <div class="bg-gray-800 p-4 rounded-lg">
            <table class="w-full border-collapse border border-gray-700">
                <thead>
                    <tr class="bg-gray-700">
                        <th class="border border-gray-600 p-2">No</th>
                        <th class="border border-gray-600 p-2">Tanggal</th>
                        <th class="border border-gray-600 p-2">Pelanggan</th>
                        <th class="border border-gray-600 p-2">Produk</th>
                        <th class="border border-gray-600 p-2">Jumlah</th>
                        <th class="border border-gray-600 p-2">Total Harga</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (count($laporan) > 0): ?>
                        <?php foreach ($laporan as $index => $row): ?>
                            <tr class="border border-gray-600">
                                <td class="p-2 text-center"> <?= $index + 1 ?> </td>
                                <td class="p-2 text-center"> <?= $row['tanggal_penjualan'] ?> </td>
                                <td class="p-2 text-center"> <?= $row['nama_pelanggan'] ?> </td>
                                <td class="p-2 text-center"> <?= $row['nama_produk'] ?> </td>
                                <td class="p-2 text-center"> <?= $row['jumlah'] ?> </td>
                                <td class="p-2 text-center"> Rp <?= number_format($row['total_harga'], 0, ',', '.') ?> </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="6" class="text-center p-4">Tidak ada data penjualan pada periode ini.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
    <a href="../index.php">Kembali ke Beranda</a>
</body>
</html>
