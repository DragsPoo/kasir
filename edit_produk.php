<?php
include 'config/koneksi.php';

if (isset($_POST['update'])) {
    $id = $_POST['id_produk'];
    $nama = $_POST['nama_produk'];
    $stok = $_POST['stok'];
    $harga = $_POST['harga'];
    
    $query = "UPDATE produk SET nama_produk='$nama', stok='$stok', harga='$harga' WHERE id_produk='$id'";
    mysqli_query($conn, $query);
    header("Location: manajemen_produk.php");
    exit();
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $result = mysqli_query($conn, "SELECT * FROM produk WHERE id_produk='$id'");
    $row = mysqli_fetch_assoc($result);
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Produk</title>
</head>
<body>
    <form method="POST" action="">
        <input type="hidden" name="id_produk" value="<?php echo isset($row['id_produk']) ? $row['id_produk'] : ''; ?>">
        <label>Nama Produk:</label>
        <input type="text" name="nama_produk" value="<?php echo isset($row['nama_produk']) ? $row['nama_produk'] : ''; ?>" required>
        <label>Stok:</label>
        <input type="number" name="stok" value="<?php echo isset($row['stok']) ? $row['stok'] : ''; ?>" required>
        <label>Harga:</label>
        <input type="text" name="harga" value="<?php echo isset($row['harga']) ? $row['harga'] : ''; ?>" required>
        <button type="submit" name="update">Update</button>
    </form>
    <br>
    <a href="index.php">Kembali ke Beranda</a>
</body>
</html>
