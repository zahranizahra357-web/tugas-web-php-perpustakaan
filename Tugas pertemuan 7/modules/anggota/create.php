<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$conn = mysqli_connect("localhost", "root", "", "perpustakaan");

if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

$error = "";

if(isset($_POST['submit'])) {

    $kode = $_POST['kode_anggota'];
    $nama = $_POST['nama'];
    $email = $_POST['email'];
    $telepon = $_POST['telepon'];
    $alamat = $_POST['alamat'];
    $tanggal_lahir = $_POST['tanggal_lahir'];
    $jenis_kelamin = $_POST['jenis_kelamin'];
    $pekerjaan = $_POST['pekerjaan'];
    $tanggal_daftar = date('Y-m-d');
    $status = "Aktif";

    // ======================
    // VALIDASI UMUR
    // ======================
    $today = date('Y-m-d');
    $umur = date_diff(date_create($tanggal_lahir), date_create($today))->y;

    if ($umur < 10) {
        $error = "Umur minimal 10 tahun!";
    }

    // ======================
    // JIKA TIDAK ADA ERROR
    // ======================
    if ($error == "") {

        // UPLOAD FOTO
        $foto = "";
        if (!empty($_FILES['foto']['name'])) {
            $foto = time() . "_" . $_FILES['foto']['name'];
            move_uploaded_file($_FILES['foto']['tmp_name'], "uploads/" . $foto);
        }

        // INSERT DATA
        $query = "INSERT INTO anggota 
        (kode_anggota, nama, email, telepon, alamat, tanggal_lahir, jenis_kelamin, pekerjaan, tanggal_daftar, status, foto)
        VALUES 
        ('$kode','$nama','$email','$telepon','$alamat','$tanggal_lahir','$jenis_kelamin','$pekerjaan','$tanggal_daftar','$status','$foto')";

        if(mysqli_query($conn, $query)) {
            echo "<script>alert('Data berhasil ditambahkan'); window.location='index.php';</script>";
        } else {
            echo "Error: " . mysqli_error($conn);
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Tambah Anggota</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">
    <h2 class="mb-4">Tambah Anggota</h2>

    <!-- PESAN ERROR -->
    <?php if ($error != "") { ?>
        <div class="alert alert-danger">
            <?= $error ?>
        </div>
    <?php } ?>

    <form method="POST" enctype="multipart/form-data" class="card p-4 shadow">

        <div class="mb-3">
            <label>Kode Anggota</label>
            <input type="text" name="kode_anggota" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Nama</label>
            <input type="text" name="nama" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Email</label>
            <input type="email" name="email" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Telepon</label>
            <input type="text" name="telepon" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Alamat</label>
            <textarea name="alamat" class="form-control" required></textarea>
        </div>

        <div class="mb-3">
            <label>Tanggal Lahir</label>
            <input type="date" name="tanggal_lahir" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Jenis Kelamin</label>
            <select name="jenis_kelamin" class="form-control">
                <option value="Laki-laki">Laki-laki</option>
                <option value="Perempuan">Perempuan</option>
            </select>
        </div>

        <div class="mb-3">
            <label>Pekerjaan</label>
            <input type="text" name="pekerjaan" class="form-control">
        </div>

        <div class="mb-3">
            <label>Foto</label>
            <input type="file" name="foto" class="form-control">
        </div>

        <button type="submit" name="submit" class="btn btn-primary">Simpan</button>
        <a href="index.php" class="btn btn-secondary">Kembali</a>

    </form>
</div>

</body>
</html>