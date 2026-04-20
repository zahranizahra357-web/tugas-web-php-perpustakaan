<?php
$buku_list = [
    ['kode'=>'BK001','judul'=>'Laskar Pelangi','kategori'=>'Novel','pengarang'=>'Andrea Hirata','penerbit'=>'Bentang Pustaka','tahun'=>2005,'harga'=>85000,'stok'=>5],
    ['kode'=>'BK002','judul'=>'Bumi Manusia','kategori'=>'Novel','pengarang'=>'Pramoedya Ananta Toer','penerbit'=>'Lentera Dipantara','tahun'=>1980,'harga'=>95000,'stok'=>0],
    ['kode'=>'BK003','judul'=>'Algoritma dan Pemrograman','kategori'=>'Teknologi','pengarang'=>'Rinaldi Munir','penerbit'=>'Informatika','tahun'=>2011,'harga'=>120000,'stok'=>3],
    ['kode'=>'BK004','judul'=>'Fisika Dasar','kategori'=>'Sains','pengarang'=>'Halliday','penerbit'=>'Erlangga','tahun'=>2010,'harga'=>175000,'stok'=>2],
    ['kode'=>'BK005','judul'=>'Sejarah Indonesia Modern','kategori'=>'Sejarah','pengarang'=>'M.C. Ricklefs','penerbit'=>'Gadjah Mada UP','tahun'=>2008,'harga'=>110000,'stok'=>4],
    ['kode'=>'BK006','judul'=>'Pemrograman Web','kategori'=>'Teknologi','pengarang'=>'Betha Sidik','penerbit'=>'Informatika','tahun'=>2017,'harga'=>98000,'stok'=>0],
    ['kode'=>'BK007','judul'=>'Ekonomi Mikro','kategori'=>'Ekonomi','pengarang'=>'N. Gregory Mankiw','penerbit'=>'Erlangga','tahun'=>2014,'harga'=>145000,'stok'=>6],
    ['kode'=>'BK008','judul'=>'Supernova','kategori'=>'Novel','pengarang'=>'Dee Lestari','penerbit'=>'Bentang Pustaka','tahun'=>2001,'harga'=>79000,'stok'=>1],
    ['kode'=>'BK009','judul'=>'Kimia Organik','kategori'=>'Sains','pengarang'=>'John McMurry','penerbit'=>'Erlangga','tahun'=>2012,'harga'=>165000,'stok'=>0],
    ['kode'=>'BK010','judul'=>'Manajemen Strategi','kategori'=>'Ekonomi','pengarang'=>'Fred R. David','penerbit'=>'Salemba Empat','tahun'=>2016,'harga'=>130000,'stok'=>3],
    ['kode'=>'BK011','judul'=>'Negeri 5 Menara','kategori'=>'Novel','pengarang'=>'Ahmad Fuadi','penerbit'=>'Gramedia','tahun'=>2009,'harga'=>88000,'stok'=>7],
    ['kode'=>'BK012','judul'=>'Basis Data','kategori'=>'Teknologi','pengarang'=>'Fathansyah','penerbit'=>'Informatika','tahun'=>2015,'harga'=>105000,'stok'=>2],
];

// ambil param GET
$keyword   = trim($_GET['keyword'] ?? '');
$kategori  = $_GET['kategori'] ?? '';
$min_harga = $_GET['min_harga'] ?? '';
$max_harga = $_GET['max_harga'] ?? '';
$tahun     = $_GET['tahun'] ?? '';
$status    = $_GET['status'] ?? 'semua';
$sort      = $_GET['sort'] ?? 'judul';
$page      = max(1, (int)($_GET['page'] ?? 1));
$per_page  = 10;

$errors = [];

if ($min_harga !== '' && $max_harga !== '' && $min_harga > $max_harga)
    $errors[] = 'Harga minimum tidak boleh lebih besar dari harga maksimum.';

if ($tahun !== '' && ($tahun < 1900 || $tahun > date('Y')))
    $errors[] = 'Tahun tidak valid (1900 - ' . date('Y') . ').';

// filter
$hasil = $buku_list;

if ($keyword != '') {
    $hasil = array_filter($hasil, fn($b) =>
        stripos($b['judul'], $keyword) !== false ||
        stripos($b['pengarang'], $keyword) !== false
    );
}
if ($kategori != '')
    $hasil = array_filter($hasil, fn($b) => $b['kategori'] == $kategori);

if ($min_harga !== '')
    $hasil = array_filter($hasil, fn($b) => $b['harga'] >= $min_harga);

if ($max_harga !== '')
    $hasil = array_filter($hasil, fn($b) => $b['harga'] <= $max_harga);

if ($tahun !== '')
    $hasil = array_filter($hasil, fn($b) => $b['tahun'] == $tahun);

if ($status == 'tersedia')
    $hasil = array_filter($hasil, fn($b) => $b['stok'] > 0);
elseif ($status == 'habis')
    $hasil = array_filter($hasil, fn($b) => $b['stok'] == 0);

// sorting
usort($hasil, function($a, $b) use ($sort) {
    if ($sort == 'harga') return $a['harga'] - $b['harga'];
    if ($sort == 'tahun') return $a['tahun'] - $b['tahun'];
    return strcmp($a['judul'], $b['judul']);
});

$hasil = array_values($hasil);
$total = count($hasil);
$total_page = ceil($total / $per_page);
$hasil_page = array_slice($hasil, ($page - 1) * $per_page, $per_page);

// daftar kategori unik
$kategori_list = array_unique(array_column($buku_list, 'kategori'));
sort($kategori_list);

// highlight keyword di teks
function hl($text, $keyword) {
    if ($keyword == '') return htmlspecialchars($text);
    return preg_replace('/(' . preg_quote($keyword, '/') . ')/i',
        '<mark>$1</mark>', htmlspecialchars($text));
}

// bangun query string untuk pagination (tanpa param page)
function buildQuery($except = []) {
    $params = $_GET;
    foreach ($except as $k) unset($params[$k]);
    return http_build_query($params);
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pencarian Buku</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background: #f5f5f5; }
        mark { background: #fff176; padding: 0; }
        .card { border: none; box-shadow: 0 2px 10px rgba(0,0,0,0.08); border-radius: 10px; }
        .card-header { background: #2c5f8a; color: #fff; border-radius: 10px 10px 0 0 !important; }
        .stok-habis { color: #dc3545; font-weight: 500; }
        .stok-ada   { color: #198754; font-weight: 500; }
        th { white-space: nowrap; }
    </style>
</head>
<body>
<div class="container py-4">
<div class="row justify-content-center">
<div class="col-lg-10">

    <div class="card mb-4">
        <div class="card-header py-3 px-4">
            <h5 class="mb-0">Pencarian Buku</h5>
        </div>
        <div class="card-body p-4">
            <?php if (!empty($errors)): ?>
                <div class="alert alert-danger py-2 mb-3">
                    <?php foreach ($errors as $e) echo '<div>' . $e . '</div>'; ?>
                </div>
            <?php endif; ?>

            <form method="GET">
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Keyword (judul / pengarang)</label>
                        <input type="text" name="keyword" class="form-control" value="<?= htmlspecialchars($keyword) ?>" placeholder="cari judul atau pengarang...">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Kategori</label>
                        <select name="kategori" class="form-select">
                            <option value="">Semua</option>
                            <?php foreach ($kategori_list as $kat): ?>
                                <option value="<?= $kat ?>" <?= $kategori == $kat ? 'selected' : '' ?>><?= $kat ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Tahun Terbit</label>
                        <input type="number" name="tahun" class="form-control" value="<?= htmlspecialchars($tahun) ?>" placeholder="misal: 2010" min="1900" max="<?= date('Y') ?>">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Harga Min</label>
                        <input type="number" name="min_harga" class="form-control" value="<?= htmlspecialchars($min_harga) ?>" placeholder="0" min="0">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Harga Max</label>
                        <input type="number" name="max_harga" class="form-control" value="<?= htmlspecialchars($max_harga) ?>" placeholder="999999" min="0">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Ketersediaan</label>
                        <div class="pt-1">
                            <?php foreach (['semua'=>'Semua','tersedia'=>'Tersedia','habis'=>'Habis'] as $val=>$label): ?>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="status" value="<?= $val ?>" id="s_<?= $val ?>" <?= $status == $val ? 'checked' : '' ?>>
                                    <label class="form-check-label" for="s_<?= $val ?>"><?= $label ?></label>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Urutkan</label>
                        <select name="sort" class="form-select">
                            <option value="judul" <?= $sort=='judul'?'selected':'' ?>>Judul</option>
                            <option value="harga" <?= $sort=='harga'?'selected':'' ?>>Harga</option>
                            <option value="tahun" <?= $sort=='tahun'?'selected':'' ?>>Tahun</option>
                        </select>
                    </div>
                    <div class="col-12 d-flex gap-2">
                        <button type="submit" class="btn btn-primary" style="background:#2c5f8a;border-color:#2c5f8a;">Cari</button>
                        <a href="search_advanced.php" class="btn btn-outline-secondary">Reset</a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <?php if (empty($errors)): ?>
    <div class="mb-2 text-muted small">
        Ditemukan <strong><?= $total ?></strong> buku
        <?= $keyword != '' ? "untuk kata kunci <strong>\"" . htmlspecialchars($keyword) . "\"</strong>" : '' ?>
    </div>

    <?php if ($total > 0): ?>
    <div class="card">
        <div class="table-responsive">
            <table class="table table-hover mb-0 align-middle">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Kode</th>
                        <th>Judul</th>
                        <th>Pengarang</th>
                        <th>Kategori</th>
                        <th>Tahun</th>
                        <th>Harga</th>
                        <th>Stok</th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach ($hasil_page as $i => $b): ?>
                    <tr>
                        <td class="text-muted"><?= ($page-1)*$per_page + $i + 1 ?></td>
                        <td><code><?= htmlspecialchars($b['kode']) ?></code></td>
                        <td><?= hl($b['judul'], $keyword) ?></td>
                        <td><?= hl($b['pengarang'], $keyword) ?></td>
                        <td><?= htmlspecialchars($b['kategori']) ?></td>
                        <td><?= $b['tahun'] ?></td>
                        <td>Rp <?= number_format($b['harga'], 0, ',', '.') ?></td>
                        <td class="<?= $b['stok'] > 0 ? 'stok-ada' : 'stok-habis' ?>">
                            <?= $b['stok'] > 0 ? $b['stok'] . ' ada' : 'Habis' ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <?php if ($total_page > 1): ?>
    <nav class="mt-3">
        <ul class="pagination pagination-sm justify-content-center mb-0">
            <?php for ($p = 1; $p <= $total_page; $p++): ?>
                <li class="page-item <?= $p == $page ? 'active' : '' ?>">
                    <a class="page-link" href="?<?= buildQuery(['page']) ?>&page=<?= $p ?>"><?= $p ?></a>
                </li>
            <?php endfor; ?>
        </ul>
    </nav>
    <?php endif; ?>

    <?php else: ?>
        <div class="text-center text-muted py-5">Tidak ada buku yang cocok dengan filter yang dipilih.</div>
    <?php endif; ?>
    <?php endif; ?>

</div>
</div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>