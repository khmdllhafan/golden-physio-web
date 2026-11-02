<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\PemesananFisioterapiModel;

class LaporanPemesanan extends BaseController
{
    public function index()
    {
        $model = new PemesananFisioterapiModel();

        $query = $model->select('pemesanan.*, user.username, terapis.nama_lengkap AS nama_terapis')
            ->join('user', 'user.id_user = pemesanan.id_user', 'left')
            ->join('terapis', 'terapis.id_terapis = pemesanan.id_terapis', 'left')
            ->where('pemesanan.status', 'Selesai');

        $tanggal = $this->request->getGet('tanggal');
        $bulan   = $this->request->getGet('bulan');
        $tahun   = $this->request->getGet('tahun');

        if (!empty($tanggal)) {
            $query->where('pemesanan.tanggal_terapi', $tanggal);
        }

        if (!empty($bulan) && $bulan !== 'Semua') {
            $query->where('MONTH(pemesanan.tanggal_terapi)', $bulan);
        }

        if (!empty($tahun) && $tahun !== 'Semua') {
            $query->where('YEAR(pemesanan.tanggal_terapi)', $tahun);
        }

        $data['pemesanan'] = $query
            ->orderBy('pemesanan.tanggal_terapi', 'DESC')
            ->findAll();

        $totalBiaya = 0;

        foreach ($data['pemesanan'] as $row) {
            $totalBiaya += (float) ($row['tarif'] ?? 0);
        }

        $data['total_biaya'] = $totalBiaya;

        return view('admin/laporan_pemesanan', $data);
    }

    public function cetakExcel()
    {
        $model = new PemesananFisioterapiModel();

        $tanggal = $this->request->getGet('tanggal');
        $bulan   = $this->request->getGet('bulan');
        $tahun   = $this->request->getGet('tahun');

        $query = $model->select('pemesanan.*, user.username, terapis.nama_lengkap AS nama_terapis')
            ->join('user', 'user.id_user = pemesanan.id_user', 'left')
            ->join('terapis', 'terapis.id_terapis = pemesanan.id_terapis', 'left')
            ->where('pemesanan.status', 'Selesai');

        if (!empty($tanggal)) {
            $query->where('pemesanan.tanggal_terapi', $tanggal);
        }

        if (!empty($bulan) && $bulan !== 'Semua') {
            $query->where('MONTH(pemesanan.tanggal_terapi)', $bulan);
        }

        if (!empty($tahun) && $tahun !== 'Semua') {
            $query->where('YEAR(pemesanan.tanggal_terapi)', $tahun);
        }

        $data['pemesanan'] = $query->findAll();

        $totalBiaya = 0;

        foreach ($data['pemesanan'] as $row) {
            $totalBiaya += (float) ($row['tarif'] ?? 0);
        }

        $data['total_biaya'] = $totalBiaya;

        header("Content-Type: application/vnd.ms-excel");
        header("Content-Disposition: attachment; filename=Laporan_Pemesanan_" . date('Y-m-d') . ".xls");

        echo view('admin/laporan_excel', $data);
        exit();
    }
}
