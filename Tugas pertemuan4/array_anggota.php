<?php
$anggota_list = [
    ["id" => "AGT-001", "nama" => "Budi Santoso",     "email" => "budi@email.com",  "telepon" => "081234567890", "alamat" => "Jakarta",    "tanggal_daftar" => "2024-01-15", "status" => "Aktif",     "total_pinjaman" => 5],
    ["id" => "AGT-002", "nama" => "Siti Rahayu",      "email" => "siti@email.com",  "telepon" => "082345678901", "alamat" => "Bandung",    "tanggal_daftar" => "2024-02-20", "status" => "Aktif",     "total_pinjaman" => 12],
    ["id" => "AGT-003", "nama" => "Rizky Firmansyah", "email" => "rizky@email.com", "telepon" => "083456789012", "alamat" => "Surabaya",   "tanggal_daftar" => "2024-03-10", "status" => "Non-Aktif", "total_pinjaman" => 2],
    ["id" => "AGT-004", "nama" => "Dewi Anggraini",   "email" => "dewi@email.com",  "telepon" => "084567890123", "alamat" => "Yogyakarta", "tanggal_daftar" => "2024-04-05", "status" => "Aktif",     "total_pinjaman" => 8],
    ["id" => "AGT-005", "nama" => "Ahmad Fauzi",      "email" => "ahmad@email.com", "telepon" => "085678901234", "alamat" => "Semarang",   "tanggal_daftar" => "2024-05-18", "status" => "Non-Aktif", "total_pinjaman" => 0],
];

// hitung total anggota
$total_anggota = count($anggota_list);

// hitung aktif dan non aktif
$jml_aktif = 0;
$jml_nonaktif = 0;
foreach ($anggota_list as $data) {
    if ($data['status'] == 'Aktif') {
        $jml_aktif++;
    } else {
        $jml_nonaktif++;
    }
}

// rata-rata pinjaman
$total_pinjaman = 0;
foreach ($anggota_list as $data) {
    $total_pinjaman += $data['total_pinjaman'];
}
$rata_pinjaman = $total_pinjaman / $total_anggota;

// cari yang paling banyak pinjam
$paling_banyak = $anggota_list[0];
foreach ($anggota_list as $data) {
    if ($data['total_pinjaman'] > $paling_banyak['total_pinjaman']) {
        $paling_banyak = $data;
    }
}

// filter berdasarkan status
$filter = isset($_GET['status']) ? $_GET['status'] : 'Semua';
$data_tampil = [];
foreach ($anggota_list as $data) {
    if ($filter == 'Semua' || $data['status'] == $filter) {
        $data_tampil[] = $data;
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Data Anggota Perpustakaan</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body class="p-4">

<h4>Data Anggota Perpustakaan</h4>
<hr>

<!-- statistik -->
<div class="row mb-4">
    <div class="col-md-3">
        <div class="card text-white bg-primary mb-2">
            <div class="card-body">
                <h5><?= $total_anggota ?></h5>
                <p class="mb-0">Total Anggota</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-white bg-success mb-2">
            <div class="card-body">
                <h5><?= $jml_aktif ?> (<?= round($jml_aktif / $total_anggota * 100, 1) ?>%)</h5>
                <p class="mb-0">Anggota Aktif</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-white bg-danger mb-2">
            <div class="card-body">
                <h5><?= $jml_nonaktif ?> (<?= round($jml_nonaktif / $total_anggota * 100, 1) ?>%)</h5>
                <p class="mb-0">Non-Aktif</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-white bg-warning mb-2">
            <div class="card-body">
                <h5><?= round($rata_pinjaman, 1) ?></h5>
                <p class="mb-0">Rata-rata Pinjaman</p>
            </div>
        </div>
    </div>
</div>

<p>Anggota paling banyak meminjam: <strong><?= $paling_banyak['nama'] ?></strong> (<?= $paling_banyak['total_pinjaman'] ?> buku)</p>

<!-- filter -->
<div class="mb-3">
    Filter Status:
    <a href="?status=Semua" class="btn btn-sm <?= $filter == 'Semua' ? 'btn-secondary' : 'btn-outline-secondary' ?>">Semua</a>
    <a href="?status=Aktif" class="btn btn-sm <?= $filter == 'Aktif' ? 'btn-secondary' : 'btn-outline-secondary' ?>">Aktif</a>
    <a href="?status=Non-Aktif" class="btn btn-sm <?= $filter == 'Non-Aktif' ? 'btn-secondary' : 'btn-outline-secondary' ?>">Non-Aktif</a>
</div>

<!-- tabel -->
<table class="table table-bordered table-striped">
    <thead class="table-dark">
        <tr>
            <th>ID</th>
            <th>Nama</th>
            <th>Email</th>
            <th>Telepon</th>
            <th>Alamat</th>
            <th>Tgl Daftar</th>
            <th>Status</th>
            <th>Total Pinjaman</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($data_tampil as $data) : ?>
        <tr>
            <td><?= $data['id'] ?></td>
            <td><?= $data['nama'] ?></td>
            <td><?= $data['email'] ?></td>
            <td><?= $data['telepon'] ?></td>
            <td><?= $data['alamat'] ?></td>
            <td><?= $data['tanggal_daftar'] ?></td>
            <td>
                <?php if ($data['status'] == 'Aktif') : ?>
                    <span class="badge bg-success">Aktif</span>
                <?php else : ?>
                    <span class="badge bg-danger">Non-Aktif</span>
                <?php endif; ?>
            </td>
            <td><?= $data['total_pinjaman'] ?></td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<p>Menampilkan <?= count($data_tampil) ?> dari <?= $total_anggota ?> anggota</p>

</body>
</html>
