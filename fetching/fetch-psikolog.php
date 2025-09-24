<?php
include "../connection/konek.php";

$start = isset($_GET["start"]) ? intval($_GET["start"]) :0;
$length = isset($_GET["length"]) ? intval($_GET["length"]) :10;
$search = isset($_GET["search"]["value"]) ? $_GET["search"]["value"] :'';

$totalDataQuery = mysqli_query($koneksi, "SELECT COUNT(*) AS total FROM data_akun");
$totalData = mysqli_fetch_assoc($totalDataQuery)["total"];

$query = "SELECT * FROM data_akun WHERE role='psikolog'";

if(!empty($search)) {
    $query .= " WHERE nama_lengkap LIKE '%$search%'
                OR role LIKE '%$search%'";
}

$totalFilteredQuery = mysqli_query($koneksi, $query);
$totalFiltered = mysqli_num_rows($totalFilteredQuery);

$query .= " LIMIT $start, $length";
$dataQuery = mysqli_query($koneksi, $query);

if(!$dataQuery) {
    die("Query Error : ".mysqli_error($koneksi));
}



$data = [];
$no = $start + 1;
while ($row = mysqli_fetch_assoc($dataQuery)) {
    $aksi = '
    <a href = "edit-account.php?id='.$row["id_akun"].'" class="btn btn-sm btn-warning"> Edit </a>
    <a href = "delete-account.php?id='.$row["id_akun"].'" class="btn btn-sm btn-danger"> Hapus </a>
    <a href = "detail-account.php?id='.$row["id_akun"].'" class="btn btn-sm btn-primary"> Detail </a>

    ';

    $data[] = [
        $no++,
        $row["nama_lengkap"],
        $row["role"],
        $row["alamat"], 
        $aksi
    ];
}

$response = [
    "draw" => intval($_GET['draw'] ??0),
    "recordsTotal" => intval($totalData),
    "recordsFiltered" => intval($totalFiltered),
    "data" => $data
];

header('Content-Type: application/json');
echo json_encode($response);

?>