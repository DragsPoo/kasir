<?php
session_start();
include 'config/koneksi.php';
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

$username = $_SESSION['username'];
$akses = $_SESSION['akses'];

?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Kasir</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body class="dark-mode">

    <nav class="navbar navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="#">Kasir Dark Mode</a>
            <a href="logout.php" class="btn btn-danger">Logout</a>
        </div>
    </nav>

    <div class="container mt-4">
        <h2 class="text-black">Selamat Datang di Sistem Kasir</h2>
        <p class="text-muted">Silakan pilih menu di sidebar untuk mengelola data.</p>

        <ul class="list-group mt-3">
        <?php if ($akses === 'Adminisator') { ?>
                <li class="list-group-item bg-dark">
                    <a class="nav-link text-white" href="registrasi.php">Tambah Pengguna</a>
                </li>
                <?php } ?>
                <li class="list-group-item bg-dark">
                    <a class="nav-link text-white" href="pages/produk.php">Produk</a>
                </li>
                <li class="list-group-item bg-dark">
                    <a class="nav-link text-white" href="pages/pelanggan.php">Pelanggan</a>
                </li>
                <li class="list-group-item bg-dark">
                    <a class="nav-link text-white" href="pages/penjualan.php">Penjualan</a>
                </li>
                <li class="list-group-item bg-dark">
                    <a class="nav-link text-white" href="pages/laporan.php">Laporan</a>
                </li>
        </ul>
    </div>

</body>
</html>
