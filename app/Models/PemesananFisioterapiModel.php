<?php

namespace App\Models;

use CodeIgniter\Model;

class PemesananFisioterapiModel extends Model
{
    protected $table            = 'pemesanan';
    protected $primaryKey       = 'id_pemesanan';
    protected $useTimestamps    = true;
    protected $createdField     = 'created_at';
    protected $updatedField     = 'updated_at';

    protected $allowedFields = [
        'id_user',
        'nama',
        'no_hp',
        'alamat',
        'tanggal_terapi',
        'jam_terapi',
        'keluhan',
        'riwayat_cedera',
        'id_terapis',
        'status',
        'catatan',
        'tarif'
    ];
}
