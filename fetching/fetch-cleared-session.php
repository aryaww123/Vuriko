<?php
include "../connection/konek.php"; // <-- ini include koneksi database

$start = isset($_GET['start']) ? intval($_GET['start']) : 0;
$length = isset($_GET['length']) ? intval($_GET['length']) : 10;
$search = isset($_GET['search']['value']) ? $_GET['search']['value'] : '';

// Hitung total data
$totalDataQuery = mysqli_query($koneksi, "SELECT COUNT(*) AS total FROM sesi JOIN data_akun ON sesi.psikolog = data_akun.id_akun");
$totalData = mysqli_fetch_assoc($totalDataQuery)['total'];

// Query dasar
$query = "SELECT sesi.*, data_akun.nama_lengkap AS nama_psikolog FROM sesi JOIN data_akun ON sesi.psikolog = data_akun.id_akun WHERE status_sesi='Sudah Selesai'";

// Jika ada pencarian
if (!empty($search)) {
    $query .= " WHERE sesi.nama_client LIKE '%$search%' 
                OR sesi.keluhan LIKE '%$search%' 
                OR sesi.status_sesi LIKE '%$search%'
                OR data_akun.nama_lengkap LIKE '%$search%'";
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

    $aksi = '
    <button class="btn btn-sm btn-primary detail-btn" 
            data-id="' . $row["id_sesi"] . '" 
            data-nama="' . $row["nama_client"] . '" 
            data-keluhan="' . $row["keluhan"] . '" 
            data-psikolog="' . $row["nama_psikolog"] . '" 
            data-tanggal="' . $row["tanggal_sesi"] . '" 
            data-jam="' . $row["jam_sesi"] . '">
        Detail
    </button>
    <a href="edit-session.php?id=' . $row["id_sesi"] . '" class="btn btn-sm btn-warning">Edit</a>
    <button class="btn btn-sm btn-danger delete-btn" data-id="' . $row["id_sesi"] . '">Hapus</button>

    ';

    $data[] = [
        $no++,
        $row['tanggal_sesi_dibuat'],
        $row['jam_sesi_dibuat'],
        $row['nama_client'],
        $row['keluhan'],
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