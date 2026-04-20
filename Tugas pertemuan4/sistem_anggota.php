<?php
require_once 'functions_anggota.php';

$anggota_list = [
    ["id"=>"AGT-001","nama"=>"Budi Santoso",    "email"=>"budi@email.com", "telepon"=>"081234567890","alamat"=>"Jakarta",   "tanggal_daftar"=>"2024-01-15","status"=>"Aktif",    "total_pinjaman"=>5],
    ["id"=>"AGT-002","nama"=>"Siti Rahayu",     "email"=>"siti@email.com", "telepon"=>"082345678901","alamat"=>"Bandung",   "tanggal_daftar"=>"2024-02-20","status"=>"Aktif",    "total_pinjaman"=>12],
    ["id"=>"AGT-003","nama"=>"Rizky Firmansyah","email"=>"rizky@email.com","telepon"=>"083456789012","alamat"=>"Surabaya",  "tanggal_daftar"=>"2024-03-10","status"=>"Non-Aktif","total_pinjaman"=>2],
    ["id"=>"AGT-004","nama"=>"Dewi Anggraini",  "email"=>"dewi@email.com", "telepon"=>"084567890123","alamat"=>"Yogyakarta","tanggal_daftar"=>"2024-04-05","status"=>"Aktif",    "total_pinjaman"=>8],
    ["id"=>"AGT-005","nama"=>"Ahmad Fauzi",     "email"=>"ahmad@email.com","telepon"=>"085678901234","alamat"=>"Semarang",  "tanggal_daftar"=>"2024-05-18","status"=>"Non-Aktif","total_pinjaman"=>0],
];

$total    = hitung_total_anggota($anggota_list);
$aktif    = hitung_anggota_aktif($anggota_list);
$nonaktif = $total - $aktif;
$rata     = hitung_rata_rata_pinjaman($anggota_list);
$teraktif = cari_anggota_teraktif($anggota_list);
$aktif_list    = filter_by_status($anggota_list, 'Aktif');
$nonaktif_list = filter_by_status($anggota_list, 'Non-Aktif');
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Anggota Perpustakaan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
</head>
<body>

<div class="container mt-4">
    <h4><i class="bi bi-people"></i> Sistem Anggota Perpustakaan</h4>
    <hr>

    <div class="row mb-3">
        <div class="col-md-3 mb-2">
            <div class="card text-white bg-primary">
                <div class="card-body">
                    <h5><?= $total ?></h5>
                    <p class="mb-0">Total Anggota</p>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-2">
            <div class="card text-white bg-success">
                <div class="card-body">
                    <h5><?= $aktif ?> (<?= round($aktif/$total*100,1) ?>%)</h5>
                    <p class="mb-0">Anggota Aktif</p>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-2">
            <div class="card text-white bg-danger">
                <div class="card-body">
                    <h5><?= $nonaktif ?> (<?= round($nonaktif/$total*100,1) ?>%)</h5>
                    <p class="mb-0">Non-Aktif</p>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-2">
            <div class="card text-white bg-warning">
                <div class="card-body">
                    <h5><?= $rata ?></h5>
                    <p class="mb-0">Rata-rata Pinjaman</p>
                </div>
            </div>
        </div>
    </div>

    <div class="card mb-3">
        <div class="card-header bg-success text-white">
            <h5 class="mb-0">Anggota Teraktif</h5>
        </div>
        <div class="card-body">
            <p><strong>Nama:</strong> <?= $teraktif['nama'] ?></p>
            <p><strong>ID:</strong> <?= $teraktif['id'] ?></p>
            <p><strong>Email:</strong> <?= $teraktif['email'] ?>
                <?php if (validasi_email($teraktif['email'])): ?>
                    <span class="badge bg-success">Valid</span>
                <?php else: ?>
                    <span class="badge bg-danger">Tidak Valid</span>
                <?php endif; ?>
            </p>
            <p><strong>Bergabung:</strong> <?= format_tanggal_indo($teraktif['tanggal_daftar']) ?></p>
            <p class="mb-0"><strong>Total Pinjaman:</strong> <?= $teraktif['total_pinjaman'] ?> buku</p>
        </div>
    </div>

    <div class="card mb-3">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">Daftar Anggota</h5>
        </div>
        <div class="card-body">
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
                        <th>Pinjaman</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($anggota_list as $a): ?>
                    <tr>
                        <td><?= $a['id'] ?></td>
                        <td><?= $a['nama'] ?></td>
                        <td><?= $a['email'] ?></td>
                        <td><?= $a['telepon'] ?></td>
                        <td><?= $a['alamat'] ?></td>
                        <td><?= format_tanggal_indo($a['tanggal_daftar']) ?></td>
                        <td>
                            <span class="badge <?= $a['status'] == 'Aktif' ? 'bg-success' : 'bg-danger' ?>">
                                <?= $a['status'] ?>
                            </span>
                        </td>
                        <td><?= $a['total_pinjaman'] ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <div class="card mb-3">
        <div class="card-header bg-success text-white">
            <h5 class="mb-0">Anggota Aktif</h5>
        </div>
        <div class="card-body">
            <div class="row">
                <?php foreach ($aktif_list as $a): ?>
                <div class="col-md-4 mb-2">
                    <div class="card border-success">
                        <div class="card-body">
                            <h6><?= $a['nama'] ?></h6>
                            <p class="mb-1 text-muted"><?= $a['id'] ?></p>
                            <p class="mb-1"><?= $a['email'] ?></p>
                            <p class="mb-1"><?= format_tanggal_indo($a['tanggal_daftar']) ?></p>
                            <p class="mb-0">Pinjaman: <strong><?= $a['total_pinjaman'] ?></strong></p>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>

    <div class="card mb-5">
        <div class="card-header bg-danger text-white">
            <h5 class="mb-0">Anggota Non-Aktif</h5>
        </div>
        <div class="card-body">
            <table class="table table-bordered">
                <thead class="table-danger">
                    <tr>
                        <th>ID</th>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Tgl Daftar</th>
                        <th>Total Pinjaman</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($nonaktif_list as $a): ?>
                    <tr>
                        <td><?= $a['id'] ?></td>
                        <td><?= $a['nama'] ?></td>
                        <td><?= $a['email'] ?></td>
                        <td><?= format_tanggal_indo($a['tanggal_daftar']) ?></td>
                        <td><?= $a['total_pinjaman'] ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
