<?php
include "../connection/konek.php"; // <-- ini include koneksi database

$start  = isset($_GET['start']) ? intval($_GET['start']) :0;
$length = isset($_GET['length']) ? intval($_GET['length']) :10;
$search = isset($_GET['search']['value']) ? $_GET['search']['value'] :'';

// Hitung total data
$totalDataQuery = mysqli_query($koneksi, "SELECT COUNT(*) AS total FROM sesi");
$totalData = mysqli_fetch_assoc($totalDataQuery)['total'];

// Query dasar
$query = "SELECT * FROM sesi";

// Jika ada pencarian
if (!empty($search)) {
    $query .= " WHERE nama_client LIKE '%$search%' 
                OR keluhan LIKE '%$search%' 
                OR status_sesi LIKE '%$search%'";
}

// Hitung total setelah filter
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
    $data[] = [
        $no++,
        $row['tanggal_sesi_dibuat'],
        $row['jam_sesi_dibuat'],
        $row['nama_client'],
        $row['keluhan'],
        $row['status_sesi'],
        $row['status_pembayaran']
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