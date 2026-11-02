<?php

namespace App\Controllers\User;

use App\Controllers\BaseController;
use App\Models\UserModel;

class LoginUser extends BaseController
{
    public function index()
    {
        return view('user/loginuser');
    }

    public function prosesLogin()
    {
        $session = session();
        $userModel = new UserModel();

        $username = trim($this->request->getPost('username'));
        $password = $this->request->getPost('password');

        if (empty($username) || empty($password)) {
            return redirect()->back()->withInput()->with('error_registrasi', 'Username atau password kosong.');
        }

        $user = $userModel->where('username', $username)->first();

        if (!$user) {
            return redirect()->back()->withInput()->with('error_registrasi', 'Username tidak ditemukan.');
        }

        $stored = $user['password'];
        $ok = false;

        if (password_verify($password, $stored)) {
            $ok = true;
        } elseif ($password === $stored) {
            $ok = true;

            $newHash = password_hash($password, PASSWORD_DEFAULT);
            $userModel->update($user['id_user'], ['password' => $newHash]);
        }

        if (!$ok) {
            return redirect()->back()->withInput()->with('error_registrasi', 'Password salah.');
        }

        $session->set([
            'id_user'      => $user['id_user'],
            'username'     => $user['username'],
            'nama_lengkap' => $user['nama_lengkap'],
            'logged_in'    => true,
        ]);

        return redirect()->to('/user/home');
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to(base_url('user/login'));
    }
}
