<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;

class TambahAdmin extends BaseController
{
    public function index()
    {
        return view('admin/tambah_admin'); 
    }

    public function simpan()
    {
        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');
        $confirmPassword = $this->request->getPost('confirm_password');
        $nama_lengkap = $this->request->getPost('nama_lengkap');
        $tanggal_lahir = $this->request->getPost('tanggal_lahir');
        $jenis_kelamin = $this->request->getPost('jenis_kelamin');
        $alamat = $this->request->getPost('alamat');
        $nomor_hp = $this->request->getPost('nomor_hp');

        if ($password !== $confirmPassword) {
            return redirect()->back()->withInput()->with('error', 'Password dan konfirmasi password tidak cocok.');
        }

        $db = \Config\Database::connect();
        $builder = $db->table('admin');

        $existingAdmin = $builder->where('username', $username)->get()->getRow();
        if ($existingAdmin) {
            return redirect()->back()->withInput()->with('error', 'Username sudah digunakan. Silakan pilih username lain.');
        }

        $nomor_hp = trim($nomor_hp);

        if (!ctype_digit($nomor_hp)) {
            return redirect()->back()->withInput()->with(
                'error',
                'Nomor handphone hanya boleh berisi angka.'
            );
        }

        if (substr($nomor_hp, 0, 2) !== '08') {
            return redirect()->back()->withInput()->with(
                'error',
                'Nomor handphone harus diawali dengan 08.'
            );
        }

        $panjang = strlen($nomor_hp);
        if ($panjang < 10 || $panjang > 13) {
            return redirect()->back()->withInput()->with(
                'error',
                'Nomor handphone harus terdiri dari 10 sampai 13 digit.'
            );
        }

        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $builder->insert([
            'username'      => $username,
            'password'      => $hashedPassword,
            'nama_lengkap'  => $nama_lengkap,
            'tanggal_lahir' => $tanggal_lahir,
            'jenis_kelamin' => $jenis_kelamin,
            'alamat'        => $alamat,
            'nomor_hp'      => $nomor_hp
        ]);
        return redirect()->to(base_url('admin/tambah'))->with('success', 'Berhasil menambahkan Admin! Silakan login.');
    }
}
