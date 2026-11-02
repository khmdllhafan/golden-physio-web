<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\PemesananFisioterapiModel;
use App\Models\UserModel;
use App\Models\TerapisModel;

class RiwayatTerapi extends BaseController
{
    protected PemesananFisioterapiModel $pemesananModel;
    protected UserModel $userModel;
    protected TerapisModel $terapisModel;

    public function __construct()
    {
        $this->pemesananModel = new PemesananFisioterapiModel();
        $this->userModel      = new UserModel();
        $this->terapisModel   = new TerapisModel();
    }

    public function index()
    {
        $keyword = $this->request->getGet('keyword');
        $query   = $this->userModel;

        if (!empty($keyword)) {
            $query = $query->groupStart()
                ->like('nama_lengkap', $keyword)
                ->orLike('username', $keyword)
                ->groupEnd();
        }

        $data['riwayat'] = $query->orderBy('nama_lengkap', 'ASC')->findAll();

        return view('admin/riwayat_terapi', $data);
    }

    public function lihat(int $id_pasien)
    {
        $pasien = $this->userModel->find($id_pasien);

        if (!$pasien) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('Pasien tidak ditemukan');
        }

        $request = service('request');
        $tanggal = $request->getGet('tanggal');
        $bulan   = $request->getGet('bulan');
        $tahun   = $request->getGet('tahun') ?? date('Y');
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
        if (!empty($tahun)) {
            $this->pemesananModel->where('YEAR(pemesanan.tanggal_terapi)', $tahun);
        }

        $this->pemesananModel->orderBy('pemesanan.tanggal_terapi', $sort);

        $data = [
            'nama_pasien' => $pasien['nama_lengkap'],
            'id_pasien'   => $id_pasien,
            'riwayat'     => $this->pemesananModel->findAll()
        ];

        return view('admin/lihat_riwayat', $data);
    }

    public function tambah($id_pasien = null)
    {
        if (empty($id_pasien)) {
            return redirect()->to(base_url('admin/riwayat'))->with('error', ['Pasien tidak ditemukan.']);
        }

        $data['pasien']       = $this->userModel->find($id_pasien);
        $data['list_terapis'] = $this->terapisModel->findAll();

        if (!$data['pasien']) {
            return redirect()->to(base_url('admin/riwayat'))->with('error', ['Data pasien tidak valid.']);
        }

        return view('admin/tambah_riwayat', $data);
    }

    public function simpan()
    {
        $rules = [
            'id_user'        => 'required',
            'tanggal_terapi' => 'required',
            'jam_terapi'     => 'required',
            'id_terapis'     => 'required',
            'tarif'          => 'required|numeric',
            'keluhan'        => 'required',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('error', $this->validator->getErrors());
        }

        $id_user = $this->request->getPost('id_user');

        $this->pemesananModel->insert([
            'id_user'        => $id_user,
            'nama'           => $this->request->getPost('nama'),
            'no_hp'          => $this->request->getPost('no_hp'),
            'alamat'         => $this->request->getPost('alamat'),
            'tanggal_terapi' => $this->request->getPost('tanggal_terapi'),
            'jam_terapi'     => $this->request->getPost('jam_terapi'),
            'id_terapis'     => $this->request->getPost('id_terapis'),
            'tarif'          => $this->request->getPost('tarif'),
            'keluhan'        => $this->request->getPost('keluhan'),
            'riwayat_cedera' => $this->request->getPost('riwayat_cedera'),
            'catatan'        => $this->request->getPost('catatan'),
            'status'         => 'Selesai'
        ]);

        return redirect()->to(base_url('admin/riwayat/lihat/' . $id_user))
            ->with('success', 'Riwayat terapi berhasil ditambahkan.');
    }

    public function edit(int $id_pemesanan)
    {
        $riwayat = $this->pemesananModel->find($id_pemesanan);

        if (!$riwayat) {
            return redirect()->to('admin/riwayat')->with('error', ['Data tidak ditemukan.']);
        }

        $data['detail_riwayat'] = $riwayat;
        $data['list_terapis']   = $this->terapisModel->findAll();

        return view('admin/edit_riwayat', $data);
    }

    public function update(int $id_pemesanan)
    {
        $rules = [
            'tanggal_terapi' => 'required',
            'jam_terapi'     => 'required',
            'keluhan'        => 'required',
            'status'         => 'required'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('error', $this->validator->getErrors());
        }

        $riwayatLama = $this->pemesananModel->find($id_pemesanan);
        if (!$riwayatLama) {
            return redirect()->to('admin/riwayat')->with('error', ['Data tidak ditemukan.']);
        }

        $this->pemesananModel->update($id_pemesanan, [
            'tanggal_terapi' => $this->request->getPost('tanggal_terapi'),
            'jam_terapi'     => $this->request->getPost('jam_terapi'),
            'id_terapis'     => $this->request->getPost('id_terapis'),
            'tarif'          => $this->request->getPost('tarif'),
            'keluhan'        => $this->request->getPost('keluhan'),
            'riwayat_cedera' => $this->request->getPost('riwayat_cedera'),
            'catatan'        => $this->request->getPost('catatan'),
            'status'         => $this->request->getPost('status'),
        ]);

        return redirect()->to(base_url('admin/riwayat/lihat/' . $riwayatLama['id_user']))
            ->with('success', 'Riwayat terapi berhasil diperbarui.');
    }

    public function delete(int $id_pemesanan)
    {
        $riwayat = $this->pemesananModel->find($id_pemesanan);
        if ($riwayat) {
            $this->pemesananModel->delete($id_pemesanan);
            return redirect()->to(base_url('admin/riwayat/lihat/' . $riwayat['id_user']))
                ->with('success', 'Data berhasil dihapus.');
        }
        return redirect()->to(base_url('admin/riwayat'))->with('error', ['Data tidak ditemukan.']);
    }
}
