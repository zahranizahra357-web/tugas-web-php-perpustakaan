<?php
// Inisialisasi variabel
$nama = $email = $telepon = $alamat = $jk = $tgl_lahir = $pekerjaan = "";
$error = [];

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Ambil data
    $nama = trim($_POST["nama"]);
    $email = trim($_POST["email"]);
    $telepon = trim($_POST["telepon"]);
    $alamat = trim($_POST["alamat"]);
    $jk = $_POST["jk"] ?? "";
    $tgl_lahir = $_POST["tgl_lahir"];
    $pekerjaan = $_POST["pekerjaan"];

    // VALIDASI

    // Nama
    if (empty($nama)) {
        $error['nama'] = "Nama wajib diisi";
    } elseif (strlen($nama) < 3) {
        $error['nama'] = "Minimal 3 karakter";
    }

    // Email
    if (empty($email)) {
        $error['email'] = "Email wajib diisi";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error['email'] = "Format email tidak valid";
    }

    // Telepon
    if (empty($telepon)) {
        $error['telepon'] = "Telepon wajib diisi";
    } elseif (!preg_match('/^08[0-9]{8,11}$/', $telepon)) {
        $error['telepon'] = "Format harus 08xxxxxxxxxx (10-13 digit)";
    }

    // Alamat
    if (empty($alamat)) {
        $error['alamat'] = "Alamat wajib diisi";
    } elseif (strlen($alamat) < 10) {
        $error['alamat'] = "Alamat minimal 10 karakter";
    }

    // Jenis Kelamin
    if (empty($jk)) {
        $error['jk'] = "Pilih jenis kelamin";
    }

    // Tanggal lahir + umur
    if (empty($tgl_lahir)) {
        $error['tgl_lahir'] = "Tanggal lahir wajib diisi";
    } else {
        $umur = date_diff(date_create($tgl_lahir), date_create('today'))->y;
        if ($umur < 10) {
            $error['tgl_lahir'] = "Umur minimal 10 tahun";
        }
    }

    // Pekerjaan
    if (empty($pekerjaan)) {
        $error['pekerjaan'] = "Pilih pekerjaan";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <title>Form Anggota</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-5">

<h3 class="mb-4">Form Registrasi Anggota</h3>

<form method="POST" class="card p-4 shadow-sm">

    <!-- Nama -->
    <div class="mb-3">
        <label>Nama Lengkap</label>
        <input type="text" name="nama" class="form-control <?= isset($error['nama']) ? 'is-invalid' : '' ?>" value="<?= $nama ?>">
        <div class="invalid-feedback"><?= $error['nama'] ?? '' ?></div>
    </div>

    <!-- Email -->
    <div class="mb-3">
        <label>Email</label>
        <input type="email" name="email" class="form-control <?= isset($error['email']) ? 'is-invalid' : '' ?>" value="<?= $email ?>">
        <div class="invalid-feedback"><?= $error['email'] ?? '' ?></div>
    </div>

    <!-- Telepon -->
    <div class="mb-3">
        <label>Telepon</label>
        <input type="text" name="telepon" class="form-control <?= isset($error['telepon']) ? 'is-invalid' : '' ?>" value="<?= $telepon ?>">
        <div class="invalid-feedback"><?= $error['telepon'] ?? '' ?></div>
    </div>

    <!-- Alamat -->
    <div class="mb-3">
        <label>Alamat</label>
        <textarea name="alamat" class="form-control <?= isset($error['alamat']) ? 'is-invalid' : '' ?>"><?= $alamat ?></textarea>
        <div class="invalid-feedback"><?= $error['alamat'] ?? '' ?></div>
    </div>

    <!-- Jenis Kelamin -->
    <div class="mb-3">
        <label>Jenis Kelamin</label><br>
        <input type="radio" name="jk" value="Laki-laki" <?= ($jk == "Laki-laki") ? "checked" : "" ?>> Laki-laki
        <input type="radio" name="jk" value="Perempuan" <?= ($jk == "Perempuan") ? "checked" : "" ?>> Perempuan
        <div class="text-danger"><?= $error['jk'] ?? '' ?></div>
    </div>

    <!-- Tanggal Lahir -->
    <div class="mb-3">
        <label>Tanggal Lahir</label>
        <input type="date" name="tgl_lahir" class="form-control <?= isset($error['tgl_lahir']) ? 'is-invalid' : '' ?>" value="<?= $tgl_lahir ?>">
        <div class="invalid-feedback"><?= $error['tgl_lahir'] ?? '' ?></div>
    </div>

    <!-- Pekerjaan -->
    <div class="mb-3">
        <label>Pekerjaan</label>
        <select name="pekerjaan" class="form-control <?= isset($error['pekerjaan']) ? 'is-invalid' : '' ?>">
            <option value="">-- Pilih --</option>
            <option <?= ($pekerjaan=="Pelajar")?"selected":"" ?>>Pelajar</option>
            <option <?= ($pekerjaan=="Mahasiswa")?"selected":"" ?>>Mahasiswa</option>
            <option <?= ($pekerjaan=="Pegawai")?"selected":"" ?>>Pegawai</option>
            <option <?= ($pekerjaan=="Lainnya")?"selected":"" ?>>Lainnya</option>
        </select>
        <div class="invalid-feedback"><?= $error['pekerjaan'] ?? '' ?></div>
    </div>

    <button type="submit" class="btn btn-primary">Daftar</button>

</form>

<?php if ($_SERVER["REQUEST_METHOD"] == "POST" && empty($error)): ?>
    <div class="card mt-4 p-3 shadow-sm">
        <h5 class="text-success">Registrasi Berhasil 🎉</h5>
        <p><b>Nama:</b> <?= $nama ?></p>
        <p><b>Email:</b> <?= $email ?></p>
        <p><b>Telepon:</b> <?= $telepon ?></p>
        <p><b>Alamat:</b> <?= $alamat ?></p>
        <p><b>Jenis Kelamin:</b> <?= $jk ?></p>
        <p><b>Tanggal Lahir:</b> <?= $tgl_lahir ?></p>
        <p><b>Pekerjaan:</b> <?= $pekerjaan ?></p>
    </div>
<?php endif; ?>

</body>
</html>