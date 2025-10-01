<?php 

namespace App\Controllers;

use App\Libraries\DataTable;
use DB;


class Tiket extends BaseController
{
    public $db;

    public function __construct()
    {
      $this->db = \Config\Database::connect();
    }

       public function index()
    {
       
        return view('tiket/index');
    }

    public function data(){

    $builder = $this->db->table('va_owner')
    ->select('va_owner.va_owner_va, va_owner.va_owner_nama, COALESCE(SUM(transaksi.transaksi_nominal),0) AS total_nominal')
    ->join('transaksi', 'transaksi.transaksi_va = va_owner.va_owner_va', 'left')
    ->groupBy('va_owner.va_owner_va, va_owner.va_owner_nama');

    $columns = ['va_owner_va', 'va_owner_name', 'total_nominal']; // harus sesuai alias

    $dt = new DataTable($builder, $columns);
    $result = $dt->generate();

    return $this->response->setJSON($result);
    }

   

}
