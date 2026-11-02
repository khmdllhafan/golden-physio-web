<?php

/**
 * Mengatasi Peringatan Undefined Variable Intelephense di VS Code
 * Menghindari penanda merah dengan membuat fallback data kosong jika variabel belum terdefinisi
 */
$detail_riwayat = $detail_riwayat ?? [
    'id_user'        => '',
    'id_pemesanan'   => '',
    'nama'           => '',
    'tanggal_terapi' => '',
    'jam_terapi'     => '',
    'keluhan'        => '',
    'riwayat_cedera' => '',
    'catatan'        => '',
    'status'         => '',
    'id_terapis'     => '', // Fallback id_terapis
    'tarif'          => ''
];

$list_terapis = $list_terapis ?? [];
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home Admin - Golden Physio</title>
    <link rel="stylesheet" href="<?= base_url('css/admin/tambah_riwayat.css'); ?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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
                    <h1 class="page-title">Edit Riwayat Terapi</h1>
                    <?php if (session()->getFlashdata('error')) : ?>
                        <div class="error">
                            <?php foreach (session()->getFlashdata('error') as $error) : ?>
                                <?= esc($error) ?><br>
                            <?php endforeach ?>
                        </div>
                    <?php endif; ?>

                    <form action="<?= base_url('admin/riwayat/update/' . $detail_riwayat['id_pemesanan']); ?>" method="POST">
                        <?= csrf_field(); ?>

                        <label>Nama Pasien</label>
                        <input type="text" value="<?= esc($detail_riwayat['nama']); ?>" readonly style="background-color: #e9ecef; cursor: not-allowed;">

                        <!-- FORM PILIHAN NAMA TERAPIS -->
                        <label for="id_terapis">Nama Terapis</label>
                        <select id="id_terapis" name="id_terapis" required>
                            <option value="" disabled>-- Pilih Terapis --</option>
                            <?php
                            $terapis_terpilih = old('id_terapis', $detail_riwayat['id_terapis']);
                            foreach ($list_terapis as $terapis) :
                            ?>
                                <option value="<?= $terapis['id_terapis']; ?>" <?= $terapis_terpilih == $terapis['id_terapis'] ? 'selected' : ''; ?>>
                                    <?= esc($terapis['nama_lengkap']); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>

                        <label for="tanggal_terapi">Tanggal Terapi</label>
                        <input type="date" id="tanggal_terapi" name="tanggal_terapi" value="<?= esc($detail_riwayat['tanggal_terapi']); ?>" required>

                        <label for="jam_terapi">Jam Terapi</label>
                        <select id="jam_terapi" name="jam_terapi" required>
                            <option value="" disabled>-- Pilih Jam Tersedia --</option>
                            <?php
                            $jam_saved = substr($detail_riwayat['jam_terapi'], 0, 5);
                            $jam_terpilih = old('jam_terapi', $jam_saved);
                            $list_jam = ['08:00', '09:00', '10:00', '11:00', '13:00', '14:00', '15:00', '16:00', '17:00', '19:00', '20:00'];
                            foreach ($list_jam as $jam) : ?>
                                <option value="<?= $jam ?>" <?= $jam_terpilih == $jam ? 'selected' : '' ?>>
                                    <?= $jam ?> WIB
                                </option>
                            <?php endforeach; ?>
                        </select>

                        <label for="keluhan">Keluhan</label>
                        <textarea id="keluhan" name="keluhan" rows="4" required><?= esc(old('keluhan', $detail_riwayat['keluhan'])); ?></textarea>

                        <label for="riwayat_cedera">Riwayat Cedera</label>
                        <textarea id="riwayat_cedera" name="riwayat_cedera" rows="3" required><?= esc(old('riwayat_cedera', $detail_riwayat['riwayat_cedera'])); ?></textarea>

                        <label for="catatan">Catatan</label>
                        <textarea id="catatan" name="catatan" rows="3" required><?= esc(old('catatan', $detail_riwayat['catatan'])); ?></textarea>

                        <label for="status">Status Terapi</label>
                        <select id="status" name="status" required>
                            <?php $status_terpilih = old('status', $detail_riwayat['status']); ?>
                            <option value="Pending" <?= $status_terpilih == 'Pending' ? 'selected' : ''; ?>>Pending</option>
                            <option value="Disetujui" <?= $status_terpilih == 'Disetujui' ? 'selected' : ''; ?>>Disetujui</option>
                            <option value="Diproses" <?= $status_terpilih == 'Diproses' ? 'selected' : ''; ?>>Diproses</option>
                            <option value="Selesai" <?= $status_terpilih == 'Selesai' ? 'selected' : ''; ?>>Selesai</option>
                            <option value="Ditolak" <?= $status_terpilih == 'Ditolak' ? 'selected' : ''; ?>>Ditolak</option>
                            <option value="Dibatalkan" <?= $status_terpilih == 'Dibatalkan' ? 'selected' : ''; ?>>Dibatalkan</option>
                        </select>

                        <label for="tarif">Tarif Biaya (Rp)</label>
                        <input type="number" id="tarif" name="tarif" value="<?= esc(old('tarif', $detail_riwayat['tarif'])); ?>" placeholder="Contoh: 150000" required>

                        <div style="text-align: center; margin-top: 20px;">
                            <button type="submit" class="btn-submit">Simpan Perubahan</button>
                            <a href="javascript:history.back()" class="btn-batal">Batal</a>
                        </div>
                    </form>
                </div>
            </div>
        </main>
    </div>

</body>

</html>