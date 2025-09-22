<?php
session_start();
include "../connection/konek.php";

if (!isset($_SESSION["user"]) || $_SESSION["user"]["role"] != "admin") {
    header( "Location: ../login.php");
    exit();
}
?>

<!doctype html>
<html lang="en">

<head>
    <title>Binar Kalbu</title>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />

    <!-- Bootstrap CSS v5.3.3 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <!-- DataTables Bootstrap 5 CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="style.css">

</head>

<body>
    <header>
        <!-- place navbar here -->
    </header>
    <main>
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-3 col-lg-2 p-0">
                    <?php include '../partition/sidebar.php' ?>
                </div>

                <div class="col-md-9 col-lg-10">
                    <h2>Semua Sesi</h2>
                    <table id="myTable" class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Tanggal sesi dibuat</th>
                                <th>Jam sesi dibuat</th>
                                <th>Nama Klien</th>
                                <th>Keluhan</th>
                                <th>Status Sesi</th>
                                <th>Status pembayaran</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>

                    <!-- jQuery & DataTables -->
                     <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
                    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
                    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

                    <script>
                        $(document).ready(function () {
                            $('#myTable').DataTable({
                                "processing": true,
                                "serverSide": true,
                                "ajax": "../fetching/fetch-session.php",
                                "pageLength": 10,
                                "lengthMenu": [5, 10, 25, 50, 100],
                                "searching": true,
                                "ordering": false,
                                "autoWidth": false,
                                "columnDefs": [
                                    { width: '50px', targets: 0 },
                                    { width: '110px', targets: 1 },
                                    { width: '90px', targets: 2 },
                                    { width: '180px', targets: 3, className: 'wrap' },
                                    { width: '320px', targets: 4, className: 'wrap' },
                                    { width: '120px', targets: 5 },
                                    { width: '120px', targets: 6 }
                                ],
                                responsive: true
                            });
                        });
                    </script>

                </div>
            </div>

        </div>
    </main>
    <footer>
        <!-- place footer here -->
    </footer>
    <!-- Bootstrap JavaScript Libraries -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
        integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r"
        crossorigin="anonymous"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"
        integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+"
        crossorigin="anonymous"></script>
</body>

</html>