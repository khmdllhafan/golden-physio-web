<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Riwayat Terapi - Golden Physio</title>
    <link rel="stylesheet" href="<?= base_url('css/admin/tambah_riwayat.css'); ?>">
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
                    <h1 class="page-title">Tambah Riwayat Terapi : <?= esc($pasien['nama_lengkap'] ?? 'Tidak Diketahui'); ?></h1>
                    <?php if (session()->getFlashdata('error')) : ?>
                        <div class="error">
                            <?php foreach (session()->getFlashdata('error') as $error) : ?>
                                <?= esc($error) ?><br>
                            <?php endforeach ?>
                        </div>
                    <?php endif; ?>

                    <form id="formSimpan" action="<?= base_url('admin/riwayat/simpan'); ?>" method="POST">
                        <?= csrf_field(); ?>

                        <input type="hidden" name="id_user" value="<?= $pasien['id_user'] ?? ''; ?>">
                        <input type="hidden" name="nama" value="<?= $pasien['nama_lengkap'] ?? ''; ?>">
                        <input type="hidden" name="no_hp" value="<?= $pasien['no_hp'] ?? '-'; ?>">
                        <input type="hidden" name="alamat" value="<?= $pasien['alamat'] ?? '-'; ?>">

                        <label for="tanggal_terapi">Tanggal Terapi</label>
                        <input type="date"
                            id="tanggal_terapi"
                            name="tanggal_terapi"
                            value="<?= esc(old('tanggal_terapi', date('Y-m-d'))) ?>"
                            required>

                        <label for="jam_terapi">Jam Terapi</label>
                        <select id="jam_terapi" name="jam_terapi" required>
                            <option value="" disabled <?= empty(old('jam_terapi')) ? 'selected' : '' ?>>-- Pilih Jam Tersedia --</option>
                            <?php
                            $list_jam = ['08:00', '09:00', '10:00', '11:00', '13:00', '14:00', '15:00', '16:00', '17:00', '19:00', '20:00'];
                            foreach ($list_jam as $jam) : ?>
                                <option value="<?= $jam ?>" <?= old('jam_terapi') == $jam ? 'selected' : '' ?>>
                                    <?= $jam ?> WIB
                                </option>
                            <?php endforeach; ?>
                        </select>

                        <!-- TAMBAHAN: Dropdown Pilihan Terapis -->
                        <label for="id_terapis">Nama Terapis</label>
                        <select id="id_terapis" name="id_terapis" required>
                            <option value="" disabled <?= empty(old('id_terapis')) ? 'selected' : '' ?>>-- Pilih Terapis --</option>
                            <?php if (!empty($list_terapis)) : ?>
                                <?php foreach ($list_terapis as $terapis) : ?>
                                    <option value="<?= $terapis['id_terapis']; ?>" <?= old('id_terapis') == $terapis['id_terapis'] ? 'selected' : '' ?>>
                                        <?= esc($terapis['nama_lengkap']); ?>
                                    </option>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </select>

                        <!-- TAMBAHAN: Input Tarif Biaya -->
                        <label for="tarif">Tarif Biaya (Rp)</label>
                        <input type="number"
                            id="tarif"
                            name="tarif"
                            value="<?= esc(old('tarif')) ?>"
                            placeholder="Contoh: 150000"
                            required>

                        <label for="keluhan">Keluhan</label>
                        <textarea id="keluhan"
                            name="keluhan"
                            rows="4"
                            placeholder="Tuliskan keluhan pasien..."
                            required><?= esc(old('keluhan')) ?></textarea>

                        <label for="riwayat_cedera">Riwayat Cedera Sebelumnya</label>
                        <textarea id="riwayat_cedera"
                            name="riwayat_cedera"
                            rows="3"
                            placeholder="Riwayat penyakit atau cedera (opsional)"><?= esc(old('riwayat_cedera')) ?></textarea>

                        <label for="catatan">Catatan</label>
                        <textarea id="catatan"
                            name="catatan"
                            rows="3"
                            placeholder="Catatan penting setelah fisioterapi"><?= esc(old('catatan')) ?></textarea>

                        <div class="form-actions">
                            <button type="button" class="btn-submit" onclick="konfirmasiSimpan()">Simpan Riwayat</button>
                            <button type="button" class="btn-batal" onclick="window.history.back();">Batal</button>
                        </div>
                    </form>
                </div>
            </div>
        </main>
    </div>
    <script>
        function konfirmasiSimpan() {
            const form = document.getElementById('formSimpan');

            if (form.checkValidity()) {
                if (confirm('Apakah Anda yakin ingin menyimpan riwayat terapi ini?')) {
                    form.submit();
                }
            } else {
                form.reportValidity();
            }
        }
    </script>
</body>

</html>