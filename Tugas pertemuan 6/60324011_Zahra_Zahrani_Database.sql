-- 1. Membuat database
CREATE DATABASE perpustakaan_lengkap;
USE perpustakaan_lengkap;

-- 2. Tabel kategori
CREATE TABLE kategori_buku (
    id_kategori INT AUTO_INCREMENT PRIMARY KEY,
    nama_kategori VARCHAR(50) NOT NULL UNIQUE,
    deskripsi TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- 3. Tabel penerbit
CREATE TABLE penerbit (
    id_penerbit INT AUTO_INCREMENT PRIMARY KEY,
    nama_penerbit VARCHAR(100) NOT NULL,
    alamat TEXT,
    telepon VARCHAR(15),
    email VARCHAR(100),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- 4. Tabel buku
CREATE TABLE buku (
    id_buku INT AUTO_INCREMENT PRIMARY KEY,
    kode_buku VARCHAR(10),
    judul VARCHAR(255),
    pengarang VARCHAR(100),
    tahun_terbit INT,
    harga DECIMAL(10,2),
    stok INT,
    id_kategori INT,
    id_penerbit INT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_kategori) REFERENCES kategori_buku(id_kategori),
    FOREIGN KEY (id_penerbit) REFERENCES penerbit(id_penerbit)
);

-- 5. Insert kategori
INSERT INTO kategori_buku (nama_kategori, deskripsi) VALUES
('Programming', 'Buku pemrograman'),
('Database', 'Buku database'),
('Web Design', 'Desain web'),
('Jaringan', 'Networking'),
('AI', 'Artificial Intelligence');

-- 6. Insert penerbit
INSERT INTO penerbit (nama_penerbit, alamat, telepon, email) VALUES
('Informatika', 'Bandung', '08123456789', 'info@informatika.com'),
('Andi', 'Yogyakarta', '08234567891', 'andi@email.com'),
('Elex Media', 'Jakarta', '08345678912', 'elex@email.com'),
('Graha Ilmu', 'Yogyakarta', '08456789123', 'graha@email.com'),
('Gramedia', 'Jakarta', '08567891234', 'gramedia@email.com');


-- 7. Insert buku
INSERT INTO buku (kode_buku, judul, pengarang, tahun_terbit, harga, stok, id_kategori, id_penerbit) VALUES
('BK001', 'Belajar PHP', 'Budi Raharjo', 2023, 90000, 10, 1, 1),
('BK002', 'MySQL Dasar', 'Andi Nugroho', 2022, 85000, 5, 2, 4),
('BK003', 'Laravel Advanced', 'Siti Aminah', 2024, 120000, 8, 1, 1),
('BK004', 'HTML CSS Pemula', 'Dedi Santoso', 2023, 75000, 7, 3, 2),
('BK005', 'Jaringan Komputer', 'Ahmad Yani', 2022, 95000, 6, 4, 3),
('BK006', 'Machine Learning', 'Siti Aminah', 2024, 150000, 4, 5, 5),
('BK007', 'Python Programming', 'Budi Raharjo', 2023, 110000, 9, 1, 1),
('BK008', 'PostgreSQL Guide', 'Ahmad Yani', 2024, 100000, 5, 2, 4),
('BK009', 'UI UX Design', 'Dedi Santoso', 2023, 80000, 6, 3, 2),
('BK010', 'Deep Learning', 'Siti Aminah', 2024, 160000, 3, 5, 5),
('BK011', 'React JS', 'Budi Raharjo', 2023, 130000, 8, 1, 1),
('BK012', 'MongoDB Dasar', 'Andi Nugroho', 2022, 90000, 5, 2, 4),
('BK013', 'Bootstrap Framework', 'Dedi Santoso', 2023, 70000, 7, 3, 2),
('BK014', 'Cisco Networking', 'Ahmad Yani', 2024, 120000, 6, 4, 3),
('BK015', 'AI Basics', 'Siti Aminah', 2024, 140000, 4, 5, 5);

-- 8. Query JOIN
-- Menampilkan buku dengan nama kategori dan penerbit
SELECT 
    buku.judul,
    kategori_buku.nama_kategori,
    penerbit.nama_penerbit
FROM buku
JOIN kategori_buku ON buku.id_kategori = kategori_buku.id_kategori
JOIN penerbit ON buku.id_penerbit = penerbit.id_penerbit;

-- Menghitung jumlah buku per kategori
SELECT 
    kategori_buku.nama_kategori,
    COUNT(*) AS jumlah_buku
FROM buku
JOIN kategori_buku ON buku.id_kategori = kategori_buku.id_kategori
GROUP BY kategori_buku.nama_kategori;

-- Menghitung jumlah buku per penerbit
SELECT 
    penerbit.nama_penerbit,
    COUNT(*) AS jumlah_buku
FROM buku
JOIN penerbit ON buku.id_penerbit = penerbit.id_penerbit
GROUP BY penerbit.nama_penerbit;

-- Menampilkan detail lengkap buku (kategori + penerbit)
SELECT 
    buku.kode_buku,
    buku.judul,
    buku.pengarang,
    buku.tahun_terbit,
    buku.harga,
    buku.stok,
    kategori_buku.nama_kategori,
    penerbit.nama_penerbit
FROM buku
JOIN kategori_buku ON buku.id_kategori = kategori_buku.id_kategori
JOIN penerbit ON buku.id_penerbit = penerbit.id_penerbit;

 