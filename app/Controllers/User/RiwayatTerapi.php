<?php

namespace App\Controllers\User;

use App\Controllers\BaseController;
use App\Models\PemesananFisioterapiModel;

class RiwayatTerapi extends BaseController
{
    protected PemesananFisioterapiModel $pemesananModel;

    public function __construct()
    {
        $this->pemesananModel = new PemesananFisioterapiModel();
    }

    public function index()
    {
        $id_user = session()->get('id_user');

        if (!$id_user) {
            return redirect()->to(base_url('user/login'))->with('error', 'Silakan login terlebih dahulu.');
        }

        $request = service('request');
        $tanggal = $request->getGet('tanggal');
        $bulan   = $request->getGet('bulan');
        $tahun   = $request->getGet('tahun');
        $sort    = $request->getGet('sort') ?? 'DESC';

        $this->pemesananModel->select('pemesanan.*, terapis.nama_lengkap AS nama_terapis');
        $this->pemesananModel->join('terapis', 'terapis.id_terapis = pemesanan.id_terapis', 'left');
        $this->pemesananModel->where('pemesanan.id_user', $id_user);

        if (!empty($tanggal)) {
            $this->pemesananModel->where('tanggal_terapi', $tanggal);
        }

        if (!empty($bulan)) {
            $this->pemesananModel->where('MONTH(tanggal_terapi)', $bulan);
        }

        $filterTahun = !empty($tahun) ? $tahun : date('Y');
        $this->pemesananModel->where('YEAR(tanggal_terapi)', $filterTahun);

        $data['riwayat'] = $this->pemesananModel
            ->orderBy('tanggal_terapi', $sort)
            ->orderBy('jam_terapi', $sort)
            ->paginate(10, 'riwayat');

        $data['pager'] = $this->pemesananModel->pager;

        return view('user/riwayatterapi', $data);
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to(base_url('user/login'))->with('success', 'Berhasil Logout.');
    }
}
