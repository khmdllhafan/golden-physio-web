<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Saya - Golden Physio</title>
    <link rel="stylesheet" href="<?= base_url('css/user/profilsaya.css'); ?>">
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
            <div class="profile-card">
                <div class="profile-header">
                    <h2>PROFIL SAYA</h2>
                </div>

                <?php if (session()->getFlashdata('success')): ?>
                    <div class="success">
                        <?= session()->getFlashdata('success'); ?>
                    </div>
                <?php endif; ?>

                <?php if (session()->has('validation')): ?>
                    <div class="error">
                        <?php foreach (session()->getFlashdata('validation')->getErrors() as $error): ?><?= esc($error) ?><?php endforeach; ?>
                    </div>
                <?php endif; ?>

                <?php if (session()->getFlashdata('error')): ?>
                    <div class="error">
                        <?= session()->getFlashdata('error'); ?>
                    </div>
                <?php endif; ?>

                <div id="password-error" class="error" style="display: none; margin-bottom: 20px;"></div>
                <form action="<?= base_url('user/update_profil'); ?>" method="post">
                    <?= csrf_field(); ?>

                    <div class="form-row">
                        <div class="form-group">
                            <label>Username</label>
                            <input type="text" name="username" id="username" value="<?= esc($user['username'] ?? ''); ?>" readonly required>
                        </div>
                        <div class="form-group">
                            <label>Nama Lengkap</label>
                            <input type="text" value="<?= esc($user['nama_lengkap'] ?? ''); ?>" readonly style="background-color: #f5f5f5;">
                        </div>
                        <div class="form-group">
                            <label>Tanggal Lahir</label>
                            <input type="text" value="<?= $user['tanggal_lahir'] ?? ''; ?>" readonly style="background-color: #f5f5f5;">
                        </div>
                        <div class="form-group">
                            <label>Jenis Kelamin</label>
                            <input type="text" value="<?= $user['jenis_kelamin'] ?? ''; ?>" readonly style="background-color: #f5f5f5;">
                        </div>


                        <div class="form-group">
                            <label>Nomor HP</label>
                            <input type="tel" name="no_hp" id="no_hp" value="<?= esc($user['no_hp'] ?? ''); ?>" readonly required>
                        </div>

                        <div class="form-group">
                            <label>Alamat</label>
                            <textarea name="alamat" id="alamat" readonly required style="width: 100%; box-sizing: border-box;"><?= esc($user['alamat'] ?? ''); ?></textarea>
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
                    <div class="form-actions">
                        <button type="button" id="btn-edit-trigger" class="btn-submit">Edit Profil</button>

                        <div id="confirmation-buttons" style="display: none; gap: 15px;">
                            <button type="submit" id="btn-submit" class="btn-submit">Simpan</button>
                            <button type="button" id="btn-batal" class="btn-batal">Batal</button>
                        </div>
                    </div>
                </form>
            </div>
        </main>
    </div>
    <script>
        function togglePassword(inputId, iconId) {
            const passwordInput = document.getElementById(inputId);
            const eyeIcon = document.getElementById(iconId);
            const isPassword = passwordInput.type === 'password';

            passwordInput.type = isPassword ? 'text' : 'password';
            eyeIcon.classList.toggle('fa-eye', !isPassword);
            eyeIcon.classList.toggle('fa-eye-slash', isPassword);
        }

        const btnEditTrigger = document.getElementById('btn-edit-trigger');
        const confirmationButtons = document.getElementById('confirmation-buttons');
        const btnBatal = document.getElementById('btn-batal');
        const btnSubmit = document.getElementById('btn-submit');
        const password = document.getElementById('password');
        const confirmPassword = document.getElementById('confirm_password');

        const errorMsg = document.getElementById('password-error');

        const editableInputs = [
            document.querySelector('input[name="username"]'),
            document.querySelector('input[name="no_hp"]'),
            document.querySelector('textarea[name="alamat"]'),
            password,
            confirmPassword
        ];

        window.onload = function() {
            const phpSuccessMsg = document.querySelector('.success');
            const phpErrorMsg = document.getElementById('php-error');

            if (phpErrorMsg) {
                btnEditTrigger.click();
            }

            if (phpSuccessMsg) {
                setTimeout(() => {
                    phpSuccessMsg.style.transition = "opacity 0.5s ease";
                    phpSuccessMsg.style.opacity = "0";
                    setTimeout(() => phpSuccessMsg.remove(), 500);
                }, 4000);
            }
        };

        btnEditTrigger.addEventListener('click', function() {
            this.style.display = 'none';
            confirmationButtons.style.display = 'flex';
            editableInputs.forEach(input => {
                if (input) {
                    input.removeAttribute('readonly');
                    input.classList.add('is-editing');
                }
            });
        });

        btnBatal.addEventListener('click', function() {
            confirmationButtons.style.display = 'none';
            btnEditTrigger.style.display = 'inline-block';

            if (errorMsg) errorMsg.style.display = 'none';

            const successMsg = document.querySelector('.success');
            if (successMsg) successMsg.style.display = 'none';

            editableInputs.forEach(input => {
                if (input) {
                    input.setAttribute('readonly', true);

                    input.classList.remove('is-editing');
                    input.classList.remove('input-error');

                    input.value = input.defaultValue;
                }
            });
        });

        function validatePassword() {
            const passVal = password.value;
            const confirmVal = confirmPassword.value;

            if (passVal !== "" && confirmVal !== "") {
                if (passVal !== confirmVal) {
                    errorMsg.innerHTML = '<i class="fas fa-exclamation-circle"></i> Password dan konfirmasi password tidak cocok!';
                    errorMsg.style.display = 'block';
                    btnSubmit.disabled = true;
                    btnSubmit.classList.add('btn-disabled');
                    confirmPassword.classList.add('input-error');
                } else {
                    errorMsg.style.display = 'none';
                    btnSubmit.disabled = false;
                    btnSubmit.classList.remove('btn-disabled');
                    confirmPassword.classList.remove('input-error');
                }
            } else {
                errorMsg.style.display = 'none';
                btnSubmit.disabled = false;
                btnSubmit.classList.remove('btn-disabled');
                confirmPassword.classList.remove('input-error');
            }
        }

        password.addEventListener('keyup', validatePassword);
        confirmPassword.addEventListener('keyup', validatePassword);
    </script>
</body>

</html>