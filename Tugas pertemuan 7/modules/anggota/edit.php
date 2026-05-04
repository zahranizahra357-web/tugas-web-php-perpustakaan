<?php
$conn = mysqli_connect("localhost", "root", "", "perpustakaan");

if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

// ambil id dari URL
$id = $_GET['id'];

// ambil data berdasarkan id
$data = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM anggota WHERE id_anggota=$id"));

// proses update
if (isset($_POST['update'])) {

    $kode   = $_POST['kode'];
    $nama   = $_POST['nama'];
    $email  = $_POST['email'];
    $telepon= $_POST['telepon'];
    $alamat = $_POST['alamat'];
    $tgl_lahir = $_POST['tanggal_lahir'];
    $jk     = $_POST['jenis_kelamin'];
    $pekerjaan = $_POST['pekerjaan'];
    $status = $_POST['status'];

    $query = "UPDATE anggota SET
        kode_anggota='$kode',
        nama='$nama',
        email='$email',
        telepon='$telepon',
        alamat='$alamat',
        tanggal_lahir='$tgl_lahir',
        jenis_kelamin='$jk',
        pekerjaan='$pekerjaan',
        status='$status'
        WHERE id_anggota=$id
    ";

    if (mysqli_query($conn, $query)) {
        echo "<script>alert('Data berhasil diupdate'); window.location='index.php';</script>";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Anggota</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-4">
    <h2>Edit Anggota</h2>

    <form method="POST">
        <div class="mb-2">
            <label>Kode</label>
            <input type="text" name="kode" class="form-control" value="<?= $data['kode_anggota'] ?>" required>
        </div>

        <div class="mb-2">
            <label>Nama</label>
            <input type="text" name="nama" class="form-control" value="<?= $data['nama'] ?>" required>
        </div>

        <div class="mb-2">
            <label>Email</label>
            <input type="email" name="email" class="form-control" value="<?= $data['email'] ?>" required>
        </div>

        <div class="mb-2">
            <label>Telepon</label>
            <input type="text" name="telepon" class="form-control" value="<?= $data['telepon'] ?>" required>
        </div>

        <div class="mb-2">
            <label>Alamat</label>
            <textarea name="alamat" class="form-control" required><?= $data['alamat'] ?></textarea>
        </div>

        <div class="mb-2">
            <label>Tanggal Lahir</label>
            <input type="date" name="tanggal_lahir" class="form-control" value="<?= $data['tanggal_lahir'] ?>" required>
        </div>

        <div class="mb-2">
            <label>Jenis Kelamin</label>
            <select name="jenis_kelamin" class="form-control">
                <option value="Laki-laki" <?= $data['jenis_kelamin']=='Laki-laki'?'selected':'' ?>>Laki-laki</option>
                <option value="Perempuan" <?= $data['jenis_kelamin']=='Perempuan'?'selected':'' ?>>Perempuan</option>
            </select>
        </div>

        <div class="mb-2">
            <label>Pekerjaan</label>
            <input type="text" name="pekerjaan" class="form-control" value="<?= $data['pekerjaan'] ?>">
        </div>

        <div class="mb-2">
            <label>Status</label>
            <select name="status" class="form-control">
                <option value="Aktif" <?= $data['status']=='Aktif'?'selected':'' ?>>Aktif</option>
                <option value="Nonaktif" <?= $data['status']=='Nonaktif'?'selected':'' ?>>Nonaktif</option>
            </select>
        </div>

        <button type="submit" name="update" class="btn btn-success">Update</button>
        <a href="index.php" class="btn btn-secondary">Kembali</a>
    </form>
</div>

</body>
</html>