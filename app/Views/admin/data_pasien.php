<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Pasien - Golden Physio</title>
    <link rel="stylesheet" href="<?= base_url('css/admin/data_pasien.css'); ?>">
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
                <div class="card">
                    <div class="table-responsive">
                        <h1 class="page-title">Data Pasien</h1>

                        <form action="<?= base_url('admin/pasien'); ?>" method="get" class="search-form">
                            <div class="search-group">
                                <input type="text" name="keyword" value="<?= service('request')->getGet('keyword'); ?>" placeholder="Cari nama atau username...">
                            </div>

                            <div class="search-action">
                                <button type="submit" class="btn-search">Cari</button>
                                <a href="<?= base_url('admin/pasien'); ?>" class="btn-reset">Reset</a>
                            </div>
                        </form>

                        <div class="header-action">
                            <a href="<?= base_url('admin/pasien/tambah'); ?>" class="btn-tambah">Tambah Pasien</a>
                        </div>

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
                                    <th width="50">No</th>
                                    <th>Nama Pasien</th>
                                    <th>Username</th>
                                    <th>Tanggal Daftar</th>
                                    <th width="150">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($user)) : ?>
                                    <?php $n = 1; ?>
                                    <?php foreach ($user as $u) : ?>
                                        <tr>
                                            <td><?= $n++; ?></td>
                                            <td><strong><?= esc($u['nama_lengkap']); ?></strong></td>
                                            <td><?= esc($u['username']); ?></td>
                                            <td style="text-align: center;"><?= $u['created_at']; ?></td>
                                            <td style="text-align: center;">
                                                <div class="action-buttons">
                                                    <a href="<?= base_url('admin/detailpasien/' . $u['id_user']); ?>" class="btn-process">Lihat</a>
                                                    <a href="<?= base_url('admin/pasien/hapus/' . $u['id_user']); ?>"
                                                        class="btn-delete"
                                                        onclick="return confirm('Yakin ingin menghapus?');">
                                                        Hapus
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else : ?>
                                    <tr>
                                        <td colspan="5" style="text-align: center; padding: 20px;">Data pasien tidak ditemukan.</td>
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