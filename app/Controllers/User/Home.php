<?php

namespace App\Controllers\User;

use App\Controllers\BaseController;

class Home extends BaseController
{
    public function index()
    {
        date_default_timezone_set("Asia/Jakarta");

        $jam = date("H");

        if ($jam >= 4 && $jam < 10) {
            $salam = "Selamat Pagi";
        } elseif ($jam >= 10 && $jam < 15) {
            $salam = "Selamat Siang";
        } elseif ($jam >= 15 && $jam < 18) {
            $salam = "Selamat Sore";
        } else {
            $salam = "Selamat Malam";
        }

        return view('user/home', ['salam' => $salam]);
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/User')->with('success', 'Berhasil Logout');
    }
}
