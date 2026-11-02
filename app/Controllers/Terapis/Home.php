<?php

namespace App\Controllers\Terapis;

use App\Controllers\BaseController;

class Home extends BaseController
{
    public function index()
    {
        $pemesananModel = new \App\Models\PemesananFisioterapiModel();
        $hariIni = date('Y-m-d');

        $data['total_jadwal'] = $pemesananModel->where('tanggal_terapi', $hariIni)->countAllResults();
        $data['pasien_selesai'] = $pemesananModel->where('tanggal_terapi', $hariIni)
            ->where('status', 'Selesai')
            ->countAllResults();
        $data['pemesanan_pending'] = $pemesananModel->where('tanggal_terapi', $hariIni)
            ->where('status', 'Pending')
            ->countAllResults();

        $data['lima_pemesanan'] = $pemesananModel->orderBy('id_pemesanan', 'DESC')->limit(5)->findAll();

        return view('terapis/home', $data);
    }
}
