<?php
declare(strict_types=1);

require_once __DIR__ . '/process.php';

// Helper tampilan untuk format Rupiah yang rapi saat bernilai negatif (defisit)
function formatRupiahUI(float $nominal): string
{
    $isNegatif = $nominal < 0;
    $teks = 'Rp ' . number_format(abs($nominal), 0, ',', '.');
    return $isNegatif ? '-' . $teks : $teks;
}

$persenTotalSerapan = ($totalJatah > 0) ? (($totalTerpakai / $totalJatah) * 100) : 0.0;
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PocketFlow</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=JetBrains+Mono:wght@500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <!-- Top Navigation Bar -->
    <nav class="topbar">
        <div class="topbar-inner">
            <div class="brand">
                <div class="brand-icon">
                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M21 12V7H5a2 2 0 0 1 0-4h14v4"/>
                        <path d="M3 5v14a2 2 0 0 0 2 2h16v-5"/>
                        <path d="M18 12a2 2 0 0 0 0 4h4v-4Z"/>
                    </svg>
                </div>
                <div class="brand-text">
                    <h1>Sistem Pengelolaan & Evaluasi Uang Saku Bulanan</h1>
                </div>
            </div>
            <div class="topbar-badges">
                <span class="pill-info">
                    <span class="dot"></span>
                    Cadangan Aktif: <?= $opsiCadangan ?>%
                </span>
                <span class="pill-info">
                    Menampilkan <?= count($dataTersaring) ?> / <?= count($posUangSaku) ?> Pos
                </span>
            </div>
        </div>
    </nav>

    <main class="container">
        <!-- KPI Summary Cards -->
        <section class="stats-grid">
            <div class="stat-card">
                <div class="stat-header">
                    <span class="stat-title">Total Jatah Anggaran</span>
                    <div class="stat-icon icon-blue">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="20" height="14" x="2" y="5" rx="2"/><line x1="2" x2="22" y1="10" y2="10"/></svg>
                    </div>
                </div>
                <div class="stat-value"><?= formatRupiahUI($totalJatah) ?></div>
                <div class="stat-meta">Alokasi dari <?= count($dataTersaring) ?> pos pengeluaran aktif</div>
            </div>

            <div class="stat-card">
                <div class="stat-header">
                    <span class="stat-title">Total Realisasi Terpakai</span>
                    <div class="stat-icon icon-amber">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 2v20M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg>
                    </div>
                </div>
                <div class="stat-value"><?= formatRupiahUI($totalTerpakai) ?></div>
                <div class="stat-meta">
                    <?= number_format($persenTotalSerapan, 1) ?>% terserap dari <?= $totalTransaksi ?> transaksi
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-header">
                    <span class="stat-title">Sisa Aktual (Sebelum Cadangan)</span>
                    <div class="stat-icon <?= $totalSisaKotor < 0 ? 'icon-rose' : 'icon-emerald' ?>">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 12h-4l-3 9L9 3l-3 9H2"/></svg>
                    </div>
                </div>
                <div class="stat-value <?= $totalSisaKotor < 0 ? 'text-deficit' : 'text-surplus' ?>">
                    <?= formatRupiahUI($totalSisaKotor) ?>
                </div>
                <div class="stat-meta">Selisih murni jatah dikurangi realisasi</div>
            </div>

            <div class="stat-card">
                <div class="stat-header">
                    <span class="stat-title">Sisa Efektif (Cadangan <?= $opsiCadangan ?>%)</span>
                    <div class="stat-icon <?= $totalSisaEfektif < 0 ? 'icon-rose' : 'icon-emerald' ?>">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
                    </div>
                </div>
                <div class="stat-value <?= $totalSisaEfektif < 0 ? 'text-deficit' : 'text-surplus' ?>">
                    <?= formatRupiahUI($totalSisaEfektif) ?>
                </div>
                <div class="stat-meta">
                    <?= $totalSisaEfektif < 0 ? 'Defisit setelah dikurangi dana darurat' : 'Aman setelah disisihkan dana darurat' ?>
                </div>
            </div>
        </section>

        <!-- Filter Bar ($_GET) -->
        <section class="filter-panel">
            <form method="GET" action="" class="filter-form">
                <div class="form-group">
                    <label for="cari">Cari Nama / Kode Pos Pengeluaran</label>
                    <div class="input-wrapper">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/></svg>
                        <input type="text" id="cari" name="cari" class="form-control" value="<?= $kataKunci ?>" placeholder="Ketik Makan, Praktikum, atau POS-04...">
                    </div>
                </div>

                <div class="form-group">
                    <label for="kategori">Filter Kategori</label>
                    <select id="kategori" name="kategori" class="form-control">
                        <option value="Semua" <?= $kategoriPilih === 'Semua' ? 'selected' : '' ?>>Semua Kategori</option>
                        <?php foreach ($semuaKategori as $kat): ?>
                            <option value="<?= htmlspecialchars($kat) ?>" <?= $kategoriPilih === $kat ? 'selected' : '' ?>>
                                <?= htmlspecialchars($kat) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="form-group">
                    <label for="cadangan">Simulasi Tabungan Darurat</label>
                    <select id="cadangan" name="cadangan" class="form-control">
                        <?php
                        // Syarat 3b (Bagian 1): Perulangan for untuk opsi persentase dana cadangan 0% s.d. 20%
                        for ($persen = 0; $persen <= 20; $persen += 5):
                        ?>
                            <option value="<?= $persen ?>" <?= $opsiCadangan === $persen ? 'selected' : '' ?>>
                                Sisihkan <?= $persen ?>% per Pos
                            </option>
                        <?php endfor; ?>
                    </select>
                </div>

                <div class="btn-group">
                    <button type="submit" class="btn btn-primary">Terapkan Filter</button>
                    <a href="index.php" class="btn btn-secondary">Reset</a>
                </div>
            </form>
        </section>

        <!-- Data Table -->
        <section class="table-card">
            <div class="table-card-header">
                <div>
                    <h2>Rincian Alokasi & Evaluasi Pos Pengeluaran</h2>
                </div>
            </div>

            <div class="table-responsive">
                <table>
                    <thead>
                        <tr>
                            <th>Kode</th>
                            <th>Pos Pengeluaran & Prioritas</th>
                            <th>Kategori</th>
                            <th class="text-right">Jatah Anggaran</th>
                            <th>Realisasi & Serapan</th>
                            <th class="text-right">Sisa Efektif</th>
                            <th>Status Anggaran</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($dataTersaring)): ?>
                            <tr>
                                <td colspan="7" class="empty-state">
                                    Tidak ditemukan data pos pengeluaran untuk kata kunci "<strong><?= $kataKunci ?></strong>" pada kategori "<strong><?= $kategoriPilih ?></strong>".
                                </td>
                            </tr>
                        <?php else: ?>
                            <?php
                            // Syarat 3a: Perulangan foreach untuk menampilkan baris tabel HTML
                            foreach ($dataTersaring as $pos):
                                $rincian = olahRincianPos($pos, $persenCadangan);

                                [$kelasStatus, $kelasBar] = match ($rincian['status']) {
                                    'Aman (Terkendali)'      => ['status-ok', 'active-ok'],
                                    'Waspada (Hampir Habis)' => ['status-warn', 'active-warn'],
                                    default                  => ['status-danger', 'active-danger'],
                                };

                                $kelasKategori = match ($pos['kategori']) {
                                    'Kebutuhan Pokok' => 'cat-pokok',
                                    'Akademik'        => 'cat-akademik',
                                    'Penunjang'       => 'cat-penunjang',
                                    default           => 'cat-gayahidup',
                                };
                            ?>
                                <tr>
                                    <td>
                                        <span class="code-badge"><?= htmlspecialchars($pos['kode']) ?></span>
                                    </td>
                                    <td>
                                        <div class="pos-title"><?= htmlspecialchars($pos['nama_pos']) ?></div>
                                        <div class="pos-sub">
                                            <span><?= htmlspecialchars($rincian['prioritas']) ?></span>
                                            <span>•</span>
                                            <span><?= $pos['frekuensi_transaksi'] ?>x transaksi</span>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="cat-pill <?= $kelasKategori ?>">
                                            <?= htmlspecialchars($pos['kategori']) ?>
                                        </span>
                                    </td>
                                    <td class="text-right num-col">
                                        <strong><?= formatRupiahUI((float) $pos['jatah_anggaran']) ?></strong>
                                    </td>
                                    <td class="usage-box">
                                        <div class="usage-top">
                                            <span class="usage-amount"><?= formatRupiahUI((float) $pos['terpakai']) ?></span>
                                            <span class="usage-pct"><?= number_format($rincian['persen_pakai'], 1) ?>%</span>
                                        </div>
                                        <div class="segment-track" title="Level Serapan: <?= $rincian['level_serapan'] ?> dari 5">
                                            <?php
                                            // Syarat 3b (Bagian 2): Perulangan for untuk menampilkan 5 segmen indikator serapan
                                            for ($i = 1; $i <= 5; $i++):
                                                $segClass = ($i <= $rincian['level_serapan']) ? $kelasBar : '';
                                            ?>
                                                <span class="segment-bar <?= $segClass ?>"></span>
                                            <?php endfor; ?>
                                        </div>
                                    </td>
                                    <td class="text-right num-col">
                                        <div class="eff-amount <?= $rincian['sisa_efektif'] < 0 ? 'text-deficit' : 'text-surplus' ?>">
                                            <?= formatRupiahUI($rincian['sisa_efektif']) ?>
                                        </div>
                                        <div class="eff-reserve">
                                            Cadangan: <?= formatRupiahUI($rincian['dana_cadangan']) ?>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="status-badge <?= $kelasStatus ?>">
                                            <span class="status-dot"></span>
                                            <?= htmlspecialchars($rincian['status']) ?>
                                        </span>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                    <?php if (!empty($dataTersaring)): ?>
                        <tfoot>
                            <tr>
                                <td colspan="3">Total Rekapitulasi (<?= count($dataTersaring) ?> Pos)</td>
                                <td class="text-right num-col"><?= formatRupiahUI($totalJatah) ?></td>
                                <td class="num-col"><?= formatRupiahUI($totalTerpakai) ?> (<?= number_format($persenTotalSerapan, 1) ?>%)</td>
                                <td class="text-right num-col <?= $totalSisaEfektif < 0 ? 'text-deficit' : 'text-surplus' ?>">
                                    <?= formatRupiahUI($totalSisaEfektif) ?>
                                </td>
                                <td></td>
                            </tr>
                        </tfoot>
                    <?php endif; ?>
                </table>
            </div>
        </section>
    </main>

</body>
</html>