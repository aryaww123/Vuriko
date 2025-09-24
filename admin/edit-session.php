<?php
include "../connection/konek.php";

$id = $_GET['id'] ?? null;
if (!$id) {
  die("ID tidak ditemukan.");
}

// Ambil data sesi
$result = mysqli_query($koneksi, "SELECT * FROM sesi WHERE id_sesi = '$id'") or die("Query error: " . mysqli_error($koneksi));
$data = mysqli_fetch_assoc($result);
if (!$data) {
  die("Data sesi tidak ditemukan.");
}

// Ambil data psikolog
$psikolog_query = mysqli_query($koneksi, "SELECT id_akun, nama_lengkap FROM data_akun WHERE role = 'psikolog'");
$psikologs = [];
while ($row = mysqli_fetch_assoc($psikolog_query)) {
  $psikologs[] = $row;
}

// Dropdown psikolog
$dropdown_psikolog = '<option value="">-- Pilih Psikolog --</option>';
foreach ($psikologs as $p) {
  $selected = ($p['id_akun'] == $data['psikolog']) ? "selected" : "";
  $dropdown_psikolog .= '<option value="' . $p['id_akun'] . '" ' . $selected . '>' . htmlspecialchars($p['nama_lengkap']) . '</option>';
}

// Proses update
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $nama = mysqli_real_escape_string($koneksi, $_POST['nama_klien']);
  $nomor = mysqli_real_escape_string($koneksi, $_POST['nomor']);
  $alamat = mysqli_real_escape_string($koneksi, $_POST['alamat']);
  $ttl = mysqli_real_escape_string($koneksi, $_POST['ttl']);
  $keluhan = mysqli_real_escape_string($koneksi, $_POST['keluhan']);
  $psikolog = mysqli_real_escape_string($koneksi, $_POST['psikolog']);
  $tanggal_sesi = mysqli_real_escape_string($koneksi, $_POST['tanggal_sesi']);
  $jam_sesi = mysqli_real_escape_string($koneksi, $_POST['jam_sesi']);
  $status_pembayaran = mysqli_real_escape_string($koneksi, $_POST['status_pembayaran']);
  $status_sesi = mysqli_real_escape_string($koneksi, $_POST['status_sesi']);

  $query = "UPDATE sesi SET 
              nama_client='$nama',
              nomor='$nomor',
              alamat='$alamat',
              ttl='$ttl',
              keluhan='$keluhan',
              psikolog='$psikolog',
              tanggal_sesi='$tanggal_sesi',
              jam_sesi='$jam_sesi',
              status_pembayaran='$status_pembayaran',
              status_sesi='$status_sesi'
            WHERE id_sesi='$id'";

  if (mysqli_query($koneksi, $query)) {
    echo "<script>alert('Data sesi berhasil diperbarui!'); window.location='index-admin.php';</script>";
    exit;
  } else {
    die("Update gagal: " . mysqli_error($koneksi));
  }
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <title>Edit Sesi</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="p-4">
  <h3>Edit Sesi Klien</h3>

  <form method="POST">
    <div class="row mb-3">
      <div class="col-md-6">
        <label class="form-label">Nama Klien</label>
        <input type="text" name="nama_klien" class="form-control" value="<?= htmlspecialchars($data['nama_client']) ?>" required>
      </div>
      <div class="col-md-6">
        <label class="form-label">Nomor HP</label>
        <input type="text" name="nomor" class="form-control" value="<?= htmlspecialchars($data['nomor']) ?>" required>
      </div>
    </div>

    <div class="row mb-3">
      <div class="col-md-6">
        <label class="form-label">Alamat</label>
        <input type="text" name="alamat" class="form-control" value="<?= htmlspecialchars($data['alamat']) ?>">
      </div>
      <div class="col-md-6">
        <label class="form-label">Tanggal Lahir</label>
        <input type="date" name="ttl" class="form-control" value="<?= htmlspecialchars($data['ttl']) ?>">
      </div>
    </div>

    <hr>

    <div class="mb-3">
      <label class="form-label">Keluhan</label>
      <textarea name="keluhan" class="form-control"><?= htmlspecialchars($data['keluhan']) ?></textarea>
    </div>

    <div class="row mb-3">
      <div class="col">
        <label class="form-label">Psikolog</label>
        <select name="psikolog" class="form-select" required>
          <?= $dropdown_psikolog ?>
        </select>
      </div>
      <div class="col">
        <label class="form-label">Tanggal Sesi</label>
        <input type="date" name="tanggal_sesi" class="form-control" value="<?= $data['tanggal_sesi'] ?>" required>
      </div>
      <div class="col">
        <label class="form-label">Jam Sesi</label>
        <input type="time" name="jam_sesi" class="form-control" value="<?= $data['jam_sesi'] ?>" required>
      </div>
    </div>

    <div class="row mb-3">
      <div class="col">
        <label class="form-label">Status Pembayaran</label>
        <select name="status_pembayaran" class="form-select">
          <option value="Belum Lunas" <?= $data['status_pembayaran'] == "Belum Lunas" ? "selected" : "" ?>>Belum Lunas</option>
          <option value="Lunas" <?= $data['status_pembayaran'] == "Lunas" ? "selected" : "" ?>>Lunas</option>
        </select>
      </div>
      <div class="col">
        <label class="form-label">Status Sesi</label>
        <select name="status_sesi" class="form-select">
          <option value="Belum" <?= $data['status_sesi'] == "Belum" ? "selected" : "" ?>>Belum</option>
          <option value="Sudah Selesai" <?= $data['status_sesi'] == "Sudah Selesai" ? "selected" : "" ?>>Sudah Selesai</option>
        </select>
      </div>
    </div>

    <div>
      <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
      <a href="index-admin.php" class="btn btn-secondary">Batal</a>
    </div>
  </form>
</body>

</html>
