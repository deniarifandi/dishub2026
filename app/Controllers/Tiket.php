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

    //$builder = $this->db->table('va_owner');

    // $builder->->select('va_owner.va_owner_va, va_owner.va_owner_nama, COALESCE(SUM(transaksi.transaksi_nominal),0) AS total_nominal')
    // ->join('transaksi', 'transaksi.transaksi_va = va_owner.va_owner_va', 'left')
    // ->groupBy('va_owner.va_owner_va, va_owner.va_owner_nama');

   $subTransaksi = $this->db->table('transaksi')
    ->select('transaksi_va, SUM(transaksi_nominal) as total_transaksi')
    ->groupBy('transaksi_va');

$subTiket = $this->db->table('tiket')
    ->select('tiket_va, 
              SUM(tiket_motor) as total_motor,
              SUM(tiket_mobil) as total_mobil,
              SUM(tiket_truk) as total_truk,
              SUM(tiket_motor_in) as total_motor_in,
              SUM(tiket_mobil_in) as total_mobil_in,
              SUM(tiket_truk_in) as total_truk_in')
    ->groupBy('tiket_va');

$builder = $this->db->table('va_owner')
    ->select('va_owner.va_owner_va, 
              va_owner.va_owner_nama, 
              COALESCE(transaksi.total_transaksi, 0) as total_transaksi,
              COALESCE(tiket.total_motor, 0) as tiket_motor,
              COALESCE(tiket.total_mobil, 0) as tiket_mobil,
              COALESCE(tiket.total_truk, 0) as tiket_truk,
              COALESCE(tiket.total_motor_in, 0) as tiket_motor_in,
              COALESCE(tiket.total_mobil_in, 0) as tiket_mobil_in,
              COALESCE(tiket.total_truk_in, 0) as tiket_truk_in')
    ->join("({$subTransaksi->getCompiledSelect()}) transaksi", 'transaksi.transaksi_va = va_owner.va_owner_va', 'left')
    ->join("({$subTiket->getCompiledSelect()}) tiket", 'tiket.tiket_va = va_owner.va_owner_va', 'left');




    // ->orderBy('total_nominal','desc');

    $columns = ['va_owner_va', 'va_owner_nama', 'total_nominal']; // harus sesuai alias

    $dt = new DataTable($builder, $columns);
    $result = $dt->generate();

    return $this->response->setJSON($result);
    }

   

}
