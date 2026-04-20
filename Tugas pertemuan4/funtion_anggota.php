<?php

function hitung_total_anggota($anggota_list) {
    return count($anggota_list);
}

function hitung_anggota_aktif($anggota_list) {
    $n = 0;
    foreach ($anggota_list as $a) {
        if ($a['status'] == 'Aktif') $n++;
    }
    return $n;
}

function hitung_rata_rata_pinjaman($anggota_list) {
    $total = 0;
    foreach ($anggota_list as $a) {
        $total += $a['total_pinjaman'];
    }
    return round($total / count($anggota_list), 1);
}

function cari_anggota_by_id($anggota_list, $id) {
    foreach ($anggota_list as $a) {
        if ($a['id'] == $id) return $a;
    }
    return null;
}

function cari_anggota_teraktif($anggota_list) {
    $hasil = $anggota_list[0];
    foreach ($anggota_list as $a) {
        if ($a['total_pinjaman'] > $hasil['total_pinjaman']) $hasil = $a;
    }
    return $hasil;
}

function filter_by_status($anggota_list, $status) {
    $hasil = [];
    foreach ($anggota_list as $a) {
        if ($a['status'] == $status) $hasil[] = $a;
    }
    return $hasil;
}

function validasi_email($email) {
    if (empty($email)) return false;
    if (strpos($email, '@') === false) return false;
    if (strpos($email, '.') === false) return false;
    return true;
}

function format_tanggal_indo($tanggal) {
    $bulan = ['01'=>'Januari','02'=>'Februari','03'=>'Maret','04'=>'April',
              '05'=>'Mei','06'=>'Juni','07'=>'Juli','08'=>'Agustus',
              '09'=>'September','10'=>'Oktober','11'=>'November','12'=>'Desember'];
    $pecah = explode('-', $tanggal);
    return $pecah[2] . ' ' . $bulan[$pecah[1]] . ' ' . $pecah[0];
}