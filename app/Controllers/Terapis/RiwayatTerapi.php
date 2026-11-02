<?php

namespace App\Controllers\Terapis;

use App\Controllers\BaseController;
use App\Models\PemesananFisioterapiModel;
use App\Models\UserModel;
use CodeIgniter\HTTP\RedirectResponse;

class RiwayatTerapi extends BaseController
{
    protected PemesananFisioterapiModel $pemesananModel;
    protected UserModel $userModel;
    protected \App\Models\TerapisModel $terapisModel;

    public function __construct()
    {
        $this->pemesananModel = new PemesananFisioterapiModel();
        $this->userModel = new UserModel();
        $this->terapisModel = new \App\Models\TerapisModel();
    }

    public function index(): string
    {
        $keyword = $this->request->getGet('keyword');

        $builder = $this->userModel->builder();
        $builder->select('id_user, nama_lengkap, username, no_hp');

        if (!empty($keyword)) {
            $builder->groupStart()
                ->like('nama_lengkap', $keyword)
                ->orLike('username', $keyword)
                ->groupEnd();
        }

        $data['riwayat'] = $builder->orderBy('nama_lengkap', 'ASC')->get()->getResultArray();

        return view('terapis/riwayat_terapi', $data);
    }

    public function lihat(int $id_pasien): string
    {
        $pasien = $this->userModel->where('id_user', $id_pasien)->first();

        if (!$pasien) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $nama_pasien = $pasien['nama_lengkap'];
        $request = service('request');

        $tanggal = $request->getGet('tanggal');
        $bulan   = $request->getGet('bulan');
        $tahun   = $request->getGet('tahun');
        $sort    = $request->getGet('sort') ?? 'DESC';

        $this->pemesananModel->select('pemesanan.*, terapis.nama_lengkap AS nama_terapis');
        $this->pemesananModel->join('terapis', 'terapis.id_terapis = pemesanan.id_terapis', 'left');
        $this->pemesananModel->where('pemesanan.id_user', $id_pasien);

        if (!empty($tanggal)) {
            $this->pemesananModel->where('pemesanan.tanggal_terapi', $tanggal);
        }
        if (!empty($bulan)) {
            $this->pemesananModel->where('MONTH(pemesanan.tanggal_terapi)', $bulan);
        }

        $filterTahun = !empty($tahun) ? $tahun : date('Y');
        $this->pemesananModel->where('YEAR(pemesanan.tanggal_terapi)', $filterTahun);

        $riwayat_data = $this->pemesananModel
            ->orderBy('tanggal_terapi', $sort)
            ->orderBy('jam_terapi', $sort)
            ->findAll();

        $data = [
            'nama_pasien' => $nama_pasien,
            'id_pasien'   => $id_pasien,
            'riwayat'     => $riwayat_data
        ];

        return view('terapis/lihat_riwayat', $data);
    }

    public function tambah(int $id_user)
    {
        $pasien = $this->pemesananModel
            ->where('id_user', $id_user)
            ->orderBy('id_pemesanan', 'DESC')
            ->first();

        if (!$pasien) {
            $userMaster = $this->userModel->find($id_user);

            if (!$userMaster) {
                return redirect()->to('terapis/riwayat')->with('error', ['Data acuan pasien tidak ditemukan.']);
            }

            $data['pasien'] = [
                'id_user'      => $userMaster['id_user'],
                'nama_lengkap' => $userMaster['nama_lengkap'],
                'no_hp'        => $userMaster['no_hp'] ?? '-',
                'alamat'       => $userMaster['alamat'] ?? '-'
            ];
        } else {
            $data['pasien'] = [
                'id_user'      => $pasien['id_user'],
                'nama_lengkap' => $pasien['nama'] ?? '-',
                'no_hp'        => $pasien['no_hp'] ?? '-',
                'alamat'       => $pasien['alamat'] ?? '-'
            ];
        }

        $data['list_terapis'] = $this->terapisModel->findAll();

        return view('terapis/tambah_riwayat', $data);
    }

    public function simpan(): RedirectResponse
    {
        $rules = [
            'tanggal_terapi' => 'required|valid_date',
            'jam_terapi'     => 'required',
            'keluhan'        => 'required',
            'id_terapis'     => 'required|numeric',
            'tarif'          => 'required|numeric'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('error', $this->validator->getErrors());
        }

        $insertData = [
            'id_user'        => $this->request->getPost('id_user'),
            'nama'           => $this->request->getPost('nama'),
            'no_hp'          => $this->request->getPost('no_hp'),
            'alamat'         => $this->request->getPost('alamat'),
            'tanggal_terapi' => $this->request->getPost('tanggal_terapi'),
            'jam_terapi'     => $this->request->getPost('jam_terapi'),
            'keluhan'        => $this->request->getPost('keluhan'),
            'riwayat_cedera' => $this->request->getPost('riwayat_cedera'),
            'id_terapis'     => $this->request->getPost('id_terapis'),
            'tarif'          => $this->request->getPost('tarif'),
            'status'         => 'Selesai'
        ];

        $this->pemesananModel->insert($insertData);

        return redirect()->to('terapis/riwayat/lihat/' . $insertData['id_user'])
            ->with('success', 'Riwayat terapi berhasil ditambahkan.');
    }

    public function edit(int $id_pemesanan)
    {
        $riwayat = $this->pemesananModel->find($id_pemesanan);

        if (!$riwayat) {
            return redirect()->to('terapis/riwayat')->with('error', ['Data riwayat terapi tidak ditemukan.']);
        }

        $terapisModel = new \App\Models\TerapisModel();
        $data['list_terapis'] = $terapisModel->findAll();
        $data['detail_riwayat'] = $riwayat;

        return view('terapis/edit_riwayat', $data);
    }

    public function update(int $id_pemesanan): RedirectResponse
    {
        $rules = [
            'tanggal_terapi' => 'required|valid_date',
            'jam_terapi'     => 'required',
            'keluhan'        => 'required',
            'riwayat_cedera' => 'required',
            'catatan'        => 'required',
            'status'         => 'required',
            'id_terapis'     => 'required|numeric',
            'tarif'          => 'required|numeric'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('error', $this->validator->getErrors());
        }

        $currentData = $this->pemesananModel->find($id_pemesanan);

        if (!$currentData) {
            return redirect()->to('terapis/riwayat')->with('error', ['Data gagal diperbarui, rekam medis tidak ditemukan.']);
        }

        $updateData = [
            'tanggal_terapi' => $this->request->getPost('tanggal_terapi'),
            'jam_terapi'     => $this->request->getPost('jam_terapi'),
            'keluhan'        => $this->request->getPost('keluhan'),
            'riwayat_cedera' => $this->request->getPost('riwayat_cedera'),
            'catatan'        => $this->request->getPost('catatan'),
            'status'         => $this->request->getPost('status'),
            'id_terapis'     => $this->request->getPost('id_terapis'),
            'tarif'          => $this->request->getPost('tarif')
        ];

        $this->pemesananModel->update($id_pemesanan, $updateData);

        return redirect()->to('terapis/riwayat/lihat/' . $currentData['id_user'])
            ->with('success', 'Data riwayat terapi berhasil diperbarui.');
    }

    public function delete(int $id_pemesanan): RedirectResponse
    {
        $currentData = $this->pemesananModel->find($id_pemesanan);

        if ($currentData) {
            $id_user = $currentData['id_user'];
            $this->pemesananModel->delete($id_pemesanan);

            return redirect()->to('terapis/riwayat/lihat/' . $id_user)
                ->with('success', 'Data riwayat terapi berhasil dihapus.');
        }

        return redirect()->to('terapis/riwayat')->with('error', ['Gagal menghapus, data tidak ditemukan.']);
    }
}
