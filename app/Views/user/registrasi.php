<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrasi User</title>
    <link rel="stylesheet" href="<?= base_url('css/user/login.css'); ?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>

<body>
    <div class="login-box">
        <h2>REGISTRASI</h2>

        <?php if (session()->getFlashdata('error_registrasi')): ?>
            <p class="error"><?= session()->getFlashdata('error_registrasi') ?></p>
        <?php endif; ?>

        <?php if (session()->getFlashdata('success_registrasi')): ?>
            <p class="success"><?= session()->getFlashdata('success_registrasi') ?></p>
        <?php endif; ?>

        <form action="<?= base_url('user/simpan') ?>" method="post">
            <input type="text" name="username" placeholder="username" title="Wajib di isi" required>
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
            <input type="text" name="nama_lengkap" placeholder="nama lengkap" title="Wajib di isi" required>
            <div class="input-date">
                <input type="date" name="tanggal_lahir" id="tanggal_lahir" title="Wajib di isi" required>
                <span class="placeholder">tanggal lahir</span>
            </div>
            <div class="select-wrapper">
                <select name="jenis_kelamin" required>
                    <option value="" disabled selected>jenis kelamin</option>
                    <option value="Laki-laki">Laki-laki</option>
                    <option value="Perempuan">Perempuan</option>
                </select>
            </div>
            <input type="text" name="alamat" placeholder="alamat" title="Wajib di isi" required>
            <input type="text" name="no_hp" placeholder="Nomor Handphone"
                pattern="08[0-9]{8,13}"
                title="Nomor harus diawali 08, hanya angka, dan 10-15 digit total">
            <div class="link-group">
                <a href="<?= base_url('user/login') ?>">Login</a>
            </div>

            <button type="submit">REGISTRASI</button>
        </form>
    </div>
    <script>
        function togglePassword(inputId, iconId) {
            var input = document.getElementById(inputId);
            var icon = document.getElementById(iconId);

            if (input.type === "password") {
                input.type = "text";
                icon.classList.remove("fa-eye");
                icon.classList.add("fa-eye-slash");
            } else {
                input.type = "password";
                icon.classList.remove("fa-eye-slash");
                icon.classList.add("fa-eye");
            }
        }
    </script>
</body>

</html>