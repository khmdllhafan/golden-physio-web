<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\PemesananFisioterapiModel;

class Home extends BaseController
{
    public function index()
    {
        $db = \Config\Database::connect();
        $tahun = date('Y');
        $hariIni = date('Y-m-d');
        $pemesananModel = new PemesananFisioterapiModel();

        $data_grafik = array_fill(1, 12, 0);
        $query = $db->query("SELECT MONTH(tanggal_terapi) as bulan, COUNT(*) as jumlah 
                             FROM pemesanan 
                             WHERE YEAR(tanggal_terapi) = $tahun 
                             GROUP BY MONTH(tanggal_terapi)");

        foreach ($query->getResult() as $row) {
            $data_grafik[$row->bulan] = (int)$row->jumlah;
        }

        $data['grafik_data'] = array_values($data_grafik);

        $queryTerapis = $db->query("SELECT id_terapis, nama_lengkap FROM terapis");
        $daftarTerapis = $queryTerapis->getResult();

        $terapis_bulanan = [];

        foreach ($daftarTerapis as $terapis) {
            $monthlyData = array_fill(1, 12, 0);

            $queryBulanTerapis = $db->query("SELECT MONTH(tanggal_terapi) as bulan, COUNT(id_pemesanan) as jumlah 
                                             FROM pemesanan 
                                             WHERE id_terapis = {$terapis->id_terapis} 
                                             AND YEAR(tanggal_terapi) = $tahun 
                                             AND status != 'Ditolak' 
                                             GROUP BY MONTH(tanggal_terapi)");

            foreach ($queryBulanTerapis->getResult() as $rowBulan) {
                $monthlyData[$rowBulan->bulan] = (int)$rowBulan->jumlah;
            }

            $terapis_bulanan[] = [
                'nama' => $terapis->nama_lengkap,
                'data' => array_values($monthlyData)
            ];
        }

        $data['terapis_bulanan'] = $terapis_bulanan;

        $pengaturan = $db->table('pengaturan_toko')
            ->where('key_pengaturan', 'status_toko')
            ->get()
            ->getRowArray();

        $data['status_toko'] = $pengaturan ? $pengaturan['value_pengaturan'] : 'Buka';

        $data['total_jadwal'] = $pemesananModel
            ->where('tanggal_terapi', $hariIni)
            ->countAllResults();

        $data['pasien_selesai'] = $pemesananModel
            ->where('tanggal_terapi', $hariIni)
            ->where('status', 'Selesai')
            ->countAllResults();

        $data['pemesanan_pending'] = $pemesananModel
            ->where('status', 'Pending')
            ->countAllResults();

        $data['lima_pemesanan'] = $pemesananModel
            ->select('pemesanan.*, user.username')
            ->join('user', 'user.id_user = pemesanan.id_user', 'left')
            ->orderBy('pemesanan.id_pemesanan', 'DESC')
            ->limit(5)
            ->findAll();

        return view('admin/home', $data);
    }

    public function update_status()
    {
        if (session()->get('role') !== 'Super Admin') {
            return redirect()->back()->with('error', 'Anda tidak memiliki akses.');
        }

        $status_baru = $this->request->getPost('status_toko');

        if ($status_baru) {
            $db = \Config\Database::connect();
            $builder = $db->table('pengaturan_toko');

            $existing = $builder
                ->where('key_pengaturan', 'status_toko')
                ->get()
                ->getRow();

            if ($existing) {
                $builder
                    ->where('key_pengaturan', 'status_toko')
                    ->update([
                        'value_pengaturan' => $status_baru
                    ]);
            } else {
                $builder->insert([
                    'key_pengaturan'   => 'status_toko',
                    'value_pengaturan' => $status_baru
                ]);
            }

            return redirect()->to(base_url('admin/home'))
                ->with('success', 'Status toko berhasil diubah.');
        }

        return redirect()->back()
            ->with('error', 'Gagal mengubah status.');
    }
}
