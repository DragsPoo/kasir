<?php
session_start();
include '../config/koneksi.php';

// Cek apakah user sudah login
if (!isset($_SESSION['username'])) {
    header("Location: ../login.php");
    exit();
}

// Fungsi untuk membersihkan input
function clean_input($data, $conn) {
    return mysqli_real_escape_string($conn, trim($data));
}

// Tambah produk
if (isset($_POST['tambah'])) {
    $nama_produk = clean_input($_POST['nama_produk'], $conn);
    $stok = (int) $_POST['stok'];
    $harga = (int) $_POST['harga'];

    if ($nama_produk && $stok >= 0 && $harga >= 0) {
        $query = "INSERT INTO produk (nama_produk, stok, harga) VALUES (?, ?, ?)";
        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, "sii", $nama_produk, $stok, $harga);
        mysqli_stmt_execute($stmt);
        header("Location: produk.php");
        exit();
    }
}

// Hapus produk
if (isset($_GET['hapus'])) {
    $id_produk = (int) $_GET['hapus'];
    $query = "DELETE FROM produk WHERE id_produk=?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "i", $id_produk);
    mysqli_stmt_execute($stmt);
    header("Location: produk.php");
    exit();
}

// Edit produk
if (isset($_POST['edit'])) {
    $id_produk = (int) $_POST['id_produk'];
    $nama_produk = clean_input($_POST['nama_produk'], $conn);
    $stok = (int) $_POST['stok'];
    $harga = (int) $_POST['harga'];

    if ($nama_produk && $stok >= 0 && $harga >= 0) {
        $query = "UPDATE produk SET nama_produk=?, stok=?, harga=? WHERE id_produk=?";
        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, "siii", $nama_produk, $stok, $harga, $id_produk);
        mysqli_stmt_execute($stmt);
        header("Location: produk.php");
        exit();
    }
}

// Ambil data produk
$result = mysqli_query($conn, "SELECT * FROM produk");

// Jika sedang mengedit produk
$edit_data = null;
if (isset($_GET['edit'])) {
    $id_produk = (int) $_GET['edit'];
    $query = "SELECT * FROM produk WHERE id_produk=?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "i", $id_produk);
    mysqli_stmt_execute($stmt);
    $edit_data = mysqli_stmt_get_result($stmt)->fetch_assoc();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Produk</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
       /* Mode Gelap (Dark Mode) */
body.dark-mode {
    background-color: #121212;
    color: #ffffff;
    font-family: Arial, sans-serif;
    margin: 0;
    padding: 20px;
    text-align: center;
}

/* Judul Halaman */
h2 {
    color: #ffcc00;
}

/* Form */
form {
    background-color: #1e1e1e;
    padding: 15px;
    border-radius: 8px;
    display: inline-block;
    box-shadow: 0px 0px 10px rgba(255, 255, 255, 0.2);
}

input[type="text"],
input[type="number"] {
    width: 90%;
    padding: 8px;
    margin: 5px 0;
    border: 1px solid #444;
    border-radius: 5px;
    background-color: #333;
    color: white;
}

button {
    background-color: #ffcc00;
    color: black;
    border: none;
    padding: 10px 15px;
    margin-top: 10px;
    border-radius: 5px;
    cursor: pointer;
    font-weight: bold;
}

button:hover {
    background-color: #ffaa00;
}

/* Tabel */
table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 20px;
}

table, th, td {
    border: 1px solid #444;
}

th {
    background-color: #333;
    padding: 10px;
}

td {
    padding: 10px;
    background-color: #1e1e1e;
}

/* Link */
a {
    text-decoration: none;
    color: #ffcc00;
    font-weight: bold;
    margin: 0 5px;
}

a:hover {
    color: #ffaa00;
}

/* Tombol Aksi */
td a {
    padding: 5px 10px;
    background-color: #ffcc00;
    border-radius: 5px;
    color: black;
}

td a:hover {
    background-color: #ffaa00;
}

/* Tombol Batal */
a[href="produk.php"] {
    display: inline-block;
    margin-top: 10px;
    padding: 8px 12px;
    background-color: #ff4444;
    color: white;
    border-radius: 5px;
}

a[href="produk.php"]:hover {
    background-color: #cc0000;
}

    </style>
</head>
<body class="dark-mode">
    <h2>Manajemen Produk</h2>

    <?php if ($edit_data) { ?>
        <h3>Edit Produk</h3>
        <form method="POST">
            <input type="hidden" name="id_produk" value="<?= htmlspecialchars($edit_data['id_produk']); ?>">
            <input type="text" name="nama_produk" value="<?= htmlspecialchars($edit_data['nama_produk']); ?>" required>
            <input type="number" name="stok" value="<?= htmlspecialchars($edit_data['stok']); ?>" required>
            <input type="number" name="harga" value="<?= htmlspecialchars($edit_data['harga']); ?>" required>
            <button type="submit" name="edit">Simpan Perubahan</button>
        </form>
        <a href="produk.php">Batal</a>
    <?php } else { ?>
        <h3>Tambah Produk</h3>
        <form method="POST">
            <input type="text" name="nama_produk" placeholder="Nama Produk" required>
            <input type="number" name="stok" placeholder="Stok" required>
            <input type="number" name="harga" placeholder="Harga" required>
            <button type="submit" name="tambah">Tambah Produk</button>
        </form>
    <?php } ?>

    <table border="1">
        <tr>
            <th>ID</th>
            <th>Nama Produk</th>
            <th>Stok</th>
            <th>Harga</th>
            <th>Aksi</th>
        </tr>
        <?php while ($row = mysqli_fetch_assoc($result)) { ?>
            <tr>
                <td><?= htmlspecialchars($row['id_produk']); ?></td>
                <td><?= htmlspecialchars($row['nama_produk']); ?></td>
                <td><?= htmlspecialchars($row['stok']); ?></td>
                <td><?= htmlspecialchars($row['harga']); ?></td>
                <td>
                    <a href="produk.php?edit=<?= htmlspecialchars($row['id_produk']); ?>">Edit</a>
                    <a href="produk.php?hapus=<?= htmlspecialchars($row['id_produk']); ?>" onclick="return confirm('Hapus produk ini?');">Hapus</a>
                </td>
            </tr>
        <?php } ?>
    </table>
    <br>
    <a href="../index.php">Kembali ke Beranda</a>
</body>
</html>
