<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Perhitungan Diskon - Tugas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1 class="mb-4">Sistem Perhitungan Diskon Bertingkat</h1>
        
        <?php
        // TODO: Isi data pembeli dan buku di sini
        $nama_pembeli = "Budi Santoso";
        $judul_buku = "Laravel Advanced";
        $harga_satuan = 150000;
        $jumlah_beli = 4;
        $is_member = true; // true atau false
        
        // TODO: Hitung subtotal
        $subtotal = $harga_satuan *$jumlah_beli;
        
        // TODO: Tentukan persentase diskon berdasarkan jumlah
        if ($jumlah_beli <= 2) {
            $persentase_diskon = 0;
        }else  if ($jumlah_beli <= 5) { 
            $persentase_diskon = 10;  
        }else if ($jumlah_beli <= 10) {
            $persentase_diskon = 15; 
        } else {
            $persentase_diskon = 20;
        }
        
        
        // TODO: Hitung diskon
        $diskon = $sub_total *($persentase_diskon / 100);

        
        // TODO: Total setelah diskon pertama
        $total_setelah_diskon1 = $sub_total - $diskon;

        
        // TODO: Hitung diskon member jika member
        $diskon_member = 0;
        if ($is_member) {
            $diskon_member = $total_setelah_diskon1 * 0.05;
        }
        
        // TODO: Total setelah semua diskon
        $total_setelah_diskon = $total_setelah_diskon1 - $diskon_member;
    
        
        // TODO: Hitung PPN
        $ppn = $total_setelah_diskon * 0.11;
        
        // TODO: Total akhir
        $total_akhir = $total_setelah_diskon +$ppn;
        
        // TODO: Total penghematan
        $total_hemat = $diskon + $diskon_member;
        ?>
        
        <!-- TODO: Tampilkan hasil perhitungan dengan Bootstrap -->
        <!-- Gunakan card, table, dan badge -->
        
    <div class="card mt-4">
        <div class="card-body">
            <p>Nama: <?=$nama_pembeli; ?></p>
            <p>Judul: <?=$judul_buku; ?></p>

            <table clas="table">
                <tr>
                    <td>Subtotal</td>
                    <td>Rp <?=number_format($sub_total,0,',','.'); ?></td>
                </tr>    
                <tr>
                    <td>Diskon</td>
                    <tdRp <?= number_format($diskon,0,',','.'); ?></td>
                </tr>
                <tr>
                    <td>Total_akhir</td>
                    <td><b>Rp <? number_format($total_akhir,0,',','.'); ?></b></td>
<               </tr>
         </table>
        div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>