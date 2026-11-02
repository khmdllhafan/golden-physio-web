<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Saya - Golden Physio</title>
    <link rel="stylesheet" href="<?= base_url('css/admin/profil_saya.css'); ?>">
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
                    <h1 class="page-title">Data Admin</h1>
                    <?php if (session()->getFlashdata('error')) : ?>
                        <div class="error">
                            <?php foreach (session()->getFlashdata('error') as $error) : ?>
                                <?= esc($error) ?>
                            <?php endforeach ?>
                        </div>
                    <?php endif; ?>
                    <form action="<?= base_url('admin/update_profil'); ?>" method="post">
                        <?= csrf_field(); ?>

                        <div class="form-row">
                            <div class="form-group">
                                <label>Username</label>
                                <input type="text" name="username" id="username" value="<?= esc($admin['username'] ?? ''); ?>" readonly required>
                            </div>
                            <div class="form-group">
                                <label>Nama Lengkap</label>
                                <input type="text" value="<?= esc($admin['nama_lengkap'] ?? ''); ?>" readonly>
                            </div>
                            <div class="form-group">
                                <label>Tanggal Lahir</label>
                                <input type="text" value="<?= $admin['tanggal_lahir'] ?? ''; ?>" readonly>
                            </div>
                            <div class="form-group">
                                <label>Jenis Kelamin</label>
                                <input type="text" value="<?= $admin['jenis_kelamin'] ?? ''; ?>" readonly>
                            </div>


                            <div class="form-group">
                                <label>Nomor HP</label>
                                <input type="tel" name="nomor_hp" id="nomor_hp" value="<?= esc($admin['nomor_hp'] ?? ''); ?>" readonly required>
                            </div>

                            <div class="form-group">
                                <label>Alamat</label>
                                <textarea name="alamat" id="alamat" readonly required><?= esc($admin['alamat'] ?? ''); ?></textarea>
                            </div>
                            <div class="form-group">
                                <label>Password Baru</label>
                                <div class="password-wrapper">
                                    <input type="password" name="password" id="password" placeholder="Masukkan password baru" readonly>
                                    <i class="fas fa-eye toggle-password" id="eye-password" onclick="togglePassword('password', 'eye-password')"></i>
                                </div>
                            </div>

                            <div class="form-group">
                                <label>Konfirmasi Password Baru</label>
                                <div class="password-wrapper">
                                    <input type="password" name="confirm_password" id="confirm_password" placeholder="Ulangi password baru" readonly>
                                    <i class="fas fa-eye toggle-password" id="eye-confirm" onclick="togglePassword('confirm_password', 'eye-confirm')"></i>
                                </div>
                            </div>
                        </div>

                        <div class="help-text-container">
                            <small>* Kosongkan kedua kolom di atas jika tidak ingin mengganti password Anda.</small>
                        </div>

                        <div id="password-error" class="error" style="display: none; margin-bottom: 20px;">
                            <i class="fas fa-exclamation-circle"></i> Password dan konfirmasi password tidak cocok!
                        </div>

                        <!-- Tombol Aksi Sekarang di Dalam Card -->
                        <div class="form-actions">
                            <button type="button" id="btn-edit-trigger" class="btn-submit">Edit Profil</button>

                            <div id="confirmation-buttons" style="display: none; gap: 15px;">
                                <button type="submit" id="btn-submit" class="btn-submit">Konfirmasi Perubahan</button>
                                <button type="button" id="btn-batal" class="btn-batal">Batal</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </main>
    </div>
    <script>
        // Ambil elemen tombol dan input
        const btnEditTrigger = document.getElementById('btn-edit-trigger');
        const confirmationButtons = document.getElementById('confirmation-buttons');
        const btnBatal = document.getElementById('btn-batal');

        // Input yang bisa diedit saat tombol edit ditekan
        const inputsToEditable = [
            document.getElementById('username'),
            document.getElementById('nomor_hp'),
            document.getElementById('alamat'),
            document.getElementById('password'),
            document.getElementById('confirm_password')
        ];

        // Simpan nilai awal data database untuk dikembalikan jika batal
        const nilaiAwal = {};
        inputsToEditable.forEach(input => {
            nilaiAwal[input.id] = input.value;
        });

        // 1. EVENT KETIKA TOMBOL 'EDIT PROFIL' DITEKAN
        btnEditTrigger.addEventListener('click', function() {
            // Sembunyikan tombol Edit Profil, Munculkan kelompok tombol (Batal & Konfirmasi)
            btnEditTrigger.style.display = 'none';
            confirmationButtons.style.display = 'flex';

            // Lepas status readonly pada input yang diizinkan edit
            inputsToEditable.forEach(input => {
                input.removeAttribute('readonly');
                // Beri efek visual tipis (opsional) agar pengguna tahu kolom sudah aktif
                if (input.id !== 'alamat') {
                    input.style.backgroundColor = '#ffffff';
                }
            });
        });

        // 2. EVENT KETIKA TOMBOL 'BATAL' DITEKAN
        btnBatal.addEventListener('click', function() {
            // Munculkan kembali tombol Edit Profil, Sembunyikan tombol Batal & Konfirmasi
            btnEditTrigger.style.display = 'block';
            confirmationButtons.style.display = 'none';

            // Kembalikan isi input ke data semula sebelum diubah-ubah, dan kunci kembali (readonly)
            inputsToEditable.forEach(input => {
                input.value = nilaiAwal[input.id];
                input.setAttribute('readonly', true);

                // Reset background style ke default terkunci
                if (input.id === 'password' || input.id === 'confirm_password') {
                    input.value = ''; // Kosongkan kembali password field jika batal
                }
            });

            // Sembunyikan error password jika sebelumnya sempat muncul error sebelum klik batal
            document.getElementById('password-error').style.display = 'none';
        });

        // 3. FUNGSI UNTUK SHOW/HIDE PASSWORD ICON EYE
        function togglePassword(inputId, iconId) {
            const passwordInput = document.getElementById(inputId);
            const toggleIcon = document.getElementById(iconId);

            // Hanya izinkan show/hide jika kolom sedang tidak terkunci (readonly salah)
            if (!passwordInput.hasAttribute('readonly')) {
                if (passwordInput.type === 'password') {
                    passwordInput.type = 'text';
                    toggleIcon.classList.remove('fa-eye');
                    toggleIcon.classList.add('fa-eye-slash');
                } else {
                    passwordInput.type = 'password';
                    toggleIcon.classList.remove('fa-eye-slash');
                    toggleIcon.classList.add('fa-eye');
                }
            }
        }

        // VALIDASI CLIENT-SIDE TAMBAHAN SEBELUM FORM SUBMIT
        document.getElementById('form-profil').addEventListener('submit', function(e) {
            const pwd = document.getElementById('password').value;
            const cfmPwd = document.getElementById('confirm_password').value;
            const errorDiv = document.getElementById('password-error');

            if (pwd !== cfmPwd) {
                e.preventDefault(); // Batalkan pengiriman form ke backend
                errorDiv.style.display = 'block';
                window.scrollTo(0, errorDiv.offsetTop - 100);
            } else {
                errorDiv.style.display = 'none';
            }
        });
    </script>
</body>

</html>