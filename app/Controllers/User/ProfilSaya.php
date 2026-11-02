<?php

namespace App\Controllers\User;

use App\Controllers\BaseController;
use App\Models\UserModel;

class ProfilSaya extends BaseController
{
    public function index()
    {
        $session = session();
        $userId = $session->get('id_user');

        if (!$userId) {
            return redirect()->to(base_url('user/login'));
        }

        $model = new UserModel();
        $data['user'] = $model->find($userId);

        return view('user/profilsaya', $data);
    }

    public function update_profil()
    {
        $userId = session()->get('id_user');
        $model = new UserModel();

        $rules = [
            'username' => [
                'rules'  => "required|is_unique[user.username,id_user,$userId]",
                'errors' => [
                    'required'  => 'Username wajib diisi.',
                    'is_unique' => 'Username ini sudah digunakan orang lain.'
                ]
            ],
            'no_hp' => [
                'rules'  => "required|regex_match[/^08[0-9]{8,11}$/]|is_unique[user.no_hp,id_user,$userId]",
                'errors' => [
                    'required'    => 'Nomor HP wajib diisi.',
                    'regex_match' => 'Format Nomor HP tidak valid.',
                    'is_unique'   => 'Nomor HP ini sudah terdaftar oleh pengguna lain.'
                ]
            ],
            'alamat' => [
                'rules'  => 'required',
                'errors' => ['required' => 'Alamat wajib diisi.']
            ]
        ];

        $passwordBaru = $this->request->getPost('password');
        if (!empty($passwordBaru)) {
            $rules['password'] = [
                'rules'  => 'min_length[8]',
                'errors' => ['min_length' => 'Password baru minimal harus 8 karakter.']
            ];
            $rules['confirm_password'] = [
                'rules'  => 'matches[password]',
                'errors' => ['matches' => 'Konfirmasi password tidak cocok dengan password baru.']
            ];
        }

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('validation', $this->validator);
        }

        $dataUpdate = [
            'username' => $this->request->getPost('username'),
            'no_hp'    => $this->request->getPost('no_hp'),
            'alamat'   => $this->request->getPost('alamat'),
        ];

        if (!empty($passwordBaru)) {
            $dataUpdate['password'] = password_hash($passwordBaru, PASSWORD_DEFAULT);
        }

        try {
            if ($model->update($userId, $dataUpdate)) {
                return redirect()->to(base_url('user/profilsaya'))->with('success', 'Profil berhasil diperbarui!');
            } else {
                return redirect()->back()->with('error', 'Gagal memperbarui profil.');
            }
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan sistem.');
        }
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to(base_url('user/login'))->with('success', 'Berhasil Logout');
    }
}
