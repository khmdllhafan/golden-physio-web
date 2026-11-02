<?php
// Mengatur header agar file diunduh sebagai .xls (Excel)
header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=Laporan_Pemesanan_Fisioterapi_" . date('d-m-Y_His') . ".xls");
header("Pragma: no-cache");
header("Expires: 0");
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Laporan Pemesanan</title>
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
        }

        th {
            background-color: #f2f2f2;
            border: 1px solid #000;
            font-weight: bold;
            text-align: center;
        }

        td {
            border: 1px solid #000;
            text-align: left;
            padding: 5px;
        }
    </style>
</head>

<body>

    <h2 style="text-align: center;">Laporan Fisioterapi - Golden Physio</h2>
    <p>Tanggal Cetak : <?= date('d-m-Y H:i:s'); ?></p>

    <table>
        <thead>
            <tr>
                <th style="text-align: center;">No</th>
                <th style="text-align: center;">Nama Lengkap</th>
                <th style="text-align: center;">Username</th>
                <th style="text-align: center;">Tanggal Terapi</th>
                <th style="text-align: center;">Jam</th>
                <th style="text-align: center;">Tarif Biaya</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($pemesanan)) :
                $no = 1;
                foreach ($pemesanan as $row) : ?>
                    <tr>
                        <td style="text-align: center;"><?= $no++; ?></td>
                        <td><?= $row['nama']; ?></td>
                        <td><?= $row['username'] ?? '-'; ?></td>
                        <td style="text-align: center;"><?= date('d-m-Y', strtotime($row['tanggal_terapi'])); ?></td>
                        <td style="text-align: center;"><?= date('H:i', strtotime($row['jam_terapi'])); ?></td>
                        <td style="text-align: right;">Rp <?= number_format($row['tarif'] ?? 0, 0, ',', '.'); ?></td>
                    </tr>
                <?php endforeach; ?>

                <!-- Baris Total Biaya pada Excel (Tampil jika difilter) -->
                <?php if (isset($isFiltered) && $isFiltered) : ?>
                    <tr style="font-weight: bold;">
                        <td colspan="5" style="text-align: right;">Total Seluruh Biaya:</td>
                        <td style="text-align: right;">Rp <?= number_format($total_biaya ?? 0, 0, ',', '.'); ?></td>
                    </tr>
                <?php endif; ?>

            <?php else : ?>
                <tr>
                    <td colspan="6" style="text-align: center;">Tidak ada data ditemukan.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

</body>

</html>