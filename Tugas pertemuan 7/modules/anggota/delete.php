<?php
$conn = mysqli_connect("localhost", "root", "", "perpustakaan");

if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

// ambil id dari URL
$id = $_GET['id'];

// ambil data dulu (untuk cek foto nanti)
$data = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM anggota WHERE id_anggota=$id"));

// hapus foto jika ada
if (!empty($data['foto'])) {
    $file = "uploads/" . $data['foto'];
    if (file_exists($file)) {
        unlink($file);
    }
}

// hapus data dari database
mysqli_query($conn, "DELETE FROM anggota WHERE id_anggota=$id");

// redirect
echo "<script>alert('Data berhasil dihapus'); window.location='index.php';</script>";
?>