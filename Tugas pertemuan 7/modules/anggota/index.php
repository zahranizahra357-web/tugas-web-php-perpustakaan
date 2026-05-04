<?php
$conn = mysqli_connect("localhost", "root", "", "perpustakaan");

if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

// ambil data anggota
$keyword = isset($_GET['keyword']) ? $_GET['keyword'] : '';

// jumlah data per halaman
$limit = 10;

// halaman sekarang
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$start = ($page - 1) * $limit;

// query utama + search
$where = "";
if ($keyword != '') {
    $where = "WHERE nama LIKE '%$keyword%' 
              OR email LIKE '%$keyword%' 
              OR telepon LIKE '%$keyword%'";
}

// ambil data sesuai halaman
$query = mysqli_query($conn, "SELECT * FROM anggota $where LIMIT $start, $limit");

// hitung total data
$total_query = mysqli_query($conn, "SELECT COUNT(*) as total FROM anggota $where");
$total_data = mysqli_fetch_assoc($total_query)['total'];
$total_pages = ceil($total_data / $limit);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Data Anggota</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-4">
    <h2>Data Anggota</h2>

    <form method="GET" class="mb-3">
        <div class="input-group">
            <input type="text" name="keyword" class="form-control"
            value="<?= isset($_GET['keyword']) ? $_GET['keyword'] : '' ?>"
            placeholder="Cari nama / email / telepon">
            
            <button type="submit" class="btn btn-primary">Cari</button>
        </div>
    </form>

    <a href="create.php" class="btn btn-primary mb-3">+ Tambah Anggota</a>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>No</th>
                <th>Foto</th>
                <th>Kode</th>
                <th>Nama</th>
                <th>Email</th>
                <th>Telepon</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>

        <?php
        if ($query && mysqli_num_rows($query) > 0) {
            $no = $start + 1; // FIX nomor biar tidak ulang dari 1
            while ($data = mysqli_fetch_assoc($query)) {
        ?>
            <tr>
                <td><?= $no++ ?></td>

                <td>
                    <?php if ($data['foto'] != "") { ?>
                        <img src="uploads/<?= $data['foto'] ?>" width="60" height="60" style="object-fit:cover;">
                    <?php } else { ?>
                        -
                    <?php } ?>
                </td>

                <td><?= $data['kode_anggota'] ?></td>
                <td><?= $data['nama'] ?></td>
                <td><?= $data['email'] ?></td>
                <td><?= $data['telepon'] ?></td>

                <td>
                    <?php if ($data['status'] == 'Aktif') { ?>
                        <span class="badge bg-success">Aktif</span>
                    <?php } else { ?>
                        <span class="badge bg-danger">Nonaktif</span>
                    <?php } ?>
                </td>

                <td>
                    <a href="edit.php?id=<?= $data['id_anggota'] ?>" class="btn btn-warning btn-sm">Edit</a>
                    <a href="delete.php?id=<?= $data['id_anggota'] ?>" 
                       class="btn btn-danger btn-sm"
                       onclick="return confirm('Yakin hapus data ini?')">Hapus</a>
                </td>
            </tr>
        <?php 
            }
        } else {
            echo "<tr><td colspan='8' class='text-center'>Belum ada data</td></tr>";
        }
        ?>

        </tbody>
    </table>

    <!-- PAGINATION -->
    <nav>
        <ul class="pagination justify-content-center">
            <?php for ($i = 1; $i <= $total_pages; $i++) { ?>
                <li class="page-item <?= ($i == $page) ? 'active' : '' ?>">
                    <a class="page-link" href="?page=<?= $i ?>&keyword=<?= $keyword ?>">
                        <?= $i ?>
                    </a>
                </li>
            <?php } ?>
        </ul>
    </nav>

</div>

</body>
</html>