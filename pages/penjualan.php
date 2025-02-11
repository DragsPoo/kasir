<?php
include '../config/koneksi.php';

// Tambah Penjualan
if (isset($_POST['tambah'])) {
    $tanggal = date('Y-m-d');
    $id_pelanggan = $_POST['id_pelanggan'];
    $id_produk = $_POST['id_produk'];
    $jumlah = $_POST['jumlah'];

    // Ambil harga produk
    $produk_query = mysqli_query($conn, "SELECT harga FROM produk WHERE id_produk='$id_produk'");
    $produk = mysqli_fetch_assoc($produk_query);
    $total_harga = $produk['harga'] * $jumlah;

    // Insert ke tabel penjualan
    $query = "INSERT INTO penjualan (tanggal_penjualan, id_pelanggan, id_produk, jumlah, total_harga) VALUES ('$tanggal', '$id_pelanggan', '$id_produk', '$jumlah', '$total_harga')";
    mysqli_query($conn, $query);
    $id_penjualan = mysqli_insert_id($conn);

    // Insert ke tabel detail_penjualan
    $query_detail = "INSERT INTO detail_penjualan (id_penjualan, id_pelanggan, jumlah, total_harga) VALUES ('$id_penjualan', '$id_pelanggan', '$jumlah', '$total_harga')";
    mysqli_query($conn, $query_detail);

    header("Location: penjualan.php");
    exit();
}

// Ambil data penjualan
$result = mysqli_query($conn, "SELECT penjualan.*, pelanggan.nama_pelanggan, produk.nama_produk FROM penjualan 
    JOIN pelanggan ON penjualan.id_pelanggan = pelanggan.id_pelanggan 
    JOIN produk ON penjualan.id_produk = produk.id_produk");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Penjualan</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        body {
            background-color: #121212;
            color: white;
        }
        .container {
            margin-top: 50px;
            background: #1e1e1e;
            padding: 20px;
            border-radius: 10px;
        }
        input, select {
            background: #333;
            color: white;
            border: 1px solid #555;
        }
        .btn-primary {
            background-color: #007bff;
            border: none;
        }
        .btn-primary:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2 class="text-center">Manajemen Penjualan</h2>
        <form method="POST" action="">
            <div class="mb-3">
                <label class="form-label">Pelanggan:</label>
                <select name="id_pelanggan" class="form-control" required>
                    <?php
                    $pelanggan_query = mysqli_query($conn, "SELECT * FROM pelanggan");
                    while ($pelanggan = mysqli_fetch_assoc($pelanggan_query)) {
                        echo "<option value='{$pelanggan['id_pelanggan']}'>{$pelanggan['nama_pelanggan']}</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="mb-3">
                <label class="form-label">Produk:</label>
                <select name="id_produk" class="form-control" required>
                    <?php
                    $produk_query = mysqli_query($conn, "SELECT * FROM produk");
                    while ($produk = mysqli_fetch_assoc($produk_query)) {
                        echo "<option value='{$produk['id_produk']}'>{$produk['nama_produk']} - Rp{$produk['harga']}</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="mb-3">
                <label class="form-label">Jumlah:</label>
                <input type="number" class="form-control" name="jumlah" required>
            </div>
            <button type="submit" class="btn btn-primary w-100" name="tambah">Tambah Penjualan</button>
        </form>
        <br>
        <table class="table table-dark table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Tanggal</th>
                    <th>Pelanggan</th>
                    <th>Produk</th>
                    <th>Jumlah</th>
                    <th>Total Harga</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                    <tr>
                        <td><?= $row['id_penjualan']; ?></td>
                        <td><?= $row['tanggal_penjualan']; ?></td>
                        <td><?= $row['nama_pelanggan']; ?></td>
                        <td><?= $row['nama_produk']; ?></td>
                        <td><?= $row['jumlah']; ?></td>
                        <td>Rp<?= number_format($row['total_harga'], 0, ',', '.'); ?></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
        <br>
        <div class="text-center">
            <a href="../index.php">Kembali ke Beranda</a>
        </div>
    </div>
</body>
</html>
