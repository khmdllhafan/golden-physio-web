<?php

namespace App\Controllers\User;

use App\Controllers\BaseController;

class Beranda extends BaseController
{
    private function get_status_toko()
    {
        $db = \Config\Database::connect();

        $query = $db->table('pengaturan_toko')
            ->where('key_pengaturan', 'status_toko')
            ->get()
            ->getRowArray();

        $status_dari_db = $query['value_pengaturan'] ?? 'Buka'; // Default 'Buka'

        $mapping = [
            'Buka'      => 'status-buka',
            'Tutup'     => 'status-tutup',
            'Istirahat' => 'status-istirahat',
            'Libur'     => 'status-libur'
        ];

        return [
            'status' => $status_dari_db,
            'class'  => $mapping[$status_dari_db] ?? 'status-buka'
        ];
    }

    public function index()
    {
        $pemesananModel = new \App\Models\PemesananFisioterapiModel();
        $tanggalHariIni = date('Y-m-d');

        $data['jadwal_hari_ini'] = $pemesananModel
            ->select('pemesanan.*, user.nama_lengkap as nama, terapis.nama_lengkap as nama_terapis')
            ->join('user', 'user.id_user = pemesanan.id_user', 'left')
            ->join('terapis', 'terapis.id_terapis = pemesanan.id_terapis', 'left')
            ->where('pemesanan.tanggal_terapi', $tanggalHariIni)
            ->orderBy('pemesanan.jam_terapi', 'ASC')
            ->findAll();

            
        $data['status_info'] = $this->get_status_toko();

        return view('user/beranda', $data);
    }
}
