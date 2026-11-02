<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Data Pasien - Golden Physio</title>
    <link rel="stylesheet" href="<?= base_url('css/admin/tambah_pasien.css'); ?>">
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
                    <h1 class="page-title">Tambah Data Pasien</h1>

                    <?php if (session()->getFlashdata('error')) : ?>
                        <div class="error">
                            <?php foreach (session()->getFlashdata('error') as $error) : ?>
                                <?= esc($error) ?>
                            <?php endforeach ?>
                        </div>
                    <?php endif; ?>
                    <form action="<?= base_url('admin/pasien/simpan'); ?>" method="POST">
                        <?= csrf_field(); ?>

                        <div class="form-row">
                            <div class="form-group">
                                <label for="username">Username</label>
                                <input type="text" name="username" id="username" value="<?= old('username'); ?>" placeholder="Masukkan username login" required>
                            </div>

                            <div class="form-group">
                                <label for="password">Password</label>
                                <div class="password-wrapper">
                                    <input type="password" name="password" id="password" placeholder="Masukkan password (minimal 8 karakter)" required>
                                    <i class="fas fa-eye toggle-password" id="eyeIcon"></i>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="nama_lengkap">Nama Lengkap</label>
                                <input type="text" name="nama_lengkap" id="nama_lengkap" value="<?= old('nama_lengkap'); ?>" placeholder="Masukkan nama lengkap pasien" required>
                            </div>

                            <div class="form-group">
                                <label for="tanggal_lahir">Tanggal Lahir</label>
                                <input type="date" name="tanggal_lahir" id="tanggal_lahir" value="<?= old('tanggal_lahir'); ?>" required>
                            </div>

                            <div class="form-group">
                                <label for="jenis_kelamin">Jenis Kelamin</label>
                                <select name="jenis_kelamin" id="jenis_kelamin" class="form-control editable" required>
                                    <option value="">-- Pilih Jenis Kelamin --</option>
                                    <option value="Laki-laki" <?= (old('jenis_kelamin') == 'Laki-laki') ? 'selected' : ''; ?>>Laki-laki</option>
                                    <option value="Perempuan" <?= (old('jenis_kelamin') == 'Perempuan') ? 'selected' : ''; ?>>Perempuan</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="no_hp">Nomor HP / WhatsApp</label>
                                <input type="text" name="no_hp" id="no_hp" value="<?= old('no_hp'); ?>"
                                    placeholder="Contoh: 08XXXXXXXXXX"
                                    pattern="^08[0-9]+$"
                                    minlength="10"
                                    inputmode="numeric"
                                    oninput="this.value = this.value.replace(/[^0-9]/g, '');" required>
                            </div>

                            <div class="form-group">
                                <label for="alamat">Alamat Tinggal</label>
                                <textarea name="alamat" id="alamat" required style="width: 100%; box-sizing: border-box; min-height: 80px;" placeholder="Masukkan alamat lengkap rumah pasien"><?= old('alamat'); ?></textarea>
                            </div>

                            <div class="action-buttons">
                                <button type="button" class="btn-submit" onclick="konfirmasiSimpan()">Simpan</button>
                                <button type="button" class="btn-batal" onclick="window.history.back();">Batal</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </main>
    </div>
    <script>
        const passwordInput = document.getElementById('password');
        const eyeIcon = document.getElementById('eyeIcon');

        eyeIcon.addEventListener('click', function() {
            // Cek tipe input saat ini
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                // Ubah ikon menjadi mata dicoret (fa-eye-slash)
                eyeIcon.classList.remove('fa-eye');
                eyeIcon.classList.add('fa-eye-slash');
            } else {
                passwordInput.type = 'password';
                // Kembalikan ke ikon mata normal
                eyeIcon.classList.remove('fa-eye-slash');
                eyeIcon.classList.add('fa-eye');
            }
        });
    </script>
</body>

</html>