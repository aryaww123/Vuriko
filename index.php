<?php
session_start();
include "connection/konek.php";
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login - Bootstrap</title>

    <!-- Bootstrap CSS (CDN) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS (salin dari contoh Bootstrap sign-in.css) -->
    <style>
      html,
      body {
        height: 100%;
      }

      body {
        display: flex;
        align-items: center;
        padding-top: 40px;
        padding-bottom: 40px;
        background-color: #f5f5f5;
      }

      .form-signin {
        max-width: 330px;
        padding: 15px;
      }

      .form-signin .form-floating:focus-within {
        z-index: 2;
      }

      .form-signin input[type="email"] {
        margin-bottom: -1px;
        border-bottom-right-radius: 0;
        border-bottom-left-radius: 0;
      }

      .form-signin input[type="password"] {
        margin-bottom: 10px;
        border-top-left-radius: 0;
        border-top-right-radius: 0;
      }
    </style>
  </head>
  <body class="text-center">

  <?php
    if (isset($_POST['username'])){
      $username = mysqli_real_escape_string($koneksi, $_POST['username']);
      $password = mysqli_real_escape_string($koneksi, $_POST['password']);
      $md5Pass = md5($password);

      $query = mysqli_query($koneksi,"SELECT*FROM data_akun where username='$username' and password='$md5Pass' LIMIT 1");

      if (mysqli_num_rows($query) > 0) {
        $data = mysqli_fetch_assoc($query);

        $_SESSION["user"] = [
          'id'      => $data['id_akun'],
          'username'=> $data['username'],
          'nama'    => $data['nama_lengkap'],
          'role'    => $data['role']
        ];

        $role = strtolower(trim($data['role']));

        switch ($role) {
          case 'admin':
            header('Location: admin/index-admin.php');
            exit;

          case 'psikolog':
            header('Location: psikolog/index-psikolog.php');
            exit;
          
          case 'klien':
            header('Location: user/index-user.php');
            exit;

          default:
            echo "<script>alert('Role tidak dikenali!');</script>";
            
        }
    } else {
      echo "<script>alert('Username atau Password salah!');</script>";
    }
  }
  ?>
    <main class="form-signin w-100 m-auto">
      <form method="POST">
        <img class="mb-4" src="assets/2.png" alt="" width="200" height="90">
        <h1 class="h3 mb-3 fw-normal">Please sign in</h1>

        <div class="form-floating">
          <input type="text" class="form-control" id="floatingInput" placeholder="Username" name="username" required>
          <label for="floatingInput">Username</label>
        </div>
        <div class="form-floating">
          <input type="password" class="form-control" id="floatingPassword" placeholder="Password" name="password">
          <label for="floatingPassword">Password</label>
        </div>

        <div class="checkbox mb-3">
          <label>
            <input type="checkbox" value="remember-me"> Remember me
          </label>
        </div>
        <button class="btn btn-primary w-100 py-2" type="submit">Sign in</button>
        <p class="mt-5 mb-3 text-muted">&copy; 2025</p>
      </form>
    </main>

    <!-- Bootstrap JS (CDN) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  </body>
</html>
