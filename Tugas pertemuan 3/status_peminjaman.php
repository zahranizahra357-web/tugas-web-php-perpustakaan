<?php

// DATA ANGGOTA

$nama_anggota = "Budi Santoso";
$total_pinjaman = 2;
$buku_terlambat = 1;
$hari_keterlambatan = 5;


// LOGIKA DENDA

$denda_per_hari = 1000;
$total_denda = $buku_terlambat * $hari_keterlambatan * $denda_per_hari;

if ($total_denda > 50000) {
    $total_denda = 50000;
}


// STATUS PINJAM (IF ELSE)

if ($buku_terlambat > 0) {
    $status = "Tidak bisa meminjam";
    $pesan = "Masih ada buku terlambat";
    $warna = "danger";
} elseif ($total_pinjaman >= 3) {
    $status = "Tidak bisa meminjam";
    $pesan = "Sudah mencapai batas maksimal";
    $warna = "danger";
} else {
    $status = "Boleh meminjam";
    $pesan = "Silakan meminjam buku";
    $warna = "success";
}


// LEVEL MEMBER (SWITCH)

switch (true) {
    case ($total_pinjaman <= 5):
        $level = "Bronze";
        break;
    case ($total_pinjaman <= 15):
        $level = "Silver";
        break;
    default:
        $level = "Gold";
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Sistem Perpustakaan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-4">
    <h3 class="mb-4">📚 Sistem Status Peminjaman</h3>

    <!-- CARD ATAS -->
    <div class="row text-center mb-4">
        <div class="col-md-4">
            <div class="card border-primary">
                <div class="card-body">
                    <h4 class="text-primary"><?= $total_pinjaman ?></h4>
                    <p>Total Pinjaman</p>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card border-warning">
                <div class="card-body">
                    <h4 class="text-warning"><?= $buku_terlambat ?></h4>
                    <p>Buku Terlambat</p>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card border-danger">
                <div class="card-body">
                    <h4 class="text-danger">
                        Rp <?= number_format($total_denda, 0, ',', '.') ?>
                    </h4>
                    <p>Total Denda</p>
                </div>
            </div>
        </div>
    </div>

    <!-- INFORMASI ANGGOTA -->
    <div class="card mb-3">
        <div class="card-header bg-primary text-white">
            Informasi Anggota
        </div>
        <div class="card-body">
            <table class="table">
                <tr>
                    <th>Nama</th>
                    <td><?= $nama_anggota ?></td>
                </tr>
                <tr>
                    <th>Total Pinjaman</th>
                    <td><?= $total_pinjaman ?></td>
                </tr>
                <tr>
                    <th>Level Member</th>
                    <td>
                        <span class="badge bg-secondary"><?= $level ?></span>
                    </td>
                </tr>
            </table>
        </div>
    </div>

    <!-- STATUS -->
    <div class="alert alert-<?= $warna ?>">
        <strong><?= $status ?></strong><br>
        <?= $pesan ?>
    </div>
</div>

</body>
</html>