<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pemesanan Masuk - Admin Golden Physio</title>
    <link rel="stylesheet" href="<?= base_url('css/admin/laporan_pemesanan.css'); ?>">
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
                        <h1 class="page-title">Laporan Fisioterapi</h1>

                        <?php if (session()->getFlashdata('success')) : ?>
                            <div class="success"><?= session()->getFlashdata('success'); ?></div>
                        <?php endif; ?>

                        <?php if (session()->getFlashdata('error')) : ?>
                            <div class="error"><?= session()->getFlashdata('error'); ?></div>
                        <?php endif; ?>

                        <form action="<?= base_url('admin/laporan_pemesanan'); ?>" method="get" class="filter-form">
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
                                <input type="number" name="tahun" value="<?= service('request')->getGet('tahun'); ?>" placeholder="Cth: 2026">
                            </div>

                            <div class="filter-actions">
                                <button type="submit" class="btn-filter">Filter</button>
                                <a href="<?= base_url('admin/laporan_pemesanan'); ?>" class="btn-reset">Reset</a>

                                <?php
                                $queryParams = $_GET;
                                $queryString = http_build_query($queryParams);
                                ?>
                                <a href="<?= base_url('admin/laporan_pemesanan/cetakExcel') . '?' . $queryString; ?>" class="btn-cetak">Cetak Excel</a>
                            </div>
                        </form>

                        <table class="data-table">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Lengkap</th>
                                    <th>Username</th>
                                    <th>Nama Terapis</th>
                                    <th>Tanggal</th>
                                    <th>Jam</th>
                                    <th>Status</th> <!-- Kolom Status ditambahkan -->
                                    <th>Tarif Biaya</th>
                                </tr>
                            </thead>

                            <tbody>
                                <?php if (!empty($pemesanan)) :
                                    $no = 1;
                                    $filtered = isset($isFiltered) ? $isFiltered : false;

                                    foreach ($pemesanan as $row) : ?>
                                        <tr>
                                            <td><?= $no++; ?></td>
                                            <td><?= esc($row['nama']); ?></td>
                                            <td><?= esc($row['username'] ?? '-'); ?></td>
                                            <td><?= esc($row['nama_terapis'] ?? '-'); ?></td>
                                            <td style="text-align: center;"><?= date('d-m-Y', strtotime($row['tanggal_terapi'])); ?></td>
                                            <td style="text-align: center;"><?= date('H:i', strtotime($row['jam_terapi'])); ?></td>
                                            <td style="text-align: center;"><?= esc($row['status'] ?? '-'); ?></td> <!-- Menampilkan Status -->
                                            <td style="text-align: right;">Rp <?= number_format($row['tarif'] ?? 0, 0, ',', '.'); ?></td>
                                        </tr>
                                    <?php endforeach; ?>

                                    <!-- Baris Total Biaya -->
                                    <?php if ($filtered) : ?>
                                        <tr style="font-weight: bold; background-color: #f9f9f9;">
                                            <td colspan="7" style="text-align: right;">Total Seluruh Biaya:</td> <!-- Disesuaikan menjadi colspan="7" -->
                                            <td style="text-align: right;">Rp <?= number_format($total_biaya ?? 0, 0, ',', '.'); ?></td>
                                        </tr>
                                    <?php endif; ?>

                                <?php else : ?>
                                    <tr>
                                        <td colspan="8" style="text-align: center; padding: 20px;">Data tidak ada.</td> <!-- Disesuaikan menjadi colspan="8" -->
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