<?php

namespace App\Controllers\Terapis;

use App\Controllers\BaseController;
use App\Models\TerapisModel;

class LoginTerapis extends BaseController
{
    public function index()
    {
        return view('terapis/login_terapis');
    }

    public function proseslogin()
    {
        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');

        $terapisModel = new TerapisModel();

        $terapis = $terapisModel->where('username', $username)->first();

        if ($terapis) {
            if (password_verify((string)$password, $terapis['password'])) {
                session()->set([
                    'id_terapis' => $terapis['id_terapis'],
                    'username'   => $terapis['username'],
                    'logged_in'  => true
                ]);
                return redirect()->to('/terapis/home');
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
        return redirect()->to('terapis/login');
    }
}
