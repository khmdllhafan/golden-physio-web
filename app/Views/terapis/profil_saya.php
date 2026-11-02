<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Saya - Golden Physio</title>
    <link rel="stylesheet" href="<?= base_url('css/terapis/profil_saya.css'); ?>">
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
            $segment2 = $uri->getSegment(2); ?>
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
                <div class="card">
                    <h1 class="page-title">Profil Saya</h1>
                    <?php if (session()->getFlashdata('error')) : ?>
                        <div class="error">
                            <?php foreach (session()->getFlashdata('error') as $error) : ?>
                                <?= esc($error) ?>
                            <?php endforeach ?>
                        </div>
                    <?php endif; ?>
                    <form action="<?= base_url('terapis/update_profil'); ?>" method="post">
                        <?= csrf_field(); ?>

                        <div class="form-row">
                            <div class="form-group">
                                <label>Username</label>
                                <input type="text" name="username" id="username" value="<?= esc($terapis['username'] ?? ''); ?>" readonly required>
                            </div>
                            <div class="form-group">
                                <label>Nama Lengkap</label>
                                <input type="text" value="<?= esc($terapis['nama_lengkap'] ?? ''); ?>" readonly >
                            </div>
                            <div class="form-group">
                                <label>Tanggal Lahir</label>
                                <input type="text" value="<?= $terapis['tanggal_lahir'] ?? ''; ?>" readonly>
                            </div>
                            <div class="form-group">
                                <label>Jenis Kelamin</label>
                                <input type="text" value="<?= $terapis['jenis_kelamin'] ?? ''; ?>" readonly>
                            </div>
                            <div class="form-group">
                                <label>Nomor HP</label>
                                <input type="tel" name="nomor_hp" id="nomor_hp" value="<?= esc($terapis['nomor_hp'] ?? ''); ?>" readonly required>
                            </div>

                            <div class="form-group">
                                <label>Alamat</label>
                                <textarea name="alamat" id="alamat" readonly required><?= esc($terapis['alamat'] ?? ''); ?></textarea>
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
                            <div class="help-text-container">
                                <small>* Kosongkan kedua kolom di atas jika tidak ingin mengganti password Anda.</small>
                            </div>
                            <div id="password-error" class="error" style="display: none; margin-bottom: 20px;">
                                <i class="fas fa-exclamation-circle"></i> Password dan konfirmasi password tidak cocok!
                            </div>
                        </div>
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
        const btnEditTrigger = document.getElementById('btn-edit-trigger');
        const confirmationButtons = document.getElementById('confirmation-buttons');
        const btnBatal = document.getElementById('btn-batal');

        const inputsToEditable = [
            document.getElementById('username'),
            document.getElementById('nomor_hp'),
            document.getElementById('alamat'),
            document.getElementById('password'),
            document.getElementById('confirm_password')
        ];

        const nilaiAwal = {};
        inputsToEditable.forEach(input => {
            nilaiAwal[input.id] = input.value;
        });


        btnEditTrigger.addEventListener('click', function() {
            btnEditTrigger.style.display = 'none';
            confirmationButtons.style.display = 'flex';

            inputsToEditable.forEach(input => {
                input.removeAttribute('readonly');
                if (input.id !== 'alamat') {
                    input.style.backgroundColor = '#ffffff';
                }
            });
        });

        btnBatal.addEventListener('click', function() {
            btnEditTrigger.style.display = 'block';
            confirmationButtons.style.display = 'none';

            inputsToEditable.forEach(input => {
                input.value = nilaiAwal[input.id];
                input.setAttribute('readonly', true);

                if (input.id === 'password' || input.id === 'confirm_password') {
                    input.value = '';
                }
            });

            document.getElementById('password-error').style.display = 'none';
        });

        function togglePassword(inputId, iconId) {
            const passwordInput = document.getElementById(inputId);
            const toggleIcon = document.getElementById(iconId);

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

        document.getElementById('form-profil').addEventListener('submit', function(e) {
            const pwd = document.getElementById('password').value;
            const cfmPwd = document.getElementById('confirm_password').value;
            const errorDiv = document.getElementById('password-error');

            if (pwd !== cfmPwd) {
                e.preventDefault();
                errorDiv.style.display = 'block';
                window.scrollTo(0, errorDiv.offsetTop - 100);
            } else {
                errorDiv.style.display = 'none';
            }
        });
    </script>
</body>

</html>