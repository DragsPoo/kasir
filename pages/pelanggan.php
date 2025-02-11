<?php
session_start();
include '../config/koneksi.php';

// Fungsi untuk membersihkan input
function clean_input($data, $conn) {
    return mysqli_real_escape_string($conn, trim($data));
}

// Tambah pelanggan
if (isset($_POST['tambah'])) {
    $nama_pelanggan = clean_input($_POST['nama_pelanggan'], $conn);
    $alamat = clean_input($_POST['alamat'], $conn);
    $no_telp = clean_input($_POST['no_telp'], $conn);

    if ($nama_pelanggan && $alamat && $no_telp) {
        $query = "INSERT INTO pelanggan (nama_pelanggan, alamat, no_telp) VALUES (?, ?, ?)";
        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, "sss", $nama_pelanggan, $alamat, $no_telp);
        mysqli_stmt_execute($stmt);
        header("Location: pelanggan.php");
        exit();
    }
}

// Edit pelanggan
$edit_data = null;
if (isset($_GET['edit'])) {
    $id_pelanggan = (int) $_GET['edit'];
    $query = "SELECT * FROM pelanggan WHERE id_pelanggan=?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "i", $id_pelanggan);
    mysqli_stmt_execute($stmt);
    $edit_data = mysqli_stmt_get_result($stmt)->fetch_assoc();
}

// Simpan perubahan pelanggan
if (isset($_POST['edit'])) {
    $id_pelanggan = (int) $_POST['id_pelanggan'];
    $nama_pelanggan = clean_input($_POST['nama_pelanggan'], $conn);
    $alamat = clean_input($_POST['alamat'], $conn);
    $no_telp = clean_input($_POST['no_telp'], $conn);

    if ($nama_pelanggan && $alamat && $no_telp) {
        $query = "UPDATE pelanggan SET nama_pelanggan=?, alamat=?, no_telp=? WHERE id_pelanggan=?";
        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, "sssi", $nama_pelanggan, $alamat, $no_telp, $id_pelanggan);
        mysqli_stmt_execute($stmt);
        header("Location: pelanggan.php");
        exit();
    }
}

// Hapus pelanggan
if (isset($_GET['hapus'])) {
    $id_pelanggan = (int) $_GET['hapus'];
    $query = "DELETE FROM pelanggan WHERE id_pelanggan=?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "i", $id_pelanggan);
    mysqli_stmt_execute($stmt);
    header("Location: pelanggan.php");
    exit();
}

// Ambil data pelanggan
$result = mysqli_query($conn, "SELECT * FROM pelanggan");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Pelanggan</title>
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
        input {
            background: #333;
            color: white;
            border: 1px solid #555;
        }
        input::placeholder {
            color: #bbb;
        }
        .btn-primary {
            background-color: #007bff;
            border: none;
        }
        .btn-primary:hover {
            background-color: #0056b3;
        }
        a {
            color: #00aaff;
        }
        a:hover {
            color: #0088cc;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2 class="text-center">Manajemen Pelanggan</h2>

        <?php if ($edit_data) { ?>
            <!-- Form Edit Pelanggan -->
            <h3>Edit Pelanggan</h3>
            <form method="POST">
                <input type="hidden" name="id_pelanggan" value="<?= htmlspecialchars($edit_data['id_pelanggan']); ?>">
                <div class="mb-3">
                    <label class="form-label">Nama Pelanggan:</label>
                    <input type="text" class="form-control" name="nama_pelanggan" value="<?= htmlspecialchars($edit_data['nama_pelanggan']); ?>" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Alamat:</label>
                    <input type="text" class="form-control" name="alamat" value="<?= htmlspecialchars($edit_data['alamat']); ?>" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">No. Telepon:</label>
                    <input type="text" class="form-control" name="no_telp" value="<?= htmlspecialchars($edit_data['no_telp']); ?>" required>
                </div>
                <button type="submit" class="btn btn-success w-100" name="edit">Simpan Perubahan</button>
                <br><br>
                <a href="pelanggan.php" class="btn btn-secondary w-100">Batal</a>
            </form>
        <?php } else { ?>
            <!-- Form Tambah Pelanggan -->
            <h3>Tambah Pelanggan</h3>
            <form method="POST">
                <div class="mb-3">
                    <label class="form-label">Nama Pelanggan:</label>
                    <input type="text" class="form-control" name="nama_pelanggan" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Alamat:</label>
                    <input type="text" class="form-control" name="alamat" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">No. Telepon:</label>
                    <input type="text" class="form-control" name="no_telp" required>
                </div>
                <button type="submit" class="btn btn-primary w-100" name="tambah">Tambah Pelanggan</button>
            </form>
        <?php } ?>

        <br>
        <table class="table table-dark table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nama Pelanggan</th>
                    <th>Alamat</th>
                    <th>No. Telepon</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                    <tr>
                        <td><?= htmlspecialchars($row['id_pelanggan']); ?></td>
                        <td><?= htmlspecialchars($row['nama_pelanggan']); ?></td>
                        <td><?= htmlspecialchars($row['alamat']); ?></td>
                        <td><?= htmlspecialchars($row['no_telp']); ?></td>
                        <td>
                            <a href="pelanggan.php?edit=<?= htmlspecialchars($row['id_pelanggan']); ?>" class="btn btn-warning btn-sm">Edit</a>
                            <a href="pelanggan.php?hapus=<?= htmlspecialchars($row['id_pelanggan']); ?>" class="btn btn-danger btn-sm" onclick="return confirm('Hapus pelanggan ini?');">Hapus</a>
                        </td>
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
