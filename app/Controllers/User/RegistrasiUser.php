<?php

namespace App\Controllers\User;

use App\Controllers\BaseController;

class RegistrasiUser extends BaseController
{
    public function index()
    {
        return view('user/registrasi');
    }

    public function simpan()
    {
        $username        = $this->request->getPost('username');
        $password        = $this->request->getPost('password');
        $confirmPassword = $this->request->getPost('confirm_password');
        $nama_lengkap    = $this->request->getPost('nama_lengkap');
        $tanggal_lahir   = $this->request->getPost('tanggal_lahir');
        $jenis_kelamin   = $this->request->getPost('jenis_kelamin');
        $alamat          = $this->request->getPost('alamat');
        $no_hp           = $this->request->getPost('no_hp');

        if (strlen($password) < 8) {
            return redirect()->back()->withInput()->with('error_registrasi', 'Password minimal harus 8 karakter.');
        }

        if ($password !== $confirmPassword) {
            return redirect()->back()->withInput()->with('error_registrasi', 'Password dan konfirmasi password tidak cocok.');
        }

        if (!preg_match('/^08[0-9]{8,13}$/', $no_hp)) {
            return redirect()->back()->withInput()->with('error_registrasi', 'Nomor HP harus diawali 08, hanya angka, dan panjang 10-15 digit.');
        }

        $db      = \Config\Database::connect();
        $builder = $db->table('user');

        $existingUser = $builder->where('username', $username)->get()->getRow();
        if ($existingUser) {
            return redirect()->back()->withInput()->with('error_registrasi', 'Username sudah digunakan.');
        }

        $cekNomorHP = $builder->where('no_hp', $no_hp)->get()->getRow();
        if ($cekNomorHP) {
            return redirect()->back()->withInput()->with('error_registrasi', 'Nomor handphone sudah terdaftar.');
        }

        $data = [
            'username'      => $username,
            'password'      => password_hash($password, PASSWORD_DEFAULT),
            'nama_lengkap'  => $nama_lengkap,
            'tanggal_lahir' => $tanggal_lahir,
            'jenis_kelamin' => $jenis_kelamin,
            'alamat'        => $alamat,
            'no_hp'         => $no_hp,
            'created_at'    => date('Y-m-d H:i:s')
        ];

        if ($builder->insert($data)) {
            return redirect()->to(base_url('user/login'))->with('success_registrasi', 'Registrasi akun Anda berhasil!');
        } else {
            return redirect()->back()->withInput()->with('error_registrasi', 'Terjadi kesalahan saat menyimpan data.');
        }
    }
}
