<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Terapi Pasien - Golden Physio</title>
    <link rel="stylesheet" href="<?= base_url('css/terapis/riwayat_terapi.css'); ?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>

<body>
    <header>
        <div class="logo">
            <img src="<?= base_url('images/logo.png'); ?>" alt="Logo Golden Physio">
            <h1>GOLDEN PHYSIO</h1>
        </div>
    </header>

    <div class="">
        <nav class="sidebar">
            <?php $uri = service('uri');
            $segment2 = $uri->getSegment(2); ?>
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
                    <h1 class="page-title">Riwayat Terapi Pasien</h1>
                    <form action="<?= base_url('terapis/riwayat'); ?>" method="get" class="search-form">
                        <div class="search-group">
                            <input type="text" name="keyword" value="<?= service('request')->getGet('keyword'); ?>" placeholder="Cari nama atau username...">
                        </div>

                        <div class="search-action">
                            <button type="submit" class="btn-search">Cari</button>
                            <a href="<?= base_url('terapis/riwayat'); ?>" class="btn-reset">Reset</a>
                        </div>
                    </form>
                    <div class="table-responsive">
                        <table class="data-table">
                            <thead>
                                <tr>
                                    <th width="50">No</th>
                                    <th>Nama Pasien</th>
                                    <th>Username</th>
                                    <th width="150">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i = 1; ?>
                                <?php if (!empty($riwayat)) : ?>
                                    <?php foreach ($riwayat as $r) : ?>
                                        <tr>
                                            <td style="text-align: center;"><?= $i++; ?></td>
                                            <td>
                                                <strong><?= esc($r['nama_lengkap']); ?></strong>
                                            </td>
                                            <td>
                                                <?= esc($r['username']); ?>
                                            </td>
                                            <td>
                                                <div class="action-buttons">
                                                    <a href="<?= base_url('terapis/riwayat/lihat/' . $r['id_user']); ?>" class="btn-process">
                                                        Lihat Riwayat
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else : ?>
                                    <tr>
                                        <td colspan="4" style="text-align: center; padding: 30px; color: #666;">
                                            Belum ada data riwayat untuk pasien ini.
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