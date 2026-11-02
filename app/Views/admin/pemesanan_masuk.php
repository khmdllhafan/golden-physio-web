<?php

/**
 * @var string|null $tanggal_terpilih
 * @var array $pemesanan
 */
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pemesanan Masuk - Admin Golden Physio</title>
    <link rel="stylesheet" href="<?= base_url('css/admin/pemesanan_masuk.css'); ?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>

<body>
    <header>
        <div class="logo">
            <img src="<?= base_url('images/logo.png'); ?>" alt="Logo Golden Physio">
            <h1>GOLDEN PHYSIO</h1>
        </div>
    </header>

    <div class="container">
        <nav class="sidebar">
            <?php
            $uri = service('uri');
            $segment2 = $uri->getSegment(2);
            $role = session()->get('role');
            ?>
            <ul>
                <li class="<?= ($segment2 == 'home') ? 'active' : '' ?>"><a href="<?= base_url('admin/home'); ?>">Home</a></li>

                <?php if ($role === 'Admin' || $role === 'Super Admin'): ?>
                    <li class="<?= ($segment2 == 'pemesanan') ? 'active' : '' ?>">
                        <a href="<?= base_url('admin/pemesanan'); ?>">Pemesanan Masuk</a>
                    </li>
                <?php endif; ?>

                <li class="<?= ($segment2 == 'riwayat') ? 'active' : '' ?>"><a href="<?= base_url('admin/riwayat'); ?>">Riwayat Terapi Pasien</a></li>

                <?php if ($role === 'Admin' || $role === 'Super Admin'): ?>
                    <li class="<?= ($segment2 == 'pasien' || $segment2 == 'detailpasien') ? 'active' : '' ?>">
                        <a href="<?= base_url('admin/pasien'); ?>">Data Pasien</a>
                    </li>
                <?php endif; ?>

                <?php if ($role === 'Super Admin'): ?>
                    <li class="<?= ($segment2 == 'terapis' || $segment2 == 'detailterapis') ? 'active' : '' ?>">
                        <a href="<?= base_url('admin/terapis'); ?>">Data Terapis</a>
                    </li>
                <?php endif; ?>

                <?php if ($role === 'Super Admin'): ?>
                    <li class="<?= ($segment2 == 'admin' || $segment2 == 'detailadmin') ? 'active' : '' ?>">
                        <a href="<?= base_url('admin/admin'); ?>">Data Admin</a>
                    </li>
                <?php endif; ?>

                <li class="<?= ($segment2 == 'laporan_pemesanan') ? 'active' : '' ?>"><a href="<?= base_url('admin/laporan_pemesanan'); ?>">Laporan Fisioterapi</a></li>
                <li class="<?= ($segment2 == 'profilsaya') ? 'active' : '' ?>"><a href="<?= base_url('admin/profilsaya'); ?>">Profil Saya</a></li>
                <li><a href="<?= base_url('admin/logout'); ?>" class="btn-logout-footer"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
            </ul>
        </nav>

        <main class="content">
            <div class="content-body">
                <div class="card table-card">
                    <div class="table-responsive">
                        <h1 class="page-title">Antrean Pemesanan Pasien</h1>
                        <form action="<?= base_url('admin/pemesanan'); ?>" method="get" class="filter-form">
                            <div class="filter-group">
                                <label>Tanggal:</label>
                                <!-- Perbaikan baris dibawah -->
                                <input type="date" name="tanggal" value="<?= esc($tanggal_terpilih ?? date('Y-m-d')); ?>">
                            </div>
                            <div class="filter-actions">
                                <button type="submit" class="btn-filter">Filter</button>
                            </div>
                        </form>

                        <?php if (session()->getFlashdata('success')) : ?>
                            <div class="success">
                                <?= session()->getFlashdata('success'); ?>
                            </div>
                        <?php endif; ?>

                        <?php if (session()->getFlashdata('error')) : ?>
                            <div class="error">
                                <?= session()->getFlashdata('error'); ?>
                            </div>
                        <?php endif; ?>

                        <table class="data-table">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Pasien</th>
                                    <th>Kontak & Alamat</th>
                                    <th>Jadwal Terapi</th>
                                    <th>Keluhan & Riwayat</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i = 1; ?>
                                <?php if (!empty($pemesanan)) : ?>
                                    <?php foreach ($pemesanan as $p) : ?>
                                        <tr>
                                            <td><?= $i++; ?></td>
                                            <td><strong><?= esc($p['nama']); ?></strong></td>
                                            <td>
                                                <small>
                                                    <?= esc($p['no_hp']); ?><br>
                                                    <?= esc($p['alamat']); ?>
                                                </small>
                                            </td>
                                            <td>
                                                <span class="badge-date"><?= esc($p['tanggal_terapi']); ?></span><br>
                                                <small>Jam: <?= esc($p['jam_terapi']); ?></small>
                                            </td>
                                            <td>
                                                <small>
                                                    <strong>Keluhan:</strong> <?= esc($p['keluhan']); ?><br>
                                                    <strong>Riwayat:</strong> <?= esc($p['riwayat_cedera'] ?: '-'); ?>
                                                </small>
                                            </td>
                                            <td style="text-align: center;">
                                                <?php $status_raw = strtolower($p['status']); ?>
                                                <span class="status status-<?= $status_raw; ?>">
                                                    <?= esc($p['status']); ?>
                                                </span>
                                            </td>
                                            <td>
                                                <div class="action-buttons">
                                                    <?php if ($status_raw == 'pending') : ?>
                                                        <a href="<?= base_url('admin/pemesanan/setuju/' . $p['id_pemesanan']); ?>" class="btn-approve">Terima</a>
                                                        <a href="<?= base_url('admin/pemesanan/tolak/' . $p['id_pemesanan']); ?>" class="btn-reject">Tolak</a>

                                                    <?php elseif ($status_raw == 'disetujui') : ?>
                                                        <a href="<?= base_url('admin/pemesanan/proses/' . $p['id_pemesanan']); ?>" class="btn-process">Proses</a>
                                                        <a href="<?= base_url('admin/pemesanan/batalkan/' . $p['id_pemesanan']); ?>" class="btn-cancel">Batalkan</a>

                                                    <?php elseif ($status_raw == 'diproses') : ?>
                                                        <a href="<?= base_url('admin/pemesanan/selesai/' . $p['id_pemesanan']); ?>" class="btn-finish">Selesai</a>

                                                    <?php else : ?>
                                                        <small style="color: #999;">Tidak ada aksi (Status: <?= $p['status'] ?: 'KOSONG'; ?>)</small>
                                                    <?php endif; ?>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else : ?>
                                    <tr>
                                        <td colspan="7" style="text-align: center; padding: 20px;">Belum ada pemesanan masuk.</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </main>
    </div>
</body>

</html>