<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home Terapis - Golden Physio</title>
    <link rel="stylesheet" href="<?= base_url('css/terapis/home.css'); ?>">
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
            <?php $uri = service('uri');
            $segment2 = $uri->getSegment(2);
            ?>
            <ul class="sidebar-menu">
                <li class="<?= ($segment2 == 'home') ? 'active' : '' ?>">
                    <a href="<?= base_url('terapis/home'); ?>"></i> Home</a>
                </li>
                <li class="<?= ($segment2 == 'jadwal') ? 'active' : '' ?>">
                    <a href="<?= base_url('terapis/jadwal'); ?>"></i> Jadwal Fisioterapi</a>
                </li>
                <li class="<?= ($segment2 == 'riwayat') ? 'active' : '' ?>">
                    <a href="<?= base_url('terapis/riwayat'); ?>"></i> Riwayat Terapi Pasien</a>
                </li>
                <li class="<?= ($segment2 == 'profil') ? 'active' : '' ?>">
                    <a href="<?= base_url('terapis/profil'); ?>"></i> Profil Saya</a>
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
                <div class="welcome">
                    <h2>Selamat Datang, <?= session()->get('username'); ?>!</h2>
                    <p>Anda login sebagai <strong>Terapis (Physiotherapist)</strong></p>
                </div>
                <div class="dashboard-section">
                    <h3>BERANDA JADWAL HARI INI - [<?= date('l, d F Y'); ?>]</h3>

                    <div class="card-stats-container">
                        <div class="card-stat">
                            <div class="stat-icon blue">📅</div>
                            <div class="stat-info">
                                <span class="stat-label">Total Jadwal</span>
                                <span class="stat-value"><?= $total_jadwal ?? 0; ?></span>
                            </div>
                        </div>
                        <div class="card-stat">
                            <div class="stat-icon green">✅</div>
                            <div class="stat-info">
                                <span class="stat-label">Pasien Selesai</span>
                                <span class="stat-value"><?= $pasien_selesai ?? 0; ?></span>
                            </div>
                        </div>
                        <div class="card-stat">
                            <div class="stat-icon orange">⏳</div>
                            <div class="stat-info">
                                <span class="stat-label">Pemesanan Pending</span>
                                <span class="stat-value"><?= $pemesanan_pending ?? 0; ?></span>
                            </div>
                        </div>
                    </div>

                    <div class="card table-card">
                        <h4>5 PEMESANAN TERAKHIR</h4>
                        <div class="table-responsive">
                            <table class="data-table">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Pasien</th>
                                        <th>Tanggal Terapi</th>
                                        <th>Jam Terapi</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (!empty($lima_pemesanan) && is_array($lima_pemesanan)) : ?>
                                        <?php $no = 1; ?>
                                        <?php foreach ($lima_pemesanan as $pesan) : ?>
                                            <tr>
                                                <td><?= $no++; ?></td>
                                                <td><strong><?= esc($pesan['nama']); ?></strong></td>
                                                <td style="text-align: center;"><?= date('d-m-Y', strtotime($pesan['tanggal_terapi'])); ?></td>
                                                <td style="text-align: center;"><?= date('H:i', strtotime($pesan['jam_terapi'])); ?> WIB</td>
                                                <td style="text-align: center;">
                                                    <?php
                                                    $status = $pesan['status'];

                                                    $class_status = 'status ';

                                                    if ($status == 'Pending') {
                                                        $class_status .= 'status-pending';
                                                    } elseif ($status == 'Disetujui') {
                                                        $class_status .= 'status-disetujui';
                                                    } elseif ($status == 'Diproses') {
                                                        $class_status .= 'status-diproses';
                                                    } elseif ($status == 'Ditolak') {
                                                        $class_status .= 'status-ditolak';
                                                    } elseif ($status == 'Selesai') {
                                                        $class_status .= 'status-selesai';
                                                    } else {
                                                        $class_status .= 'status-pending';
                                                    }
                                                    ?>
                                                    <span class="<?= $class_status; ?>"><?= esc($status); ?></span>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php else : ?>
                                        <tr>
                                            <td colspan="7" style="text-align: center; padding: 30px; color: #666;">
                                                Belum ada data riwayat untuk pasien ini.
                                            </td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
    </div>
    </main>
    </div>
</body>

</html>