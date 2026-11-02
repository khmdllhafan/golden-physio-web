<?php

namespace App\Models;

use CodeIgniter\Model;

class TerapisModel extends Model
{
    protected $table = 'terapis';
    protected $primaryKey = 'id_terapis';
    protected $allowedFields = ['username', 'password', 'nama_lengkap', 'tanggal_lahir', 'jenis_kelamin', 'alamat', 'nomor_hp'];
}
