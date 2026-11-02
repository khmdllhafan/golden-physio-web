<?php

/**
 * @var string $tanggal_terpilih
 * @var array $jadwal
 */
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jadwal Fisioterapi - Golden Physio</title>
    <link rel="stylesheet" href="<?= base_url('css/user/jadwalfisioterapi.css'); ?>">
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
            <?php $uri = service('uri'); ?>
            <ul>
                <li class="<?= ($uri->getSegment(2) == 'home') ? 'active' : '' ?>">
                    <a href="<?= base_url('user/home'); ?>">Home</a>
                </li>
                <li class="<?= ($uri->getSegment(2) == 'jadwalfisioterapi') ? 'active' : '' ?>">
                    <a href="<?= base_url('user/jadwalfisioterapi'); ?>">Jadwal Fisioterapi</a>
                </li>
                <li class="<?= ($uri->getSegment(2) == 'pemesananfisioterapi') ? 'active' : '' ?>">
                    <a href="<?= base_url('user/pemesananfisioterapi'); ?>">Pemesanan Fisioterapi</a>
                </li>
                <li class="<?= ($uri->getSegment(2) == 'riwayatterapi') ? 'active' : '' ?>">
                    <a href="<?= base_url('user/riwayatterapi'); ?>">Riwayat Terapi</a>
                </li>
                <li class="<?= ($uri->getSegment(2) == 'profilsaya') ? 'active' : '' ?>">
                    <a href="<?= base_url('user/profilsaya'); ?>">Profil Saya</a>
                </li>
                <li>
                    <a href="<?= base_url('downloads/golden-physio.apk'); ?>" download style="color: #00bfff; font-weight: bold;">
                        <i class="fas fa-download"></i> Download APK
                    </a>
                </li>

                <li class="menu-bottom">
                    <a href="<?= base_url('user/logout'); ?>" class="btn-logout-footer">
                        <i class="fas fa-sign-out-alt"></i> Logout
                    </a>
                </li>
            </ul>
        </nav>

        <main class="content" role="main">
            <div class="table-container">
                <h2 class="fixed-title">Jadwal Terapi : <?= esc(date('d-m-Y', strtotime($tanggal_terpilih))); ?></h2>
                <form action="<?= base_url('user/jadwalfisioterapi'); ?>" method="get" class="filter-form">
                    <div class="filter-group">
                        <label>Tanggal:</label>
                        <input type="date" name="tanggal" value="<?= esc($tanggal_terpilih); ?>">
                    </div>
                    <div class="filter-actions">
                        <button type="submit" class="btn-filter">Filter</button>
                    </div>
                </form>
                <div class="table-scroll">
                    <table class="table-riwayat">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Pasien</th>
                                <th>Nama Terapis</th>
                                <th>Jam</th>
                                <th>Tanggal Terapi</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($jadwal)): ?>
                                <?php $no = 1;
                                foreach ($jadwal as $row): ?>
                                    <tr>
                                        <td class="text-center"><?= $no++; ?></td>
                                        <td><?= esc($row['nama']); ?></td>
                                        <td><?= esc($row['nama_terapis'] ?? '-'); ?></td>
                                        <td class="text-center"><?= esc(substr($row['jam_terapi'], 0, 5)); ?> WIB</td>
                                        <td class="text-center"><?= esc($row['tanggal_terapi']); ?></td>
                                        <td class="text-center">
                                            <span class="badge badge-<?= strtolower($row['status']); ?>">
                                                <?= esc($row['status']); ?>
                                            </span>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="6" style="text-align: center;">
                                        Tidak ada jadwal terapi untuk tanggal ini.
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </main>
    </div>
</body>

</html>