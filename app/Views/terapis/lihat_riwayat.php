<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Terapi <?= isset($nama_pasien) ? esc($nama_pasien) : ''; ?> - Golden Physio</title>
    <link rel="stylesheet" href="<?= base_url('css/terapis/lihat_riwayat.css'); ?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
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
                    <div class="header-action">
                        <a href="<?= base_url('terapis/riwayat'); ?>" class="btn-back">Kembali</a>
                    </div>

                    <h1 class="page-title">Riwayat Terapi : <?= isset($nama_pasien) ? esc($nama_pasien) : 'Pasien'; ?></h1>

                    <?php
                    $request = service('request');
                    ?>

                    <form action="<?= base_url('terapis/riwayat/lihat/' . (isset($id_pasien) ? $id_pasien : '')); ?>" method="get" class="filter-form">
                        <div class="filter-group">
                            <label>Tanggal:</label>
                            <input type="date" name="tanggal" value="<?= $request->getGet('tanggal'); ?>">
                        </div>

                        <div class="filter-group">
                            <label>Bulan:</label>
                            <select name="bulan">
                                <option value="">Semua</option>
                                <?php
                                $bulan_sekarang = $request->getGet('bulan');
                                $nama_bulan = [1 => 'Jan', 2 => 'Feb', 3 => 'Mar', 4 => 'Apr', 5 => 'Mei', 6 => 'Jun', 7 => 'Jul', 8 => 'Agu', 9 => 'Sep', 10 => 'Okt', 11 => 'Nov', 12 => 'Des'];
                                foreach ($nama_bulan as $key => $nama) : ?>
                                    <option value="<?= $key; ?>" <?= ($bulan_sekarang == $key) ? 'selected' : ''; ?>><?= $nama; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="filter-group">
                            <label>Tahun:</label>
                            <input type="number" name="tahun" value="<?= $request->getGet('tahun') ?? date('Y'); ?>">
                        </div>

                        <div class="filter-group">
                            <label>Urutkan</label>
                            <select name="sort">
                                <option value="DESC" <?= ($request->getGet('sort') == 'DESC') ? 'selected' : ''; ?>>Terbaru ke Terlama</option>
                                <option value="ASC" <?= ($request->getGet('sort') == 'ASC') ? 'selected' : ''; ?>>Terlama ke Terbaru</option>
                            </select>
                        </div>

                        <div class="filter-actions">
                            <button type="submit" class="btn-filter">Filter</button>
                            <a href="<?= base_url('terapis/riwayat/lihat/' . (isset($id_pasien) ? $id_pasien : '')); ?>" class="btn-reset">Reset</a>
                        </div>
                    </form>

                    <div class="header-action">
                        <a href="<?= base_url('terapis/riwayat/tambah/' . (isset($id_pasien) ? $id_pasien : '')); ?>" class="btn-tambah">Tambah Riwayat</a>
                    </div>

                    <?php if (session()->getFlashdata('success')) : ?>
                        <div class="success">
                            <?= session()->getFlashdata('success'); ?>
                        </div>
                    <?php endif; ?>

                    <div class="table-responsive">
                        <table class="data-table">
                            <thead>
                                <tr>
                                    <th width="50">No</th>
                                    <th>Tanggal Terapi</th>
                                    <th>Jam</th>
                                    <th>Nama Terapis</th>
                                    <th>Keluhan</th>
                                    <th>Riwayat Cedera</th>
                                    <th>Catatan</th>
                                    <th>Tarif Biaya</th>
                                    <th>Status</th>
                                    <th width="150">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($riwayat)) : ?>
                                    <?php
                                    $currentPage = isset($pager) ? $pager->getCurrentPage() : 1;
                                    $perPage = isset($pager) ? $pager->getPerPage() : count($riwayat);
                                    $i = 1 + ($perPage * ($currentPage - 1));

                                    foreach ($riwayat as $r) : ?>
                                        <tr>
                                            <td><?= $i++; ?></td>
                                            <td style="text-align: center;">
                                                <?= date('d-m-Y', strtotime($r['tanggal_terapi'])); ?>
                                            </td>
                                            <td style="text-align: center;">
                                                <?= esc($r['jam_terapi']); ?>
                                            </td>
                                            <td>
                                                <?= esc($r['nama_terapis'] ?? '-'); ?>
                                            </td>
                                            <td><?= esc($r['keluhan']); ?></td>
                                            <td><?= esc($r['riwayat_cedera'] ?: '-'); ?></td>
                                            <td><?= esc($r['catatan'] ?: '-'); ?></td>
                                            <td style="text-align: center;">
                                                Rp <?= number_format($r['tarif'] ?? 0, 0, ',', '.'); ?>
                                            </td>
                                            <td style="text-align: center;">
                                                <?php
                                                $status_class = strtolower($r['status']);
                                                $status_text = $r['status'] ?: 'Selesai';
                                                ?>
                                                <span class="status status-<?= $status_class; ?>">
                                                    <?= esc($status_text); ?>
                                                </span>
                                            </td>
                                            <td>
                                                <div class="action-buttons">
                                                    <a href="<?= base_url('terapis/riwayat/edit/' . $r['id_pemesanan']); ?>" class="btn-edit">Edit</a>
                                                    <a href="<?= base_url('terapis/riwayat/delete/' . $r['id_pemesanan']); ?>" class="btn-delete" onclick="return confirm('Apakah Anda yakin?')">Hapus</a>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else : ?>
                                    <tr>
                                        <td colspan="10" style="text-align: center; padding: 30px; color: #666;">
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