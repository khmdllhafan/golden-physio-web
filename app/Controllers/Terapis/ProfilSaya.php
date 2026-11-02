<?php

namespace App\Controllers\Terapis;

use App\Controllers\BaseController;
use App\Models\TerapisModel;

class ProfilSaya extends BaseController
{
    public function index()
    {
        $session = session();
        $terapisId = $session->get('id_terapis');

        if (!$terapisId) {
            return redirect()->to(base_url('terapis/login'))->with('error', 'Silakan login terlebih dahulu.');
        }

        $model = new TerapisModel();
        $data['terapis'] = $model->find($terapisId);

        return view('terapis/profil_saya', $data);
    }

    public function update_profil()
    {
        $session = session();
        $terapisId = $session->get('id_terapis');

        if (!$terapisId) {
            return redirect()->to(base_url('terapis/login'))->with('error', 'Silakan login terlebih dahulu.');
        }

        $model = new TerapisModel();
        $terapisLama = $model->find($terapisId);

        if (!$terapisLama) {
            return redirect()->back()->with('error', 'Data terapis tidak ditemukan.');
        }

        $rules = [
            'username' => "required|alpha_dash|is_unique[terapis.username,id_terapis,{$terapisId}]",
            'nomor_hp' => 'required|regex_match[/^08[0-9]{8,11}$/]',
            'alamat'   => 'required',
        ];

        $passwordBaru = $this->request->getPost('password');
        if (!empty($passwordBaru)) {
            $rules['password']         = 'min_length[8]';
            $rules['confirm_password'] = 'matches[password]';
        }

        if (!$this->validate($rules)) {
            $errorMsg = "Periksa kembali input Anda.";
            if ($this->validator->hasError('username')) {
                $errorMsg = "Username sudah digunakan atau mengandung karakter terlarang.";
            } elseif ($this->validator->hasError('nomor_hp')) {
                $errorMsg = "Nomor HP harus diawali 08 dan berjumlah 10-13 digit.";
            } elseif ($this->validator->hasError('password')) {
                $errorMsg = "Password minimal harus 8 karakter.";
            } elseif ($this->validator->hasError('confirm_password')) {
                $errorMsg = "Konfirmasi password tidak cocok.";
            }

            return redirect()->back()->withInput()->with('error', $errorMsg);
        }

        $dataUpdate = [
            'username' => $this->request->getPost('username'),
            'nomor_hp' => $this->request->getPost('nomor_hp'),
            'alamat'   => $this->request->getPost('alamat'),
        ];

        if (!empty($passwordBaru)) {
            if (password_verify($passwordBaru, $terapisLama['password'])) {
                return redirect()->back()->withInput()->with('error', 'Password baru tidak boleh sama dengan password lama!');
            }
            $dataUpdate['password'] = password_hash($passwordBaru, PASSWORD_DEFAULT);
        }

        if ($model->update($terapisId, $dataUpdate)) {
            $session->set([
                'username' => $dataUpdate['username']
            ]);

            return redirect()->to(base_url('terapis/profil'))->with('success', 'Profil berhasil diperbarui!');
        } else {
            return redirect()->back()->withInput()->with('error', 'Gagal memperbarui profil atau tidak ada perubahan data.');
        }
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to(base_url('terapis/login'))->with('success', 'Berhasil Logout');
    }
}
