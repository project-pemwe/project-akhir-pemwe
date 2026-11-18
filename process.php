<?php
declare(strict_types=1);

require_once __DIR__ . '/data.php';
require_once __DIR__ . '/function.php';

// Syarat 6: Input dari $_GET dengan null coalescing (??) dan htmlspecialchars()
$kataKunci = htmlspecialchars($_GET['cari'] ?? '', ENT_QUOTES, 'UTF-8');
$kategoriPilih = htmlspecialchars($_GET['kategori'] ?? 'Semua', ENT_QUOTES, 'UTF-8');
$opsiCadangan = (int) ($_GET['cadangan'] ?? 5);

if ($opsiCadangan < 0 || $opsiCadangan > 20) {
    $opsiCadangan = 5;
}
$persenCadangan = $opsiCadangan / 100;

// Syarat 5a: Fungsi bawaan array_column() & array_unique() untuk mengambil daftar kategori
$semuaKategori = array_unique(array_column($posUangSaku, 'kategori'));

// Syarat 5b: Fungsi bawaan array_filter() untuk menyaring pos pengeluaran sesuai parameter $_GET
$dataTersaring = array_filter($posUangSaku, function (array $item) use ($kataKunci, $kategoriPilih): bool {
    $cocokKategori = ($kategoriPilih === 'Semua') || (strcasecmp($item['kategori'], $kategoriPilih) === 0);
    $cocokTeks = ($kataKunci === '')
        || (stripos($item['nama_pos'], $kataKunci) !== false)
        || (stripos($item['kode'], $kataKunci) !== false);
    return $cocokKategori && $cocokTeks;
});

// Syarat 5c: Fungsi bawaan array_sum() dan array_column() untuk rekapitulasi anggaran
$totalJatah = (float) array_sum(array_column($dataTersaring, 'jatah_anggaran'));
$totalTerpakai = (float) array_sum(array_column($dataTersaring, 'terpakai'));
$totalTransaksi = (int) array_sum(array_column($dataTersaring, 'frekuensi_transaksi'));
$totalSisaKotor = $totalJatah - $totalTerpakai;

$totalSisaEfektif = 0.0;
foreach ($dataTersaring as $pos) {
    $rincian = olahRincianPos($pos, $persenCadangan);
    $totalSisaEfektif += $rincian['sisa_efektif'];
}