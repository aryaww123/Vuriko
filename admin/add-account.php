<?php
include "../connection/konek.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama = mysqli_real_escape_string($koneksi, $_POST['nama']);
    $role = mysqli_real_escape_string($koneksi, $_POST['role']);
    $alamat = mysqli_real_escape_string($koneksi, $_POST['alamat']);
    $username = mysqli_real_escape_string($koneksi, $_POST['username_klien']);
    $password = mysqli_real_escape_string($koneksi, $_POST['password_klien']);
    $md5Pass = md5($password);
    $ttl = mysqli_real_escape_string($koneksi, $_POST['ttl']);

    // simpan ke database
    $query = "INSERT INTO data_akun (nama_lengkap, role, alamat, username, password, ttl) 
              VALUES ('$nama', '$role', '$alamat','$username', '$md5Pass', '$ttl' )";

    if (mysqli_query($koneksi, $query)) {
        header("Location: all-account.php?success=1");
        exit;
    } else {
        $error = "Gagal menambahkan akun: " . mysqli_error($koneksi);
    }
}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Account</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <!-- DataTables Bootstrap 5 CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
  <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container-fluid">
    <div class="row">
        <!-- Sidebar -->
        <div class="col-md-3 col-lg-2 p-0  bg-light">
            <?php include "../partition/sidebar.php"?>
        </div>

        <!-- Form Area -->
        <div class="col-md-9 col-lg-10 p-4">
            <h2>Tambah Akun</h2>
            
            <?php if (!empty($error)) : ?>
                <div class="alert alert-danger"><?= $error ?></div>
            <?php endif; ?>

            <form method="POST" action="add-account.php">
                <div class="mb-3">
                    <label for="nama" class="form-label">Nama Lengkap</label>
                    <input type="text" class="form-control" id="nama" name="nama" required>
                </div>

                <div class="row mb-3">
                    <div class="col-md-4">
                        <label class="form-label">Username</label>
                        <input type="text" name="username_klien" class="form-control required">

                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Password</label>
                        <input type="text" name="password_klien" class="form-control" required>
                    </div>

                    <div class="col-md-4">
                        <label for="role" class="form-label">Role</label>
                        <select class="form-select" id="role" name="role" required>
                            <option value="">-- Pilih Role --</option>
                            <option value="admin">Admin</option>
                            <option value="user">Klien</option>
                            <option value="psikolog">Psikolog</option>
                        </select>

                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Tempat dan Tanggal Lahir</label>
                    <input type="text" name="ttl" class="form-control" placeholder="Contoh: Jakarta, 01-01-2000">
                </div>

                <div class="mb-3">
                    <label for="alamat" class="form-label">Alamat</label>
                    <textarea class="form-control" id="alamat" name="alamat" rows="3" required></textarea>
                </div>

                <button type="submit" class="btn btn-primary">Simpan</button>
                <a href="all-account.php" class="btn btn-secondary">Kembali</a>
            </form>
        </div>
    </div>
</div>
</body>
</html>
