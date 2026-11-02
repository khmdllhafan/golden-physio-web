<?php

/**
 * @var string $tanggal_terpilih
 * @var array $jadwal
 */
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jadwal Fisioterapi - Golden Physio</title>
    <link rel="stylesheet" href="<?= base_url('css/terapis/jadwal_fisioterapi.css'); ?>">
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
            ?>
            <ul class="sidebar-menu">
                <li class="<?= ($segment2 == 'home') ? 'active' : '' ?>">
                    <a href="<?= base_url('terapis/home'); ?>">Home</a>
                </li>
                <li class="<?= ($segment2 == 'jadwal') ? 'active' : '' ?>">
                    <a href="<?= base_url('terapis/jadwal'); ?>">Jadwal Fisioterapi</a>
                </li>
                <li class="<?= ($segment2 == 'riwayat') ? 'active' : '' ?>">
                    <a href="<?= base_url('terapis/riwayat'); ?>">Riwayat Terapi Pasien</a>
                </li>
                <li class="<?= ($segment2 == 'profil') ? 'active' : '' ?>">
                    <a href="<?= base_url('terapis/profil'); ?>">Profil Saya</a>
                </li>
                <li class="menu-bottom">
                    <a href="<?= base_url('terapis/logout'); ?>" class="btn-logout-footer">
                        <i class="fas fa-sign-out-alt"></i> Logout
                    </a>
                </li>
            </ul>
        </nav>

        <main class="content">
            <div class="content-body">
                <div class="card">
                    <h2 class="page-title">Jadwal Terapi : <?= esc(date('d-m-Y', strtotime($tanggal_terpilih))); ?></h2>
                    <form action="<?= base_url('terapis/jadwal'); ?>" method="get" class="filter-form">
                        <div class="filter-group">
                            <label>Tanggal:</label>
                            <input type="date" name="tanggal" value="<?= esc($tanggal_terpilih); ?>">
                        </div>
                        <div class="filter-actions">
                            <button type="submit" class="btn-filter">Filter</button>
                        </div>
                    </form>
                    <div class="table-responsive">
                        <table class="data-table">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Pasien</th>
                                    <th>Nama Terapis</th>
                                    <th>Tanggal</th>
                                    <th>Jam</th>
                                    <th>Keluhan</th>
                                    <th>Riwayat Cedera</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($pemesanan) && is_array($pemesanan)) : ?>
                                    <?php $no = 1; ?>
                                    <?php foreach ($pemesanan as $row) : ?>
                                        <tr>
                                            <td><?= $no++; ?></td>
                                            <td><strong><?= esc($row['nama'] ?? '-'); ?></strong></td>
                                            <td><?= esc($row['nama_terapis'] ?? '-'); ?></td>
                                            <td style="text-align: center;"><?= date('d-m-Y', strtotime($row['tanggal_terapi'])); ?></td>
                                            <td style="text-align: center;"><?= date('H:i', strtotime($row['jam_terapi'])); ?> WIB</td>
                                            <td><?= esc($row['keluhan']); ?></td>
                                            <td><?= !empty($row['riwayat_cedera']) ? esc($row['riwayat_cedera']) : '-'; ?></td>
                                            <td style="text-align: center;">
                                                <?php
                                                $statusClass = 'status-pending';

                                                if ($row['status'] == 'Disetujui')   $statusClass = 'status-disetujui';
                                                if ($row['status'] == 'Ditolak')      $statusClass = 'status-ditolak';
                                                if ($row['status'] == 'Diproses')     $statusClass = 'status-diproses';
                                                if ($row['status'] == 'Dibatalkan')   $statusClass = 'status-dibatalkan';
                                                if ($row['status'] == 'Selesai')      $statusClass = 'status-selesai';
                                                ?>

                                                <span class="status <?= $statusClass; ?>"><?= esc($row['status']); ?></span>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else : ?>
                                    <tr>
                                        <td colspan="8" style="text-align: center; padding: 30px; color: #666;">
                                            Belum ada data jadwal untuk tanggal ini.
                                        </td>
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