<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home Admin - Golden Physio</title>
    <link rel="stylesheet" href="<?= base_url('css/admin/home.css'); ?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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
                <?php if (session()->getFlashdata('success')) : ?>
                    <div class="success">
                        <?= session()->getFlashdata('success'); ?>
                    </div>
                <?php endif; ?>

                <?php if (session()->getFlashdata('error')) : ?>
                    <div class="error">
                        <?= session()->getFlashdata('error'); ?>
                    </div>
                <?php endif; ?>
                <div class="welcome">
                    <h2>Selamat Datang, <?= esc(session()->get('username')); ?>!</h2>
                    <p>Anda login sebagai
                        <strong>
                            <?php if (session()->get('role') === 'Super Admin'): ?>
                                <span style="color: navy;">Super Admin</span>
                            <?php else: ?>
                                <span style="color: #00ff00;">Admin</span>
                            <?php endif; ?>
                        </strong>
                    </p>
                </div>
                <?php if (session()->get('role') === 'Super Admin'): ?>
                    <div class="card status-control-card">
                        <h3><i class="fas fa-cog"></i> Kontrol Status Golden Physio</h3>
                        <p>Atur status operasional fisioterapi untuk pelanggan.</p>
                        <form action="<?= base_url('admin/home/update_status'); ?>" method="post" class="status-form">
                            <select name="status_toko" class="form-control">
                                <?php
                                $opsi = ['Buka', 'Istirahat', 'Tutup', 'Libur'];
                                foreach ($opsi as $o): ?>
                                    <option value="<?= $o ?>" <?= (isset($status_toko) && $status_toko == $o) ? 'selected' : '' ?>><?= $o ?></option>
                                <?php endforeach; ?>
                            </select>
                            <button type="submit" class="btn-update">Update Status</button>
                        </form>
                    </div>
                <?php endif; ?>
                <section class="chart-section">
                    <div class="chart-card">
                        <h3 class="section-title">Grafik Pemesanan Bulanan</h3>
                        <canvas id="orderChart" height="100"></canvas>
                    </div>
                </section>

                <!-- BAGIAN GRAFIK TREN PENANGANAN BULANAN TERAPIS DENGAN DROPDOWN -->
                <section class="chart-section">
                    <div class="chart-card">
                        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px; flex-wrap: wrap; gap: 10px;">
                            <h3 class="section-title" style="margin: 0;">Grafik Tren Penanganan Bulanan Terapis</h3>
                            <div>
                                <label for="filterTerapisBulanan" style="font-size: 13px; font-weight: bold; margin-right: 8px;">Pilih Terapis:</label>
                                <select id="filterTerapisBulanan" class="form-control" style="padding: 6px 12px; border-radius: 4px; border: 1px solid #ccc; display: inline-block; width: auto;">
                                    <option value="all">-- Akumulasi Semua Terapis --</option>
                                    <!-- Options terisi otomatis via JS -->
                                </select>
                            </div>
                        </div>
                        <canvas id="terapisBulananChart" height="100"></canvas>
                    </div>
                </section>

                <section class="statistic-section">
                    <h3>BERANDA JADWAL HARI INI - [<?= date('l, d F Y'); ?>]</h3>
                    <div class="card-stats-container">
                        <div class="card-stat">
                            <div class="stat-icon blue">📅</div>
                            <div class="stat-info">
                                <span class="stat-label">Total Jadwal</span>
                                <span class="stat-value"><?= $total_jadwal ?? 0; ?></span>
                            </div>
                        </div>
                        <div class="card-stat">
                            <div class="stat-icon green">✅</div>
                            <div class="stat-info">
                                <span class="stat-label">Pasien Selesai</span>
                                <span class="stat-value"><?= $pasien_selesai ?? 0; ?></span>
                            </div>
                        </div>
                        <div class="card-stat">
                            <div class="stat-icon orange">⏳</div>
                            <div class="stat-info">
                                <span class="stat-label">Pemesanan Pending</span>
                                <span class="stat-value"><?= $pemesanan_pending ?? 0; ?></span>
                            </div>
                        </div>
                    </div>
                </section>

                <section class="table-section">
                    <div class="card table-card">
                        <div class="table-card-header">
                            <h3>5 Pemesanan Terakhir</h3>
                            <a href="<?= base_url('admin/pemesanan'); ?>" class="view-all">View all</a>
                        </div>
                        <table class="data-table">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Pasien</th>
                                    <th>Username</th>
                                    <th style="text-align: center;">Tanggal Terapi</th>
                                    <th style="text-align: center;">Jam Terapi</th>
                                    <th style="text-align: center;">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($lima_pemesanan) && is_array($lima_pemesanan)) : ?>
                                    <?php $no = 1; ?>
                                    <?php foreach ($lima_pemesanan as $pesan) : ?>
                                        <tr>
                                            <td><?= $no++; ?></td>
                                            <td><strong><?= esc($pesan['nama']); ?></strong></td>
                                            <td><?= esc($pesan['username']); ?></td>
                                            <td style="text-align: center;"><?= date('d-m-Y', strtotime($pesan['tanggal_terapi'])); ?></td>
                                            <td style="text-align: center;"><?= date('H:i', strtotime($pesan['jam_terapi'])); ?> WIB</td>
                                            <td style="text-align: center;">
                                                <?php
                                                $status = $pesan['status'];
                                                $class_status = 'status ';
                                                if ($status == 'Pending') {
                                                    $class_status .= 'status-pending';
                                                } elseif ($status == 'Disetujui') {
                                                    $class_status .= 'status-disetujui';
                                                } elseif ($status == 'Diproses') {
                                                    $class_status .= 'status-diproses';
                                                } elseif ($status == 'Ditolak') {
                                                    $class_status .= 'status-ditolak';
                                                } elseif ($status == 'Selesai') {
                                                    $class_status .= 'status-selesai';
                                                } else {
                                                    $class_status .= 'status-pending';
                                                }
                                                ?>
                                                <span class="<?= $class_status; ?>"><?= esc($status); ?></span>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else : ?>
                                    <tr>
                                        <td colspan="7" style="text-align: center; padding: 30px; color: #666;">
                                            Belum ada data riwayat untuk pasien ini.
                                        </td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </section>
            </div>
        </main>
    </div>
    <script>
        // ================= 1. GRAFIK PEMESANAN BULANAN =================
        const ctx = document.getElementById('orderChart').getContext('2d');
        const dataGrafik = <?php echo json_encode($grafik_data ?? []); ?>;

        const orderChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'],
                datasets: [{
                    label: 'Jumlah Pemesanan',
                    data: dataGrafik,
                    borderColor: '#007bff',
                    backgroundColor: 'rgba(0, 123, 255, 0.1)',
                    borderWidth: 3,
                    fill: true,
                    tension: 0.4,
                    pointRadius: 5,
                    pointHoverRadius: 7
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: {
                            display: false
                        }
                    },
                    x: {
                        grid: {
                            display: false
                        }
                    }
                },
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                return ' Jumlah Pemesanan: ' + context.parsed.y + ' pasien';
                            }
                        }
                    }
                }
            }
        });


        // ================= 2. GRAFIK TREN PENANGANAN BULANAN TERAPIS =================
        const dataTerapisBulanan = <?php echo json_encode($terapis_bulanan ?? []); ?>;
        const bulanLabels = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];

        const dropdownTerapisBulanan = document.getElementById('filterTerapisBulanan');

        // Memperbaiki typo iterasi dropdown opsi nama terapis
        dataTerapisBulanan.forEach((terapis, index) => {
            let option = document.createElement('option');
            option.value = index;
            option.text = terapis.nama;
            dropdownTerapisBulanan.appendChild(option);
        });

        // Hitung total akumulasi semua terapis per bulan sebagai default awal ('all')
        let defaultDataAkumulasi = new Array(12).fill(0);
        dataTerapisBulanan.forEach(t => {
            t.data.forEach((val, monthIdx) => {
                defaultDataAkumulasi[monthIdx] += parseInt(val || 0);
            });
        });

        const ctxTerapisBulanan = document.getElementById('terapisBulananChart').getContext('2d');

        const terapisBulananChart = new Chart(ctxTerapisBulanan, {
            type: 'line',
            data: {
                labels: bulanLabels,
                datasets: [{
                    label: 'Total Penanganan Pasien',
                    data: defaultDataAkumulasi,
                    borderColor: '#007bff',
                    backgroundColor: 'rgba(0, 123, 255, 0.1) ',
                    borderWidth: 3,
                    fill: true,
                    tension: 0.3,
                    pointRadius: 4
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true,
                        suggestedMax: 50, // <-- Mengatur batas minimal grafik agar mencapai angka 50
                        grid: {
                            display: false
                        },
                        ticks: {
                            stepSize: 10 // Interval kenaikan angka pada sumbu Y (bisa disesuaikan, misal 5 atau 10)
                        }
                    },
                    x: {
                        grid: {
                            display: false
                        }
                    }
                },
                plugins: {
                    legend: {
                        display: true,
                        position: 'top'
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                return ' Jumlah Ditangani: ' + context.parsed.y + ' pasien';
                            }
                        }
                    }
                }
            }
        });

        // Event listener saat dropdown terapis diubah
        dropdownTerapisBulanan.addEventListener('change', function() {
            const selectedValue = this.value;

            if (selectedValue === 'all') {
                terapisBulananChart.data.datasets[0].label = 'Akumulasi Semua Terapis';
                terapisBulananChart.data.datasets[0].data = defaultDataAkumulasi;
                terapisBulananChart.data.datasets[0].borderColor = '#28a745';
                terapisBulananChart.data.datasets[0].backgroundColor = 'rgba(40, 167, 69, 0.1)';
            } else {
                const idx = parseInt(selectedValue);
                const selectedTerapis = dataTerapisBulanan[idx];

                terapisBulananChart.data.datasets[0].label = 'Penanganan oleh ' + selectedTerapis.nama;
                terapisBulananChart.data.datasets[0].data = selectedTerapis.data;
                terapisBulananChart.data.datasets[0].borderColor = '#007bff';
                terapisBulananChart.data.datasets[0].backgroundColor = 'rgba(0, 123, 255, 0.1)';
            }
            terapisBulananChart.update();
        });
    </script>
</body>

</html>