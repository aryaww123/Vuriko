<?php
session_start();
include "../connection/konek.php";

if (!isset($_SESSION["user"]) || $_SESSION["user"]["role"] != "admin") {
    header("Location: ../login.php");
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

    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
        }

        #myTable {
            font-size: 13px;
            width: 100%;
            table-layout: fixed;
        }

        #myTable th {
            font-size: 0.85rem;
            font-weight: 600;
        }

        #myTable td {
            font-size: 0.9rem;
            line-height: 1.4;
        }

        .wrap {
            white-space: normal !important;
        }

        @media (max-width:768px) {

            #myTable th,
            #myTable td {
                font-size: 0.8rem;
            }
        }

        /* samakan padding header & body */
        .dataTables_scrollHead th,
        .dataTables_scrollBody td {
            padding: 8px 10px;
            border: 1px solid #dee2e6;
            vertical-align: middle;
        }

        /* hilangkan double border atas */
        .dataTables_scrollHead table {
            margin-bottom: 0 !important;
            border-bottom: none !important;
        }

        /* hilangkan double border bawah */
        .dataTables_scrollBody table {
            border-top: none !important;
        }

        #myTable th,
        #myTable td {
            font-size: 0.7rem !important;
        }

        #myTable td.ellipsis>span {
            display: block !important;
            width: 100% !important;
            white-space: nowrap !important;
            overflow: hidden !important;
            text-overflow: ellipsis !important;
        }

        td.ellipsis>span {
            display: block;
            width: 100%;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        #myTable td .btn {
            font-size: 0.5rem;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        #myTable td .btn i {
            font-size: 0.7rem;
        }

        #myTable td .d-flex {
            flex-wrap: nowrap;
        }
    </style>

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
                    <div class="table_responsive">
                        <table id="myTable" class="table table-striped table-bordered display" style="width: 100%;">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Tanggal sesi dibuat</th>
                                    <th>Jam sesi dibuat</th>
                                    <th>Nama Klien</th>
                                    <th>Psikolog</th>
                                    <th>Tanggal Sesi</th>
                                    <th>Jam Sesi</th>
                                    <th>Status Sesi</th>
                                    <th>Status pembayaran</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                    <div class="modal fade" id="detailModal" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Detail Sesi</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body">
                                    <p><strong>Nama Klien:</strong> <span id="detailNama"></span></p>
                                    <p><strong>Keluhan:</strong> <span id="detailKeluhan"></span></p>
                                    <p><strong>Psikolog:</strong> <span id="detailPsikolog"></span></p>
                                    <p><strong>Tanggal Sesi:</strong> <span id="detailTanggal"></span></p>
                                    <p><strong>Jam Sesi:</strong> <span id="detailJam"></span></p>
                                </div>
                            </div>
                        </div>
                    </div>


                    <!-- jQuery & DataTables -->
                    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
                    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
                    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
                    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

                    <script>
                        $(document).ready(function () {
                            $('#myTable').DataTable({
                                "processing": true,
                                "serverSide": true,
                                "ajax": "../fetching/fetch-cleared-session.php",
                                "pageLength": 10,
                                "lengthMenu": [5, 10, 25, 50, 100],
                                "searching": true,
                                "ordering": true,
                                "autoWidth": false,
                                "columnDefs": [
                                    { width: '50px', targets: 0 },
                                    { width: '90px', targets: 1 },
                                    { width: '90px', targets: 2 },
                                    { width: '130px', targets: 3, className: 'wrap' },
                                    // { width: '320px', targets: 4, className: 'wrap' },
                                    { width: '90px', targets: 4 },
                                    { width: '120px', targets: 5 },
                                    { width: '70px', targets: 6 },
                                    { width: '50px', targets: 7 },
                                    { width: '50px', targets: 8 },
                                    { width: '70px', targets: 9 }

                                ],
                                responsive: true
                            });
                        });
                        // Detail Button
                        $(document).on("click", ".detail-btn", function () {
                            $("#detailNama").text($(this).data("nama"));
                            $("#detailKeluhan").text($(this).data("keluhan"));
                            $("#detailPsikolog").text($(this).data("psikolog"));
                            $("#detailTanggal").text($(this).data("tanggal"));
                            $("#detailJam").text($(this).data("jam"));
                            $("#detailModal").modal("show");
                        });

                        // Delete Button
                        $(document).on("click", ".delete-btn", function () {
                            var id = $(this).data("id");

                            Swal.fire({
                                title: "Apakah kamu yakin?",
                                text: "Data ini akan dihapus permanen!",
                                icon: "warning",
                                showCancelButton: true,
                                confirmButtonColor: "#d33",
                                cancelButtonColor: "#3085d6",
                                confirmButtonText: "Ya, hapus!"
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    window.location.href = "delete-session.php?id=" + id;
                                }
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