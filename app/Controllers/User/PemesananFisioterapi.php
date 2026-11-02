<?php

namespace App\Controllers\User;

use App\Controllers\BaseController;
use App\Models\PemesananFisioterapiModel;
use App\Models\TerapisModel;

class PemesananFisioterapi extends BaseController
{
    protected PemesananFisioterapiModel $pemesananModel;

    public function __construct()
    {
        $this->pemesananModel = new PemesananFisioterapiModel();
    }

    private function getStatusPenuh(): array
    {
        return ['Pending', 'Disetujui', 'Diproses', 'Selesai'];
    }

    public function index()
    {
        if (!session()->get('id_user')) {
            return redirect()->to(base_url('user/login'))->with('error', 'Silakan login terlebih dahulu.');
        }

        $terapisModel = new TerapisModel();
        $data['terapis'] = $terapisModel->findAll();

        return view('user/pemesananfisioterapi', $data);
    }

    public function cek_ketersediaan()
    {
        $tanggal = $this->request->getGet('tanggal');
        $pemesanan = $this->pemesananModel
            ->where('tanggal_terapi', $tanggal)
            ->whereIn('status', $this->getStatusPenuh())
            ->findAll();

        $jamTerisi = array_map(function ($item) {
            return substr($item['jam_terapi'], 0, 5);
        }, $pemesanan);

        return $this->response->setJSON($jamTerisi);
    }

    public function simpan()
    {
        $rules = [
            'no_hp'          => 'required|numeric|min_length[10]|regex_match[/^08/]',
            'alamat'         => 'required',
            'id_terapis'     => 'required|numeric',
            'tanggal_terapi' => 'required|valid_date',
            'jam_terapi'     => 'required',
            'keluhan'        => 'required'
        ];

        $messages = [
            'no_hp' => [
                'required'    => 'Nomor HP wajib diisi.',
                'numeric'     => 'Nomor HP hanya boleh berisi angka.',
                'min_length'  => 'Nomor HP minimal terdiri dari 10 angka.',
                'regex_match' => 'Nomor HP harus diawali dengan angka 08.'
            ],
            'alamat' => [
                'required' => 'Alamat wajib diisi.'
            ],
            'id_terapis' => [
                'required' => 'Silakan pilih terapis terlebih dahulu.',
                'numeric'  => 'ID Terapis tidak valid.'
            ],
            'tanggal_terapi' => [
                'required'   => 'Tanggal terapi wajib dipilih.',
                'valid_date' => 'Format tanggal tidak valid.'
            ],
            'jam_terapi' => [
                'required' => 'Jam terapi wajib dipilih.'
            ],
            'keluhan' => [
                'required' => 'Keluhan wajib diisi.'
            ]
        ];

        if (!$this->validate($rules, $messages)) {
            return redirect()->back()->withInput()->with('error', implode('<br>', $this->validator->getErrors()));
        }

        $data = [
            'id_user'        => session()->get('id_user'),
            'nama'           => $this->request->getPost('nama'),
            'no_hp'          => $this->request->getPost('no_hp'),
            'alamat'         => $this->request->getPost('alamat'),
            'id_terapis'     => $this->request->getPost('id_terapis'),
            'tanggal_terapi' => $this->request->getPost('tanggal_terapi'),
            'jam_terapi'     => $this->request->getPost('jam_terapi'),
            'keluhan'        => $this->request->getPost('keluhan'),
            'riwayat_cedera' => $this->request->getPost('riwayat_cedera'),
            'status'         => 'Pending'
        ];

        // Memastikan tidak ada double booking pada status yang aktif
        $isExist = $this->pemesananModel
            ->where('tanggal_terapi', $data['tanggal_terapi'])
            ->where('jam_terapi', $data['jam_terapi'])
            ->whereIn('status', $this->getStatusPenuh())
            ->countAllResults();

        if ($isExist > 0) {
            return redirect()->back()->withInput()->with('error', 'Maaf, jadwal tersebut sudah dipesan oleh pasien lain.');
        }

        if ($this->pemesananModel->insert($data)) {
            return redirect()->to(base_url('user/riwayatterapi'))->with('success', 'Pemesanan berhasil dikirim!');
        } else {
            return redirect()->back()->withInput()->with('error', 'Gagal menyimpan data ke database.');
        }
    }
}
