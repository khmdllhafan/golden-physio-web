<?php

namespace App\Models;

use CodeIgniter\Model;

class AdminModel extends Model
{
    protected $table = 'admin';
    protected $primaryKey = 'id_admin';
    protected $allowedFields = ['username', 'password', 'nama_lengkap', 'tanggal_lahir', 'jenis_kelamin', 'alamat', 'nomor_hp'];
}
