<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\AdminModel;

class DataAdmin extends BaseController
{
    protected AdminModel $adminModel;

    public function __construct()
    {
        $this->adminModel = new AdminModel();
    }

    public function index()
    {
        $adminModel = new AdminModel();

        $keyword = $this->request->getGet('keyword');

        $builder = $adminModel->where('role', 'Admin');

        if (!empty($keyword)) {
            $builder->groupStart()
                ->like('nama_lengkap', $keyword)
                ->orLike('username', $keyword)
                ->groupEnd();
        }

        $data['admin'] = $builder->findAll();

        return view('admin/data_admin', $data);
    }

    public function tambah()
    {
        if (session()->get('role') !== 'Super Admin') {
            return redirect()->to(base_url('admin/admin'))->with('error', 'Anda tidak memiliki akses untuk menambah admin.');
        }

        return view('admin/tambah_admin');
    }

    public function simpan()
    {
        $rules = [
            'username'      => 'required|alpha_dash|is_unique[admin.username]',
            'password'      => 'required|min_length[8]',
            'nama_lengkap'  => 'required|min_length[3]',
            'tanggal_lahir' => 'required|valid_date',
            'jenis_kelamin' => 'required|in_list[Laki-laki,Perempuan]',
            'no_hp'         => 'required|numeric|min_length[10]|max_length[15]', // DITAMBAHKAN
            'alamat'        => 'required'
        ];

        $messages = [
            'no_hp' => [
                'required'   => 'Nomor HP wajib diisi.',
                'numeric'    => 'Nomor HP harus berupa angka.',
                'min_length' => 'Nomor HP minimal harus 10 karakter.',
                'max_length' => 'Nomor HP maksimal 15 karakter.'
            ]
        ];

        if (session()->get('role') !== 'Super Admin') {
            return redirect()->to(base_url('admin/admin'))->with('error', 'Akses ditolak.');
        }

        if (!$this->validate($rules, $messages)) {
            return redirect()->back()->withInput()->with('error', $this->validator->getErrors());
        }

        $this->adminModel->save([
            'username'      => $this->request->getPost('username'),
            'password'      => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
            'nama_lengkap'  => $this->request->getPost('nama_lengkap'),
            'tanggal_lahir' => $this->request->getPost('tanggal_lahir'),
            'jenis_kelamin' => $this->request->getPost('jenis_kelamin'),
            'nomor_hp'      => $this->request->getPost('no_hp'),
            'alamat'        => $this->request->getPost('alamat'),
            'status'        => 'Aktif'
        ]);

        return redirect()->to(base_url('admin/admin'))->with('success', 'Data admin berhasil ditambahkan.');
    }

    public function detail(int $id)
    {
        $adminData = $this->adminModel->find($id);
        if (!$adminData) {
            return redirect()->to(base_url('admin/admin'))->with('error', 'Data admin tidak ditemukan.');
        }
        $data = [
            'admin' => $adminData
        ];
        return view('admin/detail_admin', $data);
    }

    public function update(int $id)
    {
        $adminData = $this->adminModel->find($id);
        if (!$adminData) {
            return redirect()->to(base_url('admin/admin'))->with('error', 'Data admin tidak ditemukan.');
        }

        if (session()->get('role') !== 'Super Admin') {
            return redirect()->to(base_url('admin/admin'))->with('error', 'Akses ditolak.');
        }

        $usernameRule = 'required|alpha_dash|is_unique[admin.username,id_admin,' . $id . ']';

        $rules = [
            'username'      => $usernameRule,
            'nama_lengkap'  => 'required|min_length[3]',
            'tanggal_lahir' => 'required|valid_date',
            'jenis_kelamin' => 'required|in_list[Laki-laki,Perempuan]',
            'no_hp'         => 'required|numeric|min_length[10]|max_length[15]', // WAJIB 10-15 karakter
            'alamat'        => 'required'
        ];

        $messages = [
            'no_hp' => [
                'required'   => 'Nomor HP wajib diisi.',
                'numeric'    => 'Nomor HP harus berupa angka.',
                'min_length' => 'Nomor HP minimal harus 10 karakter.',
                'max_length' => 'Nomor HP maksimal 15 karakter.'
            ]
        ];

        if (!$this->validate($rules, $messages)) {
            return redirect()->back()->withInput()->with('error', $this->validator->getErrors());
        }

        $updateData = [
            'id_admin'      => $id,
            'username'      => $this->request->getPost('username'),
            'nama_lengkap'  => $this->request->getPost('nama_lengkap'),
            'tanggal_lahir' => $this->request->getPost('tanggal_lahir'),
            'jenis_kelamin' => $this->request->getPost('jenis_kelamin'),
            'nomor_hp'      => $this->request->getPost('no_hp'),
            'alamat'        => $this->request->getPost('alamat')
        ];

        if ($this->request->getPost('password')) {
            $updateData['password'] = password_hash($this->request->getPost('password'), PASSWORD_DEFAULT);
        }

        $this->adminModel->save($updateData);
        return redirect()->to(base_url('admin/admin'))->with('success', 'Data admin berhasil diperbarui.');
    }

    public function hapus(int $id)
    {
        if (session()->get('role') !== 'Super Admin') {
            return redirect()->to(base_url('admin/admin'))->with('error', 'Akses ditolak.');
        }

        $adminData = $this->adminModel->find($id);

        if ($adminData) {
            $this->adminModel->delete($id);
            return redirect()->to(base_url('admin/admin'))->with('success', 'Data admin berhasil dihapus.');
        }

        return redirect()->to(base_url('admin/admin'))->with('error', 'Data admin tidak ditemukan.');
    }
}
