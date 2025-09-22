<!doctype html>
<html lang="en">

<head>
  <title>Binar Kalbu</title>
  <!-- Required meta tags -->
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />

  <!-- Bootstrap CSS v5.2.1 -->
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
      <div class="col-md-3 col-lg-2 p-0 bg-light">
        <?php include "../partition/sidebar.php" ?>
      </div>

      <!-- Form Area -->
      <div class="col-md-9 col-lg-10 p-4">
        <h3 class="mb-4">Tambah Sesi Konsultasi</h3>

        <form action="add-session.php" method="POST">
          <div class="row mb-3">
            <div class="col-md-6">
              <label class="form-label">Nama Klien</label>
              <input type="text" name="nama_client" class="form-control" required>
            </div>
            <div class="col-md-6">
              <label class="form-label">Nomor Klien</label>
              <input type="text" name="nomor_client" class="form-control" required>
            </div>
          </div>

          <div class="mb-3">
            <label class="form-label">Alamat Klien</label>
            <textarea name="alamat_client" class="form-control" rows="2" required></textarea>
          </div>

          <div class="row mb-3">
            <div class="col-md-6">
              <label class="form-label">Tempat, Tanggal Lahir</label>
              <input type="text" name="ttl_client" class="form-control" placeholder="Contoh: Jakarta, 01-01-2000">
            </div>
            <div class="col-md-6">
              <label class="form-label">Dokter / Psikolog</label>
              <input type="text" name="dokter" class="form-control">
            </div>
          </div>

          <div class="mb-3">
            <label class="form-label">Keluhan / Diagnosis</label>
            <textarea name="keluhan" class="form-control" rows="3"></textarea>
          </div>

          <div class="row mb-3">
            <div class="col-md-6">
              <label class="form-label">Sesi</label>
              <input type="text" name="sesi[]" class="form-control" placeholder="Contoh: Sesi 1">
            </div>
            <div class="col-md-6">
              <label class="form-label">Status Pembayaran</label>
              <select name="status_pembayaran" class="form-select">
                <option value="Belum Lunas">Belum Lunas</option>
                <option value="Lunas">Lunas</option>
                <option value="DP">DP</option>
              </select>
            </div>
          </div>

          <!-- Tombol -->
          <div class="d-flex justify-content-end mt-4">
            <button type="button" class="btn btn-secondary me-2" onclick="window.history.back()">Batal</button>
            <button type="button" class="btn btn-info me-2" id="addSession">+ Tambah Sesi</button>
            <button type="submit" class="btn btn-primary">Simpan</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

  <!-- Script tambah sesi dinamis -->
  <script>
    document.getElementById("addSession").addEventListener("click", function () {
      const sesiInput = `
                <div class="row mb-3">
                    <div class="col-md-6">
                        <input type="text" name="sesi[]" class="form-control" placeholder="Contoh: Sesi tambahan">
                    </div>
                    <div class="col-md-6">
                        <select name="status_pembayaran" class="form-select">
                            <option value="Belum Lunas">Belum Lunas</option>
                            <option value="Lunas">Lunas</option>
                            <option value="DP">DP</option>
                        </select>
                    </div>
                </div>
            `;
      this.closest("form").insertAdjacentHTML("beforeend", sesiInput);
    });
  </script>
  <footer>
    <!-- place footer here -->
  </footer>
  <!-- Bootstrap JavaScript Libraries -->
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
    integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r"
    crossorigin="anonymous"></script>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"
    integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+"
    crossorigin="anonymous"></script>
</body>

</html>