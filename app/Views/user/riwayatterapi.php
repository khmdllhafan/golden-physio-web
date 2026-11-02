<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Terapi - Golden Physio</title>
    <link rel="stylesheet" href="<?= base_url('css/user/riwayatterapi.css'); ?>">
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
                <h2 class="fixed-title">Riwayat Terapi</h2>
                <form action="<?= base_url('user/riwayatterapi'); ?>" method="get" class="filter-form">
                    <div class="filter-group">
                        <label>Tanggal:</label>
                        <input type="date" name="tanggal" value="<?= service('request')->getGet('tanggal'); ?>">
                    </div>

                    <div class="filter-group">
                        <label>Bulan:</label>
                        <select name="bulan">
                            <option value="">Semua</option>
                            <?php
                            $bulan_sekarang = service('request')->getGet('bulan');
                            $nama_bulan = [1 => 'Jan', 2 => 'Feb', 3 => 'Mar', 4 => 'Apr', 5 => 'Mei', 6 => 'Jun', 7 => 'Jul', 8 => 'Agu', 9 => 'Sep', 10 => 'Okt', 11 => 'Nov', 12 => 'Des'];
                            foreach ($nama_bulan as $key => $nama) : ?>
                                <option value="<?= $key; ?>" <?= ($bulan_sekarang == $key) ? 'selected' : ''; ?>><?= $nama; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="filter-group">
                        <label>Tahun:</label>
                        <input type="number" name="tahun" value="<?= service('request')->getGet('tahun') ?? date('Y'); ?>">
                    </div>

                    <div class="filter-group">
                        <label>Urutkan</label>
                        <select name="sort">
                            <option value="DESC" <?= (service('request')->getGet('sort') == 'DESC') ? 'selected' : ''; ?>>Terbaru ke Terlama</option>
                            <option value="ASC" <?= (service('request')->getGet('sort') == 'ASC') ? 'selected' : ''; ?>>Terlama ke Terbaru</option>
                        </select>
                    </div>

                    <div class="filter-actions">
                        <button type="submit" class="btn-filter">Filter</button>
                        <a href="<?= base_url('user/riwayatterapi'); ?>" class="btn-reset">Reset</a>
                    </div>
                </form>

                <div class="table-scroll">
                    <table class="table-riwayat">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Tanggal Terapi</th>
                                <th>Jam</th>
                                <th>Terapis</th>
                                <th>Keluhan</th>
                                <th>Riwayat Cedera</th>
                                <th>Catatan</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($riwayat) && count($riwayat) > 0): ?>
                                <?php
                                $no = 1;
                                foreach ($riwayat as $row): ?>
                                    <tr>
                                        <td style="text-align: center;"><?= $no++; ?></td>
                                        <td style="text-align: center;"><?= date('d-m-Y', strtotime($row['tanggal_terapi'])); ?></td>
                                        <td style="text-align: center;"><?= date('H:i', strtotime($row['jam_terapi'])); ?> WIB</td>
                                        <td><?= esc($row['nama_terapis'] ?? '-'); ?></td>
                                        <td><?= esc($row['keluhan']); ?></td>
                                        <td><?= esc($row['riwayat_cedera']); ?></td>
                                        <td><?= esc($row['catatan']); ?></td>
                                        <td style="text-align: center;">
                                            <?php $status = strtolower($row['status']); ?>
                                            <span class="badge badge-<?= $status; ?>">
                                                <?= esc($row['status']); ?>
                                            </span>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="8" style="text-align: center; padding: 30px; color: #666;">
                                        Belum ada data riwayat untuk pasien ini.
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