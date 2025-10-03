<?php

namespace App\Models;
use CodeIgniter\Model;

class DishubAnggotaModel extends Model
{
    protected $table = 'dishub_anggota';
    protected $primaryKey = 'id';
    protected $allowedFields = ['nama'];
    protected $keepHistory   = false;
}