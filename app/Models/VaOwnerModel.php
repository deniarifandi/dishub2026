<?php

namespace App\Models;

use CodeIgniter\Model;

class VaOwnerModel extends Model
{
    protected $table = 'va_owner';
    protected $primaryKey = 'va_owner_id';
    protected $allowedFields = [
        'va_owner_anggotaid',
        'titpargrup_titparid',
        'va_owner_va',
        'va_owner_nama',
        'va_owner_berita_1',
        'va_owner_berita_2',
        'va_owner_berita_3',
        'va_owner_hp',
    ];
}
