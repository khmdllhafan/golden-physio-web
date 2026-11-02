<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\UserModel;

class DataPasien extends BaseController
{
    protected UserModel $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    private function isAuthorized()
    {
        $role = session()->get('role');
        return ($role === 'Admin' || $role === 'Super Admin');
    }

    public function index()
    {
        if (!$this->isAuthorized()) {
            return redirect()->to(base_url('admin/home'))->with('error', 'Akses ditolak.');
        }

        $keyword = $this->request->getGet('keyword');

        if (!empty($keyword)) {
            $data['user'] = $this->userModel->groupStart()
                ->like('nama_lengkap', $keyword)
                ->orLike('username', $keyword)
                ->groupEnd()
                ->findAll();
        } else {
            $data['user'] = $this->userModel->findAll();
        }

        return view('admin/data_pasien', $data);
    }

    public function tambah()
    {
        if (!$this->isAuthorized()) {
            return redirect()->to(base_url('admin/pasien'))->with('error', 'Akses ditolak.');
        }

        return view('admin/tambah_pasien');
    }

    public function simpan()
    {
        if (!$this->isAuthorized()) {
            return redirect()->to(base_url('admin/pasien'))->with('error', 'Akses ditolak.');
        }

        $rules = [
            'username'      => 'required|is_unique[user.username]|min_length[4]',
            'password'      => 'required|min_length[6]',
            'nama_lengkap'  => 'required',
            'no_hp'         => 'required|numeric|min_length[10]|regex_match[/^08[0-9]+$/]',
            'jenis_kelamin' => 'required',
            'tanggal_lahir' => 'required',
            'alamat'        => 'required'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('error', $this->validator->getErrors());
        }

        $this->userModel->insert([
            'username'      => $this->request->getPost('username'),
            'password'      => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
            'nama_lengkap'  => $this->request->getPost('nama_lengkap'),
            'tanggal_lahir' => $this->request->getPost('tanggal_lahir'),
            'jenis_kelamin' => $this->request->getPost('jenis_kelamin'),
            'alamat'        => $this->request->getPost('alamat'),
            'no_hp'         => $this->request->getPost('no_hp'),
        ]);

        return redirect()->to('admin/pasien')->with('success', 'Data pasien berhasil ditambahkan!');
    }

    public function detail(int $id)
    {
        if (!$this->isAuthorized()) {
            return redirect()->to(base_url('admin/pasien'))->with('error', 'Akses ditolak.');
        }

        $data['pasien'] = $this->userModel->find($id);

        if (!$data['pasien']) {
            return redirect()->to(base_url('admin/pasien'))->with('error', 'Data tidak ditemukan');
        }

        return view('admin/detail_pasien', $data);
    }

    public function update(int $id)
    {
        if (!$this->isAuthorized()) {
            return redirect()->to(base_url('admin/pasien'))->with('error', 'Akses ditolak.');
        }

        $updateData = [
            'username'      => $this->request->getPost('username'),
            'nama_lengkap'  => $this->request->getPost('nama_lengkap'),
            'tanggal_lahir' => $this->request->getPost('tanggal_lahir'),
            'jenis_kelamin' => $this->request->getPost('jenis_kelamin'),
            'no_hp'         => $this->request->getPost('no_hp'),
            'alamat'        => $this->request->getPost('alamat'),
        ];

        $password = $this->request->getPost('password');
        $confirm = $this->request->getPost('confirm_password');

        if (!empty($password)) {
            if ($password !== $confirm) {
                return redirect()->back()->with('error', ['Konfirmasi password tidak cocok.']);
            }

            $updateData['password'] = password_hash($password, PASSWORD_DEFAULT);
        }

        if ($this->userModel->update($id, $updateData)) {
            return redirect()->to(base_url('admin/detailpasien/' . $id))
                ->with('success', 'Data pasien berhasil diperbarui.');
        }

        return redirect()->back()->with('error', ['Gagal memperbarui data.']);
    }

    public function hapus(int $id_user)
    {
        if (!$this->isAuthorized()) {
            return redirect()->to(base_url('admin/pasien'))->with('error', 'Akses ditolak.');
        }

        $user = $this->userModel->find($id_user);

        if ($user) {
            $this->userModel->delete($id_user);

            return redirect()->to(base_url('admin/pasien'))
                ->with('success', 'Data pasien berhasil dihapus.');
        }

        return redirect()->to(base_url('admin/pasien'))
            ->with('error', 'Data pasien tidak ditemukan.');
    }
}
