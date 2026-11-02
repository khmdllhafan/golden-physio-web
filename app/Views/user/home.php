<?php $uri = service('uri'); ?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home Pasien - Golden Physio</title>
    <link rel="stylesheet" href="<?= base_url('css/user/home.css'); ?>">
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

        <main class="content">
            <?php if (session()->getFlashdata('success')): ?>
                <div class="success">
                    <?= esc(session()->getFlashdata('success')); ?>
                </div>
            <?php endif; ?>

            <?php if (session()->getFlashdata('error')): ?>
                <div class="error">
                    <?= esc(session()->getFlashdata('error')); ?>
                </div>
            <?php endif; ?>

            <?php
            if (session()->getFlashdata('welcome')): ?>
                <div class="welcome">
                    <?= esc(session()->getFlashdata('welcome')); ?>
                </div>
            <?php else:
                date_default_timezone_set('Asia/Jakarta');
                $hour = (int) date('H');

                if ($hour >= 4 && $hour < 10) {
                    $salam = 'Selamat Pagi';
                } elseif ($hour >= 10 && $hour < 15) {
                    $salam = 'Selamat Siang';
                } elseif ($hour >= 15 && $hour < 18) {
                    $salam = 'Selamat Sore';
                } else {
                    $salam = 'Selamat Malam';
                }

                $nama = session()->get('nama_lengkap') ? session()->get('nama_lengkap') : session()->get('username');
            ?>
                <div class="welcome">
                    <?= esc($salam); ?>, <strong><?= esc($nama); ?></strong>!
                    <p>Selamat Datang di <strong>Golden Physio Pekalongan</strong>.</p>
                    <p>
                        Terima kasih telah mempercayakan kesehatan Anda kepada kami.
                        <strong>Golden Physio</strong> hadir sebagai solusi terpercaya untuk layanan fisioterapi yang nyaman, aman, dan profesional.
                        Kami siap mendampingi Anda dalam setiap langkah pemulihan dan perawatan tubuh.
                    </p>
                    <p>Sehat itu prioritas. Mulailah bersama <strong>Golden Physio Pekalongan</strong>.</p>
                </div>
            <?php endif; ?>

            <div class="dashboard-grid">
                <div class="stat-card">
                    <div class="card-icon"><i class="fas fa-calendar-check"></i></div>
                    <div class="card-info">
                        <h3>Pesan Terapi</h3>
                        <p>Atur jadwal kunjungan fisioterapi Anda dengan mudah.</p>
                        <a href="<?= base_url('user/pemesananfisioterapi'); ?>" class="btn-link">Buat Janji →</a>
                    </div>
                </div>

                <div class="stat-card">
                    <div class="card-icon"><i class="fas fa-history"></i></div>
                    <div class="card-info">
                        <h3>Riwayat</h3>
                        <p>Lihat catatan perkembangan terapi yang telah dilakukan.</p>
                        <a href="<?= base_url('user/riwayatterapi'); ?>" class="btn-link">Lihat Detail →</a>
                    </div>
                </div>

                <div class="stat-card">
                    <div class="card-icon"><i class="fas fa-user-circle"></i></div>
                    <div class="card-info">
                        <h3>Profil Saya</h3>
                        <p>Perbarui informasi kontak dan keamanan akun Anda.</p>
                        <a href="<?= base_url('user/profilsaya'); ?>" class="btn-link">Kelola Akun →</a>
                    </div>
                </div>
            </div>

            <div class="info-banner">
                <i class="fas fa-info-circle"></i>
                <span><strong>Tips Hari Ini:</strong> Jangan lupa melakukan peregangan ringan setiap 2 jam saat bekerja untuk menjaga kelenturan otot.</span>
            </div>
        </main>
    </div>
</body>

</html>