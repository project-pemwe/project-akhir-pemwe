<?php
declare(strict_types=1);

// Syarat 1: Array multidimensi asosiatif minimal 10 baris sesuai topik uang saku bulanan
$posUangSaku = [
    [
        'kode' => 'POS-01',
        'nama_pos' => 'Sewa Kos & Tagihan Listrik',
        'kategori' => 'Kebutuhan Pokok',
        'jatah_anggaran' => 850000.0,
        'terpakai' => 850000.0,
        'frekuensi_transaksi' => 2
    ],
    [
        'kode' => 'POS-02',
        'nama_pos' => 'Makan Harian & Air Galon',
        'kategori' => 'Kebutuhan Pokok',
        'jatah_anggaran' => 900000.0,
        'terpakai' => 765000.0,
        'frekuensi_transaksi' => 45
    ],
    [
        'kode' => 'POS-03',
        'nama_pos' => 'Paket Data Internet & Pulsa',
        'kategori' => 'Penunjang',
        'jatah_anggaran' => 150000.0,
        'terpakai' => 115000.0,
        'frekuensi_transaksi' => 3
    ],
    [
        'kode' => 'POS-04',
        'nama_pos' => 'Komponen Praktikum & Alat Kuliah',
        'kategori' => 'Akademik',
        'jatah_anggaran' => 300000.0,
        'terpakai' => 285000.0,
        'frekuensi_transaksi' => 6
    ],
    [
        'kode' => 'POS-05',
        'nama_pos' => 'BBM Kendaraan & Transportasi',
        'kategori' => 'Penunjang',
        'jatah_anggaran' => 200000.0,
        'terpakai' => 140000.0,
        'frekuensi_transaksi' => 8
    ],
    [
        'kode' => 'POS-06',
        'nama_pos' => 'Laundry & Kebutuhan Mandi',
        'kategori' => 'Kebutuhan Pokok',
        'jatah_anggaran' => 120000.0,
        'terpakai' => 95000.0,
        'frekuensi_transaksi' => 5
    ],
    [
        'kode' => 'POS-07',
        'nama_pos' => 'Kopi, Nongkrong & Jajan Sore',
        'kategori' => 'Gaya Hidup',
        'jatah_anggaran' => 200000.0,
        'terpakai' => 235000.0,
        'frekuensi_transaksi' => 12
    ],
    [
        'kode' => 'POS-08',
        'nama_pos' => 'Fotokopi, Cetak Laporan & Buku',
        'kategori' => 'Akademik',
        'jatah_anggaran' => 100000.0,
        'terpakai' => 65000.0,
        'frekuensi_transaksi' => 4
    ],
    [
        'kode' => 'POS-09',
        'nama_pos' => 'Vitamin, Obat & Dana Kesehatan',
        'kategori' => 'Kebutuhan Pokok',
        'jatah_anggaran' => 100000.0,
        'terpakai' => 35000.0,
        'frekuensi_transaksi' => 2
    ],
    [
        'kode' => 'POS-10',
        'nama_pos' => 'Langganan Aplikasi & Hiburan',
        'kategori' => 'Gaya Hidup',
        'jatah_anggaran' => 80000.0,
        'terpakai' => 75000.0,
        'frekuensi_transaksi' => 2
    ]
];