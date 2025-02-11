<?php
session_start();
include 'config/koneksi.php';


// Cek apakah user sudah login dan memiliki akses Admin
if (!isset($_SESSION['username']) || $_SESSION['akses'] != 'Adminisator') {
    header("Location: login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = mysqli_real_escape_string($conn, $_POST['password']); // Password tanpa hash
    $akses = mysqli_real_escape_string($conn, $_POST['akses']);

    // Cek apakah username sudah ada
    $query_check = "SELECT * FROM users WHERE username = '$username'";
    $result_check = mysqli_query($conn, $query_check);
    
    if (mysqli_num_rows($result_check) > 0) {
        $error = "Username sudah digunakan!";
    } else {
        $query = "INSERT INTO users (username, password, akses) VALUES ('$username', '$password', '$akses')";
        if (mysqli_query($conn, $query)) {
            header("Location: login.php");
            exit();
        } else {
            $error = "Registrasi gagal!";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrasi Pengguna</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body class="dark-mode">

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-4">
            <div class="card bg-dark text-white">
                <div class="card-body">
                    <h4 class="text-center">Registrasi Pengguna</h4>
                    <?php if (isset($error)) { echo "<p class='text-danger text-center'>$error</p>"; } ?>
                    <form method="POST">
                        <div class="mb-3">
                            <label class="form-label">Username</label>
                            <input type="text" name="username" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Password</label>
                            <input type="password" name="password" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Hak Akses</label>
                            <select name="akses" class="form-select" required>
                                <option value="Adminisator">Administrator</option>
                                <option value="Petugas">Petugas</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Daftar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>
