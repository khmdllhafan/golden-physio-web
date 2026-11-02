<?php

/** @var array $terapis */
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Terapis - Golden Physio</title>
    <link rel="stylesheet" href="<?= base_url('css/admin/detail_terapis.css'); ?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
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
            <form action="<?= base_url('admin/terapis/update/' . $terapis['id_terapis']); ?>" method="POST">
                <?= csrf_field(); ?>
                <div class="card">
                    <div class="header-action">
                        <a href="<?= base_url('admin/terapis'); ?>" class="btn-back">
                            Kembali
                        </a>
                    </div>
                    <div class="profile-header">
                        <h2>Data Terapis</h2>
                    </div>
                    <?php if (session()->getFlashdata('success')) : ?>
                        <div class="success">
                            <?= session()->getFlashdata('success'); ?>
                        </div>
                    <?php endif; ?>

                    <?php if (session()->getFlashdata('error')) : ?>
                        <div class="error">
                            <?php if (is_array(session()->getFlashdata('error'))) : ?>
                                <?php foreach (session()->getFlashdata('error') as $err) : ?>
                                    <p><?= esc($err); ?></p>
                                <?php endforeach; ?>
                            <?php else : ?>
                                <?= session()->getFlashdata('error'); ?>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>
                    <div class="form-row">
                        <div class="form-group">
                            <label>Username</label>
                            <input type="text" name="username" value="<?= esc($terapis['username']); ?>" class="form-control editable" disabled>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label>Nama Lengkap</label>
                            <input type="text" name="nama_lengkap" value="<?= esc($terapis['nama_lengkap']); ?>" class="form-control editable" disabled>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label>Tanggal Lahir</label>
                            <input type="date" name="tanggal_lahir" value="<?= esc($terapis['tanggal_lahir']); ?>" class="form-control editable" disabled>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label>Jenis Kelamin</label>
                            <select name="jenis_kelamin" class="form-control editable" disabled>
                                <option value="Laki-laki" <?= ($terapis['jenis_kelamin'] == 'Laki-laki') ? 'selected' : ''; ?>>Laki-laki</option>
                                <option value="Perempuan" <?= ($terapis['jenis_kelamin'] == 'Perempuan') ? 'selected' : ''; ?>>Perempuan</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label>Nomor HP</label>
                            <input type="text" name="nomor_hp" id="no_hp" value="<?= esc($terapis['nomor_hp']); ?>" class="form-control editable" disabled>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label>Alamat</label>
                            <textarea name="alamat" class="form-control editable" disabled><?= esc($terapis['alamat']); ?></textarea>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group input-group-password">
                            <label>Password Baru</label>
                            <div class="password-wrapper">
                                <input type="password" name="password" id="password" class="form-control editable" placeholder="Masukkan password baru" disabled>
                                <i class="fas fa-eye toggle-password" id="eye-password" onclick="togglePassword('password', 'eye-password')"></i>
                            </div>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group input-group-password">
                            <label>Konfirmasi Password Baru</label>
                            <div class="password-wrapper">
                                <input type="password" name="confirm_password" id="confirm_password" class="form-control editable" placeholder="Ulangi password baru" disabled>
                                <i class="fas fa-eye toggle-password" id="eye-confirm" onclick="togglePassword('confirm_password', 'eye-confirm')"></i>
                            </div>
                        </div>
                    </div>
                    <div id="passwordError" class="error">
                        Password tidak sama!
                    </div>

                    <div class="help-text-container">
                        <small>* Kosongkan jika tidak ingin mengganti password.</small>
                    </div>

                    <div id="errorContainer" class="error" style="display: none;"></div>

                    <div class="form-actions">
                        <button type="button" id="btnEditTrigger" class="btn-submit">Edit Profil</button>

                        <button type="submit" id="btnSimpan" class="btn-submit" style="display: none;">Simpan Perubahan</button>
                        <button type="button" id="btnBatal" class="btn-batal" style="display: none;">Batal</button>
                    </div>
                </div>
            </form>
        </main>
    </div>

    <script>
        function togglePassword(inputId, eyeId) {
            const input = document.getElementById(inputId);
            const eyeIcon = document.getElementById(eyeId);

            if (input.type === "password") {
                input.type = "text";
                eyeIcon.classList.remove('fa-eye');
                eyeIcon.classList.add('fa-eye-slash');
            } else {
                input.type = "password";
                eyeIcon.classList.remove('fa-eye-slash');
                eyeIcon.classList.add('fa-eye');
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            const btnEditTrigger = document.getElementById('btnEditTrigger');
            const btnSimpan = document.getElementById('btnSimpan');
            const btnBatal = document.getElementById('btnBatal');
            const inputs = document.querySelectorAll('.editable');
            const passInput = document.getElementById('password');
            const confirmInput = document.getElementById('confirm_password');
            const hpInput = document.getElementById('no_hp');
            const form = document.querySelector('form');
            const errorContainer = document.getElementById('errorContainer');
            const passwordErrorStatic = document.getElementById('passwordError');

            if (passwordErrorStatic) passwordErrorStatic.style.display = 'none';

            // --- LOGIKA TOMBOL EDIT ---
            btnEditTrigger.addEventListener('click', function() {
                inputs.forEach(input => input.removeAttribute('disabled'));
                btnEditTrigger.style.display = 'none';
                btnSimpan.style.display = 'inline-block';
                btnBatal.style.display = 'inline-block';
            });

            // --- FILTER ANGKA NOMOR HP ---
            if (hpInput) {
                hpInput.addEventListener('input', function() {
                    this.value = this.value.replace(/[^0-9]/g, '');
                });
            }

            // --- VALIDASI SUBMIT ---
            form.addEventListener('submit', function(e) {
                let errors = [];
                errorContainer.innerHTML = "";
                errorContainer.style.display = 'none';

                // 1. Validasi Nomor HP
                if (hpInput && !hpInput.hasAttribute('disabled')) {
                    const hpValue = hpInput.value;
                    if (hpValue !== "") {
                        if (!hpValue.startsWith('08')) {
                            errors.push("Nomor HP harus diawali dengan 08!");
                        } else if (hpValue.length < 10) {
                            errors.push("Nomor HP minimal harus 10 karakter!");
                        }
                    }
                }

                // 2. Validasi Password
                if (passInput.value !== "") {
                    if (passInput.value.length < 8) {
                        errors.push("Password minimal harus 8 karakter!");
                    } else if (passInput.value !== confirmInput.value) {
                        errors.push("Password dan konfirmasi password tidak cocok!");
                    }
                }

                // --- EKSEKUSI TAMPILAN ERROR ---
                if (errors.length > 0) {
                    e.preventDefault();

                    errorContainer.className = "error";
                    errorContainer.style.display = "block";

                    errorContainer.innerHTML = `
                        <i class="fas fa-exclamation-circle"></i> 
                        <span>${errors.join(" ")}</span>
                    `;

                    errorContainer.scrollIntoView({
                        behavior: 'smooth',
                        block: 'center'
                    });
                }
            });

            // Reset saat Batal
            btnBatal.addEventListener('click', function() {
                errorContainer.style.display = 'none';
                errorContainer.innerHTML = "";
                inputs.forEach(input => {
                    input.setAttribute('disabled', 'true');
                    input.style.borderColor = '';
                });
                btnEditTrigger.style.display = 'inline-block';
                btnSimpan.style.display = 'none';
                btnBatal.style.display = 'none';
            });
        });
    </script>
</body>

</html>