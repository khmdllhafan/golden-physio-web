<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\PemesananFisioterapiModel;

class PemesananMasuk extends BaseController
{
    protected PemesananFisioterapiModel $model;

    public function __construct()
    {
        $this->model = new PemesananFisioterapiModel();

        $role = session()->get('role');
        if (!in_array($role, ['Admin', 'Super Admin'])) {
            header('Location: ' . base_url('admin/home'));
            exit();
        }
    }

    public function index()
    {
        $db = \Config\Database::connect();

        $tanggal_terpilih = $this->request->getGet('tanggal') ?? date('Y-m-d');

        $query = $db->table('pemesanan')
            ->where('tanggal_terapi', $tanggal_terpilih)
            ->get();

        $data['pemesanan']        = $query->getResultArray();
        $data['tanggal_terpilih'] = $tanggal_terpilih;

        return view('admin/pemesanan_masuk', $data);
    }

    public function setuju(int $id)
    {
        if ($this->model->update($id, ['status' => 'Disetujui'])) {
            session()->setFlashdata('success', 'Pemesanan telah disetujui.');
        }
        return redirect()->to(base_url('admin/pemesanan'));
    }

    public function tolak(int $id)
    {
        if ($this->model->update($id, ['status' => 'Ditolak'])) {
            session()->setFlashdata('success', 'Pemesanan telah ditolak.');
        }
        return redirect()->to(base_url('admin/pemesanan'));
    }

    public function proses(int $id)
    {
        if ($this->model->update($id, ['status' => 'Diproses'])) {
            session()->setFlashdata('success', 'Pasien sedang dalam proses terapi.');
        }
        return redirect()->to(base_url('admin/pemesanan'));
    }

    public function batalkan(int $id)
    {
        if ($this->model->update($id, ['status' => 'Dibatalkan'])) {
            session()->setFlashdata('success', 'Pemesanan telah dibatalkan.');
        }
        return redirect()->to(base_url('admin/pemesanan'));
    }

    public function selesai(int $id)
    {
        if ($this->model->update($id, ['status' => 'Selesai'])) {
            return redirect()->to(base_url('admin/pemesanan'))
                ->with('success', 'Layanan telah selesai dan masuk ke riwayat pasien.');
        }

        return redirect()->to(base_url('admin/pemesanan'))
            ->with('error', 'Gagal memperbarui status.');
    }
}
