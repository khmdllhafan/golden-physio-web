<?php


function hari_indo(int $day_number)

{
    $hari = [
        1 => 'Senin',
        'Selasa',
        'Rabu',
        'Kamis',
        'Jumat',
        'Sabtu',
        'Minggu'

    ];
    return $hari[$day_number];
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Beranda - Golden Physio</title>
    <link rel="stylesheet" href="<?= base_url('css/user/beranda.css'); ?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>

<body>
    <header>
        <div class="logo">
            <img src="<?= base_url('images/logo.png'); ?>" alt="Logo Golden Physio">
            <h1>GOLDEN PHYSIO</h1>
        </div>
        <nav>
            <a href="#home" class="active">HOME</a>
            <a href="#panduan">PANDUAN</a>
            <a href="#tentang-kami">TENTANG KAMI</a>
            <a href="#kontak">KONTAK</a>
            <a href="<?= base_url('user/login'); ?>">LOGIN/DAFTAR</a>
        </nav>
    </header>
    <section class="hero" id="home">
        <h1>Selamat Datang di Golden Physio</h1>
        <p>Layanan Profesional untuk Kesehatan & Mobilitas Anda</p>

        <div class="slider-wrapper">
            <button class="arrow prev" onclick="moveSlide(-1)">&#10094;</button>

            <div class="slider-container">
                <div class="slider" id="slider">
                    <img src="<?= base_url('images/1.jpeg'); ?>" alt="1">
                    <img src="<?= base_url('images/2.jpeg'); ?>" alt="2">
                    <img src="<?= base_url('images/3.jpeg'); ?>" alt="3">
                    <img src="<?= base_url('images/4.jpeg'); ?>" alt="4">
                    <img src="<?= base_url('images/5.jpg'); ?>" alt="5">
                    <img src="<?= base_url('images/6.jpeg'); ?>" alt="6">
                </div>
            </div>

            <button class="arrow next" onclick="moveSlide(1)">&#10095;</button>
            <br>
            <a href="<?= base_url('downloads/golden-physio.apk') ?>" download style="background: linear-gradient(135deg, #00bfff, #0083b0); color: white; padding: 8px 15px; border-radius: 5px; font-weight: bold; text-decoration: none;">
                <i class="fas fa-download"></i> DOWNLOAD APK
            </a>
        </div>
    </section>
    <h2 style="text-align: center;">JADWAL PEMESANAN HARI INI</h2>
    <p style="text-align: center; color: #555; margin-top: -10px; margin-bottom: 20px;">
        <?= hari_indo(date('N')); ?>, <?= date('d F Y'); ?> | Wonopringgo, Kab. Pekalongan
    </p>
    <div style="text-align: center; margin-bottom: 20px;">
        <p><strong>Jam Operasional:</strong> Senin - Jumat (09:00 - 21:00) | Sabtu & Minggu Libur</p>
        <?php
        /** * Memberitahu editor bahwa $status_info berasal dari Controller 
         * agar garis merah hilang 
         */
        /** @var array $status_info */
        ?>
        <span class="status-badge <?= $status_info['class']; ?>">
            Golden Physio Saat Ini: <?= $status_info['status']; ?>
        </span>
    </div>
    <section class="jadwal-section">
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Pasien</th>
                    <th>Nama Terapis</th>
                    <th>Tanggal</th>
                    <th>Jam</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($jadwal_hari_ini)) :
                    $no = 1;
                    foreach ($jadwal_hari_ini as $row) :
                        $status_class = strtolower($row['status']);
                ?>
                        <tr>
                            <td><?= $no++; ?></td>
                            <td><?= esc($row['nama']); ?></td>
                            <td><?= esc($row['nama_terapis'] ?? '-'); ?></td>
                            <td style="text-align: center;"><?= date('d-m-Y', strtotime($row['tanggal_terapi'])); ?></td>
                            <td style="text-align: center;"><?= date('H:i', strtotime($row['jam_terapi'])); ?></td>
                            <td style="text-align: center;">
                                <span class="status status-<?= $status_class; ?>">
                                    <?= esc($row['status']); ?>
                                </span>
                            </td>
                        </tr>
                    <?php endforeach;
                else : ?>
                    <tr>
                        <td colspan="6" style="text-align: center; padding: 30px; color: #666;">
                            Belum ada jadwal hari ini.
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </section>
    <section class="panduan-pemesanan" id="panduan">
        <h2 style="text-align: center; color: darkblue">CARA MELAKUKAN PEMESANAN</h2>
        <div class="panduan-container">
            <div class="panduan-item">
                <div class="nomor">1</div>
                <p>Login ke akun Anda. Jika belum punya, silakan mendaftar terlebih dahulu.</p>
            </div>
            <div class="panduan-item">
                <div class="nomor">2</div>
                <p>Klik sidebar pemesanan fisioterapi</p>
            </div>
            <div class="panduan-item">
                <div class="nomor">3</div>
                <p>Mengisi form pemesanan, lalu klik tombol kirim pemesanan</p>
            </div>
            <div class="panduan-item">
                <div class="nomor">4</div>
                <p>Munggu konfirmasi bisa di cek di halaman jadwal fisioterapi.</p>
            </div>
            <div class="panduan-item">
                <div class="nomor">5</div>
                <p>Setelah pemesanan disetujui masuk ke ruangan terapis sesuai jam yang di pilih</p>
            </div>
        </div>
    </section>
    <section class="tentang-kami" id="tentang-kami">
        <div class="tentang-container">
            <div class="konten-teks">
                <h2>TENTANG KAMI</h2>
                <p><strong>Golden Physio</strong> adalah pusat layanan fisioterapi terpercaya yang berlokasi di Kecamatan Wonopringgo Kabupaten Pekalongan. Kami berdedikasi untuk memberikan layanan kesehatan profesional bagi Anda yang membutuhkan pemulihan mobilitas dan peningkatan kualitas hidup.</p>
                <p>Didukung oleh tim fisioterapis berpengalaman dan fasilitas yang memadai, kami berkomitmen untuk memberikan penanganan yang personal, aman, dan efektif untuk setiap pasien.</p>
            </div>
            <div class="konten-visi-misi">
                <h3>Visi Kami</h3>
                <p>"Menjadi pusat fisioterapi unggulan yang mengedepankan kualitas pelayanan dan kepuasan pasien."</p>
                <h3>Misi Kami</h3>
                <ul>
                    <li>Memberikan layanan fisioterapi berbasis bukti (evidence-based).</li>
                    <li>Menyediakan lingkungan terapi yang nyaman dan ramah.</li>
                    <li>Meningkatkan edukasi kesehatan kepada masyarakat.</li>
                </ul>
            </div>
        </div>
    </section>
    <footer id="kontak">
        <div class="kontak-container">
            <h2>HUBUNGI KAMI</h2>
            <p>Punya pertanyaan? Silakan hubungi kami melalui saluran berikut:</p>
            <div class="info-group">
                <a href="https://maps.app.goo.gl/8udbm9kQzXf4Eio9A" target="_blank" class="info-item-link">
                    <strong><i class="fas fa-location-dot"></i> Alamat</strong>
                    <p>Wonopringgo, Kab. Pekalongan</p>
                </a>
                <a href="https://wa.me/6285327793811" target="_blank" class="info-item-link">
                    <strong><i class="fab fa-whatsapp"></i> WhatsApp</strong>
                    <p>085327793811</p>
                </a>
                <a href="https://instagram.com/golden.physiopekalongan" target="_blank" class="info-item-link">
                    <strong><i class="fab fa-instagram"></i> Instagram</strong>
                    <p>@goldenphysio</p>
                </a>
            </div>
        </div>
        <div class="footer-bottom">
            <p>© 2026 Golden Physio. Semua Hak Dilindungi.</p>
        </div>
    </footer>
</body>

<script>
    window.addEventListener('scroll', function() {
        const header = document.querySelector("header");
        if (header) {
            header.classList.toggle("is-sticky", window.pageYOffset > 50);
        }

        const navLinks = document.querySelectorAll('header nav a');
        const sections = document.querySelectorAll('section, footer');
        let current = '';

        sections.forEach(section => {
            const sectionTop = section.offsetTop;
            if (pageYOffset >= (sectionTop - 150)) {
                current = section.getAttribute('id');
            }
        });

        navLinks.forEach(a => {
            a.classList.remove('active');
            if (current && a.getAttribute('href').includes(current)) {
                a.classList.add('active');
            }
        });
    });

    let currentIndex = 0;
    const slider = document.querySelector('.slider');
    const images = document.querySelectorAll('.slider img');

    function moveSlide(direction) {
        if (!slider || images.length === 0) return;
        currentIndex = (currentIndex + direction + images.length) % images.length;
        slider.style.transform = `translateX(-${currentIndex * 100}%)`;
    }

    if (slider) {
        setInterval(() => moveSlide(1), 3000);
    }
</script>

</html>