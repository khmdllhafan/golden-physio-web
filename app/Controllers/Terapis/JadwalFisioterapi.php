<?php

namespace App\Controllers\Terapis;

use App\Controllers\BaseController;

class JadwalFisioterapi extends BaseController
{
    public function jadwal()
    {
        $db = \Config\Database::connect();

        $tanggal_filter = $this->request->getGet('tanggal');

        if (empty($tanggal_filter)) {
            $tanggal_filter = date('Y-m-d');
        }

        $query = $db->table('pemesanan')
            ->select('pemesanan.*, user.nama_lengkap as nama, terapis.nama_lengkap as nama_terapis')
            ->join('user', 'user.id_user = pemesanan.id_user', 'left')
            ->join('terapis', 'terapis.id_terapis = pemesanan.id_terapis', 'left')
            ->where('pemesanan.tanggal_terapi', $tanggal_filter)
            ->whereNotIn('pemesanan.status', ['Ditolak', 'Dibatalkan'])
            ->orderBy('pemesanan.jam_terapi', 'ASC')
            ->get();

        $data['pemesanan'] = $query->getResultArray();

        $data['tanggal_terpilih'] = $tanggal_filter;

        return view('terapis/jadwal_fisioterapi', $data);
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('terapis/login');
    }
}
