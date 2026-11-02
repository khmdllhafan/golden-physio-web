<?php

namespace App\Controllers\User;

use App\Controllers\BaseController;
use App\Models\PemesananFisioterapiModel;

class JadwalFisioterapi extends BaseController
{
    public function index()
    {
        $pemesananModel = new PemesananFisioterapiModel();
        $id_user = session()->get('id_user');

        $tanggal_filter = $this->request->getGet('tanggal');

        if (empty($tanggal_filter)) {
            $tanggal_filter = date('Y-m-d');
        }

        $data['jadwal'] = $pemesananModel
            ->select('pemesanan.*, terapis.nama_lengkap as nama_terapis, user.nama_lengkap as nama')
            ->join('terapis', 'terapis.id_terapis = pemesanan.id_terapis', 'left')
            ->join('user', 'user.id_user = pemesanan.id_user', 'left')
            ->where('pemesanan.id_user', $id_user)
            ->where('pemesanan.tanggal_terapi', $tanggal_filter)
            ->whereNotIn('pemesanan.status', ['Ditolak', 'Dibatalkan'])
            ->findAll();

        $data['tanggal_terpilih'] = $tanggal_filter;

        return view('user/jadwalfisioterapi', $data);
    }
}
