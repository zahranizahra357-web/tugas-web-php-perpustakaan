-- STATISTIK BUKU

-- Total buku
SELECT COUNT(*) AS total_buku FROM buku;

-- Total nilai inventaris (harga × stok)
SELECT SUM(harga * stok) AS total_inventaris FROM buku;

-- Rata-rata harga buku
SELECT AVG(harga) AS rata_rata_harga FROM buku;

-- Buku termahal
SELECT judul, harga 
FROM buku 
ORDER BY harga DESC 
LIMIT 1;

-- Buku dengan stok terbanyak
SELECT judul, stok 
FROM buku 
ORDER BY stok DESC 
LIMIT 1;


-- FILTER DAN PENCARIAN

-- 1. Menampilkan semua buku kategori Pemrograman dengan harga kurang dari 100.000
SELECT * 
FROM buku 
WHERE kategori = 'Pemrograman' AND harga < 100000;

-- 2. Menampilkan buku yang judulnya mengandung kata "PHP" atau "MySQL"
SELECT * 
FROM buku 
WHERE judul LIKE '%PHP%' OR judul LIKE '%MySQL%';

-- 3. Menampilkan buku yang terbit tahun 2024
SELECT * 
FROM buku 
WHERE tahun_terbit = 2024;

-- 4. Menampilkan buku dengan stok antara 5 sampai 10
SELECT * 
FROM buku 
WHERE stok BETWEEN 5 AND 10;

-- 5. Menampilkan buku yang pengarangnya "Budi Raharjo"
SELECT * 
FROM buku 
WHERE pengarang = 'Budi Raharjo';


-- GROUPING DAN AGREGASI

-- 1. Menampilkan jumlah buku dan total stok untuk setiap kategori
SELECT kategori, 
       COUNT(*) AS jumlah_buku, 
       SUM(stok) AS total_stok
FROM buku
GROUP BY kategori;

-- 2. Menampilkan rata-rata harga buku untuk setiap kategori
SELECT kategori, 
       AVG(harga) AS rata_rata_harga
FROM buku
GROUP BY kategori;

-- 3. Menampilkan kategori dengan total nilai inventaris terbesar
SELECT kategori, 
       SUM(harga * stok) AS total_inventaris
FROM buku
GROUP BY kategori
ORDER BY total_inventaris DESC
LIMIT 1;


-- UPDATE DATA

-- 1. Menaikkan harga semua buku kategori Programming sebesar 5%
UPDATE buku
SET harga = harga * 1.05
WHERE kategori = 'Programming';

-- 2. Menambahkan stok sebanyak 10 untuk buku yang stoknya kurang dari 5
UPDATE buku
SET stok = stok + 10
WHERE stok < 5;

-- LAPORAN KHUSUS
-
-- 1. Menampilkan daftar buku yang perlu restocking (stok < 5)
-- Catatan: Jika tidak ada data dengan stok < 5, maka hasil akan kosong
SELECT * 
FROM buku 
WHERE stok < 5;

-- 2. Menampilkan 5 buku termahal
SELECT judul, harga 
FROM buku 
ORDER BY harga DESC 
LIMIT 5;