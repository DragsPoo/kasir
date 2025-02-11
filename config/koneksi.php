<?php
$host = "localhost";
$user = "root"; // Sesuaikan dengan user MySQL Anda
$pass = ""; // Sesuaikan jika ada password
$db   = "kasir";

$conn = mysqli_connect($host, $user, $pass, $db);

if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}
?>
