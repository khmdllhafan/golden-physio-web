<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\AdminModel;

class LupaPassword extends BaseController
{
    public function lupaPassword()
    {
        return view('admin/lupa_password');
    }

    public function prosesLupaPassword()
    {
        $model = new AdminModel();

        if (!session()->has('reset_id')) {
            $username = $this->request->getPost('username');
            $nama_lengkap = $this->request->getPost('nama_lengkap');
            $tgl_lahir = $this->request->getPost('tanggal_lahir');

            $admin = $model->where('username', $username)
                ->where('nama_lengkap', $nama_lengkap)
                ->where('tanggal_lahir', $tgl_lahir)
                ->first();

            if ($admin) {
                session()->set('reset_id', $admin['id_admin']);
                return redirect()->to(base_url('admin/lupa_password'));
            } else {
                return redirect()->back()->with('error_registrasi', 'Data tidak ditemukan!');
            }
        } else {
            $id = session()->get('reset_id');
            $new_password = $this->request->getPost('password');
            $confirm_password = $this->request->getPost('confirm_password');

            if ($new_password !== $confirm_password) {
                return redirect()->back()->with('error_registrasi', 'Password dan Konfirmasi Password tidak cocok!');
            }

            $model->update($id, [
                'password' => password_hash($new_password, PASSWORD_DEFAULT)
            ]);

            session()->remove('reset_id');
            return redirect()->to('/admin/login')->with('success_registrasi', 'Password berhasil diubah!');
        }
    }
}
