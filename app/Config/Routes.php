<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// LOGIN & LOGOUT ADMIN
$routes->get('admin/login', 'Admin\LoginAdmin::index');
$routes->post('admin/proseslogin', 'Admin\LoginAdmin::proseslogin');
$routes->get('admin/logout', 'Admin\LoginAdmin::logout');

// LUPA PASSWORD Admin
$routes->get('admin/lupa_password', 'Admin\LupaPassword::lupaPassword');
$routes->post('admin/proses_lupapassword', 'Admin\LupaPassword::prosesLupaPassword');
$routes->post('admin/update_password_baru', 'Admin\LupaPassword::updatePasswordBaru');

// TAMBAH ADMIN
$routes->get('admin/tambah', 'Admin\TambahAdmin::index');
$routes->post('admin/simpan', 'Admin\TambahAdmin::simpan');

// DASHBOARD ADMIN
$routes->get('admin/home', 'Admin\Home::index');
$routes->post('admin/home/update_status', 'Admin\Home::update_status'); 
$routes->get('admin/jadwal_fisioterapi', 'Admin\JadwalFisioterapi::jadwal');
$routes->get('admin/pemesanan', 'Admin\PemesananMasuk::index');
$routes->post('admin/pemesanan/updateStatus', 'Admin\PemesananMasuk::updateStatus');
$routes->get('admin/pemesanan/setuju/(:num)', 'Admin\PemesananMasuk::setuju/$1');
$routes->get('admin/pemesanan/tolak/(:num)', 'Admin\PemesananMasuk::tolak/$1');
$routes->get('admin/pemesanan/proses/(:num)', 'Admin\PemesananMasuk::proses/$1');
$routes->get('admin/pemesanan/batalkan/(:num)', 'Admin\PemesananMasuk::batalkan/$1');
$routes->get('admin/pemesanan/selesai/(:num)', 'Admin\PemesananMasuk::selesai/$1');

$routes->get('admin/riwayat', 'Admin\RiwayatTerapi::index');
$routes->get('admin/riwayat/lihat/(:num)', 'Admin\RiwayatTerapi::lihat/$1');
$routes->get('admin/riwayat/tambah/(:num)', 'Admin\RiwayatTerapi::tambah/$1');
$routes->post('admin/riwayat/simpan', 'Admin\RiwayatTerapi::simpan');
$routes->get('admin/riwayat/edit/(:num)', 'Admin\RiwayatTerapi::edit/$1');
$routes->post('admin/riwayat/update/(:num)', 'Admin\RiwayatTerapi::update/$1');
$routes->get('admin/riwayat/delete/(:num)', 'Admin\RiwayatTerapi::delete/$1');
$routes->get('admin/riwayat/hapus/(:num)', 'Admin\RiwayatTerapi::delete/$1');

$routes->get('admin/pasien', 'Admin\DataPasien::index');
$routes->get('admin/pasien/tambah', 'Admin\DataPasien::tambah');
$routes->post('admin/pasien/simpan', 'Admin\DataPasien::simpan');
$routes->get('admin/pasien/hapus/(:num)', '\App\Controllers\Admin\DataPasien::hapus/$1');
$routes->get('admin/detailpasien/(:num)', 'Admin\DataPasien::detail/$1');
$routes->post('admin/detailpasien/update/(:num)', 'Admin\DataPasien::update/$1');

$routes->get('admin/terapis', 'Admin\DataTerapis::index');
$routes->get('admin/terapis/tambah', 'Admin\DataTerapis::tambah');
$routes->post('admin/terapis/simpan', 'Admin\DataTerapis::simpan');
$routes->get('admin/terapis/detail/(:num)', 'Admin\DataTerapis::detail/$1');
$routes->post('admin/terapis/update/(:num)', 'Admin\DataTerapis::update/$1');
$routes->post('admin/terapis/hapus/(:num)', 'Admin\DataTerapis::hapus/$1');

$routes->get('admin/admin', 'Admin\DataAdmin::index');
$routes->get('admin/admin/tambah', 'Admin\DataAdmin::tambah');
$routes->post('admin/admin/simpan', 'Admin\DataAdmin::simpan');
$routes->get('admin/admin/detail/(:num)', 'Admin\DataAdmin::detail/$1');
$routes->post('admin/admin/update/(:num)', 'Admin\DataAdmin::update/$1');
$routes->post('admin/admin/hapus/(:num)', 'Admin\DataAdmin::hapus/$1');

$routes->get('admin/laporan_pemesanan', 'Admin\LaporanPemesanan::index');
$routes->get('admin/laporan_pemesanan/cetakExcel', 'Admin\LaporanPemesanan::cetakExcel');

$routes->get('admin/profilsaya', 'Admin\ProfilSaya::index');
$routes->post('admin/update_profil', 'Admin\ProfilSaya::update_profil');

// LOGIN & LOGOUT USER
$routes->get('user/beranda', 'User\Beranda::index');
$routes->get('user/login', 'User\LoginUser::index');
$routes->post('user/login/proses', 'User\LoginUser::prosesLogin');
$routes->get('user/logout', 'User\LoginUser::logout');

// REGISTRASI USER
$routes->get('user/registrasi', 'User\RegistrasiUser::index');
$routes->post('user/simpan', 'User\RegistrasiUser::simpan');

// LUPA PASSWORD USER
$routes->get('user/lupapassword', 'User\LupaPassword::lupaPassword');
$routes->post('user/proses_lupapassword', 'User\LupaPassword::prosesLupaPassword');
$routes->post('user/update_password_baru', 'User\LupaPassword::updatePasswordBaru');

// DASHBOARD USER
$routes->get('user/home', 'User\Home::index');
$routes->get('user/jadwalfisioterapi', 'User\jadwalfisioterapi::index');
$routes->get('user/pemesananfisioterapi', 'User\PemesananFisioterapi::index');
$routes->post('user/pemesananfisioterapi/simpan', 'User\PemesananFisioterapi::simpan');
$routes->get('user/pemesananfisioterapi/cek_ketersediaan', 'User\PemesananFisioterapi::cek_ketersediaan');
$routes->get('user/riwayatterapi', 'User\RiwayatTerapi::index');
$routes->get('user/profilsaya', 'User\ProfilSaya::index');
$routes->post('user/update_profil', 'User\ProfilSaya::update_profil');


// LOGIN & LOGOUT TERAPIS
$routes->get('terapis/login', 'Terapis\LoginTerapis::index');
$routes->post('terapis/proseslogin', 'Terapis\LoginTerapis::proseslogin');
$routes->get('terapis/logout', 'Terapis\LoginTerapis::logout');

// LUPA PASSWORD Terapis
$routes->get('terapis/lupa_password', 'Terapis\LupaPassword::lupaPassword');
$routes->post('terapis/proses_lupapassword', 'Terapis\LupaPassword::prosesLupaPassword');
$routes->post('terapis/update_password_baru', 'Terapis\LupaPassword::updatePasswordBaru');

// DASHBOARD TERAPIS
$routes->get('terapis/home', 'Terapis\Home::index');
$routes->get('terapis/jadwal', 'Terapis\JadwalFisioterapi::jadwal');
$routes->get('terapis/jadwalfisioterapi', 'Terapis\JadwalFisioterapi::jadwal');

$routes->get('terapis/riwayat', 'Terapis\RiwayatTerapi::index');
$routes->get('terapis/riwayat/lihat/(:num)', 'Terapis\RiwayatTerapi::lihat/$1');
$routes->get('terapis/riwayat/tambah/(:num)', 'Terapis\RiwayatTerapi::tambah/$1');
$routes->post('terapis/riwayat/simpan', 'Terapis\RiwayatTerapi::simpan');
$routes->get('terapis/riwayat/edit/(:num)', 'Terapis\RiwayatTerapi::edit/$1');
$routes->post('terapis/riwayat/update/(:num)', 'Terapis\RiwayatTerapi::update/$1');
$routes->get('terapis/riwayat/delete/(:num)', 'Terapis\RiwayatTerapi::delete/$1');

$routes->get('terapis/profil', 'Terapis\ProfilSaya::index');
$routes->post('terapis/update_profil', 'Terapis\ProfilSaya::update_profil');
