<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1" />
    <title>Pemesanan Fisioterapi - Golden Physio</title>
    <link rel="stylesheet" href="<?= base_url('css/user/pemesananfisioterapi.css'); ?>">
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

        <main class="content" role="main">
            <div class="card">
                <h2 class="title">PEMESANAN FISIOTERAPI</h2>
                <div id="error-no_hp" class="error">
                    Nomor HP harus diawali 08 dan minimal 10 angka.
                </div>

                <?php if (session()->getFlashdata('success')): ?>
                    <div class="success">
                        <?= session()->getFlashdata('success'); ?>
                    </div>
                <?php endif; ?>
                <?php if (session()->getFlashdata('error')): ?>
                    <div class="error">
                        <?= session()->getFlashdata('error'); ?>
                    </div>
                <?php endif; ?>

                <form id="form-pemesanan" action="<?= site_url('user/pemesananfisioterapi/simpan') ?>" method="post" autocomplete="off" novalidate>
                    <?= csrf_field() ?>

                    <label for="nama">Nama</label>
                    <input type="text"
                        id="nama"
                        name="nama"
                        readonly
                        value="<?= esc(old('nama', session()->get('nama_lengkap') ?? session()->get('username') ?? '')) ?>">

                    <label for="no_hp">No Handphone</label>
                    <input type="tel"
                        id="no_hp"
                        name="no_hp"
                        placeholder="08xxxxxxx"
                        value="<?= esc(old('no_hp')) ?>"
                        inputmode="numeric"
                        oninput="this.value = this.value.replace(/[^0-9]/g, '');"
                        required>

                    <label for="alamat">Alamat</label>
                    <input type="text"
                        id="alamat"
                        name="alamat"
                        placeholder="Alamat lengkap"
                        value="<?= esc(old('alamat')) ?>"
                        required>

                    <label for="id_terapis">Pilih Terapis</label>
                    <select id="id_terapis" name="id_terapis" required>
                        <option value="" disabled <?= empty(old('id_terapis')) ? 'selected' : '' ?>>-- Pilih Terapis Tersedia --</option>
                        <?php
                        if (!empty($terapis)) :
                            foreach ($terapis as $t) : ?>
                                <option value="<?= $t['id_terapis'] ?? $t['id']; ?>" <?= old('id_terapis') == ($t['id_terapis'] ?? $t['id']) ? 'selected' : '' ?>>
                                    <?= esc($t['nama'] ?? $t['nama_lengkap']); ?>
                                </option>
                        <?php endforeach;
                        endif; ?>
                    </select>

                    <label for="tanggal_terapi">Tanggal Terapi</label>
                    <input type="date"
                        id="tanggal_terapi"
                        name="tanggal_terapi"
                        value="<?= esc(old('tanggal_terapi')) ?>"
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

                    <label for="keluhan">Keluhan</label>
                    <textarea id="keluhan"
                        name="keluhan"
                        rows="4"
                        placeholder="Tuliskan keluhan Anda"
                        required><?= esc(old('keluhan')) ?></textarea>

                    <label for="riwayat_cedera">Riwayat Cedera Sebelumnya</label>
                    <textarea id="riwayat_cedera"
                        name="riwayat_cedera"
                        rows="3"
                        placeholder="Riwayat penyakit atau cedera (opsional)"><?= esc(old('riwayat_cedera')) ?></textarea>

                    <div class="checkbox-row">
                        <label>
                            <input type="checkbox" id="setuju-check" name="setuju" value="1" <?= old('setuju') ? 'checked' : '' ?> required>
                            Saya menyatakan bahwa data yang saya isi adalah benar dan saya bersedia mengikuti prosedur serta ketentuan layanan fisioterapi.
                        </label>
                    </div>
                    <div class="actions" style="text-align: center;">
                        <button type="submit" id="btn-kirim" class="btn-submit" disabled>Kirim Pemesanan</button>
                    </div>
                </form>
            </div>
        </main>
    </div>
    <script>
        const checkbox = document.getElementById('setuju-check');
        const submitBtn = document.getElementById('btn-kirim');
        const tanggalInput = document.getElementById('tanggal_terapi');
        const jamSelect = document.getElementById('jam_terapi');
        const formPemesanan = document.getElementById('form-pemesanan');
        const noHpInput = document.getElementById('no_hp');
        const errorNoHp = document.getElementById('error-no_hp');

        noHpInput.addEventListener('input', function() {
            this.value = this.value.replace(/[^0-9]/g, '');
            updateSubmitButton();
        });

        function validateNoHp() {
            const val = noHpInput.value;
            const isValid = val.startsWith('08') && val.length >= 10;

            if (val.length > 0 && !isValid) {
                errorNoHp.style.display = 'block';
                noHpInput.style.borderColor = 'red';
                return false;
            } else {
                errorNoHp.style.display = 'none';
                noHpInput.style.borderColor = '';
                return true;
            }
        }

        function updateSubmitButton() {
            const isNoHpValid = validateNoHp();
            if (checkbox.checked && isNoHpValid) {
                submitBtn.disabled = false;
                submitBtn.style.opacity = "1";
                submitBtn.style.cursor = "pointer";
            } else {
                submitBtn.disabled = true;
                submitBtn.style.opacity = "0.6";
                submitBtn.style.cursor = "not-allowed";
            }
        }

        checkbox.addEventListener('change', updateSubmitButton);

        if (formPemesanan) {
            formPemesanan.addEventListener('submit', function() {
                submitBtn.disabled = true;
                submitBtn.innerText = "Mengirim...";
                submitBtn.style.opacity = "0.6";
            });
        }

        tanggalInput.addEventListener('change', function() {
            const tanggal = this.value;
            if (!tanggal) return;

            Array.from(jamSelect.options).forEach(option => {
                if (option.value !== "") {
                    option.disabled = false;
                    option.style.color = "";
                    option.text = option.value + " WIB";
                }
            });

            fetch(`<?= base_url('user/pemesananfisioterapi/cek_ketersediaan'); ?>?tanggal=${tanggal}`)
                .then(response => response.json())
                .then(data => {
                    const jamTerisi = Array.isArray(data) ? data : [];

                    Array.from(jamSelect.options).forEach(option => {
                        if (option.value === "") return;

                        if (jamTerisi.includes(option.value)) {
                            option.disabled = true;
                            option.style.color = "red";
                            option.text = option.value + " WIB (Penuh)";
                        } else {
                            option.disabled = false;
                            option.style.color = "";
                            option.text = option.value + " WIB";
                        }
                    });
                });
        });

        window.onload = function() {
            updateSubmitButton();
            if (tanggalInput.value) tanggalInput.dispatchEvent(new Event('change'));
        };
    </script>
</body>

</html>