<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\AdminModel;

class LoginAdmin extends BaseController
{
    public function index()
    {
        return view('admin/login_admin');
    }

    public function proseslogin()
    {
        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');

        $adminModel = new AdminModel();
        $admin = $adminModel->where('username', $username)->first();

        if ($admin) {
            if (password_verify($password, $admin['password'])) {
                session()->set([
                    'id_admin'  => $admin['id_admin'],
                    'username'  => $admin['username'],
                    'role'      => $admin['role'],
                    'logged_in' => true
                ]);

                return redirect()->to('/admin/home');
            } else {
                return redirect()->back()->with('error_registrasi', 'Password salah');
            }
        } else {
            return redirect()->back()->with('error_registrasi', 'Username tidak ditemukan');
        }
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to(base_url('admin/login'));
    }
}
