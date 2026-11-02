<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lupa Password Admin</title>
    <link rel="stylesheet" href="<?= base_url('css/admin/login.css'); ?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>

<body>
    <div class="login-box">
        <h2>LUPA PASSWORD</h2>

        <?php if (session()->getFlashdata('error_registrasi')): ?>
            <p class="error_registrasi"><?= session()->getFlashdata('error_registrasi') ?></p>
        <?php endif; ?>

        <?php if (session()->getFlashdata('success_registrasi')): ?>
            <p class="success_registrasi"><?= session()->getFlashdata('success_registrasi') ?></p>
        <?php endif; ?>

        <form action="<?= base_url('admin/proses_lupapassword') ?>" method="post">
            <input type="text" name="username" placeholder="username" title="Wajib di isi" required>
            <input type="text" name="nama_lengkap" placeholder="nama lengkap" title="Wajib di isi" required>
            <div class="input-date">
                <input type="date" name="tanggal_lahir" id="tanggal_lahir" title="Wajib di isi" required>
                <span class="placeholder">tanggal lahir</span>
            </div>
            <div class="password-container">
                <input type="password" name="password" id="password" placeholder="password" required>
                <i class="fas fa-eye toggle-password" id="eye-password"
                    onclick="togglePassword('password', 'eye-password')"></i>
            </div>
            <div class="password-container">
                <input type="password" name="confirm_password" id="confirm_password" placeholder="confirm password" required>
                <i class="fas fa-eye toggle-password" id="eye-confirm"
                    onclick="togglePassword('confirm_password', 'eye-confirm')"></i>
            </div>
            <div class="link-group">
                <a href="<?= base_url('admin/login') ?>">Login</a>
            </div>
            <button type="submit">Simpan</button>
        </form>
    </div>
    <script>
        function togglePassword(inputId, iconId) {
            var input = document.getElementById(inputId);
            var icon = document.getElementById(iconId);

            if (input.type === "password") {
                input.type = "text";
                // Ganti ke icon mata dicoret
                icon.classList.remove("fa-eye");
                icon.classList.add("fa-eye-slash");
            } else {
                input.type = "password";
                // Ganti kembali ke icon mata biasa
                icon.classList.remove("fa-eye-slash");
                icon.classList.add("fa-eye");
            }
        }
    </script>
</body>

</html>