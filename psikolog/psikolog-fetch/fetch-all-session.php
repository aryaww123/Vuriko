<?php
session_start();
include "../../connection/konek.php";


if (!isset($_SESSION["user"]["id"])) {
    echo json_encode(["error" => "Session expired"]);
    exit;
};

$id_psikolog = $_SESSION["user"]["id"];

$start = isset($_GET["start"]) ? intval($_GET["start"]) :0;
$length = isset($_GET["length"]) ? intval($_GET["length"]) : 10;
$search = isset($_GET["search"]["value"]) ? $_GET["search"]["value"] :'';

$totalDataQuery = mysqli_query($koneksi, "SELECT COUNT(*) AS total FROM sesi WHERE psikolog = '$id_psikolog'");
$totalData = mysqli_fetch_assoc($totalDataQuery)['total'];

$query = "
SELECT sesi.*, data_akun.nama_lengkap AS nama_psikolog 
FROM sesi 
JOIN data_akun ON sesi.psikolog =data_akun.id_akun
WHERE sesi.psikolog = '$id_psikolog'";

if (!empty($search)) {
    $query .= " AND (sesi.nama_client LIKE '%$search%' 
                OR sesi.keluhan LIKE '%$search%' 
                OR sesi.status_sesi LIKE '%$search%'
                OR data_akun.nama_lengkap LIKE '%$search%'
                OR sesi.status_pembayaran LIKE '%$search%'
                )";
}

$totalFilteredQuery = mysqli_query($koneksi, $query);
$totalFiltered = mysqli_num_rows($totalFilteredQuery);

// Tambahkan limit
$query .= " LIMIT $start, $length";
$dataQuery = mysqli_query($koneksi, $query);

if (!$dataQuery) {
    die("Query Error : " . mysqli_error($koneksi));
}

// Ambil data
$data = [];
$no = $start + 1;
while ($row = mysqli_fetch_assoc($dataQuery)) {

    $aksi = '
    <div class="d-flex gap-1 justify-content-center">
    <button class="btn btn-sm btn-primary detail-btn px-2 py-1"
        data-id="' . $row["id_sesi"] . '" 
        data-nama="' . $row["nama_client"] . '" 
        data-keluhan="' . $row["keluhan"] . '" 
        data-psikolog="' . $row["nama_psikolog"] . '" 
        data-tanggal="' . $row["tanggal_sesi"] . '" 
        data-jam="' . $row["jam_sesi"] . '"
        data-status_sesi="' . $row["status_sesi"] . '"
        data-status_pembayaran="' . $row["status_pembayaran"] . '">
        <i class="bi bi-eye"></i>
    </button>
</div>';

    $data[] = [
        $no++,
        $row['tanggal_sesi_dibuat'],
        $row['jam_sesi_dibuat'],
        $row['nama_client'],
        $row['nama_psikolog'],
        $row['tanggal_sesi'],
        $row['jam_sesi'],
        $row['status_sesi'],
        $row['status_pembayaran'],
        $aksi
    ];
}

// Format JSON
$response = [
    "draw" => intval($_GET['draw']),
    "recordsTotal" => intval($totalData),
    "recordsFiltered" => intval($totalFiltered),
    "data" => $data
];

header('Content-Type: application/json');
echo json_encode($response);
?>