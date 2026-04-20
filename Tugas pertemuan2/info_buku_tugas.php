<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Info Buku - Perpustakaan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
<div class="container mt-5">
    <h1 class="mb-4">Informasi Buku</h1>

    <?php
    // Data banyak buku (SUDAH BENAR pakai array)
    $buku = [
        [
            "judul" => "Laravel: From Beginner to Advanced",
            "pengarang" => "Budi Raharjo",
            "penerbit" => "Informatika",
            "tahun" => 2023,
            "harga" => 125000,
            "stok" => 8,
            "isbn" => "978-602-1234-56-7",
            "kategori" => "Programming",
            "bahasa" => "Indonesia",
            "halaman" => 320,
            "berat" => 400
        ],
        [
            "judul" => "Belajar MySQL",
            "pengarang" => "Riyadi",
            "penerbit" => "Elex Media",
            "tahun" => 2022,
            "harga" => 150000,
            "stok" => 7,
            "isbn" => "976-602-124-56-7",
            "kategori" => "Database",
            "bahasa" => "Indonesia",
            "halaman" => 250,
            "berat" => 300
        ],
        [
            "judul" => "Web Design Modern",
            "pengarang" => "Hartono",
            "penerbit" => "Gramedia",
            "tahun" => 2021,
            "harga" => 100000,
            "stok" => 6,
            "isbn" => "976-602-999-56-7",
            "kategori" => "Web Design",
            "bahasa" => "Inggris",
            "halaman" => 280,
            "berat" => 300
        ]
    ];

    // Function warna badge
    function warnaBadge($kategori) {
        if ($kategori == "Programming") return "primary";
        elseif ($kategori == "Database") return "success";
        elseif ($kategori == "Web Design") return "warning";
        else return "secondary";
    }
    ?>

    <div class="row">
        <?php foreach ($buku as $b) { ?>
            <div class="col-md-4 mb-4">
                <div class="card shadow">

                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0"><?php echo $b["judul"]; ?></h5>
                    </div>

                    <div class="card-body">
                        <p><strong>Pengarang:</strong> <?php echo $b["pengarang"]; ?></p>
                        <p><strong>Penerbit:</strong> <?php echo $b["penerbit"]; ?></p>
                        <p><strong>Tahun:</strong> <?php echo $b["tahun"]; ?></p>
                        <p><strong>ISBN:</strong> <?php echo $b["isbn"]; ?></p>
                        <p><strong>Harga:</strong> Rp <?php echo number_format($b["harga"], 0, ',', '.'); ?></p>
                        <p><strong>Stok:</strong> <?php echo $b["stok"]; ?> buku</p>

                        <!-- Badge kategori -->
                        <span class="badge bg-<?php echo warnaBadge($b["kategori"]); ?>">
                            <?php echo $b["kategori"]; ?>
                        </span>

                        <p class="mt-2">
                            Bahasa: <?php echo $b["bahasa"]; ?><br>
                            Halaman: <?php echo $b["halaman"]; ?> halaman<br>
                            Berat: <?php echo $b["berat"]; ?> gram
                        </p>
                    </div>

                </div>
            </div>
        <?php } ?>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>