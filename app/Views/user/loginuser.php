<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Golden Physio</title>
    <link rel="stylesheet" href="<?= base_url('css/user/login.css'); ?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>

<body>

    <div class="logo">
        <img src="<?= base_url('images/logo.png') ?>" alt="Golden Physio Logo">
    </div>

    <div class="login-box">
        <h2>LOGIN</h2>

        <?php if (session()->getFlashdata('success_registrasi')): ?>
            <div class="success_registrasi">
                <?= esc(session()->getFlashdata('success_registrasi')); ?>
            </div>
        <?php endif; ?>

        <?php if (session()->getFlashdata('error_registrasi')): ?>
            <div class="error_registrasi">
                <?= esc(session()->getFlashdata('error_registrasi')); ?>
            </div>
        <?php endif; ?>

        <form action="<?= base_url('user/login/proses') ?>" method="post">
            <input type="text" name="username" placeholder="username" required>

            <div class="password-container">
                <input type="password" id="password" name="password" placeholder="password" required>
                <span class="toggle-password" onclick="togglePassword()">
                    <i class="fas fa-eye" id="eyeIcon"></i>
                </span>
            </div>

            <div class="link-group">
                <a href="<?= base_url('user/lupapassword') ?>">Lupa password</a>
                <a href="<?= base_url('user/registrasi') ?>">Registrasi</a>
                <a href="<?= base_url('user/beranda') ?>">Kembali ke beranda</a>
            </div>

            <button type="submit">Masuk</button>
        </form>
    </div>

    <script>
        function togglePassword() {
            const passwordField = document.getElementById("password");
            const eyeIcon = document.getElementById("eyeIcon");

            if (passwordField.type === "password") {
                passwordField.type = "text";
                eyeIcon.classList.remove("fa-eye");
                eyeIcon.classList.add("fa-eye-slash");
            } else {
                passwordField.type = "password";
                eyeIcon.classList.remove("fa-eye-slash");
                eyeIcon.classList.add("fa-eye");
            }
        }
    </script>

</body>

</html>