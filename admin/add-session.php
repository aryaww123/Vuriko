<?php
include "../connection/konek.php";

// Ambil data psikolog sekali saja
$psikolog_query = mysqli_query($koneksi, "SELECT id_akun, nama_lengkap FROM data_akun WHERE role = 'psikolog'");
$psikologs = [];
while ($row = mysqli_fetch_assoc($psikolog_query)) {
  $psikologs[] = $row;
}

// Buat dropdown siap pakai
$dropdown_psikolog = '<option value="">-- Pilih Psikolog --</option>';
foreach ($psikologs as $p) {
  $dropdown_psikolog .= '<option value="' . $p['id_akun'] . '">' . htmlspecialchars($p['nama_lengkap']) . '</option>';
}

// Proses form
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $nama = mysqli_real_escape_string($koneksi, $_POST['nama_klien']);
  $nomor = mysqli_real_escape_string($koneksi, $_POST['nomor']);
  $alamat = mysqli_real_escape_string($koneksi, $_POST['alamat']);
  $ttl = mysqli_real_escape_string($koneksi, $_POST['ttl']);
  $keluhan = mysqli_real_escape_string($koneksi, $_POST['keluhan']);

  $psikologs_post = $_POST['psikolog'];
  $tanggal_sesis_post = $_POST['tanggal_sesi'];
  $jam_sesis_post = $_POST['jam_sesi'];
  $status_pembayaran_post = $_POST['status_pembayaran'];
  $status_sesi_post = $_POST['status_sesi'];

  $tanggal_sekarang = date("Y-m-d");
  $jam_sekarang = date("H:i:s");

  for ($i = 0; $i < count($psikologs_post); $i++) {
    $psikolog_terpilih = mysqli_real_escape_string($koneksi, $psikologs_post[$i]);
    $tanggal_sesi = mysqli_real_escape_string($koneksi, $tanggal_sesis_post[$i]);
    $jam_sesi = mysqli_real_escape_string($koneksi, $jam_sesis_post[$i]);
    $status = mysqli_real_escape_string($koneksi, $status_pembayaran_post[$i]);
    $status_sesi = mysqli_real_escape_string($koneksi, $status_sesi_post[$i]);

    $query = "INSERT INTO sesi 
                    (tanggal_sesi_dibuat, jam_sesi_dibuat, nama_client, nomor, alamat, ttl, keluhan, status_pembayaran, psikolog, tanggal_sesi, jam_sesi, status_sesi)
                  VALUES 
                    ('$tanggal_sekarang','$jam_sekarang','$nama','$nomor','$alamat','$ttl','$keluhan','$status','$psikolog_terpilih','$tanggal_sesi','$jam_sesi','$status_sesi')";

    mysqli_query($koneksi, $query);
  }

  echo "<script>alert('Data sesi berhasil ditambahkan!'); window.location='index-admin.php';</script>";
  exit;
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <title>Tambah Sesi</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
  <!-- DataTables Bootstrap 5 CSS -->
  <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
  <link rel="stylesheet" href="style.css">
</head>

<body>
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-3 col-lg-2 p-0">
        <?php include '../partition/sidebar.php' ?>
      </div>

      <div class="col-md-9 col-lg-10">
        <h3 class="mb-3">Tambah Sesi Klien</h3>

        <form method="POST">
          <!-- Data Klien -->
          <div class="row mb-3">
            <div class="col-md-6">
              <label class="form-label">Nama Klien</label>
              <input type="text" name="nama_klien" class="form-control" required>
            </div>
            <div class="col-md-6">
              <label class="form-label">Nomor HP</label>
              <input type="text" name="nomor" class="form-control" required>
            </div>
          </div>
          <div class="row mb-3">
            <div class="col-md-6">
              <label class="form-label">Alamat</label>
              <input type="text" name="alamat" class="form-control">
            </div>
            <div class="col-md-6">
              <label class="form-label">Tanggal Lahir</label>
              <input type="date" name="ttl" class="form-control">
            </div>
          </div>
          <hr>

          <!-- Sesi Pertama -->
          <div id="sessions">
            <div class="mb-3">
              <label class="form-label">Keluhan</label>
              <textarea name="keluhan" class="form-control"></textarea>
            </div>

            <div class="row mb-3">
              <div class="col">
                <label class="form-label">Psikolog</label>
                <select name="psikolog[]" class="form-select" required>
                  <?= $dropdown_psikolog ?>
                </select>
              </div>
              <div class="col">
                <label class="form-label">Tanggal Sesi</label>
                <input type="date" name="tanggal_sesi[]" class="form-control" required>
              </div>
              <div class="col">
                <label class="form-label">Jam Sesi</label>
                <input type="time" name="jam_sesi[]" class="form-control" required>
              </div>
              <div class="col">
                <label class="form-label">Status Pembayaran</label>
                <select name="status_pembayaran[]" class="form-select">
                  <option value="Belum Lunas">Belum Lunas</option>
                  <option value="Lunas">Lunas</option>
                </select>
              </div>
              <div class="col">
                <label class="form-label">Status Sesi</label>
                <select name="status_sesi[]" class="form-select">
                  <option value="Belum Lunas">Belum</option>
                  <option value="Lunas">Sudah Selesai</option>
                </select>
              </div>
            </div>
          </div>

          <!-- Tombol Tambah Sesi -->
          <button type="button" class="btn btn-sm btn-secondary mb-3" onclick="addSession()">+ Tambah Sesi</button>

          <div>
            <button type="submit" class="btn btn-primary">Simpan</button>
            <a href="index-admin.php" class="btn btn-danger">Batal</a>
          </div>
        </form>
      </div>

      <script>
        function addSession() {
          const sesiInput = `
          <hr>
            <div class="mb-3">
              <label class="form-label">Keluhan</label>
              <textarea name="keluhan" class="form-control"></textarea>
            </div>
        <div class="row mb-3">
            <div class="col-md-4">
                <label class="form-label">Psikolog</label>
                <select name="psikolog[]" class="form-select" required>
                    <?= $dropdown_psikolog ?>
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label">Tanggal Sesi</label>
                <input type="date" name="tanggal_sesi[]" class="form-control" required>
            </div>
            <div class="col-md-3">
                <label class="form-label">Jam Sesi</label>
                <input type="time" name="jam_sesi[]" class="form-control" required>
            </div>
            <div class="col-md-2">
                <label class="form-label">Status</label>
                <select name="status_pembayaran[]" class="form-select">
                    <option value="Belum Lunas">Belum Lunas</option>
                    <option value="Lunas">Lunas</option>
                </select>
            </div>
        </div>
    `;
          document.getElementById('sessions').insertAdjacentHTML('beforeend', sesiInput);
        }
      </script>
    </div>
  </div>
</body>

</html>