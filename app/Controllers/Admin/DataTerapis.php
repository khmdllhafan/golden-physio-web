<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\TerapisModel;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

class DataTerapis extends BaseController
{
    protected TerapisModel $terapisModel;

    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);

        $this->terapisModel = new TerapisModel();

        if ($this->session()->get('role') !== 'Super Admin') {
            header('Location: ' . base_url('admin/home'));
            exit;
        }
    }

    private function session()
    {
        return \Config\Services::session();
    }

    public function index()
    {
        $keyword = $this->request->getGet('keyword');
        $builder = $this->terapisModel;

        if (!empty($keyword)) {
            $builder->groupStart()
                ->like('nama_lengkap', $keyword)
                ->orLike('username', $keyword)
                ->groupEnd();
        }

        return view('admin/data_terapis', ['terapis' => $builder->findAll()]);
    }

    public function tambah()
    {
        return view('admin/tambah_terapis');
    }

    public function simpan()
    {
        $rules = [
            'username'      => 'required|alpha_dash|is_unique[terapis.username]',
            'password'      => 'required|min_length[8]',
            'nama_lengkap'  => 'required|min_length[3]',
            'tanggal_lahir' => 'required|valid_date',
            'jenis_kelamin' => 'required|in_list[Laki-laki,Perempuan]',
            'nomor_hp'      => 'required|numeric|min_length[10]',
            'alamat'        => 'required'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('error', $this->validator->listErrors());
        }

        $this->terapisModel->save([
            'username'      => $this->request->getPost('username'),
            'password'      => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
            'nama_lengkap'  => $this->request->getPost('nama_lengkap'),
            'tanggal_lahir' => $this->request->getPost('tanggal_lahir'),
            'jenis_kelamin' => $this->request->getPost('jenis_kelamin'),
            'nomor_hp'      => $this->request->getPost('nomor_hp'),
            'alamat'        => $this->request->getPost('alamat'),
            'status'        => 'Aktif'
        ]);

        return redirect()->to(base_url('admin/terapis'))->with('success', 'Data terapis berhasil ditambahkan.');
    }

    public function detail(int $id)
    {
        $data = $this->terapisModel->find($id);

        if (!$data) {
            return redirect()->to(base_url('admin/terapis'))->with('error', 'Data tidak ditemukan.');
        }

        return view('admin/detail_terapis', ['terapis' => $data]);
    }

    public function update(int $id)
    {
        $terapisData = $this->terapisModel->find($id);

        if (!$terapisData) {
            return redirect()->to(base_url('admin/terapis'))->with('error', 'Data tidak ditemukan.');
        }

        $usernameRule = 'required|alpha_dash';

        if ($this->request->getPost('username') != $terapisData['username']) {
            $usernameRule .= '|is_unique[terapis.username]';
        }

        if (
            !$this->validate([
                'username' => $usernameRule,
                'nama_lengkap' => 'required|min_length[3]',
                'nomor_hp' => 'required|numeric|min_length[10]'
            ])
        ) {
            return redirect()->back()->withInput()->with('error', $this->validator->listErrors());
        }

        $updateData = [
            'id_terapis'    => $id,
            'username'      => $this->request->getPost('username'),
            'nama_lengkap'  => $this->request->getPost('nama_lengkap'),
            'tanggal_lahir' => $this->request->getPost('tanggal_lahir'),
            'jenis_kelamin' => $this->request->getPost('jenis_kelamin'),
            'nomor_hp'      => $this->request->getPost('nomor_hp'),
            'alamat'        => $this->request->getPost('alamat')
        ];

        if ($password = $this->request->getPost('password')) {
            $updateData['password'] = password_hash($password, PASSWORD_DEFAULT);
        }

        $this->terapisModel->save($updateData);

        return redirect()->to(base_url('admin/terapis'))->with('success', 'Data berhasil diperbarui.');
    }

    public function hapus(int $id)
    {
        if ($this->terapisModel->find($id)) {
            $this->terapisModel->delete($id);

            return redirect()->to(base_url('admin/terapis'))->with('success', 'Data berhasil dihapus.');
        }

        return redirect()->to(base_url('admin/terapis'))->with('error', 'Data tidak ditemukan.');
    }
}
